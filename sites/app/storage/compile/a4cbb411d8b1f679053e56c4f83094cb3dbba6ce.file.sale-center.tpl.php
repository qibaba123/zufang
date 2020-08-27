<?php /* Smarty version Smarty-3.1.17, created on 2020-04-02 16:14:15
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/three/sale-center.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10948914325e859ed7c8d344-26256903%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a4cbb411d8b1f679053e56c4f83094cb3dbba6ce' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/three/sale-center.tpl',
      1 => 1575621713,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10948914325e859ed7c8d344-26256903',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'row' => 0,
    'cropper' => 0,
    'curr_shop' => 0,
    'appletCfg' => 0,
    'menuType' => 0,
    'noticeList' => 0,
    'articles' => 0,
    'information' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e859ed7d56805_30602277',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e859ed7d56805_30602277')) {function content_5e859ed7d56805_30602277($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/memberHome.css">
<link rel="stylesheet" href="/public/manage/colorPicker/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/train/temp1/css/style.css">
<script src="/public/manage/colorPicker/spectrum.js"></script>
<style>
    .table.table-avatar tbody>tr>td{
        line-height: 48px;
    }
    .myfund ul li p{
        color: <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cc_center_color']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_center_color'];?>
<?php } else { ?>#fff<?php }?>;
    }
    .member-info{
        box-shadow: 1px 1px 1px rgba(0,0,0,0.1);
        background: url(<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cc_center_bg']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_center_bg'];?>
<?php } else { ?>/public/manage/images/shk_02.png<?php }?>) no-repeat;
        background-size: 100% 100%;
        background-position: top center;
        background-color: #fff;
        color: #fff;
        margin-bottom: 8px;
    }
    input[type=checkbox].ace.ace-switch {
        height: 32px;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        line-height: 31px;
        height: 32px;
        overflow: hidden;
        border-radius: 18px;
        font-size: 12px;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::before {
        background-color: #44BB00;
        border-color: #44BB00;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after {
        width: 30px;
        height: 30px;
        line-height: 30px;
        border-radius: 50%;
        top: 1px;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after {
        top: 1px
    }
    #must_set input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "\a0\a0必须设置\a0\a0\a0\a0暂不设置";
    }
    #must_set input[type=checkbox].ace.ace-switch,#must_set input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        width: 105px;
    }
    #must_set input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after {
        left: 74px;
    }
    #show_refer input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "\a0\a0显示\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0隐藏";
    }
    #show_refer input[type=checkbox].ace.ace-switch,#show_refer input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        width: 85px;
    }
    #show_refer input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after {
        left: 54px;
    }
    .check-row span {
        width: 110px;
    }

</style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div  id="mainContent">
<div><?php echo $_smarty_tpl->tpl_vars['cropper']->value['modal'];?>
</div>
<div ng-app="CenterSetting"  ng-controller="Center" ng-init="
    title='<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cc_center_title']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_center_title'];?>
<?php } else { ?>会员中心<?php }?>';
    font_color='<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cc_center_color']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_center_color'];?>
<?php }?>';
    ">
    <div class="space-6" style="color: red;" ng-show="tip" ng-bind="tip"></div>
    <div class="row" >
        <div class="col-sm-12" style="position: relative;">
            <!-- 会员主页内容 -->
            <div class="member-content" style="padding-bottom: 60px;">
                <!-- 手机页面展示  -->
                <div class="mobile-page">
                    <div class="mobile-header"></div>
                    <div class="mobile-con">
                        <div class="title-bar"><h3 id="show_title">{{title}}</h3></div>
                        <div id="wrap" class="flex-wrap flex-vertical">
                            <div id="main" class="flex-con">
                                <!-- 用户基本信息 -->
                                <div class="member-info">
                                    <div class="base-info">
                                        <div class="left-touxiang"><img src="/public/manage/images/Avatar-sample-30@2x.png" alt="头像"></div>
                                        <div class="user-name">
                                            <p>用户昵称</p>
                                            <p>推荐人【<?php echo $_smarty_tpl->tpl_vars['curr_shop']->value['s_name'];?>
】</p>
                                            <p>关注时间：2016-7-31 15:32:15</p>
                                        </div>
                                    </div>
                                    <div class="myfund">
                                        <ul>
                                            <li>
                                                <p>销售额</p>
                                                <p>￥288.00</p>
                                            </li>
                                            <li>
                                                <p>总收入</p>
                                                <p>￥88.00</p>
                                            </li> 
                                            <li>
                                                <p>会员号</p>
                                                <p>12</p>
                                            </li> 
                                            <li>
                                                <p>邀请码</p>
                                                <p>48562</p>
                                            </li>         
                                        </ul>
                                    </div>
                                </div>
                                <!--新增公告内容-->
                               <!-- <div class="notice-box" data-left-preview data-id="4">
                                    <img src="/public/wxapp/train/images/home_notable.png" class="noticeicon" alt="图标">
                                    <div class="notice-txt">
                                        <p ng-if="noticeTxt.length<=0">最新公告内容</p>
                                        <p ng-repeat="notice in noticeTxt">{{notice.title}}</p>
                                    </div>
                                </div>-->
                                <ul class="user-operation">
                                    <li data-id="showhide10"><a href="javascript:;" class="icon9">{{listTxt.mynoticeTxt}}</a></li>
                                    <li class="mine" data-id="showhide1"><a href="javascript:;">{{listTxt.myuserTxt.firstTxt}}<span>0人</span></a>
                                        <ul class="zhanyou border-b">
                                            <?php if ($_smarty_tpl->tpl_vars['row']->value['tc_level']>=1) {?>
                                            <li class="border-b">
                                                <span style="float: left;margin-top:6px;font-size: 12px;color: darkgrey;">（1级）</span><a href="javascript:;">{{listTxt.myuserTxt.secondTxt.oneGradeTxt}}
                                                    <span>0人</span></a>
                                            </li>
                                            <?php }?><?php if ($_smarty_tpl->tpl_vars['row']->value['tc_level']>=2) {?>
                                            <li class="border-b">
                                                <span style="float: left;margin-top:6px;font-size: 12px;color: darkgrey;">（2级）</span>
                                                <a href="javascript:;">{{listTxt.myuserTxt.secondTxt.twoGradeTxt}}
                                                    <span>0人</span></a>
                                            </li>
                                            <?php }?><?php if ($_smarty_tpl->tpl_vars['row']->value['tc_level']>=3) {?>
                                            <li><span style="float: left;margin-top:6px;font-size: 12px;color: darkgrey;">（3级）</span>
                                                <a href="javascript:;">{{listTxt.myuserTxt.secondTxt.threeGradeTxt}}<span>0人</span></a>
                                            </li>
                                            <?php }?>
                                        </ul>
                                    </li>
                                    <li class="border-b" data-id="showhide2"><a href="javascript:;" class="icon1">{{listTxt.myshareTxt}}<span></span></a></li>
                                    <li class="border-b" data-id="showhide3"><a href="javascript:;" class="icon2">{{listTxt.mycashTxt}}<span></span></a></li>
                                    <li class="border-b" data-id="showhide12"><a href="javascript:;" class="icon12">{{listTxt.mybranchauditTxt}}<span></span></a></li>
                                    <li class="border-b" data-id="showhide4"><a href="javascript:;" class="icon3">{{listTxt.myorderTxt}}<span></span></a></li>
                                    <li class="border-b" data-id="showhide11"><a href="javascript:;" class="icon10">{{listTxt.goodsratioTxt}}<span></span></a></li>
                                </ul>
                                <ul class="user-operation">
                                    <li class="border-b" data-id="showhide5"><a href="javascript:;" class="icon4">{{listTxt.myreferTxt}}<span></span></a></li>
                                    <li class="border-b" data-id="showhide6"><a href="javascript:;" class="icon5">{{listTxt.myinfoTxt}}<span></span></a></li>
                                    <li class="border-b" data-id="showhide8"><a href="javascript:;" class="icon6">{{listTxt.mywithTxt}}<span></span></a></li>
                                </ul>
                                <ul class="user-operation">

                                    <li class="border-b" data-id="showhide7"><a href="javascript:;" class="icon7">{{listTxt.mycodeTxt}}<span class="red">快速</span></a></li>
                                    <li class="border-b" data-id="showhide9"><a href="javascript:;" class="icon8">{{listTxt.myrankTxt}}<span></span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="float: right;width:490px; position: relative;">
                    <!-- 会员信息封面修改 -->
                    <div class="member-cover member-infobg">
                        <div class="modify-info">

                            <div class="row">
                                <label class="col-sm-3" for="">背景图片:</label>
                                <div class="col-sm-9">
                                    <div class="col-sm-10 cropper-box" data-width="750" data-height="360" style="margin-left: -24px;">
                                        <img src="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cc_center_bg']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_center_bg'];?>
<?php } else { ?>/public/manage/img/zhanwei/zw_fxb_64_23.png<?php }?>" id="bg-img" width="150px" height="55px" style="display:inline-block;"><a href="javascript:void(0)" style="display: inline;color:blue;font-size:14px;vertical-align: bottom;position: relative;bottom: -8px; left:3px;">修改背景图</a>
                                        <p><small style="font-size: 12px;color:#999">建议尺寸：750*360</small></p>
                                        <input type="hidden" id="center_bg" class="avatar-field bg-img" name="center_bg" value="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cc_center_bg']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_center_bg'];?>
<?php } else { ?>/public/manage/images/shk_02.png<?php }?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--新增通知公告-->
                  
                    <div class="notice" data-right-edit data-id="4"   <?php if (!$_smarty_tpl->tpl_vars['row']->value['cc_mynotice_show']) {?> style="display:none;"
                     <?php }?>    id="noticeShow" >
                        <label>最新公告</label>
                        <div class="service-manage" ng-repeat="notice in noticeTxt">
                            <div class="delete" ng-click="delIndex('noticeTxt',notice.index)">×</div>
                            <div class="edit-txt">
                                <div class="input-groups">
                                    <label for="">标　题：</label>
                                    <input type="text" class="cus-input" ng-model="notice.title">
                                </div>
                                <div class="input-groups">
                                    <label for="">链接到：</label>
                                    <select class="cus-input" ng-model="notice.articleId" ng-options="x.id as x.title for x in information"></select>
                                </div>
                            </div>
                        </div>
                        <div class="add-box" title="添加" ng-click="addNotice()"></div>
                    </div>




                    <!-- 底部链接地址 -->
                    <div class="member-cover link-address" style="position: relative;margin-top:30px;">
                        <div class="show-control">

                            <div class="check-row">
                                <span for="">广播:</span>
                                <div class="check-box">
                                    <p>
                                        <input type="checkbox" id="mynotice" data-id="showhide10" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cc_mynotice_show']==1) {?>checked<?php }?>>
                                        <label for="mynotice">显示</label>
                                    </p>
                                    <p class="text"><input type="text" class="form-control" ng-model="listTxt.mynoticeTxt"></p>
                                </div>
                            </div>


                            <!--结束-->

                            <div class="check-row">
                                <span>我的会员:</span>
                                <div class="check-box">
                                    <p>
                                        <input type="checkbox" id="member" data-id="showhide1" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cc_myuser_show']==1) {?>checked<?php }?>>
                                        <label for="member">显示</label>
                                    </p>
                                    <p class="text">
                                        <input type="text" class="form-control" ng-model="listTxt.myuserTxt.firstTxt">
                                        <?php if ($_smarty_tpl->tpl_vars['row']->value['tc_level']>=1) {?>
                                        <input type="text" class="form-control" placeholder="请填写1级会员" ng-model="listTxt.myuserTxt.secondTxt.oneGradeTxt">
                                        <?php }?><?php if ($_smarty_tpl->tpl_vars['row']->value['tc_level']>=2) {?>
                                        <input type="text" class="form-control" placeholder="请填写2级会员" ng-model="listTxt.myuserTxt.secondTxt.twoGradeTxt">
                                        <?php }?><?php if ($_smarty_tpl->tpl_vars['row']->value['tc_level']>=3) {?>
                                        <input type="text" class="form-control" placeholder="请填写3级会员" ng-model="listTxt.myuserTxt.secondTxt.threeGradeTxt">
                                        <?php }?>
                                    </p>
                                </div>
                            </div>

                            <div class="check-row">
                                <span for="">我的分享收入:</span>
                                <div class="check-box">
                                    <p>
                                        <input type="checkbox" id="myshare" data-id="showhide2" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cc_mynotice_show']==1) {?>checked<?php }?>>
                                        <label for="myshare">显示</label>
                                    </p>
                                    <p class="text"><input type="text" class="form-control" ng-model="listTxt.myshareTxt"></p>
                                </div>
                            </div>
                            <div class="check-row">
                                <span for="">我的返现收入:</span>
                                <div class="check-box">
                                    <p>
                                        <input type="checkbox" id="myfanxian" data-id="showhide3" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cc_mycash_show']==1) {?>checked<?php }?>>
                                        <label for="myfanxian">显示</label>
                                    </p>
                                    <p class="text"><input type="text" class="form-control" ng-model="listTxt.mycashTxt"></p>
                                </div>
                            </div>
                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21) {?>
                            <div class="check-row">
                                <span for="">下级分销商审核:</span>
                                <div class="check-box">
                                    <p>
                                        <input type="checkbox" id="mybranchaudit" data-id="showhide12" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cc_mybranch_audit_show']==1) {?>checked<?php }?>>
                                        <label for="mybranchaudit">显示</label>
                                    </p>
                                    <p class="text"><input type="text" class="form-control" ng-model="listTxt.mybranchauditTxt"></p>
                                </div>
                            </div>
                            <?php }?>
                            <div class="check-row">
                                <span for="">分销订单:</span>
                                <div class="check-box">
                                    <p>
                                        <input type="checkbox" id="fxorder" data-id="showhide4" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cc_myorder_show']==1) {?>checked<?php }?>>
                                        <label for="fxorder">显示</label>
                                    </p>
                                    <p class="text"><input type="text" class="form-control" ng-model="listTxt.myorderTxt"></p>
                                </div>
                            </div>
                            <div class="check-row">
                                <span for="">单品分销详情:</span>
                                <div class="check-box">
                                    <p>
                                        <input type="checkbox" id="goodsratio" data-id="showhide11" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cc_goodsratio_show']==1) {?>checked<?php }?>>
                                        <label for="goodsratio">显示</label>
                                    </p>
                                    <p class="text"><input type="text" class="form-control" ng-model="listTxt.goodsratioTxt"></p>
                                </div>
                            </div>
                            <div class="check-row">
                                <span for="">我的推荐人:</span>
                                <div class="check-box">
                                    <p>
                                        <input type="checkbox" id="tuijian" data-id="showhide5" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cc_myrefer_show']==1) {?>checked<?php }?>>
                                        <label for="tuijian">显示</label>
                                    </p>
                                    <p class="text"><input type="text" class="form-control" ng-model="listTxt.myreferTxt"></p>
                                </div>
                            </div>
                            <div class="check-row">
                                <span for="">我的资料:</span>
                                <div class="check-box">
                                    <p>
                                        <input type="checkbox" id="ziliao" data-id="showhide6" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cc_myinfo_show']==1) {?>checked<?php }?>>
                                        <label for="ziliao">显示</label>
                                    </p>
                                    <p class="text"><input type="text" class="form-control" ng-model="listTxt.myinfoTxt"></p>
                                </div>
                            </div>
                            <div class="check-row" <?php if ($_smarty_tpl->tpl_vars['menuType']->value=='toutiao') {?>style="display: none" <?php }?>>
                                <span for="">我的二维码:</span>
                                <div class="check-box">
                                    <p>
                                        <input type="checkbox" id="mycode" data-id="showhide7" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cc_mycode_show']==1) {?>checked<?php }?>>
                                        <label for="mycode">显示</label>
                                    </p>
                                    <p class="text"><input type="text" class="form-control" ng-model="listTxt.mycodeTxt"></p>
                                </div>
                            </div>
                            <div class="check-row">
                                <span for="">申请提现:</span>
                                <div class="check-box">
                                    <p>
                                        <input type="checkbox" id="tixian" data-id="showhide8" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cc_mywith_show']==1) {?>checked<?php }?>>
                                        <label for="tixian">显示</label>
                                    </p>
                                    <p class="text"><input type="text" class="form-control" ng-model="listTxt.mywithTxt"></p>
                                </div>
                            </div>
                            <div class="check-row">
                                <span for="">销售排行榜:</span>
                                <div class="check-box">
                                    <p>
                                        <input type="checkbox" id="paihang" data-id="showhide9" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cc_myrank_show']==1) {?>checked<?php }?>>
                                        <label for="paihang">显示</label>
                                    </p>
                                    <p class="text"><input type="text" class="form-control" ng-model="listTxt.myrankTxt"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="alert alert-warning setting-save" role="alert" ><button class="btn btn-primary btn-sm" ng-click="saveSetting();">保存</button></div>
        </div>
    </div>
</div>
</div>
<script src="/public/manage/vendor/angular.min.js"></script>
<script src="/public/manage/vendor/angular-root.js"></script>
<script src="/public/wxapp/three/js/custom.js"></script>
<script src="/public/plugin/layer/layer.js"></script>
<script src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>

<script>
    var menuType = '<?php echo $_smarty_tpl->tpl_vars['menuType']->value;?>
';
    /*控制显示隐藏函数*/
    function showHide(elem){
            var dataId = $(elem).data('id');
            var isShow = $(elem).is(':checked');
            if(dataId =='showhide10'){
                if(isShow){
                   $('#noticeShow').css("display","block");
                }else{
                    $('#noticeShow').css("display","none");
                }
            }

            if(menuType == 'toutiao' && dataId == 'showhide7'){
                isShow = 0;
            }

            if(isShow){
                $(".user-operation").find('li[data-id='+dataId+']').css("display","block");
            }else{
                $(".user-operation").find('li[data-id='+dataId+']').css("display","none");
            }
    }
    $(function(){
        /*控制显示隐藏部分操作项*/
        $(".show-control").on('click', 'input[type=checkbox]', function(event) {
            showHide(this);
        });
        /*初始化显示隐藏部分*/
        $(".show-control").find('input[type=checkbox]').each(function() {
            showHide(this);
        });


        $('#bg-img').on('load',function(){
           var img = $(this).attr('src');
            $('.member-info').css('background','url('+img+') no-repeat center top / 100% 100%');
            //$('.member-info').css('background-size','100% 100%');
        });

        $("#colorpicker").spectrum({
            color: "<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cc_center_color']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_center_color'];?>
<?php } else { ?>#fff<?php }?>",
            cancelText: "取消",
            chooseText: "选择",
            allowEmpty:true,
            showInput: true,
            containerClassName: "color-spectrum",
            showInitial: true,
            showPalette: true,
            showSelectionPalette: true,
            showAlpha: true,
            maxPaletteSize: 10,
            preferredFormat: "hex",
            move: function (color) {
                console.log(color.toHexString());
                $('.myfund ul li p').css('color',color.toHexString());
                $('#font_color').val(color.toHexString());
            },
            show: function () {

            },
            beforeShow: function () {

            },
            hide: function (color) {
                updateBorders(color);
            },

            palette: [
                ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)", /*"rgb(153, 153, 153)","rgb(183, 183, 183)",*/
                "rgb(204, 204, 204)", "rgb(217, 217, 217)", /*"rgb(239, 239, 239)", "rgb(243, 243, 243)",*/ "rgb(255, 255, 255)"],
                ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
                "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"],
                ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)",
                "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)",
                "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)",
                "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)",
                "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)",
                "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
                "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
                "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
                /*"rgb(133, 32, 12)", "rgb(153, 0, 0)", "rgb(180, 95, 6)", "rgb(191, 144, 0)", "rgb(56, 118, 29)",
                "rgb(19, 79, 92)", "rgb(17, 85, 204)", "rgb(11, 83, 148)", "rgb(53, 28, 117)", "rgb(116, 27, 71)",*/
                "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)",
                "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
            ]
        });
    });

    // 定义一个新的复制对象
    var clip = new ZeroClipboard( $('.copy_input'), {
        moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
    } );
    // 复制内容到剪贴板成功后的操作
    clip.on( 'complete', function(client, args) {
        console.log("复制成功的内容是："+args.text);
        layer.msg('复制成功');
    } );

    var member_login_module = angular.module('CenterSetting', ['RootModule']);

    member_login_module.controller('Center', ['$scope', '$http', function($scope, $http){

        $("input[name=level][value="+$scope.level+"]").attr("checked",true);
        /*是否店长推荐*/
        $(".levelChoose").on('click', 'input[type=radio]', function(event) {
            var val = $(this).parent("span").data("val");
            $scope.level = val;
            console.log($scope.level);
        });

        $scope.listTxt = {
            myuserTxt:{
                firstTxt:'<?php if ($_smarty_tpl->tpl_vars['row']->value['cc_myuser_name0']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_myuser_name0'];?>
<?php } else { ?>我的会员<?php }?>',
                secondTxt:{
                    oneGradeTxt:'<?php if ($_smarty_tpl->tpl_vars['row']->value['cc_myuser_name1']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_myuser_name1'];?>
<?php } else { ?>1级会员<?php }?>',
                    twoGradeTxt:'<?php if ($_smarty_tpl->tpl_vars['row']->value['cc_myuser_name2']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_myuser_name2'];?>
<?php } else { ?>2级会员<?php }?>',
                    threeGradeTxt:'<?php if ($_smarty_tpl->tpl_vars['row']->value['cc_myuser_name3']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_myuser_name3'];?>
