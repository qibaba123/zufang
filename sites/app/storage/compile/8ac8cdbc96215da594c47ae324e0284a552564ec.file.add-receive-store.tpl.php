<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 10:52:58
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/delivery/add-receive-store.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12590311105e4df48adf7222-18271119%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8ac8cdbc96215da594c47ae324e0284a552564ec' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/delivery/add-receive-store.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12590311105e4df48adf7222-18271119',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'row' => 0,
    'isReceive' => 0,
    'category_select' => 0,
    'val' => 0,
    'showManager' => 0,
    'isPoint' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4df48ae84329_20558822',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df48ae84329_20558822')) {function content_5e4df48ae84329_20558822($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<style type="text/css">
    #default-onoff input[name=is_default].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "是 \a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0否";
    }
    #default-onoff input[type=checkbox].ace.ace-switch{
        margin:0;
        width: 60px;
        height: 30px;
    }
    #default-onoff input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before,#default-onoff input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before{
        line-height: 30px;
        height: 31px;
        width: 60px;
    }
    #default-onoff input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after,#default-onoff input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after{
        left: 30px;
    }
    #default-onoff input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after,#default-onoff input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after {
        width: 29px;
        height: 29px;
        line-height: 29px;
    }
    #container {
        width:100%;
        height: 300px;
    }
    .marker-route{
        width: 120px;
        height: 50px;
        background-color: #fff;
        font-size: 14px;
    }
    .week-choose{
        font-size: 0;
    }
    .week-choose span{
        display: inline-block;
        width: 13%;
        margin:0 0.64%;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        border:1px solid #E2E2E2;
        font-size: 12px;
        text-align: center;
        color: #777;
        line-height: 34px;
        cursor: pointer;
        max-width: 50px;
    }
    .week-choose span.active{
        border-color: #3DC018;
        position: relative;
    }
    .week-choose span.active:before{
        position: absolute;
        content: '';
        top:0;
        right: 0;
        z-index: 1;
        background: url(/public/manage/images/active.png) no-repeat;
        background-size: 14px;
        background-position: top right;
        width: 14px;
        height: 14px;
    }
</style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu-new.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("../article-kind-editor.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div  ng-app="ShopIndex"  ng-controller="ShopInfoController" style="margin-left: 130px">
    <div class="row">
        <div class="col-sm-12">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-header widget-header-blue widget-header-flat">
                            <h4 class="lighter"><small><a href="/wxapp/delivery/receiveCfg" >返回</a></small> | 新增/编辑门店信息</h4>

                        </div>
                        <div class="widget-body">
                            <div class="widget-main">
                                <form class="form-inline container" id="activity-form"  enctype="multipart/form-data">
                                    <input type="hidden" id="hid_id" name="id" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['os_id'];?>
<?php } else { ?>0<?php }?>">
                                    <input type="hidden" id="hid_isReceive" name="isReceive" value="<?php if ($_smarty_tpl->tpl_vars['isReceive']->value) {?><?php echo $_smarty_tpl->tpl_vars['isReceive']->value;?>
<?php } else { ?>0<?php }?>">
                                    <div style="overflow:hidden">
                                        <div class="row" style="margin-bottom: 10px">

                                            <div class="form-group col-sm-2 text-right">
                                                <label for="">店铺logo图<font color="red">*</font></label>
                                            </div>
                                            <div class="form-group col-sm-10" >
                                                <img onclick="toUpload(this)" data-limit="1" data-width="750" data-height="500"  data-dom-id="upload-logo" id="upload-logo"  src="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['os_logo']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['os_logo'];?>
<?php } else { ?>/public/manage/img/zhanwei/zw_fxb_45_45.png<?php }?>" style="display:inline-block;margin-left:0; width: 250px;height: 160px;">
                                                <input type="hidden" id="logo" placeholder="请上店铺logo"  class="avatar-field bg-img" name="logo" value="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['os_logo']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['os_logo'];?>
<?php }?>"/>
                                                <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="750" data-height="500" data-dom-id="upload-logo">修改</a>
                                            </div>

                                        </div>
                                        <div class="row" style="margin-bottom: 10px">

                                            <div class="form-group col-sm-2 text-right">
                                                <label for="">店铺封面图片<font color="red">*</font></label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <img onclick="toUpload(this)" data-limit="1" data-width="750" data-height="400" data-dom-id="upload-cover" id="upload-cover"  src="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['os_cover']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['os_cover'];?>
<?php } else { ?>/public/manage/img/zhanwei/zw_fxb_75_36.png<?php }?>"  width="300" style="display:inline-block;margin-left:0;">
                                                <input type="hidden" id="cover" placeholder="请上传店铺封面图"  class="avatar-field bg-img" name="cover" value="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['os_cover']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['os_cover'];?>
