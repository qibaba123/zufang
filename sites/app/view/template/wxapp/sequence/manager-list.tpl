<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/ajax-page.css">

<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <a href="/wxapp/sequence/managerEdit" class="btn btn-sm btn-green"><i class="icon-plus bigger-80"></i>添加合伙人</a>
        </div><!-- /.page-header -->
        <div class="page-header search-box">
            <div class="col-sm-12">
                <form class="form-inline" action="/wxapp/sequence/managerList" method="get">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container" style="width: auto !important;">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">姓名</div>
                                    <input type="text" class="form-control" name="name" value="<{$name}>"  placeholder="姓名">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">电话</div>
                                    <input type="text" class="form-control" name="mobile" value="<{$mobile}>"  placeholder="电话">
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
                            <th>姓名</th>
                            <th>上级姓名</th>
                            <th>电话</th>
                            <th>分佣比例</th>
                            <th>更新时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['esm_id']}>">
                                <td>
                                    <{$val['esm_nickname']}>
                                </td>
                                <td>
                                    <{$val['parentName']}>
                                </td>
                                <td>
                                    <{$val['esm_mobile']}>
                                </td>
                                <td><{$val['esm_percent']}>%</td>
                                <td><{date('Y-m-d H:i:s', $val['esm_update_time'])}></td>
                                <td>
                                    <a href="/wxapp/sequence/managerEdit?id=<{$val['esm_id']}>" >编辑</a>
                                     - <a href="/wxapp/sequence/managerDeductRecord?id=<{$val['esm_id']}>">佣金详情</a>
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
<{include file="../fetch-leader-modal.tpl"}>
<script>


    function confirmDelete(ele) {
        layer.confirm('确定删除吗？', {
            title:'提示',
            btn: ['确定','取消'] //按钮
        }, function(){
            var id = $(ele).data('id');
            if(id){
                var loading = layer.load(2);
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/sequence/communityDelete',
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

    function removeLeader(ele) {
        layer.confirm('确定取消关联吗？', {
            title:'提示',
            btn: ['确定','取消'] //按钮
        }, function(){
            var id = $(ele).data('id');
            var leaderId = $(ele).data('leaderid');
            
            if(id){
                var loading = layer.load(2);
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/sequence/removeCommunityLeader',
                    'data'  : { id:id,leaderId:leaderId},
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