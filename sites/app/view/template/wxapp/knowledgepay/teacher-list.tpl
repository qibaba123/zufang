<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style type="text/css">
    #goods-tr td{
        padding:8px 5px;
        border-bottom:1px solid #eee;
        cursor: pointer;
        text-align: center;
        vertical-align: middle;
    }
    #goods-tr td p{
        margin:0;
    }
    #goods-tr td img{
        width: 60px;
        height: 60px;
    }
    #goods-tr td p.g-name{
        margin:0;
        padding:0;
        height: 30px;
        line-height: 30px;
        max-width: 400px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        color: #38f;
        font-family: '黑体';
    }
    .pull-right>.btn{
        margin-left: 6px;
    }
    .center{
        text-align: center;
    }
    .form-group{
        margin-bottom: 10px;
    }
    .form-group .control-label[class*="col-"] {
        line-height: 36px;
        margin: 0;
        padding: 0;
        text-align: right;
        font-weight: bold;
    }
    .form-group .price{
        line-height: 36px;
        color: red;
        font-weight: bold;
    }
</style>
<{include file="../../manage/common-kind-editor.tpl"}>
<div id="content-con">
    <div  id="mainContent">
        <div class="page-header">
            <a href="/wxapp/knowledgepay/addTeacher" class="btn btn-green btn-sm"><i class="icon-plus bigger-80"></i> 新增</a>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>头像</th>
                            <th>姓名</th>
                            <th>标签</th>
                            <th>简介</th>
                            <th>添加时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['akt_id']}>">
                                <td><img src="<{$val['akt_avatar']}>" alt="" style="width: 100px"/></td>
                                <td><{$val['akt_name']}></td>
                                <td><{$val['akt_label']}></td>
                                <td><{$val['akt_desc']}></td>
                                <td><{date('Y-m-d H:i',$val['akt_create_time'])}></td>
                                <td>
                                    <a href="/wxapp/knowledgepay/addTeacher/id/<{$val['akt_id']}>">编辑</a>-
                                    <a href="javascript:" onclick="delTeacher(this)" data-id="<{$val['akt_id']}>">删除</a>
                                </td>
                            </tr>
                            <{/foreach}>
                        <{if $pageHtml}>
                            <tr><td colspan="7"><{$pageHtml}></td></tr>
                            <{/if}>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
    </div>
</div>


<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>

    function delTeacher(e){
        var id = $(e).data('id');
        if(id > 0){
            var index = layer.load(2,
                    {
                        shade: [0.1,'#333'],
                        time: 10*1000
                    }
            );
            $.ajax({
                type: 'post',
                url: "/wxapp/knowledgepay/delTeacher" ,
                data: {id:id},
                dataType: 'json',
                success: function(json_ret){
                    layer.msg(json_ret.em);
                    layer.close(index);
                    if(json_ret.ec == 200){
                        window.location.reload();
                    }
                }
            });
        }
    }
</script>
