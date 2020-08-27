<?php /* Smarty version Smarty-3.1.17, created on 2019-12-06 17:08:42
         compiled from "/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/community/district.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14291307375dea1a9a4af716-17311005%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1c29ab63a42a610f76e47132224d32add6b24e19' => 
    array (
      0 => '/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/community/district.tpl',
      1 => 1575623319,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14291307375dea1a9a4af716-17311005',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'provSelect' => 0,
    'key' => 0,
    'zone' => 0,
    'val' => 0,
    'name' => 0,
    'list' => 0,
    'pagination' => 0,
    'searchProvince' => 0,
    'searchCity' => 0,
    'searchZone' => 0,
    'areaSelect' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5dea1a9a5097c4_18884132',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5dea1a9a5097c4_18884132')) {function content_5dea1a9a5097c4_18884132($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">

<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <a class="btn btn-green btn-xs" href="#" id="add-new" data-toggle="modal" data-target="#myModal"><i class="icon-plus bigger-80"></i>添加商圈</a>
        </div><!-- /.page-header -->
        <div class="page-header search-box">
            <div class="col-sm-12">
                <form action="/wxapp/community/district" method="get" class="form-inline">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon" style="height:34px;">省份</div>
                                    <select name="searchProvince" id="searchProvince" class="form-control" onchange="changeSearchWxappProvince()">
                                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['provSelect']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['key']->value==$_smarty_tpl->tpl_vars['zone']->value['parent_id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon" style="height:34px;">城市</div>
                                    <select name="searchCity" id="searchCity" class="form-control" onchange="changeSearchWxappCity()">

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon" style="height:34px;">区域</div>
                                    <select name="searchZone" id="searchZone" class="form-control">

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">商圈名称</div>
                                    <input type="text" class="form-control" name="name" value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" placeholder="商圈名称">
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
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>商圈名称</th>
                            <th>所属地区</th>
                            <th>排序</th>
                            <th>添加时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['acd_id'];?>
">
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['acd_name'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['acd_area_name'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['acd_sort'];?>
</td>
                                <td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['acd_create_time']);?>
</td>
                                <td class="jg-line-color">
                                    <a class="confirm-handle" href="#" data-toggle="modal" data-target="#myModal"  data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['acd_id'];?>
" data-prov="<?php echo $_smarty_tpl->tpl_vars['val']->value['acd_prov_id'];?>
" data-city="<?php echo $_smarty_tpl->tpl_vars['val']->value['acd_city_id'];?>
" data-area="<?php echo $_smarty_tpl->tpl_vars['val']->value['acd_area_id'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['val']->value['acd_name'];?>
" data-weight="<?php echo $_smarty_tpl->tpl_vars['val']->value['acd_sort'];?>
" >编辑</a>
                                     - <a data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['acd_id'];?>
" onclick="confirmDelete(this)" style="color:#f00;">删除</a>
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
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    添加商圈
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row" style="margin-top: 20px">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">商圈名称：</label>
                    <div class="col-sm-8">
                        <input id="district-name" class="form-control" placeholder="请填写商圈名称" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">所属区域：</label>
                    <div class="col-sm-2">
                        <select name="province" id="province" class="form-control" onchange="changeWxappProvince()">
                            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['provSelect']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['key']->value==$_smarty_tpl->tpl_vars['zone']->value['parent_id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select name="city" id="city" class="form-control" onchange="changeWxappCity()">

                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select name="zone" id="zone" class="form-control">

                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">商圈排序：</label>
                    <div class="col-sm-8">
                        <input id="district-weight" class="form-control" placeholder="数字越大，排序越靠后" style="height:auto!important"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-category">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script type="text/javascript" src="/public/common/js/province-city-area.js"></script>
<script>
    var province = '<?php echo $_smarty_tpl->tpl_vars['zone']->value['parent_id'];?>
';
    var city = '<?php echo $_smarty_tpl->tpl_vars['zone']->value['region_id'];?>
';

    var searchProvince = '<?php echo $_smarty_tpl->tpl_vars['searchProvince']->value;?>
';
    var searchCity = '<?php echo $_smarty_tpl->tpl_vars['searchCity']->value;?>
';
    var searchZone = '<?php echo $_smarty_tpl->tpl_vars['searchZone']->value;?>
';
    var areaSelect = <?php echo json_encode($_smarty_tpl->tpl_vars['areaSelect']->value);?>
;

    $(function(){
        initWxappRegion(province,'city',city);
        initWxappRegion(city,'zone','');

        initSearchWxappRegion(searchProvince,'searchCity',searchCity);
        initSearchWxappRegion(searchCity,'searchZone',searchZone);
    });

    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#district-name').val($(this).data('name'));
        $('#district-weight').val($(this).data('weight'));
        initWxappRegion($(this).data('prov'),'city',$(this).data('city'));
        initWxappRegion($(this).data('city'),'zone',$(this).data('area'));
    });

    $('#add-new').on('click',function () {
        $('#hid_id').val(0);
        $('#district-name').val('');
        $('#district-weight').val('');
        initWxappRegion(province,'city',city);
        initWxappRegion(city,'zone','');
    });

    $('#confirm-category').on('click',function(){
        var id     = $('#hid_id').val();
        var name   = $('#district-name').val();
        var weight = $('#district-weight').val();
        var area  = $('#zone').val();
        var province  = $('#province').val();
        var city  = $('#city').val();
        var data = {
            id     : id,
            name   : name,
            weight : weight,
            province : province,
            city : city,
            area  : area,
            areaName:areaSelect[area]
        };

        if(name){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/saveDistrict',
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

    function confirmDelete(ele) {
        var id = $(ele).data('id');
        if(id){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/deleteDistrict',
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
    }

    /**
     * 省会变更
     */
    function changeSearchWxappProvince(){
        var fid = $('#searchProvince').val();
        initSearchWxappRegion(fid ,'searchCity');
    }
    /**
     * 城市变更
     */
    function changeSearchWxappCity(){
        var fid = $('#searchCity').val();
        initSearchWxappRegion(fid ,'searchZone');
    }

    function initSearchWxappRegion(fid,selectId,df){
        if(fid > 0) {
            var data = {
                'fid': fid
            };
            $.ajax({
                'type'   : 'post',
                'url'   : '/wxapp/index/region',
                'data'  : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    if(ret.ec == 200){
                        region_search_html(ret.data,selectId,df);
                        if(!df){
                            if(selectId == 'searchProvince'){
                                initSearchWxappRegion(ret.data[0].region_id,'searchCity');
                            }
                            if(selectId == 'searchCity'){
                                initSearchWxappRegion(ret.data[0].region_id,'searchZone');
                            }
                        }
                    }
                }
            });
        }
    }

    /**
     * 展示区域省市区
     * @param data
     * @param selectId
     */
    function region_search_html(data,selectId,df){
        var option = '';
        for(var i=0 ; i < data.length ; i++){
            var temp  = data[i];
            var sel   = '';
            if(df && temp.region_id == df ){
                sel = 'selected';
            }
            option += '<option  value="'+temp.region_id+'" '+sel+'>'+temp.region_name+'</option>';
        }
        $('#'+selectId).html(option);
    }



</script><?php }} ?>