<?php }?>"/>
                                                <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="750" data-height="400" data-dom-id="upload-cover">修改</a>
                                            </div>

                                        </div>
                                        <div class="space-6"></div>
                                        <?php if ($_smarty_tpl->tpl_vars['category_select']->value) {?>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="">店铺分类</label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <select id="category"  class="form-control">
                                                    <option value="0">无分类</option>

                                                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['category_select']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                                         <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['acc_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['os_category']==$_smarty_tpl->tpl_vars['val']->value['acc_id']) {?>selected="selected"<?php }?> ><?php echo $_smarty_tpl->tpl_vars['val']->value['acc_title'];?>
</option>
                                                        <?php } ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="space-6"></div>
                                        <?php } else { ?>
                                        <input type="hidden" value="0" id="category">
                                        <?php }?>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name"><font color="red">*</font>门店名称</label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <input type="text" class="form-control" id="name" name="name" placeholder="请填写门店名称" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['os_name'];?>
<?php }?>">
                                            </div>
                                        </div>

                                        <div class="space-6"></div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>门店地点</label>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <select class="form-control" id="province" name="province" onchange="changeWxappProvince()" placeholder="请选择省会">
                                                    <option value="">选择省会</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <select class="form-control" id="city" name="city" onchange="changeWxappCity()" placeholder="请选择城市">
                                                    <option value="">选择城市</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <select class="form-control" id="zone" name="zone" placeholder="请选择地区">
                                                    <option value="">选择地区</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="space-6"></div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>详细地址</label>
                                            </div>

                                            <div class="form-group col-sm-8">
                                                <input type="text" class="form-control" id="addr" name="addr" placeholder="请填写详细地址" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['os_addr'];?>
<?php }?>">
                                            </div>

                                            <div class="form-group col-sm-2 text-left">
                                                <input type="hidden" id="lng" name="lng" placeholder="请在地图中标注分店位置" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['os_lng'];?>
<?php }?>">
                                                <input type="hidden" id="lat" name="lat" placeholder="请在地图中标注分店位置" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['os_lat'];?>
<?php }?>">
                                                <label class="btn btn-default btn-sm btn-map-search"> 搜索地图 </label>
                                            </div>
                                        </div>

                                        <div class="space-6"></div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>地图定位</label>
                                            </div>
                                            <div class="form-group col-sm-9">
                                                <div id="container"></div>
                                            </div>

                                        </div>

                                        <div class="space-6"></div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>联系方式</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="text" class="form-control" id="contact" name="contact" placeholder="请填写联系方式" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['os_contact'];?>
<?php }?>">
                                            </div>
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>是否是总店</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="" id="default-onoff">
                                                    <input class="ace ace-switch ace-switch-5" id="is_head" name="is_head" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['os_is_head']==1) {?>checked<?php }?>  type="checkbox">
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="space-6"></div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>接待时间</label>
                                            </div>
                                            <div class="form-group col-sm-4" style="padding:0">
                                                <div class="col-xs-5 bootstrap-timepicker">
                                                    <input type="text" class="form-control col-xs-5" id="open_time" name="open_time" placeholder="请选择接待开始时间" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['os_open_time'];?>
<?php } else { ?>08:30<?php }?>">
                                                </div>
                                                <span class="col-xs-2 text-center" style="line-height:34px">~</span>
                                                <div class="col-xs-5 bootstrap-timepicker">
                                                    <input type="text" class="form-control col-xs-5" id="close_time" name="close_time" placeholder="请选择接待结束时间" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['os_close_time'];?>
