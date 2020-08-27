<?php /* Smarty version Smarty-3.1.17, created on 2020-05-11 09:15:00
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/appointment/goods-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:290724095eb8a714148de9-19787226%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '32b31ab77dc936806d3525dadc9203deafdcc097' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/appointment/goods-list.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '290724095eb8a714148de9-19787226',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'statInfo' => 0,
    'name' => 0,
    'category_select' => 0,
    'key' => 0,
    'kind' => 0,
    'val' => 0,
    'choseLink' => 0,
    'status' => 0,
    'menuType' => 0,
    'list' => 0,
    'paginator' => 0,
    'now' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5eb8a7141d43e3_04253956',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5eb8a7141d43e3_04253956')) {function content_5eb8a7141d43e3_04253956($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">
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
    /* 项目列表图片名称样式 */
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
    .fixed-table-body #sample-table-1{
        border-right: none;
        border-left: none;
    }
    .index-con {
        padding: 0;
        position: relative;
    }
    .index-con .index-main {
        height: 425px;
        background-color: #f3f4f5;
        overflow: auto;
    }
    .message{
        width: 92%;
        background-color: #fff;
        border:1px solid #ddd;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -ms-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        margin:10px auto;
        -webkit-box-sizing:border-box;
        -moz-box-sizing:border-box;
        -ms-box-sizing:border-box;
        -o-box-sizing:border-box;
        box-sizing:border-box;
        padding:5px 8px 0;
    }
    .message h3{
        font-size: 15px;
        font-weight: bold;
    }
    .message .date{
        color: #999;
        font-size: 13px;
    }
    .message .remind-txt{
        padding:5px 0;
        margin-bottom: 5px;
        font-size: 13px;
        color: #FF1F1F;
    }
    .message .item-txt{
        font-size: 13px;
    }
    .message .item-txt .text{
        color: #5976be;
    }
    .message .see-detail{
        border-top:1px solid #eee;
        line-height: 1.6;
        padding:5px 0 7px;
        margin-top: 12px;
        background: url(/public/manage/mesManage/images/enter.png) no-repeat;
        background-size: 12px;
        background-position: 99% center;
    }
    .preview-page{
        max-width: 900px;
        margin:0 auto;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        padding:20px 15px;
        overflow: hidden;
    }
    .preview-page .mobile-page{
        width: 350px;
        float: left;
        background-color: #fff;
        border: 1px solid #ccc;
        -webkit-border-radius: 15px;
        -moz-border-radius: 15px;
        -ms-border-radius: 15px;
        -o-border-radius: 15px;
        border-radius: 15px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        padding:0 15px;
    }
    .preview-page {
        padding-bottom: 20px!important;
    }
    .mobile-page{
        margin-left: 48px;
    }
    .mobile-page .mobile-header {
        height: 70px;
        width: 100%;
        background: url(/public/manage/mesManage/images/iphone_head.png) no-repeat;
        background-position: center;
    }
    .mobile-page .mobile-con{
        width: 100%;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        border:1px solid #ccc;
        background-color: #fff;
    }
    .mobile-con .title-bar{
        height: 64px;
        background: url(/public/manage/mesManage/images/titlebar.png) no-repeat;
        background-position: center;
        padding-top:20px;
        font-size: 16px;
        line-height: 44px;
        text-align: center;
        color: #fff;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        letter-spacing: 1px;
    }

    .mobile-page .mobile-footer{
        height: 65px;
        line-height: 65px;
        text-align: center;
        width: 100%;
    }
    .mobile-page .mobile-footer span{
        display: inline-block;
        height: 45px;
        width: 45px;
        margin:10px 0;
        background-color: #e6e1e1;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
        border-radius: 50%;
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
	.choose-state>a.active{
		border-top:0;
		border-bottom-color:#4C8FBD;
	}
</style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu-new.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div  id="content-con" style="margin-left: 140px">
    <!-- 汇总信息 -->
    <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
        <div class="balance-info">
            <div class="balance-title">在售项目<span></span></div>
            <div class="balance-content">
                <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['sale'];?>
</span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">下架项目<span></span></div>
            <div class="balance-content">
                <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['nosale'];?>
</span>
            </div>
        </div>
    </div>
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/appointment/goods" method="get" class="form-inline">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">项目名称</div>
                                <input type="text" class="form-control" name="name" value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" placeholder="项目名称">
                            </div>
                        </div>
                    </div>

                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">项目分类</div>
                                <select name="kind" class="form-control">
                                    <option value="0">全部</option>
                                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['category_select']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['key']->value==$_smarty_tpl->tpl_vars['kind']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-xs-1 pull-right search-btn">
                    <button type="submit" class="btn btn-green btn-sm">查询</button>
                </div>
            </form>
        </div>
    </div>
    <div style="margin-bottom: 20px">
        <a href="/wxapp/appointment/addGood" class="btn btn-green btn-xs"><i class="icon-plus bigger-80"></i> 新增</a>
        <a href="/wxapp/appointment/appointmentKindList" class="btn btn-green btn-xs">分类管理</a>
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
                    <table class="table table-hover table-avatar">
                        <thead>
                            <tr>
                                <th class="center">
                                    <label>
                                        <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                        <span class="lbl"></span>
                                    </label>
                                </th>
                                <th>项目 价格</th>
                                <th>分类</th>
                                <!--
                                <th>首页推荐</th>
                                -->
                                <th>预约时长</th>
                                <th>预约时间</th>
                                <th>预约日期</th>
                                <!--
                                <th>
                                    <i class="icon-time bigger-110 hidden-480"></i>
                                    最近更新
                                </th>
                                -->
                                <?php if (!in_array($_smarty_tpl->tpl_vars['menuType']->value,array('aliapp','bdapp','toutiao'))) {?>
                                <th>是否已推送</th>
                                <?php }?>
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
" width="144px" height="82px" alt="封面图">
                                    <?php }?>
                                    <div>
                                        <p class="pro-name">
                                            <?php if (mb_strlen($_smarty_tpl->tpl_vars['val']->value['g_name'])>20) {?><?php echo mb_substr($_smarty_tpl->tpl_vars['val']->value['g_name'],0,20);?>

                                            <?php echo mb_substr($_smarty_tpl->tpl_vars['val']->value['g_name'],20,40);?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['val']->value['g_name'];?>
<?php }?>
                                        </p>
                                        <p class="pro-price"><?php if ($_smarty_tpl->tpl_vars['val']->value['g_price']>0) {?><?php echo $_smarty_tpl->tpl_vars['val']->value['g_price'];?>
<?php } else { ?>免费<?php }?></p>
                                        <p>
                                            <?php if ($_smarty_tpl->tpl_vars['val']->value['g_is_top']==1) {?>
                                            <!--<span class="label label-sm label-success">首页推荐</span>-->
                                            <span style="color:#82af6f;border:1px solid #82af6f;border-radius:4px;padding:0 2px;">首页推荐</span>
                                            <?php }?>
                                        </p>
                                    </div>
                                    
                                </td>
                                <td><?php echo $_smarty_tpl->tpl_vars['category_select']->value[$_smarty_tpl->tpl_vars['val']->value['g_appointment_kind']];?>
