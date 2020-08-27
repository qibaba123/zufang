<link rel="stylesheet" href="/public/manage/css/bargain-list.css">

<div id="content-con">
    <div  id="mainContent" ng-app="ShopIndex"  ng-controller="ShopInfoController">
        <div class="page-header">
            <a href="/wxapp/currency/addArticle" class="btn btn-green btn-xs" style="padding-top: 2px;padding-bottom: 2px;"><i class="icon-plus bigger-80"></i> 新增</a>
        </div><!-- /.page-header -->
        <div class="choose-state">
            <!--
            <button class="pull-right btn btn-danger btn-xs" style="margin-top: 5px;margin-right: 10px;">
                <i class="icon-remove"></i> 删除所选<span id="choose-num">(12)</span>
            </button>
            -->
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th class="center">
                                <label>
                                    <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                    <span class="lbl"></span>
                                </label>
                            </th>
                            <th>标题</th>
                            <th>封面图</th>
                            <th>简介</th>
                            <th>
                                <i class="icon-time bigger-110 hidden-480"></i>
                                最近更新</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr>
                                <td class="center">
                                    <label>
                                        <input type="checkbox" class="ace" name="ids" value="<{$val['aa_id']}>"/>
                                        <span class="lbl"></span>
                                    </label>
                                </td>
                                <td><{$val['aa_title']}></td>
                                <td><img src="<{$val['aa_cover']}>" width="50"></td>
                                <td style="white-space: normal;min-width:290px;"><{$val['aa_brief']}></td>
                                <td><{date('Y-m-d H:i',$val['aa_create_time'])}></td>
                                <td class="jg-line-color">
                                    <a href="/wxapp/currency/addArticle/id/<{$val['aa_id']}>" >编辑</a> -
                                    <a href="#" id="delete-confirm" data-id="<{$val['aa_id']}>" onclick="deleteArticle('<{$val['aa_id']}>')" style="color:#f00;">删除</a>
                                </td>
                            </tr>
                            <{/foreach}>
                        <tr><td colspan="7"><{$pagination}></td></tr>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>
    function deleteArticle(id) {
        //var id = $(this).data('id');
        console.log(id);
        var load_index = layer.load(2,
            {
                shade: [0.1,'#333'],
                time: 10*1000
            }
        );
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/currency/deletedArticle',
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
        });
    }
</script>