<?php } else { ?>3级会员<?php }?>'
                }
            },
            myshareTxt  : '<?php if ($_smarty_tpl->tpl_vars['row']->value['cc_myshare_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_myshare_name'];?>
<?php } else { ?>我的分享收入<?php }?>',
            mycashTxt   : '<?php if ($_smarty_tpl->tpl_vars['row']->value['cc_mycash_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_mycash_name'];?>
<?php } else { ?>我的返现收入<?php }?>',
            mybranchauditTxt   : '<?php if ($_smarty_tpl->tpl_vars['row']->value['cc_mybranch_audit_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_mybranch_audit_name'];?>
<?php } else { ?>下级分销商审核<?php }?>',
            myorderTxt  : '<?php if ($_smarty_tpl->tpl_vars['row']->value['cc_myorder_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_myorder_name'];?>
<?php } else { ?>分销订单<?php }?>',
            myreferTxt  : '<?php if ($_smarty_tpl->tpl_vars['row']->value['cc_myrefer_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_myrefer_name'];?>
<?php } else { ?>我的推荐人<?php }?>',
            myinfoTxt   : '<?php if ($_smarty_tpl->tpl_vars['row']->value['cc_myinfo_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_myinfo_name'];?>
<?php } else { ?>我的资料<?php }?>',
            mywithTxt   : '<?php if ($_smarty_tpl->tpl_vars['row']->value['cc_mywith_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_mywith_name'];?>
