<style>
    .form-group-box{
        overflow: auto;
    }
    .form-group-box .form-group{
        width: 260px;
        margin-right: 10px;
        float: left;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "开\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0关";
    }

    .table-hover>tbody>tr:hover>td, .table-hover>tbody>tr:hover>th {
        background-color: #fff;
    }

    .table-striped>tbody>tr:nth-child(odd)>td, .table-striped>tbody>tr:nth-child(odd)>th {
        background-color: #fff;
    }

    .table {
        border: 0;
    }

    .table thead tr th {
        border-right: 0;
    }

    .table thead>tr>th, .table tbody>tr>th, .table tfoot>tr>th, .table thead>tr>td, .table tbody>tr>td, .table tfoot>tr>td {
        border-bottom: 1px solid #ddd;
        border-top: 0;
    }

    .table thead>tr>th, .table tbody>tr>th, .table tfoot>tr>th, .table thead>tr>td, .table tbody>tr>td, .table tfoot>tr>td {
        padding: 15px 8px;
    }

    select.form-control {
        width: 60%;
        display: inline-block;
    }

    .alert.save-btn-box {
        border: 1px solid #F5F5AA;
        background-color: #FFFFCC;
        text-align: center;
        position: fixed;
        bottom: 0;
        left: 50%;
        margin-left: -453px;
        width: 870px;
        margin-bottom: 0;
        z-index: 200;
    }
    .table-responsive{
        padding-bottom: 40px;
    }
    .select-default-tplmsg{
        font-size: 14px;
        margin-left: 5px;
    }

