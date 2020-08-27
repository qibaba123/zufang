<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
    .add-servicefl{
        display: inline-block;
        vertical-align: middle;
    }
    .add-servicefl>div{
        display: inline-block;
        vertical-align: middle;
    }
    .add-servicefl .fl-input{
        margin-left: 10px;
        display: none;
    }
    .add-servicefl .fl-input .form-control{
        display: inline-block;
        vertical-align: middle;
        width: 150px;
    }
    .add-servicefl .fl-input .btn{
        display: inline-block;
        vertical-align: middle;;
    }
    .servicefl-wrap{
        margin-bottom: 10px;
    }
    .servicefl-wrap h4{
        font-size: 16px;
        font-weight: bold;;
        margin:0;
        line-height: 2;
        margin-bottom: 5px;
    }
    .servicefl-wrap .fl-item{
        display: inline-block;
        margin-right: 6px;
        margin-bottom: 6px;
        background-color: #f5f5f5;
        border: 1px solid #dfdfdf;
        border-radius: 3px;
        padding: 0 10px;
        height: 35px;
        line-height: 33px;
        position: relative;
        padding-right: 30px;
    }
    .servicefl-wrap .fl-item .delete-fl{
        position: absolute;
        height: 20px;
        width: 20px;
        top: 6px;
        right: 3px;
        font-size: 18px;
        color: #666;
        text-align: center;
        z-index: 1;
        line-height: 20px;
        cursor: pointer;
    }
    .cus-input { padding: 7px 8px; font-size: 14px; border: 1px solid #ddd; -webkit-border-radius: 4px; -moz-border-radius: 4px; -ms-border-radius: 4px; -o-border-radius: 4px; border-radius: 4px; width: 100%; -webkit-transition: box-shadow 0.5s; -moz-transition: box-shadow 0.5s; -ms-transition: box-shadow 0.5s; -o-transition: box-shadow 0.5s; transition: box-shadow 0.5s; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; -o-box-sizing: border-box; box-sizing: border-box; min-height: 34px; resize: none; font-size: 14px;}
    .classify-wrap .classify-title { font-size: 16px; font-weight: bold; line-height: 2;padding: 10px 0; }
    .classify-wrap .classify-preiview-page { width: 320px; padding: 0 20px 20px; border: 1px solid #dfdfdf; -webkit-border-radius: 10px 10px 0 0; -moz-border-radius: 10px 10px 0 0; -ms-border-radius: 10px 10px 0 0; -o-border-radius: 10px 10px 0 0; border-radius: 10px 10px 0 0; background-color: #fff; box-sizing: content-box; float: left; }
    .classify-preiview-page .mobile-head { padding: 12px 0; text-align: center}
    .classify-preiview-page .mobile-con { border: 1px solid #dfdfdf; min-height: 150px; background-color: #f5f6f7; }
    .classify-preiview-page .mobile-nav { position: relative; }
    .classify-preiview-page .mobile-nav img { width: 100%; }
    .classify-preiview-page .mobile-nav p { line-height: 44px; height: 44px; position: absolute; width: 100%; top: 20px; left: 0; font-size: 15px; text-align: center; }
    .classify-preiview-page .classify-name { display: table; background-color: #fff; }
    .classify-preiview-page .classify-name span { display: table-cell; width: 1000px; text-align: center; height: 45px; line-height: 45px; }
    .classify-wrap .right-classify-manage { margin-left: 370px; min-height: 210px; }
    .right-classify-manage .manage-title{font-weight: bold;padding: 10px 10px 5px;}
    .right-classify-manage .manage-title span{font-size: 13px;color: #999;font-weight: normal;}
    .right-classify-manage .add-classify{padding: 0 10px;}
    .right-classify-manage .add-classify .add-btn{height: 30px;line-height: 30px; padding: 0 10px;background-color: #06BF04;border-radius: 4px;font-size: 14px;display: inline-block;cursor: pointer;border:1px solid #00AB00;color: #fff;}
    .classify-name-con { font-size: 0; padding: 10px;}
    .noclassify{font-size: 15px;color: #999;}
    .classify-name-con .classify-name { border: 1px solid #ddd; border-radius: 4px; padding: 5px 10px; position: relative; display: inline-block; font-size: 14px; margin-right: 10px; margin-bottom: 10px; background-color: #f5f6f7; cursor: move;}
    .right-classify-manage .classify-name .cus-input{display: inline-block;width: 150px;}
    .classify-name-con .classify-name .del-btn { display:inline-block;height: 34px; line-height: 34px; font-size: 20px; width: 25px; cursor: pointer; text-align: center; color: #666; vertical-align: middle;}
    .classify-name-con .classify-name .del-btn:hover { color: #333; }
</style>
<div id="content-con">
    <div  id="mainContent">
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>认领人头像</th>
                            <th>认领人昵称</th>
                            <th>资质图片</th>
                            <th>认领时间</th>
                            <th>审核状态</th>
                            <th>审核时间</th>
                            <th>审核备注</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr>
                                <td><img src="<{$val['m_avatar']}>" width="50"></td>
                                <td><{$val['m_nickname']}></td>
                                <td>
                                    <{foreach json_decode($val['acsc_images'], true) as $img}>
                                    <a href="<{$img}>" rel="prettyPhoto[]"><img src="<{$img}>" width="50"></a>
                                    <{/foreach}>
                                </td>
                                <td><{date('Y-m-d H:i',$val['acsc_create_time'])}></td>
                                <td><span <{if $val['acsc_status'] == 1}>style="color: red"<{/if}>><{$statusNote[$val['acsc_status']]}></span></td>
                                <td><{if $val['acsc_deal_time']}><{date('Y-m-d H:i',$val['acsc_deal_time'])}><{/if}></td>
                                <td><{$val['acsc_deal_note']}></td>
                                <td>
                                    <{if $val['acsc_status'] == 1}>
                                    <a href="javascript:;" class="confirm-handle" data-toggle="modal" data-target="#myModal" data-id="<{$val['acsc_id']}>">审核</a>
                                    <{/if}>
                                </td>
                            </tr>
                            <{/foreach}>
                        <tr><td colspan="9"><{$pagination}></td></tr>
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
                    申请处理
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">审核状态：</label>
                    <div class="col-sm-10">
                        <select name="status" id="status" class="form-control">
                            <option value="2">通过</option>
                            <option value="3">拒绝</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">处理备注：</label>
                    <div class="col-sm-10">
                        <textarea id="market" class="form-control" rows="5" placeholder="请填写处理备注信息" style="height:auto!important"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-handle">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<script src="/public/plugin/layui/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script src="/public/plugin/sortable/sortable.js"></script>
<script type="text/javascript" src="/public/plugin/prettyPhoto/js/jquery.prettyphoto.js"></script>
<script type="text/javascript" src="/public/plugin/prettyPhoto/js/lrtk.js"></script>
<script>
    $(document).ready(function(){
        $("area[rel^='prettyPhoto']").prettyPhoto();
        $(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});
    })

    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
    });


    $('#confirm-handle').on('click',function(){
        var hid = $('#hid_id').val();
        var market = $('#market').val();
        var status = $('#status').val();
        var data = {
            id : hid,
            market : market,
            status: status
        };
        if(hid){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/dealClaim',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em,{
                        time : 2000
                    },function () {
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        }
    });

</script>

