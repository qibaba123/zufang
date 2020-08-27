<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<style>
    .balance .balance-info{
        width: 33.33% !important;
    }
    .table-bordered>tbody>tr>td{border:0;border-bottom:1px solid #ddd; }
</style>
    <{include file="../common-second-menu-new.tpl"}>


    <div class="row" style="margin-left: 150px;margin-top: 20px;">
        <div class="col-sm-9" style="margin-bottom: 20px;">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li>
                        <a  href="/wxapp/currency/informationCardType">
                            <i class="green icon-money bigger-110"></i>
                            付费会员类型
                        </a>
                    </li>
                    <li class="active">
                        <a data-toggle="tab" href="#home">
                            <i class="green icon-th-large bigger-110"></i>
                            付费会员
                        </a>
                    </li>
                    <li>
                        <a  href="/wxapp/currency/getInformationPayRecord">
                            <i class="green icon-cog bigger-110"></i>
                            资讯付费记录
                        </a>
                    </li>
                    <li>
                        <a href="/wxapp/currency/getInformationCardPayRecord">
                            <i class="green icon-cog bigger-110"></i>
                            会员购买记录
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- 汇总信息 -->
                    <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
                        <div class="balance-info">
                            <div class="balance-title">会员总数<span></span></div>
                            <div class="balance-content">
                                <span class="money"><{$statInfo['total']}></span>
                            </div>
                        </div>
                        <div class="balance-info">
                            <div class="balance-title">未到期会员<span></span></div>
                            <div class="balance-content">
                                <span class="money"><{$statInfo['normal']}></span>
                            </div>
                        </div>
                        <div class="balance-info">
                            <div class="balance-title">已到期会员
                            </div>
                            <div class="balance-content">
                                <span class="money"><{$statInfo['expire']}></span>
                            </div>
                        </div>
                    </div>
                    <!--充值记录-->
                    <div id="home" class="tab-pane in active">
                        <div class="table-responsive">
                            <table id="sample-table-1" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>会员头像</th>
                                    <th>会员昵称</th>
                                    <th>类型</th>
                                    <th>到期时间</th>
                                    <th>会员状态</th>
                                    <th>购买时间</th>
                                </tr>
                                </thead>

                                <tbody>
                                <{foreach $list as $val}>
                                    <tr id="tr_<{$val['aim_id']}>">
                                        <td style="width: 60px;text-align: center">
                                            <img src="<{$val['m_avatar']}>" alt="头像" style="height: 50px">
                                        </td>
                                        <td><{$val['m_nickname']}></td>
                                        <td><{$val['aim_title']}></td>
                                        <td><{date('Y-m-d H:i:s', $val['aim_expire_time'])}></td>
                                        <td>
                                            <{if $val['aim_expire_time'] < time()}>
                                            <span style="color: red">已到期</span>
                                            <{else}>
                                            <span style="color: #333;">正常</span>
                                            <{/if}>
                                        </td>
                                        <td><{date('Y-m-d H:i:s', $val['aim_create_time'])}></td>
                                    </tr>
                                    <{/foreach}>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>

</script>