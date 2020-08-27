<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
    /*页面样式*/
    .flex-wrap { display: -webkit-flex; display: -ms-flexbox; display: -webkit-box; display: -ms-box; display: box; display: flex; -webkit-box-pack: center; -ms-flex-pack: center; -webkit-justify-content: center; justify-content: center; -webkit-box-align: center; -ms-flex-align: center; -webkit-align-items: center; align-items: center; }
    .flex-con { -webkit-box-flex: 1; -ms-box-flex: 1; -webkit-flex: 1; -ms-flex: 1; box-flex: 1; flex: 1; }
    .authorize-tip { overflow: hidden; margin-top: 10px; margin-bottom: 20px; }
    .authorize-tip { background-color: #F4F5F9; padding: 15px 20px; }
    .authorize-tip .shop-logo{width: 50px;height: 50px;border-radius: 50%;margin-right: 10px;border-radius: 50%;overflow: hidden;}
    .authorize-tip .shop-logo img{height: 100%;width: 100%;}
    .authorize-tip h4 { font-size: 16px; margin: 0; margin-bottom: 6px; }
    .authorize-tip .state { margin: 0; font-size: 13px; color: #999; }
    .authorize-tip .state.green { color: #48C23D; }
    .authorize-tip .btn { margin-left: 10px; }
</style>
<div id="content-con">
    <{if $appletCfg['ac_type'] neq 15}>
    <div class="authorize-tip flex-wrap">
        <div class="shop-logo">
            <img src="/public/wxapp/setup/images/yuyue_icon.png" alt="logo">
        </div>
        <div class="flex-con">
            <h4>预约咨询功能</h4>
            <p class="state" style="color: #999;">
                <span>简化版的预约咨询功能,无需开通支付 </span>
                <span>如果需要用户付费预约,请使用<a href="/wxapp/appointment/template" target="_blank">付费预约功能</a></span>
            </p>
        </div>
        <div>
            <!--
            <a href="/wxapp/currency/payStyle" class="btn btn-sm btn-green"><i class="icon-plus bigger-80"></i> 配置微信支付</a>
            -->
        </div>
    </div>
    <{/if}>
    <div  id="mainContent" >
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>姓名</th>
                            <th>电话</th>
                            <{if $appCfg['ac_type'] == 4}>
                            <th>预约人数</th>
                            <{else}>
                            <th>预约内容</th>
                            <{/if}>
                            <th>备注</th>
                            <th>预约时间</th>
                            <th>处理情况</th>
                            <th>处理备注</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['ai_id']}>">
                                <td><{$val['ai_name']}></td>
                                <td><{$val['ai_mobile']}></td>
                                <{if $appCfg['ac_type'] == 4}>
                                <td><{$val['ai_population']}></td>
                                <{else}>
                                <td><{$val['ai_content']}></td>
                                <{/if}>
                                <td><{$val['ai_extra']}></td>
                                <{if $appCfg['ac_type'] == 4}>
                                <td><{date('Y-m-d H:i',$val['ai_time'])}></td>
                                <{else}>
                                <td><{date('Y-m-d H:i',$val['ai_create_time'])}></td>
                                <{/if}>
                                <{if $val['ai_processed'] eq 1}>
                                <td style="color: green">已处理</td>
                                <{else}>
                                <td style="color:#333;">未处理</td>
                                <{/if}>
                                <td><{$val['ai_remark']}></td>
                                <td class="jg-line-color">
                                    <{if $val['ai_processed'] eq 0}>
                                    <a class="confirm-handle" href="#" data-toggle="modal" data-target="#myModal"  data-id="<{$val['ai_id']}>">处理</a> - 
                                    <{/if}>
                                    <a class="confirm-delete" href="#" data-id="<{$val['ai_id']}>" style="color:#f00;">删除</a>
                                </td>
                            </tr>
                            <{/foreach}>
                        <{if $pageHtml}>
                            <tr><td colspan="8"><{$pageHtml}></td></tr>
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
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    预约处理
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">处理备注：</label>
                    <div class="col-sm-10">
                        <textarea id="market" class="form-control" rows="8" placeholder="请填写处理备注信息" style="height:auto!important"></textarea>
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
<script>
    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
    });

    $('#confirm-handle').on('click',function(){
        var hid = $('#hid_id').val();
        var market = $('#market').val();
        var data = {
            id : hid,
            market : market
        };
        if(hid){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/currency/handleAppointment',
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
    $('.confirm-delete').on('click',function () {
        var id = $(this).data('id');
        var data = {
            id : id,
        };
        layer.confirm('确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/currency/deleteAppointment',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.msg(ret.em,{
                        time: 2000, //2s后自动关闭
                    },function(){
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        });
    });

</script>