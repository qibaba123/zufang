<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style type="text/css">

    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "开启\a0\a0\a0\a0\a0\a0\a0\a0禁止";
    }

    #goods-tr td{
        padding:8px 5px;
        border-bottom:1px solid #eee;
        cursor: pointer;
        text-align: center;
        vertical-align: middle;
    }
    #goods-tr td p{
        margin:0;
    }
    #goods-tr td img{
        width: 60px;
        height: 60px;
    }
    #goods-tr td p.g-name{
        margin:0;
        padding:0;
        height: 30px;
        line-height: 30px;
        max-width: 400px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        color: #38f;
        font-family: '黑体';
    }
    .pull-right>.btn{
        margin-left: 6px;
    }
    .center{
        text-align: center;
    }
    .form-group{
        margin-bottom: 10px;
    }
    .form-group .control-label[class*="col-"] {
        line-height: 36px;
        margin: 0;
        padding: 0;
        text-align: right;
        font-weight: bold;
    }
    .form-group .price{
        line-height: 36px;
        color: red;
        font-weight: bold;
    }
    .package-cover{
        height: 50px;
    }

    .vip-dialog__viptable td {
        border: 1px solid #e5e5e5;
        border-left: none;
        padding: 5px;
        height: 40px;
    }

    .vip-dialog__viptable .td-discount {
        width: 110px;
        text-align: center;
    }

    .vip-dialog__viptable .mini-input input {
        width: 54px;
        min-width: 0;
        padding: 3px 7px;
    }

    .vip-dialog__viptable .td-discount__unit {
        display: inline-block;
        margin-left: 10px;
    }

    .vip-dialog__viptable_head th{
        text-align: center;
        padding-bottom: 15px;
    }

</style>

<div id="content-con">
    <div  id="mainContent">
        <div class="page-header">
            <a href="/wxapp/train/addCourse" class="btn btn-green btn-xs" style="padding-top: 2px;padding-bottom: 2px;"><i class="icon-plus bigger-80"></i> 新增</a>
            <a href="#" class="btn btn-blue btn-xs" style="padding-top: 2px;padding-bottom: 2px;" data-toggle="modal" data-target="#myModal">标题配置</a>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                        	<th>封面图</th>
                            <th>课程标题</th>
                            <th>分类</th>
                            <th>价格</th>
                            <th>原价</th>
                            <th>报名人数</th>
                            <th>添加时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr>
                            	<td><img src="<{$val['atc_cover']}>" alt="封面图" class="package-cover" style="border-radius:4px;"></td>
                                <td><{$val['atc_title']}></td>
                                <td><{$val['atc_type_name']}></td>
                                <td><{$val['atc_price']}></td>
                                <td><{$val['atc_ori_price']}></td>
                                <td><{$val['atc_apply']}></td>        
                                <td><{date('Y-m-d H:i',$val['atc_create_time'])}></td>
                                <td class="jg-line-color">
                                    <p>
                                        <a href="/wxapp/train/addCourse/id/<{$val['atc_id']}>">编辑</a> -
                                        <a href="#" class="now-delete" data-id="<{$val['atc_id']}>" style="color:#f00;">删除</a>
                                    </p>
                                    <p>
                                        <{if $val['editVipPrice'] == 1}>
                                        <a href="javascript:;" onclick="showVipPriceModal(<{$val['atc_id']}>)">会员价</a>
                                        <{/if}>
                                    </p>
                                </td>
                            </tr>
                            <{/foreach}>
                        <{if $pageHtml}>
                            <tr><td colspan="13"><{$pageHtml}></td></tr>
                            <{/if}>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
    </div>
