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
    .nickname{
        padding-left: 3px;
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
                                        <em style="width:70px;text-align:center">收益时间：</em>
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
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">类型</div>
                                    <select  class="form-control" name="categoryId">
                                        <option value="0">全部</option>
                                        <{if $type == 1}>
                                            <{foreach $postCategory as $val}>
                                        <option value="<{$val['id']}>"  <{if $val['id'] eq $categoryId}>selected<{/if}>><{$val['name']}></option>
                                            <{/foreach}>
                                        <{else}>
                                        <{foreach $shopCategory as $val}>
                                    <option value="<{$val['id']}>"  <{if $val['id'] eq $categoryId}>selected<{/if}>><{$val['name']}></option>
                                        <{/foreach}>
                                        <{/if}>
                                    </select>
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
                            <th>用户</th>
                            <th style="min-width: 300px">内容</th>
                            <th>时间</th>
                        </tr>
                        </thead>
                        <tbody>
                            <{foreach $list as $val}>
                            <tr>
                                <{if $val['sc_from']}>
                                <td>
                                    <img style="width: 50px;" src="<{if $curr_shop['s_logo']}><{$curr_shop['s_logo']}><{else}>/public/manage/img/zhanwei/zw_fxb_200_200.png<{/if}>" alt="">
                                    <span class="nickname">客服</span>
                                </td>
                                <{else}>
                                <td>
                                    <img style="width: 50px;" src="<{if $val['m_avatar']}><{$val['m_avatar']}><{else}>/public/wxapp/images/applet-avatar.png<{/if}>" alt="">
                                    <span class="nickname"><{$val['m_nickname']}></span>
                                </td>
                                <{/if}>
                                <td style="min-width: 300px">
                                <{if $val['sc_type'] == 1}>
                                <img style="width: 150px;" src="<{$val['sc_content']}>" alt="">
                                <{else}>
                                <{$val['sc_content']}>
                                <{/if}>
                                </td>
                                <td><{date('Y-m-d H:i:s',$val['sc_create_time'])}></td>
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
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
