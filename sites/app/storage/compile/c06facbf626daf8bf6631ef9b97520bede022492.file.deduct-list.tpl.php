<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 11:10:33
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/three/deduct-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11333621655e4df8a96ba775-23560191%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c06facbf626daf8bf6631ef9b97520bede022492' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/three/deduct-list.tpl',
      1 => 1575621713,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11333621655e4df8a96ba775-23560191',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cfg' => 0,
    'level' => 0,
    'list' => 0,
    'item' => 0,
    'val' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4df8a9712627_02341661',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df8a9712627_02341661')) {function content_5e4df8a9712627_02341661($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/www/wwwroot/default/yingxiaosc/libs/view/smarty/libs/plugins/modifier.date_format.php';
?><link rel="stylesheet" href="/public/manage/css/deduct.css" />
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
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div  id="mainContent">
    <div class="page-header">
        <div class="alert alert-block alert-yellow ">
            <button type="button" class="close" data-dismiss="alert">
                <i class="icon-remove"></i>
            </button>
            提醒1: 店铺全部商品分佣设置，若商品未设置单品分佣，则按当前店铺佣金配置进行分销!<br/>
            提醒2: 分佣可以按购买次数进行阶梯型配置，	&rarr;如分别设置1-5-9，则代表分为4个阶段，购买&le;1时;1&lt;购买&le;5时;5&lt;购买&le;9时;购买>9时;<br/>
            &rarr;如设置3-6，则代表分为3个阶段，0&lt;购买&le;3时;3&lt;购买&le;6时;购买>6时;<br>
            &rarr;如仅设置1，则代表分为1个阶段，购买&ge;1时。<br>
            提醒3: 购买人返现代表当前商品购买人可以得到的返现金额，如果不想返现，可以设置为0;
        </div>
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
                <input type="radio" name="roundType" id="round_no" value="0" <?php if (!($_smarty_tpl->tpl_vars['cfg']->value['tc_round_type']>0)) {?>checked<?php }?>>
                <label for="round_no">不取整</label>
            </span>
            <span>
                <input type="radio" name="roundType" id="round_ceil" value="1" <?php if ($_smarty_tpl->tpl_vars['cfg']->value['tc_round_type']==1) {?>checked<?php }?>>
                <label for="round_ceil">向上取整</label>
            </span>
            <span>
                <input type="radio" name="roundType" id="round_floor" value="2" <?php if ($_smarty_tpl->tpl_vars['cfg']->value['tc_round_type']==2) {?>checked<?php }?>>
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
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon input-group-addon-title">购 买 次 数</div>
                                            <input type="text" class="form-control" ng-model="buy_num" placeholder="购买次数">
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon input-group-addon-title">购买人返现比例</div>
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
                                            <div class="input-group-addon input-group-addon-title">上级提成比例</div>
                                            <input type="text" class="form-control" ng-model="first_ratio" placeholder="百分比">
                                            <div class="input-group-addon">%</div>
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="form-group ">
                                        <div class="input-group <?php if ($_smarty_tpl->tpl_vars['level']->value<2) {?>hide<?php }?>">
                                            <div class="input-group-addon input-group-addon-title">二级提成比例</div>
                                            <input type="text" class="form-control" ng-model="second_ratio"  placeholder="百分比">
                                            <div class="input-group-addon">%</div>
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="form-group <?php if ($_smarty_tpl->tpl_vars['level']->value<3) {?>hide<?php }?>">
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
                        <th>购买次数</th>
                        <th>购买人返现比例</th>
                        <th>返现分期</th>
                        <th>上一级提成比例</th>
                        <th class="<?php if ($_smarty_tpl->tpl_vars['level']->value<2) {?>hide<?php }?>">上二级提成比例</th>
                        <th class="<?php if ($_smarty_tpl->tpl_vars['level']->value<3) {?>hide<?php }?>">上三级提成比例</th>
                        <th>
                            <i class="icon-time bigger-110 hidden-480"></i>
                            更新时间
                        </th>
                        <th>操作</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                        <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['item']->value['dc_id'];?>
">
                            <!--<td class="center">
                                <label>
                                    <input type="checkbox" class="ace" name="ids"  value="<?php echo $_smarty_tpl->tpl_vars['val']->value['s_id'];?>
"/>
                                    <span class="lbl"></span>
                                </label>
                            </td>-->
                            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['dc_buy_num'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['dc_0f_ratio'];?>
％</td>
                            <td><?php if (in_array($_smarty_tpl->tpl_vars['item']->value['dc_back_num'],array(0,1))) {?>一次性返现<?php } else { ?>分<?php echo $_smarty_tpl->tpl_vars['item']->value['dc_back_num'];?>
期<?php }?></td>
                            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['dc_1f_ratio'];?>
％</td>
                            <td class="<?php if ($_smarty_tpl->tpl_vars['level']->value<2) {?>hide<?php }?>"><?php echo $_smarty_tpl->tpl_vars['item']->value['dc_2f_ratio'];?>
％</td>
                            <td class="<?php if ($_smarty_tpl->tpl_vars['level']->value<3) {?>hide<?php }?>"><?php echo $_smarty_tpl->tpl_vars['item']->value['dc_3f_ratio'];?>
％</td>
                            <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['item']->value['dc_update_time'],"%Y-%m-%d %H:%M:%S");?>
</td>
                            <td style="color:#ccc;">
                                <a href="javascript:;" ng-click="edit($event)"
                                   data-id="<?php echo $_smarty_tpl->tpl_vars['item']->value['dc_id'];?>
"
                                   data-num="<?php echo $_smarty_tpl->tpl_vars['item']->value['dc_buy_num'];?>
"
                                   data-back-num="<?php echo $_smarty_tpl->tpl_vars['item']->value['dc_back_num'];?>
"
                                   data-ratio="<?php echo $_smarty_tpl->tpl_vars['item']->value['dc_0f_ratio'];?>
"
                                   data-f-ratio="<?php echo $_smarty_tpl->tpl_vars['item']->value['dc_1f_ratio'];?>
"
                                   data-ff-ratio="<?php echo $_smarty_tpl->tpl_vars['item']->value['dc_2f_ratio'];?>
"
                                   data-fff-ratio="<?php echo $_smarty_tpl->tpl_vars['item']->value['dc_3f_ratio'];?>
"
                                   class="" role="button" data-toggle="modal">编辑 - </a>

                                <a href="javascript:;" ng-click="del($event)"
                                   data-id="<?php echo $_smarty_tpl->tpl_vars['item']->value['dc_id'];?>
"
                                   class="" role="button" style="color:#f00;">删除</a>
                            </td>
                        </tr>
                        <?php } ?>
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

<?php }} ?>
