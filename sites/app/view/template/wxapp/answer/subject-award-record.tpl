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
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/answer/awardRecordList" method="get" class="form-inline">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">兑换码</div>
                                <input type="text" class="form-control" name="code" value="<{$code}>" placeholder="兑换码">
                            </div>
                        </div>
                    </div>
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">奖品</div>
                                <select name="awardId" id="" class="form-control">
                                    <option value="0">全部</option>
                                    <{foreach $awards as $val}>
                                    <option value="<{$val['asa_id']}>" <{if $val['asa_id'] == $awardId}> selected <{/if}>><{$val['asa_name']}></option>
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
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="fixed-table-box" style="margin-bottom: 30px;">
                <div class="fixed-table-header">
                    <table class="table table-striped table-hover table-avatar">
                            <tr>
                                <th>会员id</th>
                                <th>会员昵称</th>
                                <th>会员头像</th>
                                <th>奖品</th>
                                <th>兑换码</th>
                                <th>兑换状态</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                        <{foreach $list as $val}>
                            <tr>
                                <td style="white-space: normal;"><{$val['m_id']}></td>
                                <td style="white-space: normal;"><{$val['m_nickname']}></td>
                                <td style="white-space: normal;"><img src="<{$val['m_avatar']}>" alt="" style="height: 75px;"></td>
                                <td style="white-space: normal;"><{$val['asar_name']}></td>
                                <td style="white-space: normal;"><{$val['asar_code']}></td>
                                <td style="white-space: normal;">
                                    <{if $val['asar_status'] eq 1}>
                                    已兑换
                                    <{/if}>
                                </td>
                                <td style="white-space: normal;"><{date('Y-m-d H:i',$val['asar_create_time'])}></td>
                                <td style="white-space: normal;">
                                    <{if $val['asar_status'] eq 0}>
                                    <a href="javascript:;" onclick="changeStatus(this)" data-mid="<{$val['asar_m_id']}>" data-code="<{$val['asar_code']}>" class="btn-del">核销</a>
                                    <{/if}>
                                </td>
                            </tr>
                        <{/foreach}>
                        <tr><td colspan="8" style="text-align:right"><{$paginator}></td></tr>
                    </table>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
</div>    <!-- PAGE CONTENT ENDS -->
<!-- 添加奖品弹出层 -->

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
    function changeStatus(ele) {
        var mid = $(ele).data('mid');
        var code = $(ele).data('code');
        var data={
            'mid':mid,
            'code':code
        };
        if(mid && code){
            layer.confirm('确定要核销吗？', {
                title: '确认核销',
                btn: ['确定', '取消'] //按钮
            }, function () {
                $.ajax({
                    'type': 'post',
                    'url' : '/wxapp/answer/checkAward',
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



</script>