<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<style>
    .form-item{
        height: 50px;
    }

    input.form-control.money{
        display: inline-block;
        width: 100px;
    }

    .form-group .col-sm-8{
        min-height: 27px;
        line-height: 27px;
    }
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
    .datepicker {
        z-index: 1060 !important;
    }
</style>
<div id="content-con">
    <a href="/wxapp/sequence/supplierForm" class="btn btn-sm btn-green" target="_blank" style="margin-bottom: 20px"> 自定义表单 </a>
    <div  id="mainContent" >
        <div class="page-header search-box">
            <div class="col-sm-12">
                <form class="form-inline" action="/wxapp/sequence/supplierApplyList" method="get">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container" style="width: auto !important;">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">昵称</div>
                                    <input type="text" class="form-control" name="nickname" value="<{$nickname}>"  placeholder="昵称">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">会员编号</div>
                                    <input type="number" class="form-control" name="showid" value="<{$showid}>"  placeholder="会员编号">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-1 pull-right search-btn" style="position: absolute;top: 15%;right: 2%;">
                        <button type="submit" class="btn btn-green btn-sm">查询</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>头像</th>
                            <th>昵称</th>
                            <th>
                                <i class="icon-time bigger-110 hidden-480"></i>
                                提交时间
                            </th>
                            <th>处理情况</th>
                            <th>处理时间</th>
                            <th>处理备注</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $key => $val}>
                            <tr id="tr_<{$val['ass_id']}>">
                                <td><img src="<{$val['m_avatar']}>" alt="" style="width: 50px;height: 50px"/></td>
                                <td><{$val['m_nickname']}></td>
                                <td><{date('Y-m-d H:i:s',$val['ass_create_time'])}></td>
                                <td>
                                    <{if $val['ass_status'] == 2}>
                                    <span style="color: green;"><{$statusNote[$val['ass_status']]}></span>
                                    <{elseif $val['ass_status'] == 3}>
                                    <span style="color:red"><{$statusNote[$val['ass_status']]}></span>
                                    <{else}>
                                    <{$statusNote[$val['ass_status']]}>
                                    <{/if}>
                                </td>
                                <td><{if $val['ass_handle_time']}><{date('Y-m-d H:i:s')}><{/if}></td>
                                <td><{$val['ass_handle_remark']}></td>
                                <td class="jg-line-color">
                                    <a href="#" data-toggle="modal" data-target="#myModal<{$val['ass_id']}>">详情</a>-
                                    <{if $val['ass_processed'] eq 0}>
                                    <a class="confirm-handle" href="#" data-toggle="modal" data-target="#handleModal"  data-id="<{$val['ass_id']}>">处理</a>-
                                    <{/if}>
                                    <a class="delete-btn" data-id="<{$val['ass_id']}>" style="color:#f00;">删除</a>
                                </td>
                            </tr>
                        <{/foreach}>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
               <!--页码<div class='text-right'>
                   
               </div>-->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<{if $showPage != 0 }>
<div style="height: 53px;margin-top: 15px;">
    <div class="bottom-opera-fixd">
        <div class="bottom-opera">	            
            <div class="bottom-opera-item" style="text-align:center;">
                <div class="page-part-wrap"><{$pagination}></div>
            </div>
        </div>
    </div>
</div>
<{/if}>
<{foreach $list as $key => $val}>
<div class="modal fade" id="myModal<{$val['ass_id']}>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    提交信息
                </h4>
            </div>
            <div class="modal-body">
                <{foreach json_decode($val['ass_data'],true) as $k => $v}>
                    <{if $v['type'] != 'submit'}>
                        <{if $v['type'] == 'upload'}>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><{$v['data']['title']}>：</label>
                            <div class="col-sm-8">
                                <div><img src="<{$v['value']}>" alt="" style="width: 100px"/></div>
                            </div>
                        </div>
                        <{elseif $v['type'] == 'map'}>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><{$v['data']['title']}>：</label>
                            <div class="col-sm-8">
                                <div><{$v['value'][0]}></div>
                            </div>
                        </div>
                        <{else}>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><{$v['data']['title']}>：</label>
                            <div class="col-sm-8">
                                <div><{$v['value']}></div>
                            </div>
                        </div>
                        <{/if}>
                    <{/if}>
                <{/foreach}>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<{/foreach}>
<div class="modal fade" id="handleModal" tabindex="-1" role="dialog" aria-labelledby="handleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="handleModalLabel">
                    申请处理
                </h4>
            </div>
            <div class="modal-body" style="padding: 10px 15px !important;">
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
<div class="modal fade" id="excelOrder" tabindex="-1" role="dialog" style="display: none;" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="excelOrderLabel">
                    导出留言
                </h4>
            </div>
            <div class="modal-body" style="overflow: auto;text-align: center;margin-bottom: 45px">
                <div class="modal-plan p_num clearfix shouhuo">
                    <form enctype="multipart/form-data" action="/wxapp/form/importMessage" method="post">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">开始日期</label>
                            <div class="col-sm-4">
                                <input class="form-control date-picker" type="text" id="startDate" data-date-format="yyyy-mm-dd" name="startDate" placeholder="请输入开始日期"/>
                            </div>
                            <label class="col-sm-2 control-label">开始时间</label>
                            <div class="col-sm-4 bootstrap-timepicker">
                                <input class="form-control" type="text" id="timepicker1" name="startTime" placeholder="请输入开始时间"/>
                            </div>
                        </div>
                        <div class="space"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">结束日期</label>
                            <div class="col-sm-4">
                                <input class="form-control date-picker" type="text" id="endDate" data-date-format="yyyy-mm-dd" name="endDate" placeholder="请输入结束日期"/>
                            </div>
                            <label class="col-sm-2 control-label">结束时间</label>
                            <div class="col-sm-4 bootstrap-timepicker">
                                <input class="form-control" type="text" id="timepicker2" name="endTime" placeholder="请输入结束时间"/>
                            </div>
                        </div>
                        <div class="space" style="margin-bottom: 70px;"></div>
                        <button type="button" class="btn btn-normal" data-dismiss="modal" style="margin-right: 30px">取消</button>
                        <button type="submit" class="btn btn-primary" role="button">导出</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script>
    $(function(){
        /*初始化日期选择器*/
        $('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
            $(this).prev().focus();
        });
        $("input[id^='timepicker']").timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false
        }).next().on(ace.click_event, function(){
            $(this).prev().focus();
        });

    })

    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
    });

    $('#confirm-handle').on('click',function(){
        var hid = $('#hid_id').val();
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
                'url'   : '/wxapp/sequence/supplierApplyHandle',
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


    $('.delete-btn').on('click', function(){
        var id = $(this).data('id');
		layer.confirm('确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
           	var loading = layer.load(2);
	        $.ajax({
	            'type'  : 'post',
	            'url'   : '/wxapp/sequence/delSupplierApply',
	            'data'  : {id: id},
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
    })
</script>