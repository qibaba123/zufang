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
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked + .lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked + .lbl::before{
    	background-color: #06BF04;
    	border-color: #06BF04;
    }
</style>
<div ng-app="Withdraw"  ng-controller="WithdrawList">
    <div class="page-header" style="overflow:hidden">
        <h3 style="float: left">
            广告位配置
            <!--<a href="https://bbs.tiandiantong.net/forum.php?mod=viewthread&tid=388&extra=" target="_blank" style="font-size:14px">点此查看操作教程</a>-->
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
                        <th class="hidden-480">位置</th>
                        <th>广告位ID</th>
                        <{if $menuType eq 'bdapp'}>
                        <th>百度应用ID</th>
                        <{/if}>
                        <th>操作</th>
                    </tr>
                    </thead>

                    <tbody>
                    <!-- 插件,模块 相关 -->
                    <{if $wms}>
                        <tr>
                            <td>秒杀首页</td>
                            <td>
                                <input type="text" class="form-control" name="aa_wms_id" value="<{$row['aa_wms_id']}>">
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aa_wms_open" type="checkbox" <{if $row && $row['aa_wms_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                    <{/if}>
                    <{if $wkj}>
                        <tr>
                            <td>砍价首页</td>
                            <td>
                                <input type="text" class="form-control" name="aa_wkj_id" value="<{$row['aa_wkj_id']}>">
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aa_wkj_open" type="checkbox" <{if $row && $row['aa_wkj_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                    <{/if}>
                    <{if $wkj}>
                        <tr>
                            <td>拼团首页</td>
                            <td>
                                <input type="text" class="form-control" name="aa_wpt_id" value="<{$row['aa_wpt_id']}>">
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aa_wpt_open" type="checkbox" <{if $row && $row['aa_wpt_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                    <{/if}>
                    <{if $prize}>
                        <tr>
                            <td>抽奖</td>
                            <td>
                                <input type="text" class="form-control" name="aa_prize_id" value="<{$row['aa_prize_id']}>">
                            </td>
                            <{if $menuType eq 'bdapp'}>
                            <td>
                                <input type="text" class="form-control" name="aa_prize_baidu_id" value="<{$row['aa_prize_baidu_id']}>">
                            </td>
                            <{/if}>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aa_prize_open" type="checkbox" <{if $row && $row['aa_prize_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                    <{/if}>
                    <{if $dhb}>
                        <tr>
                            <td>电话本列表</td>
                            <td>
                                <input type="text" class="form-control" name="aa_dhbl_id" value="<{$row['aa_dhbl_id']}>">
                            </td>
                            <{if $menuType eq 'bdapp'}>
                            <td>
                                <input type="text" class="form-control" name="aa_dhbl_baidu_id" value="<{$row['aa_dhbl_baidu_id']}>">
                            </td>
                            <{/if}>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aa_dhbl_open" type="checkbox" <{if $row && $row['aa_dhbl_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>电话本详情</td>
                            <td>
                                <input type="text" class="form-control" name="aa_dhbd_id" value="<{$row['aa_dhbd_id']}>">
                            </td>
                            <{if $menuType eq 'bdapp'}>
                            <td>
                                <input type="text" class="form-control" name="aa_dhbd_baidu_id" value="<{$row['aa_dhbd_baidu_id']}>">
                            </td>
                            <{/if}>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aa_dhbd_open" type="checkbox" <{if $row && $row['aa_dhbd_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                    <{/if}>
                    <{if $dt}>
                        <tr>
                            <td>答题首页</td>
                            <td>
                                <input type="text" class="form-control" name="aa_dti_id" value="<{$row['aa_dti_id']}>">
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aa_dti_open" type="checkbox" <{if $row && $row['aa_dti_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>答题提示</td>
                            <td>
                                <input type="text" class="form-control" name="aa_dta_id" value="<{$row['aa_dta_id']}>">
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aa_dta_open" type="checkbox" <{if $row && $row['aa_dta_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                    <{/if}>
                    <{if $payShort}>
                        <tr>
                            <td>收银台支付完成</td>
                            <td>
                                <input type="text" class="form-control" name="aa_ps_id" value="<{$row['aa_ps_id']}>">
                            </td>
                            <{if $menuType eq 'bdapp'}>
                            <td>
                                <input type="text" class="form-control" name="aa_ps_baidu_id" value="<{$row['aa_ps_baidu_id']}>">
                            </td>
                            <{/if}>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aa_ps_open" type="checkbox" <{if $row && $row['aa_ps_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                    <{/if}>
                    <{if $mpj}>
                        <tr>
                            <td>我的名片</td>
                            <td>
                                <input type="text" class="form-control" name="aa_mpj_id" value="<{$row['aa_mpj_id']}>">
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aa_mpj_open" type="checkbox" <{if $row && $row['aa_mpj_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                    <{/if}>
                    <{if $pointGoods }>
                        <tr>
                            <td>积分商城</td>
                            <td>
                                <input type="text" class="form-control" name="aa_pg_id" value="<{$row['aa_pg_id']}>">
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aa_pg_open" type="checkbox" <{if $row && $row['aa_pg_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                    <{/if}>
                        <!-- 多店 酒店 -->
                    <{if $appletCfg['ac_type'] == 8 || $appletCfg['ac_type'] == 7}>
                        <tr>
                            <td>门店列表</td>
                            <td>
                                <input type="text" class="form-control" name="aa_sl_id" value="<{$row['aa_sl_id']}>">
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aa_sl_open" type="checkbox" <{if $row && $row['aa_sl_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                    <{/if}>
                        <!-- 营销商城 -->
                    <{if $appletCfg['ac_type'] == 21}>
                    <tr>
                        <td>订单支付完成</td>
                        <td>
                            <input type="text" class="form-control" name="aa_tp_id" value="<{$row['aa_tp_id']}>">
                        </td>
                        <td>
                            <input  class="ace ace-switch ace-switch-5" name="aa_tp_open" type="checkbox" <{if $row && $row['aa_tp_open'] == 1}>checked<{/if}>>
                            <span class="lbl"></span>
                        </td>
                    </tr>
                    <{/if}>
                        <!-- 同城,多店 -->
                    <{if $appletCfg['ac_type'] == 6 || $appletCfg['ac_type'] == 8}>
                        <tr>
                            <td>帖子列表</td>
                            <td>
                                <input type="text" class="form-control" name="aa_pl_id" value="<{$row['aa_pl_id']}>">
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aa_pl_open" type="checkbox" <{if $row && $row['aa_pl_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                    <{/if}>
                        <!-- 同城 -->
                    <{if $appletCfg['ac_type'] == 6}>
                        <tr>
                            <td>帖子详情</td>
                            <td>
                                <input type="text" class="form-control" name="aa_pd_id" value="<{$row['aa_pd_id']}>">
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aa_pd_open" type="checkbox" <{if $row && $row['aa_pd_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                    <{/if}>
                    <!-- 游戏盒子-->
                    <{if $appletCfg['ac_type'] == 30}>

                        <tr>
                            <td>推荐列表页</td>
                            <td>
                                <input type="text" class="form-control" name="aa_game_recommend_id" value="<{$row['aa_game_recommend_id']}>">
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aa_game_recommend_open" type="checkbox" <{if $row && $row['aa_game_recommend_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>

                        <tr>
                            <td>排行榜页</td>
                            <td>
                                <input type="text" class="form-control" name="aa_game_rank_id" value="<{$row['aa_game_rank_id']}>">
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aa_game_rank_open" type="checkbox" <{if $row && $row['aa_game_rank_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>

                        <tr>
                            <td>抽奖页</td>
                            <td>
                                <input type="text" class="form-control" name="aa_game_lottery_id" value="<{$row['aa_game_lottery_id']}>">
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aa_game_lottery_open" type="checkbox" <{if $row && $row['aa_game_lottery_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>

                        <tr>
                            <td>日常任务页</td>
                            <td>
                                <input type="text" class="form-control" name="aa_game_task_id" value="<{$row['aa_game_task_id']}>">
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aa_game_task_open" type="checkbox" <{if $row && $row['aa_game_task_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                        <{/if}>
                        <!-- 通用部分 游戏盒子没资讯-->
                    <{if $appletCfg['ac_type'] != 30}>
                        <tr>
                            <td>资讯列表</td>
                            <td>
                                <input type="text" class="form-control" name="aa_il_id" value="<{$row['aa_il_id']}>">
                            </td>
                            <{if $menuType eq 'bdapp'}>
                            <td>
                                <input type="text" class="form-control" name="aa_il_baidu_id" value="<{$row['aa_il_baidu_id']}>">
                            </td>
                            <{/if}>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aa_il_open" type="checkbox" <{if $row && $row['aa_il_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>

                        <tr>
                            <td>资讯详情</td>
                            <td>
                                <input type="text" class="form-control" name="aa_id_id" value="<{$row['aa_id_id']}>">
                            </td>
                            <{if $menuType eq 'bdapp'}>
                            <td>
                                <input type="text" class="form-control" name="aa_id_baidu_id" value="<{$row['aa_id_baidu_id']}>">
                            </td>
                            <{/if}>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aa_id_open" type="checkbox" <{if $row && $row['aa_id_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                        <{/if}>
                    <{if $zdhb }>
                        <tr>
                            <td>组队红包</td>
                            <td>
                                <input type="text" class="form-control" name="aa_zdhb_id" value="<{$row['aa_zdhb_id']}>">
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aa_zdhb_open" type="checkbox" <{if $row && $row['aa_zdhb_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                        <{/if}>
                    <{if $appletCfg['ac_type'] == 28}>
                        <tr>
                            <td>首页</td>
                            <td>
                                <input type="text" class="form-control" name="aa_job_index_id" value="<{$row['aa_job_index_id']}>">
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aa_job_index_open" type="checkbox" <{if $row && $row['aa_job_index_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>职位列表</td>
                            <td>
                                <input type="text" class="form-control" name="aa_job_list_id" value="<{$row['aa_job_list_id']}>">
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aa_job_list_open" type="checkbox" <{if $row && $row['aa_job_list_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>职位详情</td>
                            <td>
                                <input type="text" class="form-control" name="aa_job_detail_id" value="<{$row['aa_job_detail_id']}>">
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aa_job_detail_open" type="checkbox" <{if $row && $row['aa_job_detail_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>简历大厅</td>
                            <td>
                                <input type="text" class="form-control" name="aa_job_resume_id" value="<{$row['aa_job_resume_id']}>">
                            </td>
                            <td>
                                <input  class="ace ace-switch ace-switch-5" name="aa_job_resume_open" type="checkbox" <{if $row && $row['aa_job_resume_open'] == 1}>checked<{/if}>>
                                <span class="lbl"></span>
                            </td>
                        </tr>
                    <{/if}>
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
            'pl_open': $('input[name=aa_pl_open]').is(':checked')?1:0,
            'pl_id': $('input[name=aa_pl_id]').val(),
            'pd_open': $('input[name=aa_pd_open]').is(':checked')?1:0,
            'pd_id': $('input[name=aa_pd_id]').val(),
            'il_open': $('input[name=aa_il_open]').is(':checked')?1:0,
            'il_id': $('input[name=aa_il_id]').val(),
            'id_open': $('input[name=aa_id_open]').is(':checked')?1:0,
            'id_id': $('input[name=aa_id_id]').val(),
            'tp_open': $('input[name=aa_tp_open]').is(':checked')?1:0,
            'tp_id': $('input[name=aa_tp_id]').val(),
            'sl_open': $('input[name=aa_sl_open]').is(':checked')?1:0,
            'sl_id': $('input[name=aa_sl_id]').val(),
            'wms_open': $('input[name=aa_wms_open]').is(':checked')?1:0,
            'wms_id': $('input[name=aa_wms_id]').val(),
            'wkj_open': $('input[name=aa_wkj_open]').is(':checked')?1:0,
            'wkj_id': $('input[name=aa_wkj_id]').val(),
            'wpt_open': $('input[name=aa_wpt_open]').is(':checked')?1:0,
            'wpt_id': $('input[name=aa_wpt_id]').val(),
            'prize_open': $('input[name=aa_prize_open]').is(':checked')?1:0,
            'prize_id': $('input[name=aa_prize_id]').val(),
            'dhbl_open': $('input[name=aa_dhbl_open]').is(':checked')?1:0,
            'dhbl_id': $('input[name=aa_dhbl_id]').val(),
            'dhbd_open': $('input[name=aa_dhbd_open]').is(':checked')?1:0,
            'dhbd_id': $('input[name=aa_dhbd_id]').val(),
            'dti_open': $('input[name=aa_dti_open]').is(':checked')?1:0,
            'dti_id': $('input[name=aa_dti_id]').val(),
            'dta_open': $('input[name=aa_dta_open]').is(':checked')?1:0,
            'dta_id': $('input[name=aa_dta_id]').val(),
            'ps_open': $('input[name=aa_ps_open]').is(':checked')?1:0,
            'ps_id': $('input[name=aa_ps_id]').val(),
            'mpj_open': $('input[name=aa_mpj_open]').is(':checked')?1:0,
            'mpj_id': $('input[name=aa_mpj_id]').val(),
            'pg_open': $('input[name=aa_pg_open]').is(':checked')?1:0,
            'pg_id': $('input[name=aa_pg_id]').val(),
            'game_recommend_open': $('input[name=aa_game_recommend_open]').is(':checked')?1:0,
            'game_recommend_id': $('input[name=aa_game_recommend_id]').val(),
            'game_rank_open': $('input[name=aa_game_rank_open]').is(':checked')?1:0,
            'game_rank_id': $('input[name=aa_game_rank_id]').val(),
            'game_lottery_open': $('input[name=aa_game_lottery_open]').is(':checked')?1:0,
            'game_lottery_id': $('input[name=aa_game_lottery_id]').val(),
            'game_task_open': $('input[name=aa_game_task_open]').is(':checked')?1:0,
            'game_task_id': $('input[name=aa_game_task_id]').val(),

            'job_index_open': $('input[name=aa_job_index_open]').is(':checked')?1:0,
            'job_index_id': $('input[name=aa_job_index_id]').val(),
            'job_list_open': $('input[name=aa_job_list_open]').is(':checked')?1:0,
            'job_list_id': $('input[name=aa_job_list_id]').val(),
            'job_detail_open': $('input[name=aa_job_detail_open]').is(':checked')?1:0,
            'job_detail_id': $('input[name=aa_job_detail_id]').val(),
            'job_resume_open': $('input[name=aa_job_resume_open]').is(':checked')?1:0,
            'job_resume_id': $('input[name=aa_job_resume_id]').val(),
            'zdhb_open': $('input[name=aa_zdhb_open]').is(':checked')?1:0,
            'zdhb_id': $('input[name=aa_zdhb_id]').val(),
            'prize_baidu_id': $('input[name=aa_prize_baidu_id]').val(),
            'dhbl_baidu_id': $('input[name=aa_dhbl_baidu_id]').val(),
            'id_baidu_id': $('input[name=aa_id_baidu_id]').val(),
            'il_baidu_id': $('input[name=aa_il_baidu_id]').val(),
            'dhbd_baidu_id': $('input[name=aa_dhbd_baidu_id]').val(),
            'ps_baidu_id': $('input[name=aa_ps_baidu_id]').val(),
        };

        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/city/saveAd',
            'data'  : data,
            'dataType'  : 'json',
            success : function(json_ret){
                layer.close(index);
                layer.msg(json_ret.em);
            }
        })
    });



</script>
