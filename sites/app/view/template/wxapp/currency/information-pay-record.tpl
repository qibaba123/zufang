<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<style>
    .balance .balance-info{
        width: 50% !important;
    }
    .table-bordered>tbody>tr>td{border:0;border-bottom:1px solid #ddd;}
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
                    <li>
                        <a  href="/wxapp/currency/getInformationMemberList">
                            <i class="green icon-th-large bigger-110"></i>
                            付费会员
                        </a>
                    </li>
                    <li class="active">
                        <a data-toggle="tab" href="#home">
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
                <div class="page-header">
                    <div class="page-header search-box" style="margin-bottom: 0">
                        <div class="col-sm-12">
                            <form class="form-inline" action="/wxapp/currency/getInformationPayRecord" method="get">
                                <div class="col-xs-11 form-group-box">
                                    <div class="form-container">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">标题</div>
                                                <input type="text" class="form-control" name="title" value="<{$title}>"  placeholder="文章标题">
                                            </div>
                                        </div>
                                        <div class="form-group" style="width: 450px">
                                            <div class="input-group">
                                                <div class="input-group-addon" >支付时间</div>
                                                <input type="text" class="form-control" name="start" value="<{$start}>" placeholder="开始时间" id="start-time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                                <span class="input-group-addon">
	                                        <i class="icon-calendar bigger-110"></i>
	                                    </span>
                                                <span class="input-group-addon" style="border: none !important;background-color:  inherit !important;">到</span>
                                                <input type="text" class="form-control" name="end" value="<{$end}>" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                                <span class="input-group-addon">
	                                        <i class="icon-calendar bigger-110"></i>
	                                    </span>
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
                </div><!-- /.page-header -->
                <div class="tab-content">
                    <!-- 汇总信息 -->
                    <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
                        <div class="balance-info">
                            <div class="balance-title">总收入金额<span></span></div>
                            <div class="balance-content">
                                <span class="money"><{$statInfo['money']}></span>
                                <span class="unit">元</span>
                            </div>
                        </div>
                        <div class="balance-info">
                            <div class="balance-title">购买总次数<span></span></div>
                            <div class="balance-content">
                                <span class="money"><{$statInfo['total']}></span>
                            </div>
                        </div>
                    </div>
                    <!--充值记录-->
                    <div id="home" class="tab-pane in active">
                        <div class="table-responsive">
                            <table id="sample-table-1" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>资讯标题</th>
                                    <th>会员昵称</th>
                                    <th>支付金额</th>
                                    <th>支付时间</th>
                                </tr>
                                </thead>

                                <tbody>
                                <{foreach $list as $val}>
                                    <tr id="tr_<{$val['aip_id']}>">
                                        <td style="">
                                            <{$val['ai_title']}>
                                        </td>
                                        <!--<td>
                                    <{$category_select[$val['ai_category']]}>
                                </td>-->
                                        <td><{$val['m_nickname']}></td>
                                        <td><{$val['aip_pay_money']}></td>
                                        <td><{date('Y-m-d H:i:s', $val['aip_pay_time'])}></td>
                                    </tr>
                                    <{/foreach}>
                                <tr>
                                    <td colspan="4"><{$paginator}></td>
                                </tr>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div>
                </div>
            </div>
        </div>
    </div>


<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/plugin/datePicker/WdatePicker.js"></script>

<script>

</script>