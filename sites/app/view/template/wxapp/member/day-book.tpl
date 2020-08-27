<style>
    .table.table-button tbody>tr>td{
        line-height: 33px;
    }
    .infobox{
        width: 95%;
        height: 85px;
        margin:0 auto;
        text-align: center;
        padding-top: 5%;
    }
    .info-tongji .infobox-orange{
        background-color: #f9c13a;
    }
    .info-tongji .infobox-green{
        background-color: #9ccb59;
    }
    .info-tongji .infobox-green2{
        background-color: #02a7a9;
    }
    .info-tongji .infobox-blue2{
        background-color: #0181ca;
    }

    .infobox>span{
        font-size: 25px;
        margin-top: 5px;
        display: block;
    }
    .infobox>p{
        margin:0;
    }
    .info-tongji{
        overflow: hidden;
        margin-bottom:25px;
    }
    .info-tongji>div{
        text-align: center;
    }
</style>
<{if $showSecond == 1}>
    <{include file="../common-second-menu.tpl"}>
<{/if}>
<div id="mainContent">
    <div class="user-moneyinfo">
        <h4 style="padding: 0 20px;font-weight: bold;font-size: 14px;"><{$member['m_nickname']}></h4>
        <div class="row info-tongji" >
            <div class="col-sm-3">
                <div class="infobox infobox-orange infobox-dark">
                    <span><{$member['m_deduct_amount']}></span>
                    <p><i class="icon-comment"></i> 返佣总额 </p>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="infobox infobox-green infobox-dark">
                    <span><{$member['m_deduct_ktx']}></span>
                    <p><i class="icon-user"></i> 可提现金额 </p>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="infobox infobox-green2 infobox-dark">
                    <span><{$member['m_deduct_ytx']}></span>
                    <p><i class="icon-certificate"></i> 已提现金额 </p>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="infobox infobox-blue2 infobox-dark">
                    <span><{$member['m_deduct_dsh']}></span>
                    <p><i class="icon-book"></i> 待审核提现金额 </p>
                </div>
            </div>
        </div>
    </div>
    <div class="choose-state">
        <{foreach $choseLink as $val}>
        <a href="<{$val['href']}>" <{if $type eq $val['key']}> class="active" <{/if}>><{$val['label']}></a>
        <{/foreach}>
    </div>
    <div class="row">
        <!-- <div class="space-4"></div> -->
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table id="sample-table-1" class="table table-striped table-hover table-button">
                            <thead>
                            <tr>
                                <th class="hidden-480">订单编号</th>
                                <th>级别</th>
                                <th>流水金额</th>
                                <th>
                                    <i class="icon-time bigger-110 hidden-480"></i>
                                    流水时间
                                </th>
                                <th>备注</th>
                            </tr>
                            </thead>

                            <tbody>
                            <{foreach $list as $val}>
                                <tr>
                                    <td><{$val['dd_tid']}></td>
                                    <td><{if $val['dd_level']}><{$val['dd_level']}>级<{else}>返现<{/if}></td>
                                    <td class="hidden-480">
                                        <{if in_array($val['dd_record_type'],array(1,2))}>
                                        <span class="label label-sm label-success"> + <{$val['dd_amount']}> </span>
                                        <{else}>
                                        <span class="label label-sm label-danger"> - <{$val['dd_amount']}> </span>
                                        <{/if}>
                                    </td>
                                    <td><{date('Y-m-d H:i:s',$val['dd_record_time'])}></td>
                                    <td><{$val['dd_record_remark']}></td>
                                </tr>
                                <{/foreach}>
                                <tr><td colspan="5"><{$paginator}></td></tr>
                            </tbody>
                        </table>
                        <{$paginator}>
                    </div><!-- /.table-responsive -->
                </div><!-- /span -->
            </div><!-- /row -->
        </div>
    </div>
</div>



