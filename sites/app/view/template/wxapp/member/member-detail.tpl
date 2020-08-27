<link rel="stylesheet" href="/public/manage/searchable/jquery.searchableSelect.css">
<link rel="stylesheet" href="/public/manage/css/member-list.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<style type="text/css">
.top-info-box { display: flex; height: 65%; width: 100%; align-items: stretch; }
.bottom-info-box { height: 34%; width: 94%; margin: 0 auto; }
.info-box { width: 46%; height: 100%; padding: 10px; margin: auto !important; }
.widget-main { width: 100%; height: 880px; }
.info-item { height: 10%; width: 100%; padding: 3px 5px; font-size: 14px; }
.info-item { height: 9%; }
.inline-block { display: inline-block; }
.info-item .title { min-width: 16%; margin-right: 5px; }
.button-box { display: inline-block; margin-left: 10px; }
</style>
<div class="ui-popover ui-popover-select left-center" style="top:100px;width: 340px" >
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
    <!--
    <div class="arrow"></div>
    -->
</div>
<div  id="content-con" >
    <div class="wechat-setting">
        <div class="tabbable">
            <!--导航链接-->
            <{include file="../memberCard/tabal-link.tpl"}>
            <input type="hidden" id="hide_mid" value="<{$row['mid']}>">
            <input type="hidden" id="source" value="<{$row['source']}>">
            <div class="tab-content"  style="z-index:1;">
                <div class="widget-main" style="">
                    <div class="top-info-box">
                        <div class="info-box info-box-avatar">
                            <div class="info-item" style="height: 20%;display: flex;align-items: center">
                                <div class="title inline-block">用户头像：</div>
                                <div class="info inline-block">
                                    <{if $row['source'] == 5}>
                                <img onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="upload-cover" id="upload-cover"  src="<{if $row['avatar']}><{$row['avatar']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>" style="display:inline-block;margin:0;width: 70px">
                                <input type="hidden" id="cover"  class="avatar-field bg-img" name="upload-cover" value="<{$row['avatar']}>"/>
                                    <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="upload-cover" style="font-size: 14px">修改头像<small style="font-size: 12px;color:#999">（建议尺寸：200*200）</small></a>
                                    <{else}>
                                    <img src="<{$row['avatar']}>" alt="头像" style="width: 70px">
                                    <{/if}>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="title inline-block">用户编号：</div>
                                <div class="info inline-block"><{$row['showId']}></div>
                            </div>
                            <div class="info-item">
                                <div class="title inline-block">用户昵称：</div>
                                <div class="info inline-block">
                                    <{if $row['source'] == 5}>
                                    <input type="text" id="nickname" style="width: 200px" class="form-control" value="<{$row['nickname']}>">
                                    <{else}>
                                    <{$row['nickname']}>
                                    <{/if}>

                                </div>
                            </div>
                            <div class="info-item">
                                <div class="title inline-block">手　　机：</div>
                                <div class="info inline-block"><{$row['mobile']}></div>
                            </div>
                            <div class="info-item">
                                <div class="title inline-block">姓　　名：</div>
                                <div class="info inline-block"><{$row['truename']}></div>
                            </div>
                            <div class="info-item">
                                <div class="title inline-block">生　　日：</div>
                                <div class="info inline-block"><{$row['birthday']}></div>
                            </div>
                            <div class="info-item">
                                <div class="title inline-block">性　　别：</div>
                                <div class="info inline-block"><{$row['sex']}></div>
                            </div>
                            <{if !$hideLevel}>
                            <div class="info-item">
                                <div class="title inline-block">用户等级：</div>
                                <div class="info inline-block"><{$row['level']}>
                                    <div class="button-box">
                                        <a href="#" class="set-membergrade btn btn-xs btn-blueoutline" data-id="<{$row['mid']}>" data-level="<{$row['levelId']}>">设会员</a>
                                    </div>
                                </div>
                            </div>
                            <{/if}>
                            <{if $showStatus == 1}>
                            <div class="info-item">
                                <div class="title inline-block">用户状态：</div>
                                <div class="info inline-block">
                                    <{if $row['status'] == 0}>
                                    <span style="color: #06BF04">正常</span>
                                    <{/if}>
                                    <{if $row['status'] == 1}>
                                    <span style="color: red">封禁中</span>
                                    <{/if}>
                                    <div class="button-box">
                                        <{if $row['status'] == 0}>
                                            <a href="javascript:;" class="btn btn-xs btn-blueoutline" onclick="changeStatus(<{$row['mid']}>,<{$row['status']}>)">封禁</a>
                                        <{/if}>
                                        <{if $row['status'] == 1}>
                                            <a href="javascript:;"  class="btn btn-xs btn-blueoutline" onclick="changeStatus(<{$row['mid']}>,<{$row['status']}>)">解封</a>
                                        <{/if}>
                                    </div>
                                </div>
                            </div>
                            <{/if}>
                            <div class="info-item">
                                <div class="title inline-block">所属地区：</div>
                                <div class="info inline-block"><{$row['address']}></div>
                            </div>
                        </div>
                        <div class="info-box">
                            <div class="info-item">
                                <div class="title inline-block">openid：</div>
                                <div class="info inline-block"><{$row['openid']}></div>
                            </div>
                            <{if !$hideCoin}>
                            <div class="info-item">
                                <div class="title inline-block">账户储值余额：</div>
                                <div class="info inline-block"><{$row['coin']}></div>
                                <div class="button-box">
                                    <a class="btn btn-xs btn-blueoutline recharge-btn" data-toggle="modal" data-target="#rechargeModal"  data-mid="<{$row['mid']}>" data-coin="<{$row['coin']}>" data-type="single">操作</a>
                                </div>
                            </div>
                            <{/if}>
                            <div class="info-item">
                                <div class="title inline-block">订单成交总数：</div>
                                <div class="info inline-block"><{$row['tradeNum']}></div>
                            </div>
                            <div class="info-item">
                                <div class="title inline-block">订单成交总额：</div>
                                <div class="info inline-block"><{$row['tradeMoney']}></div>
                            </div>
                            <{if !$hidePoints}>
                            <div class="info-item">
                                <div class="title inline-block">目前积分：</div>
                                <div class="info inline-block">
                                    <{$row['point']}>
                                    <div class="button-box">
                                        <a class="btn btn-xs btn-blueoutline point-btn" data-toggle="modal" data-target="#pointModal"  data-mid="<{$row['mid']}>" data-type="single" data-point_now="<{$row['point']}>">操作</a>
                                    </div>
                                </div>
                            </div>
                            <{/if}>
                            <{if !$hideCard == 1}>
                            <div class="info-item">
                                <div class="title inline-block">会员卡状态：</div>
                                <div class="info inline-block"><{$row['offlineCard']}></div>
                            </div>
                            <{/if}>
                            <{if !$hideCoupon}>
                            <div class="info-item">
                                <div class="title inline-block">未使用优惠券：</div>
                                <div class="info inline-block"><{$row['couponCount']}></div>
                            </div>
                            <{/if}>
                            <div class="info-item">
                                <div class="title inline-block">关注时间：</div>
                                <div class="info inline-block"><{$row['followTime']}></div>
                            </div>
                            <div class="info-item">
                                <div class="title inline-block">用户分类：</div>
                                <div class="info inline-block">
                                    <{$row['category']}>
                                    <div class="button-box">
                                        <a class="btn btn-xs btn-blueoutline cate-btn" data-toggle="modal" data-target="#categoryModal"  data-mid="<{$row['mid']}>" data-type="single">修改</a>
                                    </div>
                                </div>
                            </div>
                            <{if !$hideThree}>
                            <div class="info-item">
                                <div class="title inline-block">推荐上级：</div>
                                <div class="info inline-block"><{if isset($level[$row['m_1f_id']])}><{if $level[$row['m_1f_id']]}><{$level[$row['m_1f_id']]}><{else}>未知昵称:ID(<{$row['m_1f_id']}>)<{/if}><{else}>无<{/if}></div>
                            </div>
                            <div class="info-item">
                                <div class="title inline-block">拥有下级人数：</div>
                                <div class="info inline-block"><{$row['threeTotal']}></div>
                            </div>
                            <{/if}>
                        </div>
                    </div>
                    <div class="bottom-info-box">
                        <div class="title inline-block" style="font-size: 16px">备注：</div>
                        <div style="text-align: center">
                            <textarea name="remark" id="remark" cols="30" rows="10" class="form-control" style="width: 100%;margin: 10px auto; "><{$row['remark']}></textarea>
                            <button class="btn btn-blue save-remark" data-mid="<{$row['mid']}>">保存</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    <!-- PAGE CONTENT ENDS -->