</style>
<div ng-app="Withdraw"  ng-controller="WithdrawList">
    <div class="page-header" style="overflow:hidden">
        <h3 style="float: left">
            消息模板发送配置
        </h3>
        <!--
        <div style="float: right;margin-top: 20px;">
            <a class="btn btn-green btn-sm save-btn" href="javascript:;" style="padding: 5px 40px;">
                保存
            </a>
        </div>
        -->
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="sample-table-1" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-480">标题</th>
                        <th>模板</th>
                        <th>操作</th>
                    </tr>
                    </thead>

                    <tbody>
                        <{if $applet['ac_type']==22 }>
                        <tr>
                            <td>会务报名成功通知</td>
                            <td>
                                <select name="aws_meeting_bmcg_mid"  class="form-control">
                                    <option value="0">请选择消息模板</option>
                                    <{foreach $tplList as $val}>
                                <option value="<{$val['awt_id']}>" <{if $row && $row['aws_meeting_bmcg_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                    <{/foreach}>
                                </select>
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aws_meeting_bmcg_open" type="checkbox" <{if $row && $row['aws_meeting_bmcg_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                        <{/if}>

                        <{if $applet['ac_type']==1 || $applet['ac_type']==4 || $applet['ac_type']==3 || $applet['ac_type']==6 || $applet['ac_type']==8 || $applet['ac_type']==13 || $applet['ac_type']==18 || $applet['ac_type']==21 || $applet['ac_type']==24 || $applet['ac_type']==32 || $applet['ac_type'] == 27 || $applet['ac_type'] == 7}>
                        <tr>
                            <td>支付成功</td>
                            <td>
                                <select name="aws_zfcg_mid"  class="form-control">
                                    <option value="0">请选择消息模板</option>
                                    <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_zfcg_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                    <{/foreach}>
                                </select>
                                <{if $applet['ac_type'] != 27 && $menuType != 'weixin'}>
                                <span><a href="JavaScript:;" class="select-default-tplmsg" data-field="aws_zfcg_mid" data-type='zfcg' >设置默认模板</a></span>
                                <{/if}>
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aws_zfcg_open" type="checkbox" <{if $row && $row['aws_zfcg_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>

                        <tr>
                            <td>退款通知</td>
                            <td>
                                <select name="aws_refund_mid"  class="form-control">
                                    <option value="0">请选择消息模板</option>
                                    <{foreach $tplList as $val}>
                                <option value="<{$val['awt_id']}>" <{if $row && $row['aws_refund_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                    <{/foreach}>
                                </select>
                                <{if $menuType != 'weixin'}>
                                <span><a href="JavaScript:;" class="select-default-tplmsg" data-field="aws_refund_mid" data-type='refund' >设置默认模板</a></span>
                                <{/if}>
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aws_refund_open" type="checkbox" <{if $row && $row['aws_refund_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                        <{if $applet['ac_type']!=32}>
                        <tr>
                            <td>卖家发货</td>
                            <td>
                                <select name="aws_mjfh_mid"  class="form-control">
                                    <option value="0">请选择消息模板</option>
                                    <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_mjfh_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                    <{/foreach}>
                                </select>
                                <{if $menuType != 'weixin'}>
                                <span><a href="JavaScript:;" class="select-default-tplmsg" data-field="aws_mjfh_mid" data-type='mjfh' >设置默认模板</a></span>
                                <{/if}>
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aws_mjfh_open"  type="checkbox" <{if $row && $row['aws_mjfh_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>确认收货</td>
                            <td>
                                <select name="aws_qrsh_mid"  class="form-control">
                                    <option value="0">请选择消息模板</option>
                                    <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_qrsh_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                    <{/foreach}>
                                </select>
                                <{if $menuType != 'weixin'}>
                                <span><a href="JavaScript:;" class="select-default-tplmsg" data-field="aws_qrsh_mid" data-type='qrsh' >设置默认模板</a></span>
                                <{/if}>
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aws_qrsh_open"  type="checkbox" <{if $row && $row['aws_qrsh_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                        <{/if}>
                        <{elseif $applet['ac_type'] == 12}>
                            <tr>
                                <td>支付成功</td>
                                <td>
                                    <select name="aws_zfcg_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_zfcg_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                    <{if $menuType != 'weixin'}>
                                    <span><a href="JavaScript:;" class="select-default-tplmsg" data-field="aws_zfcg_mid" data-type='zfcg' >设置默认模板</a></span>
                                    <{/if}>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_zfcg_open" type="checkbox" <{if $row && $row['aws_zfcg_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>退款通知</td>
                                <td>
                                    <select name="aws_refund_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_refund_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                    <{if $menuType != 'weixin'}>
                                    <span><a href="JavaScript:;" class="select-default-tplmsg" data-field="aws_refund_mid" data-type='refund' >设置默认模板</a></span>
                                    <{/if}>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_refund_open" type="checkbox" <{if $row && $row['aws_refund_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                        <{/if}>
                        <{if $applet['ac_type']==6 || $applet['ac_type']==21 || $applet['ac_type'] == 12}>
                            <tr>
                                <td>分销佣金通知</td>
                                <td>
                                    <select name="aws_deduct_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_deduct_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                    <{if $menuType != 'weixin'}>
                                    <span><a href="JavaScript:;" class="select-default-tplmsg" data-field="aws_deduct_mid" data-type='deduct' >设置默认模板</a></span>
                                    <{/if}>

                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_deduct_open"  type="checkbox" <{if $row && $row['aws_deduct_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                        <{/if}>
                        <{if $applet['ac_type']!=32}>
                        <tr>
                            <td>充值成功</td>
                            <td>
                                <select name="aws_recharge_mid"  class="form-control">
                                    <option value="0">请选择消息模板</option>
                                    <{foreach $tplList as $val}>
                                <option value="<{$val['awt_id']}>" <{if $row && $row['aws_recharge_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                    <{/foreach}>
                                </select>
                                <{if $menuType != 'weixin'}>
                                <span><a href="JavaScript:;" class="select-default-tplmsg" data-field="aws_recharge_mid" data-type='recharge' >设置默认模板</a></span>
                                <{/if}>

                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aws_recharge_open" type="checkbox" <{if $row && $row['aws_recharge_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                        <{/if}>
                        <tr>
                            <td>资讯推送</td>
                            <td>
                                <select name="aws_push_mid"  class="form-control">
                                    <option value="0">请选择消息模板</option>
                                    <{foreach $tplList as $val}>
                                <option value="<{$val['awt_id']}>" <{if $row && $row['aws_push_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                    <{/foreach}>
                                </select>
                                <{if $menuType != 'weixin'}>
                                <span><a href="JavaScript:;" class="select-default-tplmsg" data-field="aws_push_mid" data-type='push' >设置默认模板</a></span>
                                <{/if}>
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aws_push_open"  type="checkbox" <{if $row && $row['aws_push_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                        <{if $applet['ac_type']==6 || $applet['ac_type']==8 || $applet['ac_type']==28}>
                        <tr>
                            <td>入驻店铺审核</td>
                            <td>
                                <select name="aws_audit_mid"  class="form-control">
                                    <option value="0">请选择消息模板</option>
                                    <{foreach $tplList as $val}>
                                <option value="<{$val['awt_id']}>" <{if $row && $row['aws_audit_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                    <{/foreach}>
                                </select>
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aws_audit_open"  type="checkbox" <{if $row && $row['aws_audit_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                        <{/if}>
                        <{if $applet['ac_type']==6 || $applet['ac_type']==8}>

                            <tr>
                                <td>帖子评论</td>
                                <td>
                                    <select name="aws_comment_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_comment_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                    <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_comment_open"  type="checkbox" <{if $row && $row['aws_comment_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>帖子推送</td>
                                <td>
                                    <select name="aws_post_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_post_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_post_open"  type="checkbox" <{if $row && $row['aws_post_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                        <{/if}>
                        <{if $applet['ac_type']==8 || $applet['ac_type']==6}>
                            <tr>
                                <td>商家推送</td>
                                <td>
                                    <select name="aws_shop_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_shop_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_shop_open"  type="checkbox" <{if $row && $row['aws_shop_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                        <{/if}>
                        <{if $applet['ac_type']==6}>
                            <tr>
                                <td>入驻店铺到期提醒</td>
                                <td>
                                    <select name="aws_sexpire_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_sexpire_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_sexpire_open"  type="checkbox" <{if $row && $row['aws_sexpire_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>帖子点赞</td>
                                <td>
                                    <select name="aws_like_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_like_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_like_open"  type="checkbox" <{if $row && $row['aws_like_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>帖子赞赏</td>
                                <td>
                                    <select name="aws_reward_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_reward_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_reward_open"  type="checkbox" <{if $row && $row['aws_reward_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>店铺评论通知</td>
                                <td>
                                    <select name="aws_shop_comment_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_shop_comment_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_shop_comment_open"  type="checkbox" <{if $row && $row['aws_shop_comment_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>

                            <tr>
                                <td>电话本入驻审核通知</td>
                                <td>
                                    <select name="aws_mobile_audit_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_mobile_audit_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_mobile_audit_open"  type="checkbox" <{if $row && $row['aws_mobile_audit_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>

                            <tr>
                                <td>店铺认领审核通知</td>
                                <td>
                                    <select name="aws_shop_claim_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_shop_claim_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_shop_claim_open"  type="checkbox" <{if $row && $row['aws_shop_claim_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>

                            <!--<tr>
                                <td>转发帖子</td>
                                <td>
                                    <select name="aws_like_mid"  class="form-control">
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_share_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_like_open"  type="checkbox" <{if $row && $row['aws_share_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>-->
                        <{/if}>
                        <{if $applet['ac_type'] == 6 || $applet['ac_type'] == 32}>
                        <tr>
                            <td>答题推送</td>
                            <td>
                                <select name="aws_answer_mid"  class="form-control">
                                    <option value="0">请选择消息模板</option>
                                    <{foreach $tplList as $val}>
                                <option value="<{$val['awt_id']}>" <{if $row && $row['aws_answer_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                    <{/foreach}>
                                </select>
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aws_answer_open"  type="checkbox" <{if $row && $row['aws_answer_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                        <{/if}>
                        <{if $applet['ac_type']==3 || $applet['ac_type']==19}>
                            <tr>
                                <td>产品服务</td>
                                <td>
                                    <select name="aws_service_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_service_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_service_open"  type="checkbox" <{if $row && $row['aws_service_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                        <{/if}>
                        <{if $applet['ac_type']==23 || $applet['ac_type'] == 13}>
                            <tr>
                                <td>店铺动态</td>
                                <td>
                                    <select name="aws_dynamic_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_dynamic_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_dynamic_open"  type="checkbox" <{if $row && $row['aws_dynamic_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                            <{/if}>
                        <{if $applet['ac_type']!=23 && $applet['ac_type']!=19 && $applet['ac_type']!=24 && $applet['ac_type']!=20 && $applet['ac_type']!=28 && $applet['ac_type']!=32 && $applet['ac_type']!=34 }>
                        <tr>
                            <td>付费预约</td>
                            <td>
                                <select name="aws_appointment_mid"  class="form-control">
                                    <option value="0">请选择消息模板</option>
                                    <{foreach $tplList as $val}>
                                <option value="<{$val['awt_id']}>" <{if $row && $row['aws_appointment_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                    <{/foreach}>
                                </select>
                                <{if $menuType != 'weixin'}>
                                <span><a href="JavaScript:;" class="select-default-tplmsg" data-field="aws_appointment_mid" data-type='appointment' >设置默认模板</a></span>
                                <{/if}>
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aws_appointment_open"  type="checkbox" <{if $row && $row['aws_appointment_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                        <!--<tr>
                            <td>付费预约提醒</td>
                            <td>
                                <select name="aws_appointment_remind_mid"  class="form-control">
                                    <option value="0">请选择消息模板</option>
                                    <{foreach $tplList as $val}>
                                <option value="<{$val['awt_id']}>" <{if $row && $row['aws_appointment_remind_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                    <{/foreach}>
                                </select>
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aws_appointment_remind_open"  type="checkbox" <{if $row && $row['aws_appointment_remind_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>-->
                        <{if $applet['ac_type'] != 16 && $applet['ac_type'] != 34}>
                            <tr>
                                <td>抽奖活动</td>
                                <td>
                                    <select name="aws_lottery_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_lottery_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_lottery_open"  type="checkbox" <{if $row && $row['aws_lottery_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                        <{/if}>
                        <{/if}>
                        <{if !in_array($menuType,['weixin'])}>
                        <tr>
                            <td>版本更新</td>
                            <td>
                                <select name="aws_upgrade_mid"  class="form-control">
                                    <option value="0">请选择消息模板</option>
                                    <{foreach $tplList as $val}>
                                <option value="<{$val['awt_id']}>" <{if $row && $row['aws_upgrade_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                    <{/foreach}>
                                </select>
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aws_upgrade_open"  type="checkbox" <{if $row && $row['aws_upgrade_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                        <{/if}>
                        <{if $applet['ac_type']!=20 && $applet['ac_type']!=22 && $applet['ac_type']!=28 && $applet['ac_type'] != 32 && $appletCfg['ac_type'] != 36 && $applet['ac_type'] != 16 && $applet['ac_type'] != 34}>
                        <tr>
                            <{if $applet['ac_type'] == 27}>
                            <td>课程推送</td>
                            <{else}>
                            <td>商品推送</td>
                            <{/if}>

                            <td>
                                <select name="aws_goods_mid"  class="form-control">
                                    <option value="0">请选择消息模板</option>
                                    <{foreach $tplList as $val}>
                                <option value="<{$val['awt_id']}>" <{if $row && $row['aws_goods_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                    <{/foreach}>
                                </select>
                                <{if $menuType != 'weixin'}>
                                <span><a href="JavaScript:;" class="select-default-tplmsg" data-field="aws_goods_mid" data-type='goods' >设置默认模板</a></span>
                                <{/if}>

                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aws_goods_open"  type="checkbox" <{if $row && $row['aws_goods_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                        <{/if}>
                        <{if $applet['ac_type'] == 16}>
                            <tr>
                                <td>房源推送</td>
                                <td>
                                    <select name="aws_fpush_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_fpush_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_fpush_open"  type="checkbox" <{if $row && $row['aws_fpush_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                            <{/if}>
                        <{if $applet['ac_type']==6 || $applet['ac_type']==4 || $applet['ac_type']==7 || $applet['ac_type']==8 || $applet['ac_type']==13 || $applet['ac_type']==21 || $applet['ac_type'] == 12}>
                        <tr>
                            <td>拼团活动推送</td>
                            <td>
                                <select name="aws_group_mid"  class="form-control">
                                    <option value="0">请选择消息模板</option>
                                    <{foreach $tplList as $val}>
                                <option value="<{$val['awt_id']}>" <{if $row && $row['aws_group_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                    <{/foreach}>
                                </select>
                                <{if $menuType != 'weixin'}>
                                <span><a href="JavaScript:;" class="select-default-tplmsg" data-field="aws_group_mid" data-type='group' >设置默认模板</a></span>
                                <{/if}>
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aws_group_open"  type="checkbox" <{if $row && $row['aws_group_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                        <{/if}>
                        <{if $applet['ac_type']==6 || $applet['ac_type']==4 || $applet['ac_type']==7 || $applet['ac_type']==8 || $applet['ac_type']==13 || $applet['ac_type']==18 || $applet['ac_type']==21 || $applet['ac_type']==32 || $applet['ac_type'] == 12}>
                        <tr>
                            <td>秒杀活动推送</td>
                            <td>
                                <select name="aws_limit_mid"  class="form-control">
                                    <option value="0">请选择消息模板</option>
                                    <{foreach $tplList as $val}>
                                <option value="<{$val['awt_id']}>" <{if $row && $row['aws_limit_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                    <{/foreach}>
                                </select>
                                <{if $menuType != 'weixin'}>
                                <span><a href="JavaScript:;" class="select-default-tplmsg" data-field="aws_limit_mid" data-type='limit' >设置默认模板</a></span>
                                <{/if}>
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aws_limit_open"  type="checkbox" <{if $row && $row['aws_limit_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                        <{/if}>
                        <{if $applet['ac_type']==6 || $applet['ac_type']==21 || $applet['ac_type']==18 || $applet['ac_type']==4 || $applet['ac_type']==7 || $applet['ac_type']==32 || $applet['ac_type'] == 12}>
                        <tr>
                            <td>砍价活动推送</td>
                            <td>
                                <select name="aws_bargain_mid"  class="form-control">
                                    <option value="0">请选择消息模板</option>
                                    <{foreach $tplList as $val}>
                                <option value="<{$val['awt_id']}>" <{if $row && $row['aws_bargain_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                    <{/foreach}>
                                </select>
                                <{if $menuType != 'weixin'}>
                                <span><a href="JavaScript:;" class="select-default-tplmsg" data-field="aws_bargain_mid" data-type='bargain' >设置默认模板</a></span>
                                <{/if}>
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aws_bargain_open"  type="checkbox" <{if $row && $row['aws_bargain_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                        <{/if}>
                        <{if $applet['ac_type']!=20 && $applet['ac_type']!=28 && !$applet['ac_type'] != 32 && $appletCfg['ac_type'] != 36 && $applet['ac_type']!=16}>
                        <tr>
                            <td>优惠券推送</td>
                            <td>
                                <select name="aws_coupon_mid"  class="form-control">
                                    <option value="0">请选择消息模板</option>
                                    <{foreach $tplList as $val}>
                                <option value="<{$val['awt_id']}>" <{if $row && $row['aws_coupon_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                    <{/foreach}>
                                </select>
                                <{if $menuType != 'weixin'}>
                                <span><a href="JavaScript:;" class="select-default-tplmsg" data-field="aws_coupon_mid" data-type='coupon' >设置默认模板</a></span>
                                <{/if}>
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aws_coupon_open"  type="checkbox" <{if $row && $row['aws_coupon_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                        <{if $applet['ac_type']!=22}>
                        <tr>
                            <td>购买会员卡通知</td>
                            <td>
                                <select name="aws_buy_member_card_mid"  class="form-control">
                                    <option value="0">请选择消息模板</option>
                                    <{foreach $tplList as $val}>
                                <option value="<{$val['awt_id']}>" <{if $row && $row['aws_buy_member_card_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                    <{/foreach}>
                                </select>
                                <{if $menuType != 'weixin'}>
                                <span><a href="JavaScript:;" class="select-default-tplmsg" data-field="aws_buy_member_card_mid" data-type='buy_member_card' >设置默认模板</a></span>
                                <{/if}>
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aws_buy_member_card_open"  type="checkbox" <{if $row && $row['aws_buy_member_card_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                        <{/if}>
                        <{/if}>
                        <{if $applet['ac_type']==6 || $applet['ac_type']==28 || $applet['ac_type']==33}>
                            <tr>
                                <td>私信通知推送</td>
                                <td>
                                    <select name="aws_chat_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_chat_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_chat_open"  type="checkbox" <{if $row && $row['aws_chat_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                            <{/if}>
                        <{if $applet['ac_type'] ==20 }>
                            <tr>
                                <td>工单已创建</td>
                                <td>
                                    <select name="aws_work_order_create_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_work_order_create_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_work_order_create_open"  type="checkbox" <{if $row && $row['aws_work_order_create_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>工单处理中</td>
                                <td>
                                    <select name="aws_work_order_dealing_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_work_order_dealing_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_work_order_dealing_open"  type="checkbox" <{if $row && $row['aws_work_order_dealing_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>工单已完成</td>
                                <td>
                                    <select name="aws_work_order_finish_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_work_order_finish_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_work_order_finish_open"  type="checkbox" <{if $row && $row['aws_work_order_finish_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>工单评论</td>
                                <td>
                                    <select name="aws_work_order_comment_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_work_order_comment_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_work_order_comment_open"  type="checkbox" <{if $row && $row['aws_work_order_comment_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                        <{/if}>
                        <{if $applet['ac_type'] ==28 }>
                            <tr>
                                <td>投递状态变化</td>
                                <td>
                                    <select name="aws_job_send_change_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_job_send_change_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_job_send_change_open"  type="checkbox" <{if $row && $row['aws_job_send_change_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>推荐成功</td>
                                <td>
                                    <select name="aws_job_recommend_success_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_job_recommend_success_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_job_recommend_success_open"  type="checkbox" <{if $row && $row['aws_job_recommend_success_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>职位推送</td>
                                <td>
                                    <select name="aws_job_position_push_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_job_position_push_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_job_position_push_open"  type="checkbox" <{if $row && $row['aws_job_position_push_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>简历被浏览</td>
                                <td>
                                    <select name="aws_job_resume_show_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_job_resume_show_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_job_resume_show_open"  type="checkbox" <{if $row && $row['aws_job_resume_show_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                        <{/if}>
                        <{if $applet['ac_type'] == 32}>
                        <!--
                            <tr>
                                <td>发起活动成功</td>
                                <td>
                                    <select name="aws_se_create_activity_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_se_create_activity_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_se_create_activity_open"  type="checkbox" <{if $row && $row['aws_se_create_activity_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>参与活动成功</td>
                                <td>
                                    <select name="aws_se_join_activity_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_se_join_activity_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_se_join_activity_open"  type="checkbox" <{if $row && $row['aws_se_join_activity_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                            -->
                            <tr style="">
                                <td>订单核销</td>
                                <td>
                                    <select name="aws_se_trade_verify_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_se_trade_verify_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                    <{if $menuType != 'weixin'}>
                                    <span><a href="JavaScript:;" class="select-default-tplmsg" data-field="aws_se_trade_verify_mid" data-type='se_trade_verify' >设置默认模板</a></span>
                                    <{/if}>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_se_trade_verify_open"  type="checkbox" <{if $row && $row['aws_se_trade_verify_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                            <tr style="">
                                <td>订单通知团长</td>
                                <td>
                                    <select name="aws_se_notice_leader_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_se_notice_leader_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                    <{if $menuType != 'weixin'}>
                                    <span><a href="JavaScript:;" class="select-default-tplmsg" data-field="aws_se_notice_leader_mid" data-type='se_notice_leader' >设置默认模板</a></span>
                                    <{/if}>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_se_notice_leader_open"  type="checkbox" <{if $row && $row['aws_se_notice_leader_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                            <tr style="">
                                <td>商品到货通知</td>
                                <td>
                                    <select name="aws_se_goods_get_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_se_goods_get_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                    <{if $menuType != 'weixin'}>
                                    <span><a href="JavaScript:;" class="select-default-tplmsg" data-field="aws_se_goods_get_mid" data-type='se_goods_get' >设置默认模板</a></span>
                                    <{/if}>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_se_goods_get_open"  type="checkbox" <{if $row && $row['aws_se_goods_get_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>

                            <tr>
                                <td>团长申请审核</td>
                                <td>
                                    <select name="aws_leader_handle_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_leader_handle_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                    <{if $menuType != 'weixin'}>
                                    <span><a href="JavaScript:;" class="select-default-tplmsg" data-field="aws_leader_handle_mid" data-type='leader_handle' >设置默认模板</a></span>
                                    <{/if}>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_leader_handle_open"  type="checkbox" <{if $row && $row['aws_leader_handle_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                        <{/if}>
                        <{if $applet['ac_type'] == 4 || $applet['ac_type'] == 6 || $applet['ac_type'] == 8}>
                            <tr style="">
                                <td>取号成功</td>
                                <td>
                                    <select name="aws_meal_start_queue_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_meal_start_queue_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_meal_start_queue_open"  type="checkbox" <{if $row && $row['aws_meal_start_queue_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                            <tr style="">
                                <td>叫号通知</td>
                                <td>
                                    <select name="aws_meal_call_queue_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_meal_call_queue_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_meal_call_queue_open"  type="checkbox" <{if $row && $row['aws_meal_call_queue_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                        <{/if}>
                        <{if $applet['ac_type'] == 21 }>
                            <tr style="">
                                <td>积分变更通知</td>
                                <td>
                                    <select name="aws_points_change_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_points_change_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                    <{if $menuType != 'weixin'}>
                                    <span><a href="JavaScript:;" class="select-default-tplmsg" data-field="aws_points_change_mid" data-type='points_change' >设置默认模板</a></span>
                                    <{/if}>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_points_change_open"  type="checkbox" <{if $row && $row['aws_points_change_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                            <tr style="">
                                <td>余额变更通知</td>
                                <td>
                                    <select name="aws_coin_change_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_coin_change_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                    <{if $menuType != 'weixin'}>
                                    <span><a href="JavaScript:;" class="select-default-tplmsg" data-field="aws_coin_change_mid" data-type='coin_change' >设置默认模板</a></span>
                                    <{/if}>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_coin_change_open"  type="checkbox" <{if $row && $row['aws_coin_change_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                        <{/if}>

                        <{if $applet['ac_type'] == 34 }>
                            <tr style="">
                                <td>订单支付通知</td>
                                <td>
                                    <select name="aws_legwork_pay_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_legwork_pay_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_legwork_pay_open"  type="checkbox" <{if $row && $row['aws_legwork_pay_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                            <tr style="">
                                <td>骑手接单通知</td>
                                <td>
                                    <select name="aws_legwork_take_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_legwork_take_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_legwork_take_open"  type="checkbox" <{if $row && $row['aws_legwork_take_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                            <tr style="">
                                <td>骑手已取货通知</td>
                                <td>
                                    <select name="aws_legwork_get_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_legwork_get_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_legwork_get_open"  type="checkbox" <{if $row && $row['aws_legwork_get_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                            <tr style="">
                                <td>订单确认通知</td>
                                <td>
                                    <select name="aws_legwork_finish_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_legwork_finish_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_legwork_finish_open"  type="checkbox" <{if $row && $row['aws_legwork_finish_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                            <tr style="">
                                <td>订单取消通知</td>
                                <td>
                                    <select name="aws_legwork_cancel_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_legwork_cancel_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_legwork_cancel_open"  type="checkbox" <{if $row && $row['aws_legwork_cancel_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                            <tr style="">
                                <td>邀请成功通知</td>
                                <td>
                                    <select name="aws_share_success_mid"  class="form-control">
                                        <option value="0">请选择消息模板</option>
                                        <{foreach $tplList as $val}>
                                    <option value="<{$val['awt_id']}>" <{if $row && $row['aws_share_success_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                        <{/foreach}>
                                    </select>
                                </td>
                                <td>
                                    <input  class="ace ace-switch ace-switch-5" name="aws_share_success_open"  type="checkbox" <{if $row && $row['aws_share_success_open'] == 1}>checked<{/if}>>
                                    <span class="lbl"></span>
                                </td>
                            </tr>
                        <{/if}>
                        <tr style="">
                            <td>留言表单处理结果</td>
                            <td>
                                <select name="aws_form_deal_mid"  class="form-control">
                                    <option value="0">请选择消息模板</option>
                                    <{foreach $tplList as $val}>
                                <option value="<{$val['awt_id']}>" <{if $row && $row['aws_form_deal_mid'] == $val['awt_id']}>selected<{/if}>><{$val['awt_title']}></option>
                                    <{/foreach}>
                                </select>
                                <{if $menuType != 'weixin'}>
                                <span><a href="JavaScript:;" class="select-default-tplmsg" data-field="aws_form_deal_mid" data-type='form_deal' >设置默认模板</a></span>
                                <{/if}>
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aws_form_deal_open"  type="checkbox" <{if $row && $row['aws_form_deal_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
        </div><!-- /span -->
    </div><!-- /row -->

</div>
<div class="alert alert-warning save-btn-box" role="alert" style="text-align: center;">
    <button class="btn btn-primary btn-sm save-btn">保存</button>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js" ></script>

<script type="text/javascript" language="javascript">

    $('.save-btn').on('click',function(){
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        },{time:10*1000});
        var data = {
            'zfcg_open': $('input[name=aws_zfcg_open]').is(':checked')?1:0,
            'zfcg_mid': $('select[name=aws_zfcg_mid]').val(),
            'mjfh_open': $('input[name=aws_mjfh_open]').is(':checked')?1:0,
            'mjfh_mid': $('select[name=aws_mjfh_mid]').val(),
            'qrsh_open': $('input[name=aws_qrsh_open]').is(':checked')?1:0,
            'qrsh_mid': $('select[name=aws_qrsh_mid]').val(),
            'audit_open': $('input[name=aws_audit_open]').is(':checked')?1:0,
            'audit_mid': $('select[name=aws_audit_mid]').val(),
            'comment_open': $('input[name=aws_comment_open]').is(':checked')?1:0,
            'comment_mid': $('select[name=aws_comment_mid]').val(),
            'like_open': $('input[name=aws_like_open]').is(':checked')?1:0,
            'like_mid': $('select[name=aws_like_mid]').val(),
            'reward_open': $('input[name=aws_reward_open]').is(':checked')?1:0,
            'reward_mid': $('select[name=aws_reward_mid]').val(),
            'push_open': $('input[name=aws_push_open]').is(':checked')?1:0,
            'push_mid': $('select[name=aws_push_mid]').val(),
            'sexpire_open': $('input[name=aws_sexpire_open]').is(':checked')?1:0,
            'sexpire_mid': $('select[name=aws_sexpire_mid]').val(),
            'service_open': $('input[name=aws_service_open]').is(':checked')?1:0,
            'service_mid': $('select[name=aws_service_mid]').val(),
            'lottery_open': $('input[name=aws_lottery_open]').is(':checked')?1:0,
            'lottery_mid': $('select[name=aws_lottery_mid]').val(),
            'appointment_open': $('input[name=aws_appointment_open]').is(':checked')?1:0,
            'appointment_mid': $('select[name=aws_appointment_mid]').val(),
            'appointment_remind_open': $('input[name=aws_appointment_remind_open]').is(':checked')?1:0,
            'appointment_remind_mid': $('select[name=aws_appointment_remind_mid]').val(),
            'upgrade_open': $('input[name=aws_upgrade_open]').is(':checked')?1:0,
            'upgrade_mid': $('select[name=aws_upgrade_mid]').val(),
            'goods_open': $('input[name=aws_goods_open]').is(':checked')?1:0,
            'goods_mid': $('select[name=aws_goods_mid]').val(),
            'group_open': $('input[name=aws_group_open]').is(':checked')?1:0,
            'group_mid': $('select[name=aws_group_mid]').val(),
            'limit_open': $('input[name=aws_limit_open]').is(':checked')?1:0,
            'limit_mid': $('select[name=aws_limit_mid]').val(),
            'bargain_open': $('input[name=aws_bargain_open]').is(':checked')?1:0,
            'bargain_mid': $('select[name=aws_bargain_mid]').val(),
            'post_open': $('input[name=aws_post_open]').is(':checked')?1:0,
            'post_mid': $('select[name=aws_post_mid]').val(),
            'shop_open': $('input[name=aws_shop_open]').is(':checked')?1:0,
            'shop_mid': $('select[name=aws_shop_mid]').val(),
            'coupon_open': $('input[name=aws_coupon_open]').is(':checked')?1:0,
            'coupon_mid': $('select[name=aws_coupon_mid]').val(),
            'answer_open': $('input[name=aws_answer_open]').is(':checked')?1:0,
            'answer_mid': $('select[name=aws_answer_mid]').val(),
            'dynamic_open': $('input[name=aws_dynamic_open]').is(':checked')?1:0,
            'dynamic_mid': $('select[name=aws_dynamic_mid]').val(),
            'recharge_open': $('input[name=aws_recharge_open]').is(':checked')?1:0,
            'recharge_mid': $('select[name=aws_recharge_mid]').val(),
            'refund_open': $('input[name=aws_refund_open]').is(':checked')?1:0,
            'refund_mid': $('select[name=aws_refund_mid]').val(),
            'deduct_open': $('input[name=aws_deduct_open]').is(':checked')?1:0,
            'deduct_mid': $('select[name=aws_deduct_mid]').val(),
            'work_order_create_open': $('input[name=aws_work_order_create_open]').is(':checked')?1:0,
            'work_order_create_mid': $('select[name=aws_work_order_create_mid]').val(),
            'work_order_dealing_open': $('input[name=aws_work_order_dealing_open]').is(':checked')?1:0,
            'work_order_dealing_mid': $('select[name=aws_work_order_dealing_mid]').val(),
            'work_order_finish_open': $('input[name=aws_work_order_finish_open]').is(':checked')?1:0,
            'work_order_finish_mid': $('select[name=aws_work_order_finish_mid]').val(),
            'work_order_comment_open': $('input[name=aws_work_order_comment_open]').is(':checked')?1:0,
            'work_order_comment_mid': $('select[name=aws_work_order_comment_mid]').val(),
            'job_send_change_open': $('input[name=aws_job_send_change_open]').is(':checked')?1:0,
            'job_send_change_mid': $('select[name=aws_job_send_change_mid]').val(),
            'job_recommend_success_open': $('input[name=aws_job_recommend_success_open]').is(':checked')?1:0,
            'job_recommend_success_mid': $('select[name=aws_job_recommend_success_mid]').val(),
            'job_position_push_open': $('input[name=aws_job_position_push_open]').is(':checked')?1:0,
            'job_position_push_mid': $('select[name=aws_job_position_push_mid]').val(),
            'se_create_activity_open': $('input[name=aws_se_create_activity_open]').is(':checked')?1:0,
            'se_create_activity_mid': $('select[name=aws_se_create_activity_mid]').val(),
            'se_join_activity_open': $('input[name=aws_se_join_activity_open]').is(':checked')?1:0,
            'se_join_activity_mid': $('select[name=aws_se_join_activity_mid]').val(),
            'se_trade_verify_open': $('input[name=aws_se_trade_verify_open]').is(':checked')?1:0,
            'se_trade_verify_mid': $('select[name=aws_se_trade_verify_mid]').val(),
            'se_notice_leader_open': $('input[name=aws_se_notice_leader_open]').is(':checked')?1:0,
            'se_notice_leader_mid': $('select[name=aws_se_notice_leader_mid]').val(),
            'se_goods_get_open': $('input[name=aws_se_goods_get_open]').is(':checked')?1:0,
            'se_goods_get_mid': $('select[name=aws_se_goods_get_mid]').val(),
            'fpush_open': $('input[name=aws_fpush_open]').is(':checked')?1:0,
            'fpush_mid': $('select[name=aws_fpush_mid]').val(),
            'chat_open': $('input[name=aws_chat_open]').is(':checked')?1:0,
            'chat_mid': $('select[name=aws_chat_mid]').val(),
            'legwork_pay_open': $('input[name=aws_legwork_pay_open]').is(':checked')?1:0,
            'legwork_pay_mid': $('select[name=aws_legwork_pay_mid]').val(),
            'legwork_take_open': $('input[name=aws_legwork_take_open]').is(':checked')?1:0,
            'legwork_take_mid': $('select[name=aws_legwork_take_mid]').val(),
            'legwork_get_open': $('input[name=aws_legwork_get_open]').is(':checked')?1:0,
            'legwork_get_mid': $('select[name=aws_legwork_get_mid]').val(),
            'legwork_cancel_open': $('input[name=aws_legwork_cancel_open]').is(':checked')?1:0,
            'legwork_cancel_mid': $('select[name=aws_legwork_cancel_mid]').val(),
            'legwork_finish_open': $('input[name=aws_legwork_finish_open]').is(':checked')?1:0,
            'legwork_finish_mid': $('select[name=aws_legwork_finish_mid]').val(),
            'share_success_open': $('input[name=aws_share_success_open]').is(':checked')?1:0,
            'share_success_mid': $('select[name=aws_share_success_mid]').val(),
            'job_resume_show_open': $('input[name=aws_job_resume_show_open]').is(':checked')?1:0,
            'job_resume_show_mid': $('select[name=aws_job_resume_show_mid]').val(),
            'meal_start_queue_open': $('input[name=aws_meal_start_queue_open]').is(':checked')?1:0,
            'meal_start_queue_mid': $('select[name=aws_meal_start_queue_mid]').val(),
            'meal_call_queue_open': $('input[name=aws_meal_call_queue_open]').is(':checked')?1:0,
            'meal_call_queue_mid': $('select[name=aws_meal_call_queue_mid]').val(),
            'buy_member_card_open': $('input[name=aws_buy_member_card_open]').is(':checked')?1:0,
            'buy_member_card_mid': $('select[name=aws_buy_member_card_mid]').val(),
            'leader_handle_open': $('input[name=aws_leader_handle_open]').is(':checked')?1:0,
            'leader_handle_mid': $('select[name=aws_leader_handle_mid]').val(),
            'points_change_mid': $('select[name=aws_points_change_mid]').val(),
            'points_change_open': $('input[name=aws_points_change_open]').is(':checked')?1:0,
            'coin_change_mid': $('select[name=aws_coin_change_mid]').val(),
            'coin_change_open': $('input[name=aws_coin_change_open]').is(':checked')?1:0,
            'meeting_bmcg_mid': $('select[name=aws_meeting_bmcg_mid]').val(),
            'meeting_bmcg_open': $('input[name=aws_meeting_bmcg_open]').is(':checked')?1:0,
            'form_deal_mid': $('select[name=aws_form_deal_mid]').val(),
            'form_deal_open': $('input[name=aws_form_deal_open]').is(':checked')?1:0,
            'shop_comment_mid': $('select[name=aws_shop_comment_mid]').val(),
            'shop_comment_open': $('input[name=aws_shop_comment_open]').is(':checked')?1:0,
            'mobile_audit_mid': $('select[name=aws_mobile_audit_mid]').val(),
            'mobile_audit_open': $('input[name=aws_mobile_audit_open]').is(':checked')?1:0,
            'shop_claim_mid': $('select[name=aws_shop_claim_mid]').val(),
            'shop_claim_open': $('input[name=aws_shop_claim_open]').is(':checked')?1:0,
        }

        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/tplmsg/saveSetup',
            'data'  : data,
            'dataType'  : 'json',
            success : function(json_ret){
                layer.close(index);
                layer.msg(json_ret.em);
            }
        })
    });

    $('.select-default-tplmsg').click(function () {
        let type = $(this).data('type');
        let field = $(this).data('field');
        layer.confirm('确定要创建并使用默认模板？', {
            btn: ['确定','取消'], //按钮
            title : '模板'
        }, function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{time:10*1000});
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/tplmsg/createDefaultTplmsg',
                'data'  : {type, field},
                'dataType'  : 'json',
                success : function(json_ret){
                    layer.close(index);
                    layer.msg(json_ret.em);
                    if(json_ret.ec = 200){
                       // window.location.reload();
                    }
                }
            })
        })
    })



</script>