<?php } else { ?>申请提现<?php }?>',
            mycodeTxt   : '<?php if ($_smarty_tpl->tpl_vars['row']->value['cc_mycode_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_mycode_name'];?>
<?php } else { ?>我的二维码<?php }?>',
            myrankTxt   : '<?php if ($_smarty_tpl->tpl_vars['row']->value['cc_myrank_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_myrank_name'];?>
<?php } else { ?>销售排行榜<?php }?>',
            //新增广播
            mynoticeTxt : '<?php if ($_smarty_tpl->tpl_vars['row']->value['cc_mynotice_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_mynotice_name'];?>
<?php } else { ?>广播<?php }?>',
            goodsratioTxt : '<?php if ($_smarty_tpl->tpl_vars['row']->value['cc_goodsratio_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_goodsratio_name'];?>
<?php } else { ?>单品分销列表<?php }?>',
        };
        $scope.noticeTxt = <?php echo $_smarty_tpl->tpl_vars['noticeList']->value;?>
;
        $scope.articles = <?php echo $_smarty_tpl->tpl_vars['articles']->value;?>
;
        $scope.information = <?php echo $_smarty_tpl->tpl_vars['information']->value;?>
;



        $scope.addNotice = function(){
            console.log(123);
            console.log($scope.noticeTxt.length);
            var notice_length = $scope.noticeTxt.length;
            var defaultIndex = 0;
            if(notice_length>0){
                for (var i=0;i<notice_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.noticeTxt[i].index)){
                        defaultIndex = parseInt($scope.noticeTxt[i].index);
                    }
                }
                defaultIndex++;
            }
            if(notice_length>=5){
                layer.msg("最多只能添加5条公告哦~");
            }else{
                var notice_Default = {
                    index: defaultIndex,
                    title: '默认公告标题',
                    articleTitle:$scope.articles.length>0?$scope.articles[0].name:'',
                    articleId:$scope.articles.length>0?$scope.articles[0].id:''
                };
                $scope.noticeTxt.push(notice_Default);
            }
            console.log($scope.noticeTxt);
        }
        /*获取真正索引*/
        $scope.getRealIndex = function(type,index){
            var resultIndex = -1;
            for(var i=0;i<type.length;i++){
                if(type[i].index==index){
                    resultIndex = i;
                    break;
                }
            }
            return resultIndex;
        };

        // 选择文章
        $scope.getSelectId = function(type,index,title,parentType){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            if(parentType){
                realIndex = $scope.getRealIndex($scope[parentType][type],index);
            }else{
                realIndex = $scope.getRealIndex($scope[type],index);
            }
            var information = $scope.information;
            var curId = '';
            for(var i = 0;i < information.length;i++){
                if(information[i].title == title){
                    curId = information[i].id;
                }
            }
            if(parentType){
                $scope[parentType][type][realIndex].articleId = curId;
            }else{
                $scope[type][realIndex].articleId = curId;
            }
        };


        /*删除元素*/
        $scope.delIndex=function(type,index,parentType){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            if(parentType){
                realIndex = $scope.getRealIndex($scope[parentType][type],index);
            }else{
                realIndex = $scope.getRealIndex($scope[type],index);
            }


            console.log(type+"-->"+realIndex);
            layer.confirm('您确定要删除吗？', {
                title:'删除提示',
                btn: ['确定','取消']
            }, function(){
                if(parentType){
                    $scope.$apply(function(){
                        $scope[parentType][type].splice(realIndex,1);
                    });
                }else{
                    $scope.$apply(function(){
                        $scope[type].splice(realIndex,1);
                    });
                }
                layer.msg('删除成功');
            });
            console.log($scope.appointInfo);
        }
        //设置提示
        $scope.tip  = false;
        $scope.saveSetting   = function() {
        	layer.confirm('确定要保存吗？', {
	            btn: ['确定','取消'] //按钮
	        }, function(){
	            var index = layer.load(1, {
	                shade: [0.1,'#fff'] //0.1透明度的白色背景
	            },{
	                time : 10*1000
	            });
	
	            var data = {
	                'center_bg' : $('#center_bg').val(),
	                'myuser'    : $('#member').is(":checked") ? 1 : 0,
	                'myshare'   : $('#myshare').is(":checked") ? 1 : 0,
	                'mycash'    : $('#myfanxian').is(":checked") ? 1 : 0,
	                'myorder'   : $('#fxorder').is(":checked") ? 1 : 0,
	                'myrefer'   : $('#tuijian').is(":checked") ? 1 : 0,
	                'myinfo'    : $('#ziliao').is(":checked") ? 1 : 0,
	                'mywith'    : $('#tixian').is(":checked") ? 1 : 0,
	                'mycode'    : $('#mycode').is(":checked") ? 1 : 0,
	                'myrank'    : $('#paihang').is(":checked") ? 1 : 0,
	                'mynotice'  : $('#mynotice').is(":checked")?1 :0,   //新增通知公告
	                'goodsratio'  : $('#goodsratio').is(":checked")?1 :0,   //单品分销详情
                    'mybranch_audit'  : $('#mybranchaudit').is(":checked")?1 :0,   //单品分销详情

	                'myuser_name0'   : $scope.listTxt.myuserTxt.firstTxt,
	                'myuser_name1'   : $scope.listTxt.myuserTxt.secondTxt.oneGradeTxt,
	                'myuser_name2'   : $scope.listTxt.myuserTxt.secondTxt.twoGradeTxt,
	                'myuser_name3'   : $scope.listTxt.myuserTxt.secondTxt.threeGradeTxt,
	                'myshare_name'   : $scope.listTxt.myshareTxt,
	                'mycash_name'    : $scope.listTxt.mycashTxt,
	                'myorder_name'   : $scope.listTxt.myorderTxt,
	                'myrefer_name'   : $scope.listTxt.myreferTxt,
	                'myinfo_name'    : $scope.listTxt.myinfoTxt,
	                'mywith_name'    : $scope.listTxt.mywithTxt,
	                'mycode_name'    : $scope.listTxt.mycodeTxt,
	                'myrank_name'    : $scope.listTxt.myrankTxt,
                    'mybranch_audit_name'  : $scope.listTxt.mybranchauditTxt,
	                'mynotice_name'  : $scope.listTxt.mynoticeTxt,    //广播
	                'notice'         : $scope.noticeTxt,  //新增保存通知公告信息
	                'goodsratio_name'         : $scope.listTxt.goodsratioTxt,  //单品分销详情

	
	            };
	            $http({
	                method: 'POST',
	                url:    '/wxapp/three/saveCenter',
	                data:   data
	            }).then(function(response) {
	                layer.close(index);
	                layer.msg(response.data.em);
	            });
	        });
            
        };
    }]);


</script><?php }} ?>
