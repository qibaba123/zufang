<?php /* Smarty version Smarty-3.1.17, created on 2019-12-06 17:03:16
         compiled from "/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/currency/popup-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11309122835dea19545394f8-64775701%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6845e275a4332022fa9eca132a930ed380b6ad88' => 
    array (
      0 => '/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/currency/popup-list.tpl',
      1 => 1575622993,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11309122835dea19545394f8-64775701',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'list' => 0,
    'val' => 0,
    'timeTypeNote' => 0,
    'pagination' => 0,
    'appletCfg' => 0,
    'page_list' => 0,
    'goodsList' => 0,
    'information' => 0,
    'linkType' => 0,
    'linkList' => 0,
    'auctionList' => 0,
    'kindSelect' => 0,
    'firstKindSelect' => 0,
    'goodsGroup' => 0,
    'expertCategory' => 0,
    'reservationCategory' => 0,
    'expertList' => 0,
    'shopGoodsGroup' => 0,
    'serviceArticle' => 0,
    'categoryList' => 0,
    'groupList' => 0,
    'limitList' => 0,
    'bargainList' => 0,
    'allKindSelect' => 0,
    'informationCategory' => 0,
    'appointmentGoodsList' => 0,
    'hotelLinkLists' => 0,
    'shopInfo' => 0,
    'jumpList' => 0,
    'shoplist' => 0,
    'shopKindSelect' => 0,
    'positionList' => 0,
    'companySelect' => 0,
    'formlist' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5dea19545f9713_93922285',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5dea19545f9713_93922285')) {function content_5dea19545f9713_93922285($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">

<div id="content-con" ng-app="chApp" ng-controller="chCtrl">
    <div  id="mainContent" >
        <div class="page-header">
            <a class="btn btn-green btn-xs" href="#" id="add-new" data-toggle="modal" data-target="#myModal" ng-click="addPopup()"><i class="icon-plus bigger-80"></i>添加图片</a>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar" style="border: none">
                        <thead>
                        <tr>
                            <th>图片</th>
                            <!--
                            <th>链接类型</th>
                            -->
                            <th>首页弹出</th>
                            <th>弹出频率</th>
                            <th>更新时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['ap_id'];?>
">
                                <td>
                                    <img src="<?php if ($_smarty_tpl->tpl_vars['val']->value['ap_path']) {?><?php echo $_smarty_tpl->tpl_vars['val']->value['ap_path'];?>
<?php } else { ?>/public/manage/img/zhanwei/zw_fxb_350_425.png<?php }?>" style="width:80px" alt="">
                                </td>
                                <!--
                                <td>

                                </td>
                                -->
                                <td>
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['ap_show']) {?>
                                    <span style="color: green">已启用</span>
                                    <a href="#" class="btn btn-sm btn-red" onclick="changeShow(<?php echo $_smarty_tpl->tpl_vars['val']->value['ap_id'];?>
,0)" style="padding: 3px 5px">关闭</a>
                                    <?php } else { ?>
                                    <span style="color: red">未启用</span>
                                    <a href="#" class="btn btn-sm btn-green" onclick="changeShow(<?php echo $_smarty_tpl->tpl_vars['val']->value['ap_id'];?>
,1)" style="padding: 3px 5px">启用</a>
                                    <?php }?>
                                </td>
                                <td>
                                    每<?php echo $_smarty_tpl->tpl_vars['val']->value['ap_time_value'];?>
<?php echo $_smarty_tpl->tpl_vars['timeTypeNote']->value[$_smarty_tpl->tpl_vars['val']->value['ap_time_type']];?>
弹出一次
                                </td>
                                <td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['ap_update_time']);?>
</td>
                                <td>
                                    <!--
                                    <a class="confirm-handle" href="#" data-toggle="modal" data-target="#myModal"  data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['ap_id'];?>
" data-cover="<?php if ($_smarty_tpl->tpl_vars['val']->value['ap_path']) {?><?php echo $_smarty_tpl->tpl_vars['val']->value['ap_path'];?>
<?php } else { ?>/public/manage/img/zhanwei/zw_fxb_350_425.png<?php }?>" data-showindex="<?php echo $_smarty_tpl->tpl_vars['val']->value['ap_show'];?>
" data-showtype="<?php echo $_smarty_tpl->tpl_vars['val']->value['ap_show_type'];?>
" data-link="<?php echo $_smarty_tpl->tpl_vars['val']->value['ap_link'];?>
" data-linktype="<?php echo $_smarty_tpl->tpl_vars['val']->value['ap_link_type'];?>
" ng-click="editPopup(<?php echo $_smarty_tpl->tpl_vars['val']->value['ap_id'];?>
,'<?php echo $_smarty_tpl->tpl_vars['val']->value['ap_path'];?>
',<?php echo $_smarty_tpl->tpl_vars['val']->value['ap_link_type'];?>
,'<?php echo $_smarty_tpl->tpl_vars['val']->value['ap_link'];?>
',<?php echo $_smarty_tpl->tpl_vars['val']->value['ap_show_type'];?>
,<?php echo $_smarty_tpl->tpl_vars['val']->value['ap_show'];?>
)">编辑</a>
                                    -->
                                    <a class="confirm-handle btn btn-xs btn-green" href="#" data-toggle="modal" data-target="#myModal" ng-click="editPopup(<?php echo $_smarty_tpl->tpl_vars['val']->value['ap_id'];?>
,'<?php echo $_smarty_tpl->tpl_vars['val']->value['ap_path'];?>
',<?php echo $_smarty_tpl->tpl_vars['val']->value['ap_link_type'];?>
,'<?php echo $_smarty_tpl->tpl_vars['val']->value['ap_link'];?>
',<?php echo $_smarty_tpl->tpl_vars['val']->value['ap_show_type'];?>
,<?php echo $_smarty_tpl->tpl_vars['val']->value['ap_show'];?>
,<?php echo $_smarty_tpl->tpl_vars['val']->value['ap_time_type'];?>
,<?php echo $_smarty_tpl->tpl_vars['val']->value['ap_time_value'];?>
)">编辑</a>

                                    <a data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['ap_id'];?>
" onclick="confirmDelete(this)" class="btn btn-xs btn-danger del-btn">删除</a>
                                </td>
                            </tr>
                            <?php } ?>

                        <tr><td colspan="9"><?php echo $_smarty_tpl->tpl_vars['pagination']->value;?>
</td></tr>

                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
        <div class="modal-dialog" style="width: 535px;">
            <div class="modal-content">
                <input type="hidden" id="hid_id" ng-model="popup_id">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        添加/编辑
                    </h4>
                </div>
                <div class="modal-body" style="margin-left: 20px">
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">图片：(建议尺寸600*750)</label>
                        <div class="col-sm-8">
                            <div>
                                <div>
                                    <img onclick="toUpload(this)" data-limit="1" data-width="600" data-height="750" data-dom-id="upload-cover" id="upload-cover"  src="/public/manage/img/zhanwei/zw_fxb_350_425.png"  width="300" height="375" style="display:inline-block;margin-left:0;" imageonload="changeCover()">
                                    <input type="hidden" id="popup_cover"  class="avatar-field bg-img" name="popup_cover" ng-model="popup_cover" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==7) {?>
                    <!-- 酒店都是链接 -->
                    <input type="hidden"  ng-model="link_type" value="2">
                    <div class="form-group row" >
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">连 接 到：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_2">
                                <option ng-repeat="page in hotelLinkLists" value="{{page.link}}" ng-selected="page.link == link_path" >{{page.name}}</option>
                            </select>

                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">链接类型：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_type" class="form-control link_type" >
                                <option ng-repeat="type in linkTypes" value="{{type.id}}" ng-selected="type.id == link_type">{{type.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 2">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">连 接 到：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_2">
                                <option ng-repeat="page in linkLists" value="{{page.path}}" ng-selected="page.path == link_path" >{{page.name}}</option>
                            </select>

                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 5">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">商　　品：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_5">
                                <option ng-repeat="good in goodsList" value="{{good.id}}" ng-selected="good.id == link_path" >{{good.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 1">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">资　　讯：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_1" ng-options="x.id as x.title for x in articles">
                                <option ng-repeat="item in articles" value="{{item.id}}" ng-selected="item.id == link_path" >{{item.title}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 47">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">拍　　卖：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_47">
                                <option ng-repeat="auction in auctionList" value="{{auction.id}}" ng-selected="auction.id == link_path" >{{auction.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 3">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">外　　链：</label>
                        <div class="col-sm-8">
                            <input type="text" ng-model="link_path" class="form-control link_path_3">
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 4">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">分组详情：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_4">
                                <option ng-repeat="x in category" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 9">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">分类详情：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_9">
                                <option ng-repeat="x in kindSelect" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 10">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">分类详情：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_10">
                                <option ng-repeat="x in kindSelect" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 18">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">分类列表：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_18">
                                <option ng-repeat="x in categoryList" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 19">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">服务详情：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_19">
                                <option ng-repeat="x in serviceArticles" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.title}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 44">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">车源详情：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_44">
                                <option ng-repeat="x in carList" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 45">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">分类详情：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_45">
                                <option ng-repeat="x in carShopKindList" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 6">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">分类详情：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_6">
                                <option ng-repeat="x in reservationCategory" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 37">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">专家详情：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_37">
                                <option ng-repeat="x in expertList" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 38">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">专家分类：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_38">
                                <option ng-repeat="x in expertCategory" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 39">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">游戏分类：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_39">
                                <option ng-repeat="x in gameCategory" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 23">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">游戏分类：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_23">
                                <option ng-repeat="x in firstKindSelect" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 29">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">秒杀商品：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_29">
                                <option ng-repeat="x in limitList" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 30">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">拼团商品：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_30">
                                <option ng-repeat="x in groupList" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 31">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">拼团商品：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_31">
                                <option ng-repeat="x in bargainList" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 32">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">资讯分类：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_32">
                                <option ng-repeat="x in informationCategory" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 104">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">菜　　单：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_104">
                                <option ng-repeat="x in pages" value="{{x.path}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 16">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">店铺分类：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_16">
                                <option ng-repeat="x in shopKindSelect" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 34">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">店铺分类：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_34">
                                <option ng-repeat="x in shopKindSelect" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 17">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">店铺详情：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_17">
                                <option ng-repeat="x in shoplist" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 20">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">店铺详情：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_20">
                                <option ng-repeat="x in shoplist" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 26">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">分类列表：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_26">
                                <option ng-repeat="x in knowpayType" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 26">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">分类详情：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_26">
                                <option ng-repeat="x in knowpayType" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 41">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">商品分组：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_41">
                                <option ng-repeat="x in category" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 42">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">商品分组：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_42">
                                <option ng-repeat="x in shopCategory" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 43">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">店铺详情：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_43">
                                <option ng-repeat="x in shoplist" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 106">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">小 程 序：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_106">
                                <option ng-repeat="x in jumpList" value="{{x.appid}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 46">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">付费预约：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_46">
                                <option ng-repeat="x in appointmentGoodsList" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 35">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">职位分类：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_35">
                                <option ng-repeat="x in kindSelect" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 36">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">职位详情：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_36">
                                <option ng-repeat="x in positionList" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 50">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">公司分类：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_50">
                                <option ng-repeat="x in firstKindSelect" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 48">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">公司详情：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_48">
                                <option ng-repeat="x in companySelect" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" ng-show="link_type == 55">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">表　　单：</label>
                        <div class="col-sm-8">
                            <select name="" id="" ng-model="link_path" class="form-control link_path_55">
                                <option ng-repeat="x in formlist" value="{{x.id}}" ng-selected="x.id == link_path" >{{x.name}}</option>
                            </select>
                        </div>
                    </div>
                    <?php }?>


                    <div class="form-group row" style="margin-bottom: 5px">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">是否弹出：</label>
                        <div class="col-sm-6">
                            <div class="radio-box">
                                    <span>
                                        <input type="radio" name="indexShow" id="index_yes" value="1" ng-model="show_index">
                                        <label for="index_yes">启用</label>
                                    </span>
                                <span>
                                        <input type="radio" name="indexShow" id="index_no" value="0" ng-model="show_index">
                                        <label for="index_no">不启用</label>
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row" style="margin-bottom: 5px;display: none">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">次　　数：</label>
                        <div class="col-sm-6">
                            <div class="radio-box">
                            <span>
                                        <input type="radio" name="showType" id="showtype_1" value="1" ng-model="show_type">
                                        <label for="showtype_1">每7天1次</label>
                                    </span>
                                <span>
                                        <input type="radio" name="showType" id="showtype_2" value="2" ng-model="show_type">
                                        <label for="showtype_2">每天1次</label>
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row" style="margin-bottom: 5px">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">频　　率：</label>
                        <div class="col-sm-6">
                            每
                            <input type="text" maxlength="2" class="form-control" style="width: 25%;display: inline-block" ng-model="timeValue">
                            <select  class="form-control" name="timeType" id="timeType" style="width: 25%;display: inline-block" ng-model="timeType">
                                <option value="1" ng-selected="timeType==1">天</option>
                                <option value="2" ng-selected="timeType==2">小时</option>
                            </select>
                            弹出一次
                            <span style="color: red;font-size: 12px;display: block">请填写1-99之间的整数</span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-primary" id="confirm-category" ng-click="saveData()">
                        确认
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script src="/public/plugin/sortable/sortable.js"></script>
<script>
    var app = angular.module('chApp', ['RootModule',"ui.sortable"]);
    app.controller('chCtrl',['$scope','$http','$timeout', function($scope,$http,$timeout){

        $scope.link_type = 0;
        console.log($scope.link_type);
        $scope.show_type = 2;
        $scope.show_index = 0;
        $scope.link_path = '';
        $scope.popup_cover = '';
        $scope.popup_id = 0;
        $scope.pages =  <?php echo $_smarty_tpl->tpl_vars['page_list']->value;?>
;
        console.log($scope.pages);
        $scope.goodsList = <?php echo $_smarty_tpl->tpl_vars['goodsList']->value;?>
;
        $scope.articles = <?php echo $_smarty_tpl->tpl_vars['information']->value;?>
;
        $scope.linkTypes = <?php echo $_smarty_tpl->tpl_vars['linkType']->value;?>
;
        $scope.linkLists  = <?php echo $_smarty_tpl->tpl_vars['linkList']->value;?>
;
        $scope.auctionList  = <?php echo $_smarty_tpl->tpl_vars['auctionList']->value;?>
;
        $scope.kindSelect           = <?php echo $_smarty_tpl->tpl_vars['kindSelect']->value;?>
;
        $scope.firstKindSelect      = <?php echo $_smarty_tpl->tpl_vars['firstKindSelect']->value;?>
;
        $scope.category             = <?php echo $_smarty_tpl->tpl_vars['goodsGroup']->value;?>
;
        $scope.expertCategory       = <?php echo $_smarty_tpl->tpl_vars['expertCategory']->value;?>
;
        $scope.reservationCategory  = <?php echo $_smarty_tpl->tpl_vars['reservationCategory']->value;?>
;
        $scope.expertList           = <?php echo $_smarty_tpl->tpl_vars['expertList']->value;?>
;
        $scope.shopCategory         = <?php echo $_smarty_tpl->tpl_vars['shopGoodsGroup']->value;?>
;
        $scope.serviceArticles      =  <?php echo $_smarty_tpl->tpl_vars['serviceArticle']->value;?>
;
        $scope.categoryList         =  <?php echo $_smarty_tpl->tpl_vars['categoryList']->value;?>
;
        $scope.groupList            = <?php echo $_smarty_tpl->tpl_vars['groupList']->value;?>
;
        $scope.limitList            = <?php echo $_smarty_tpl->tpl_vars['limitList']->value;?>
;
        $scope.bargainList          = <?php echo $_smarty_tpl->tpl_vars['bargainList']->value;?>
;
        $scope.allKindSelect        = <?php echo $_smarty_tpl->tpl_vars['allKindSelect']->value;?>
;
        $scope.informationCategory  = <?php echo $_smarty_tpl->tpl_vars['informationCategory']->value;?>
;
        $scope.appointmentGoodsList = <?php echo $_smarty_tpl->tpl_vars['appointmentGoodsList']->value;?>
;
        $scope.hotelLinkLists = <?php echo $_smarty_tpl->tpl_vars['hotelLinkLists']->value;?>
;
        $scope.shopInfo             = <?php echo $_smarty_tpl->tpl_vars['shopInfo']->value;?>
;
        $scope.jumpList             = <?php echo $_smarty_tpl->tpl_vars['jumpList']->value;?>
;
        $scope.shoplist             = <?php echo $_smarty_tpl->tpl_vars['shoplist']->value;?>
;
        $scope.shopKindSelect       = <?php echo $_smarty_tpl->tpl_vars['shopKindSelect']->value;?>
;
        $scope.positionList         = <?php echo $_smarty_tpl->tpl_vars['positionList']->value;?>
;
        $scope.companySelect        = <?php echo $_smarty_tpl->tpl_vars['companySelect']->value;?>
;
        $scope.formlist             = <?php echo $_smarty_tpl->tpl_vars['formlist']->value;?>
;
        $scope.timeType = 1;
        $scope.timeValue = 1;
        console.log($scope.linkLists);
        // 保存数据
        $scope.saveData = function(){
            var cover = $('#popup_cover').val();

            if(!cover){
                layer.msg('请上传图片');
                return false;
            }
            if($scope.timeValue > 99 || $scope.timeValue < 1){
                layer.msg('时间填写不正确');
                return false;
            }

            var data = {
                'id' : $scope.popup_id,
                'link_path' : $scope.link_path,
                'link_type' : $scope.link_type,
                'cover'     : cover,
                'showIndex' : $scope.show_index,
                'showType'  : $scope.show_type,
                'timeType'  : $scope.timeType,
                'timeValue' : $scope.timeValue,
            };
            console.log(data);

            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });

            $http({
                method: 'POST',
                url:    '/wxapp/popup/popupSave',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
                if(response.data.ec){
                    window.location.reload();
                }
            });
        };

        $scope.changeCover = function () {
            console.log('change cover');
            console.log(imgNowsrc);
            if(imgNowsrc){
                $scope.popup_cover = imgNowsrc;
            }
        };
        $scope.editPopup = function (id,cover,linktype,link,showtype,showindex,timetype,timevalue) {
            $scope.popup_id = id;
            $scope.popup_cover = cover ? cover : '';
            $scope.popup_cover_show = cover ? cover : '/public/manage/img/zhanwei/zw_fxb_350_425.png';
            $scope.link_type = linktype;
            console.log($scope.link_type);
            $scope.link_path = link;
            $scope.show_type = showtype;
            $scope.show_index = showindex;
            $scope.timeType = timetype;
            $scope.timeValue = timevalue;
            $('#upload-cover').attr('src',$scope.popup_cover_show);
            $('#popup_cover').val($scope.popup_cover);
            //$('#timeType').val($scope.timeType);
            if($scope.show_index == 1){
                $('#index_yes').prop('checked',true);
            }else{
                $('#index_no').prop('checked',true);
            }

            if($scope.show_type == 1){
                $('#showtype_1').prop('checked',true);
            }else{
                $('#showtype_2').prop('checked',true);
            }
        };

        $scope.addPopup = function () {
            $scope.link_type = 1;
            $scope.link_path = '';
            $scope.popup_id = 0;
            $scope.show_type = 2;
            $scope.show_index = 0;
            $scope.timeType = 1;
            $scope.timeValue = 1;
            $('#popup_cover').val('');
            $('#upload-cover').attr('src','/public/manage/img/zhanwei/zw_fxb_350_425.png');
        };

        $(function(){
            /*
            $('.confirm-handle').on('click',function () {

                $scope.link_type = $(this).data('linktype');
                $scope.link_path = $(this).data('link');

                $scope.popup_id = $(this).data('id');
                $scope.popup_cover = $(this).data('cover');
                $scope.show_type = $(this).data('showtype');
                $scope.show_index = $(this).data('showindex');
                $('#upload-cover').attr('src',$scope.popup_cover);
                $('#popup_cover').val($scope.popup_cover);
                // $('#popup_cover').val($scope.popup_cover);
                // $('#popup_id').val($scope.popup_id);
                // $('.link_type').val($scope.link_type);
                // $('.link_path_' + $scope.link_type).val($scope.link_path);

                if($scope.show_index == 1){
                    $('#index_yes').prop('checked',true);
                }else{
                    $('#index_no').prop('checked',true);
                }

                if($scope.show_type == 1){
                    $('#showtype_1').prop('checked',true);
                }else{
                    $('#showtype_2').prop('checked',true);
                }

            });

            $('#add-new').on('click',function () {
                $scope.link_type = 1;
                $scope.link_path = '';
                //$scope.popup_cover = '';
                $scope.popup_id = 0;
                $scope.show_type = 2;
                $scope.show_index = 0;
                $('#popup_cover').val('');
                $('#upload-cover').attr('src','/public/manage/img/zhanwei/zw_fxb_350_425.png');
            });
            */

        });
    }]);


    function confirmDelete(ele) {
        layer.confirm('确定删除吗？', {
            title:'删除提示',
            btn: ['确定','取消'] //按钮
        }, function(){
            var id = $(ele).data('id');
            if(id){
                var loading = layer.load(2);
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/popup/popupDelete',
                    'data'  : { id:id},
                    'dataType' : 'json',
                    success : function(ret){
                        layer.close(loading);
                        layer.msg(ret.em);
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    }
                });
            }
        });

    }
    /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                $('#'+nowId).attr('src',allSrc[0]);
                if(nowId == 'upload-cover'){
                    $('#popup_cover').val(allSrc[0]);
                }
                if(nowId == 'brief-img'){
                    $('#brief-cover').val(allSrc[0]);
                }
            }else{
                var img_html = '';
                var cur_num = $('#'+nowId+'-num').val();
                for(var i=0 ; i< allSrc.length ; i++){
                    var key = i + parseInt(cur_num);
                    img_html += '<p>';
                    img_html += '<img class="img-thumbnail col" layer-src="'+allSrc[i]+'"  layer-pid="" src="'+allSrc[i]+'" >';
                    img_html += '<span class="delimg-btn">×</span>';
                    img_html += '<input type="hidden" id="slide_'+key+'" name="slide_'+key+'" value="'+allSrc[i]+'">';
                    img_html += '<input type="hidden" id="slide_id_'+key+'" name="slide_id_'+key+'" value="0">';
                    img_html += '</p>';
                }
                var now_num = parseInt(cur_num)+allSrc.length;
                if(now_num <= maxNum){
                    $('#'+nowId+'-num').val(now_num);
                    $('#'+nowId).prepend(img_html);
                }else{
                    layer.msg('幻灯图片最多'+maxNum+'张');
                }
            }
        }
    }

    function changeShow(id,status) {
        if(id){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/popup/popupChangShow',
                'data'  : { id:id,status:status},
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);

                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        }
    }


</script>
<?php }} ?>
