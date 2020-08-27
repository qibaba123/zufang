<link rel="stylesheet" href="/public/manage/css/bargain-list.css">

<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <a class="btn btn-green btn-xs" href="#" id="add-new" data-toggle="modal" data-target="#myModal"><i class="icon-plus bigger-80"></i>添加分类</a>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>分类名称</th>
                            <th>分类图片</th>
                            <th>分类权重</th>
                            <th>游戏数量</th>
                            <th>首页展示</th>
                            <th>添加时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['agc_id']}>">
                                <td><{$val['agc_name']}></td>
                                <td>
                                    <img src="<{if $val['agc_cover']}><{$val['agc_cover']}><{else}>/public/manage/img/zhanwei/fenleinav.png<{/if}>" style="width:100px" alt="">
                                </td>
                                <td><{$val['agc_sort']}></td>
                                <td><{if $val['gameCount'] > 0}><a href="/wxapp/gamebox/gameList?category=<{$val['agc_id']}>" style="color: blue" target="_blank"><{$val['gameCount']}></a><{/if}></td>
                                <td>
                                    <{if $val['agc_index_show']}>
                                    展示
                                    <{/if}>
                                </td>
                                <td><{date('Y-m-d H:i:s', $val['agc_update_time'])}></td>
                                <td>
                                    <a class="confirm-handle" href="#" data-toggle="modal" data-target="#myModal"  data-id="<{$val['agc_id']}>" data-name="<{$val['agc_name']}>" data-weight="<{$val['agc_sort']}>" data-cover="<{if $val['agc_cover']}><{$val['agc_cover']}><{else}>/public/manage/img/zhanwei/fenleinav.png<{/if}>" data-indexshow="<{$val['agc_index_show']}>" data-topimg="<{if $val['agc_top_img']}><{$val['agc_top_img']}><{else}>/public/manage/img/zhanwei/zw_fxb_750_180.png<{/if}>" data-indexshowType="<{$val['agc_index_show_type']}>">编辑</a>
                                    - <a href="/wxapp/gamebox/categoryDetail?id=<{$val['agc_id']}>">分类幻灯</a>
                                    - <a data-id="<{$val['agc_id']}>" onclick="confirmDelete(this)" style="color:red;">删除</a>
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    添加分类
                </h4>
            </div>
            <div class="modal-body" style="margin-left: 20px">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">分类图片：(建议尺寸200*200)</label>
                    <div class="col-sm-8">
                        <div>
                            <div>
                                <img onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="upload-cover" id="upload-cover"  src="/public/manage/img/zhanwei/zw_fxb_200_200.png"  width="200" height="200" style="display:inline-block;margin-left:0;width: 30%;height: 30%">
                                <input type="hidden" id="category-cover"  class="avatar-field bg-img" name="category-cover"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">分类名称：</label>
                    <div class="col-sm-8">
                        <input id="category-name" class="form-control" placeholder="请填写分类名称" style="height:auto!important"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">分类权重：</label>
                    <div class="col-sm-8">
                        <input id="category-weight" class="form-control" placeholder="数字越大，排序越靠前" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row" style="margin-bottom: 5px">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">首页展示：</label>
                    <div class="col-sm-6">
                        <div class="radio-box">
                                    <span>
                                        <input type="radio" name="indexShow" id="index_yes" value="1" >
                                        <label for="index_yes">是</label>
                                    </span>
                            <span>
                                        <input type="radio" name="indexShow" id="index_no" value="0" >
                                        <label for="index_no">否</label>
                                    </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-category">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script>
    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#category-name').val($(this).data('name'));
        $('#category-weight').val($(this).data('weight'));
        $('#category-cover').val($(this).data('cover'));
        $('#category-price').val($(this).data('price'));
        $('#upload-cover').attr('src',$(this).data('cover'));
        $('#upload-topimg').attr('src',$(this).data('topimg'));
        $('#topimg').val($(this).data('topimg'));
        $("input[name='indexShow']").removeProp('checked');
        var indexShow = $(this).data('indexshow');

        if(indexShow == 1){
            $('#index_yes').prop('checked',true);
        }else{
            $('#index_no').prop('checked',true);
        }
        $("input[name='indexShowType']").removeProp('checked');
        var indexShowType = $(this).data('indexshowtype');
        if(indexShowType){
            $('#index_type_'+indexShowType).prop('checked',true);
        }else{
            $('#index_type_1').prop('checked',true);
        }

    });

    $('#add-new').on('click',function () {
        $('#hid_id').val(0);
        $('#category-name').val('');
        $('#category-weight').val('');
        $('#category-cover').val('');
        $('#upload-cover').attr('src','/public/manage/img/zhanwei/zw_fxb_200_200.png');
        $('#topimg').val('');
        $('#upload-topimg').attr('src','/public/manage/img/zhanwei/zw_fxb_750_180.png');
        $("input[name='indexShow']").removeProp('checked');
        $('#index_yes').prop('checked',true);
        $('#index_type_1').prop('checked',true);
    });

    $('#confirm-category').on('click',function(){
        var id     = $('#hid_id').val();
        var name   = $('#category-name').val();
        var weight = $('#category-weight').val();
        var cover  = $('#category-cover').val();
        var topimg = $('#topimg').val();
        var indexShow = $("input[name='indexShow']:checked").val();
        var indexShowType = $("input[name='indexShowType']:checked").val();
        var data = {
            id     : id,
            name   : name,
            weight : weight,
            cover  : cover,
            topimg : topimg,
            indexShow : indexShow,
            indexShowType: indexShowType
        };
        console.log(data);
        if(name){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/gamebox/saveCategory',
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
                    'url'   : '/wxapp/gamebox/deleteCategory',
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
                if(nowId == 'upload-topimg'){
                    $('#topimg').val(allSrc[0]);
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