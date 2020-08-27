<meta http-equiv="Content-Type" content="text/html; charset=utf8mb4" />
<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/wxapp/hotel/css/emoji.css">
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
    /*
    switch开关
     */
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { content: "已启用\a0\a0\a0\a0\a0未启用"; }
    input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { content: "\a0\a0禁用\a0\a0\a0\a0\a0\a0\a0启用"; }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { background-color: #666666; border: 1px solid #666666; }
    input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { background-color: #333333; border: 1px solid #333333; }
    input[type=checkbox].ace.ace-switch { width: 90px; height: 30px; margin: 0; }
    input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { line-height: 30px; height: 31px; overflow: hidden; border-radius: 18px; width: 89px; font-size: 13px; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::before { background-color: #44BB00; border-color: #44BB00; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:hover:checked:hover+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked:hover+.lbl::before { background-color: #DD0000; border-color: #DD0000; }
    input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after { width: 28px; height: 28px; line-height: 28px; border-radius: 50%; top: 1px; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after { left: 59px; top: 1px }
    #tip-div{
        width: 60%;
        margin-top: 10px;
    }
    #tip-textarea{
        display: inline-block;
        width: 50%;
    }
    #tip-span{
        width: 10%;
        display: inline-block;
        text-align: center;
    }
</style>
<span style="">
        <span class="switch-title">启用手机号验证：</span>
        <label id="choose-onoff" class="choose-onoff">
            <input class="ace ace-switch ace-switch-5" id="applyOpen"  data-type="open" onchange="changeOpen()" type="checkbox" <{if $curr_shop['s_check_mobile'] eq 1}>checked<{/if}>>
            <span class="lbl"></span>
        </label>
        <span style="color: red">此功能启用时，用户必须认证手机号后才能发帖</span>
    </span>
<div class="page-header search-box">
    <div class="col-sm-12">
        <form class="form-inline" action="/wxapp/mobilecheck/index" method="get">
            <div class="col-xs-11 form-group-box">
                <div class="form-container">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">昵称</div>
                            <input type="text" class="form-control" name="nickname" value="<{$nickname}>"  placeholder="微信昵称">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">会员编号</div>
                            <input type="text" class="form-control" name="showId" value="<{$showId}>"  placeholder="会员编号">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">手机号</div>
                            <input type="text" class="form-control" name="mobile" value="<{$mobile}>"  placeholder="手机号">
                        </div>
                    </div>
                    <input type="hidden" name="status" value="<{$status}>">
                </div>
            </div>
            <div class="col-xs-1 pull-right search-btn">
                <button type="submit" class="btn btn-green btn-sm">查询</button>
            </div>
        </form>
    </div>
</div>
<div id="content-con">
    <div  id="mainContent" >
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>头像</th>
                            <th>昵称</th>
                            <th>会员编号</th>
                            <th>手机号</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['m_id']}>">
                                <td><img src="<{if $val['m_avatar']}><{$val['m_avatar']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>" width="50"></td>
                                <td style="max-width: 120px"><{$val['m_nickname']}></td>
                                <td><{$val['m_show_id']}></td>
                                <td><{$val['m_mobile']}></td>
                                <td>
                                    <a class="confirm-handle" href="/wxapp/city/postList?mid=<{$val['m_id']}>" >会员发帖</a>
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


<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/plugin/datePicker/WdatePicker.js"></script>

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

    });

    function changeOpen() {
        var open   = $('#applyOpen:checked').val();
        var data = {
            value:open
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/mobilecheck/mobileCheckOpen',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
            }
        });
    }
</script>
