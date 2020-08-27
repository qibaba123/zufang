<?php /* Smarty version Smarty-3.1.17, created on 2020-04-01 18:39:13
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/tplmsg/wx-tpl.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1970855775e846f51c0c011-71241008%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ba0759e2435f80f80b2b17db0ca826b8ff5f09de' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/tplmsg/wx-tpl.tpl',
      1 => 1575621713,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1970855775e846f51c0c011-71241008',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'list' => 0,
    'val' => 0,
    'pageHtml' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e846f51c3e536_09568941',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e846f51c3e536_09568941')) {function content_5e846f51c3e536_09568941($_smarty_tpl) {?><style>
    .form-group-box{
        overflow: auto;
    }
    .form-group-box .form-group{
        width: 260px;
        margin-right: 10px;
        float: left;
    }
</style>
<div ng-app="Withdraw"  ng-controller="WithdrawList">
    <div class="alert alert-block alert-success">
        <ol>
            <li><small>模版消息，来自微信公众平台-小程序“<a href="javascritp:;" class="xxmb-bnt">查看位置</a>”里面的功能－模版消息，请至<a href="https://mp.weixin.qq.com/" target="_blank"> 微信公众平台 </a>添加更多模版消息</small></li>
            <li style="padding-top: 5px">
                <!--<small>模板消息教程：<a href="http://bbs.tiandiantong.net/forum.php?mod=viewthread&tid=361&extra=page%3D2" class="xxmb-bnt" target="_blank">http://bbs.tiandiantong.net/forum.php?mod=viewthread&tid=361&extra=page%3D2</a></small>-->
                <!--<small style="padding-left: 20px"><a href="http://bbs.tiandiantong.net/forum.php?mod=viewthread&tid=361&extra=page%3D2" style="color: red;" target="_blank">查看图文教程</a></small>-->
            </li>
        </ol>
    </div>
    <div class="page-header" style="overflow:hidden">
        <div class="col-sm-6">
            <a class="btn btn-green btn-sm refresh-btn" href="javascript:;">
                <i class="icon-refresh bigger-40"></i>  消息模版同步
            </a>
        </div>
        <div style="float: right;">
            <a class="btn btn-green btn-sm" href="/wxapp/tplmsg/tplmsgSetup" style="padding: 5px 20px;">
                消息发送设置
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="sample-table-1" class="table table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-480">模版ID</th>
                        <th>标题</th>
                        <th>操作</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                        <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['awt_tplid'];?>
">
                            <td><?php echo $_smarty_tpl->tpl_vars['val']->value['awt_tplid'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['val']->value['awt_title'];?>
</td>
                            <td class="jg-line-color">
                                <a href="/wxapp/tplmsg/tplmsgList/?tplid=<?php echo $_smarty_tpl->tpl_vars['val']->value['awt_tplid'];?>
">
                                    管理
                                </a>
                                 - <a href="javascript:;" class="deal-audit"
                                   data-title="<?php echo $_smarty_tpl->tpl_vars['val']->value['awt_title'];?>
"
                                   data-example='<?php echo $_smarty_tpl->tpl_vars['val']->value['awt_example'];?>
'
                                   data-industry2='<?php echo $_smarty_tpl->tpl_vars['val']->value['awt_industry2'];?>
'>
                                    示例
                                </a>
                                 - <a href="javascript:;" class="del-btn"
                                   data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['awt_tplid'];?>
" style="color:#f00;">
                                    删除
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if ($_smarty_tpl->tpl_vars['pageHtml']->value) {?>
                        <tr><td colspan="5"><?php echo $_smarty_tpl->tpl_vars['pageHtml']->value;?>
</td></tr>
                    <?php }?>
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
        </div><!-- /span -->
    </div><!-- /row -->
    <div id="withdraw-form"  class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">消息模版示例</h4>
                </div>
                <div class="modal-body">
                    <div style="padding: 20px">
                        <h4 id="h1Title"></h4>
                        <p><small>10-18</small><p>
                        <p id="example"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <span id="saveResult" ng-model="saveResult" class="text-center"></span>
                    <button type="button" class="btn btn-primary modal-save" >知道了</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>


<script type="text/javascript" src="/public/plugin/layer/layer.js" ></script>
<script type="text/javascript" src="/public/manage/controllers/withdraw-list.js" ></script>

<script type="text/javascript" language="javascript">
    $('.deal-audit').on('click',function(){
        $('#h1Title').text($(this).data('title'));
        $('#example').html($(this).data('example'));
        $('#withdraw-form').modal('show');
    });
    $('.modal-save').on('click',function(){
        $('#withdraw-form').modal('hide');
    })
    $('.xxmb-bnt').on('click',function(){
        layer.open({
            type: 1,
            title: false,
            closeBtn: 1,
            area: '516px',
            shadeClose: true,
            content: '<img src="/public/manage/img/helper/WX20171102-190708.png" width="500px">'
        });
    });
    $('.refresh-btn').on('click',function(){
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        },{time:10*1000});

        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/tplmsg/refreshTpl',
            'dataType'  : 'json',
            success : function(json_ret){
                layer.close(index);
                layer.msg(json_ret.em);

                if(json_ret.ec == 200){
                    window.location.reload();
                }
            }

        })
    });
    $('.del-btn').on('click',function(){
        var tplId = $(this).data('id');
    	layer.confirm('确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            var data = {
	            'tplId' : tplId
	        };
	        var index = layer.load(1, {
	            shade: [0.1,'#fff'] //0.1透明度的白色背景
	        },{time:10*1000});
	
	        $.ajax({
	            'type'  : 'post',
	            'url'   : '/wxapp/tplmsg/deleteTpl',
	            'data'  : data,
	            'dataType'  : 'json',
	            success : function(json_ret){
	                layer.close(index);
	                layer.msg(json_ret.em);
	
	                if(json_ret.ec == 200){
	                    $('#tr_'+data.tplId).hide();
	                }
	            }
	
	        })
        });

    });


</script>
<?php }} ?>
