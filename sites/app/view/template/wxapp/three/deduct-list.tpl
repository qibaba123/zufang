<link rel="stylesheet" href="/public/manage/css/deduct.css" />
<style>
    .round-cfg{
        font-size: 16px;
        color: #2c354c;
        font-weight: bold;
    }
    .round-cfg span label{
        font-size: 16px !important;
    }
</style>
<{include file="../common-second-menu.tpl"}>
<div  id="mainContent">
    <div class="page-header">

    </div><!-- /.page-header -->

    <!--
    <div class="page-header">
        <div class="alert alert-block alert-green ">
            <button type="button" class="close" data-dismiss="alert">
                <i class="icon-remove"></i>
            </button>
            1.选择向上取整时，佣金会强制转换为更大的整数，如佣金为<span style="color: red">1.01元</span>则会增加为<span style="color: red">2元</span><br>
            2.选择向下取整时，佣金会强制转换为更小的整数，如佣金为<span style="color: red">1.99元</span>则会减少为<span style="color: red">1元</span><br>
        </div>
        <div class="radio-box round-cfg">
            佣金取整
            <span style="margin-left: 10px">
                <input type="radio" name="roundType" id="round_no" value="0" <{if !($cfg['tc_round_type'] > 0)}>checked<{/if}>>
                <label for="round_no">不取整</label>
            </span>
            <span>
                <input type="radio" name="roundType" id="round_ceil" value="1" <{if $cfg['tc_round_type'] == 1}>checked<{/if}>>
                <label for="round_ceil">向上取整</label>
            </span>
            <span>
                <input type="radio" name="roundType" id="round_floor" value="2" <{if $cfg['tc_round_type'] == 2}>checked<{/if}>>
                <label for="round_floor">向下取整</label>
            </span>
            <span>
                <button class="btn btn-xs btn-primary" onclick="changeRoundType()">保存</button>
            </span>
        </div>
    </div>
    -->

    <div class="row" ng-app="ShopIndex" ng-controller="ShopInfoController">
        <div class="col-sm-12" style="margin-bottom: 20px;">
           <button class="btn btn-green" ng-click="add()" data-target="#modal-info-form">
                <i class="icon-plus bigger-80"></i> 添 加
            </button>
        </div>
        <div id="modal-info-form" class="modal fade" tabindex="-1">
            <div class="modal-dialog" style="width:850px;;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="blue bigger">佣金配置设置</h4>
                    </div>

                    <div class="modal-body" style="overflow: hidden;">
                        <!-- <input type="hidden" class="form-control" ng-model="shop_id" > -->
                        <div class="col-sm-12" style="margin-bottom: 20px;">
                            <div class="tab-content">
                                <!--店铺基本信息-->
                                <div id="home" class="tab-pane in active">
                                    <div class="form-group" style = "display：none;">
                                        <div class="input-group">
                                            <div class="input-group-addon input-group-addon-title">等级名称</div>
                                            <input type="text" class="form-control" ng-model="buy_num" placeholder="等级名称">
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon input-group-addon-title">本人购买返现比例</div>
                                            <input type="text" class="form-control" ng-model="ratio" placeholder="返现比例百分比">
                                            <div class="input-group-addon">%</div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="display: none">
                                        <div class="input-group">
                                            <div class="input-group-addon input-group-addon-title"> 返 现 期 数 </div>
                                            <input type="text" class="form-control" ng-model="back_num" placeholder="返现分期数，0和1表示一次性返现，大于1表示分期">
                                            <div class="input-group-addon">期</div>
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon input-group-addon-title">下级购买提成比例</div>
                                            <input type="text" class="form-control" ng-model="first_ratio" placeholder="百分比">
                                            <div class="input-group-addon">%</div>
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="form-group ">
                                        <div class="input-group <{if $level < 2}>hide<{/if}>">
                                            <div class="input-group-addon input-group-addon-title">二级提成比例</div>
                                            <input type="text" class="form-control" ng-model="second_ratio"  placeholder="百分比">
                                            <div class="input-group-addon">%</div>
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="form-group <{if $level < 3}>hide<{/if}>">
                                        <div class="input-group">
                                            <div class="input-group-addon input-group-addon-title">三级提成比例</div>
                                            <input type="text" class="form-control" ng-model="third_ratio"  placeholder="百分比">
                                            <div class="input-group-addon">%</div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="left" style="text-align: center;">
                                            <button class="btn btn-sm btn-primary"  ng-click="save()"> &nbsp; 保 &nbsp; 存 &nbsp; </button>
                                        </div>
                                        <div class="right">
                                            <input type="hidden" name="deduct_id" id="deduct_id" value="0"/>
                                            <div id="saveResult" class="col-sm-9" style="text-align: center;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- PAGE CONTENT ENDS -->
        <!-- 列表 展示 -->
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="sample-table-1" class="table table-hover table-button">
                    <thead>
                    <tr>
                        <!--<th class="center">
                            <label>
                                <input type="checkbox" class="ace" id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                <span class="lbl"></span>
                            </label>
                        </th>-->
                        <th>等级名称</th>
                        <th>本人购买返现比例</th>
                        <th>下级购买提成比例</th>
                        <th class="<{if $level < 2}>hide<{/if}>">上二级提成比例</th>
                        <th class="<{if $level < 3}>hide<{/if}>">上三级提成比例</th>
                        <th>
                            <i class="icon-time bigger-110 hidden-480"></i>
                            更新时间
                        </th>
                        <th>操作</th>
                    </tr>
                    </thead>

                    <tbody>
                    <{foreach $list as $item}>
                        <tr id="tr_<{$item['dc_id']}>">
                            <!--<td class="center">
                                <label>
                                    <input type="checkbox" class="ace" name="ids"  value="<{$val['s_id']}>"/>
                                    <span class="lbl"></span>
                                </label>
                            </td>-->
                            <td><{$item['dc_buy_num']}></td>
                            <td><{$item['dc_0f_ratio']}>％</td>
                            <td><{$item['dc_1f_ratio']}>％</td>
                            <td class="<{if $level < 2}>hide<{/if}>"><{$item['dc_2f_ratio']}>％</td>
                            <td class="<{if $level < 3}>hide<{/if}>"><{$item['dc_3f_ratio']}>％</td>
                            <td><{$item['dc_update_time']|date_format:"%Y-%m-%d %H:%M:%S"}></td>
                            <td style="color:#ccc;">
                                <a href="javascript:;" ng-click="edit($event)"
                                   data-id="<{$item['dc_id']}>"
                                   data-name="<{$item['dc_name']}>"
                                   data-num="<{$item['dc_buy_num']}>"
                                   data-back-num="<{$item['dc_back_num']}>"
                                   data-ratio="<{$item['dc_0f_ratio']}>"
                                   data-f-ratio="<{$item['dc_1f_ratio']}>"
                                   data-ff-ratio="<{$item['dc_2f_ratio']}>"
                                   data-fff-ratio="<{$item['dc_3f_ratio']}>"
                                   class="" role="button" data-toggle="modal">编辑</a>

                                 <a href="javascript:;" ng-click="del($event)"
                                   data-id="<{$item['dc_id']}>"
                                   class="" role="button" style="color:#f00;">删除</a>
                            </td>
                        </tr>
                        <{/foreach}>
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
        </div><!-- /span -->
    </div>
</div>
<script type="text/javascript">
    function changeRoundType() {
        var type = $("input[name='roundType']:checked").val();
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            'type'	: 'post',
            'url'	: '/wxapp/three/changeRoundType',
            'data'	: {type:type},
            'dataType' : 'json',
            'success'  : function(ret){
                layer.close(index);
                layer.msg(ret.em);
                if(ret.ec == 200){

                }
            }
        });
    }
</script>
<script type="text/javascript" src="/public/manage/vendor/angular.min.js"></script>
<script type="text/javascript" src="/public/manage/vendor/angular-root.js"></script>
<script type="text/javascript" src="/public/wxapp/three/js/custom.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/wxapp/three/js/shop-deduct.js"></script>

