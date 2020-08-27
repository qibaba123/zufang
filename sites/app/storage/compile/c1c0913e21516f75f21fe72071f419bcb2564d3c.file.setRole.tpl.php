<?php /* Smarty version Smarty-3.1.17, created on 2020-04-03 13:55:47
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/manager/setRole.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13260910305e86cfe34983b2-03994397%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c1c0913e21516f75f21fe72071f419bcb2564d3c' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/manager/setRole.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13260910305e86cfe34983b2-03994397',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'group' => 0,
    'menu_arr' => 0,
    'menu' => 0,
    'app_power' => 0,
    'app_menu_arr' => 0,
    'app_menu' => 0,
    'id' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e86cfe34d2962_36237196',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e86cfe34d2962_36237196')) {function content_5e86cfe34d2962_36237196($_smarty_tpl) {?><link rel="StyleSheet" href="/public/dtree/dtree.css" type="text/css" />
<script type="text/javascript" src="/public/dtree/dtree.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<style>
    .power-box{
        display: flex;
        flex-direction: row;
        align-items: flex-start;
    }
    .app_dtree{
        padding-top: 50px;
        margin-left: 50px;
    }
</style>

<div class="row power-box">
    <div class="dtree power-content">
        <h3><?php echo $_smarty_tpl->tpl_vars['group']->value;?>
</h3>
        <p><a href="javascript:  d.closeAll();">展开全部</a> | <a href="javascript: d.openAll();">收起全部</a></p>

        <script type="text/javascript">
            <!--
            d = new dTree('d');
            // d.add(0,-1,'权限设置');
            d.add(0,-1,'子管理员权限设置');
            <?php  $_smarty_tpl->tpl_vars['menu'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['menu']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menu_arr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['menu']->key => $_smarty_tpl->tpl_vars['menu']->value) {
$_smarty_tpl->tpl_vars['menu']->_loop = true;
?>
            d.add(<?php echo $_smarty_tpl->tpl_vars['menu']->value['id'];?>
,<?php echo $_smarty_tpl->tpl_vars['menu']->value['fid'];?>
,'authority','<?php echo $_smarty_tpl->tpl_vars['menu']->value['key'];?>
','<?php echo $_smarty_tpl->tpl_vars['menu']->value['name'];?>
',<?php echo $_smarty_tpl->tpl_vars['menu']->value['select'];?>
);
            <?php } ?>
            document.write(d);
            d.openAll();
            //-->
        </script>

    </div>


    <div class="app_dtree power-content" <?php if (!$_smarty_tpl->tpl_vars['app_power']->value) {?>style="display: none"<?php }?>>
        <p></p>
        <script type="text/javascript">
            app = new dTree('app');
            // d.add(0,-1,'权限设置');
            app.add(0,-1,'子管理员App权限设置');
            <?php  $_smarty_tpl->tpl_vars['app_menu'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['app_menu']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['app_menu_arr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['app_menu']->key => $_smarty_tpl->tpl_vars['app_menu']->value) {
$_smarty_tpl->tpl_vars['app_menu']->_loop = true;
?>
            app.add(<?php echo $_smarty_tpl->tpl_vars['app_menu']->value['id'];?>
,0,'app_authority','<?php echo $_smarty_tpl->tpl_vars['app_menu']->value['key'];?>
','<?php echo $_smarty_tpl->tpl_vars['app_menu']->value['name'];?>
',<?php echo $_smarty_tpl->tpl_vars['app_menu']->value['select'];?>
);
            <?php } ?>
            document.write(app);
        </script>
    </div>


</div>
<button type="button"  data-button class="btn btn-success btn-sm" data-add="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" style="margin-left: 30px;margin-top: 20px;">保存</button>
<style>
    .dtree {
        font-size: 16px;
        line-height: 2;
        margin-left: 20px;
    }
</style>
<script type="text/javascript">
    $("[data-button]").on('click',function(){
        var sel=[];
        $("input[name='authority']:checked").each(function() {
            sel.push($(this).val());
        });

        var app_sel=[];
        $("input[name='app_authority']:checked").each(function() {
            app_sel.push($(this).val());
        });

        var id = $(this).data('add');
        console.log(id);
        console.log(sel);
        console.log(app_sel);
        if(id){
            $.ajax({
                type: 'POST',
                url: "/wxapp/manager/saveSubManageRole",
                data: {id:id,sel:sel,app_sel:app_sel},
                dataType: 'json',
                success: function(ret){
                    if (ret.ec == 200) {
                        layer.msg(ret.em);
                        window.location.reload();
                    } else {
                        layer.msg(ret.em);
                    }
                }
            });
        }
    });
</script><?php }} ?>
