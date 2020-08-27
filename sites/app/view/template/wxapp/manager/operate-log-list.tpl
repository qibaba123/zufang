<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<div>
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/manager/operateLogList" method="get" class="form-inline" id="search-form-box">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon" style="height:34px;">操作人</div>
                                <select id="cate" name="manager" style="height:34px;width:100%" class="form-control">
                                    <option value="0">全部</option>
                                    <{foreach $managerList as $val}>
                                <option <{if $manager eq $val['m_id']}>selected<{/if}> value="<{$val['m_id']}>"><{$val['m_nickname']}></option>
                                    <{/foreach}>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="width: 600px">
                            <div class="input-group">
                                <div class="input-group-addon" >操作时间</div>
                                <input type="text" class="form-control" autocomplete="off" name="start" value="<{$start}>" placeholder="开始时间" id="start-time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                <span class="input-group-addon" style="border: none !important;background-color:  inherit !important;">到</span>
                                <input type="text" class="form-control" autocomplete="off" name="end" value="<{$end}>" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-1 pull-right search-btn" style="position: absolute;top: 18%;right: 2%;">
                    <button type="submit" class="btn btn-green btn-sm">查询</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>操作人</th>
                                <th>操作信息</th>
                                <th>操作时间</th>
                                <th>操作ip</th>
                            </tr>
                            </thead>

                            <tbody>
                            <{foreach $list as $item}>
                            <tr id="tr_id_<{$item['mol_id']}>">
                                <td>
                                    <a href="#"><{$item['m_nickname']}></a>
                                </td>
                                <td><{$item['mol_message']}></td>
                                <td><{$item['mol_create_time']|date_format:"%Y-%m-%d %H:%M:%S"}></td>
                                <td>
                                    <{$item['mol_ip']}>
                                </td>
                            </tr>
                            <{/foreach}>
                            </tbody>
                        </table>
                        <div class='text-center'>
                            <{$paginator}>
                        </div>
                    </div><!-- /.table-responsive -->
                </div><!-- /span -->
            </div><!-- /row -->
        </div>
    </div>
</div>
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<script src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
    $(function() {
        /*初始化日期选择器*/
        $('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function () {
            $(this).prev().focus();
        });

        $("input[id^='timepicker']").timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false
        }).next().on(ace.click_event, function () {
            $(this).prev().focus();
        });
    });
</script>