</td>
                                <!--
                                <td>
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['g_is_top']==1) {?>
                                    <span class="label label-sm label-success">首页推荐</span>
                                    <?php }?>
                                </td>
                                -->
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['g_appointment_length'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['g_appointment_time'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['g_appointment_date'];?>
</td>
                                <!--
                                <td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['g_update_time']);?>
</td>
                                -->
                                <?php if (!in_array($_smarty_tpl->tpl_vars['menuType']->value,array('aliapp','bdapp','toutiao','qq','qihoo'))) {?>
                                <td><?php if ($_smarty_tpl->tpl_vars['val']->value['g_push']) {?>已推送<?php } else { ?><span style="color:#333;">未推送</span><?php }?></td>
                                <?php }?>
                                <td style="color:#ccc;">
                                    <?php if (!in_array($_smarty_tpl->tpl_vars['menuType']->value,array('aliapp','bdapp','toutiao','qq','qihoo'))) {?>
                                	<p>
                                        <a href="javascript:;" onclick="pushAppointment('<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
')" >推送</a> -
                                        <?php if (!in_array($_smarty_tpl->tpl_vars['menuType']->value,array('weixin'))) {?>
                                        <a href="javascript:;" data-toggle="modal" data-target="#tplPreviewModal" onclick="showPreview('<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
')">预览</a> -
                                        <?php }?>
                                        <a href="/wxapp/tplpreview/pushHistory?type=appointment&id=<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" >记录</a>
                                    </p>
                                    <?php }?>
                                    <p>
                                        <a href="/wxapp/appointment/addGood?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" >编辑</a> -
                                        <a href="javascript:;" id="del_<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" class="btn-del" data-gid="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" style="color:#f00;">删除</a>
                                    </p>                       
                                </td>
                            </tr>
                            <?php } ?>
                            <tr><td colspan="2">
                                    <?php if ($_smarty_tpl->tpl_vars['status']->value=='sell') {?>
                                    <span class="btn btn-xs btn-name btn-shelf btn-primary" data-type="down">下架</span>
                                    <?php } elseif ($_smarty_tpl->tpl_vars['status']->value=='depot') {?>
                                    <span class="btn btn-xs btn-name btn-shelf btn-primary" data-type="up">上架</span>
                                    <?php }?>
                                </td><td colspan="10" style="text-align:right"><?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>
