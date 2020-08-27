<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<{if $couponCenter == 1 && $curr_shop['s_id'] == 5741}>
    <{include file="../common-second-menu-new.tpl"}>
    <{/if}>
<div  id="content-con" <{if $couponCenter == 1 && $curr_shop['s_id'] == 5741}>style="margin-left:130px"<{/if}>>
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/coupon/receive" method="get" class="form-inline">
                <input type="hidden" name="esid" value="<{$esId}>">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">领取会员昵称</div>
                                <input type="text" class="form-control" name="nickname" value="<{$nickname}>" placeholder="领取会员昵称">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">优惠券名称</div>
                                <input type="text" class="form-control" name="name" value="<{$name}>" placeholder="优惠券名称">
                            </div>
                        </div>
                        <input type="hidden" name="cid" value="<{$cid}>">
                    </div>
                </div>
                <div class="col-xs-1 pull-right search-btn">
                    <button type="submit" class="btn btn-green btn-sm">查询</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                    <thead>
                    <tr>
                        <th>优惠券</th>
                        <th>领取人</th>
                        <th>
                            <i class="icon-time bigger-110 hidden-480"></i>
                            领取时间
                        </th>
                        <th>是否使用</th>
                        <th>
                            <i class="icon-time bigger-110 hidden-480"></i>
                            使用时间
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach $list as $val}>
                        <tr>
                            <td class="proimg-name">
                                <{if mb_strlen($val['cl_name']) > 20 }>
                                    <{mb_substr($val['cl_name'],0,20)}>
                                <{else}>
                                    <{$val['cl_name']}>
                                <{/if}>
                            </td>
                            <td><{$val['m_nickname']}></td>
                            <td><{date('Y-m-d H:i:s',$val['cr_receive_time'])}></td>
                            <td><{if $val['cr_is_used'] eq 1}>已使用<{else}>未使用<{/if}></td>
                            <td><{if $val['cr_used_time']}><{date('Y-m-d H:i:s',$val['cr_used_time'])}><{/if}></td>
                        </tr>
                        <{/foreach}>
                        <tr><td colspan="10" style="text-align:right"><{$paginator}></td></tr>
                    </tbody>
                </table>

            </div><!-- /.table-responsive -->
        </div><!-- /span -->
    </div><!-- /row -->
</div>    <!-- PAGE CONTENT ENDS -->

