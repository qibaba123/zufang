<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/css/bindsetting.css">
<div class="wrap">
    <div class="function" style="border: none;padding: 1px;">
        <div class="left">
            <table>
                <tr>
                    <td class="title">活动名称：</td>
                    <td colspan="5"><{$bargain['ba_name']}></td>
                </tr>
                <tr>
                    <td class="title">活动时间：</td>
                    <td colspan="5"><{date('Y-m-d H:i',$bargain['ba_start_time'])}> 至 <{date('Y-m-d H:i',$bargain['ba_end_time'])}></td>
                </tr>
                <tr>
                    <td class="title">商品单价：</td>
                    <td><{$bargain['ba_price']}></td>
                    <td class="title">商品总数：</td>
                    <td><{$bargain['ba_total']}></td>
                    <td class="title">活动状态：</td>
                    <td>
                        <span class="label label-sm label-<{$bargainStatus[$bargain['ba_status']]['css']}>"><{$bargainStatus[$bargain['ba_status']]['label']}></span>
                    </td>
                </tr>
                <tr>
                    <td class="title">参与会员：</td>
                    <td><{$bargain['bj_m_nickname']}></td>
                    <td class="title">助力总金额：</td>
                    <td><{$bargain['bj_amount']}></td>
                    <td class="title">是否购买：</td>
                    <td><{if $bargain['bj_has_buy']}><font color="green">已购买</font><{else}><font color="red">未购买</font><{/if}></td>
                </tr>

            </table>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="table-responsive">
            <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                <thead>
                <tr>
                    <th>参与会员</th>
                    <th>头像</th>
                    <th>砍价金额</th>
                    <th>砍价时间</th>
                </tr>
                </thead>
                <tbody>
                <{foreach $list as $val}>
                    <tr>
                        <td><{$val['be_m_nickname']}></td>
                        <td><img src="<{$val['be_m_avatar']}>" width="50"></td>
                        <td><{$val['be_money']}></td>
                        <td><{date('Y-m-d H:i:s',$val['be_help_time'])}></td>
                    </tr>
                    <{/foreach}>
                </tbody>
                <tr><td colspan="4"><{$paginator}></td></tr>
            </table>
        </div><!-- /.table-responsive -->
    </div><!-- /span -->
</div><!-- /row -->
