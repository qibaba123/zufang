<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "开启\a0\a0\a0\a0\a0\a0\a0\a0禁止";
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before{
        background-color: #D15B47;
        border: 1px solid #CC4E38;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked + .lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked + .lbl::before{
    	background-color: #06BF04;
        border-color:#06BF04;
    }

    .balance {
        padding: 10px 0;
        border-top: 1px solid #e5e5e5;
        background: #fff;
        zoom: 1;
    }
    .balance-info {
        text-align: center;
        padding: 0 15px 30px;
    }
    .balance .balance-info {
        float: left;
        width: calc(100% / 6);
        margin-left: -1px;
        padding: 0 15px;
        border-left: 1px solid #e5e5e5;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .balance .balance-info2 {
        width: 50%;
    }
    .balance .balance-info .balance-title {
        font-size: 14px;
        color: #999;
        margin-bottom: 10px;
    }
    .balance .balance-info .balance-title span {
        font-size: 12px;
    }
    .balance .balance-info .balance-content {
        zoom: 1;
    }
    .balance .balance-info .balance-content .money {
        font-size: 25px;
        color: #f60;
    }
    .balance .balance-info .balance-content span, .balance .balance-info .balance-content a {
        vertical-align: baseline;
        line-height: 26px;
    }
    .balance .balance-info .balance-content .unit {
        font-size: 12px;
        color: #666;
    }
    .pull-right {
        float: right;
    }
    .balance .balance-info .balance-content .money {
        font-size: 25px;
        color: #f60;
    }
    .balance .balance-info .balance-content .money-font {
        font-size: 20px;
    }

</style>
<div id="content-con">
    <div  id="mainContent" >
        <!--
        <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
            <div class="balance-info">
                <div class="balance-title">累计置顶帖子<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['total_zds']}></span>
                    <span class="unit"></span>
                </div>
            </div>
        </div>
        -->

        <div class="page-header">
            <a class="add-cost btn btn-green btn-xs" href="#" data-toggle="modal" data-target="#myModal"  data-id="" data-weight="" data-name=""><i class="icon-plus bigger-80"></i> 添加收费配置</a>
            <{if $is_show_ftcfg == 1}>
            <div style="display: inline-block;vertical-align:  middle;">
                　是否需要审核:
                <label id="choose-onoff" class="choose-onoff">
                    <input class="ace ace-switch ace-switch-5" id="discountOpen" data-type="open" onchange="dealShFb()" type="checkbox" <{if $ft_cfg['aci_post_audit']}>checked<{/if}>>
                    <span class="lbl"></span>
                </label>
            </div>
            <{/if}>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>天数</th>
                            <th>费用</th>
                            <th>更新时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['act_id']}>">
                                <td><{$val['act_data']}></td>
                                <td><{$val['act_cost']}></td>
                                <td><{date('Y-m-d H:i:s', $val['act_update_time'])}></td>
                                <td class="jg-line-color">
                                    <a class="confirm-handle" href="#" data-toggle="modal" data-target="#myModal"  data-id="<{$val['act_id']}>" data-name="<{$val['act_data']}>" data-weight="<{$val['act_cost']}>">编辑</a> -
                                    <a href="#" data-id="<{$val['act_id']}>" onclick="confirmDelete(this)" style="color: red">删除</a>
                                </td>
                            </tr>
                            <{/foreach}>
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
                    设置
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">天数：</label>
                    <div class="col-sm-8">
                        <input id="category-name" class="form-control" placeholder="请填写置顶天数" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">费用：</label>
                    <div class="col-sm-8">
                        <input id="category-weight" class="form-control" placeholder="请填写费用" style="height:auto!important"/>
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
    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#category-name').val($(this).data('name'));
        $('#category-weight').val($(this).data('weight'));
    });
    $('#confirm-category').on('click',function(){
        var id     = $('#hid_id').val();
        var date   = $('#category-name').val();
        var cost = $('#category-weight').val();
        var data = {
            id     : id,
            date   : date,
            cost   : cost
        };
        if(date){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/city/saveTopSet',
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
                    'url'   : '/wxapp/city/deleteTopSet',
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

    //发帖配置
    function dealShFb(obj){
        var v = $('#discountOpen:checked').val();
        console.log(v);
        var v = v == 'on' ? 1 : 0;
        console.log(v);
        var data = {
            'postAudit' : v
        }
        console.log(data);
        $.ajax({
            type: 'POST',
            url : '/wxapp/city/savePostCfgDD',
            data: data,
            dataType : 'json',
            success : function(res){
                if(res.ec == 400){
                    layer.msg(res.em,{ time : 2000 });
                }
            }
        });
    }

</script>