<link rel="stylesheet" href="/public/manage/css/bargain-list.css">

<div id="content-con">
    <div  id="mainContent" >

        <div class="page-header search-box">
            <div class="col-sm-12">
                <form class="form-inline" action="/wxapp/sequence/groupList" method="get">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container" style="width: auto !important;">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">团长昵称</div>
                                    <input type="text" class="form-control" name="nickname" value="<{$nickname}>"  placeholder="团长昵称">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">团长姓名</div>
                                    <input type="text" class="form-control" name="truename" value="<{$truename}>"  placeholder="团长姓名">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">团长电话</div>
                                    <input type="text" class="form-control" name="mobile" value="<{$mobile}>"  placeholder="团长电话">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">小区名称</div>
                                    <input type="text" class="form-control" name="community" value="<{$community}>"  placeholder="小区名称">
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
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>编号</th>
                            <th>活动名称</th>
                            <th>团长信息</th>
                            <th>已接龙数</th>
                            <th>小区名称</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['asg_id']}>">
                                <td>
                                    <{$val['asg_id']}>
                                </td>
                                <td>
                                    <{$val['asa_title']}>
                                </td>
                                <td>
                                    <p>
                                        昵称：<{$val['m_nickname']}>（会员编号：<{$val['m_show_id']}>）
                                    </p>
                                    <p>
                                        姓名：<{$val['asl_name']}>
                                    </p>
                                    <p>
                                        电话：<{$val['asl_mobile']}>
                                    </p>
                                </td>
                                <td><{$val['asg_join']}></td>
                                <td><{$val['asc_name']}></td>
                                <td>

                                    <a href="/wxapp/sequence/tradeList?groupId=<{$val['asg_id']}>">查看订单</a>

                                     - <a href="/wxapp/sequence/groupGoodsSum?groupId=<{$val['asg_id']}>">商品统计</a>

                                </td>
                            </tr>
                            <{/foreach}>

                        <tr><td colspan="9"><{$pagination}></td></tr>

                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>


<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script>

</script>