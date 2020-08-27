<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 11:07:45
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/community/point-goods.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1704970785e4df80196d4b5-26136787%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2710227436cca87d6191e5e5180c3122b7357663' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/community/point-goods.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1704970785e4df80196d4b5-26136787',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'canShare' => 0,
    'statInfo' => 0,
    'appletCfg' => 0,
    'import' => 0,
    'name' => 0,
    'gtype' => 0,
    'choseLink' => 0,
    'val' => 0,
    'status' => 0,
    'threeSale' => 0,
    'openPoint' => 0,
    'list' => 0,
    'deduct' => 0,
    'paginator' => 0,
    'integral' => 0,
    'ikey' => 0,
    'ial' => 0,
    'now' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4df801a1a680_82237174',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df801a1a680_82237174')) {function content_5e4df801a1a680_82237174($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style type="text/css">
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "开启\a0\a0\a0\a0\a0\a0\a0\a0禁止";
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before{
        background-color: #D15B47;
        border: 1px solid #CC4E38;
    }
    .alert-yellow {
        color: #FF6330;
        font-weight: bold;
        background-color: #FFFFCC;
        border-color: #FFDA89;
        margin:10px 0;
        letter-spacing: 0.5px;
        border-radius: 2px;
    }
    /* 商品列表图片名称样式 */
    td.proimg-name{
        min-width: 250px;
    }
    td.proimg-name img{
        float: left;
    }
    td.proimg-name>div{
        display: inline-block;
        margin-left: 10px;
        color: #428bca;
        width:100%
    }
    td.proimg-name>div .pro-name{
        max-width: 350px;
        margin: 0;
        width: 60%;
        margin-right: 40px;
        display: -webkit-box !important;
        overflow: hidden;
        text-overflow: ellipsis;
        word-break: break-all;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        white-space: normal;
    }
    td.proimg-name>div .pro-price{
        color: #E97312;
        font-weight: bold;
        margin: 0;
        margin-top: 5px;
    }
    .ui-popover.ui-popover-tuiguang.left-center .arrow{
        top:160px;
    }
    #sample-table-1{
        border-right: none;
        border-left: none;
    }

    .balance {
        padding: 10px 0;
        border-top: 1px solid #e5e5e5;
        background: #fff;
        zoom: 1;
    }
    .balance-info {
        text-align: center;
        padding: 0 15px 30px;
    }
    .balance .balance-info {
        float: left;
        width: 50%;
        margin-left: -1px;
        padding: 0 15px;
        border-left: 1px solid #e5e5e5;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .balance .balance-info2 {
        width: 50%;
    }
    .balance .balance-info .balance-title {
        font-size: 14px;
        color: #999;
        margin-bottom: 10px;
    }
    .balance .balance-info .balance-title span {
        font-size: 12px;
    }
    .balance .balance-info .balance-content {
        zoom: 1;
    }
    .balance .balance-info .balance-content .money {
        font-size: 25px;
        color: #f60;
    }
    .balance .balance-info .balance-content span, .balance .balance-info .balance-content a {
        vertical-align: baseline;
        line-height: 26px;
    }
    .balance .balance-info .balance-content .unit {
        font-size: 12px;
        color: #666;
    }
    .pull-right {
        float: right;
    }
    .balance .balance-info .balance-content .money {
        font-size: 25px;
        color: #f60;
    }
    .balance .balance-info .balance-content .money-font {
        font-size: 20px;
    }
    .choose-state>a.active{border-bottom-color: #4C8FBD;border-top:0;}
</style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-community-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div  id="content-con"  style="padding-left: 130px;">
    <!-- 推广商品弹出框 -->
    <div class="ui-popover ui-popover-tuiguang left-center">
        <div class="ui-popover-inner" style="padding: 0;border-radius: 7px;overflow: hidden;">
            <div class="tab-name">
                <span class="active">商品二维码</span>
                <span>商品链接</span>
            </div>
            <div class="tab-main">
                <div class="code-box show">
                    <div class="alert alert-orange">扫一扫，在手机上查看并分享<a class="new-window pull-right" href="#" target="_blank">帮助</a></div>
                    <div class="code-fenlei">
                        <div class="pull-left">
                            <ul>
                                <li class="active">直接购买<i class="icon-play"></i></li>
                                <?php if ($_smarty_tpl->tpl_vars['canShare']->value) {?><li>关注后购买<i class="icon-play"></i></li><?php }?>
                            </ul>
                        </div>
                        <div class="pull-right">
                            <div class="text-center show">
                                <img src="" id="act-code-img" alt="二维码">
                                <p>扫码后直接购买</p>
                                <div class="text-left">
                                    <a href="" id="tuangou" class="new-window" target="_blank">下载二维码</a>
                                </div>
                            </div>
                            <?php if ($_smarty_tpl->tpl_vars['canShare']->value) {?>
                            <div class="text-center">
                                <img src="" id="share-code-img" alt="二维码">
                                <p>关注后购买</p>
                                <div class="text-left">
                                    <a href="" id="guanzhu" class="new-window" target="_blank">下载二维码</a>
                                </div>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
                <div class="link-box">
                    <div class="alert alert-orange">分享才有更多人看到哦</div>
                    <div class="link-wrap">
                        <p>商品页链接</p>
                        <div class="input-group copy-div">
                            <input type="text" class="form-control" id="copyLink" value="http://www.fenxiaobao.xin/wxapp/goods/index" readonly>
                            <span class="input-group-btn">
                                <a href="#" class="btn btn-white copy_input" id="copygoods" type="button" data-clipboard-target="copyLink" style="border-left:0;outline:none;padding-left:0;padding-right:0;width:60px;text-align:center">复制</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="arrow"></div>
    </div>
    <!-- 复制链接弹出框 -->
    <div class="ui-popover ui-popover-link left-center" style="top:100px;">
        <div class="ui-popover-inner">
            <div class="input-group copy-div">
                <input type="text" class="form-control" id="copy" value="" readonly>
                <span class="input-group-btn">
                    <a href="#" class="btn btn-white copy_input" id="copycardid" type="button" data-clipboard-target="copy" style="border-left:0;outline:none;padding-left:0;padding-right:0;width:60px;text-align:center">复制</a>
                </span>
            </div>
        </div>
        <div class="arrow"></div>
    </div>
    <!-- 汇总信息 -->
    <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
        <div class="balance-info">
            <div class="balance-title">出售中<span></span></div>
            <div class="balance-content">
                <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['sale'];?>
</span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">已下架<span></span></div>
            <div class="balance-content">
                <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['nosale'];?>
</span>
            </div>
        </div>
    </div>
    <a href="/wxapp/community/addPointGoods" class="btn btn-green btn-xs"><i class="icon-plus bigger-80"></i> 新增</a>
    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=7&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=27&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=30&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=3&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=12) {?>
    <a href="/wxapp/community/selectGoods" class="btn btn-blue btn-xs"><i class="icon-plus bigger-80"></i> 选择</a>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['import']->value) {?>
    <a href="<?php echo $_smarty_tpl->tpl_vars['import']->value['link'];?>
" class="btn btn-pink btn-xs"><i class="icon-exchange bigger-80"></i> <?php echo $_smarty_tpl->tpl_vars['import']->value['name'];?>
</a>
    <?php }?>
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/community/pointGoods" method="get" class="form-inline">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">商品名称</div>
                                <input type="text" class="form-control" name="name" value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" placeholder="商品名称">
                            </div>
                        </div>
                        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=27) {?>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon" style="height:34px;">类别</div>
                                <select id="gtype" name="gtype" style="height:34px;width:100%" class="form-control">
                                    <option value="0">全部</option>
                                    <option  <?php if ($_smarty_tpl->tpl_vars['gtype']->value==4) {?>selected<?php }?> value="4">实物商品</option>
                                    <option  <?php if ($_smarty_tpl->tpl_vars['gtype']->value==5) {?>selected<?php }?> value="5">虚拟商品</option>
                                </select>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                </div>
                <div class="col-xs-1 pull-right search-btn">
                    <button type="submit" class="btn btn-green btn-sm">查询</button>
                </div>
            </form>
        </div>
    </div>
    <div class="choose-state">
        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['choseLink']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['href'];?>
" <?php if ($_smarty_tpl->tpl_vars['status']->value==$_smarty_tpl->tpl_vars['val']->value['key']) {?> class="active" <?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['label'];?>
</a>
        <?php } ?>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="fixed-table-box" style="margin-bottom: 30px;">
                <div class="fixed-table-header">
                    <table class="table table-striped table-hover table-avatar">
                        <thead>
                            <tr>
                                <th class="center">
                                    <label>
                                        <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                        <span class="lbl"></span>
                                    </label>
                                </th>
                                <th>商品</th>
                                <th>价格 积分</th>
                                <th>库存</th>
                                <th>商品销量</th>
                                <th>排序权重</th>
                                <th>
                                    <i class="icon-time bigger-110 hidden-480"></i>
                                    最近更新
                                </th>
                                <!--<?php if ($_smarty_tpl->tpl_vars['threeSale']->value) {?><th>单品分销</th><?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['openPoint']->value) {?><th>积分</th><?php }?>-->
                                <th>操作</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="fixed-table-body">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
">
                                <td class="center">
                                    <label>
                                        <input type="checkbox" class="ace" name="ids" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
"/>
                                        <span class="lbl"></span>
                                    </label>
                                </td>
                                <td class="proimg-name" style="min-width: 270px;">
                                    <?php if (isset($_smarty_tpl->tpl_vars['val']->value['g_cover'])) {?>
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_cover'];?>
" width="60" height="60" alt="封面图" style="border-radius: 4px;">
                                    <?php }?>
                                    <div>
                                        <p class="pro-name">
                                            <?php if (mb_strlen($_smarty_tpl->tpl_vars['val']->value['g_name'])>20) {?><?php echo mb_substr($_smarty_tpl->tpl_vars['val']->value['g_name'],0,20);?>

                                            <?php echo mb_substr($_smarty_tpl->tpl_vars['val']->value['g_name'],20,40);?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['val']->value['g_name'];?>
<?php }?>
                                        </p>
                                        <!--<p class="pro-price"><?php echo $_smarty_tpl->tpl_vars['val']->value['g_price'];?>
 + <?php echo $_smarty_tpl->tpl_vars['val']->value['g_points'];?>
</p>-->
                                    </div>
                                    
                                </td>
                                <td>
                                	<p class="pro-price" style="color: #E97312;font-weight: bold;"><?php echo $_smarty_tpl->tpl_vars['val']->value['g_price'];?>
 + <?php echo $_smarty_tpl->tpl_vars['val']->value['g_points'];?>
</p>
                                </td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['g_stock'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['g_sold'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['g_weight'];?>
</td>
                                <td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['g_update_time']);?>
</td>
                                <!--<?php if ($_smarty_tpl->tpl_vars['threeSale']->value) {?>
                                <td>
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['g_is_deduct']) {?>已开启<?php } else { ?>未开启<?php }?>
                                    <a href="javascript:;"
                                       data-gid="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
"
                                       data-ratio_0="<?php if (isset($_smarty_tpl->tpl_vars['deduct']->value[$_smarty_tpl->tpl_vars['val']->value['g_id']])) {?><?php echo $_smarty_tpl->tpl_vars['deduct']->value[$_smarty_tpl->tpl_vars['val']->value['g_id']]['gd_0f_ratio'];?>
<?php }?>"
                                       data-ratio_1="<?php if (isset($_smarty_tpl->tpl_vars['deduct']->value[$_smarty_tpl->tpl_vars['val']->value['g_id']])) {?><?php echo $_smarty_tpl->tpl_vars['deduct']->value[$_smarty_tpl->tpl_vars['val']->value['g_id']]['gd_1f_ratio'];?>
<?php }?>"
                                       data-ratio_2="<?php if (isset($_smarty_tpl->tpl_vars['deduct']->value[$_smarty_tpl->tpl_vars['val']->value['g_id']])) {?><?php echo $_smarty_tpl->tpl_vars['deduct']->value[$_smarty_tpl->tpl_vars['val']->value['g_id']]['gd_2f_ratio'];?>
