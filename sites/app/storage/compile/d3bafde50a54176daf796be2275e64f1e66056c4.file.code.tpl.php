<?php /* Smarty version Smarty-3.1.17, created on 2020-04-03 11:11:32
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/three/code.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9856595595e86a96464f063-94729930%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd3bafde50a54176daf796be2275e64f1e66056c4' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/three/code.tpl',
      1 => 1575621713,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9856595595e86a96464f063-94729930',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'row' => 0,
    'curr_shop' => 0,
    'cropper' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e86a9646a17c6_56934509',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e86a9646a17c6_56934509')) {function content_5e86a9646a17c6_56934509($_smarty_tpl) {?><link rel="stylesheet" href="/public/plugin/sortable/jquery-ui.min.css">
<style>
    .custom-code{
        width: 800px;
        margin:0 auto;
        overflow: hidden;
        padding-top: 20px;
    }
    .code-box{
        width: 320px;
        height: 464px;
        background: #fff url(<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cc_qrcode_bg']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_qrcode_bg'];?>
<?php } else { ?>/public/manage/three/images/code-bg.png<?php }?>) no-repeat center;
        background-size: 100% 100%;
        margin:0 auto;
        position: relative;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        float: left;
        border: 1px solid #eee;
    }
    .code-box .user-nameinfo{
        position: absolute;
        top:30px;
        left:30px;
        cursor: move;
    }
    .code-box .user-nameinfo:after{
        content:'';
        height: 100%;
        width: 100%;
        box-sizing: border-box;
        position: absolute;
        left: 0;
        top:0;
        border:2px dashed red;
        z-index: 1;
    }
    .code-box .user-nameinfo .avatar{
        width: 48px;
        height: 48px;
        overflow: hidden;
        -webkit-border-radius: 3px;
        border-radius: 3px;
        float: left;
        background-color: #fff;
    }
    .code-box .user-nameinfo .avatar img{
        width: 100%;
        min-height: 100%;
        display: block;
        margin: 0;
    }
    .code-box .user-nameinfo .name{
        float: left;
        padding-left: 10px;
        padding-right: 10px
    }
    .code-box .user-nameinfo .name h3{
        font-size: 14px;
        line-height: 2;
        font-weight: bold;
        margin: 0;
    }
    .code-box .user-nameinfo .name p{
        color: #999;
        margin:0;
    }
    .code-box .code{
        position: absolute;
        left:75px;
        top:150px;
        width: 106px;
        cursor: move;
        background-color: #fff;
    }
    .code-box .code:after{
        content:'';
        height: 100%;
        width: 100%;
        box-sizing: border-box;
        position: absolute;
        left: 0;
        top:0;
        border:2px dashed red;
        z-index: 1;
    }
    .code-box .code img{
        width: 100%;
        min-height: 100%;
        display: block;
        margin: 0;
    }
    .code-box .code p{
        color: #666;
        text-align: center;
    }
    .right-edit{
        float: left;
        width: 400px;
        padding-top: 30px;
        margin-left: 50px;
    }
    .right-edit>div{
        margin-bottom: 10px;
    }
    .right-edit label{
        display: block;
    }
    .erweima-bg .bg-box span{
        display: inline-block;
        vertical-align: bottom;
        color: #38f;
        margin-bottom: 3px;
        cursor: pointer;
    }
    .erweima-bg img{
        width: 135px;
        height: 196px;
        display: inline-block;
    }
    .pos-box .form-control{
        width: 300px;
    }
    .save-btn-box{
        padding:10px 0;
        margin-top: 30px;
    }
    .ui-resizable-e:after{
        content: '';
        height: 7px;
        width: 7px;
        box-sizing: border-box;
        position: absolute;
        left: -2px;
        top: 49%;
        border: 2px dashed red;
        z-index: 1;
        background: red;
    }

    .ui-resizable-s:before{
        content: '';
        height: 7px;
        width: 7px;
        box-sizing: border-box;
        position: absolute;
        left: 97%;
        top: -3px;
        border: 2px dashed red;
        z-index: 1;
        background: red;
    }

    .ui-resizable-s:after{
        content: '';
        height: 7px;
        width: 7px;
        box-sizing: border-box;
        position: absolute;
        left: 49%;
        top: -2px;
        border: 2px dashed red;
        z-index: 1;
        background: red;
    }
</style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div  id="mainContent">
    <div class="row">
        <div class="col-sm-12" style="max-width:1000px;margin-bottom: 20px;">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li>
                        <a href="/wxapp/three/index">
                            <i class="green icon-cog bigger-110"></i>
                            分销配置
                        </a>
                    </li>
                    <li class="active">
                        <a data-toggle="tab" href="#mycode">
                            <i class="green icon-qrcode bigger-110"></i>
                            微海报配置
                        </a>
                    </li>
                </ul>
                <div class="tab-content form-horizontal">
                    <!--我的二维码-->
                    <div id="mycode" class="tab-pane in active custom-code">
                        <div class="code-box" id="codeBox">
                                <?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_id']!=7163||$_smarty_tpl->tpl_vars['curr_shop']->value['s_id']!=7224) {?>
                            <div class="user-nameinfo" id="userInfo" style="left: <?php echo $_smarty_tpl->tpl_vars['row']->value['avatar_l'];?>
px;top: <?php echo $_smarty_tpl->tpl_vars['row']->value['avatar_t'];?>
px;">
                                <div class="avatar"><img src="/public/manage/three/images/tx-48.png" alt="头像"></div>
                                <div class="name">
                                    <h3>此处显示用户昵称</h3>
                                </div>
                            </div>
                                <div class="code" id="code" style="left: <?php echo $_smarty_tpl->tpl_vars['row']->value['code_l'];?>
px;top: <?php echo $_smarty_tpl->tpl_vars['row']->value['code_t'];?>
px;width: <?php echo $_smarty_tpl->tpl_vars['row']->value['cc_qrcode_size'];?>
px;">
                                <img src="/public/manage/three/images/code-212.png" alt="二维码">
                                </div>
                                <?php }?>
                        </div>
                        <div class="right-edit">
                            <div class="erweima-bg">
                                <label for="">背景图片</label>
                                <?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_id']==7163||$_smarty_tpl->tpl_vars['curr_shop']->value['s_id']==7224) {?>
                                <div class="bg-box cropper-box" data-width="640" data-height="758">
                                <?php } else { ?>
                                <div class="bg-box cropper-box" data-width="640" data-height="928">
                                <?php }?>
                                    <img src="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cc_qrcode_bg']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_qrcode_bg'];?>
<?php } else { ?>/public/manage/three/images/code-bg.png<?php }?>" class="img-thumbnail bg-img-reload"  alt="背景图片">
                                    <span>更换背景<small style="font-size: 12px;color:#999">建议比例：640*928</small></span>
                                    <input type="hidden" class="avatar-field" name="qrcode_bg" id="qrcode_bg" value="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cc_qrcode_bg']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_qrcode_bg'];?>
<?php } else { ?>/public/manage/three/images/code-bg.png<?php }?>"/>
                                </div>
                            </div>
                                <div class="pos-box">
                                    <label for="">头像信息坐标:</label>
                                    <input type="text" class="form-control" id="userInfoPos" value="<?php if ($_smarty_tpl->tpl_vars['row']->value['cc_avatar_loc']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_avatar_loc'];?>
<?php } else { ?>(30,30)<?php }?>" readonly>
                                </div>
                            <div class="pos-box">
                                <label for="">二维码坐标:</label>
                                <input type="text" class="form-control" id="codePos" value="<?php if ($_smarty_tpl->tpl_vars['row']->value['cc_qrcode_loc']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_qrcode_loc'];?>
<?php } else { ?>(75,150)<?php }?>" readonly>
                            </div>
                            <div class="save-btn-box">
                                <div class="btn btn-md btn-green btn-save">保存</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div><?php echo $_smarty_tpl->tpl_vars['cropper']->value['modal'];?>
</div>
<script type="text/javascript" src="/public/manage/three/js/drag-elem.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
    <script type="text/javascript" src="/public/plugin/sortable/jquery-ui.min.js"></script>
<script>
    window.onload = function (){
        dragElem('userInfo','codeBox',function(pos){
            console.log("用户信息当前坐标("+2*pos.x+","+2*pos.y+")");
            $("#userInfoPos").val("("+2*pos.x+","+2*pos.y+")");
        });
        dragElem('code','codeBox',function(pos){
            console.log("二维码当前坐标("+2*pos.x+","+2*pos.y+")");
            $("#codePos").val("("+2*pos.x+","+2*pos.y+")");
        });
        $( "#code" ).resizable({
            aspectRatio: 1
        });
    };

    $('.bg-img-reload').on('load',function(){
        console.log($(this).attr("src"));
        $('.code-box').css('background','url('+$(this).attr("src")+') no-repeat center top / 100% 100%');
    });

    $('.btn-save').on('click',function(){
    	layer.confirm('确定要保存吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            var data = {
                'userInfoPos'   : $('#userInfoPos').val(),
	            'codePos'       : $('#codePos').val(),
	            'codeBg'        : $('#qrcode_bg').val(),
                'codeSize'      : parseInt($('#code').css('width'))
	        };
	        console.log(data);
	        var index = layer.load(1, {
	            shade: [0.1,'#fff'] //0.1透明度的白色背景
	        });
	        $.ajax({
	            'type'  : 'post',
	            'url'   : '/wxapp/three/saveCode',
	            'data'  : data,
	            'dataType' : 'json',
	            'success'  : function(ret){
	                console.log(ret);
	                layer.close(index);
	                layer.msg(ret.em);
	            }
	        });
        });

    });
</script><?php }} ?>
