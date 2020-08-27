<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<div class="page-header search-box">
    <div class="col-sm-12">
        <form class="form-inline" action="/wxapp/meeting/record" method="get">
            <div class="col-xs-11 form-group-box">
                <input type="hidden" name="id" value="<{$id}>"/>
                <input type="hidden" name="type" value="<{$type}>"/>
                <div class="form-container">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">用户昵称</div>
                            <input type="text" class="form-control" name="nickname" value="<{$nickname}>"  placeholder="用户昵称">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">手机号</div>
                            <input type="text" class="form-control" name="mobile" value="<{$mobile}>"  placeholder="手机号">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">核销码</div>
                            <input type="text" class="form-control" name="code" value="<{$code}>"  placeholder="手机号">
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
<div id="content-con">
    <div  id="mainContent" >
        <div class="choose-state">
            <a href="/wxapp/meeting/record?type=0&id=<{$id}>" <{if $type eq 0}> class="active" <{/if}>>全部</a>
            <a href="/wxapp/meeting/record?type=1&id=<{$id}>" <{if $type eq 1}> class="active" <{/if}>>中奖</a>
            <a href="/wxapp/meeting/record?type=2&id=<{$id}>" <{if $type eq 2}> class="active" <{/if}>>未中奖</a>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>头像</th>
                            <th>昵称</th>
                            <th>手机号</th>
                            <th>奖品图片</th>
                            <th>奖品名称</th>
                            <th>中奖/参与时间</th>
                            <th>处理结果</th>
                            <th>兑换码</th>
                            <th>备注</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['amr_id']}>">
                                <td><img src="<{$val['m_avatar']}>" alt="" style="width: 50px"/></td>
                                <td><{$val['m_nickname']}></td>
                                <td><{$val['m_mobile']}></td>
                                <td><img src="<{$val['amr_img']}>" alt="" style="width: 50px"/></td>
                                <td><{$val['amr_name']}></td>
                                <td>
                                    <{if $val.amr_type==1}>
                                    <span class='text-success'>  <{date('Y/m/d H:i:s',$val.amr_create_time)}></span>
                                    <{else}>
                                    <span class='text-warning'>  <{date('Y/m/d H:i:s',$val.amr_create_time)}></span>
                                    <{/if}>
                                </td>
                                <td>
                                    <{if $val['amr_status'] == 0 && $val['amr_type'] == 1 }>
                                    未核销
                                    <{else}>
                                    <p>已核销</p>
                                    <p><{if $val.amr_deal_time != ''}><{date('Y/m/d H:i:s',$val.amr_deal_time)}><{/if}></p>
                                    <{/if}>
                                </td>
                                <td><{$val['amr_code']}></td>
                                <td>
                                    <{if $val['amr_note']}><{$val['amr_note']}><{else}>无<{/if}>
                                </td>
                                <td>
                                    <{if $val['amr_status'] == 0 && $val['amr_type'] == 1}>
                                    <a class="btn btn-green btn-xs" href="#" data-toggle="modal" data-id="<{$val['amr_id']}>" onclick="deal(this)" data-target="#myModal">核销</a>
                                    <{else}>
                                    <a class="btn btn-default btn-xs" href="javascript:;" disabled >已核销</a>
                                    <{/if}>
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    处理
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">备注：</label>
                    <div class="col-sm-8">
                        <textarea name="" id="note" cols="30" rows="10" class="form-control"></textarea>
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
<{$cropper['modal']}>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script>

    function deal(e){
        $('#hid_id').val($(e).data('id'));
    }

    $('#confirm-category').on('click',function(){
        var id     = $('#hid_id').val();
        var note   = $('#note').val();
        var data = {
            id     : id,
            note   : note
        };
        if(id){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/meeting/dealLottery',
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
</script>
