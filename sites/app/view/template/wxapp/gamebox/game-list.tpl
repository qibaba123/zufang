<link rel="stylesheet" href="/public/manage/css/bargain-list.css">

<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <a class="btn btn-green btn-xs" href="/wxapp/gamebox/editGame" id="add-new" ><i class="icon-plus bigger-80"></i>新增</a>
        </div><!-- /.page-header -->
        <div class="page-header search-box">
            <div class="col-sm-12">
                <form action="/wxapp/gamebox/gameList" method="get" class="form-inline">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">游戏名称</div>
                                    <input type="text" class="form-control" name="name" value="<{$name}>" placeholder="游戏名称">
                                </div>
                            </div>
                        </div>
                        <div class="form-container">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">游戏分类</div>
                                    <select name="category" id="category" class="form-control">
                                        <option value="0">全部</option>
                                        <{foreach $categorySelect as $val}>
                                    <option value="<{$val['id']}>" <{if $val['id'] == $category}>selected<{/if}>><{$val['name']}></option>
                                        <{/foreach}>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-1 pull-right search-btn" style="position: absolute;top: 18%;right: 2%;">
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
                            <th>游戏名称</th>
                            <th>游戏logo</th>
                            <th>游戏热度</th>
                            <th>排序权重</th>
                            <th>最近编辑</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['agg_id']}>">
                                <td><{$val['agg_name']}></td>
                                <td>
                                    <img src="<{if $val['agg_cover']}><{$val['agg_cover']}><{else}>/public/manage/img/zhanwei/fenleinav.png<{/if}>" style="width:100px" alt="">
                                </td>
                                <td><{$val['agg_num']}></td>
                                <td>
                                   <{$val['agg_sort']}>
                                </td>
                                <td><{date('Y-m-d H:i:s', $val['agg_update_time'])}></td>
                                <td>
                                    <a class="confirm-handle" href="/wxapp/gamebox/editGame?id=<{$val['agg_id']}>" ">编辑</a>
                                    <a data-id="<{$val['agg_id']}>" onclick="confirmDelete(this)" style="color:red;">删除</a>
                                </td>
                            </tr>
                            <{/foreach}>
                        <tr><td colspan="6"><{$pagination}></td></tr>
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

    function confirmDelete(ele) {
        layer.confirm('确定删除吗？', {
            title:'删除提示',
            btn: ['确定','取消'] //按钮
        }, function(){
            var id = $(ele).data('id');
            if(id){
                var loading = layer.load(2);
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/gamebox/deleteGame',
                    'data'  : { id:id},
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

    }

    /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                $('#'+nowId).attr('src',allSrc[0]);
                if(nowId == 'upload-cover'){
                    $('#category-cover').val(allSrc[0]);
                }
                if(nowId == 'brief-img'){
                    $('#brief-cover').val(allSrc[0]);
                }
            }else{
                var img_html = '';
                var cur_num = $('#'+nowId+'-num').val();
                for(var i=0 ; i< allSrc.length ; i++){
                    var key = i + parseInt(cur_num);
                    img_html += '<p>';
                    img_html += '<img class="img-thumbnail col" layer-src="'+allSrc[i]+'"  layer-pid="" src="'+allSrc[i]+'" >';
                    img_html += '<span class="delimg-btn">×</span>';
                    img_html += '<input type="hidden" id="slide_'+key+'" name="slide_'+key+'" value="'+allSrc[i]+'">';
                    img_html += '<input type="hidden" id="slide_id_'+key+'" name="slide_id_'+key+'" value="0">';
                    img_html += '</p>';
                }
                var now_num = parseInt(cur_num)+allSrc.length;
                if(now_num <= maxNum){
                    $('#'+nowId+'-num').val(now_num);
                    $('#'+nowId).prepend(img_html);
                }else{
                    layer.msg('幻灯图片最多'+maxNum+'张');
                }
            }
        }
    }
</script>