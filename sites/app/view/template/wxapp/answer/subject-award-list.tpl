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
        width: calc(100% / 4);
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
<{include file="../common-second-menu.tpl"}>
<div  id="content-con"  style="margin-left: 150px">

    <a class="add-award btn btn-green btn-xs" href="#" data-toggle="modal" data-target="#myModal"  data-id="0.00" data-name="" data-cover="/public/manage/img/zhanwei/zw_fxb_200_200.png" data-price="" ><i class="icon-plus bigger-80"></i> 新增</a>
    <!--<div style="margin: 10px 0;border: 1px solid #ccc;width: 45%">
        <div class="input-group-addon" style="text-align: left;">导入题目信息</div>
        <div style="padding: 10px 20px">
            <form enctype="multipart/form-data" method="post" action="/wxapp/answer/excelSubject" >
                <label>选择导入的excel<font color="red">*</font></label>
                <div>
                    <input type="file" id="files" name="files" style="float: left"/>
                    <button type="submit" class="btn btn-green btn-sm">导入excel题目信息</button>
                </div>
            </form>
        </div>
    </div>-->
    <!--
    <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
        <div class="balance-info">
            <div class="balance-title">累计答题次数<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['total']}></span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">累计答题人数<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['total_zsy']}></span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">累计正确次数<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['total_dsh']}></span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">累计错误次数<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['total_ytg']}></span>
            </div>
        </div>

    </div>
-->
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/answer/awardList" method="get" class="form-inline">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">名称</div>
                                <input type="text" class="form-control" name="name" value="<{$name}>" placeholder="名称">
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
    <div class="row">
        <div class="col-xs-12">
            <div class="fixed-table-box" style="margin-bottom: 30px;">
                <div class="fixed-table-header">
                    <table class="table table-hover table-avatar">
                            <tr>
                                <th>名称</th>
                                <th>图片</th>
                                <th>价值</th>
                                <th>选用状态</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                        <{foreach $list as $val}>
                            <tr>
                                <td style="white-space: normal;"><{$val['asa_name']}></td>
                                <td style="white-space: normal;"><img src="<{$val['asa_cover']}>" alt="" style="height: 75px;"></td>
                                <td style="white-space: normal;"><{$val['asa_price']}></td>
                                <td style="white-space: normal;">
                                    <{if $val['asa_status'] eq 1}>
                                    已选用
                                    <{/if}>
                                </td>
                                <td style="white-space: normal;"><{date('Y-m-d H:i',$val['asa_create_time'])}></td>
                                <td style="white-space: normal;" class="jg-line-color">
                                    <a class="add-award" href="#" data-toggle="modal" data-target="#myModal"  data-id="<{$val['asa_id']}>" data-name="<{$val['asa_name']}>" data-cover="<{$val['asa_cover']}>" data-price="<{$val['asa_price']}>" >编辑</a> -
                                    <a href="/wxapp/answer/awardRecordList?awardId=<{$val['asa_id']}>" class="award-record">查看获奖</a> -
                                    <a href="javascript:;" onclick="deleteSubject(this)" data-id="<{$val['asa_id']}>" class="btn-del" style="color:#f00;">删除</a>
                                </td>
                            </tr>
                        <{/foreach}>
                        <tr><td colspan="6" style="text-align:right"><{$paginator}></td></tr>
                    </table>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
</div>    <!-- PAGE CONTENT ENDS -->
<!-- 添加奖品弹出层 -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 550px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    添加奖品
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">奖品封面图：(建议尺寸200*200)</label>
                    <div class="col-sm-8">
                        <div>
                            <div class="cropper-box" data-width="200" data-height="200" style="height:100%;">
                                <img id="default-cover" src="/public/manage/img/zhanwei/zw_fxb_200_200.png" width="100%" height="100%" style="display:block;width: 75px;height: 75px" alt="封面" >
                                <input type="hidden" class="avatar-field bg-img" name="award-cover" id="award-cover"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">奖品名称：</label>
                    <div class="col-sm-8">
                        <input id="award-name" class="form-control" placeholder="请填写奖品名称" style="height:auto!important"/>
                    </div>
                </div>
                <!--<div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">奖品价值：</label>
                    <div class="col-sm-8">
                        <input type="number" id="award-price" class="form-control" placeholder="请填写奖品价值" maxlength="2" style="height:auto!important" />
                    </div>
                </div>-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="add-award">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
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
<{$cropper['modal']}>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script type="text/javascript">
    function deleteSubject(ele) {
        var id = $(ele).data('id');
        var data={
            'id':id
        };
        if(id){
            layer.confirm('确定要删除吗？', {
                title: '删除提示',
                btn: ['确定', '取消'] //按钮
            }, function () {
                $.ajax({
                    'type': 'post',
                    'url' : '/wxapp/answer/deleteAward',
                    'data':data,
                    'dataType': 'json',
                    success: function (ret) {
                        layer.msg(ret.em);
                        if (ret.ec == 200) {
                            window.location.reload();
                        }
                    }
                });
            });
        }
    }

    $('.add-award').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#award-name').val($(this).data('name'));
        $('#award-price').val($(this).data('price'));
        $('#award-cover').val($(this).data('cover'));
        $('#default-cover').attr('src',$(this).data('cover'));
    });

    $('#add-award').on('click',function(){
        var name = $('#award-name').val();
        var price = $('#award-price').val();
        var cover = $('#award-cover').val();


//        if(label.length == 0){
//            layer.msg('请添加类型标签');
//            return false;
//        }
        if(!name){
            layer.msg('请填写商品名称');
            return;
        }
        if(!cover){
            layer.msg('请上传奖品封面');
            return;
        }
        if(!cover){
            layer.msg('请填写奖品价值');
            return;
        }


        var loading = layer.load(10, {
            shade: [0.6,'#666']
        });
        var id  = $('#hid_id').val();


        var data = {
            id   : id,
            name : name,
            cover : cover,
            price : price

        };
//        console.log(data);return;
        //保存信息
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/answer/saveAward',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.href='/wxapp/answer/awardList'
                }
            }
        });

    });

</script>