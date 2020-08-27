<link rel="stylesheet" href="/public/manage/css/bargain-list.css">

<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <a href="/wxapp/city/postCatePage" class="btn btn-sm btn-primary">发布页幻灯图</a>
        </div>
        <div class="page-header">
            <span style="color:red;font-size: 14px;">提示:列表为帖子一级分类。帖子的一级分类在同城管理->主页管理->轮播图下面的分类导航处设置</span>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>分类图标</th>
                            <th>分类名称</th>
                            <th>添加时间</th>
                            <th style="max-width: 200px">管理</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['acc_id']}>">
                                <td>
                                    <img src="<{$val['acc_img']}>" alt="" style="width: 50px">
                                </td>
                                <td><{$val['acc_title']}></td>
                                <td><{date('Y-m-d H:i:s', $val['acc_create_time'])}></td>
                                <td style="max-width: 200px">
                                    <a class="btn btn-sm btn-green" href="/wxapp/city/firstCategoryDetail?id=<{$val['acc_id']}>" >幻灯图/二级分类</a>
                                </td>
                            </tr>
                        <{/foreach}>
                        </tbody>
                    </table>
                    <{$pagination}>
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