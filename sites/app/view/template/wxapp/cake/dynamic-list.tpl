<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<div class="page-header">
    <a class="btn btn-green btn-xs" href="/wxapp/cake/addStoreDynamic" ><i class="icon-plus bigger-80"></i>动态添加</a>
    <button class="btn btn-green btn-xs" style="margin-left: 10px" data-toggle="modal" data-target="#myModal" onclick="addNotice()"><i class="icon-plus bigger-80"></i>动态设置</button>
</div>
<div id="content-con">
    <div  id="mainContent" >
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>序号</th>
                            <th>添加时间</th>
                            <th>点赞数</th>
                            <th>评论数</th>
                            <th>是否已推送</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['id']}>">
                                <td><{$val['num']}></td>
                                <td><{date('Y-m-d', $val['startTime'])}></td>
                                <td><{$val['fabulous']}></td>
                                <td><{$val['comment']}></td>
                                <td><{if $val['push']}>已推送<{else}><span style="color:#333;">未推送</span><{/if}></td>
                                <td class="jg-line-color">
                                	<{if !$val['push']}>
                                    <a href="javascript:;" onclick="pushDynamic('<{$val['id']}>')" >推送</a> - 
                                    <{/if}>
                                    <a href="/wxapp/cake/addStoreDynamic?id=<{$val['id']}>" >编辑</a>
                                     - <a href="#" data-id="<{$val['id']}>" onclick="confirmDelete(this)" style="color:#f00;">删除</a>                                   
                                </td>
                            </tr>
                        <{/foreach}>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
                <{$paginator}>
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    动态设置
                </h4>
                <input type="hidden" id="notice_id" value="">
            </div>
            <div class="modal-body">
                <div id="buy-template" style="padding: 10px 25px">
                    <div class="form-group row">
                        <label class="col-sm-2 control-label no-padding-right" for="qq-num">店铺标签：</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="store_sign" placeholder="请输入店铺标签" value="<{if $row}><{$row['aci_dynamic_sign']}><{/if}>"/>
                            <input type="hidden" class="form-control" id="store_id" value="<{if $row}><{$row['aci_id']}><{/if}>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label no-padding-right" for="qq-num">背景图：</label>
                        <div class="cropper-box" data-width="750" data-height="360">
                            <img src="<{if $row && $row['aci_dynamic_bg']}><{$row['aci_dynamic_bg']}><{else}>/public/manage/img/zhanwei/zw_fxb_750_320.png<{/if}>" id="source_img" width="100" style="display:inline-block;margin-left:2%;"><a href="javascript:void(0)" style="display: inline;color:blue;font-size:14px;vertical-align: bottom;position: relative;left:5px;">门店动态页面顶部背景图</a>
                            <p><small style="font-size: 12px;color:#999;margin-left: 20%">建议尺寸:750*360</small></p>
                            <input type="hidden" id="source_background" class="avatar-field source-img" ng-model="cover" name="source_image" value="<{if $row && $row['aci_dynamic_bg']}><{$row['aci_dynamic_bg']}><{/if}>"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-primary" id="conform-update">
                        确认修改
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<{include file="../img-upload-modal.tpl"}>
<script>
    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#category-name').val($(this).data('name'));
        console.log($(this).data('cover'));
    });
    function confirmDelete(ele) {
        var id = $(ele).data('id');
        if(id){
            layer.confirm('确定要删除吗？', {
                title:'删除提示',
                btn: ['确定','取消'] //按钮
            }, function(){
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/smartstore/delDynamic',
                    'data'  : { id:id},
                    'dataType' : 'json',
                    success : function(ret){
                        layer.msg(ret.em);
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    }
                });
            });
        }
    }

    function pushDynamic(id) {
        layer.confirm('确定要推送吗？', {
          btn: ['确定','取消'], //按钮
          title : '推送'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/tplpush/dynamicPush',
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

    function addNotice(){
        $('#notice_id').val('');
        $('#username').val('');
        $('#mobile').val('');
        $('#password').val('');
    }
    $('#conform-update').on('click',function () {
        //var id = $('#store_id').val();
        var sign = $('#store_sign').val();
        var background = $('#source_background').val();
        var data = {
            //id             : id,
            sign           : sign,
            background     : background,
        };
        var load_index = layer.load(2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );
        console.log(data);
        $.ajax({
            'type'      : 'post',
            'url'       : '/wxapp/cake/storeCfgSave',
            'data'      : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });

    })
</script>