<?php }?>"
                                       data-ratio_3="<?php if (isset($_smarty_tpl->tpl_vars['deduct']->value[$_smarty_tpl->tpl_vars['val']->value['g_id']])) {?><?php echo $_smarty_tpl->tpl_vars['deduct']->value[$_smarty_tpl->tpl_vars['val']->value['g_id']]['gd_3f_ratio'];?>
<?php }?>"
                                       data-used="<?php if (isset($_smarty_tpl->tpl_vars['deduct']->value[$_smarty_tpl->tpl_vars['val']->value['g_id']])) {?><?php echo $_smarty_tpl->tpl_vars['deduct']->value[$_smarty_tpl->tpl_vars['val']->value['g_id']]['gd_is_used'];?>
<?php } else { ?>0<?php }?>"
                                       class="fxGoods"> 设置 </a>
                                </td>
                                <?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['openPoint']->value) {?>
                                <td>
                                    <a href="javascript:;" class="setPoint"
                                       data-gid="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
"
                                       data-format="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_has_format'];?>
"
                                       data-point="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_send_point'];?>
"
                                       data-num="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_back_num'];?>
"
                                       data-unit="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_back_unit'];?>
"
                                            >设置积分</a>
                                </td>
                                <?php }?>-->

                                <td style="color:#ccc;">
                                    <a href="/wxapp/community/addPointGoods/?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" >编辑</a> -
                                    <!--<a href="javascript:;" id="link_<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" class="btn-link" data-link="<?php echo $_smarty_tpl->tpl_vars['val']->value['link'];?>
