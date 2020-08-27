<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/css/bindsetting.css">
<style>
    .table tbody tr td.good-name{
        white-space: normal;
        min-width: 300px;
    }
    .tuan-tag {
        background-color: #ea0000;
        border-radius: 2px;
        color: #fff;
        font-size: 12px;
        padding: 2px;
        position: relative;
        top: -1px;
    }
</style>
<{include file="../common-second-menu.tpl"}>
<div id="mainContent">
<div id="content-con">
    <div class="wrap">
        <div class="function" style="border: none;padding: 1px;">
            <div class="left">
                <table>
                    <tr>
                        <td class="title">团购商品：</td>
                        <td colspan="3"><{$group['g_name']}></td>
                    </tr>
                    <tr>
                        <td class="title">团购类型：</td>
                        <td><{$groupType[$group['gb_type']]['title']}></td>
                        <td class="title">团购价格：</td>
                        <td><{$group['gb_price']}></td>
                    </tr>
                    <tr>
                        <td class="title">要求参团人数：</td>
                        <td><{$group['gb_total']}> 人</td>
                        <td class="title">目前参与人数：</td>
                        <td><{$group['gb_joined']}> 人</td>
                    </tr>
                    <tr>
                        <td class="title">结束时间：</td>
                        <td><{date('Y-m-d',$group['gb_end_time'])}> </td>
                        <td class="title">活动状态：</td>
                        <td>
                            <{if $group['gb_end_time'] < time() }>
                            <span class="label label-sm label-default">已结束</span>
                            <{elseif $group['gb_start_time'] > time()}>
                            <span class="label label-sm label-info">尚未开始</span>
                            <{elseif $group['gb_start_time'] <= time() && $group['gb_end_time'] >= time()}>
                            <span class="label label-sm label-success">进行中</span>
                            <{/if}>
                        </td>
                    </tr>
                    <{if $group['gb_type'] eq 2 && $canMsg}> <!---抽奖团---->
                    <tr>
                        <td class="title">开奖退款：</td>
                        <td colspan="3">
                            <div class="remain-right">
                                <!--<div class="row">
                                    <input type="checkbox" class="cus-check" id="refund_type" value="1" checked><label for="tuikuan">自动全部退款</label></span>
                                </div>-->
                                <div class="row">
                                    <div class="col-xs-12">
                                        <p class="tips">（模板消息）</p>
                                        <select class="form-control" name="tktz_msgid" id="tktz_msgid">
                                            <option value="0">不发送</option>
                                            <{foreach $msg as $mal}>
                                            <option value="<{$mal['awt_id']}>" <{if $luckMsg && $luckMsg['gc_tktz_msgid'] eq $mal['awt_id']}>selected<{/if}>><{$mal['awt_title']}></option>
                                            <{/foreach}>
                                        </select>
                                    </div>
                                    <!--<div class="col-xs-6">
                                        <p class="tips">（图文消息）</p>
                                        <select class="form-control" name="tktz_nwid" id="tktz_nwid">
                                            <option value="0">不发送</option>
                                            <{foreach $graphic as $gal}>
                                            <option value="<{$gal['wn_id']}>" <{if $luckMsg && $luckMsg['gc_tktz_nwid'] eq $gal['wn_id']}>selected<{/if}>><{$gal['wn_title']}></option>
                                            <{/foreach}>
                                        </select>
                                    </div>-->
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="title">中奖结果推送：</td>
                        <td colspan="3">
                            <div class="remain-right">
                                <div class="radio-box" style="margin-bottom: 5px; <{$luckMsg['gc_push_type']}>">
                                <span>
                                    <input type="radio" name="push_type" id="choosenotice1" value="1" <{if !$luckMsg || ($luckMsg && $luckMsg['gc_push_type'] eq 1)}>checked<{/if}>>
                                    <label for="choosenotice1">推送给中奖者</label>
                                </span>
                                <span>
                                    <input type="radio" name="push_type" id="choosenotice2" value="2" <{if $luckMsg && $luckMsg['gc_push_type'] eq 2}>checked<{/if}>>
                                    <label for="choosenotice2">推送给全部参与者</label>
                                </span>
                                <span>
                                    <input type="radio" name="push_type" id="choosenotice3" value="3" <{if $luckMsg && $luckMsg['gc_push_type'] eq 3}>checked<{/if}>>
                                    <label for="choosenotice3">推送给成功参与者</label>
                                </span>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <p class="tips">（模板消息）</p>
                                        <select class="form-control" name="zjjg_msgid" id="zjjg_msgid">
                                            <option value="0">不发送</option>
                                            <{foreach $msg as $mal}>
                                            <option value="<{$mal['awt_id']}>" <{if $luckMsg && $luckMsg['gc_zjjg_msgid'] eq $mal['awt_id']}>selected<{/if}>><{$mal['awt_title']}></option>
                                            <{/foreach}>
                                        </select>
                                    </div>
                                    <!--<div class="col-xs-6">
                                        <p class="tips">（图文消息）</p>
                                        <select class="form-control" name="zjjg_nwid" id="zjjg_nwid">
                                            <option value="0">不发送</option>
                                            <{foreach $graphic as $gal}>
                                            <option value="<{$gal['wn_id']}>" <{if $luckMsg && $luckMsg['gc_zjjg_nwid'] eq $gal['wn_id']}>selected<{/if}>><{$gal['wn_title']}></option>
                                            <{/foreach}>
                                        </select>
                                    </div>-->
                                </div>
                            </div>
                        </td>
                    </tr>
                    <!--<tr>
                        <td class="title">礼券推送：</td>
                        <td colspan="3">
                            <div class="remain-right">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <p class="tips">（模板消息）</p>
                                        <select class="form-control" name="lqtz_msgid" id="lqtz_msgid">
                                            <option value="0">不发送</option>
                                            <{foreach $msg as $mal}>
                                            <option value="<{$mal['wt_id']}>" <{if $luckMsg && $luckMsg['gc_lqtz_msgid'] eq $mal['wt_id']}>selected<{/if}>><{$mal['wt_title']}></option>
                                            <{/foreach}>
                                        </select>
                                    </div>
                                    <div class="col-xs-6">
                                        <p class="tips">（图文消息）</p>
                                        <select class="form-control" name="lqtz_nwid" id="lqtz_nwid">
                                            <option value="0">不发送</option>
                                            <{foreach $graphic as $gal}>
                                            <option value="<{$gal['wn_id']}>" <{if $luckMsg && $luckMsg['gc_lqtz_nwid'] eq $gal['wn_id']}>selected<{/if}>><{$gal['wn_title']}></option>
                                            <{/foreach}>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>-->
                    <tr>
                        <td class="title">&nbsp;</td>
                        <td colspan="3">
                            <{if $group['gb_type'] eq 2  && ($group['gb_end_time'] <= $time['nextDay'])}>
                                <button type="button" class="btn btn-green good-luck-btn"> 开 奖 </button>
                            <{/if}>
                            <button type="button" class="btn btn-primary luck-btn">保存设置</button>
                        </td>
                    </tr>
                    <{/if}>
                </table>
            </div>
        </div>
    </div>
    <div ng-app="ShopIndex"  ng-controller="ShopInfoController">
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>团长</th>
                            <th>所需人数</th>
                            <th>已参与人数</th>
                            <th>
                                <i class="icon-time bigger-110 hidden-480"></i>
                                开始时间
                            </th>
                            <th>状态</th>
                            <th>
                                <i class="icon-time bigger-110 hidden-480"></i>
                                结束时间
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr>
                                <td><{$val['m_nickname']}></td>
                                <td><{$val['go_total']}></td>
                                <td><{$val['go_had']}>
                                    <{if $val['go_had'] > 0 }>
                                    <!-- <a href="/manage/group/mem/goid/<{$val['go_id']}>" >查看参与人</a> -->
                                    <a href="javascript:;" class="new-window" data-goid="<{$val['go_id']}>">查看参与人</a>
                                    <{/if}>
                                </td>
                                <td><{date('Y-m-d H:i:s',$val['go_create_time'])}></td>
                                <td>
                                    <{if $val['go_status'] == 1}>
                                    <span class="label label-sm label-success">成功</span>
                                    <{elseif $val['go_status'] == 2}>
                                    <span class="label label-sm label-danger">失败</span>
                                    <{elseif $val['go_status'] == 0}>
                                    <span class="label label-sm label-info">进行中</span>
                                    <{/if}>
                                </td>
                                <td><{if $val['go_over_time']}><{date('Y-m-d H:i',$val['go_over_time'])}><{/if}></td>
                            </tr>
                            <{/foreach}>
                            <tr><td colspan="13"><{$pageHtml}></td></tr>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
