<link rel="stylesheet" href="/public/manage/menu/css/customMenu.css">

<div ng-app="youzan" ng-controller="menuCtrl" class="custommenu-box" id="custommenu-box" style="position:static;">
    <div class="page-con" style="margin-bottom: 70px;">
        <div class="notifications {{statusClass}}" ng-show="noticetip">{{tiptext}}</div>
        <div class="custom-menu clearfix">
            <div class="mobile-page">
                <div class="mobile-header"></div>
                <div class="mobile-con">
                    <div class="title-bar"><h3><{if $center['cc_center_title']}><{$center['cc_center_title']}><{else}>会员中心<{/if}></h3></div>
                    <div class="nav-menu">
                        <div class="jianpan"><img src="/public/manage/menu/images/showmenu_icon@2x.png" alt=""></div>
                        <div id="navmenu-ul" class="navmenu-ul" >
                            <ul class="box">
                                <li ng-repeat="menu in menus">
                                    <span>{{menu.text}}</span>
                                    <dl ng-if="menu.son_menus.length>0">
                                        <dd ng-repeat="son_menu in menu.son_menus"><span>{{son_menu.text}}</span></dd>
                                    </dl>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div id="navmenu-masklayer" class="masklayer-div on">&nbsp;</div>
                </div>
                <div class="mobile-home"></div>
            </div>
            <div class="custom-operation">
                <ul id="firstmenu"  ui-sortable ng-model="menus">
                    <li class="opera-box" ng-repeat="menu in menus">
                        <div class="delete" ng-click="dealMenuIndex('del',-1,menu.index)">×</div>
                        <div class="opera-wrap clearfix">
                            <div class="menu-titles">
                                <div class="h4">一级菜单:</div>
                                <ul class="first-nav-field">
                                    <li class="menu-item clearfix" ng-class="{'active':menu.son_menus.length==0}" data-id="-1">
                                        <span class="h5">{{menu.text}}</span>
                                        <span class="opts">
                                            <a ng-click="dealMenuIndex('edit',-1,menu.index)" class="js-edit-first" href="javascript:void(0);">编辑</a>
                                        </span>
                                    </li>
                                </ul>
                                <div class="h4">二级菜单:</div>
                                <ul ng-if="menu.son_menus.length>0" ui-sortable ng-model="menu.son_menus" class="sec-nav-field">
                                    <li ng-repeat="son_menu in menu.son_menus" ng-class="{'active':$last}" class="menu-item js-second-field js-menu-li clearfix " data-id="{{$index}}">
                                        <span class="h5">{{$index+1}}. {{son_menu.text}}</span>
                                        <span class="opts">
                                            <a ng-click="dealMenuIndex('edit',menu.index,son_menu.index)" class="js-edit-second" href="javascript:void(0);">编辑</a> -
                                            <a ng-click="dealMenuIndex('del',menu.index,son_menu.index)" class="js-del-second" href="javascript:void(0);">删除</a>
                                        </span>
                                    </li>
                                </ul>
                                <div class="add-second-nav">
                                    <a ng-click="addNewMenu($index)" class="js-add-second" href="javascript:void(0);">+ 添加二级菜单</a>
                                </div>
                            </div>
                            <div class="menu-main">
                                <!-- <div class="menu-content" ng-style="{'min-height':(80+menu.son_menus.length*36)+'px'}">
                                    <div class="firsttxt-disabled" style="font-size: 14px;font-weight:bold;color:#888;display: none;" >使用二级菜单后主回复已失效。</div>
                                </div> -->
                                <div class="menu-content" ng-model="menu.son_menus" ng-style="{'min-height':(80+menu.son_menus.length*36)+'px'}">
                                    <div class="link-to firsttxt-disabled" data-id="-1" ng-class="{'show':menu.son_menus.length==0}">{{menu.link}}</div>
                                    <div class="link-to js-link-to" ng-repeat="son_menu in menu.son_menus"  ng-class="{'show':$last}" data-id="{{$index}}">{{son_menu.link}}</div>
                                </div>
                                <div class="select-link js-select-link">
                                    <span class="change-txt">回复内容：</span>
                                    <span class="main-link">
                                        <a href="#" data-type="txt" class="js-modal-txt" data-toggle="modal" data-target="#myModal" >文本信息</a> - 
                                        <a href="#" data-type="link" class="js-modal-links" data-toggle="modal" data-target="#myModalLink" >自定义外链</a> -
                                        <!-- <{foreach $click_enum as $key => $val}>
                                        <a href="#" data-type="save" class="js-modal-save menu_map" data-toggle="modal" data-target="#myModalSave" data-key="<{$key}>" data-value="<{$val['text']}>" ><{$val['text']}></a>
                                        <{/foreach}> -->


                                        <!-- <a href="#" data-type="news" class="js-modal-news" data-toggle="modal" data-target="#myModal1">图文素材</a> -

                                        <a href="#" data-type="feature" class="js-modal-magazine">微页面</a> -
                                        <a href="#" data-type="goods" class="js-modal-goods">商品</a> - -->
                                    </span>
                                    <div class="opts dropdown-con hover">
                                        <a href="#" class="dropdowncon-toggle">其他<i class="caret"></i></a>
                                        <ul class="dropdown-menu-xiala">
                                            <{foreach $click_enum as $key => $val}>
                                            <li>
                                                <a href="#" data-type="save" class="js-modal-save menu_map" data-toggle="modal" data-target="#myModalSave" data-key="<{$key}>" data-value="<{$val['value']}>" ><{$val['text']}></a>
                                            </li>
                                            <{/foreach}>
                                            <!-- <li>
                                                <a href="#" data-type="activity" class="js-modal-activity">活动</a>
                                            </li>
                                            <li>
                                                <a href="#" data-type="homepage" class="js-modal-homepage">店铺主页</a>
                                            </li>
                                            <li>
                                                <a href="#" data-type="usercenter" class="js-modal-usercenter">会员主页</a>
                                            </li>
                                            <li>
                                                <a href="#" data-type="cart" class="js-modal-cart">购物车</a>
                                            </li>
                                            <li>
                                                <a href="#" data-type="search" class="js-modal-search">搜索</a>
                                            </li>
                                            <li>
                                                <a href="#" data-type="checkin" class="js-modal-checkin">签到</a>
                                            </li>
                                            <li>
                                                <a href="#" data-type="survey" class="js-modal-survey">投票调查</a>
                                            </li>
                                             -->
                                        </ul>
                                    </div>
                                    <div class="editor-image js-editor-image"></div>
                                    <div class="hide editor-place js-editor-place"></div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="add-first-nav">
                    <a ng-click="addNewFirstMenu()" class="js-add-first" href="javascript:void(0);">+ 添加一级菜单</a>
                </div>
            </div>
        </div>
        <div class="alert alert-warning setting-save" role="alert"><button class="btn btn-primary btn-sm" ng-click="saveMenu();">提交修改</button></div>
    </div>
    <!-- 确定删除 -->
    <div class="ui-popover ui-popover--confirm left-center">
        <div class="ui-popover-inner clearfix pop-shopnav-del">
            <div class="inner__header clearfix">
                <div style="width: 160px;line-height: 28px;font-size: 14px;" class="pull-left text-center">确定删除？</div>
                <div class="pull-right">
                    <a ng-click="delMenu()" class="ui-btn ui-btn-primary js-save" href="javascript:void(0);">确定</a>
                    <a class="ui-btn js-cancel" href="javascript:void(0);">取消</a>
                </div>
            </div>
        </div>
        <div class="arrow"></div>
    </div>
    <!-- 编辑标题 -->
    <div class="ui-popover ui-popover-edit top-center"  style="top:100px;">
        <div class="ui-popover-inner">
            <span></span>
            <input type="text" style="margin-bottom: 0;" ng-model="editMenuText" placeholder="" value="标题" class="input-medium js-name-input" autofocus="autofocus" onfocus="this.select()">
            <a ng-click="editMenu()" class="ui-btn ui-btn-primary js-save" href="javascript:void(0);">确定</a>
            <a class="ui-btn js-cancel" href="javascript:void(0);">取消</a>
        </div>
        <div class="arrow"></div>
    </div>
    <!-- 弹出层 模态框（Modal）-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        文本信息
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="txt-info" id="txt-info">
                        <textarea  class="form-control" name="" id="extra-text" rows="5" placeholder="文本信息"></textarea>
                        <span class="wordwrap"><var class="word">600</var>/600</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default cancel" data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-primary confirm" data-dismiss="modal" ng-click="setLink('click')">
                        确认
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal -->
    </div>
    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        模态框（Modal）标题
                    </h4>
                </div>
                <div class="modal-body">
                    图文素材
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default cancel" data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-primary confirm" data-dismiss="modal">
                        确认
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal -->
    </div>
    <div class="modal fade" id="myModalLink" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        自定义外链
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="custom-link">
                        <input type="text" class="form-control" id="extra-link" placeholder="http://www.baidu.com">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default cancel" data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-primary confirm" data-dismiss="modal" ng-click="setLink('view')">
                        确认
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal -->
    </div>
    <div class="modal fade" id="myModalSave" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width:200px;">
            <div class="modal-content">
                <div class="modal-body" style="text-align:center">
                <input type="hidden" id="akey" >
                <input type="hidden" id="avalue" >
                    确认保存吗？
                </div>
                <div class="modal-footer" style="text-align:center">
                    <button type="button" class="btn btn-sm btn-default cancel" data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-sm btn-primary confirm" ng-click="saveMap()" data-dismiss="modal">
                        确认
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal -->
    </div>
