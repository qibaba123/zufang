<link rel="stylesheet" href="/public/manage/searchable/jquery.searchableSelect.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/member-list.css">
<style>
    .form-group-box{
        overflow: auto;
    }
    .form-group-box .form-group{
        width: 260px;
        margin-right: 10px;
        float: left;
    }
    .fixed-table-box .table thead>tr>th,.fixed-table-body .table tbody>tr>td{
        text-align: center;
    }

    .fixed-table-body {
        max-height: inherit;
    }
    .recharge-btn,.point-btn{
        padding: 0 3px !important;
        margin-left: 10px;
        /*position: absolute;*/
        /*right: 5px;*/
        /*top: 24.5px;*/
    }
    .recharge-td {
        /*position: relative;*/
    }
    .waiter-dialog{
        width: 500px !important;
    }
    .waiter-content{
        overflow:visible !important;
    }
    .radio-box span{
        margin-right: 45px !important;
    }
    #waiter_shop{
        max-width: 250px;
    }

    /* 扣费弹出框 */
    .ui-popover,.openid-box {
        background: #000 none repeat scroll 0 0;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        padding: 2px;
        z-index: 1010;
        display: none;
        position: absolute;
        right: 0;
        top: 75%;
        width: 340px;
        left: auto;
    }
    .ui-popover .ui-popover-inner {
        background: #fff none repeat scroll 0 0;
        border-radius: 4px;
        min-width: 280px;
        padding: 10px;
    }
    .ui-popover .ui-popover-inner .money-input,.ui-popover .ui-popover-inner .point-input {
        border-radius: 4px !important;
        line-height: 19px;
        -webkit-transition: border linear .2s, box-shadow linear .2s;
        -moz-transition: border linear .2s, box-shadow linear .2s;
        -o-transition: border linear .2s, box-shadow linear .2s;
        transition: border linear .2s, box-shadow linear .2s;
    }
    .ui-popover .ui-popover-inner .money-input:focus,.ui-popover .ui-popover-inner .point-input:focus {
        border: 1px solid #73b8ee;
        -webkit-box-shadow: inset 0 1px 1px rgba(115, 184, 238, .075);
        -moz-box-shadow: inset 0 1px 1px rgba(115, 184, 238, .075);
        box-shadow: inset 0 1px 1px rgba(115, 184, 238, .075);
    }
    .ui-popover .arrow {
        border: 5px solid transparent;
        height: 0;
        position: absolute;
        width: 0;
    }
    .ui-popover.top-center .arrow {
        left: 90%;
        margin-left: -5px;
        top: -10px;
    }
    .ui-popover.top-left .arrow, .ui-popover.top-center .arrow, .ui-popover.top-right .arrow {
        border-bottom-color: #000;
    }
    .ui-popover .arrow::after {
        border: 5px solid transparent;
        content: " ";
        display: block;
        font-size: 0;
        height: 0;
        position: relative;
        width: 0;
    }
    .ui-popover.top-center .arrow::after {
        left: -5px;
        top: -3px;
    }
    .ui-popover.top-left .arrow::after, .ui-popover.top-center .arrow::after, .ui-popover.top-right .arrow::after {
        border-bottom-color: #fff;
    }

    .bottom-tr td{
        line-height: 25px !important;
    }
    .btn-openid{
        padding-top: 2px !important;
        padding-bottom: 2px !important;
        text-align: center;
        margin: 0 auto;
        width: 72px;
        display: block;
    }



</style>
<!-- openid弹出框 -->
<div class="ui-popover ui-popover-openid left-center" style="top:100px;" popover-type="openid">
    <!--
    <div class="arrow"></div>
    -->
    <div class="ui-popover-inner">
        <div class="input-group copy-div">
            <input type="text" class="form-control" id="copy" value="" readonly>
            <span class="input-group-btn">
                    <button class="copy-openid btn btn-white" data-clipboard-action="copy" data-clipboard-text="" style="border-left:0;outline:none;padding-left:0;padding-right:0;width:60px;text-align:center;z-index: 3000">复制</button>
            </span>
        </div>
    </div>