<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 350px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <input type="hidden" id="now_expire" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    修改分类
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group" style="padding: 20px">
                    <div class="input-group" style="width: 100%">
                        <label for="kind2" class="control-label">用户分类：</label>
                        <select name="custom_cate" id="custom_cate" class="form-control">
                            <option value="0">请选择分类</option>
                            <option value="-1">清除分类</option>
                            <{foreach $memberCategory as $key =>$val}>
                            <option value="<{$key}>"><{$val['mc_name']}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="change-cate">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!-- 增加积分 -->
<div class="modal fade" id="pointModal" tabindex="-1" role="dialog" aria-labelledby="pointModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <input type="hidden" id="point_mid" >
            <input type="hidden" id="point_type" value="">
            <input type="hidden" id="point_now" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="pointModalLabel">
                    积分
                </h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group row point-operate" style="display: none">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><font color="red">*</font>操作：</label>
                        <div class="col-sm-8">
                            <div class="radio-box">
                            <span>
                                <input type="radio" name="operatePoint" id="addPoint" value="1" checked="checked">
                                <label for="addPoint">增加</label>
                            </span>
                                <span>
                                <input type="radio" name="operatePoint" id="reducePoint" value="0">
                                <label for="reducePoint">扣除</label>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><font color="red">*</font>积分：</label>
                        <div class="col-sm-8">
                            <input id="point" class="form-control" placeholder="请填写积分数值" style="height:auto!important" type="number"/>
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">备注：</label>
                        <div class="col-sm-8">
                            <textarea name="point-remark" id="point_remark" cols="30" rows="3" placeholder="请填写备注" style="width: 100%"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><font color="red">*</font>密码：</label>
                        <div class="col-sm-8">
                            <input type="password" autocomplete="off" id="point_pwd" class="form-control" placeholder="请填写登录密码" style="height:auto!important" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary savePoint">保存</button>
            </div>
        </div>
    </div>