</div>
<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 460px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    标题配置
                </h4>
                <input type="hidden" id="post_id" value="">
                <input type="hidden" id="post_cate_old" value="">
                <input type="hidden" id="category_level" value="">
            </div>
            <div class="modal-body">
                <div id="buy-template">
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num">预约项目：</label>
                        <div class="col-sm-6">
                            <input type="text" maxlength="4" class="form-control" name="appo_title" id="appo_title" placeholder="请输入预约项目标题" value="<{if $indexCfg['ati_appo_title']}><{$indexCfg['ati_appo_title']}><{else}>所选课程<{/if}>">
                        </div>
                    </div>
                    <!--<div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num">课程详情：</label>
                        <div class="col-sm-6">
                            <input type="text" maxlength="10" class="form-control" name="detail_title" id="detail_title" placeholder="请输入课程详情标题" value="<{if $indexCfg['ati_detail_title']}><{$indexCfg['ati_detail_title']}><{else}>课程介绍<{/if}>">
                        </div>
                    </div>-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-primary" id="conform-update">
                        保存
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</div>
<div class="modal fade" id="vipPriceModal" tabindex="-1" role="dialog" aria-labelledby="vipPriceModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="overflow: auto; width: 900px">
        <div class="modal-content">
            <input type="hidden" id="vip-price-type" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    自定义会员价
                </h4>
            </div>
            <div class="modal-body" style="overflow: auto" >
                <div id="vip-price-edit">

                </div>
                <div class="form-group" style="margin-top: 10px">
                    <label class="control-label">是否显示会员价：</label>
                    <div class="control-group" style="display: inline-block;">
                        <label style="padding: 4px 0;margin: 0;">
                            <input name="g_show_vip" class="ace ace-switch ace-switch-5" id="g_show_vip" type="checkbox">
                            <span class="lbl"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="save-vip-price">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script>

    $(".now-delete").click(function(){
        var id = $(this).data('id');
        if(id){
            var load_index = layer.load(2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
            );
            $.ajax({
                'type'   : 'post',
                'url'   : '/wxapp/train/deleteCourse',
                'data'  : { id:id},
                'dataType'  : 'json',
                'success'  : function(ret){
                    layer.close(load_index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });
        }
    });

    $('#conform-update').on('click',function () {
        var appo_title = $('#appo_title').val();
        var detail_title = $('#detail_title').val();

        if(!appo_title || !detail_title){
            layer.msg('标题不能为空');
            return false;
        }
            var data = {
                detail_title : detail_title,
                appo_title : appo_title,
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
                'url'       : '/wxapp/train/updateTitle',
                'data'      : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.close(load_index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
//                        window.location.reload();
                    }
                }
            });

    });

    function showVipPriceModal(id) {
        // 先判断是否添加了会员等级
        var levelCount = '<{$levelCount}>';
        console.log(levelCount);
        if(levelCount<1){
            layer.msg('请先添加会员等级才能使用此功能');
            return false;
        }

        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/train/getVipPrice',
            'data'  : {id:id},
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                $('#vip-price-type').val(ret.type);
                if(ret.showVip == 1){
                    $('#g_show_vip').prop("checked", true);
                }else{
                    $('#g_show_vip').prop("checked", false);
                }

                $html = '';
                $html += '<table><thead class="vip-dialog__viptable_head">';
                $html += '<tr>';
                for(var i in ret.formatName){
                    $html +=  '<th class="sku"><div class="tdwrap1">'+ret.formatName[i]+'</div></th>';
                }
                $html +=  '<th class="sku"><div class="tdwrap1">正常售价</div></th>';
                for(var i in ret.data[0]['vipPrice']){
                    $html += '<th><div class="tdwrap2">'+ret.data[0]['vipPrice'][i]['name']+'</div></th>';
                }
                $html += '</tr></thead>';
                $html += '<tbody class="vip-dialog__viptable">';
                for(var i in ret.data){
                    $html += '<tr>';
                    if(ret.data[i]['name1']){
                        $html += '<td><div class="td-sku" id="normal-price" style="width: 110px;text-align: center">'+ret.data[i]['name1']+'</div></td>';
                    }
                    if(ret.data[i]['name2']){
                        $html += '<td><div class="td-sku" id="normal-price" style="width: 110px;text-align: center">'+ret.data[i]['name2']+'</div></td>';
                    }
                    if(ret.data[i]['name3']){
                        $html += '<td><div class="td-sku" id="normal-price" style="width: 110px;text-align: center">'+ret.data[i]['name3']+'</div></td>';
                    }
                    $html += '<td><div class="td-sku" id="normal-price" style="width: 110px;text-align: center">￥'+ret.data[i]['price']+'</div></td>';
                    for(var n in ret.data[i]['vipPrice']){
                        $html += '<td class=""><div class="td-discount">' +
                            '<div class="zent-number-input-wrapper mini-input" style="display: inline-block">' +
                            '<div class="zent-input-wrapper mini-input">' +
                            '<input type="text" class="form-control vip-price-value" style="display: inline-block" data-id='+ret.data[i]['vipPrice'][n]['id']+' data-lid='+ret.data[i]['vipPrice'][n]['lid']+' value="'+ret.data[i]['vipPrice'][n]['price']+'"></div></div>' +
                            '<span class="td-discount__unit">元</span></div></td>';
                    }
                    $html += '</tr>';
                }
                $html += '</tbody></table>';
                $('#vip-price-edit').html($html);
                $('#vipPriceModal').modal('show');
            }
        });
    }

    $('#save-vip-price').click(function () {
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        var type = $('#vip-price-type').val();
        var showVip = $('#g_show_vip').is(':checked');
        var data = [];
        $('.vip-price-value').each(function(index, element) {
            data[index] = {
                'id' : $(element).data('id'),
                'identity' : $(element).data('lid'),
                'price' : $(element).val(),
            };
        });
        console.log(showVip);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/train/saveVipPrice',
            'data'  : {data:data, type: type, showVip: showVip},
            'dataType' : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    layer.msg(ret.em);
                    layer.close(index);
                    $('#vipPriceModal').modal('hide');
                }
            }
        });
    });

</script>