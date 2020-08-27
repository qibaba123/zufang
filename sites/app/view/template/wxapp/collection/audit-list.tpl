<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/wxapp/hotel/css/emoji.css">
<link rel="stylesheet" href="/public/plugin/prettyPhoto/css/prettyPhoto.css">
<style>
    .table tbody tr td {
        white-space: normal;
    }
    .start-endtime{
        overflow: hidden;
    }
    .start-endtime>em{
        float: left;
        line-height: 34px;
        font-style: normal;
    }
    .start-endtime .input-group{
        float: left;
        width:42%;
    }
    .start-endtime .input-group .input-group-addon{
        border-radius: 0 4px 4px 0!important;
    }
    .form-group-box{
        overflow: auto;
    }
    .form-group-box .form-group{
        width: 260px;
        margin-right: 10px;
        float: left;
    }
</style>
<{include file="../common-second-menu.tpl"}>

<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header search-box">
            <div class="col-sm-12">
                <form class="form-inline" action="/wxapp/collectionprize/check" method="get">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">用户昵称</div>
                                    <input type="text" class="form-control" name="nickname" value="<{$nickname}>"  placeholder="用户昵称">
                                    <input type="hidden" name="status" value="<{$status}>">
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
        <div class="choose-state">
            <a href="/wxapp/collectionprize/check?status=1" <{if $status eq 1}> class="active" <{/if}>>待审核</a>
            <a href="/wxapp/collectionprize/check?status=2" <{if $status eq 2}> class="active" <{/if}>>已通过</a>
            <a href="/wxapp/collectionprize/check?status=3" <{if $status eq 3}> class="active" <{/if}>>已拒绝</a>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>头像</th>
                            <th>昵称</th>
                            <th>图片</th>
                            <th>提交时间</th>
                            <th>状态</th>
                            <th>处理备注</th>
                            <th>处理时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['acpa_id']}>">
                                <td><img src="<{$val['m_avatar']}>" width="50"></td>
                                <td style="max-width: 120px"><{$val['m_nickname']}></td>
                                <td><a href="<{$val['acpa_collection_img']}>" rel="prettyPhoto[]"><img src="<{$val['acpa_collection_img']}>" width="50"></a></td>
                                <td><{date('Y-m-d H:i',$val['acpa_create_time'])}></td>
                                <td style="max-width: 120px">
                                    <{if $val['acpa_status'] == 1}>
                                    <span style="color: red">待审核</span>
                                    <{/if}>
                                    <{if $val['acpa_status'] == 2}>
                                    <span style="color: blue">已通过</span>
                                    <{/if}>
                                    <{if $val['acpa_status'] == 3}>
                                    <span>已拒绝</span>
                                    <{/if}>
                                </td>
                                <td><{$val['acpa_deal_note']}></td>
                                <td><{if $val['acpa_audit_time']>0}><{date('Y-m-d H:i',$val['acpa_audit_time'])}><{/if}></td>
                                <td>
                                    <a class="confirm-handle" href="#" data-toggle="modal" data-target="#myModal"  data-id="<{$val['acpa_id']}>" data-reamrk="<{$val['acpa_deal_note']}>">审核</a>
                                </td>
                            </tr>
                            <{/foreach}>
                        <tr><td colspan="9"><{$paginator}></td></tr>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>

<!-- 模态框（Modal） -->
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
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">审核状态：</label>
                    <div class="col-sm-10">
                        <select name="status" id="status" class="form-control">
                            <option value="2">通过</option>
                            <option value="3">拒绝</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">处理备注：</label>
                    <div class="col-sm-10">
                        <textarea id="remark" class="form-control" rows="5" placeholder="请填写处理备注信息" style="height:auto!important"></textarea>
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
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/public/plugin/prettyPhoto/js/jquery.prettyphoto.js"></script>
<script type="text/javascript" src="/public/plugin/prettyPhoto/js/lrtk.js"></script>

<script>
    $(function(){
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        $(".form-group-box .form-container .form-group").each(function(){
            groupItemWidth=Number($(this).outerWidth(true));
            sumWidth +=groupItemWidth;
        });
        $(".form-group-box .form-container").css("width",sumWidth+"px");
        $("a[rel^='prettyPhoto']").prettyPhoto();
    });

    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#remark').val($(this).data('remark'));
    });

    $('#confirm-handle').on('click',function(){
        var hid = $('#hid_id').val();
        var remark = $('#remark').val();
        var status = $('#status').val();
        var data = {
            id : hid,
            remark : remark,
            status: status
        };
        if(hid){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/collectionprize/handleApply',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em,{
                        time : 2000
                    },function () {
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        }
    });
</script>