<?php } else { ?>17:30<?php }?>">
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-6 week-choose">
                                                <span data-week="1" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['os_week_1']==1) {?>class="active"<?php }?>>周一</span>
                                                <span data-week="2" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['os_week_2']==1) {?>class="active"<?php }?>>周二</span>
                                                <span data-week="3" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['os_week_3']==1) {?>class="active"<?php }?>>周三</span>
                                                <span data-week="4" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['os_week_4']==1) {?>class="active"<?php }?>>周四</span>
                                                <span data-week="5" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['os_week_5']==1) {?>class="active"<?php }?>>周五</span>
                                                <span data-week="6" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['os_week_6']==1) {?>class="active"<?php }?>>周六</span>
                                                <span data-week="7" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['os_week_7']==1) {?>class="active"<?php }?>>周日</span>
                                            </div>
                                        </div>
                                        <div class="space-6"></div>
                                        <?php if ($_smarty_tpl->tpl_vars['showManager']->value==1) {?>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name">管理员账号</label>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <input type="text" class="form-control" id="manager_mobile" name="manager_mobile" placeholder="请填写管理员账号" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['os_manager_mobile'];?>
<?php }?>">
                                            </div>
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name">管理员密码
                                                    <?php if ($_smarty_tpl->tpl_vars['row']->value&&!$_smarty_tpl->tpl_vars['row']->value['os_manager_password']) {?>
                                                    <span style="color: red">(未设置)</span>
                                                    <?php } elseif ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['os_manager_password']) {?>
                                                    <span style="color: green">(已设置)</span>
                                                    <?php }?>
                                                </label>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <input type="password" autocomplete="off" class="form-control" id="manager_password" name="manager_password" placeholder="管理员密码" value="">
                                            </div>
                                            <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['os_id']) {?>
                                                <span style="color: #888;font-size: 12px">不填则为不修改</span>
                                            <?php }?>
                                            <!--
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name">确认密码</label>
                                            </div>
                                            <div class="form-group col-sm-2">
                                                <input type="text" class="form-control" id="confirm_password" name="confirm_password" placeholder="确认管理员密码" value="">
                                            </div>
                                            -->
                                        </div>
                                        <div class="space-6"></div>
                                        <?php }?>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="">店铺详情<font color="red">*</font></label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <textarea class="form-control" style="width:100%;height:700px;visibility:hidden;" id = "detail" name="aptitude" placeholder="请填写资质信息"  rows="20" style=" text-align: left; resize:vertical;" >
                                                    <?php echo $_smarty_tpl->tpl_vars['row']->value['os_detail'];?>

                                                </textarea>
                                                <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                                                <input type="hidden" name="ke_textarea_name" value="aptitude" />
                                            </div>
                                        </div>
                                        <div class="space-8"></div>

                                        <div class="form-group col-sm-12" style="text-align:center">
                                            <span type="button" class="btn btn-primary btn-sm btn-save "> 保 存 </span>
                                        </div>
                                        <div class="space-8"></div>
                                    </div>
                                </form>
                            </div><!-- /widget-main -->
                        </div><!-- /widget-body -->
                    </div>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
