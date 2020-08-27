<style>
    .form-group-box{
        overflow: auto;
    }
    .form-group-box .form-group{
        width: 260px;
        margin-right: 10px;
        float: left;
    }
</style>
<div ng-app="Withdraw"  ng-controller="WithdrawList">
    <div class="alert alert-block alert-success">
        <ol>
            <li><small>模版消息，来自微信公众平台-小程序“<a href="javascritp:;" class="xxmb-bnt">查看位置</a>”里面的功能－模版消息，请至<a href="https://mp.weixin.qq.com/" target="_blank"> 微信公众平台 </a>添加更多模版消息</small></li>
            <li style="padding-top: 5px">
                <!--<small>模板消息教程：<a href="http://bbs.tiandiantong.net/forum.php?mod=viewthread&tid=361&extra=page%3D2" class="xxmb-bnt" target="_blank">http://bbs.tiandiantong.net/forum.php?mod=viewthread&tid=361&extra=page%3D2</a></small>-->
                <!--<small style="padding-left: 20px"><a href="http://bbs.tiandiantong.net/forum.php?mod=viewthread&tid=361&extra=page%3D2" style="color: red;" target="_blank">查看图文教程</a></small>-->
            </li>
        </ol>
    </div>
    <div class="page-header" style="overflow:hidden">
        <div class="col-sm-6">
            <a class="btn btn-green btn-sm refresh-btn" href="javascript:;">
                <i class="icon-refresh bigger-40"></i>  消息模版同步
            </a>
        </div>
        <div style="float: right;">
            <a class="btn btn-green btn-sm" href="/wxapp/tplmsg/tplmsgSetup" style="padding: 5px 20px;">
                消息发送设置
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="sample-table-1" class="table table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-480">模版ID</th>
                        <th>标题</th>
                        <th>操作</th>
                    </tr>
                    </thead>

                    <tbody>
                    <{foreach $list as $val}>
                        <tr id="tr_<{$val['awt_tplid']}>">
                            <td><{$val['awt_tplid']}></td>
                            <td><{$val['awt_title']}></td>
                            <td class="jg-line-color">
                                <a href="/wxapp/tplmsg/tplmsgList/?tplid=<{$val['awt_tplid']}>">
                                    管理
                                </a>
                                 - <a href="javascript:;" class="deal-audit"
                                   data-title="<{$val['awt_title']}>"
                                   data-example='<{$val['awt_example']}>'
                                   data-industry2='<{$val['awt_industry2']}>'>
                                    示例
                                </a>
                                 - <a href="javascript:;" class="del-btn"
                                   data-id="<{$val['awt_tplid']}>" style="color:#f00;">
                                    删除
                                </a>
                            </td>
                        </tr>
                    <{/foreach}>
                    <{if $pageHtml}>
                        <tr><td colspan="5"><{$pageHtml}></td></tr>
                    <{/if}>
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
        </div><!-- /span -->
    </div><!-- /row -->
    <div id="withdraw-form"  class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">消息模版示例</h4>
                </div>
                <div class="modal-body">
                    <div style="padding: 20px">
                        <h4 id="h1Title"></h4>
                        <p><small>10-18</small><p>
                        <p id="example"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <span id="saveResult" ng-model="saveResult" class="text-center"></span>
                    <button type="button" class="btn btn-primary modal-save" >知道了</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>


<script type="text/javascript" src="/public/plugin/layer/layer.js" ></script>
<script type="text/javascript" src="/public/manage/controllers/withdraw-list.js" ></script>

<script type="text/javascript" language="javascript">
    $('.deal-audit').on('click',function(){
        $('#h1Title').text($(this).data('title'));
        $('#example').html($(this).data('example'));
        $('#withdraw-form').modal('show');
    });
    $('.modal-save').on('click',function(){
        $('#withdraw-form').modal('hide');
    })
    $('.xxmb-bnt').on('click',function(){
        layer.open({
            type: 1,
            title: false,
            closeBtn: 1,
            area: '516px',
            shadeClose: true,
            content: '<img src="/public/manage/img/helper/WX20171102-190708.png" width="500px">'
        });
    });
    $('.refresh-btn').on('click',function(){
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        },{time:10*1000});

        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/tplmsg/refreshTpl',
            'dataType'  : 'json',
            success : function(json_ret){
                layer.close(index);
                layer.msg(json_ret.em);

                if(json_ret.ec == 200){
                    window.location.reload();
                }
            }

        })
    });
    $('.del-btn').on('click',function(){
        var tplId = $(this).data('id');
    	layer.confirm('确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            var data = {
	            'tplId' : tplId
	        };
	        var index = layer.load(1, {
	            shade: [0.1,'#fff'] //0.1透明度的白色背景
	        },{time:10*1000});
	
	        $.ajax({
	            'type'  : 'post',
	            'url'   : '/wxapp/tplmsg/deleteTpl',
	            'data'  : data,
	            'dataType'  : 'json',
	            success : function(json_ret){
	                layer.close(index);
	                layer.msg(json_ret.em);
	
	                if(json_ret.ec == 200){
	                    $('#tr_'+data.tplId).hide();
	                }
	            }
	
	        })
        });

    });


</script>
