<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style type="text/css">
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "开启\a0\a0\a0\a0\a0\a0\a0\a0禁止";
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before{
        background-color: #D15B47;
        border: 1px solid #CC4E38;
    }
    .alert-yellow {
        color: #FF6330;
        font-weight: bold;
        background-color: #FFFFCC;
        border-color: #FFDA89;
        margin:10px 0;
        letter-spacing: 0.5px;
        border-radius: 2px;
    }
    /* 商品列表图片名称样式 */
    td.proimg-name{
        min-width: 250px;
    }
    td.proimg-name img{
        float: left;
    }
    td.proimg-name>div{
        display: inline-block;
        margin-left: 10px;
        color: #428bca;
        width:100%
    }
    td.proimg-name>div .pro-name{
        max-width: 350px;
        margin: 0;
        width: 60%;
        margin-right: 40px;
        display: -webkit-box !important;
        overflow: hidden;
        text-overflow: ellipsis;
        word-break: break-all;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        white-space: normal;
    }
    td.proimg-name>div .pro-price{
        color: #E97312;
        font-weight: bold;
        margin: 0;
        margin-top: 5px;
    }
    .ui-popover.ui-popover-tuiguang.left-center .arrow{
        top:160px;
    }

    .ui-popover-tuiguang .code-fenlei>div {
        width: auto;
    }

    .alert-orange {
        text-align: center;
    }

    .fixed-table-body {
        max-height: inherit;
    }
    td{
        white-space: normal;
    }
</style>
<{include file="../common-second-menu.tpl"}>
<div  id="content-con"  style="margin-left: 150px">

    <a href="javascript:;" style="margin-bottom: 10px;" data-mk="add" data-id="0" data-name="" class="btn btn-green btn-xs btn-group"><i class="icon-plus bigger-80"></i> 新增</a>
    <!--<div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/answer/subjectList" method="get" class="form-inline">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">题目</div>
                                <input type="text" class="form-control" name="name" value="<{$name}>" placeholder="题目">
                                <input type="hidden" class="form-control" name="type" value="<{$type}>" placeholder="题目">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">难易程度</div>
                                <select class="form-control" id="degree" name="degreeNum">
                                    <{foreach $degree as $key=>$val}>
                                    <option value ="<{$key}>" <{if $key==$degreeNum}>selected="selected"<{/if}>><{$val}></option>
                                    <{/foreach}>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-1 pull-right search-btn">
                    <button type="submit" class="btn btn-green btn-sm">查询</button>
                </div>
            </form>
        </div>
    </div>-->
    <div class="row">
        <div class="col-xs-12">
            <div class="fixed-table-box" style="margin-bottom: 30px;">
                <div class="fixed-table-header">
                    <table class="table table-striped table-hover table-avatar">
                            <tr>
                                <th style="width:33.33%">币种名称</th>
                                <th style="width:33.33%">添加时间</th>
                                <th style="width:33.33%">操作</th>
                            </tr>
                        <{foreach $list as $val}>
                            <tr>
                                <td style="white-space: normal;"><{$val['acc_name']}></td>
                                <td style="white-space: normal;"><{date('Y-m-d H:i',$val['acc_create_time'])}></td>
                                <td style="white-space: normal;">
                                    <a class="btn-group" href="javascript:;" data-mk="edit" data-id="<{$val['acc_id']}>" data-name="<{$val['acc_name']}>">编辑</a>
                                    -
                                    <a class="btn-group" href="javascript:;" data-mk="del" data-id="<{$val['acc_id']}>" >删除</a>
                                 </td>
                            </tr>
                        <{/foreach}>
                        <tr><td colspan="9" style="text-align:right"><{$paginator}></td></tr>
                    </table>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
    <div id="add-modal"  class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" style="font-size: 18px">币种管理</h3>
                </div>
                <div class="modal-body" style="margin: 5px 15px">
                    <form id="add-form">
                        <input type="hidden" class="form-control" id="hid_id" value="0">
                        <div class="form-group">
                            <label for="group_name" style="margin-bottom: 5px;">币种名称</label>
                            <input type="text" class="form-control" id="group_name" placeholder="请输入币种名称">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-save-add" >保存</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>    <!-- PAGE CONTENT ENDS -->
<!-- 批量导入题目文件弹框 -->
<style>
    .layui-layer-btn{
        border-top: 1px solid #eee;
    }
    .upload-tips{
        /* overflow: hidden; */
    }
    .upload-tips label{
        display: inline-block;
        width: 70px;
    }
    .upload-tips p{
        display: inline-block;
        font-size: 13px;
        margin:0;
        color: #666;
        margin-left: 10px;
    }
    .upload-tips .upload-input{
        display: inline-block;
        text-align: center;
        height: 35px;
        line-height: 35px;
        background-color: #1276D8;
        color: #fff;
        width: 90px;
        position: relative;
        cursor: pointer;
    }
    .upload-tips .upload-input>input{
        display: block;
        height: 35px;
        width: 90px;
        opacity: 0;
        margin: 0;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 2;
        cursor: pointer;
    }
</style>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script type="text/javascript">
    //币种新增或编辑
    $('.btn-save-add').on('click',function(){
        var data = {
            'id'   : $('#hid_id').val(),
            'name' : $('#group_name').val(),
        };

        if(data.name){
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/answer/saveCurrency',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        $('#add-modal').modal('hide');
                            window.location.reload();
                    }
                }
            });
        }else{
            layer.msg('币种名称不能为空');
        }
    });
    //编辑或者删除处理
    $('.btn-group').on('click',function(){
        var mk      = $(this).data('mk');
        var id      = $(this).data('id');
        var name    = $(this).data('name');
        switch (mk){
            case 'add' :
            case 'edit':
                $('#hid_id').val(id);
                $('#group_name').val(name);
                $('#add-modal').modal('show');
                break;
            case 'del' :
                var data = {
                    'id'   : id
                };
                commonDeleteByIdWxapp(data);
                break;
        }

    });
    /**
     * 小程序通用删除
     */
    function commonDeleteByIdWxapp(data){
        if(data.id > 0){
            layer.confirm('您是确定要删除吗？', {
                btn: ['删除','暂不删除'] //按钮
            }, function(){
                var index = layer.load(10, {
                    shade: [0.6,'#666']
                });
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/answer/deleteCurrency',
                    'data'  : data,
                    'dataType' : 'json',
                    'success'   : function(ret){
                        layer.close(index);
                        layer.msg(ret.em);
                        if(ret.ec == 200 ){
                            window.location.reload();
                        }
                    }
                });
            });
        }else{
            layer.msg('参数错误');
        }
    }
</script>