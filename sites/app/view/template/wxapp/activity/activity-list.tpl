<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
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
<{if $showSecondLink == 1}>
    <{include file="../common-second-menu.tpl"}>
<{/if}>
<{include file="../../manage/common-kind-editor.tpl"}>
<div id="content-con">
    <div  id="mainContent" >
        <!--<div class="page-header">
            <a href="/wxapp/community/inCharge" class="btn btn-green btn-sm"><i class="icon-plus bigger-80"></i> 入驻费用配置</a>
            <button class="btn btn-green btn-xs" style="padding-top: 5px;padding-bottom: 5px;" data-toggle="modal" data-target="#topModal"><i class="icon-plus bigger-80"></i>入驻页顶部图片</button>
            <button class="btn btn-green btn-xs" style="padding-top: 5px;padding-bottom: 5px;" data-toggle="modal" data-target="#enterModal"><i class="icon-plus bigger-80"></i>入驻协议</button>
            <div class="watermrk-show">
                <span class="label-name">店铺订单抽成比例(%)：</span>
                <div class="watermark-box">
                    <div class="input-group">
                        <input type="text" style="width: 60px" class="form-control" id="default-maid" value="<{$maid}>">
                        <span class="input-group-btn">
                            <span class="btn btn-blue" id="save-default-maid">确认修改</span>
                            <span>（微信在线支付提现会收取0.6%手续费）</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>--><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>申请人姓名</th>
                            <th>联系电话</th>
                            <th>申请内容</th>
                            <th>申请状态</th>
                            <th>申请时间</th>
                            <th>处理备注</th>
                            <th>处理时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['aap_id']}>">                                
                                <td><{$val['aap_name']}></td>
                                <td><{$val['aap_mobile']}></td>
                                <td><{$val['aap_content']}></td>
                                <td><{$status[$val['aap_status']]}></td>
                                <td><{if $val['aap_create_time'] > 0}><{date('Y-m-d H:i',$val['aap_create_time'])}><{/if}></td>
                                <td><{$val['aap_handle_note']}></td>
                                <td><{if $val['aap_handle_time'] > 0}><{date('Y-m-d H:i',$val['aap_handle_time'])}><{/if}></td>
                            	<td>
                                    <{if $val['aap_status'] eq 0}>
                                    <a class="confirm-handle" href="#" data-toggle="modal" data-target="#myModal"  data-id="<{$val['aap_id']}>">处理</a>
                                    <{/if}>
                                </td>
                            </tr>
                            <{/foreach}>
                        <tr><td colspan="8"><{$paginator}></td></tr>
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
                    申请处理
                </h4>
            </div>
            <div class="modal-body" style="padding: 15px!important;">
                <!--<div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">审核状态：</label>
                    <div class="col-sm-10">
                        <select name="status" id="status" class="form-control">
                            <option value="1">通过</option>
                            <option value="2">拒绝</option>
                        </select>
                    </div>
                </div>-->
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">处理备注：</label>
                    <div class="col-sm-10">
                        <textarea id="note" class="form-control" rows="5" placeholder="请填写处理备注信息" style="height:auto!important"></textarea>
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

<!-- 模态框（Modal） -->
<div class="modal fade" id="enterModal" tabindex="-1" role="dialog" aria-labelledby="enterModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="enterModalLabel">
                    入驻协议
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-12" style="padding: 30px">
                        <textarea class="form-control" style="width:100%;height:400px;visibility:hidden;" id = "protocol" name="protocol" placeholder="入驻协议"  rows="20" style=" text-align: left; resize:vertical;" >
                              <{if $protocol}><{$protocol}><{/if}>
                        </textarea>
                        <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                        <input type="hidden" name="ke_textarea_name" value="protocol" />
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="conform-protocol">
                    保存
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!-- 模态框（Modal） -->
<div class="modal fade" id="topModal" tabindex="-1" role="dialog" aria-labelledby="topModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    入驻页顶部图片
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-12">
                        <!--<div style="text-align: center;padding: 20px 0">
                            <img onclick="toUpload(this)" data-limit="1" style="width: 80%" data-width="750" data-height="200" data-dom-id="upload-cover" id="upload-cover"  src="<{if $image}><{$image}><{else}>/public/wxapp/community/images/image_750_200.png<{/if}>"  width="750px" height="200px" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="top-image"  class="avatar-field bg-img" name="top-image" value="<{if $image}><{$image}><{/if}>"/>
                        </div>-->
                        <div class="cropper-box" data-width="750" data-height="200" style="padding: 20px 0">
                            <img id="default-cover" src="<{if $image}><{$image}><{else}>/public/wxapp/community/images/image_750_200.png<{/if}>" width="80%"style="display:block;margin:auto" alt="轮播图">
                            <input type="hidden" class="avatar-field bg-img" name="top-image" id="top-image" value="<{if $image}><{$image}><{else}>/public/wxapp/community/images/image_750_200.png<{/if}>"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-save">
                    保存
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<script type="text/javascript" charset="utf-8" src="/public/plugin/layer/layer.js"></script>
<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript">
    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
    });

    $('#confirm-save').on('click',function(){
        var image = $('#top-image').val();
        var data = {
            image: image
        };

        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/community/saveTopImage',
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

    });

    // 提交入驻协议
    $("#conform-protocol").click(function(){
        var protocol = $('#protocol').val();
        var data = {
            'protocol'     : protocol
        };
        var index = layer.load(2,
            {
                shade: [0.1,'#333'],
                time: 10*1000
            }
        );
        $.ajax({
            type: 'post',
            url: "/wxapp/community/saveProtocol" ,
            data: data,
            dataType: 'json',
            success: function(json_ret){
                layer.close(index);
                layer.msg(json_ret.em);
                if(json_ret.ec == 200){
                    $('#myModal').modal('hide');
                }
            }
        });
    });

    $('#confirm-handle').on('click',function(){
        var hid = $('#hid_id').val();
        var note = $('#note').val();
        var status = $('#status').val();
        var data = {
            id : hid,
            note : note,
           // status: status
        };
        console.log(JSON.stringify(data));
        if(hid){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/activity/handleApply',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
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
