<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/css/member-list.css">
<link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<!--<link rel="stylesheet" href="/public/manage/css/wechatArticle.css">-->
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-select.css">
<style>
    .inline-div{
        line-height: 34px;
        padding-right: 0;
        padding-left: 0;
    }
    .multi-choose-box{
        margin-bottom: 5px;
        margin-top: 5px;
    }
    .ui-popover{
        width: 300px;
    }
    .my-ui-btn{
        margin: 0 7px;
    }
</style>
<{include file="../common-second-menu-new.tpl"}>
<div class="ui-popover ui-popover-select left-center" style="top:100px;">
    <div class="ui-popover-inner">
        <span style="display: inline-block;width: 100%;text-align: center">更改绑定会员</span>
        <{include file="../layer/ajax-select-input-single.tpl"}>
        <input type="hidden" id="hid_amsId" value="0">
        <div style="text-align: center">
            <a class="ui-btn ui-btn-primary js-save my-ui-btn" href="javascript:;">确定</a>
            <a class="ui-btn js-cancel my-ui-btn" href="javascript:;" onclick="optshide(this)">取消</a>
        </div>
    </div>
    <div class="arrow"></div>
</div>
<div id="content-con">
    <div  id="mainContent" >

        <!--<div class="page-header">
            <!--<a class="btn btn-green btn-xs add-activity" href="#" data-toggle="modal" data-target="#settledAgreement"><i class="icon-plus bigger-80"></i>入驻协议设置</a>
            <a href="/wxapp/mobile/shopEdit" class="btn btn-green btn-xs add-activity" ><i class="icon-plus bigger-80"></i> 新增</a>
        </div>-->

        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>审核</th>
                            <th>认领人姓名</th>
                            <th>头像</th>
                            <!--<th>电话本记录id</th>-->
                            <!--<th>认领证明信息</th>-->
                            <th>状态</th>
                            <th>申请时间</th>
                            <th>审核时间</th>

                            <th>审核备注</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['ams_id']}>">
                                <td>
                                    <a class="confirm-handle" href="#" data-toggle="modal" data-target="#handleModal"  data-id="<{$val['ams_id']}>">审核</a>
                                </td>
                                <td><{$memberList[$val['ams_mid']]['name']}></td>
                                <td><img class="img-thumbnail" width="60" src="<{if $memberList[$val['ams_mid']]['avatar']}><{$memberList[$val['ams_mid']]['avatar']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"/></td>

                                <!-- <td></td>-->
                                <td>
                                    <{if $val['ams_status'] eq 0}>
                                    <span style="">待审核</span>
                                    <{elseif $val['ams_status'] eq 1}>
                                    <span style="color: green">已通过</span>
                                    <{else}>
                                    <span style="color: red">已拒绝</span>
                                    <{/if}>
                                </td>
                                <td><{if $val['ams_create_time'] > 0}><{date('Y-m-d H:i',$val['ams_create_time'])}><{/if}></td>
                                <td><{if $val['ams_auth_time'] > 0}><{date('Y-m-d H:i',$val['ams_auth_time'])}><{/if}></td>
                                <td><{$val['ams_auth_remark']}></td>
                                <td> <a href="/wxapp/mobile/claimEdit/?id=<{$val['ams_id']}>">详情</a></td>
                            </tr>
                            <{/foreach}>
                        <tr><td colspan="9"><{$paginator}></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 350px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <input type="hidden" id="now_expire" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    延长到期时间
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div style="margin: auto">
                        <div class="col-sm-3 inline-div" style="text-align: right">延长</div>
                        <div class="col-sm-6">
                            <input type="number" name="expire" id="expire" placeholder="请填写整数" class="form-control" >
                        </div>
                        <div class="col-sm-3 inline-div" style="text-align: left">个月</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="change-expire">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<div class="modal fade" id="handleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id_handle" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    申请处理
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">审核状态：</label>
                    <div class="col-sm-10">
                        <select name="status" id="status" class="form-control">
                            <option value="1">通过</option>
                            <option value="2">拒绝</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">处理备注：</label>
                    <div class="col-sm-10">
                        <textarea id="market" class="form-control" rows="5" placeholder="请填写处理备注信息" style="height:auto!important"></textarea>
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

<{include file="../../manage/common-kind-editor.tpl"}>
<script type="text/javascript" charset="utf-8" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" charset="utf-8" src="/public/manage/assets/js/bootstrap-select.js"></script>

<script>
    function confirmDelete(ele) {
        var id = $(ele).data('id');
        if(id){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/mobile/deleteShop',
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
        }
    }

    $('.change-expire').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#now_expire').val($(this).data('expire'));
    });

    $('#change-expire').on('click',function(){
        var hid = $('#hid_id').val();
        var expire = $('#expire').val();
        var now_expire = $('#now_expire').val();
        if(!expire){
            layer.msg('请填写延长时间');
            return false;
        }

        var data = {
            id : hid,
            expire : expire,
            now_expire : now_expire
        };
        if(hid){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/mobile/changeExpire',
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

    $(function(){
        /*多选列表*/
        $(".chosen-select").chosen({
            no_results_text: "没有找到",
            search_contains: true,
            max_selected_options:1
        });

        $('.js-save').on('click',function(){
            var amsId = $('#hid_amsId').val();
            var mid = $("#multi-choose").find(".choose-txt").find('.delete').data('id');
            if(!mid){
                layer.msg('请选择会员');
                return;
            }

            var data = {
                'id' : amsId,
                'mid': mid
            };
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/mobile/changeBelong',
                'data'  : data,
                'dataType' : 'json',
                'success'  : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
//                        optshide();
                        window.location.reload();
                    }
                }
            });

        });
    });
    $("#content-con").on('click',function () {
        optshide();
    });

    $("#content-con").on('click', 'table td a.set-membergrade', function(event) {
        var id = $(this).data('id');
        $('#hid_amsId').val(id);
        optshide();
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-106;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        $("#m_nickname").css('display','inline-block');
        $(".ui-popover.ui-popover-select").css({'left':left-conLeft-450,'top':top-conTop-145}).stop().show();
    });
    /*隐藏设置会员弹出框*/
    function optshide(){
        //隐藏
        $('.ui-popover').stop().hide();
        //清空已选择
        $("#multi-choose").find(".choose-txt").each(function () {
           $(this).remove();
        });
    }

    $('.confirm-handle').on('click',function () {
        $('#hid_id_handle').val($(this).data('id'));
    });
    //处理电话本认领相关信息
    $('#confirm-handle').on('click',function(){
        var hid = $('#hid_id_handle').val();
        var market = $('#market').val();
        var status = $('#status').val();
        var data = {
            id : hid,
            market : market,
            status: status
        };
        if(hid){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/mobile/handleClaim',
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
</script>