</div>
<!-- 余额充值 -->
<div class="modal fade" id="rechargeModal" tabindex="-1" role="dialog" aria-labelledby="rechargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <input type="hidden" id="hid_mid" >
            <input type="hidden" id="recharge_type" value="">
            <input type="hidden" id="gold_coin_now" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="rechargeModalLabel">
                    余额
                </h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group row coin-operate" style="display: none">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><font color="red">*</font>操作：</label>
                        <div class="col-sm-8">
                            <div class="radio-box">
                            <span>
                                <input type="radio" name="operateCoin" id="addCoin" value="1" checked="checked">
                                <label for="addCoin">充值</label>
                            </span>
                                <span>
                                <input type="radio" name="operateCoin" id="reduceCoin" value="0">
                                <label for="reduceCoin">扣费</label>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><font color="red">*</font>金额：</label>
                        <div class="col-sm-8">
                            <input id="gold_coin" class="form-control" placeholder="请填写充值金额" style="height:auto!important" type="number"/>
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">备注：</label>
                        <div class="col-sm-8">
                            <textarea name="recharge-remark" id="recharge_remark" cols="30" rows="3" placeholder="请填写备注" style="width: 100%"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><font color="red">*</font>密码：</label>
                        <div class="col-sm-8">
                            <input type="password" autocomplete="off" id="pwd" class="form-control" placeholder="请填写登录密码" style="height:auto!important" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary saveRecharge">保存</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/searchable/jquery.searchableSelect.js"></script>
