<style>
    .page-content {
        background-color: #f5f5f5;
    }

    .block-content {
        margin: 0 auto;
        padding: 20px 20px 1px;
        max-width: 100%;
        overflow-x: visible;
        -webkit-transition: opacity 0.2s ease-out;
        transition: opacity 0.2s ease-out;
        background: #fff;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .content-grid {
        margin-bottom: 24px;
    }

    .content-grid .row {
        margin-left: -3px;
        margin-right: -3px;
    }

    .content-grid .row > div[class*="col"] {
        padding-left: 3px;
        padding-right: 3px;
    }

    .img-rounded {
        border-radius: 4px;
    }

    .p-l-m {
        padding-left: 20px !important;
    }

    .block-content p, .block-content .push, .block-content .block, .block-content .items-push > div {
        margin-bottom: 20px;
    }

    .text-danger {
        color: #d26a5c;
    }

    .font-s14 {
        font-size: 14px !important;
    }

    .m-l-md {
        margin-left: 20px !important;
    }
    .table tbody tr td {
        white-space: inherit;
    }
</style>

<div class="block-content">
    <div class="content-grid">
        <div class="row">
            <div class="col-xs-2" style="width: 12%">
                <img src="<{$goods['g_cover']}>" class="img-rounded" style="width:100%;">
            </div>
            <div class="col-xs-8 p-l-m">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="h3" style="margin-bottom: 20px"><{$goods['g_name']}></div>
                        <p class="p-t-xs"><em><{$goods['g_brief']}></em></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <{if $goods['g_type'] == 4 || $goods['g_type'] == 5}>
                        <div class="text-danger font-s14"><{$goods['g_points']}>积分</div>
                        <{else}>
                        <div class="text-danger font-s14">￥<{$goods['g_price']}></div>
                        <{/if}>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="font-s14" style="margin-top: 20px">订阅量: <{$goods['g_sold']}></div>
                    </div>
                </div>
            </div>
            <div class="col-xs-2">
                <div class="row">
                    <div class="col-xs-12 ">
                        <div class="pull-right">
                            <div class="btn-group btn-group-sm">
                                <a href="/wxapp/knowledgepay/addGoods/?id=<{$goods['g_id']}>" class="btn btn-default" data-toggle="tooltip" title="" data-original-title="编辑专栏"><i class="icon-edit"></i> 编辑</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<a href="/wxapp/knowledgepay/addGoodsKnowledge/type/<{$goods['g_knowledge_pay_type']}>/gid/<{$goods['g_id']}>" class="btn btn-green btn-xs"><i class="icon-plus bigger-80"></i> 新增</a>
<div class="row" style="background: #fff;padding: 20px 0;margin: 20px 0px;">
    <div class="col-xs-12">
        <div class="fixed-table-box" style="margin-bottom: 30px;">
            <div class="fixed-table-header">
                <table class="table table-striped table-hover table-avatar">
                    <thead>
                    <tr>
                        <th class="center" style="width: 20%">
                            <label>
                                <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                <span class="lbl"></span>
                            </label>
                        </th>
                        <th style="width: 20%">课程名称</th>
                        <th style="width: 20%">访问量</th>
                        <th style="width: 20%">
                            <i class="icon-time bigger-110 hidden-480"></i>
                            最近更新
                        </th>

                        <th style="width: 20%">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach $list as $val}>
                        <tr id="tr_<{$val['akk_id']}>">
                            <td class="center">
                                <label>
                                    <input type="checkbox" class="ace" name="ids" value="<{$val['akk_id']}>"/>
                                    <span class="lbl"></span>
                                </label>
                            </td>
                            <td>
                                <{if mb_strlen($val['akk_name']) > 20 }><{mb_substr($val['akk_name'],0,20)}>
                                <{mb_substr($val['akk_name'],20,40)}><{else}><{$val['akk_name']}><{/if}>
                            </td>
                            <td><{$val['akk_read_num']}></td>
                            <td><{date('Y-m-d H:i:s', $val['akk_create_time'])}></td>
                            <td>
                                <a href="/wxapp/knowledgepay/addGoodsKnowledge/?id=<{$val['akk_id']}>&type=<{$goods['g_knowledge_pay_type']}>&gid=<{$goods['g_id']}>" >编辑</a>-
                                <a href="javascript:;" class="btn-del" data-kid="<{$val['akk_id']}>" >删除</a>
                            </td>
                        </tr>
                        <{/foreach}>
                    <tr><td colspan="5" style="text-align:right"><{$paginator}></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- /span -->
</div><!-- /row -->

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script>
    $('.btn-del').on('click',function(){
        var data = {
            'id' : $(this).data('kid')
        };
        if(data.id > 0){
            layer.confirm('删除后会有其他影响，您是确定要删除吗？', {
                btn: ['删除','暂不删除'] //按钮
            }, function(){
                var index = layer.load(10, {
                    shade: [0.6,'#666']
                });
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/knowledgepay/delGoodsKnowledge',
                    'data'  : data,
                    'dataType' : 'json',
                    'success'   : function(ret){
                        layer.close(index);
                        layer.msg(ret.em);
                        if(ret.ec == 200 ){
                            $('#tr_'+data.id).hide();
                        }
                    }
                });
            });
        }else{
            layer.msg('参数错误');
        }
    });
</script>