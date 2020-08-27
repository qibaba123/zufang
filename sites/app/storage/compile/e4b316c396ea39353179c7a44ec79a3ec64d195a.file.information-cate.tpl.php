<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 10:45:05
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/currency/information-cate.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15336854075e4df2b1b8a5c5-16393421%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e4b316c396ea39353179c7a44ec79a3ec64d195a' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/currency/information-cate.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15336854075e4df2b1b8a5c5-16393421',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'appletCfg' => 0,
    'curr_shop' => 0,
    'categoryListSelect' => 0,
    'val' => 0,
    'key' => 0,
    'categoryList' => 0,
    'applet_cfg' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4df2b1bc9ec5_84982870',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df2b1bc9ec5_84982870')) {function content_5e4df2b1bc9ec5_84982870($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/wxapp/enterprise/service/index.css">
<link rel="stylesheet" href="/public/wxapp/enterprise/service/style.css">
<style>
    .add-servicefl{
        display: inline-block;
        vertical-align: middle;
    }
    .add-servicefl>div{
        display: inline-block;
        vertical-align: middle;
    }
    .add-servicefl .fl-input{
        margin-left: 10px;
        display: none;
    }
    .add-servicefl .fl-input .form-control{
        display: inline-block;
        vertical-align: middle;
        width: 150px;
    }
    .add-servicefl .fl-input .btn{
        display: inline-block;
        vertical-align: middle;;
    }
    .servicefl-wrap{
        margin-bottom: 10px;
    }
    .servicefl-wrap h4{
        font-size: 16px;
        font-weight: bold;;
        margin:0;
        line-height: 2;
        margin-bottom: 5px;
    }
    .servicefl-wrap .fl-item{
        display: inline-block;
        margin-right: 6px;
        margin-bottom: 6px;
        background-color: #f5f5f5;
        border: 1px solid #dfdfdf;
        border-radius: 3px;
        padding: 0 10px;
        height: 35px;
        line-height: 33px;
        position: relative;
        padding-right: 30px;
    }
    .servicefl-wrap .fl-item .delete-fl{
        position: absolute;
        height: 20px;
        width: 20px;
        top: 6px;
        right: 3px;
        font-size: 18px;
        color: #666;
        text-align: center;
        z-index: 1;
        line-height: 20px;
        cursor: pointer;
    }
    .article-circle-img {
        width: 50px;
        height: 50px;
        border-radius: 25px;
        background-color: #eee;
        margin-left: 0;
    }
    .gzh-middle-content {
        display: flex;
        flex-direction: column;
    }
    .introduce-article-content, .introduce-content {
        overflow: hidden;
        text-overflow: ellipsis;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .article-add-img {
        width: 20px;
        height: 20px;
        margin-left: 20px;
        cursor: pointer;
    }

    #search-content{
        font-size: 12px;
    }

    #search-content .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
    }

    .middle-div {
        border-bottom: 1px solid #e5e5e5;
        width: 590px!important;
    }

    #search-content td {
        min-width: 66px;
        font-size: 12px;
        line-height: 20px!important;
        vertical-align: middle!important;
        padding-top: 11px!important;
        padding-bottom: 11px!important;
        border-color: #e5e5e5!important;
    }

    .introduce-content {
        width: 400px;
    }
    .input-hidden{
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
    }

    .cus-input { padding: 7px 8px; font-size: 14px; border: 1px solid #ddd; -webkit-border-radius: 4px; -moz-border-radius: 4px; -ms-border-radius: 4px; -o-border-radius: 4px; border-radius: 4px; width: 100%; -webkit-transition: box-shadow 0.5s; -moz-transition: box-shadow 0.5s; -ms-transition: box-shadow 0.5s; -o-transition: box-shadow 0.5s; transition: box-shadow 0.5s; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; -o-box-sizing: border-box; box-sizing: border-box; min-height: 34px; resize: none; font-size: 14px;}
    .classify-wrap .classify-title { font-size: 16px; font-weight: bold; line-height: 2;padding: 10px 0; }
    .classify-wrap .classify-preiview-page { width: 320px; padding: 0 20px 20px; border: 1px solid #dfdfdf; -webkit-border-radius: 10px 10px 0 0; -moz-border-radius: 10px 10px 0 0; -ms-border-radius: 10px 10px 0 0; -o-border-radius: 10px 10px 0 0; border-radius: 10px 10px 0 0; background-color: #fff; box-sizing: content-box; float: left; }
    .classify-preiview-page .mobile-head { padding: 12px 0; text-align: center}
    .classify-preiview-page .mobile-con { border: 1px solid #dfdfdf; min-height: 150px; background-color: #f5f6f7; }
    .classify-preiview-page .mobile-nav { position: relative; }
    .classify-preiview-page .mobile-nav img { width: 100%; }
    .classify-preiview-page .mobile-nav p { line-height: 44px; height: 44px; position: absolute; width: 100%; top: 20px; left: 0; font-size: 15px; text-align: center; }
    .classify-preiview-page .classify-name { display: table; background-color: #fff; }
    .classify-preiview-page .classify-name span { display: table-cell; width: 1000px; text-align: center; height: 45px; line-height: 45px; }
    .classify-wrap .right-classify-manage { margin-left: 370px; min-height: 210px; }
    .right-classify-manage .manage-title{font-weight: bold;padding: 10px 10px 5px;}
    .right-classify-manage .manage-title span{font-size: 13px;color: #999;font-weight: normal;}
    .right-classify-manage .add-classify{padding: 0 10px;}
    .right-classify-manage .add-classify .add-btn{height: 30px;line-height: 30px; padding: 0 10px;background-color: #06BF04;border-radius: 4px;font-size: 14px;display: inline-block;cursor: pointer;border:1px solid #00AB00;color: #fff;}
    .classify-name-con { font-size: 0; padding: 10px;}
    .noclassify{font-size: 15px;color: #999;}
    .classify-name-con .classify-name { border: 1px solid #ddd; border-radius: 4px; padding: 5px 10px; position: relative; display: inline-block; font-size: 14px; margin-right: 10px; margin-bottom: 10px; background-color: #f5f6f7; cursor: move;}
    .right-classify-manage .classify-name .cus-input{display: inline-block;width: 150px;}
    .classify-name-con .classify-name .del-btn { display:inline-block;height: 34px; line-height: 34px; font-size: 20px; width: 25px; cursor: pointer; text-align: center; color: #666; vertical-align: middle;}
    .classify-name-con .classify-name .del-btn:hover { color: #333; }
    #search-pager span{
        width: 25px;
        display: inline-block;
        height: 25px;
        text-align: center;
        line-height: 25px;
        color: #333;
        cursor: pointer;
        outline: 0;
        text-decoration: none;
        background: #ccc;
        border-radius: 4px;
        margin: 5px;
        margin-bottom: 15px;
    }

    #search-pager .active{
        background: #fff;
        font-weight: bold;
        color: #00a06a;
    }

    .el-col{
        margin: 30px 10px 55px;
        border: 1px solid rgb(209, 219, 229);
        padding: 25px;
        border-radius: 4px;
        height: 150px;
        box-shadow: 0 2px 4px 0 rgba(0,0,0,.12), 0 0 6px 0 rgba(0,0,0,.04);
    }

    .el-button{
        font-size: 12px;
        width: 60px;
        color: #fff;
        border-radius: 4px;
        background-color: #010406;
        border-color: #010406;
    }

    .style_1 .news-item { padding: 10px 10px; background-color: #fff; margin-top: 8px; }
    .style_1 .news-item .title { font-size: 16px; line-height: 1.6; display: block; margin-bottom: 2px; font-weight: bold; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
    .style_1 .news-item img { width: 100%; height: 167px; display: block; margin-bottom: 7px; }
    .style_1 .news-item .intro { font-size: 14px; color: #999; display: block; display: -webkit-box !important; overflow: hidden; text-overflow: ellipsis; word-break: break-all; -webkit-box-orient: vertical; -webkit-line-clamp: 2; }
    .style_1 .news-item.border-b:after { height: 0; }

    /* 列表样式2 */
    .news-list.style_2 { padding-top: 8px; }
    .style_2 .news-item { padding: 0; background-color: #fff; overflow: hidden; }
    .style_2 .news-item img { width: 50%; height: 89px; }
    .style_2 .news-item .news-intro { width: 50%; height:89px; box-sizing: border-box; padding: 7px 10px; }
    .style_2 .news-item:nth-of-type(2n+1) img { float: left; }
    .style_2 .news-item:nth-of-type(2n+1) .news-intro { float: right; }
    .style_2 .news-item:nth-of-type(2n) img { float: right; }
    .style_2 .news-item:nth-of-type(2n) .news-intro { float: left; }
    .style_2 .news-item .news-intro .title { font-size: 16px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; text-align: center; margin-bottom: 2px; line-height: 1.6; font-weight: bold; }
    .style_2 .news-item .news-intro .intro { font-size: 14px; color: #999; display: -webkit-box !important; overflow: hidden; text-overflow: ellipsis; word-break: break-all; -webkit-box-orient: vertical; -webkit-line-clamp: 3; }
    .style_2 .news-item.border-b:after { height: 0; }

    /* 列表样式3 */
    .news-list.style_3 { padding-top: 8px; }
    .style_3 .news-item { padding: 8px 10px; background-color: #fff; overflow: hidden; }
    .style_3 .news-item img { width: 25%; height: 50px; float: left; }
    .style_3 .news-item .news-intro { width: 75%; height: 50px; box-sizing: border-box; padding: 3px 10px; float: left; }
    .style_3 .news-item .news-intro .title { font-size: 15px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; text-align: left; line-height: 1.6; font-weight: bold; }
    .style_3 .news-item .news-intro .intro { font-size: 14px; color: #999; display: -webkit-box !important; overflow: hidden; text-overflow: ellipsis; word-break: break-all; -webkit-box-orient: vertical; -webkit-line-clamp: 1; }

    /* 列表样式4 */
    .news-list.style_4 { padding-top: 8px; }
    .style_4 .news-item { padding: 8px 10px; background-color: #fff; overflow: hidden; }
    .style_4 .news-item img { width: 25%; height: 50px; float: right; }
    .style_4 .news-item .news-intro { width: 75%; height: 50px; box-sizing: border-box; padding: 3px 10px; float: left; }
    .style_4 .news-item .news-intro .title { font-size: 15px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; text-align: left; line-height: 1.6; font-weight: bold; }
    .style_4 .news-item .news-intro .intro { font-size: 14px; color: #999; display: -webkit-box !important; overflow: hidden; text-overflow: ellipsis; word-break: break-all; -webkit-box-orient: vertical; -webkit-line-clamp: 1; }
    .radio-box span img{width: 50px;margin-left: 22px;}
    .style_5 .putong,.style_1 .xinxiliu,.style_2 .xinxiliu,.style_3 .xinxiliu,.style_4 .xinxiliu{display: none;}
    .style_5 .xinxiliu,.style_1 .putong,.style_2 .putong,.style_3 .putong,.style_4 .putong{display: block;}
        /*信息流样式*/
    .news-item .single-img,.news-item .three-img,.news-item .video-box{padding:10px;background-color: #fff;overflow: hidden;}
    .news-item .single-img img{ width: 25%;height: 56px;float: right; }
    .news-item .single-img .news-intro{width: 72%;float: left;height: 56px;}
    .news-item .three-img img{ width: 25%;height: 56px;float: right; }
    .news-item .three-img .img-box{width: 100%;overflow: hidden;text-align: center;font-size: 0;}
    .news-item .three-img .img-box img{width: 28%;margin:0 2%;height: 60px;}
    .news-item .video-box .img-box{width: 100%;position: relative;}
    .news-item .video-box .img-box img{width:100%;height: 180px;display: block;}
    .news-item .video-box .play-btn{position: absolute;width: 44px;height: 44px;left: 50%;top:50%;margin-top: -22px;margin-left: -22px;border-radius: 50%;background-color: rgba(0,0,0,.4);box-sizing: border-box;padding: 7px 0 0 4px;}
    .news-item .video-box .play-btn img{width: 30px;height: 30px;display: block;margin: auto;}
</style>

    <style>
        input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { content: "已启用\a0\a0\a0\a0\a0未启用" !important; }
input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { content: "\a0\a0禁用\a0\a0\a0\a0\a0\a0\a0启用" !important; }
input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { background-color: #666666; border: 1px solid #666666; }
input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { background-color: #333333; border: 1px solid #333333; }
input[type=checkbox].ace.ace-switch { width: 90px; height: 30px; margin: 0; }
input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { line-height: 30px; height: 31px; overflow: hidden; border-radius: 18px; width: 89px; font-size: 13px; }
input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::before { background-color: #44BB00; border-color: #44BB00; }
input[type=checkbox].ace.ace-switch.ace-switch-4:hover:checked:hover+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked:hover+.lbl::before { background-color: #DD0000; border-color: #DD0000; }
input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after { width: 28px; height: 28px; line-height: 28px; border-radius: 50%; top: 1px; }
input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after { left: 59px; top: 1px }


    </style>

<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu-new.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div id="content-con">
    <div  id="mainContent">
        <div class="page-header">
            <!--
            <a href="/wxapp/currency/informationStyle" class="btn btn-green btn-xs" style="padding-top: 2px;padding-bottom: 2px;">样式设置</a>
            -->
            <a href="/wxapp/currency/informationSlide" class="btn btn-green btn-xs" style="padding-top: 2px;padding-bottom: 2px;">幻灯图管理</a>
            <a class="btn btn-primary btn-xs page-link-show" style="padding-top: 2px;padding-bottom: 2px;" data-toggle="modal" data-target="#pageLinkModal" >分类链接</a>
            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=32&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=36&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=33&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=34) {?>
            <span style="margin-left: 40px">
                    是否启用打赏:
                    <label id="choose-onoff" class="choose-onoff">
                        <input class="ace ace-switch ace-switch-5" id="rewardOpen"  data-type="open" onchange="changeOpen()" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['curr_shop']->value&&$_smarty_tpl->tpl_vars['curr_shop']->value['s_information_reward']) {?>checked<?php }?>>
                        <span class="lbl"></span>
                    </label>
                </span>
            <?php }?>
        </div><!-- /.page-header -->
        <div class="classify-wrap" ng-app="classifyApp" ng-controller="classifyCtrl">
            <div class="classify-title">
                <span class="page-title">当前分类</span>
            </div>
            <div class="classify-con" style="overflow: hidden;margin-bottom: 20px;">
                <div class="classify-preiview-page">
                    <div class="mobile-head">
                        <img src="/public/wxapp/images/iphone_head.png" alt="头部">
                    </div>
                    <div class="mobile-con">
                        <div class="mobile-nav">
                            <img src="/public/wxapp/images/title-bar.jpg" alt="导航">
                            <p>分类预览</p>
                        </div>
                        <div class="classify-name">
                            <span class="noclassify" ng-if="classifyList.length<=0">暂未添加任何分类~</span>
                            <span ng-repeat="classify in classifyList" ng-if="$index<4">{{classify.name}}</span>
                        </div>
                        <!-- 主体内容部分 -->
                        <div class="index-con">
                            <!-- 首页主题内容 -->
                            <div class="index-main" style="background-color: #f6f7f8;">
                                <div class="news-list style_{{listStyle}}">
                                    <div class="putong">
                                        <div class="news-item border-b">
                                            <img src="/public/manage/img/zhanwei/zw_fxb_750_422.png" />
                                            <div class="news-intro">
                                                <div class="title">文章标题</div>
                                                <div class="intro">文章相关简介</div>
                                            </div>
                                        </div>
                                        <div class="news-item border-b">
                                            <img src="/public/manage/img/zhanwei/zw_fxb_750_422.png" />
                                            <div class="news-intro">
                                                <div class="title">文章标题</div>
                                                <div class="intro">文章相关简介</div>
                                            </div>
                                        </div>
                                        <div class="news-item border-b">
                                            <img src="/public/manage/img/zhanwei/zw_fxb_750_422.png" />
                                            <div class="news-intro">
                                                <div class="title">文章标题</div>
                                                <div class="intro">文章相关简介</div>
                                            </div>
                                        </div>
                                        <div class="news-item border-b">
                                            <img src="/public/manage/img/zhanwei/zw_fxb_750_422.png" />
                                            <div class="news-intro">
                                                <div class="title">文章标题</div>
                                                <div class="intro">文章相关简介</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="xinxiliu">
                                        <div class="news-item border-b">
                                            <div class="single-img">
                                                <img src="/public/manage/img/zhanwei/zw_fxb_750_422.png" />
                                                <div class="news-intro">
                                                    <div class="title">文章标题内容</div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="news-item border-b">
                                            <div class="three-img">
                                                <div class="title">文章标题内容</div>
                                                <div class="img-box">
                                                    <img src="/public/manage/img/zhanwei/zw_fxb_750_422.png" />
                                                    <img src="/public/manage/img/zhanwei/zw_fxb_750_422.png" />
                                                    <img src="/public/manage/img/zhanwei/zw_fxb_750_422.png" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="news-item border-b">
                                            <div class="video-box">
                                                <div class="title">文章标题内容</div>
                                                <div class="img-box">
                                                    <div class="play-btn"><img src="/public/wxapp/images/icon_bf.png" alt="图标"></div>
                                                    <img src="/public/manage/img/zhanwei/zw_fxb_750_422.png" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="goods-show">
                        <div class="goods-view{{listStyle}}">
                            <ul>
                                <li>
                                    <a href="javascript:;">
                                        <img src="/public/manage/img/zhanwei/fenleinav.png" alt="商品">
                                        <div class="intro">
                                            <h4>此处显示资讯名称</h4>
                                            <p>此处显示资讯简介</p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <img src="/public/manage/img/zhanwei/fenleinav.png" alt="商品">
                                        <div class="intro">
                                            <h4>此处显示产品或服务名称</h4>
                                            <p>此处显示资讯简介</p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <img src="/public/manage/img/zhanwei/fenleinav.png" alt="商品">
                                        <div class="intro">
                                            <h4>此处显示产品或服务名称</h4>
                                            <p>此处显示资讯简介</p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <img src="/public/manage/img/zhanwei/fenleinav.png" alt="商品">
                                        <div class="intro">
                                            <h4>此处显示产品或服务名称</h4>
                                            <p>此处显示资讯简介</p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right-classify-manage">
                    <div class="manage-title">管理分类<span>(左边预览默认显示4个，其它不做显示，手机端可横向滑动，拖动分类可以进行排序)</span></div>
                    <div class="add-classify">

                        <span class="add-btn" ng-click="addClassify()" style="background-color: #2a6496;border: 1px solid #2a6496">添加分类</span>
                        <!--
                        <span class="add-btn" ng-click="saveCategory()">保存分类</span>
                        -->
                    </div>
                    <div class="classify-name-con" ui-sortable ng-model="classifyList">
                        <div class="classify-name" ng-repeat="classify in classifyList">
                            <input type="text" ng-model="classify.name" class="cus-input" maxlength="10" placeholder="请输入分类名称">
                            <span class="del-btn" ng-click="delIndex('classifyList',classify.index)">×</span>
                        </div>
                    </div>
                </div>
                <div class="edit-right" style="margin-left: 375px;">
                <div class="edit-con" style="width: 60%;margin-top: 50px;">
                    <div class="service-style">
                        <label>资讯列表展示样式</label>
                        <div class="radio-box">
						<span ng-click="changeStyle($event)">
							<input type="radio" name="goods-show" data-styleid="1" id="showstyle1" ng-checked="{{listStyle==1?true:false}}">
							<label for="showstyle1">上图下文</label>
                            <img src="/public/wxapp/images/style_1.png" />
						</span>
                            <span ng-click="changeStyle($event)">
							<input type="radio" name="goods-show" data-styleid="2" id="showstyle2" ng-checked="{{listStyle==2?true:false}}">
							<label for="showstyle2">一左一右</label>
                            <img src="/public/wxapp/images/style_2.png" />
						</span>
                            <span ng-click="changeStyle($event)">
							<input type="radio" name="goods-show" data-styleid="3" id="showstyle3" ng-checked="{{listStyle==3?true:false}}">
							<label for="showstyle3">左图右文</label>
                            <img src="/public/wxapp/images/style_3.png" />
						</span>
                            <span ng-click="changeStyle($event)">
							<input type="radio" name="goods-show" data-styleid="4" id="showstyle4" ng-checked="{{listStyle==4?true:false}}">
							<label for="showstyle4">左文右图</label>
                            <img src="/public/wxapp/images/style_4.png" />
						</span>
                            <span ng-click="changeStyle($event)">
							<input type="radio" name="goods-show" data-styleid="5" id="showstyle5" ng-checked="{{listStyle==5?true:false}}">
							<label for="showstyle5">高级版（信息流）</label>
                            <img src="/public/wxapp/images/style_5.png" />
						</span>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="alert alert-warning save-btn-box" role="alert"><button class="btn btn-blue btn-sm" ng-click="saveAll()">  保 存

            </div>
        <!-- PAGE CONTENT ENDS -->

            <div class="modal fade" id="pageLinkModal" tabindex="-1" role="dialog" aria-labelledby="pageLinkModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="width: 1100px;">
                    <div class="modal-content" style="padding: 20px">
                        <div class="table-responsive">
                            <table id="sample-table-1" class="table table-hover">
                                <thead>
                                <tr>
                                    <th>名称</th>
                                    <th>链接</th>
                                    <th>操作</th>
                                </tr>
                                </thead>

                                <tbody>
                                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['categoryListSelect']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                    <tr >
                                        <td><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['val']->value['page'];?>
</td>
                                        <input class="input-hidden" type="text" id="copy<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['page'];?>
">
                                        <td>
                                            <button type="button"  class="btn btn-xs btn-green copy-button" data-clipboard-action="copy"  data-clipboard-target="#copy<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">
                                                复制链接
                                            </button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->

                    </div><!-- /.modal-content -->
                </div><!-- /.modal -->
            </div>

    </div>
</div>



<script src="/public/plugin/layui/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script src="/public/plugin/sortable/sortable.js"></script>
<script src="/public/plugin/ZeroClip/clipboard.min.js"></script>
<script>
    $(function () {
        // 定义一个新的复制对象
        var clipboard = new ClipboardJS('.copy-button');
        // 复制内容到剪贴板成功后的操作
        clipboard.on('success', function(e) {
            console.log(e);
            layer.msg('复制成功');
        });
        clipboard.on('error', function(e) {
            console.log(e);
            console.log('复制失败');
        });
    });


    // 分类相关
    var app = angular.module('classifyApp', ['RootModule',"ui.sortable"]);
    app.controller('classifyCtrl',['$scope','$http','$timeout',function($scope,$http,$timeout){
        $scope.classifyList = <?php echo $_smarty_tpl->tpl_vars['categoryList']->value;?>
;
        $scope.listStyle = <?php echo $_smarty_tpl->tpl_vars['applet_cfg']->value['ac_information_style'];?>
;
        console.log($scope.listStyle);
        $scope.addClassify = function(){
            var classify_length = $scope.classifyList.length;
            var defaultIndex = 0;
            if(classify_length>0){
                for (var i=0;i<classify_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.classifyList[i].index)){
                        defaultIndex = $scope.classifyList[i].index;
                    }
                }
                defaultIndex++;
            }
            if(classify_length>=15){
                layer.msg('最多只能添加15个分类');
            }else{
                var classify_Default = {
                    id: 0,
                    index: defaultIndex,
                    name: '分类名称'
                };
                $scope.classifyList.push(classify_Default);
                $scope.inpurClassify = '';
            }
            console.log($scope.classifyList);
        };
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
        /*删除元素*/
        $scope.delIndex=function(type,index){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            realIndex = $scope.getRealIndex($scope[type],index);
            console.log(type+"-->"+realIndex);

            layer.confirm('您确定要删除吗？删除后该分类下的信息将不再显示', {
                title:'删除提示',
                btn: ['确定','取消']
            }, function(){
                $scope.$apply(function(){
                    $scope[type].splice(realIndex,1);
                });
                layer.msg('删除成功');
                $scope.saveCategory();
            });
        };
        $scope.changeStyle=function($event){
            $event.preventDefault();
            var that =$($event.target).parents('span').find('input:eq(0)');
            var value = that.data('styleid');
            that.get(0).checked = true;
            $scope.listStyle = value;
            console.log($scope.listStyle);
        };

        // 保存分类数据
        $scope.saveCategory = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });

            var data = {
                'categoryList'  : $scope.classifyList
            };
            console.log(data);
            $http({
                method: 'POST',
                url:    '/wxapp/currency/saveCategory',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
        };

        /*
        同时保存分类和列表样式
         */
        $scope.saveAll = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });

            var data = {
                'categoryList'  : $scope.classifyList,
                'styleId' : $scope.listStyle
            };
            console.log(data);
            $http({
                method: 'POST',
                url:    '/wxapp/currency/saveInformationAll',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
        };


    }]);

    function changeOpen() {
        var open   = $('#rewardOpen:checked').val();
        console.log(open);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/currency/saveShopReward',
            'data'  : { open:open == 'on' ? 1 : 0},
            'dataType'  : 'json',
            'success'   : function(ret){
                console.log(ret.em);
            }
        });
    }


</script>

<?php }} ?>