">链接</a> - -->
                                    <a href="javascript:;" id="del_<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" class="btn-del" data-gid="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" style="color:#f00;">删除</a>
                                    <!-- - <a href="javascript:;" class="btn-tuiguang" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_id'];?>
" data-link="<?php echo $_smarty_tpl->tpl_vars['val']->value['link'];?>
" data-share="<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_share_qrcode'];?>
">推广活动</a> -->
                                </td>
                            </tr>
                            <?php } ?>
                            <tr><td colspan="2">
                                    <?php if ($_smarty_tpl->tpl_vars['status']->value=='sell') {?>
                                    <span class="btn btn-xs btn-name btn-shelf btn-origin" data-type="down">下架</span>
                                    <?php } elseif ($_smarty_tpl->tpl_vars['status']->value=='depot') {?>
                                    <span class="btn btn-xs btn-name btn-shelf btn-primary" data-type="up">上架</span>
                                    <?php }?>
                                </td><td colspan="8" style="text-align:right"><?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>
</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
    <?php if ($_smarty_tpl->tpl_vars['threeSale']->value) {?>
    <div id="modal-info-form" class="modal fade" tabindex="-1">
        <div class="modal-dialog" style="width:850px;;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="blue bigger" id="modal-title">佣金配置设置</h4>
                </div>

                <div class="modal-body" style="overflow: hidden;">
                    <input type="hidden" class="form-control" id="hid-goods" value="0">
                    <input type="hidden" class="form-control" id="hid-type" value="deduct">
                    <!--分佣比例设置-->
                    <div id="threeSale" class="tab-div">
                        <div class="alert alert-block alert-yellow">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            若未开启，或者未设置，则按 店铺 佣金配置进行分销!
                        </div>
                        <div class="col-sm-12" style="margin-bottom: 20px;">
                            <div id="home"  class="tab-pane in active">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon input-group-addon-title">购买人返现比例</div>
                                        <input type="text" class="form-control" id="ratio_0" placeholder="返现比例百分比">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon input-group-addon-title">上级提成比例</div>
                                        <input type="text" class="form-control" id="ratio_1" placeholder="百分比">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                                <?php if ($_smarty_tpl->tpl_vars['threeSale']->value>1) {?>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon input-group-addon-title">二级提成比例</div>
                                        <input type="text" class="form-control" id="ratio_2"  placeholder="百分比">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                                <?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['threeSale']->value>2) {?>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon input-group-addon-title">三级提成比例</div>
                                        <input type="text" class="form-control" id="ratio_3"  placeholder="百分比">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                                <?php }?>
                                <div class="input-group col-sm-3">
                                    <div class="input-group-addon"> 是否开启 : &nbsp;</div>
                                    <label class="input-group-addon" id="choose-yesno" style="padding: 4px 10px;margin: 0;border: 1px solid #D5D5D5;">
                                        <input name="used" class="ace ace-switch ace-switch-5" id="used"  type="checkbox">
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--积分设置-->
                    <div id="setPoint" class="tab-div">
                        <input type="hidden" class="form-control" id="hid-num" value="1">
                        <input type="hidden" class="form-control" id="hid-format" value="0">
                        <div id="pointContent">

                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">返还期数</div>
                                <input type="text" class="form-control" style="height: 40px;" id="backNum" value="" placeholder="请填写大于0的整数" >
                                <div class="input-group-addon">
                                    <div class="radio-box">
                                        <?php  $_smarty_tpl->tpl_vars['ial'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ial']->_loop = false;
 $_smarty_tpl->tpl_vars['ikey'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['integral']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['ial']->key => $_smarty_tpl->tpl_vars['ial']->value) {
$_smarty_tpl->tpl_vars['ial']->_loop = true;
 $_smarty_tpl->tpl_vars['ikey']->value = $_smarty_tpl->tpl_vars['ial']->key;
?>
                                        <span data-val="<?php echo $_smarty_tpl->tpl_vars['ikey']->value;?>
">
                                            <input type="radio" name="backUnit" value="<?php echo $_smarty_tpl->tpl_vars['ikey']->value;?>
" id="refer<?php echo $_smarty_tpl->tpl_vars['ikey']->value;?>
" >
                                            <label for="refer<?php echo $_smarty_tpl->tpl_vars['ikey']->value;?>
">按<?php echo $_smarty_tpl->tpl_vars['ial']->value;?>
</label>
                                        </span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-block alert-yellow">
                            期数为“1”，则购买后立即赠送积分。
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary modal-save">保存</button>
                </div>
            </div>
        </div>
    </div>    <!-- MODAL ENDS -->
    <?php }?>
</div>    <!-- PAGE CONTENT ENDS -->

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script type="text/javascript">
    // 定义一个新的复制对象
    var clip = new ZeroClipboard( $('.copy_input'), {
        moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
    });
    // 复制内容到剪贴板成功后的操作
    clip.on( 'complete', function(client, args) {
        layer.msg('复制成功');
        optshide();
    } );
    /*复制链接地址弹出框*/
    $("#content-con").on('click', 'table td a.btn-link', function(event) {
        var link = $(this).data('link');
        if(link){
            $('.copy-div input').val(link);
        }
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-104;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        optshide();
        $(".ui-popover.ui-popover-link").css({'left':left-conLeft-510,'top':top-conTop-122}).stop().show();
     });
    // 推广商品弹出框
    $("#content-con").on('click', 'table td a.btn-tuiguang', function(event) {
        var link   = $(this).data('link');
        var share  = $(this).data('share');
        var linkImg        = '/wxapp/shop/qrcode?url='+link;
        var shareImg       = share ? '/manage/shop/qrcode?url='+share : linkImg;
        var groupDown      = '/manage/plugin/downCode/?name=tuangou&link='+link;
        var shareDown      = share ? '/manage/plugin/downCode/?name=guanzhu&link='+share : groupDown;
        $('#copyLink').val(link); //购买链接
        $('#act-code-img').attr('src',linkImg); //购买二维码图片
        $('#share-code-img').attr('src',shareImg); //分享二维码图片
        $('#tuangou').attr('href',groupDown); //购买二维码下载
        $('#guanzhu').attr('href',shareDown); //分享二维码下载
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-104;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        optshide();
        $(".ui-popover.ui-popover-tuiguang").css({'left':left-conLeft-530,'top':top-conTop-158-95}).stop().show();
     });
    $(".ui-popover-tuiguang").on('click', '.tab-name>span', function(event) {
        event.preventDefault();
        var $this = $(this);
        var index = $this.index();
        $this.addClass('active').siblings().removeClass('active');
        $this.parents(".ui-popover-tuiguang").find(".tab-main>div").eq(index).addClass('show').siblings().removeClass('show');
    });
    $(".ui-popover-tuiguang").on('click', '.code-fenlei .pull-left li', function(event) {
        event.preventDefault();
        var $this = $(this);
        var index = $this.index();
        $this.addClass('active').siblings().removeClass('active');
        $this.parents(".ui-popover-tuiguang").find(".code-fenlei .pull-right .text-center").eq(index).addClass('show').siblings().removeClass('show');
    });
    $(".ui-popover-tuiguang").on('click', function(event) {
        event.stopPropagation();
    });
     $("body").on('click', function(event) {
        optshide();
     });
     /*隐藏弹出框*/
     function optshide(){
         $('.ui-popover').stop().hide();
     }
    $('.btn-shelf').on('click',function(){
        var type = $(this).data('type');
        var ids  = get_select_all_ids_by_name('ids');
        if(ids && type){
            var data = {
                'ids' : ids,
                'type' : type
            };
            var url = '/wxapp/goods/shelf';
            plumAjax(url,data,true);
        }

    });
    $('.fxGoods').on('click',function(){
        var gid = $(this).data('gid');
        if(gid){
            for(var i=0 ; i<=3 ; i++){
                var temp = $(this).data('ratio_'+i);
                $('#ratio_'+i).val(temp);
            }
            var used = $(this).data('used');
            if(used == 1) {
                $('input[name="used"]').prop("checked","checked");
            }else{
                $('input[name="used"]').prop("checked","");
            }

            show_modal_content('threeSale',gid);
            $('#modal-info-form').modal('show');
        }else{
            layer.msg('未获取到商品信息');
        }
    });
    $('.setPoint').on('click',function(){
        var gid    = $(this).data('gid');
        var format = $(this).data('format');
        var point  = $(this).data('point');
        var unit   = $(this).data('unit');
        $('#backNum').val($(this).data('num'));
        $('input[name="backUnit"][value="'+unit+'"]').attr("checked",true);
        if(format == 0){
            var html = show_point_setting('赠送积分','sendPoint0',point,gid);
            $('#hid-num').val(1);
            $('#pointContent').html(html);
        }else{ //多规格的，分别处理
            var data = {
                'gid' : gid
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/goods/formatToPoint',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    if(ret.ec == 200){
                        var html = '';
                        for(var i = 0 ; i < ret.data.length ; i ++){
                            var row = ret.data;
                            html += show_point_setting(row[i]['name'],'sendPoint'+i,row[i]['point'],row[i]['id'])
                        }

                        $('#hid-num').val(ret.data.length);
                        $('#pointContent').html(html);
                    }
                }
            });
        }
        $('#hid-format').val(format);
        show_modal_content('setPoint',gid);
        $('#modal-info-form').modal('show');
    });
    function show_point_setting(title,id,val,did){
        var _html = '<div class="form-group">';
        _html += '<div class="input-group">';
        _html += '<div class="input-group-addon input-group-addon-title">'+title+'</div>';
        _html += '<input type="text" class="form-control" id="'+id+'" value="'+val+'" data-id="'+did+'" placeholder="请填写积分">';
        _html += '<div class="input-group-addon">分</div>';
        _html += '</div></div>';
        _html += '<div class="space-4"></div>';
        return _html;
    }
    function show_modal_content(id,gid){
        $('.tab-div').hide();
        $('#'+id).show();
        $('#hid-goods').val(gid);
        var title = '佣金配置设置',type='deduct';
        switch (id){
            case 'threeSale':
                title = '佣金配置设置';
                type  = 'deduct';
                break;
            case 'setPoint':
                title = '商品积分设置';
                type  = 'point';
                break;
        }
        $('#modal-title').text(title);
        $('#hid-type').val(type);
    }
    $('.btn-del').on('click',function(){
        var data = {
            'id' : $(this).data('gid'),
            'type': 'goods'
        };
        //commonDeleteById(data);
        commonDeleteByIdWxapp(data);
    });
    $('.modal-save').on('click',function(){
        var type = $('#hid-type').val();
        switch (type){
            case 'deduct':
                saveRatio();
                break;
            case 'point':
                savePoint();
                break;
        }

    });
    function saveRatio(){
        var gid = $('#hid-goods').val();
        if(gid){
            var ck = $('#used:checked').val();
            var data = {
                'gid'  : gid,
                'used' : ck == 'on' ? 1 : 0,
            };
            for(var i=0 ; i<=3 ; i++){
                data['ratio_'+i] = $('#ratio_'+i).val();
            }
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/goods/saveRatio',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });

        }
    }

    function savePoint(){
        var data = {
            'gid'    : $('#hid-goods').val(),
            'format' : $('#hid-format').val(),
            'unit'   : $('input[name="backUnit"]:checked').val(),
            'num'    : parseInt($('#backNum').val())
        };
        if(data.num <= 0){
            layer.msg('请填写返还期数');
            return false;
        }
        if(data.format == 0){
            data.point = $('#sendPoint0').val();
        }else{
            var num    = $('#hid-num').val();
            var point  = {};
            for(var i = 0 ; i < num ; i ++){
                var temp = {
                    'id' : $('#sendPoint'+i).data('id'),
                    'val': $('#sendPoint'+i).val()
                };
                point['point_'+i] = temp;
            }
            data.point = point;
        }
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/savePoint',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });
    }

    $(function(){
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        var lists    =  '<?php echo $_smarty_tpl->tpl_vars['now']->value;?>
';
        $(".form-group-box .form-container .form-group").each(function(){
            groupItemWidth=Number($(this).outerWidth(true));
            sumWidth +=groupItemWidth;
        });
        $(".form-group-box .form-container").css("width",sumWidth+"px");
        if(lists){
            tableFixedInit();//表格初始化
            $(window).resize(function(event) {
                tableFixedInit();
            });
        }
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
</script><?php }} ?>