<script type="text/javascript">
    /*设置会员等级*/
    $('#member-grade').searchableSelect();
    $("#content-con").on('click', 'a.set-membergrade', function(event) {
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
        $(".ui-popover.ui-popover-select").css({'left':left-conLeft-60,'top':top-conTop-96}).stop().show();
    });

    $("#content-con").on('click', function(event) {
        optshide();
    });

    /*隐藏设置会员弹出框*/
    function optshide(){
        $('.ui-popover').stop().hide();
    }

    function changeStatus(id,status){
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

    $(".ui-popover .js-save").on('click', function(event) {
        var level = $(".ui-popover #member-grade").val();
        var id    = $('#hid_mid').val();
        if(id>0 && level != 0){
            event.preventDefault();
            var data  = {
                'id'    : id,
                'level' : level
            };
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/member/changeLevel',
                'data'  : data,
                'dataType' : 'json',
                'success'  : function(ret){
                    layer.close(index);
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
                layer.msg('请选择用户');
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
                layer.msg('请选择用户');
                return false;
            }
        }else{
            $(".coin-operate").css('display','');
        }
        $('#hid_mid').val(mid);
        $('#recharge_type').val(type);
        $('#gold_coin_now').val(coinNow);
        $('#gold_coin').val('');
        $('#recharge_remark').val('');
        $('#pwd').val('');
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
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            type  : 'post',
            url   : postUrl,
            data  : data,
            dataType  : 'json',
            success : function (json_ret) {
                layer.close(index);
                layer.msg(json_ret.em);
                if(json_ret.ec == 200){
                    window.location.reload();
                }
            }
        });

    });

    //管理员操作余额
    $('.saveRecharge').on('click',function(){
        var mid    = $('#hid_mid').val();
        var coin   = $('#gold_coin').val();
        var coinNow= $('#gold_coin_now').val();
        var remark = $('#recharge_remark').val();
        var pwd    = $('#pwd').val();
        var type   = $('#recharge_type').val();
        var operate= $("input[name='operateCoin']:checked").val();
        if(!pwd){
            layer.msg('请填写登录密码');
            return false;
        }

        if(operate == 0 && parseFloat(coinNow) < parseFloat(coin)){
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
                layer.msg('请选择用户');
                return false;
            }
            postUrl = '/wxapp/member/saveMultiRecharge'
        }
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            type  : 'post',
            url   : postUrl,
            data  : data,
            dataType  : 'json',
            success : function (json_ret) {
                layer.close(index);
                layer.msg(json_ret.em);
                if(json_ret.ec == 200){
                    window.location.reload();
                }
            }
        });

    });

    //保存用户备注
    $('.save-remark').on('click',function(){
        var mid    = $(this).data('mid');
        var remark = $('#remark').val();
        var nickname = $('#nickname').val();
        var avatar = $('#cover').val();
        var source = $('#source').val();
        var data = {
            'mid'     : mid,
            'remark'  : remark,
            'nickname': nickname,
            'avatar'  : avatar,
            'source'  : source
        };
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            type  : 'post',
            url   : '/wxapp/member/saveRemark',
            data  : data,
            dataType  : 'json',
            success : function (json_ret) {
                layer.close(index);
                layer.msg(json_ret.em);
                if(json_ret.ec == 200){
                    window.location.reload();
                }
            }
        });

    });


    $('#change-cate').on('click',function(){
        var mid = $('#hide_mid').val();
        if(mid){
            $(this).attr('disabled','disabled');
            var data = {
                'mid' : mid,
                'cate': $('#custom_cate').val()
            };
            var url = '/wxapp/member/changeMemberCategory';
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : url,
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        $(this).removeAttr('disabled');
                    }
                }
            });
        }else{
            layer.msg('请选择用户');
        }
    });
</script>
<{include file="../img-upload-modal.tpl"}>


