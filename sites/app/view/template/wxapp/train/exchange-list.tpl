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

    .remark-row td {
        padding: 0 10px;
        word-break: break-all;
        border: none !important;
    }

   .remark-row {
        height: 25px;
        line-height: 25px;
        background: #fffaeb;
        color: #f90;
    }
    .remark-row.buyer-msg {
        background: #fff;
        color: #000;
    }
    .exchange-list-item{
        padding: 2px;
    }
    .exchange-list-item td{
        border-bottom: none;
    }
    .info-cell{
        padding-right: 20px;
    }

</style>
<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header search-box">
            <div class="col-sm-12">
                <form class="form-inline" action="/wxapp/train/exchangeList" method="get">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container" style="width: auto !important;">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">姓名</div>
                                    <input type="text" class="form-control" name="name" value="<{$name}>"  placeholder="姓名">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">状态</div>
                                    <select name="exchange_status" id="exchange_status" class="form-control">
                                        <option value="0">全部</option>
                                        <option value="1" <{if $exchange_status == 1}>selected<{/if}>>未处理</option>
                                        <option value="2" <{if $exchange_status == 2}>selected<{/if}>>已处理</option>
                                    </select>
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
                            <th>课程名称</th>
                            <th>人数</th>
                            <th>
                                <i class="icon-time bigger-110 hidden-480"></i>
                                预约时间
                            </th>
                            <th>备注</th>
                            <th>提交时间</th>
                            <th>状态</th>
                            <th>处理时间</th>
                            <th>处理备注</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $key => $val}>
                            <tr id="tr_<{$val['atce_id']}>" class="exchange-list-item">
                                <!--
                                <td>
                                    <p>姓名：<{$val['atce_name']}>&nbsp;&nbsp;<{if $val['atce_sex'] == 2}>女<{else}>男<{/if}>&nbsp;&nbsp;<{$val['atce_mobile']}></p>
                                    <p>公司：<{$val['atce_company']}></p>
                                    <p>职位：<{$val['atce_position']}></p>
                                    <p>课程：<span style="color: blue"><{$val['atc_title']}></span></p>
                                </td>
                                -->
                                <td><span style="color: blue"><{$val['atc_title']}></span></td>
                                <td><{$val['atce_num']}>人</td>
                                <td>
                                    <{date('Y-m-d',$val['atce_time'])}>
                                </td>
                                <td><{$val['atce_note']}></td>
                                <td><{date('Y-m-d H:i:s',$val['atce_create_time'])}></td>
                                <td>
                                    <{if $val['atce_status'] == 1}>
                                    <span style="">未处理</span>
                                    <{elseif $val['atce_status'] == 2}>
                                    <span style="color:green">已处理</span>
                                    <{/if}>
                                </td>
                                <td><{if $val['atce_handle_time']}><{date('Y-m-d H:i:s')}><{/if}></td>
                                <td><{$val['atce_handle_remark']}></td>
                                <td class="jg-line-color">
                                    <!--
                                    <a href="#" data-toggle="modal" data-target="#myModal<{$val['atce_id']}>">详情</a>-
                                    -->
                                    <{if $val['atce_status'] eq 1}>
                                    <a class="confirm-handle" href="#" data-toggle="modal" data-target="#handleModal"  data-id="<{$val['atce_id']}>">处理</a>
                                    <{/if}>
                                    <!--
                                    <a class="delete-btn" data-id="<{$val['atce_id']}>" style="color:#f00;">删除</a>
                                    -->

                                </td>
                            </tr>
                            <{if $val['atce_info_list']}>
                            <tr class="remark-row buyer-msg">
                                <td colspan="9">
                                    <{foreach $val['atce_info_list'] as $value}>
                                    <div class="info-item">
                                        <span class="info-cell">姓名：<{$value['name']}></span>
                                        <span class="info-cell">性别：<{if $value['sex'] == 2}>女<{else}>男<{/if}></span>
                                        <span class="info-cell">电话：<{$value['mobile']}></span>
                                        <span class="info-cell">公司：<{$value['company']}></span>
                                        <span class="info-cell">职位：<{$value['position']}></span>
                                    </div>
                                    <{/foreach}>
                                </td>
                            </tr>
                            <{/if}>
                            <{/foreach}>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
                <{$pageHtml}>
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<{foreach $list as $key => $val}>
<div class="modal fade" id="myModal<{$val['atce_id']}>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                <{foreach json_decode($val['atce_data'],true) as $k => $v}>
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
                    处理
                </h4>
            </div>
            <div class="modal-body" style="padding: 10px 15px !important;">
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">状态：</label>
                    <div class="col-sm-10">
                        <select name="status" id="status" class="form-control">
                            <option value="2">已处理</option>
                            <option value="1">未处理</option>
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
            remark : market,
            status: status
        };
        if(hid){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/train/exchangeHandle',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em,{
                        time : 1000
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