</div>
<!-- 开奖弹出层 -->
<div class="modal fade" id="myModalTuanuser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 680px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalTuanuserLabel">所有参与人</h4>
            </div>
            <div class="modal-body">
                <div class="tuan-userlist">
                    <ul class="clearfix" id="memUl">

                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary luck btn-luck-now">立即开奖</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/wxapp/mall/js/group.js"></script>
<script type="text/javascript" >
    $('.luck-btn').on('click',function(){
        var field = new Array('tktz','zjjg','lqtz');
        var data  = {};
        for(var i = 0 ; i < field.length ; i ++){
            data[field[i]+'_msgid'] = $('#'+field[i]+'_msgid').val();
            data[field[i]+'_nwid']  = $('#'+field[i]+'_nwid').val();
        }
        data['push_type']   = $('input[name="push_type"]:checked').val();
        data['refund_type'] = 1 ;
        data['gb_id']       = <{$group['gb_id']}> ;
        saveLuckMsg(data);
    });
    $('.new-window').on('click',function(){
        $('.luck').hide();
         var data = {
             'goid' : $(this).data('goid'),
             'type' : 'org'
         };
         getPartyMember(data);
    });
    $('.good-luck-btn').on('click',function(){
        $('.luck').show();
        var data = {
            'gbid' : <{$group['gb_id']}>,
            'type' : 'luck'
        };
        getPartyMember(data);
    })

    $('.btn-luck-now').on('click',function(){
        var i = 0,j= 0, ids = new Array(),all = new Array();
        $('input[name="gmids"]').each(function(){
            if($(this).is(":checked")){
                ids[i] = $(this).val();
                i ++ ;
            }
            all[j] = $(this).val();
            j ++ ;
        });
        if(i <= 0){
            layer.msg('请选择中奖用户');
            return false;
        }
        var data = {
            'gmids'     : ids.join(','),
            'allmid'    : all.join(','),
            'gbid'      : <{$group['gb_id']}>

        };
        saveMember(data);
    })

</script>