</div><!-- PAGE CONTENT ENDS -->
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>
<script type="text/javascript" src="/public/common/js/province-city-area.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/wxapp/cake/js/store.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
    $(function(){
        /*选择接待开始时间*/
        $('#open_time').timepicker({
            minuteStep: 1,
            showSeconds: false,
            showMeridian: false
        }).next().on(ace.click_event, function(){
            $(this).prev().focus();
        });
        /*选择接待结束时间*/
        $('#close_time').timepicker({
            minuteStep: 1,
            showSeconds: false,
            showMeridian: false
        }).next().on(ace.click_event, function(){
            $(this).prev().focus();
        });
        /*选择周几*/
        $(".week-choose").on('click', 'span', function(event) {
            $(this).toggleClass('active');
        });

        //初始化省、市、区
        var id = $('#hid_id').val();
        if(id){
            initWxappRegion(1,'province','<?php echo $_smarty_tpl->tpl_vars['row']->value['os_province'];?>
');
            initWxappRegion('<?php echo $_smarty_tpl->tpl_vars['row']->value['os_province'];?>
','city','<?php echo $_smarty_tpl->tpl_vars['row']->value['os_city'];?>
');
            initWxappRegion('<?php echo $_smarty_tpl->tpl_vars['row']->value['os_city'];?>
','zone','<?php echo $_smarty_tpl->tpl_vars['row']->value['os_zone'];?>
');
        }else{
            initWxappRegion(1,'province');
        }
        //$("#province").find("option[text='河南']").attr("selected",true);
        $('#province option[text="河南"]').attr("selected", true);
        console.log($("#province").find("option[text='河南']"));
        //高德地图引入
        var marker, geocoder,map = new AMap.Map('container',{
            zoom            : 10,
            keyboardEnable  : true,
            resizeEnable    : true,
            topWhenClick    : true
        });
        //添加地图控件
        AMap.plugin(['AMap.ToolBar'],function(){
            var toolBar = new AMap.ToolBar();
            map.addControl(toolBar);
        });

        //地图添加点击事件
        map.on('click', function(e) {
            $('#lng').val(e.lnglat.getLng());
            $('#lat').val(e.lnglat.getLat());
            //添加地图服务
            AMap.service('AMap.Geocoder',function(){
                //实例化Geocoder
                geocoder = new AMap.Geocoder({
                    city: "010"//城市，默认：“全国”
                });
                //TODO: 使用geocoder 对象完成相关功能
                //逆地理编码
                var lnglatXY=[e.lnglat.getLng(), e.lnglat.getLat()];//地图上所标点的坐标
                geocoder.getAddress(lnglatXY, function(status, result) {
                    console.log(result);
                    if (status === 'complete' && result.info === 'OK') {
                        addMarker(e.lnglat.getLng(), e.lnglat.getLat(),result.regeocode.formattedAddress);

                        //详细地址处理
                        var pcz  = {
                            'province'  : result.regeocode.addressComponent.province,
                            'city'      : result.regeocode.addressComponent.city,
                            'zone'      : result.regeocode.addressComponent.district
                        };
                        initRegionByName(pcz);
                        var township    =  result.regeocode.addressComponent.township;
                        var street      =  result.regeocode.addressComponent.street;
                        var streetNumber=  result.regeocode.addressComponent.streetNumber;
                        var neighborhood=  result.regeocode.addressComponent.neighborhood;
                        var adds = township + street + streetNumber + neighborhood;
                        $('#addr').val(adds);
                    }else{
                        //获取地址失败
                    }
                });
            });
        });
        //搜索地图位置
        $('.btn-map-search').on('click',function(){
            var province = $('#province').find('option:selected').text();
            var city     = $('#city').find('option:selected').text();
            var zone     = $('#zone').find('option:selected').text();
            var addr     = $('#addr').val();
            if(province && city && zone && addr){
                var address = city + '市' + zone + addr;
                console.log(address);
                AMap.service('AMap.Geocoder',function(){ //回调函数
                    //实例化Geocoder
                    geocoder = new AMap.Geocoder({
                        'city'   : city, //城市，默认：“全国”
                        'radius' : 1000   //范围，默认：500
                    });
                    //TODO: 使用geocoder 对象完成相关功能
                    //地理编码,返回地理编码结果
                    geocoder.getLocation(address, function(status, result) {
                        console.log(result);
                        if (status === 'complete' && result.info === 'OK') {
                            var loc_lng_lat = result.geocodes[0].location;
                            $('#lng').val(loc_lng_lat.getLng());
                            $('#lat').val(loc_lng_lat.getLat());
                            addMarker(loc_lng_lat.getLng(),loc_lng_lat.getLat(),result.geocodes[0].formattedAddress);
                        }else{
                            layer.msg('您输入的地址无法找到，请确认后再次输入');
                        }
                    });
                });

            }else{
                layer.msg('请填写门店地址和详细地址');
            }
        });


        /**
         * 添加一个标签和一个结构体
         * @param lng
         * @param lat
         * @param address
         */
        function addMarker(lng,lat,address) {
            if (marker) {
                marker.setMap();
            }
            marker = new AMap.Marker({
                icon    : "https://webapi.amap.com/theme/v1.3/markers/n/mark_b.png",
                position: [lng,lat]
            });
            marker.setMap(map);

            infoWindow = new AMap.InfoWindow({
                offset  : new AMap.Pixel(0,-30),
                content : '您选中的位置：'+address
            });
            infoWindow.open(map, [lng,lat]);
        }

    });


    $('.btn-save').on('click',function(){
        savePickStore();
    });

    function savePickStore(){
    var is_head  = $('#is_head:checked').val();
    var data = {};
    var check = new Array('name','province','city','zone','addr','contact','lng','lat','open_time','close_time','logo','cover','detail');
    for(var i=0 ; i < check.length; i++){
        var temp = $('#'+check[i]).val();
        if(temp){
            data[check[i]] = temp;
        }else{
            var msg = $('#'+check[i]).attr('placeholder');
            layer.msg(msg);
            return false;
        }
    }
    data.category = $('#category').val();
    data.is_head = is_head == 'on' ? 1 : 0 ;
    data.id      = $('#hid_id').val();
    data.receive_store  = $('#hid_isReceive').val();
    data.manager_mobile = $('#manager_mobile').val();
    data.manager_password = $('#manager_password').val();
    data = getWeek(data);
    var index    = layer.load(1, {
        shade: [0.1,'#fff'] //0.1透明度的白色背景
    });
    $.ajax({
        'type'   : 'post',
        'url'   : '/wxapp/cake/saveStore',
        'data'  : data,
        'dataType'  : 'json',
        'success'   : function(ret){
            layer.close(index);
            if(ret.ec == 200){
                if('<?php echo $_smarty_tpl->tpl_vars['isPoint']->value;?>
' == '1'){
                    window.location.href='/wxapp/community/receiveCfg';
                }else{
                    window.location.href='/wxapp/delivery/receiveCfg';
                }

            }else{
                layer.msg(ret.em);
            }
        }
    });
}
</script>
<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php }} ?>
