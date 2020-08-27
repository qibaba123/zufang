<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
.add-servicefl { display: inline-block; vertical-align: middle; }
.add-servicefl>div { display: inline-block; vertical-align: middle; }
.add-servicefl .fl-input { margin-left: 10px; display: none; }
.add-servicefl .fl-input .form-control { display: inline-block; vertical-align: middle; width: 150px; }
.add-servicefl .fl-input .btn { display: inline-block; vertical-align: middle; }
.servicefl-wrap { margin-bottom: 10px; }
.servicefl-wrap h4 { font-size: 16px; font-weight: bold; margin: 0; line-height: 2; margin-bottom: 5px; }
.servicefl-wrap .fl-item { display: inline-block; margin-right: 6px; margin-bottom: 6px; background-color: #f5f5f5; border: 1px solid #dfdfdf; border-radius: 3px; padding: 0 10px; height: 35px; line-height: 33px; padding-right: 30px; position: relative; }
.servicefl-wrap .fl-item .delete-fl { position: absolute; height: 20px; width: 20px; top: 6px; right: 3px; font-size: 18px; color: #666; text-align: center; z-index: 1; line-height: 20px; cursor: pointer; }
.cus-input { padding: 7px 8px; font-size: 14px; border: 1px solid #ddd; -webkit-border-radius: 4px; -moz-border-radius: 4px; -ms-border-radius: 4px; -o-border-radius: 4px; border-radius: 4px; width: 100%; -webkit-transition: box-shadow 0.5s; -moz-transition: box-shadow 0.5s; -ms-transition: box-shadow 0.5s; -o-transition: box-shadow 0.5s; transition: box-shadow 0.5s; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; -o-box-sizing: border-box; box-sizing: border-box; min-height: 34px; resize: none; font-size: 14px; }
.classify-wrap .classify-title { font-size: 16px; font-weight: bold; line-height: 2; padding: 10px 0; }
.classify-wrap .classify-preiview-page { width: 320px; padding: 0 20px 20px; border: 1px solid #dfdfdf; -webkit-border-radius: 10px 10px 0 0; -moz-border-radius: 10px 10px 0 0; -ms-border-radius: 10px 10px 0 0; -o-border-radius: 10px 10px 0 0; border-radius: 10px 10px 0 0; background-color: #fff; box-sizing: content-box; float: left; }
.classify-preiview-page .mobile-head { padding: 12px 0; text-align: center }
.classify-preiview-page .mobile-con { border: 1px solid #dfdfdf; min-height: 150px; background-color: #f5f6f7; }
.classify-preiview-page .mobile-nav { position: relative; }
.classify-preiview-page .mobile-nav img { width: 100%; }
.classify-preiview-page .mobile-nav p { line-height: 44px; height: 44px; position: absolute; width: 100%; top: 20px; left: 0; font-size: 15px; text-align: center; }
.classify-preiview-page .classify-name { display: table; background-color: #fff; }
.classify-preiview-page .classify-name span { display: table-cell; width: 1000px; text-align: center; height: 45px; line-height: 45px; }
.classify-wrap .right-classify-manage { margin-left: 370px; min-height: 210px; }
.right-classify-manage .manage-title { font-weight: bold; padding: 10px 10px 5px; }
.right-classify-manage .manage-title span { font-size: 13px; color: #999; font-weight: normal; }
.right-classify-manage .add-classify { padding: 0 10px; }
.right-classify-manage .add-classify .add-btn { height: 32px; line-height: 30px; padding: 0 10px; background-color: #06BF04; border-radius: 4px; font-size: 14px; display: inline-block; cursor: pointer; border: 1px solid #00AB00; color: #fff; }
.classify-name-con { font-size: 0; padding: 10px; }
.noclassify { font-size: 15px; color: #999; }
.classify-name-con .classify-name { border: 1px solid #ddd; border-radius: 4px; padding: 5px 10px; position: relative; display: inline-block; font-size: 14px; margin-right: 10px; margin-bottom: 10px; background-color: #f5f6f7; cursor: move; }
.right-classify-manage .classify-name .cus-input { display: inline-block; width: 150px; }
.classify-name-con .classify-name .del-btn { display: inline-block; height: 34px; line-height: 34px; font-size: 20px; width: 25px; cursor: pointer; text-align: center; color: #666; vertical-align: middle; }
.classify-name-con .classify-name .del-btn:hover { color: #333; }

    .ui-popover.ui-popover-tuiguang.left-center .arrow{
        top:160px;
    }

    .ui-popover-tuiguang .code-fenlei>div {
        width: auto;
    }
    .ui-popover{
        width: 300px;
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
</style>

<!-- 二维码弹出框 -->
    <div class="ui-popover ui-popover-tuiguang left-center">
        <div class="ui-popover-inner" style="padding: 0;border-radius: 7px;overflow: hidden;">
            <div class="tab-name">
                <span class="active">企业服务二维码</span>
            </div>
            <div class="tab-main">
                <div class="code-box show">
                    <div class="alert alert-orange" style="text-align: center">扫一扫，在手机上查看并分享</div>
                    <div class="code-fenlei">
                        <div style="text-align: center">
                            <div class="text-center show">
                                <input type="hidden" id="qrcode-goods-id"/>
                                <img src="" id="act-code-img" alt="请重新生成二维码" style="width: 150px">
                                <!--<p>扫码查看名片详情</p>-->
                                <div style="text-align: center">
                                    <a href="javascript:;" onclick="reCreateQrcode()" class="new-window">重新生成</a>-
                                    <a href="" id="download-goods-qrcode" class="new-window">下载二维码</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="arrow"></div>
    </div>
<div id="content-con">
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
    <div  id="mainContent">
        <div class="choose-state" style="border:none;">
        </div>
        <div class="classify-wrap" ng-app="classifyApp" ng-controller="classifyCtrl">
            <div class="classify-title">当前分类</div>
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
                    </div>
                </div>
                <div class="right-classify-manage">
                    <div class="manage-title">管理分类<span>(左边预览默认显示4个，其它不做显示，手机端可横向滑动，拖动分类可以进行排序)</span></div>
                    <div class="add-classify">

                        <span class="add-btn" ng-click="addClassify()" style="background-color: #0077DD;border: 1px solid #006CC9">添加分类</span>
                        <span class="add-btn" ng-click="saveCategory()">保存分类</span>
                        <{if $type eq 1}><a href="/wxapp/shop/serviceStyle" class="add-btn" >样式设置</a><{/if}>

                    </div>
                    <div class="classify-name-con" ui-sortable ng-model="classifyList">
                        <div class="classify-name" ng-repeat="classify in classifyList">
                            <input type="text" ng-model="classify.name" class="cus-input" maxlength="10" placeholder="请输入分类名称">
                            <span class="del-btn" ng-click="delIndex('classifyList',classify.index)">×</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <a href="/wxapp/shop/add/type/<{$type}>" class="btn btn-green btn-xs" style="padding-top: 2px;padding-bottom: 2px;margin-bottom:10px"><i class="icon-plus bigger-80"></i>新增</a>
        </div>

        <{if $curr_shop['s_id'] == 3712}>
        <div class="page-header search-box" style="margin-bottom: 25px">
            <div class="col-sm-12">
                <form class="form-inline" action="/wxapp/shop/service" method="get">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">标题</div>
                                    <input type="text" class="form-control" name="title" value="<{$title}>"  placeholder="文章标题">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">分类</div>
                                    <select class="form-control" name="categoryId">
                                        <option value="0">全部</option>
                                        <{foreach $category_list as $val}>
                                    <option value="<{$val['id']}>" <{if $val['id'] == $categoryId}>selected<{/if}>><{$val['name']}></option>
                                        <{/foreach}>
                                    </select>
                                </div>
                            </div>

                            <!--<div class="form-group">
	                        <div class="input-group">
	                            <div class="input-group-addon">工单状态</div>
	                            <select class="form-control" name="status">
	                                <{foreach $statusList as $key=>$val}>
	                                <option value="<{$key}>" <{if $key == $status}>selected<{/if}>><{$val}></option>
	                                <{/foreach}>
	                            </select>
	                        </div>
	                    </div>-->
                            <div class="form-group" style="width: 450px">
                                <div class="input-group">
                                    <div class="input-group-addon" >最近更新</div>
                                    <input type="text" class="form-control" name="start" value="<{$start}>" placeholder="开始时间" id="start-time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})" autocomplete="off">
                                    <span class="input-group-addon">
	                                        <i class="icon-calendar bigger-110"></i>
	                                    </span>
                                    <span class="input-group-addon" style="border: none !important;background-color:  inherit !important;">到</span>
                                    <input type="text" class="form-control" name="end" value="<{$end}>" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})" autocomplete="off">
                                    <span class="input-group-addon">
	                                        <i class="icon-calendar bigger-110"></i>
	                                    </span>
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
        <{/if}>

        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th class="center">
                                <label>
                                    <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                    <span class="lbl"></span>
                                </label>
                            </th>
                            <th>封面图</th>
                            <th>标题</th>
                            <th>所属分类</th>                            
                            <th>简介</th>
                            <th>
                                <i class="icon-time bigger-110 hidden-480"></i>
                                最近更新</th>
                            <{if !in_array($menuType,['aliapp','bdapp','toutiao','qq','qihoo'])}>
                            <th>是否已推送</th>
                            <{/if}>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr>
                                <td class="center">
                                    <label>
                                        <input type="checkbox" class="ace" name="ids" value="<{$val['ss_id']}>"/>
                                        <span class="lbl"></span>
                                    </label>
                                </td>
                                <td><img src="<{$val['ss_cover']}>" width="50" style="border-radius:4px;"></td>
                                <td><{$val['ss_title']}></td>
                                <td><{if $category_select[$val['ss_type']][$val['ss_category']]}><{$category_select[$val['ss_type']][$val['ss_category']]}><{/if}></td>                                
                                <td style="white-space: normal;min-width:290px;"><{$val['ss_brief']}></td>
                                <td><{date('Y-m-d H:i',$val['ss_create_time'])}></td>
                                <{if !in_array($menuType,['aliapp','bdapp','toutiao','qq','qihoo'])}>
                                <td><{if $val['ss_push']}>已推送<{else}><span style="color:#333;">未推送</span><{/if}></td>
                                <{/if}>
                                <td class="jg-line-color">
                                    <{if !in_array($menuType,['aliapp','bdapp','toutiao','qq','qihoo'])}>
                                	<p>
                                        <a href="javascript:;" onclick="pushService('<{$val['ss_id']}>')" >推送</a> -
                                        <a href="javascript:;" data-toggle="modal" data-target="#tplPreviewModal" onclick="showPreview('<{$val['ss_id']}>')">预览</a> -
                                        <a href="/wxapp/tplpreview/pushHistory?type=service&id=<{$val['ss_id']}>" >记录</a>
                                    </p>
                                    <{/if}>
                                    <p>
                                        <{if !in_array($menuType,['aliapp','bdapp','toutiao','qq','qihoo'])}>
                                    	<a href="javascript:;" class="btn-tuiguang" data-id="<{$val['ss_id']}>" data-share="<{$val['ss_qrcode']}>">二维码</a> -
                                        <{/if}>
                                         <a href="/wxapp/shop/add/id/<{$val['ss_id']}>/type/<{$val['ss_type']}>" >编辑</a>
                                         - <a href="#" id="delete-confirm" data-id="<{$val['ss_id']}>" onclick="deleteArticle('<{$val['ss_id']}>')" style="color:#f00;">删除</a>                                       
                                    </p>                                    
                                </td>
                            </tr>
                            <{/foreach}>
                        <tr><td colspan="7"><{$pagination}></td></tr>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
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
<script src="/public/plugin/layui/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script src="/public/plugin/sortable/sortable.js"></script>
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<script>
    // 分类相关
    var app = angular.module('classifyApp', ['RootModule',"ui.sortable"]);
    app.controller('classifyCtrl',['$scope','$http','$timeout',function($scope,$http,$timeout){
        $scope.classifyList = <{$categoryList}>;
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
            if(classify_length>=20){
                layer.msg('最多只能添加20个分类');
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
                url:    '/wxapp/shop/saveCategory',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
        };


    }]);

    // 二维码弹出框
    $("#content-con").on('click', 'table td a.btn-tuiguang', function(event) {
        var that = $(this);
        var shareImg  = that.data('share');
        var id  = that.data('id');
//        if(shareImg){
            $('#act-code-img').attr('src',shareImg); //分享二维码图片
            $('#qrcode-goods-id').val(id);
            $('#download-goods-qrcode').attr('href', '/wxapp/shop/downloadServiceQrcode?id='+id);
            event.preventDefault();
            event.stopPropagation();
            var edithat = $(this) ;
            var conLeft = Math.round($("#content-con").offset().left)-160;
            var conTop = Math.round($("#content-con").offset().top)-104;
            var left = Math.round(edithat.offset().left);
            var top = Math.round(edithat.offset().top);
            optshide();
            $(".ui-popover.ui-popover-tuiguang").css({'left':left-conLeft-308,'top':top-conTop-206}).stop().show();
//        }
    });
    $("#content-con").on('click',function () {
        optshide();
    });
    function optshide(){
        $('.ui-popover').stop().hide();
    }

    function pushService(id) {
        layer.confirm('确定要推送吗？', {
          btn: ['确定','取消'], //按钮
          title : '推送'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/tplpush/servicePush',
                'data'  : { sid:id},
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

    function deleteArticle(id) {
        //var id = $(this).data('id');
        console.log(id);
        var load_index = layer.load(2,
            {
                shade: [0.1,'#333'],
                time: 10*1000
            }
        );
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/shop/deleteServiceInformation',
            'data'  : { id:id},
            'dataType'  : 'json',
            'success'  : function(ret){
                layer.close(load_index);
                if(ret.ec == 200){
                    window.location.reload();
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    }
    //重新生成二维码图片
    function reCreateQrcode(){
        var id = $('#qrcode-goods-id').val();
        console.log(id);

        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/shop/createServiceQrcode',
            'data'  : {id:id},
            'dataType' : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    layer.msg(ret.em);
                    layer.close(index);
                    $('#act-code-img').attr('src',ret.url); //分享二维码图片
                }
            }
        });

    }


    function showPreview(id) {
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/tplpreview/servicePreview',
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
</script>
