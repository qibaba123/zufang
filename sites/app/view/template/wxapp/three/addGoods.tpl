<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<style>
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "开启\a0\a0\a0\a0\a0\a0\a0\a0禁止";
    }
    .chosen-container {
        width: 100%!important;
    }
    .chosen-container-multi .chosen-choices{
        padding: 3px 5px 2px!important;
        border-radius: 4px;
        border: 1px solid #ccc;
    }
    .chosen-container-single .chosen-single{
        padding: 3px 5px 2px!important;
        border-radius: 4px;
        border: 1px solid #ccc;
        height: 34px;
        background: url();
        background-color: #fff;
    }
    .chosen-container-single .chosen-single span{
        margin-top: 2px;
    }
    .chosen-single div b:before{
        top:3px;
    }
    select.form-control {
        padding: 5px 6px;
        height: 34px;
    }
</style>
<{include file="../common-second-menu.tpl"}>
<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <a class="btn btn-green btn-xs fxGoods" href="#"><i class="icon-plus bigger-80"></i>添加单品分销</a>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th><{$goodsName}>名称</th>
                            <th>购买人返现比例</th>
                            <th>上级提成比例</th>
                            <{if $threeSale > 1}>
                            <th>二级提成比例</th>
                            <{/if}>
                            <{if $threeSale > 2}>
                            <th>三级提成比例</th>
                            <{/if}>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['gd_id']}>">
                                <td><{$val['g_name']}></td>
                                <td>
                                    <{$val['gd_0f_ratio']}>
                                </td>
                                <td><{$val['gd_1f_ratio']}></td>
                                <{if $threeSale > 1}>
                                <td><{$val['gd_2f_ratio']}></td>
                                <{/if}>
                                <{if $threeSale > 2}>
                                <td><{$val['gd_3f_ratio']}></td>
                                <{/if}>
                                <td style="color:#ccc;">
                                    <a class="confirm-handle fxGoods" href="#" data-gid="<{$val['g_id']}>" data-name="<{$val['g_name']}>"
                                       data-ratio_0="<{$val['gd_0f_ratio']}>"
                                       data-ratio_1="<{$val['gd_1f_ratio']}>"
                                       data-ratio_2="<{$val['gd_2f_ratio']}>"
                                       data-ratio_3="<{$val['gd_3f_ratio']}>"
                                       data-used="<{$val['gd_is_used']}>" >编辑 - </a>
                                    <a data-id="<{$val['gd_id']}>" onclick="confirmDelete(this)" style="cursor: pointer;color:#f00;">删除</a>
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

    <div id="modal-info-form" class="modal fade" tabindex="-1">
        <div class="modal-dialog" style="width:500px;;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="blue bigger" id="modal-title">佣金配置设置</h4>
                </div>

                <div class="modal-body" style="overflow: hidden;height: 400px">
                    <input type="hidden" class="form-control" id="hid-id">
                    <input type="hidden" class="form-control" id="hid-type" value="deduct">
                    <!--分佣比例设置-->
                    <div id="threeSale" class="tab-div">
                        <div class="alert alert-block alert-yellow">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            若未开启，或者未设置，则按 店铺 佣金配置进行分销!
                        </div>
                        <div class="col-sm-12" style="margin-bottom: 20px;">
                            <div id="home"  class="tab-pane in active">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon input-group-addon-title">分销<{$goodsName}></div>
                                        <div>
                                            <select class="form-control selectpicker chosen-select" id="g_id" name="g_id"  data-live-search="true"  data-need="required" data-placeholder="请选择分销<{$goodsName}>">
                                            <{foreach $goodsList as $val}>
                                            <option value="<{$val['g_id']}>"><{mb_substr($val['g_name'],0,20)}></option>
                                            <{/foreach}>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon input-group-addon-title">购买人返现比例</div>
                                        <input type="text" class="form-control" id="ratio_0" placeholder="返现比例百分比">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon input-group-addon-title">上级提成比例</div>
                                        <input type="text" class="form-control" id="ratio_1" placeholder="百分比">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                                <{if $threeSale > 1}>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon input-group-addon-title">二级提成比例</div>
                                        <input type="text" class="form-control" id="ratio_2"  placeholder="百分比">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                                <{/if}>
                                <{if $threeSale > 2}>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon input-group-addon-title">三级提成比例</div>
                                        <input type="text" class="form-control" id="ratio_3"  placeholder="百分比">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                                <{/if}>
                                <div class="input-group col-sm-3" style="padding: 0">
                                    <div class="input-group-addon"> 是否开启 : &nbsp;</div>
                                    <label class="input-group-addon" id="choose-yesno" style="padding: 4px 10px;margin: 0;border: 1px solid #D5D5D5;">
                                        <input name="used" class="ace ace-switch ace-switch-5" id="used"  type="checkbox">
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary modal-save" onclick="saveRatio()">保存</button>
                </div>
            </div>
        </div>
    </div>    <!-- MODAL ENDS -->

<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script>

    $(function(){
        // 搜索选择下拉框
        $(".chosen-select").chosen({
            no_results_text: "没有找到",
            search_contains: true
        });

    });

    $('.fxGoods').on('click',function(){
        var gid = $(this).data('gid');
        if(gid){
            var name = $(this).data('name');
            $('.chosen-single span').text(name);
            $('#hid-id').val(gid);
            for(var i=0 ; i<=3 ; i++){
                var temp = $(this).data('ratio_'+i);
                $('#ratio_'+i).val(temp);
            }
            var used = $(this).data('used');
            if(used == 1) {
                $('input[name="used"]').prop("checked","checked");
            }else{
                $('input[name="used"]').prop("checked","");
            }
        }else{
            $('#hid-id').val();
        }
        show_modal_content('threeSale',gid);
        $('#modal-info-form').modal('show');

    });

    function show_modal_content(id,gid){
        $('.tab-div').hide();
        $('#'+id).show();
        $('#hid-goods').val(gid);
        var title = '佣金配置设置',type='deduct';
        switch (id){
            case 'threeSale':
                title = '佣金配置设置';
                type  = 'deduct';
                break;
            case 'setPoint':
                title = '<{$goodsName}>积分设置';
                type  = 'point';
                break;
        }
        $('#modal-title').text(title);
        $('#hid-type').val(type);
    }

    function saveRatio(){
        var gid = $('#hid-id').val();
        if(!gid){
            gid = $('#g_id').val();
        }
        if(gid){
            var ck = $('#used:checked').val();
            var data = {
                'gid'  : gid,
                'used' : ck == 'on' ? 1 : 0,
            };
            for(var i=0 ; i<=3 ; i++){
                data['ratio_'+i] = $('#ratio_'+i).val();
            }
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/goods/saveRatio',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });

        }
    }

    function confirmDelete(ele) {
        var id = $(ele).data('id');
        if(id){
        	layer.confirm('确定要删除吗？', {
	            btn: ['确定','取消'] //按钮
	        }, function(){
	            var loading = layer.load(2);
	            $.ajax({
	                'type'  : 'post',
	                'url'   : '/wxapp/goods/delRatio',
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
	        });
        }
    }

</script>