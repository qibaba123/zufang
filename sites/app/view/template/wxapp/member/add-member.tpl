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
                        <!--<input type="hidden" name="id" value="<{$detail['m_id']}>" id="mid" />-->
                        <div class="row">
                            <div class="col-sm-5 col-sm-offset-1">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="form-field-name-1">会员昵称</label>
                                        <input class="form-control" type="text" id="form-field-name-1" name="nickname" readonly="readonly" required="required" value="<{$detail['m_nickname']}>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-10 col-sm-offset-1">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="form-field-name-1">头像</label>
                                        <img onclick="toUpload(this)"
                                             data-limit="1"
                                             data-width="200"
                                             data-height="200"
                                             data-dom-id="cover"
                                             id="cover"
                                             data-dfvalue="/public/manage/img/zhanwei/zw_fxb_75_36.png"
                                             placeholder="请上传会员头像"
                                             data-need="required"
                                             src="<{if $row && $row['gb_cover']}><{$row['gb_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_75_36.png<{/if}>"  style="display:inline-block;width:200px;height: auto;"  class="avatar-field bg-img img-thumbnail" >
                                        <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="cover">修改（尺寸：750*360）</a>
                                    </div>
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
        var data = {
            'id'    : id,
            'remark' : remark,
            'mobile' : mobile,
            'realname' : realname
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