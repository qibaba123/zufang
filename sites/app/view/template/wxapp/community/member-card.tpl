<style type="text/css">
    .table tr th ,.table tr td {
        text-align: center;
    }
    .table-bordered>tbody>tr>td{border:0;border-bottom:1px solid #ddd; }
    .table>thead>tr.success>th{background-color:#f8f8f8;border-color: #f8f8f8;border-right: 1px solid #ddd;border-bottom: 1px solid #ddd;}
</style>
<{include file="../common-community-menu.tpl"}>
<div  id="content-con" style="padding-left: 130px;">
    <div class="wechat-setting">
        <div class="tabbable">
            <!----导航链接----->
            <div class="tab-content"  style="z-index:1;">
                <!--验证卡券-->
                <div id="tab1" class="tab-pane in active">
                    <div class="verify-intro-box" data-on-setting>
                        <div class="page-header">
                            <a href="javascript:;" class="btn btn-green btn-sm add-btn" data-toggle="modal" data-target="#editModal" >
                                添加会员卡
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table id="sample-table-1" class="table table-bordered table-hover">
                                <thead>
                                <tr class="success">
                                    <th>会员卡名称</th>
                                    <th>类型/时长</th>
                                    <th>所需积分</th>
                                    <th>折扣率</th>
                                    <th>权益</th>
                                    <th>须知</th>
                                    <th>操作</th>
                                </tr>
                                </thead>

                                <tbody>
                                <{foreach $list as $val}>
                                <tr id="tr_<{$val['oc_id']}>">
                                    <td><{$val['oc_name']}></td>
                                    <td><{$type[$val['oc_long_type']]['name']}>/<{$val['oc_long']}>天</td>
                                    <td><{$val['oc_points']}></td>
                                    <td><{if $val['ml_discount'] > 0}><{$val['ml_discount']}>折<{/if}></td>
                                    <td><{$val['oc_rights']}></td>
                                    <td><{$val['oc_notice']}></td>
                                    <td style="color:#ccc;">
                                        <a href="javascript:;" data-toggle="modal" data-target="#editModal"  data-id="<{$val['oc_id']}>" data-points="<{$val['oc_points']}>" class="edit-btn">编辑</a>-
                                        <a href="javascript:;" data-id="<{$val['oc_id']}>" class="del-btn" style="color:#f00;">删除</a>
                                    </td>
                                </tr>
                                <{/foreach}>
                                <{if $pageHtml}>
                                    <tr><td colspan="9"><{$pagination}></td></tr>
                                <{/if}>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    <!-- PAGE CONTENT ENDS -->

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="esmid" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="infoModalLabel">
                    编辑会员卡
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">会员卡：</label>
                    <div class="col-sm-8">
                        <select name="member-card" id="member-card" class="form-control">
                            <{foreach $cardSelectList as $val}>
                            <option value="<{$val['oc_id']}>"><{$val['oc_name']}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">所需积分：</label>
                    <div class="col-sm-8">
                        <input id="card-points" type="number" class="form-control" placeholder="请填写所需积分" style="height:auto!important"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-info">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>


<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript">

    $('.add-btn').on('click',function(){
        $("#member-card").val(0);
        $("#card-points").val(0);
        $("#member-card").attr("disabled",false);
    });

    $('.edit-btn').on('click',function(){
        $("#member-card").val($(this).data('id'));
        $("#card-points").val($(this).data('points'));
        $("#member-card").attr("disabled",true);
    });

    $('#confirm-info').on('click',function(){
        var data   = {
            'cardId'     : $("#member-card").val(),
            'points'     : $("#card-points").val(),
        };
        if(data.cardId > 0){
            var loading = layer.load(10, {
                shade: [0.6,'#666']
            });
            console.log(data);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/addPointMemberCard',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    console.log(ret);
                    layer.close(loading);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });
        }
    })

    $('.del-btn').on('click',function(){
        var data   = {
            'cardId'     : $(this).data('id')
        };
        if(data.cardId > 0){
        	layer.confirm('确定要删除吗？', {
	            btn: ['确定','取消'] //按钮
	        }, function(){
	           	var loading = layer.load(10, {
	                shade: [0.6,'#666']
	            });
	           	console.log(data);
	            $.ajax({
	                'type'  : 'post',
	                'url'   : '/wxapp/community/delPointMemberCard',
	                'data'  : data,
	                'dataType' : 'json',
	                'success'   : function(ret){
	                    console.log(ret);
	                    layer.close(loading);
	                    layer.msg(ret.em);
	                    if(ret.ec == 200){
                            window.location.reload();
	                    }
	                }
	            }); 
	        });
        }
    });

</script>