</div>
<div class="ui-popover ui-popover-select left-center" style="top:100px;" >
    <div class="ui-popover-inner">
        <span></span>
        <select id="member-grade" name="jiaohuo">
            <{if $mLevel}>
                <option value="0">请选择等级</option>
                <option value="-1">清除会员等级</option>
            <{foreach $mLevel as $key=>$val}>
                <option value="<{$key}>"><{$val}></option>
            <{/foreach}>
            <{else}>
                <option value="0">尚未添加等级</option>
            <{/if}>
        </select>
        <input type="hidden" id="hid_mid" value="0">
        <a class="ui-btn ui-btn-primary js-save" href="javascript:;">确定</a>
        <a class="ui-btn js-cancel" href="javascript:;" onclick="optshide(this)">取消</a>
    </div>
    <div class="arrow"></div>
</div>
<div class="ui-popover ui-popover-time left-center" style="top:100px;">
    <div class="ui-popover-inner">
        <span></span>
        <input type="text" id="endDate" style="margin:0">
        <input type="hidden" id="hid_dateid" value="0">
        <a class="ui-btn ui-btn-primary js-save-date" href="javascript:;" onclick="saveDate(this)">确定</a>
        <a class="ui-btn js-cancel" href="javascript:;" onclick="optshide(this)">取消</a>
    </div>
    <div class="arrow"></div>
</div>
<{if $addMember == 1}>
    <a href="javascript:;" onclick="addMember()" class="btn btn-green btn-xs"><i class="icon-plus bigger-80"></i> 新增</a>
    <{/if}>
