<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
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
<div id="content-con">

    <div  id="mainContent" >

        <!--
        <div class="page-header search-box">
            <div class="col-sm-12">
                <form action="/wxapp/customer/index" method="get" class="form-inline">
                    <input type="hidden" name="type" value="<{$type}>">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container">
                            <div class="form-group" style="width:580px;">
                                <div class="input-group" style="width:100%;">
                                    <div class="start-endtime">
                                        <em style="width:70px;text-align:center">咨询时间：</em>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="start" value="<{$start}>" placeholder="开始时间" id="start-time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                            <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                        </div>
                                        <em style="padding:0 3px;">到</em>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="end" value="<{$end}>" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                            <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                        </div>
                                    </div>
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
        -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>

                            <th>头像</th>
                            <th>昵称</th>
                            <th>领取金额</th>
                            <th>领取时间</th>
                        </tr>
                        </thead>
                        <tbody>
                            <{foreach $list as $val}>
                            <tr>
                                <td>
                                    <img style="width: 50px;" src="<{if $val['m_avatar']}><{$val['m_avatar']}><{else}>/public/wxapp/images/applet-avatar.png<{/if}>" alt="">
                                </td>
                                <td><{$val['m_nickname']}></td>
                                <td><{$val['acrr_money']}></td>
                                <td><{date('Y-m-d H:i:s',$val['acrr_create_time'])}></td>
                            </tr>
                            <{/foreach}>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
            <{$page_html}>
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>

</script>