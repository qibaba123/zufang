<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 19:02:28
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/mobile/mobile-shop-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15534464675e4e6744b5d158-55937186%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1dd23f7d715fb044c0952b47b906a4cb41ac0a42' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/mobile/mobile-shop-list.tpl',
      1 => 1579405884,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15534464675e4e6744b5d158-55937186',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'statInfo' => 0,
    'name' => 0,
    'categorySelect' => 0,
    'val' => 0,
    'category' => 0,
    'statusNote' => 0,
    'k' => 0,
    'status' => 0,
    'v' => 0,
    'end' => 0,
    'list' => 0,
    'cate' => 0,
    'paginator' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4e6744bd5a19_41919791',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4e6744bd5a19_41919791')) {function content_5e4e6744bd5a19_41919791($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/css/member-list.css">
<link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<!--<link rel="stylesheet" href="/public/manage/css/wechatArticle.css">-->
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-select.css">
<style>
    .inline-div{
        line-height: 34px;
        padding-right: 0;
        padding-left: 0;
    }
    .multi-choose-box{
        margin-bottom: 5px;
        margin-top: 5px;
    }
    .ui-popover{
        width: 300px;
    }
    .my-ui-btn{
        margin: 0 7px;
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
        width: calc(100% / 6);
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

</style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu-new.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="ui-popover ui-popover-select left-center" style="top:100px;">
    <div class="ui-popover-inner">
        <span style="display: inline-block;width: 100%;text-align: center">更改绑定会员</span>
        <?php echo $_smarty_tpl->getSubTemplate ("../layer/ajax-select-input-single.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <input type="hidden" id="hid_amsId" value="0">
        <div style="text-align: center">
            <a class="ui-btn ui-btn-primary js-save my-ui-btn" href="javascript:;">确定</a>
            <a class="ui-btn js-cancel my-ui-btn" href="javascript:;" onclick="optshide(this)">取消</a>
        </div>
    </div>
    <div class="arrow"></div>
</div>
<div id="content-con">
    <div  id="mainContent" >

        <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
            <div class="balance-info">
                <div class="balance-title">总店铺数<span></span></div>
                <div class="balance-content">
                    <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total'];?>
</span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">总收益<span></span></div>
                <div class="balance-content">
                    <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total_zsy'];?>
</span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">待审核<span></span></div>
                <div class="balance-content">
                    <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total_dsh'];?>
</span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">已通过<span></span></div>
                <div class="balance-content">
                    <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total_ytg'];?>
</span>
                </div>
            </div>

            <div class="balance-info">
                <div class="balance-title">后台添加<span></span></div>
                <div class="balance-content">
                    <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total_httj'];?>
</span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">已到期<span></span></div>
                <div class="balance-content">
                    <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total_ydq'];?>
</span>
                </div>
            </div>

        </div>

        <div class="page-header">
            <!--<a class="btn btn-green btn-xs add-activity" href="#" data-toggle="modal" data-target="#settledAgreement"><i class="icon-plus bigger-80"></i>入驻协议设置</a>-->
            <a href="/wxapp/mobile/shopEdit" class="btn btn-green btn-xs add-activity" ><i class="icon-plus bigger-80"></i> 新增</a>
            <a href="#" data-target="#excelModal" data-toggle="modal" class="btn btn-xs btn-primary">导出</a>
        </div>

        <div class="page-header search-box">
            <div class="col-sm-12">
                <form class="form-inline" action="/wxapp/mobile/shopList" method="get">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">店铺名称</div>
                                    <input type="text" class="form-control" name="name" value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
"  placeholder="店铺名称">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">店铺分类</div>
                                    <select name="category" id="" class="form-control">
                                        <option value="0">全部</option>
                                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categorySelect']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                        <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['val']->value['id']==$_smarty_tpl->tpl_vars['category']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">状态</div>
                                    <select name="status" id="" class="form-control">
                                        <option value="0">全部</option>
                                        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['statusNote']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                                        <option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['k']->value==$_smarty_tpl->tpl_vars['status']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <!--
					<div class="form-group">
						<div class="input-group" style="width: 210px;">
							<span class="input-group-addon" style="border: none !important;background-color:  inherit !important;">到</span>
							 <input type="text" class="form-control" name="end" value="<?php echo $_smarty_tpl->tpl_vars['end']->value;?>
" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                    <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
						</div>
					</div>
					-->
                        </div>
                    </div>
                    <div class="col-xs-1 pull-right search-btn" style="position: absolute;top: 5%;right: 2%;">
                        <button type="submit" class="btn btn-green btn-sm">查询</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                        	<th>店铺logo</th>
                            <th>会员编号</th>
                            <th>入驻店铺名称</th>
                            <!--
                            <th>电话</th>
                            <th>联系人</th>
                            -->
                            <th>分类</th>
                            <!--
                            <th>营业时间</th>
                            -->
                            <th>店铺地址</th>
                            <th>入驻时间</th>
                            <th>到期时间</th>
                            <th>审核状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['ams_id'];?>
">
                                <td><img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['ams_logo'];?>
" alt="" style="width: 60px"/></td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['m_show_id'];?>
</td>                               
                                <td style="max-width: 150px;word-break: break-all;white-space: normal;"><?php echo $_smarty_tpl->tpl_vars['val']->value['ams_name'];?>
</td>
                                <!--
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['ams_mobile'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['ams_contacts'];?>
</td>
                                -->
                                <td><?php echo $_smarty_tpl->tpl_vars['cate']->value[$_smarty_tpl->tpl_vars['val']->value['ams_cate_id']];?>
</td>
                                <!--
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['ams_open_time'];?>
-<?php echo $_smarty_tpl->tpl_vars['val']->value['ams_close_time'];?>
</td>
                                -->
                                <td style="max-width: 150px;word-break: break-all;white-space: normal;"><?php echo $_smarty_tpl->tpl_vars['val']->value['ams_address'];?>
</td>
                                <!--<td style="color: <?php if ($_smarty_tpl->tpl_vars['val']->value['ams_status']==1) {?>red<?php } else { ?>green<?php }?>"><?php echo $_smarty_tpl->tpl_vars['status']->value[$_smarty_tpl->tpl_vars['val']->value['ams_status']];?>
</td>-->
                                <td><?php if ($_smarty_tpl->tpl_vars['val']->value['ams_create_time']>0) {?><?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['val']->value['ams_create_time']);?>
<?php }?></td>
                                <td><?php if ($_smarty_tpl->tpl_vars['val']->value['ams_expire_time']>0) {?><?php echo date('Y-m-d',$_smarty_tpl->tpl_vars['val']->value['ams_expire_time']);?>
<?php }?></td>
                                <td>
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['ams_status']==1) {?>
                                     <span style="">待审核</span>
                                    <?php } elseif ($_smarty_tpl->tpl_vars['val']->value['ams_status']==2) {?>
                                    <span style="color: green">已通过</span>
                                    <?php } else { ?>
                                    <span style="color: red">已拒绝</span>
                                    <?php }?>
                                </td>
                                <td class="jg-line-color">
                                    <p>
                                        <a class="confirm-handle" href="#" data-toggle="modal" data-target="#handleModal"  data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['ams_id'];?>
">审核</a>
                                         - <a href="/wxapp/mobile/shopEdit/?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['ams_id'];?>
">详情</a>
                                        <?php if ($_smarty_tpl->tpl_vars['val']->value['ams_status']==2) {?>
                                        <!-- 只有通过才可以延长时间 -->
                                         - <a class="change-expire" href="#" data-toggle="modal" data-target="#myModal"  data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['ams_id'];?>
" data-expire="<?php echo $_smarty_tpl->tpl_vars['val']->value['ams_expire_time'];?>
">延长时间</a>
                                        <?php }?>
                                         - <a href="/wxapp/mobile/shopPayRecord/?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['ams_id'];?>
">付费记录</a>
                                    </p>
                                    <p>
                                        <a href="#" class="set-membergrade" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['ams_id'];?>
" >绑定会员</a>
                                        <?php if (!$_smarty_tpl->tpl_vars['val']->value['ams_m_id']) {?>
                                         - <a href="/wxapp/mobile/claimList/?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['ams_id'];?>
">申请人列表</a>
                                        <?php }?>
                                         - <a href="#" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['ams_id'];?>
" onclick="confirmDelete(this)" style="color:red;">删除</a>
                                    </p>
                                </td>
                            </tr>
                            <?php } ?>
                        <tr><td colspan="14"><?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>
</td></tr>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 350px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <input type="hidden" id="now_expire" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    延长到期时间
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div style="margin: auto">
                        <div class="col-sm-3 inline-div" style="text-align: right">延长</div>
                        <div class="col-sm-6">
                            <input type="number" name="expire" id="expire" placeholder="请填写整数" class="form-control" >
                        </div>
                        <div class="col-sm-3 inline-div" style="text-align: left">个月</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="change-expire">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<div class="modal fade" id="handleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id_handle" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    申请处理
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">审核状态：</label>
                    <div class="col-sm-10">
                        <select name="status" id="status" class="form-control">
                            <option value="2">通过</option>
                            <option value="3">拒绝</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">处理备注：</label>
                    <div class="col-sm-10">
                        <textarea id="market" class="form-control" rows="5" placeholder="请填写处理备注信息" style="height:auto!important"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-handle">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<div class="modal fade" id="excelModal" tabindex="-1" role="dialog" aria-labelledby="excelModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    导出
                </h4>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" action="/wxapp/mobile/shopExcel" method="post">
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">分类：</label>
                        <div class="col-sm-8">
                            <select name="category_excel" id="" class="form-control">
                                <option value="0">全部</option>
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categorySelect']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">状态：</label>
                        <div class="col-sm-8">
                            <select name="status_excel" id="" class="form-control">
                                <option value="0">全部</option>
                                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['statusNote']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div style="margin: 0 auto;text-align: center">
                        <button type="button" class="btn btn-normal" data-dismiss="modal" style="margin-right: 30px">取消</button>
                        <button type="submit" class="btn btn-primary" role="button">导出</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<?php echo $_smarty_tpl->getSubTemplate ("../../manage/common-kind-editor.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script type="text/javascript" charset="utf-8" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" charset="utf-8" src="/public/manage/assets/js/bootstrap-select.js"></script>

<script>
    function confirmDelete(ele) {
        var id = $(ele).data('id');
        layer.confirm('确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
           if(id){
	            var loading = layer.load(2);
	            $.ajax({
	                'type'  : 'post',
	                'url'   : '/wxapp/mobile/deleteShop',
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

    $('.change-expire').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#now_expire').val($(this).data('expire'));
    });

    $('#change-expire').on('click',function(){
        var hid = $('#hid_id').val();
        var expire = $('#expire').val();
        var now_expire = $('#now_expire').val();
        if(!expire){
            layer.msg('请填写延长时间');
            return false;
        }

        var data = {
            id : hid,
            expire : expire,
            now_expire : now_expire
        };
        if(hid){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/mobile/changeExpire',
                'data'  : data,
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

    $(function(){
        /*多选列表*/
        $(".chosen-select").chosen({
            no_results_text: "没有找到",
            search_contains: true,
            max_selected_options:1
        });

        $('.js-save').on('click',function(){
            var amsId = $('#hid_amsId').val();
            var mid = $("#multi-choose").find(".choose-txt").find('.delete').data('id');
            if(!mid){
                layer.msg('请选择会员');
                return;
            }

            var data = {
                'id' : amsId,
                'mid': mid
            };
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/mobile/changeBelong',
                'data'  : data,
                'dataType' : 'json',
                'success'  : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
//                        optshide();
                        window.location.reload();
                    }
                }
            });

        });
    });
    $("#content-con").on('click',function () {
        optshide();
    });

    $("#content-con").on('click', 'table td a.set-membergrade', function(event) {
        var id = $(this).data('id');
        $('#hid_amsId').val(id);
        optshide();
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-106;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        $("#m_nickname").css('display','inline-block');
        $(".ui-popover.ui-popover-select").css({'left':left-conLeft-450,'top':top-conTop-145}).stop().show();
    });
    /*隐藏设置会员弹出框*/
    function optshide(){
        //隐藏
        $('.ui-popover').stop().hide();
        //清空已选择
        $("#multi-choose").find(".choose-txt").each(function () {
           $(this).remove();
        });
    }

    $('.confirm-handle').on('click',function () {
        $('#hid_id_handle').val($(this).data('id'));
    });

    $('#confirm-handle').on('click',function(){
        var hid = $('#hid_id_handle').val();
        var market = $('#market').val();
        var status = $('#status').val();
        var data = {
            id : hid,
            market : market,
            status: status
        };
        if(hid){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/mobile/handleApply',
                'data'  : data,
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
</script>
<?php }} ?>