<div id="content-con">
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/member/jobMemberList" method="get" class="form-inline">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <input type="hidden" name="type" value="<{if $type}><{$type}><{else}>all<{/if}>">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">昵称</div>
                                    <input type="text" class="form-control" name="nickname" value="<{$nickname}>" placeholder="微信昵称">
                                </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">会员编号</div>
                                <input type="text" class="form-control" name="mid"  value="<{if $mid}><{$mid}><{/if}>" placeholder="编号">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">授权状态</div>
                                <select name="authorization" id="authorization" class="form-control">
                                    <option value="-1">全部</option>
                                    <option value="0" <{if $authorization == 0}> selected <{/if}>>已授权</option>
                                    <option value="1" <{if $authorization == 1}> selected <{/if}>>未授权</option>
                                </select>
                            </div>
                        </div>
                        <{if $appletCfg['ac_type'] == 6}>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">会员来源</div>
                                <select name="source" id="source" class="form-control">
                                    <option value="0">全部</option>
                                    <option value="2" <{if $source eq 2}>selected<{/if}> >小程序</option>
                                    <option value="4" <{if $source eq 4}>selected<{/if}> >后台添加</option>
                                </select>
                            </div>
                        </div>
                        <{/if}>
                    </div>
                </div>
                <div class="col-xs-1 pull-right search-btn">
                    <button type="submit" class="btn btn-green btn-sm">查询</button>
                </div>
            </form>
        </div>
    </div>
    <div class="choose-state">
        <!--<{foreach $choseLink as $val}>
        <a href="<{$val['href']}>" <{if $type eq $val['key']}> class="active" <{/if}>><{$val['label']}></a>
        <{/foreach}>-->
        <!---
        <button class="pull-right btn btn-danger btn-xs" style="margin-top: 5px;margin-right: 10px;">
            <i class="icon-remove"></i> 删除所选<span id="choose-num">(12)</span>
        </button>
        -->
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    <div class="fixed-table-box" style="margin-bottom: 30px;">
                        <div class="fixed-table-header">
                            <table class="table table-hover table-avatar">
                                <thead>
                                    <tr>
                                        <th class="center">
                                            <label>
                                                <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                                <span class="lbl"></span>
                                            </label>
                                        </th>
                                        <th>会员编号</th>
                                        <th>会员昵称</th>
                                        <{if $addMember == 1}>
                                        <th>来源</th>
                                        <{/if}>
                                        <th>手机号</th>
                                        <th class="hidden-480">头像</th>
                                        <th>状态</th>
                                        <th>工作状态</th>
                                        <th>公司</th>
                                        <th>收益</th>
                                        <th>关注时间</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="fixed-table-body">
                            <table id="sample-table-1" class="table table-hover table-avatar">
                                <tbody>
                                <{foreach $list as $val}>
                                    <tr id="tr_<{$val['m_id']}>">
                                        <td class="center">
                                            <label>
                                                <input type="checkbox" class="ace" name="ids" value="<{$val['m_id']}>"/>
                                                <span class="lbl"></span>
                                            </label>
                                        </td>
                                        <td><{$val['m_show_id']}></td>
                                        <td>
                                            <{if $val['m_nickname']}>
                                            <a href="#"><{$val['m_nickname']}></a>
                                            <{/if}>

                                                <a href="#" class="btn btn-default btn-xs btn-openid" data-openid="<{$val['m_openid']}>" style="">查看openid</a>
                                        </td>
                                        <{if $addMember == 1}>
                                        <td><{$memberSource[$val['m_source']]}></td>
                                        <{/if}>
                                        <td><{if $val['m_mobile']}><{$val['m_mobile']}><{else}>无<{/if}></td>
                                        <td style="position:relative">
                                            <img class="img-thumbnail" width="60" src="<{if $val['m_avatar']}><{$val['m_avatar']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>" />
                                        </td>
                                        <td>
                                           <{if $val['m_gold_freeze'] == 0}>
                                        <span style="color: #06BF04">正常</span>
                                            <!--<a class="btn btn-warning freeze-btn" mid="<{$val['m_id']}>" status="1">冻结账户</a>-->
                                        <{/if}>
                                        <{if $val['m_gold_freeze'] == 1}>
                                        <span style="color: red">已冻结</span>
                                            <!--<a class="btn btn-success freeze-btn" mid="<{$val['m_id']}>" status="0">解冻账户</a>-->
                                        <{/if}>
                                        </td>
                                        <td>
                                            <{if $val['entry']}>
                                            已入职
                                            <{elseif $val['ajr_id']}>
                                            已创建简历
                                            <{elseif !$val['ajr_id']}>
                                            未创建简历
                                            <{/if}>
                                        </td>
                                        <td>
                                            <{if $val['company']}><{$val['company']}><{else}>无<{/if}>
                                        </td>
                                        <td style="min-width: 100px;position: relative">
                                            <{$val['m_deduct_ktx']}>
                                        </td>
                                        <td>
                                            <{$val['m_follow_time']}>
                                        </td>
                                        <td style="min-width: 100px">
                                        <a href="/wxapp/member/memberDetail?id=<{$val['m_id']}>" >
                                            <{if $val['m_source'] == 5 }>
                                            编辑
                                            <{else}>
                                            查看
                                            <{/if}>
                                        </a> -
                                        <{if $val['ajr_id']}>
                                            <a href="/wxapp/job/resumeDetail?id=<{$val['ajr_id']}>">简历详情</a>-
                                        <{/if}>
                                            <a href="/wxapp/job/sendHistory?id=<{$val['m_id']}>">投递记录</a>-
                                            <a href="/wxapp/job/awardRecord?id=<{$val['m_id']}>">收益记录</a>

                                        <{if $val['m_gold_freeze'] == 0}>
                                         <a class="freeze-gold" href="#" mid="<{$val['m_id']}>" status="1">冻结余额</a>
                                        <{else}>
                                         <a class="freeze-gold"  href="#" mid="<{$val['m_id']}>" status="0">解冻余额</a>
                                        <{/if}>
                                        </td>
                                    </tr>
                                    <{/foreach}>

                                    <tr class="bottom-tr">
                                        <td colspan="3" style="text-align: left">
                                            <a href="#" class="btn btn-primary btn-xs recharge-btn" data-toggle="modal"  data-type="multi" data-mid="0" data-target="#rechargeModal" style="padding-top: 2px !important;padding-bottom: 2px !important;">余额批量充值</a>

                                            <a href="#" class="btn btn-default btn-xs point-btn" data-toggle="modal"  data-type="multi" data-mid="0" data-target="#pointModal" style="padding-top: 2px !important;padding-bottom: 2px !important;">积分批量增加</a>

                                        </td>
                                        <td colspan="15" style="text-align: right">
                                            <{$paginator}>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div><!-- /span -->
            </div><!-- /row -->
        </div>
    </div>
