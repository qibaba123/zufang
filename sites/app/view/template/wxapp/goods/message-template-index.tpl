<link rel="stylesheet" href="/public/wxapp/mall/css/deliveryTemplate.css">
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

    .freight-head{
        margin: 0 0 12px;
        border-bottom: 1px dotted #e2e2e2;
        padding-bottom: 16px;
        padding-top: 7px;
    }
    </style>
<div class="freight-list">
    <div class="alert alert-block alert-success">
        <ol>
            <li>
                说明：本功能为用户下单时用户填写，您可根据经营需要选择用户需填信息项。<{$menuType}>
            </li>
        </ol>
    </div>
    <div class="freight-head" >
        <a href="/wxapp/goods/addMessageList" class="btn btn-green btn-xs">新建留言模版</a>
        <{if $appletCfg['ac_type'] != 34}>
        <{if $menuType != "toutiao" || $appletCfg['ac_type'] != 18}>
        <span style="font-size: 12px;color: red;">(在商品列表中添加商品时可选择该处设置的留言模板)</span>
        <{/if}>
        <{else}>
        <a href="#" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal">选择留言模版</a>
        <{/if}>

    </div>

    <div class="freight-content" style="display: block;">
        <div class="freight-template-list-wrap js-freight-template-list-wrap">
            <ul>
                <{foreach $list as $val}>
                <li class="freight-template-item">
                    <h4 class="freight-template-title js-freight-extend-toggle">
                        <b><{$val['amt_name']}></b>
                        <div class="pull-right">
                            <span class="c-gray">最后编辑时间<{date('Y-m-d H:i:s',$val['amt_update_time'])}></span>&nbsp;&nbsp;
                            <a href="/wxapp/goods/addMessageList?id=<{$val['amt_id']}>" class="js-freight-edit">修改</a> -
                            <a href="javascript:;" class="js-freight-delete" onclick="deleteTemplate(<{$val['amt_id']}>)" style="color:#f00;">删除</a>
                        </div>
                    </h4>

                    <table class="freight-template-table">
                        <tbody>
                        <{foreach json_decode($val['amt_data'], true) as $v}>
                            <tr>
                                <td><{$v['name']}></td>
                                <td><{if $v['require']=='true'}>必填<{else}>非必填<{/if}></td>
                            </tr>
                        <{/foreach}>
                        </tbody>
                    </table>
                </li>
                <{/foreach}>
            </ul>
        </div>
        <{$paginator}>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    选择留言模板
                </h4>
            </div>
            <div class="modal-body" style="margin-left: 20px">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">代我买：</label>
                    <div class="col-sm-8">
                        <select name="buy" id="buy" class="form-control" >
                            <option value="0">无</option>
                            <{foreach $list as $val}>
                            <option value="<{$val['amt_id']}>" <{if $buyMessage == $val['amt_id']}>selected<{/if}>><{$val['amt_name']}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">代我取：</label>
                    <div class="col-sm-8">
                        <select name="receive" id="receive" class="form-control" >
                            <option value="0">无</option>
                            <{foreach $list as $val}>
                        <option value="<{$val['amt_id']}>" <{if $receiveMessage == $val['amt_id']}>selected<{/if}>><{$val['amt_name']}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">代我送：</label>
                    <div class="col-sm-8">
                        <select name="send" id="send" class="form-control" >
                            <option value="0">无</option>
                            <{foreach $list as $val}>
                        <option value="<{$val['amt_id']}>" <{if $sendMessage == $val['amt_id']}>selected<{/if}>><{$val['amt_name']}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-message" onclick="saveLegworkMessage()">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>


<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/fuelux/fuelux.wizard.min.js"></script>
<script type="text/javascript" src="/public/plugin/sortable/jquery-ui.min.js"></script>

<script>
    function deleteTemplate(id){
        layer.confirm('你确定要删除该留言模板吗，删除后会影响选择该留言模板的商品的购买', {
            title: '确认删除',
            btn: ['确定','取消']    //按钮
        }, function(){
            if(id){
                var index = layer.load(1, {
                    shade: [0.1,'#fff'] //0.1透明度的白色背景
                });
                $.ajax({
                    'type'   : 'post',
                    'url'   : '/wxapp/goods/deleteMessageTemplate',
                    'data'  : {id:id},
                    'dataType'  : 'json',
                    'success'   : function(ret){
                        layer.close(index);
                        window.location.reload();
                    }
                });
            }
        },function (){

        });
    }

    function saveLegworkMessage() {
        $('#confirm-message').attr('disabled','disabled');
        var buyMessage = $('#buy').val();
        var sendMessage = $('#send').val();
        var receiveMessage = $('#receive').val();

        var data = {
          buyMessage : buyMessage,
          sendMessage : sendMessage,
          receiveMessage : receiveMessage,
        };

        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/goods/saveLegworkMessage',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }else{
                    $('#confirm-message').removeAttr('disabled');
                }
            }
        });
    }



</script>
