<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
    .add-servicefl{
        display: inline-block;
        vertical-align: middle;
    }
    .add-servicefl>div{
        display: inline-block;
        vertical-align: middle;
    }
    .add-servicefl .fl-input{
        margin-left: 10px;
        display: none;
    }
    .add-servicefl .fl-input .form-control{
        display: inline-block;
        vertical-align: middle;
        width: 150px;
    }
    .add-servicefl .fl-input .btn{
        display: inline-block;
        vertical-align: middle;;
    }
    .servicefl-wrap{
        margin-bottom: 10px;
    }
    .servicefl-wrap h4{
        font-size: 16px;
        font-weight: bold;;
        margin:0;
        line-height: 2;
        margin-bottom: 5px;
    }
    .servicefl-wrap .fl-item{
        display: inline-block;
        margin-right: 6px;
        margin-bottom: 6px;
        background-color: #f5f5f5;
        border: 1px solid #dfdfdf;
        border-radius: 3px;
        padding: 0 10px;
        height: 35px;
        line-height: 33px;
        position: relative;
        padding-right: 30px;
    }
    .servicefl-wrap .fl-item .delete-fl{
        position: absolute;
        height: 20px;
        width: 20px;
        top: 6px;
        right: 3px;
        font-size: 18px;
        color: #666;
        text-align: center;
        z-index: 1;
        line-height: 20px;
        cursor: pointer;
    }
    .article-circle-img {
        width: 50px;
        height: 50px;
        border-radius: 25px;
        background-color: #eee;
        margin-left: 0;
    }
    .gzh-middle-content {
        display: flex;
        flex-direction: column;
    }
    .introduce-article-content, .introduce-content {
        overflow: hidden;
        text-overflow: ellipsis;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .article-add-img {
        width: 20px;
        height: 20px;
        margin-left: 20px;
        cursor: pointer;
    }

    #search-content{
        font-size: 12px;
    }

    #search-content .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
    }

    .middle-div {
        border-bottom: 1px solid #e5e5e5;
        width: 590px!important;
    }

    #search-content td {
        min-width: 66px;
        font-size: 12px;
        line-height: 20px!important;
        vertical-align: middle!important;
        padding-top: 11px!important;
        padding-bottom: 11px!important;
        border-color: #e5e5e5!important;
    }

    .introduce-content {
        width: 400px;
    }


    .cus-input { padding: 7px 8px; font-size: 14px; border: 1px solid #ddd; -webkit-border-radius: 4px; -moz-border-radius: 4px; -ms-border-radius: 4px; -o-border-radius: 4px; border-radius: 4px; width: 100%; -webkit-transition: box-shadow 0.5s; -moz-transition: box-shadow 0.5s; -ms-transition: box-shadow 0.5s; -o-transition: box-shadow 0.5s; transition: box-shadow 0.5s; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; -o-box-sizing: border-box; box-sizing: border-box; min-height: 34px; resize: none; font-size: 14px;}
    .classify-wrap .classify-title { font-size: 16px; font-weight: bold; line-height: 2;padding: 10px 0; }
    .classify-wrap .classify-preiview-page { width: 320px; padding: 0 20px 20px; border: 1px solid #dfdfdf; -webkit-border-radius: 10px 10px 0 0; -moz-border-radius: 10px 10px 0 0; -ms-border-radius: 10px 10px 0 0; -o-border-radius: 10px 10px 0 0; border-radius: 10px 10px 0 0; background-color: #fff; box-sizing: content-box; float: left; }
    .classify-preiview-page .mobile-head { padding: 12px 0; text-align: center}
    .classify-preiview-page .mobile-con { border: 1px solid #dfdfdf; min-height: 150px; background-color: #f5f6f7; }
    .classify-preiview-page .mobile-nav { position: relative; }
    .classify-preiview-page .mobile-nav img { width: 100%; }
    .classify-preiview-page .mobile-nav p { line-height: 44px; height: 44px; position: absolute; width: 100%; top: 20px; left: 0; font-size: 15px; text-align: center; }
    .classify-preiview-page .classify-name { display: table; background-color: #fff; }
    .classify-preiview-page .classify-name span { display: table-cell; width: 1000px; text-align: center; height: 45px; line-height: 45px; }
    .classify-wrap .right-classify-manage { margin-left: 370px; min-height: 210px; }
    .right-classify-manage .manage-title{font-weight: bold;padding: 10px 10px 5px;}
    .right-classify-manage .manage-title span{font-size: 13px;color: #999;font-weight: normal;}
    .right-classify-manage .add-classify{padding: 0 10px;}
    .right-classify-manage .add-classify .add-btn{height: 30px;line-height: 30px; padding: 0 10px;background-color: #06BF04;border-radius: 4px;font-size: 14px;display: inline-block;cursor: pointer;border:1px solid #00AB00;color: #fff;}
    .classify-name-con { font-size: 0; padding: 10px;}
    .noclassify{font-size: 15px;color: #999;}
    .classify-name-con .classify-name { border: 1px solid #ddd; border-radius: 4px; padding: 5px 10px; position: relative; display: inline-block; font-size: 14px; margin-right: 10px; margin-bottom: 10px; background-color: #f5f6f7; cursor: move;}
    .right-classify-manage .classify-name .cus-input{display: inline-block;width: 150px;}
    .classify-name-con .classify-name .del-btn { display:inline-block;height: 34px; line-height: 34px; font-size: 20px; width: 25px; cursor: pointer; text-align: center; color: #666; vertical-align: middle;}
    .classify-name-con .classify-name .del-btn:hover { color: #333; }
    #search-pager span{
        width: 25px;
        display: inline-block;
        height: 25px;
        text-align: center;
        line-height: 25px;
        color: #333;
        cursor: pointer;
        outline: 0;
        text-decoration: none;
        background: #ccc;
        border-radius: 4px;
        margin: 5px;
        margin-bottom: 15px;
    }

    #search-pager .active{
        background: #fff;
        font-weight: bold;
        color: #00a06a;
    }

    .el-col{
        margin: 30px 10px 55px;
        border: 1px solid rgb(209, 219, 229);
        padding: 25px;
        border-radius: 4px;
        height: 150px;
        box-shadow: 0 2px 4px 0 rgba(0,0,0,.12), 0 0 6px 0 rgba(0,0,0,.04);
    }

    .el-button{
        font-size: 12px;
        width: 60px;
        color: #fff;
        border-radius: 4px;
        background-color: #010406;
        border-color: #010406;
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
    .index-con {
        padding: 0;
        position: relative;
    }
    .index-con .index-main {
        height: 425px;
        background-color: #f3f4f5;
        overflow: auto;
    }
    .message{
        width: 92%;
        background-color: #fff;
        border:1px solid #ddd;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -ms-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        margin:10px auto;
        -webkit-box-sizing:border-box;
        -moz-box-sizing:border-box;
        -ms-box-sizing:border-box;
        -o-box-sizing:border-box;
        box-sizing:border-box;
        padding:5px 8px 0;
    }
    .message h3{
        font-size: 15px;
        font-weight: bold;
    }
    .message .date{
        color: #999;
        font-size: 13px;
    }
    .message .remind-txt{
        padding:5px 0;
        margin-bottom: 5px;
        font-size: 13px;
        color: #FF1F1F;
    }
    .message .item-txt{
        font-size: 13px;
    }
    .message .item-txt .text{
        color: #5976be;
    }
    .message .see-detail{
        border-top:1px solid #eee;
        line-height: 1.6;
        padding:5px 0 7px;
        margin-top: 12px;
        background: url(/public/manage/mesManage/images/enter.png) no-repeat;
        background-size: 12px;
        background-position: 99% center;
    }
    .preview-page{
        max-width: 900px;
        margin:0 auto;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        padding:20px 15px;
        overflow: hidden;
    }
    .preview-page .mobile-page{
        width: 350px;
        float: left;
        background-color: #fff;
        border: 1px solid #ccc;
        -webkit-border-radius: 15px;
        -moz-border-radius: 15px;
        -ms-border-radius: 15px;
        -o-border-radius: 15px;
        border-radius: 15px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        padding:0 15px;
    }
    .preview-page {
        padding-bottom: 20px!important;
    }
    .mobile-page{
        margin-left: 48px;
    }
    .mobile-page .mobile-header {
        height: 70px;
        width: 100%;
        background: url(/public/manage/mesManage/images/iphone_head.png) no-repeat;
        background-position: center;
    }
    .mobile-page .mobile-con{
        width: 100%;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        border:1px solid #ccc;
        background-color: #fff;
    }
    .mobile-con .title-bar{
        height: 64px;
        background: url(/public/manage/mesManage/images/titlebar.png) no-repeat;
        background-position: center;
        padding-top:20px;
        font-size: 16px;
        line-height: 44px;
        text-align: center;
        color: #fff;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        letter-spacing: 1px;
    }

    .mobile-page .mobile-footer{
        height: 65px;
        line-height: 65px;
        text-align: center;
        width: 100%;
    }
    .mobile-page .mobile-footer span{
        display: inline-block;
        height: 45px;
        width: 45px;
        margin:10px 0;
        background-color: #e6e1e1;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
        border-radius: 50%;
    }
</style>

    <style>
        input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { content: "已启用\a0\a0\a0\a0\a0未启用" !important; }
input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { content: "\a0\a0禁用\a0\a0\a0\a0\a0\a0\a0启用" !important; }
input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { background-color: #666666; border: 1px solid #666666; }
input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { background-color: #333333; border: 1px solid #333333; }
input[type=checkbox].ace.ace-switch { width: 90px; height: 30px; margin: 0; }
input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { line-height: 30px; height: 31px; overflow: hidden; border-radius: 18px; width: 89px; font-size: 13px; }
input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::before { background-color: #44BB00; border-color: #44BB00; }
input[type=checkbox].ace.ace-switch.ace-switch-4:hover:checked:hover+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked:hover+.lbl::before { background-color: #DD0000; border-color: #DD0000; }
input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after { width: 28px; height: 28px; line-height: 28px; border-radius: 50%; top: 1px; }
input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after { left: 59px; top: 1px }
    </style>
<!--
<div class="alert alert-block alert-success" style="margin-left: 130px">
    <ol>
        <li>
            <small>消息推送教程：<a href="http://bbs.tiandiantong.net/forum.php?mod=viewthread&tid=361&extra=page%3D2" class="xxmb-bnt" target="_blank">http://bbs.tiandiantong.net/forum.php?mod=viewthread&tid=361&extra=page%3D2</a></small>
            <small style="padding-left: 20px"><a href="http://bbs.tiandiantong.net/forum.php?mod=viewthread&tid=361&extra=page%3D2" style="color: red;" target="_blank">查看图文教程</a></small>
        </li>
    </ol>
</div>
-->
<div id="content-con">
    <div  id="mainContent">
        <div class="alert alert-block alert-yellow " >
            <button type="button" class="close" data-dismiss="alert">
                <i class="icon-remove"></i>
            </button>
            此处通知信息为通知骑手相关信息，可在骑手APP，抢单大厅页面查看
        </div>
        <div class="page-header">
            <a href="/wxapp/legwork/noticeEdit" class="btn btn-green btn-xs" style="padding-top: 2px;padding-bottom: 2px;"><i class="icon-plus bigger-80"></i> 新增</a>

            <div class="page-header search-box" style="margin-bottom: 0">
                <div class="col-sm-12">
                    <form class="form-inline" action="/wxapp/legwork/noticeList" method="get">
                        <div class="col-xs-11 form-group-box">
                            <div class="form-container">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">标题</div>
                                        <input type="text" class="form-control" name="title" value="<{$title}>"  placeholder="标题">
                                    </div>
                                </div>

                                <div class="form-group" style="width: 450px">
                                    <div class="input-group">
                                        <div class="input-group-addon" >最近更新</div>
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


        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <!--
                            <th class="center">
                                <label>
                                    <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                    <span class="lbl"></span>
                                </label>
                            </th>
                            -->
                            <th>标题</th>
                            <th>最近更新</th>
                            <th>最近推送</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr>
                                <!--
                                <td class="center">
                                    <label>
                                        <input type="checkbox" class="ace" name="ids" value="<{$val['aln_id']}>"/>
                                        <span class="lbl"></span>
                                    </label>
                                </td>
                                -->
                                <td><{$val['aln_title']}></td>
                                <td><{if $val['aln_update_time'] && $val['aln_update_time']>0}><{date('Y-m-d H:i',$val['aln_update_time'])}><{else}><{date('Y-m-d H:i',$val['aln_create_time'])}><{/if}></td>
                                <td>
                                    <{if $val['aln_push_time'] > 0}><{date('Y-m-d H:i',$val['aln_push_time'])}><{/if}>
                                </td>
                                <td>
                                    <p>
                                        <a href="/wxapp/legwork/noticeEdit/id/<{$val['aln_id']}>" >编辑</a> -
                                        <a href="#" id="delete-confirm" data-id="<{$val['aln_id']}>" onclick="deleteArticle('<{$val['aln_id']}>')" style="color:#f00;">删除</a>
                                    </p>
                                    <p>
                                        <a href="javascript:;" onclick="pushArticle('<{$val['aln_id']}>')" >推送骑手</a>
                                    </p>
                                </td>
                            </tr>
                            <{/foreach}>
                        <tr>
                            <!--
                            <td colspan="2">
                                <span class="btn btn-xs btn-name btn-change-cate btn-primary" >
                                        <a href="javascript:;" style="color: #fff" data-toggle="modal" data-target="#myModal" >批量修改分类</a>
                                    </span>
                                <span class="btn btn-xs btn-name btn-danger" >
                                        <a href="javascript:;" style="color: #fff" id="multi-delete">批量删除</a>
                                    </span>
                            </td>
                            -->
                            <td colspan="8"><{$pagination}></td></tr>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 350px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <input type="hidden" id="now_expire" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    修改分类
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="kind2" class="control-label">资讯分类：</label>
                    <div class="control-group" id="customCategory">
                        <select id="custom_cate" name="custom_cate" class="form-control">
                            <option value="0">无分类</option>
                            <{foreach $category_select as $key => $val}>
                            <option value="<{$key}>"><{$val}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="change-cate">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<div class="modal fade" id="tplPreviewModal" tabindex="-1" role="dialog" aria-labelledby="tplPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="overflow: auto; width: 500px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    推送预览
                </h4>
            </div>
            <div class="modal-body preview-page" style="overflow: auto">
                <div class="mobile-page ">
                    <div class="mobile-header"></div>
                    <div class="mobile-con">
                        <div class="title-bar">
                            消息模板预览
                        </div>
                        <!-- 主体内容部分 -->
                        <div class="index-con">
                            <!-- 首页主题内容 -->
                            <div class="index-main" style="height: 380px;">
                                <div class="message">
                                    <h3 id="tpl-title"></h3>
                                    <p class="date" id="tpl-date"></p>
                                    <div class="item-txt"  id="tpl-content">

                                    </div>
                                    <div class="see-detail">进入小程序查看</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mobile-footer"><span></span></div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/plugin/layui/jquery-ui-1.9.2.min.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script src="/public/plugin/sortable/sortable.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
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
        //$(".form-group-box .form-container").css("width",sumWidth+"px");

    });

    $('#confirm-bind').on('click',function(){
        var cid = $('#category-id').val();
        var sourceId = $('#article-source').val();
        var data = {
            cid : cid,
            sourceId : sourceId
        };
        if(cid && sourceId){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/currency/bindCategory',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });
        }else{
            layer.msg('请选择内容源');
        }
    });

    $('#change-cate').on('click',function(){
        var ids  = get_select_all_ids_by_name('ids');
        if(ids){
            var data = {
                'ids' : ids,
                'custom_cate': $('#custom_cate').val()
            };
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/currency/changeInformationCate',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });
        }
    });


    $('#multi-delete').on('click',function(){
        var ids  = get_select_all_ids_by_name('ids');
        if(ids){
            layer.confirm('确定删除所选文章？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                var data = {
                    'ids' : ids
                };
                console.log(data);
                var loading = layer.load(2);
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/currency/informationMultiDelete',
                    'data'  : data,
                    'dataType' : 'json',
                    success : function(ret){
                        layer.close(loading);
                        layer.msg(ret.em);
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    }
                });
            }, function(){

            });
        }else{
            layer.msg('请选择要删除的文章');
            return false;
        }
    });



    function searchWeixin(page=1) {
        var type = $('#search-type').val();
        var key = $('#search-key').val();
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        },{
            time : 10*1000
        });

        var data = {
            'type'  : type,
            'key' : key,
            'page': page
        };
        console.log(data);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/information/search',
            'data'  : data,
            'dataType' : 'json',
            success : function(ret){
                layer.close(index);
                var html = '';
                html += '<table class="table table-hover article-self-table"><tbody class="list-content">';
                var data = ret.data;
                for(var key in data){
                    html +='<tr><td class="padding-tr" style="width:50px;min-width:50px">' +
                        '<img class="article-circle-img" src="'+data[key]['round_head_img']+'"></td><td class="middle-div">' +
                        '<div class="gzh-middle-content"><span>'+data[key]['nickname']+'</span>' +
                        '</div></td>' +
                        '<td class="add-img-div">' +
                        '<img class="article-add-img" onclick="addWxapp(this)" data-cover="'+data[key]['round_head_img']+'" data-url="'+data[key]['url']+'" data-name="'+data[key]['nickname']+'"  data-wxno="'+data[key]['fakeid']+'" src="/public/wxapp/images/article_add.png">' +
                        '</td></tr>';
                }
                html += '</tbody></table>';
                $('#search-content').html(html);
                /*layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }*/
            }
        });
    }

    function removeGzh(id) {
        layer.confirm('确定删除文章源？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/information/removeGzh',
                'data'  : {id: id},
                'dataType' : 'json',
                success : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });
        }, function(){

        });
    }

    function addWxapp(elem) {
        var data = {
            'url' : $(elem).data('url'),
            'wxno': $(elem).data('wxno'),
            'name' : $(elem).data('name'),
            'cover': $(elem).data('cover'),
        }
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/information/addWxapp',
            'data'  : data,
            'dataType' : 'json',
            success : function(ret){
                layer.close(index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });

    };
    // 分类相关
    var app = angular.module('classifyApp', ['RootModule',"ui.sortable"]);
    app.controller('classifyCtrl',['$scope','$http','$timeout',function($scope,$http,$timeout){
        $scope.classifyList = [];
        $scope.addClassify = function(){
            var classify_length = $scope.classifyList.length;
            var defaultIndex = 0;
            if(classify_length>0){
                for (var i=0;i<classify_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.classifyList[i].index)){
                        defaultIndex = $scope.classifyList[i].index;
                    }
                }
                defaultIndex++;
            }
            if(classify_length>=10){
                layer.msg('最多只能添加10个分类');
            }else{
                var classify_Default = {
                    id: 0,
                    index: defaultIndex,
                    name: '分类名称'
                };
                $scope.classifyList.push(classify_Default);
                $scope.inpurClassify = '';
            }
            console.log($scope.classifyList);
        };
        /*获取真正索引*/
        $scope.getRealIndex = function(type,index){
            var resultIndex = -1;
            for(var i=0;i<type.length;i++){
                if(type[i].index==index){
                    resultIndex = i;
                    break;
                }
            }
            return resultIndex;
        };
        /*删除元素*/
        $scope.delIndex=function(type,index){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            realIndex = $scope.getRealIndex($scope[type],index);
            console.log(type+"-->"+realIndex);

            layer.confirm('您确定要删除吗？删除后该分类下的信息将不再显示', {
                title:'删除提示',
                btn: ['确定','取消']
            }, function(){
                $scope.$apply(function(){
                    $scope[type].splice(realIndex,1);
                });
                layer.msg('删除成功');
                $scope.saveCategory();
            });
        };

        $scope.bindSource = function(id) {
            $('#category-id').val(id);
            if($('.source'+id).length>0){
                $('.source'+id).attr("selected", true).siblings().removeAttr('selected');
            }else{
                $('.source-default').attr("selected", true).siblings().removeAttr('selected');
            }
        }

        // 保存分类数据
        $scope.saveCategory = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });

            var data = {
                'categoryList'  : $scope.classifyList
            };
            console.log(data);
            $http({
                method: 'POST',
                url:    '/wxapp/currency/saveCategory',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
        };


    }]);

    function pushArticle(id) {
        layer.confirm('确定要推送吗？', {
          btn: ['确定','取消'], //按钮
          title : '推送'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/legwork/noticePush',
                'data'  : { id:id},
                'dataType' : 'json',
                success : function(ret){
                    layer.msg(ret.em,{
                        time: 2000, //2s后自动关闭
                    },function(){
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        }, function(){

        });

    }

    function deleteArticle(id) {
        //var id = $(this).data('id');
       /* console.log(id);
        var load_index = layer.load(2,
            {
                shade: [0.1,'#333'],
                time: 10*1000
            }
        );*/
        /*$.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/currency/deletedInformation',
            'data'  : { id:id},
            'dataType'  : 'json',
            'success'  : function(ret){
                layer.close(load_index);
                if(ret.ec == 200){
                    window.location.reload();
                }else{
                    layer.msg(ret.em);
                }
            }
        });*/
        layer.confirm('确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/legwork/noticeDelete',
                'data'  : { id:id},
                'dataType' : 'json',
                success : function(ret){
                    layer.msg(ret.em,{
                        time: 2000, //2s后自动关闭
                    },function(){
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        });
    }

    function changeOpen() {
        var open   = $('#rewardOpen:checked').val();
        console.log(open);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/currency/saveShopReward',
            'data'  : { open:open == 'on' ? 1 : 0},
            'dataType'  : 'json',
            'success'   : function(ret){
                console.log(ret.em);
            }
        });
    }

    function showPreview(id) {
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/tplpreview/informationPreview',
            'data'  : {id:id},
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                if(ret.ec == 200){
                    $('#tpl-title').html(ret.data.title);
                    $('#tpl-date').html(ret.data.date);
                    var data = ret.data.tplData;
                    var html = '';
                    for(var i in data){
                        html += '<div>';
                        if(data[i]['emphasis'] != 1){
                            html += '<span class="title" >'+data[i]['titletxt']+'：</span>';
                            html += '<span class="text"  style="color:'+data[i]["color"]+'">'+data[i]['contxt']+'</span>';
                        }else{
                            html += '<span class="title" style="display: block;text-align: center">'+data[i]['titletxt']+'</span>';
                            html += '<span class="text" style="display: block;text-align: center;font-size: 20px"  style="color:'+data[i]["color"]+'">'+data[i]['contxt']+'</span>';
                        }
                        html += '</div>';
                    }
                    $('#tpl-content').html(html);
                }else{
                    layer.msg(ret.em);
                }

            }
        });
    }

</script>