</div>
<!--新增添加会员-->
<div id="add-modal"  class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" style="font-size: 18px">添加用户</h3>
            </div>
            <div class="modal-body" style="margin: 5px 15px">
                <form id="add-form">
                    <div class="form-group">
                        <label for="name">用户昵称</label>
                        <input type="text" class="form-control" id="username" placeholder="请输入用户昵称">
                    </div>
                    <div class="form-group">
                        <label>用户头像</label>
                        <div>
                            <img onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="upload-cover" id="upload-cover"  src="/public/manage/img/zhanwei/zw_fxb_45_45.png"  width="200px" style="display:inline-block;margin:0;">
                            <input type="hidden" id="cover"  class="avatar-field bg-img" name="upload-cover" value=""/>
                            <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="upload-cover">修改头像<small style="font-size: 12px;color:#999">（建议尺寸：200*200）</small></a>
                        </div>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="saveMember()" class="btn btn-primary btn-save-add" >保存</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                <form><input type="hidden" id="hid_type" value="">
                    <div class="form-group has-success has-feedback">
                        <div class="input-group">
                            <span class="input-group-addon">会员编号</span>
                            <input type="text" class="form-control" id="showID" aria-describedby="inputGroupSuccess1Status">
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="form-group has-success has-feedback">
                        <div class="input-group">
                            <span class="input-group-addon">推荐码(选填)</span>
                            <input oninput="this.value=this.value.replace(/\D/g,'')" class="form-control" id="code" placeholder="6位数字,会员推荐码" >
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary saveReferBest">保存</button>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript" src="/public/manage/searchable/jquery.searchableSelect.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/bootbox.min.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/manage/controllers/member.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/plugin/ZeroClip/clipboard.min.js"></script>
<script type="text/javascript">
    var clipboard = new ClipboardJS('.copy-openid');
    // 复制内容到剪贴板成功后的操作
    clipboard.on('success', function(e) {
        layer.msg('复制成功');
    });
    clipboard.on('error', function(e) {
    });

    function hideChargeInput(){
        $(".charge-input").stop().fadeOut();
    }
    function hidePointInput(){
        $(".point-charge-input").stop().fadeOut();
    }

    $('.add-btn').on('click',function(){
        var type = $(this).data('type');
        var title = $(this).data('title');
        $('#myModalLabel').html(title);
        $('#hid_type').val(type);
        $('#showID').val('');
        $('#code').val('');
        $('#myModal').modal('show')
    });
    //充值模态框点击
    $('.recharge-btn').on('click',function(){
        var mid = $(this).data('mid');
        var type = $(this).data('type');
        var coinNow = $(this).data('coin');
        //批量充值
        if(type == 'multi'){
            //隐藏操作选择
            $(".coin-operate").css('display','none');
            var ids = get_select_all_ids_array_by_name('ids');
            if(ids.length == 0){
                layer.msg('请选择会员');
                return false;
            }
        }else{
            $(".coin-operate").css('display','');
        }
        $('#hid_mid').val(mid);
        $('#recharge_type').val(type);
        $('#gold_coin_now').val(coinNow);
        $('#gold_coin').val('');
        $('#remark').val('');
        $('#pwd').val('');
    });


    //增加积分模态框点击
    $('.point-btn').on('click',function(){
        var mid = $(this).data('mid');
        var type = $(this).data('type');
        var pointNow = $(this).data('point_now');
        //批量增加
        if(type == 'multi'){
            $(".point-operate").css('display','none');
            var ids = get_select_all_ids_array_by_name('ids');
            if(ids.length == 0){
                layer.msg('请选择会员');
                return false;
            }
        }else{
            $(".point-operate").css('display','');
        }
        $('#point_mid').val(mid);
        $('#point_type').val(type);
        $('#point_now').val(pointNow);
        $('#point').val('');
        $('#point_remark').val('');
        $('#point_pwd').val('');
    });

    $('.waiter-set').on('click',function () {
        var mid = $(this).data('mid');
        var isWaiter = $(this).data('waiter');
        var shop = $(this).data('shop');
        $('#hid_waiter_mid').val(mid);
        if(isWaiter){
            $('#waiter_yes').attr('checked','checked');
            $('#waiter_no').attr('checked','');
        }
        $('#waiter_shop').val(shop);
    });

    $('.saveWaiter').on('click',function(){
        var mid    = $('#hid_waiter_mid').val();
        var isWaiter = $('input:radio[name="is_waiter"]:checked').val();
        var shop   = $('#waiter_shop').val();
        if(mid){
            var data = {
                'mid'     : mid,
                'isWaiter': isWaiter,
                'shop'    : shop
            };

            $.ajax({
                type  : 'post',
                url   : '/wxapp/member/setWaiterNew',
                data  : data,
                dataType  : 'json',
                success : function (json_ret) {
                    layer.msg(json_ret.em);
                    if(json_ret.ec == 200){
                        window.location.reload();
                    }
                }
            })
        }
    });

    $('.saveReferBest').on('click',function(){
        var type   = $('#hid_type').val();
        var showId = $('#showID').val();
        var code   = $('#code').val();
        if(code.length !=6 ){
            layer.msg('推荐码必须是6位数字');
            return false;
        }

        if(showId && type){
            var data = {
                'type'      :  type,
                'showId'    : showId,
                'code'      : code
            };
            $.ajax({
                type  : 'post',
                url   : '/wxapp/member/setReferBest',
                data  : data,
                dataType  : 'json',
                success : function (json_ret) {
                    layer.msg(json_ret.em);
                    if(json_ret.ec == 200){
                        window.location.reload();
                    }
                }
            })
        }
    });
    //管理员操作余额
    $('.saveRecharge').on('click',function(){
        var mid    = $('#hid_mid').val();
        var coin   = $('#gold_coin').val();
        var coinNow= $('#gold_coin_now').val();
        var remark = $('#remark').val();
        var pwd    = $('#pwd').val();
        var type   = $('#recharge_type').val();
        var operate= $("input[name='operateCoin']:checked").val();
        if(!pwd){
            layer.msg('请填写登录密码');
            return false;
        }

        if(operate == 0 && coinNow < coin){
            layer.msg('扣费金额需小于当前余额');
            return false;
        }
        var data = {
            'mid'     : mid,
            'coin'    : coin,
            'remark'  : remark,
            'pwd'     : pwd,
            'operate' : operate
        };
        var postUrl= '/wxapp/member/newSaveRecharge';
        //批量充值
        if(type == 'multi'){
            var ids    = get_select_all_ids_array_by_name('ids');
            if(ids.length > 0){
                data.ids = ids;
            }else{
                layer.msg('请选择会员');
                return false;
            }
            postUrl = '/wxapp/member/saveMultiRecharge'
        }
        $.ajax({
            type  : 'post',
            url   : postUrl,
            data  : data,
            dataType  : 'json',
            success : function (json_ret) {
                layer.msg(json_ret.em);
                if(json_ret.ec == 200){
                    window.location.reload();
                }
            }
        });

    });

    //管理员增加积分
    $('.savePoint').on('click',function(){
        var mid    = $('#point_mid').val();
        var type   = $('#point_type').val();
        var point  = $('#point').val();
        var pointNow = $('#point_now').val();
        var remark = $('#point_remark').val();
        var pwd    = $('#point_pwd').val();
        var operate= $("input[name='operatePoint']:checked").val();
        if(!pwd){
            layer.msg('请填写登录密码');
            return false;
        }

        if(operate == 0 && pointNow < point){
            layer.msg('扣除积分需小于当前积分');
            return false;
        }

        var data = {
            'mid'     : mid,
            'point'   : point,
            'remark'  : remark,
            'pwd'     : pwd,
            'operate' : operate
        };
        var postUrl = '/wxapp/member/savePoint';
        //批量增加
        if(type == 'multi'){
            var ids    = get_select_all_ids_array_by_name('ids');
            if(ids.length > 0){
                data.ids = ids;
            }else{
                layer.msg('请选择会员');
                return false;
            }
            postUrl = '/wxapp/member/saveMultiPoint';
        }
        $.ajax({
            type  : 'post',
            url   : postUrl,
            data  : data,
            dataType  : 'json',
            success : function (json_ret) {
                layer.msg(json_ret.em);
                if(json_ret.ec == 200){
                    window.location.reload();
                }
            }
        });

    });

   $('#myTab li').on('click', function() {
       var id = $(this).data('id');
       window.location.href='/wxapp/member/list?type='+id;
   });

   /*设置会员等级*/
    $('#member-grade').searchableSelect();
    $("#content-con").on('click', 'table td a.set-membergrade', function(event) {
        var id = $(this).data('id');
        var level = $(this).data('level');
        if(level){
           $('#member-grade').val(level);
        }
        $('#hid_mid').val(id);
        optshide();
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-106;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top); 
        $(".ui-popover.ui-popover-select").css({'left':left-conLeft-486,'top':top-conTop-76}).stop().show();
    });
    /**
     * 保存等级到期时间
     */
    $("#content-con").on('click', 'table td a.long_date', function(event) {
        var _this = $(this);
        var id  = _this.data('id');
        var end = _this.data('end');
        var curDate = _this.text();
        $("#endDate").val(curDate);
        $("#hid_dateid").val(id);

        optshide();
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-106;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top); 
        $(".ui-popover.ui-popover-time").css({'left':left-conLeft-445,'top':top-conTop-96}).stop().show();
    });

    // $(".ui-popover").on('click', function(event) {
    //     event.stopPropagation();
    // });
    // $(".ui-popover").on('click', function(event) {
    //     setTimeout(function () {
    //         event.preventDefault();
    //         event.stopPropagation();
    //     },100);
    // });

    //$(".main-container").on('click', function(event) {

    $("#content-con").on('click', function(event) {
        optshide();
    });

    /*复制openid弹出框*/
    $("#content-con").on('click', 'table td a.btn-openid', function(event) {
        var openid = $(this).data('openid');
        if(openid){
            $('.copy-div input').val(openid);
            $('.copy-div .copy-openid').attr('data-clipboard-text',openid);
        }
        event.preventDefault();
        event.stopPropagation();

        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-104;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        optshide();
        $(".ui-popover.ui-popover-openid").css({'left':left-conLeft-64,'top':top-conTop-66}).stop().show();
    });

    $(".ui-popover .js-save").on('click', function(event) {
        var level = $(".ui-popover #member-grade").val();
        var id    = $('#hid_mid').val();
        if(id>0 && level != 0){
            event.preventDefault();
            var data  = {
                'id'    : id,
                'level' : level
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/member/changeLevel',
                'data'  : data,
                'dataType' : 'json',
                'success'  : function(ret){
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                        //optshide();
                    }
                }
            });
        }else{
            layer.msg('您尚未选择用户等级');
        }

    });



    //取消官方推荐
    $('.cel-refer').on('click',function(){
        var id = $(this).data('id');
        var data  = {
            'id'    : id
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/member/cancelRefer',
            'data'  : data,
            'dataType' : 'json',
            'success'  : function(ret){
                layer.msg(ret.em);
                if(ret.ec == 200){
                    $('#tr_'+id).remove();
                    //optshide();
                }
            }
        });
    });
    /*$('.long_date').on('click',function(){
        var id  = $(this).data('id');
        var end = $(this).data('end');
    });*/

    $(function(){
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        $(".form-group-box .form-container .form-group").each(function(){
            groupItemWidth=Number($(this).outerWidth(true));
            sumWidth +=groupItemWidth;
        });
        $(".form-group-box .form-container").css("width",sumWidth+"px");

        /*日期选择器*/
        $('#endDate').datepicker({autoclose:true}).next().on(ace.click_event, function(){
          // $(this).prev().focus();
        });
        tableFixedInit();//表格初始化
        $(window).resize(function(event) {
            tableFixedInit();
        });
        
    });
    // 表格固定表头
    function tableFixedInit(){
        var tableBodyW = $('.fixed-table-body .table').width();
        $(".fixed-table-header .table").width(tableBodyW);
        $('.fixed-table-body .table tr').eq(0).find('td').each(function(index, el) {
            $(".fixed-table-header .table th").eq(index).outerWidth($(this).outerWidth())
        });
        $(".fixed-table-body").scroll(function(event) {
            var scrollLeft = $(this).scrollLeft();
            $(".fixed-table-header .table").css("left",-scrollLeft+'px');
        });
    }

    function changeStatus(id, status){
        var load_index = layer.load(
                2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/member/changeStatus',
            'data'  : {id: id,status: status},
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                if(ret.ec == 200){
                    window.location.reload();
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    }

    $('.freeze-gold').on('click',function () {
        var mid = $(this).attr('mid');
        var status = $(this).attr('status');
        var text;
        if(status==1){
        	text="确定要冻结余额吗？";
        }else{
        	text="确定要解冻余额吗？";
        }
        layer.confirm(text, {
            btn: ['确定','取消'] //按钮
        }, function(){
            var load_index = layer.load(
	                2,
	                {
	                    shade: [0.1,'#333'],
	                    time: 10*1000
	                }
	        );
	        $.ajax({
	            'type'  : 'post',
	            'url'   : '/wxapp/member/freezeGold',
	            'data'  : {mid: mid,status: status},
	            'dataType'  : 'json',
	            'success'   : function(ret){
	                layer.close(load_index);
	                if(ret.ec == 200){
	                    window.location.reload();
	                }else{
	                    layer.msg(ret.em);
	                }
	            }
	        });
        });
    });

    $('.set-waiter').on('click',function () {
        var mid = $(this).attr('mid');
        var status = $(this).attr('status')
        var load_index = layer.load(
                2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/member/setWaiter',
            'data'  : {mid: mid,status: status},
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                if(ret.ec == 200){
                    window.location.reload();
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    });

    //新增添加会员弹出框
    function addMember(){
        $('#add-modal').modal('show');
    }

    //保存新的会员信息
    function saveMember(){
        var name    = $('#username').val();
        var avatar  = $('#cover').val();
        var data    = {
            'name':name,
            'avatar':avatar
        };
        if(name && avatar){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/member/addMember',
                'data'  : data,
                'dataType' : 'json',
                'success'  : function(ret){
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        //$('#tr_'+id).remove();
                        //optshide();
                        window.location.reload();
                    }
                }
            });
        }else{
            layer.msg('请完善信息');
        }

    }
</script>
<{include file="../img-upload-modal.tpl"}>