</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
</div>    <!-- PAGE CONTENT ENDS -->
<div class="modal fade" id="tplPreviewModal" tabindex="-1" role="dialog" aria-labelledby="tplPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="overflow: auto; width: 500px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    推送预览
                </h4>
            </div>
            <div class="modal-body preview-page" style="overflow: auto">
                <div class="mobile-page ">
                    <div class="mobile-header"></div>
                    <div class="mobile-con">
                        <div class="title-bar">
                            消息模板预览
                        </div>
                        <!-- 主体内容部分 -->
                        <div class="index-con">
                            <!-- 首页主题内容 -->
                            <div class="index-main" style="height: 380px;">
                                <div class="message">
                                    <h3 id="tpl-title"></h3>
                                    <p class="date" id="tpl-date"></p>
                                    <div class="item-txt"  id="tpl-content">

                                    </div>
                                    <div class="see-detail">进入小程序查看</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mobile-footer"><span></span></div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script type="text/javascript">
    $('.btn-del').on('click',function(){
        var data = {
            'id' : $(this).data('gid'),
            'type': 'goods'
        };
        commonDeleteByIdWxapp(data);
    });

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

    $(function(){
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        var lists    = '<?php echo $_smarty_tpl->tpl_vars['now']->value;?>
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

    function pushAppointment(id) {
        layer.confirm('确定要推送吗？', {
          btn: ['确定','取消'], //按钮
          title : '推送'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/tplpush/appointmentPush',
                'data'  : { id:id},
                'dataType' : 'json',
                success : function(ret){
                    layer.msg(ret.em,{
                        time: 2000, //2s后自动关闭
                    },function(){
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        }, function(){

        });
    }

    function showPreview(id) {
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/tplpreview/appointmentPreview',
            'data'  : {id:id},
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                if(ret.ec == 200){
                    $('#tpl-title').html(ret.data.title);
                    $('#tpl-date').html(ret.data.date);
                    var data = ret.data.tplData;
                    var html = '';
                    for(var i in data){
                        html += '<div>';
                        if(data[i]['emphasis'] != 1){
                            html += '<span class="title" >'+data[i]['titletxt']+'：</span>';
                            html += '<span class="text"  style="color:'+data[i]["color"]+'">'+data[i]['contxt']+'</span>';
                        }else{
                            html += '<span class="title" style="display: block;text-align: center">'+data[i]['titletxt']+'</span>';
                            html += '<span class="text" style="display: block;text-align: center;font-size: 20px"  style="color:'+data[i]["color"]+'">'+data[i]['contxt']+'</span>';
                        }
                        html += '</div>';
                    }
                    $('#tpl-content').html(html);
                }else{
                    layer.msg(ret.em);
                }

            }
        });
    }

</script><?php }} ?>