</div>

<script type="text/javascript" src="/public/manage/menu/js/lib/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/public/manage/menu/js/lib/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="/public/manage/menu/js/lib/angular-1.4.6.min.js"></script>
<script type="text/javascript" src="/public/manage/menu/js/lib/sortable.js"></script>
<script type="text/javascript" src="/public/manage/menu/js/customMenu.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>
    var Youzan=angular.module("youzan",["ui.sortable"]);
    //依赖注入  前边的数组 和 后面的回调函数里面必须都要写 就是根据前边的数组 来寻找要注入的模块
    Youzan.controller("menuCtrl",["$scope","$timeout", '$http', function($scope,$timeout,$http){
        //定义初始菜单
        $scope.menus = <{$menu_json}>;

        $scope.noticetip=false;
        $scope.tiptext="创建成功";
        $scope.statusClass="bg0";

        //菜单的默认标题
        $scope.defaultText="标题";
        //默认添加到的一级菜单索引为-1
        $scope.defaultMenuIndex=-1;

        //新增新的一级菜单
        $scope.addNewFirstMenu=function(){
            var menu_length = parseInt($scope.menus.length);
            var defaultIndex = 0;
            if(menu_length>0){
                // defaultIndex = $scope.menus[menu_length-1].index+1;
                for (var i=0;i<length;i++){
                    if(defaultIndex < parseInt($scope.menus[i].index)){
                        defaultIndex = parseInt($scope.menus[i].index);
                    }
                }
                defaultIndex++;
            }
            if(menu_length<3){

                //保存一级菜单到数据库
                saveMenu($scope.defaultText,-1,menu_length);
                var menufirst={
                    // index:menu_length,
                    index:defaultIndex,
                    text:$scope.defaultText,
                    link:"",
                    son_menus:[]
                };
                //添加
                $scope.menus.push(menufirst);
                $scope.tiptext="一级菜单创建成功";
                $scope.statusClass="bg0";
                $scope.noticetip=true;
                $timeout(function () {
                    $scope.noticetip=false;
                }, 2000);
            }else{
                $scope.tiptext="最多只能添加3个一级菜单";
                $scope.statusClass="bg1";
                $scope.noticetip=true;
                $timeout(function () {
                    $scope.noticetip=false;
                },2000);
            }
        };
        //新增新的二级菜单
        $scope.addNewMenu=function(menuIndex){
            $scope.defaultMenuIndex=menuIndex;
            var sonmenu_length=$scope.menus[$scope.defaultMenuIndex].son_menus.length+1;
            var length=$scope.menus[$scope.defaultMenuIndex].son_menus.length;
            var defaultIndex = 0;
            if(length>0){
                // defaultIndex = $scope.menus[$scope.defaultMenuIndex].son_menus[length-1].index+1;
                for (var i=0;i<length;i++){
                    if(defaultIndex < parseInt($scope.menus[$scope.defaultMenuIndex].son_menus[i].index)){
                        defaultIndex = parseInt($scope.menus[$scope.defaultMenuIndex].son_menus[i].index);
                    }
                }
                defaultIndex++;
            }
            if(sonmenu_length<=5){
                var menu={
                    // index:$scope.menus[$scope.defaultMenuIndex].son_menus.length,
                    index:defaultIndex,
                    text:$scope.defaultText,
                    link:""
                };
                //添加
                $scope.menus[$scope.defaultMenuIndex].son_menus.push(menu);
                $scope.tiptext="二级菜单创建成功,请修改标题,否则无法保存";
                $scope.statusClass="bg0";
                $scope.noticetip=true;
                $timeout(function () {
                    $scope.noticetip=false;
                }, 2000);
            }else{
                $scope.tiptext="最多只能添加5个二级菜单";
                $scope.statusClass="bg1";
                $scope.noticetip=true;
                $timeout(function () {
                    $scope.noticetip=false;
                }, 2000);
            }
        };

        $scope.getIndexInArry=function(parentIndex,sonIndex){
            var resultIndex=-1;
            //判断编辑的是不是一级菜单
            if(parentIndex<0){ //是
            	for(i=0;i<$scope.menus.length;i++){
                	if($scope.menus[i].index==sonIndex){
	                    resultIndex=i;
	                    break;
                	}
                }
            }else{
                //否
                for(i=0;i<$scope.menus[parentIndex].son_menus.length;i++){
                    if($scope.menus[parentIndex].son_menus[i].index==sonIndex){
                        resultIndex=i;
                        break;
                    }
                }
            }
            return resultIndex;
        };
        //记录要删除的菜单的索引
        $scope.dealIndexStr="-1,-1";

        //操作按钮赋值函数
        $scope.dealMenuIndex=function(actionType,parentIndex,sonIndex){
            // 
            //判断当前操作的是不是一级菜单
            var realParentIndex=-1,delArrayIndex=-1,dealIndexStr="";

            if(parentIndex<0){
                realParentIndex=$scope.getIndexInArry(-1,sonIndex);
                delArrayIndex=realParentIndex;
                dealIndexStr="-1,"+delArrayIndex;
            }else{
                realParentIndex=$scope.getIndexInArry(-1,parentIndex);
                delArrayIndex=-1;
                delArrayIndex=$scope.getIndexInArry(realParentIndex,sonIndex);
                dealIndexStr=realParentIndex+","+delArrayIndex;
            }

            $scope.dealIndexStr=dealIndexStr;
            //如果是编辑操作
            if(actionType=="edit"){
                if(parentIndex>=0){
                    //编辑二级菜单
                    $scope.editMenuText=$scope.menus[realParentIndex].son_menus[delArrayIndex].text;
                }else{
                    //编辑一级菜单
                    $scope.editMenuText=$scope.menus[delArrayIndex].text;
                }
            }
        };
        //删除菜单
        $scope.delMenu=function(){
            var parentIndex=$scope.dealIndexStr.split(',')[0];
            var sonIndex=$scope.dealIndexStr.split(',')[1];

            var delArrayIndex=$scope.getIndexInArry(parentIndex,sonIndex);
            //删除
            if(parentIndex<0){
                /*删除一级菜单*/
                $scope.menus.splice(delArrayIndex,1);
                $scope.tiptext="删除成功";
                $scope.statusClass="bg0";
                $scope.noticetip=true;
                $timeout(function () {
                    $scope.noticetip=false;
                },2000);
            }else{
                /*删除二级菜单*/
                $scope.menus[parentIndex].son_menus.splice(delArrayIndex,1);
                $scope.tiptext="删除成功";
                $scope.statusClass="bg0";
                $scope.noticetip=true;
                $timeout(function () {
                    $scope.noticetip=false;
                },2000);
            }
            delMenu(parentIndex,sonIndex);
            
        };
        $scope.saveMenu=function(){
            var flag    = true;
            var menu    = $scope.menus;
            for (var x in menu) {
                if (menu[x]['son_menus'].length > 0) {
                    var son = menu[x]['son_menus'];
                    for (var y in son) {
                        if (!son[y]['link']) {
                            flag = false;
                            break;
                        }
                    }
                } else {
                    if (!menu[x]['link']) {
                        flag = false;
                        break;
                    }
                }
            }
            if (flag) {
                publishMenu();
            } else {
                layer.open({
                    type: 1,
                    title: false, //不显示标题
                    shade:0,
                    skin: 'layui-layer-error', //样式类名
                    closeBtn: 0, //不显示关闭按钮
                    shift: 5,
                    content: '有菜单没有回复内容,请修改后重新提交',
                    time: 3000
                });
            }
        };
        //当前编辑的菜单的名字
        $scope.editMenuText="";
        //当前的操作类型 edit del
        $scope.actionType="";
        //编辑菜单
        $scope.editMenu=function(){
            var parentIndex=$scope.dealIndexStr.split(',')[0];
            var sonIndex=$scope.dealIndexStr.split(',')[1];

            if(parentIndex<0){
                //完成编辑
                if($scope.editMenuText.length<=4){
                    $scope.menus[sonIndex].text=$scope.editMenuText;
                    $scope.tiptext="更新成功";
                    $scope.statusClass="bg0";
                    $scope.noticetip=true;
                    $timeout(function () {
                        $scope.noticetip=false;
                    },2000);
                    //保存菜单修改
                    saveMenu($scope.editMenuText,parentIndex,sonIndex);
                }else{
                    $scope.tiptext="一级菜单最多不能超过四个字";
                    $scope.statusClass="bg1";
                    $scope.noticetip=true;
                    $timeout(function () {
                        $scope.noticetip=false;
                    },2000);
                }
                
            }else{
                //完成编辑
                if($scope.editMenuText.length<=7){
                    $scope.menus[parentIndex].son_menus[sonIndex].text=$scope.editMenuText;
                    $scope.tiptext="更新成功";
                    $scope.statusClass="bg0";
                    $scope.noticetip=true;
                    $timeout(function () {
                        $scope.noticetip=false;
                    },2000);
                    //保存菜单修改
                    saveMenu($scope.editMenuText,parentIndex,sonIndex);
                }else{
                    $scope.tiptext="二级菜单最多不能超过7个字";
                    $scope.statusClass="bg1";
                    $scope.noticetip=true;
                    $timeout(function () {
                        $scope.noticetip=false;
                    },2000);
                }
                
            }
        };
        //监控菜单改变 刷新菜单
        $scope.$watch("menus",function(newvalue){
            for(index in newvalue){
                $scope.menus[index].index=index;

                for(sonIndex in newvalue[index].son_menus){
                    $scope.menus[index].son_menus[sonIndex].index=sonIndex;
                }
            }
        },true);
        //菜单链接链接值得
        $scope.setLink=function(type){
            var extra;
            if(type=='click'){
                 extra = document.getElementById("extra-text").value;
            }else if(type='view'){
                 extra  = document.getElementById("extra-link").value;
            }

            setValue(extra , type);
            if(dataIndex == -1){
                $scope.menus[oneIndex].link = extra;
            }else{
                $scope.menus[oneIndex]. son_menus[dataIndex].link = extra;
            }
        };
        $scope.saveMap = function(){
            var akey = document.getElementById("akey").value ,label = document.getElementById("avalue").value;;
            if(akey && label){
                setValue(label , 'click',akey);
                if(dataIndex == -1){
                    $scope.menus[oneIndex].link = label;
                }else{
                    $scope.menus[oneIndex]. son_menus[dataIndex].link = label;
                }
            }
        }
    }]);
</script>