<style>
    .form-imgload .container{
        margin-left: 0;
        padding-left: 0;
    }
    .row{
        padding: 3px;
    }
</style>
<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal" role="form" method="post" action="/wxapp/member/memberRemark" onsubmit="return check_edit_shop();" id="info-form">
                        <input type="hidden" name="id" value="<{$detail['m_id']}>" id="mid" />
                        <input type="hidden" name="source" value="<{$detail['m_source']}>" id="source" />
                        <div class="row">
                            <div class="col-sm-5 col-sm-offset-1">

                                <{if $detail['m_source'] == 5}>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="nickname">会员昵称</label>
                                        <input class="form-control" type="text" id="nickname" name="nickname" required="required" value="<{$detail['m_nickname']}>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="avatar">会员头像</label>
                                        <div>
                                            <img onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="upload-cover" id="upload-cover"  src="<{if $detail['m_avatar']}><{$detail['m_avatar']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="200px" style="display:inline-block;margin:0;">
                                            <input type="hidden" id="cover"  class="avatar-field bg-img" name="upload-cover" value="<{$detail['m_avatar']}>"/>
                                            <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="upload-cover">修改头像<small style="font-size: 12px;color:#999">（建议尺寸：200*200）</small></a>
                                        </div>
                                    </div>
                                </div>
                                <{else}>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="nickname">会员昵称</label>
                                        <input class="form-control" type="text" id="nickname" name="nickname" readonly="readonly" required="required" value="<{$detail['m_nickname']}>">
                                    </div>
                                </div>
                                <{/if}>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="brief">手机号</label>
                                        <input class="form-control" type="number" id="mobile" name="mobile" required="required" value="<{$detail['m_mobile']}>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="brief">真实姓名</label>
                                        <input class="form-control" type="text" id="realname" name="realname" required="required" value="<{$detail['m_realname']}>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label for="form-field-name-1">账户金额</label>
                                        <input class="form-control" type="text" id="form-field-name-1" name="coin" required="required" disabled="disabled" value="<{$detail['m_gold_coin']}>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label for="form-field-name-1">订单成交总数</label>
                                        <input class="form-control" type="text" id="form-field-name-1" name="num" required="required"  disabled="disabled" value="<{$detail['m_traded_num']}>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label for="form-field-name-1">订单成交总额</label>
                                        <input class="form-control" type="text" id="form-field-name-1" name="money" required="required" disabled="disabled" value="<{$detail['m_traded_money']}>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-10 col-sm-offset-1">
                                <div class="form-group" style="margin-left: 0;">
                                    <label for="introduce">备注信息<span class="red">*</span></label>
                                    <textarea class="form-control"  id = "introduce" name="remark" placeholder="备注"  rows="10" style=" text-align: left; resize:vertical;" ><{$detail['m_remark']}></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="text-align: center;">
                            <button type="button" class="btn btn-app btn-xs btn-success" id="save-info">
                                保存
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript">
    $("#save-info").on('click',function () {
        var remark = $('#introduce').val();
        var mobile = $('#mobile').val();
        var realname = $('#realname').val();
        var id     = $('#mid').val();
        var source     = $('#source').val();
        var nickname = $('#nickname').val();
        var avatar = $('#cover').val();
        var data = {
            'id'    : id,
            'remark' : remark,
            'mobile' : mobile,
            'realname' : realname,
            'source' : source,
            'nickname' : nickname,
            'avatar' : avatar
        };
        $.ajax({
        'type'   : 'post',
        'url'   : '/wxapp/member/memberRemark',
        'data'  : data,
        'dataType'  : 'json',
        'success'   : function(ret){
            layer.msg(ret.em);
            if(ret.ec == 200){
                window.location.reload();
            }else{

            }
        }
    });
    });
</script>
<{include file="../img-upload-modal.tpl"}>