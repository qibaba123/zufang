<script>
    //console.log(<{$siddd}>);
</script>
<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<{include file="../common-second-menu-new.tpl"}>
<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <a class="add-cost btn btn-green btn-xs" href="#" data-toggle="modal" data-target="#myModal"  data-id="" data-weight="" data-name=""><i class="icon-plus bigger-80"></i> 添加打印机</a>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                	<!--table-striped--> 
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>打印机编号</th>
                            <th>打印机名称</th>
                            <th>打印机状态</th>
                            <th>待打印数量</th>
                            <th>流量卡号</th>
                            <th>是否自动打印</th>
                            <{if $showCategory == 1}>
                            <th>商品分类</th>
                            <{/if}>
                            <!--
                            <{if $esTrade == 1}>
                            <th>是否打印商家订单</th>
                            <{/if}>
                            -->
                            <th>添加时间</th>
                            <{if $region !=1 && $show_printer_owner==1}>
                            <th>添加人</th>
                            <{/if}>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['afl_id']}>">
                                <td><{$val['afl_sn']}></td>
                                <td><{$val['afl_name']}></td>
                                <td><{$val['status']}></td>
                                <td><{$val['orderNum']}><{if $val['orderNum'] >0 }><a style="margin-left: 8px" href="javascript:;" class="btn btn-danger btn-xs" data-sn="<{$val['afl_sn']}>" data-type="waiting" data-msg="确定清除待打印订单吗？" data-id="<{$val['afl_id']}>" onclick="printOperate(this)">清空</a><{/if}></td>
                                <td><{$val['afl_phonenum']}></td>
                                <td><{if $val['afl_automatic'] gt 0 }><span style="color:#333">是</span><a class="btn btn-danger btn-xs" style="margin-left: 5px" href="#" data-sn="<{$val['afl_sn']}>" data-type="automatic" data-msg="确定要关闭当前打印机的自动打印吗？" onclick="printOperate(this)">关闭</a><{else}><span style="color: red">否</span><a class="btn btn-blue btn-xs" style="margin-left: 5px" href="#" data-sn="<{$val['afl_sn']}>" data-type="automatic" data-id="<{$val['afl_id']}>" data-msg="确定要开启当前打印机的自动打印吗？" onclick="printOperate(this)">开启</a><{/if}></td>
                                <{if $showCategory}>
                                <td><{if isset($firstCategory[$val['afl_kind1']])}><{$firstCategory[$val['afl_kind1']]['name']}><{else}>全部<{/if}></td>
                                <{/if}>
                                <!--
                                <{if $esTrade == 1}>
                                <td><{if $val['afl_es_trade'] gt 0 }><span style="color:#333">是</span><a class="btn btn-danger btn-xs" style="margin-left: 5px" href="#" data-sn="<{$val['afl_sn']}>" data-type="estrade" data-msg="确定要关闭当前打印机打印商家订单吗？关闭后入驻商家的订单将不会被打印" onclick="printOperate(this)">关闭</a><{else}><span style="color: red">否</span><a class="btn btn-blue btn-xs" style="margin-left: 5px" href="#" data-sn="<{$val['afl_sn']}>" data-type="estrade" data-msg="确定要开启当前打印机打印商家订单吗？开启后将自动打印入驻商家的订单" data-id="<{$val['afl_id']}>" onclick="printOperate(this)">开启</a><{/if}></td>
                                <{/if}>
                                -->
                                <td><{date('Y-m-d H:i:s', $val['afl_create_time'])}></td>
                                <{if $region !=1 && $show_printer_owner==1}>
                                    <{if $val.afl_create_by==0}>
                                    <td title='区域合伙人添加'>平台</td>
                                    <{else}>
                                    <td title='区域合伙人添加'><{$val.m_nickname}></td>
                                    <{/if}>
                                <{/if}>
                                <td>
                                    <a class="confirm-handle btn btn-green btn-xs" href="#" data-toggle="modal" data-target="#myModal"  data-id="<{$val['afl_id']}>" data-name="<{$val['afl_name']}>" data-sn="<{$val['afl_sn']}>" data-phonenum="<{$val['afl_phonenum']}>" data-key="<{$val['afl_key']}>" data-estrade="<{$val['afl_es_trade']}>" data-kind1="<{$val['afl_kind1']}>">编辑</a>
                                    <a class="confirm-handle btn btn-green btn-xs" href="#" data-sn="<{$val['afl_sn']}>" data-type="test" data-msg="确定发送测试订单到该打印机吗？" onclick="printOperate(this)" data-id="<{$val['afl_id']}>" >测试</a>
                                    <a class="btn btn-danger btn-xs" href="#" data-sn="<{$val['afl_sn']}>" data-type="delete" data-msg="确定删除当前打印机吗？" onclick="printOperate(this)" data-id="<{$val['afl_id']}>" style="color:#f00;">删除</a>
                                </td>
                            </tr>
                            <{/foreach}>
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
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    添加打印机
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: center">打印机编号（必填）</label>
                    <div class="col-sm-7">
                        <input id="print-sn" class="form-control" placeholder="请填写打印机编号" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: center">打印机识别码（必填）</label>
                    <div class="col-sm-7">
                        <input id="print-key" class="form-control" placeholder="请填写打印机识别码" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: center">打印机备注名称</label>
                    <div class="col-sm-7">
                        <input id="print-name" class="form-control" placeholder="请填写打印机备注名称" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: center">流量卡号</label>
                    <div class="col-sm-7">
                        <input id="print-phonenum" class="form-control" placeholder="请填写流量卡号" style="height:auto!important"/>
                    </div>
                </div>

                <div class="form-group row" <{if $showCategory == 0}>style="display:none"<{/if}>>
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: center">商品分类</label>
                    <div class="col-sm-7">
                        <select name="print-kind1" id="print-kind1" class="form-control">
                            <option value="0">全部</option>
                            <{foreach $firstCategory as $key => $val}>
                            <option value="<{$key}>"><{$val['name']}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
                <!--
                <{if $esTrade == 1}>
                <div class="form-group row">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: center">同步打印商家订单</label>
                    <div class="col-sm-7">
                        <div class="radio-box">
                            <span data-val="1">
                                <input type="radio" name="esTrade" value="1" id="esTrade1" >
                                <label for="esTrade1">是</label>
                            </span>
                            <span data-val="0">
                                <input type="radio" name="esTrade" value="0" id="esTrade0" checked>
                                <label for="esTrade0">否</label>
                            </span>
                        </div>
                        <span style="font-size: 12px;color: #777">启用时，当入驻商家有订单付款时，此打印机会同步打印</span>
                    </div>
                </div>
                <{/if}>
                -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-save">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>
    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#print-sn').val($(this).data('sn'));
        $('#print-name').val($(this).data('name'));
        $('#print-key').val($(this).data('key'));
        $('#print-phonenum').val($(this).data('phonenum'));
        $('#print-kind1').val($(this).data('kind1'));

    });
    $('#confirm-save').on('click',function(){
        var id   = $('#hid_id').val();
        var sn   = $('#print-sn').val();
        var name = $('#print-name').val();
        var key  = $('#print-key').val();
        var phonenum = $('#print-phonenum').val();
        var kind1 = $('#print-kind1').val();
        var data = {
            id     : id,
            sn     : sn,
            name   : name,
            key    : key,
            phonenum   : phonenum,
            kind1  : kind1
        };
        if(data){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/print/savePrintNew',
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
    // 操作打印机
    function printOperate(ele) {
        var sn = $(ele).data('sn');
        var id = $(ele).data('id');
        var type = $(ele).data('type');
        var msg = $(ele).data('msg');
        if(sn){
            layer.confirm(msg, {
                title: '提示',
                btn: ['确定','取消']    //按钮
            }, function(){
                var loading = layer.load(2);
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/print/printOperate',
                    'data'  : { sn:sn,type:type,id:id},
                    'dataType' : 'json',
                    success : function(ret){
                        layer.close(loading);
                        layer.msg(ret.em);
                        if(ret.ec == 200){
                            //window.location.reload();
                        }
                    }
                });
            }, function() {

            });
        }
    }

</script>