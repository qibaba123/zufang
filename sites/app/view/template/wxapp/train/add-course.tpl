<link rel="stylesheet" href="/public/plugin/sortable/jquery-ui.min.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/addgoods.css">
<style>
    .course-time{
        display: inline-block;
        width: 34%;
    }
    .course-time .time-label{
        width: 70px !important;
        font-weight: normal !important;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "是\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0否";
    }

</style>
<{include file="../article-kind-editor.tpl"}>
<div class="row" ng-app="chApp" ng-controller="chCtrl">
    <div class="col-xs-12">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-header widget-header-blue widget-header-flat">
                        <h4 class="lighter"><small><a href="/wxapp/train/courseList"> 返回 </a></small> | 新增/编辑课程信息</h4>
                        <div class="col-xs-1 pull-right search-btn">
                        </div>
                    </div>
                    <div class="step-content row-fluid position-relative" id="step-container">
                        <form class="form-horizontal" id="course-form"  enctype="multipart/form-data" style="overflow: hidden;">
                            <input type="hidden" id="hid_id" name="hid_id" value="<{if $row}><{$row['atc_id']}><{else}>0<{/if}>">
                            <!-- 表单分类显示 -->
                            <div class="info-group-inner">
                                <div class="group-title">
                                    <span>基本信息</span>
                                </div>
                                <div class="group-info">
                                    <div class="form-group">
                                        <label for="name" class="control-label"><font color="red">*</font>课程名称：</label>
                                        <div class="control-group">
                                            <input type="text" class="form-control" id="course-title" name="course-title" placeholder="请填写课程名称" required="required" value="<{if $row}><{$row['atc_title']}><{/if}>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="control-label">报名人数：</label>
                                        <div class="control-group">
                                            <input type="text" class="form-control" id="course-apply" name="course-apply" placeholder="请填写已报名人数" value="<{if $row}><{$row['atc_apply']}><{/if}>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="control-label"><font color="red">*</font>课程简介：</label>
                                        <div class="control-group">
                                            <textarea type="text" class="form-control" id="course-brief" name="course-brief" placeholder="请填写课程简介" required="required" ><{if $row}><{$row['atc_brief']}><{/if}></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="control-label"><font color="red">*</font>课程类型：</label>
                                        <div class="control-group">
                                            <select id="course-type" name="course-type" style="width: 80%" class="form-control">
                                                <{if $type}>
                                                <{foreach $type as $key=>$val}>
                                                <option <{if $row['atc_type_id'] eq $key}>selected<{/if}> value="<{$key}>"><{$val}></option>
                                                <{/foreach}>
                                                <{else}>
                                                <option value="0">请先添加课程分类</option>
                                                <{/if}>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="control-label">课程原价：</label>
                                        <div class="control-group">
                                            <input type="text" class="form-control" id="course-ori-price" name="course-ori-price" placeholder="请填写课程原价,不填则不显示" value="<{if $row}><{$row['atc_ori_price']}><{/if}>" maxlength="20">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="control-label">课程价格：</label>
                                        <div class="control-group">
                                            <input type="text" class="form-control" id="course-price" name="course-price" placeholder="请填写课程价格,不填则不显示" value="<{if $row}><{$row['atc_price']}><{/if}>" maxlength="20">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">是否参与会员折扣：</label>
                                        <div class="control-group">
                                            <label style="padding: 4px 0;margin: 0;">
                                                <input name="atc_join_discount" class="ace ace-switch ace-switch-5" id="atc_join_discount" <{if ($row && $row['atc_join_discount']) || !$row}>checked<{/if}> type="checkbox">
                                                <span class="lbl"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="control-label">课时：</label>
                                        <div class="control-group" style="width: 30%">
                                            <input type="number" class="form-control" id="course-hour" name="course-hour" placeholder="请填写课时数,不填则不显示" value="<{if $row}><{$row['atc_hour']}><{/if}>" maxlength="20">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="control-label">课程时间：</label>
                                        <div class="control-group">
                                            <div class="course-time" style="width: 30%;">
                                                <input type="text" class="form-control time" id="course-start-time" name="course-start-time" placeholder="请填写开始时间,不填则不显示" value="<{if $row && $row['atc_start_time']}><{date('Y-m-d',$row['atc_start_time'])}><{/if}>" style="max-width: 100% !important;width: 100%">
                                            </div>
                                            <div class="course-time">
                                                <label for="name" class="control-label time-label" style="text-align: center;width: 20% !important;">至</label>
                                                <input type="text" class="form-control time" id="course-end-time" name="course-end-time" style="width: 80%;" placeholder="请填写结束时间,不填则不显示" value="<{if $row && $row['atc_end_time']}><{date('Y-m-d',$row['atc_end_time'])}><{/if}>" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">课程列表标签：</label>
                                        <div class="control-group">
                                            <input type="text" class="form-control" id="atc_list_label" name="atc_list_label" placeholder="请填写课程列表标签，最多4个字"  value="<{if $row}><{$row['atc_list_label']}><{/if}>" >
                                            <p class="tip">课程列表标签最多4个字</p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">课程排序：</label>
                                        <div class="control-group" style="width: 30%">
                                            <input type="text" class="form-control" id="atc_sort" name="atc_sort" placeholder="课程排序"  value="<{if $row}><{$row['atc_sort']}><{/if}>" >
                                            <p class="tip">越大越靠前</p>
                                        </div>
                                    </div>

                                    <{if $curr_shop['s_id'] == 10380}>
                                    <div class="form-group">
                                        <label class="control-label">兑换所需次数：</label>
                                        <div class="control-group">
                                            <input type="text" class="form-control" id="atc_exchange_cost" name="atc_exchange_cost" placeholder="请填写兑换所需次数"  value="<{if $row}><{$row['atc_exchange_cost']}><{/if}>" >
                                            <p class="tip" style="max-width: 500px">单位：次/每人。若每人需消耗2次兑换，直接填写“2”即可</p>
                                        </div>
                                    </div>
                                    <{/if}>
                                    <div class="form-group">
                                        <label for="price" class="control-label"><font color="red">*</font>课程封面图片：</label>
                                        <div class="control-group">
                                            <!--<div class="cropper-box" data-width="750" data-height="300">
                                                <img src="<{if $row && $row['atc_cover']}><{$row['atc_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_75_30.png<{/if}>" width="300" style="display:inline-block;margin:0;">
                                                <input type="hidden" id="course_cover_img" class="avatar-field source-img" ng-model="cover" name="course_cover_img" value="<{$row['atc_cover']}>"/>
                                                <span>建议尺寸（750*300）</span>
                                            </div>-->
                                            <div>
                                                <img onclick="toUpload(this)" data-limit="1" data-width="750" data-height="400" data-dom-id="upload-cover" id="upload-cover"  <{if $row && $row['atc_cover']}>src=<{$row['atc_cover']}><{else}>src="/public/manage/img/zhanwei/zw_fxb_75_40.png"<{/if}> width="300" style="display:inline-block;margin-left:0;">
                                                <input type="hidden" id="course_cover_img"  class="avatar-field bg-img" name="course_cover_img" value="<{$row['atc_cover']}>"/>
                                                <span>建议尺寸（750*400）</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">分享标题：</label>
                                        <div class="control-group">
                                            <input type="text" class="form-control" id="atc_share_title" name="atc_share_title" placeholder="请填写分享标题"  value="<{if $row}><{$row['atc_share_title']}><{/if}>" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="price" class="control-label"><font color="red">*</font>分享图片：</label>
                                        <div class="control-group">
                                            <div>
                                                <img onclick="toUpload(this)" data-limit="1" data-width="500" data-height="400" data-dom-id="upload-share-img" id="upload-share-img"  <{if $row && $row['atc_share_img']}>src=<{$row['atc_share_img']}><{else}>src="/public/manage/img/zhanwei/zw_fxb_45_45.png"<{/if}> width="150" style="display:inline-block;margin-left:0;">
                                                <input type="hidden" id="course_share_img"  class="avatar-field bg-img" name="course_share_img" value="<{$row['atc_share_img']}>"/>
                                                <span>建议尺寸（500*400）</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="info-group-box" style="margin-top: 5px">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>报名表单</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <div class="control-group">
                                                                <div class="panel-group" id="panel-group" ui-sortable ng-model="messageList">
                                                                    <div class="panel message-row" ng-repeat="message in messageList track by $index">
                                                                        <div class="panel-collapse">
                                                                            <a href="javascript:;" class="close" ng-click="delIndex('messageList',$index)">×</a>
                                                                            <div class="panel-body">
                                                                                <div class="col-xs-2">
                                                                                    <div class="input-group" style="width: 100%">
                                                                                        <input type="text"  maxlength="5" style="width: 100%;max-width: 100%"  class="form-control message-name" ng-model="message.name">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-3">
                                                                                    <div class="input-group" style="width: 100%">
                                                                                        <select class="form-control message-type" ng-model="message.type" style="width: 100%;max-width: 100%"   ng-options="x.type as x.name for x in messageType" ></select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-3" ng-if="message.type!='image'">
                                                                                    <div class="input-group" style="width: 100%">
                                                                                        <input type="text"  style="width: 100%;max-width: 100%" placeholder="提示文本" class="form-control message-placeholder" ng-model="message.placeholder">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-3">
                                                                                    <div class="input-group">
                                                                                        <label for=""  style="padding: 6px 3px">
                                                                                            <input type="checkbox" name="require"  class="message-require" ng-model="message.require"  ng-checked="message.require"> 必填
                                                                                        </label>
                                                                                        <label for=""  style="padding: 6px 3px" ng-if="message.type=='text'">
                                                                                            <input type="checkbox" name="date" ng-model="message.multi"  class="message-multi" ng-checked="message.multi"> 多行
                                                                                        </label>
                                                                                        <label for=""  style="padding: 6px 3px" ng-if="message.type=='time'">
                                                                                            <input type="checkbox" name="date" ng-model="message.date"  class="message-date" ng-checked="message.date"> 日期
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <a href="javascript:;" class="ui-btn" ng-click="addMessage()" style="    margin: 3px 0;"><i class="icon-plus"></i>添加字段</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                            <!--
                            <div class="info-group-box" style="margin-top: 3px">
                                <div class="info-group-inner">
                                    <div class="group-title">
                                        <span>大纲</span>
                                    </div>
                                    <div class="group-info">
                                        <div class="form-group">
                                            <label for="price" class="control-label">课程大纲：</label>
                                            <div class="control-group">
                                                <div class="panel-group" id="panel-group">
                                                    <div class="panel outlineRow" ng-repeat="outline in outlineList track by $index">
                                                        <div class="panel-collapse">
                                                            <a href="javascript:;" class="close" ng-click="delIndex('outlineList',$index)">×</a>
                                                            <div class="panel-body">
                                                                <div class="col-xs-6">
                                                                    <div class="input-group" style="width: 100%">
                                                                        <span class="col-xs-2" style="display: inline-block;margin-top: 5px;">标题：</span>
                                                                        <input type="text"  style="width: 80%;max-width: 100%" placeholder="请输入大纲标题" ng-model="outline.title" class="form-control col-xs-6 outline-title">
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-6">
                                                                    <div class="input-group" style="width: 100%">
                                                                        <span class="col-xs-2" style="display: inline-block;margin-top: 5px;">简介：</span>
                                                                        <input type="text"  style="width: 80%;max-width: 100%" placeholder="请输入大纲简介" class="form-control col-xs-6 outline-brief" ng-model="outline.brief">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="javascript:;" class="ui-btn" style="    margin: 3px 0;" ng-click="addOutline()"><i class="icon-plus"></i>添加大纲</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            -->
                            <div class="info-group-box">
                                <div class="info-group-inner">
                                    <div class="group-title">
                                        <span>课程大纲</span>
                                    </div>
                                    <div class="group-info">
                                        <div class="form-group">
                                            <label for="price" class="control-label">课程大纲：</label>
                                            <div class="control-group">
                                                <div class="form-textarea">
                                                    <textarea class="form-control" style="height:350px;visibility:hidden;" id="article-outline" name="article-outline" placeholder="课程大纲"  rows="20" style=" text-align: left; resize:vertical;" ><{if $row && $row['atc_outline']}><{$row['atc_outline']}><{/if}></textarea>
                                                    <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                                                    <input type="hidden" name="ke_textarea_name" value="article-outline" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="info-group-box">
                                <div class="info-group-inner">
                                    <div class="group-title">
                                        <span>详情</span>
                                    </div>
                                    <div class="group-info">
                                        <div class="form-group">
                                            <label for="price" class="control-label">课程详情：</label>
                                            <div class="control-group">
                                                <div class="form-textarea">
                                                    <textarea class="form-control" style="height:350px;visibility:hidden;" id="article-detail" name="article-detail" placeholder="文章内容"  rows="20" style=" text-align: left; resize:vertical;" ><{if $row && $row['atc_content']}><{$row['atc_content']}><{/if}></textarea>
                                                    <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                                                    <input type="hidden" name="ke_textarea_name" value="article-detail" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- 讲师介绍 -->
                            <div class="info-group-box">
                                <div class="info-group-inner">
                                    <div class="group-title">
                                        <span>讲师介绍</span>
                                    </div>
                                    <div class="group-info">
                                        <div class="form-group">
                                            <label for="price" class="control-label">讲师介绍：</label>
                                            <div class="control-group">
                                                <div class="form-textarea">
                                                    <textarea class="form-control" style="height:350px;visibility:hidden;" id="teacher-detail" name="teacher-detail" placeholder="讲师介绍"  rows="20" style=" text-align: left; resize:vertical;" ><{if $row && $row['atc_teacher']}><{$row['atc_teacher']}><{/if}></textarea>
                                                     <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                                                    <input type="hidden" name="ke_textarea_name" value="teacher-detail" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <button class="btn btn-primary" onclick="savePackage();" style="margin: 30px 45%;">
                        保存
                    </button>
                </div>
            </div>
        </div>
    </div><!-- /span -->
</div><!-- /row -->
<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 460px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    修改帖子信息
                </h4>
                <input type="hidden" id="post_id" value="">
                <input type="hidden" id="post_cate_old" value="">
                <input type="hidden" id="category_level" value="">
            </div>
            <div class="modal-body">
                <div id="buy-template">
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num">预约项目：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="appo_title" id="appo_title" placeholder="请输入预约项目标题">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num">课程详情：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="detail_title" id="detail_title" placeholder="请输入课程详情标题">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-primary" id="conform-update">
                        确认修改
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</div>
<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/public/plugin/sortable/jquery-ui.min.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script src="/public/plugin/sortable/sortable.js"></script>
<script type="text/javascript">
    var curr_sid = "<{$curr_shop['s_id']}>";
    var app = angular.module('chApp', ['RootModule',"ui.sortable"]);
    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope, $http, $timeout){
        //$scope.outlineList = <{$outlineList}>;
        $scope.messageList = <{$messageList}>;
        $scope.messageType = [
            {
                'type': 'text',
                'name': '文本格式'
            },
            {
                'type': 'number',
                'name': '数字格式'
            },
            {
                'type': 'email',
                'name': '邮箱'
            },
            {
                'type': 'date',
                'name': '日期'
            },
            {
                'type': 'time',
                'name': '时间'
            },
            {
                'type': 'idcard',
                'name': '身份证号'
            },
            {
                'type': 'image',
                'name': '图片'
            },
            {
                'type': 'mobile',
                'name': '手机号'
            }
        ];
        $scope.addMessage = function () {
            var data = {
                'name': '留言',
                'type': 'text',
                'multi': false,
                'require': false,
                'date' : false
            };
            $scope.messageList.push(data);
            console.log($scope.messageList);
        };
        $scope.addOutline = function () {
            var data = {
                'title': '标题',
                'brief': '简介'
            };
            $scope.outlineList.push(data);
        };

        /*删除元素*/
        $scope.delIndex=function(type,index){
            console.log(index);
             $scope[type].splice(index,1);
//            layer.confirm('您确定要删除吗？', {
//                title:'删除提示',
//                btn: ['确定','取消']
//            }, function(){
//                $scope.$apply(function(){
//                    $scope[type].splice(index,1);
//                });
//                layer.msg('删除成功');
//            })
        }

    }]);

    /**
     * 第二步检查基本信息
     * */
    function checkBasic(){
        var check   = new Array('course-title','course-type','article-detail');
        for(var i=0 ; i < check.length ; i++){
            var temp = $('#'+check[i]).val();
            if(!temp){
                var msg = $('#'+check[i]).attr('placeholder');
                layer.msg(msg);
                return false;
            }
        }
        return true;
    }

    /**
     * 第三步，检查图片
     * @returns {boolean}
     */
    function checkImg(){
        var cover = $('#course_cover_img').val();
        if(!cover){
            layer.msg('请上传课程图片');
            return false;
        }
        return true;
    }

    /**
     * 保存课程信息
     */
    function savePackage(){
        if(!checkBasic() || !checkImg()){
            return false;
        }

//        var outlineList = [];
//        $('.outlineRow').each(function () {
////            var obj = $(this);
//            var title = $(this).find('.outline-title').val();
//            var brief = $(this).find('.outline-brief').val();
//            if(title && brief){
//                var outline = {
//                    'title' : title,
//                    'brief' : brief
//                };
//                outlineList.push(outline);
//            }else{
//                layer.msg('请补全大纲信息');
//                return false
//            }
//        });
        var messageList = [];
        $('.message-row').each(function () {
            // var obj = $(this);
            var multi;
            var require;
            var date;
            var name = $(this).find('.message-name').val();
            var type = $(this).find('.message-type').val();
            var placeholder = $(this).find('.message-placeholder').val();
            type = type.replace('string:','');
            if($(this).find('.message-multi').is(':checked')) {
                multi = true;
            }else{
                multi = false;
            };

            if($(this).find('.message-require').is(':checked')) {
                require = true;
            }else{
                require = false;
            };

            if($(this).find('.message-date').is(':checked')) {
                date = true;
            }else{
                date = false;
            };

            var data = {
                'name': name,
                'type': type,
                'placeholder' : placeholder,
                'multi': multi,
                'require': require,
                'date' : date
            };
            messageList.push(data);
        });
//        if(curr_sid == 4230){
//            console.log(messageList);
//            return ;
//        }
        var load_index = layer.load(2,
            {
                shade: [0.1,'#333'],
                time: 10*1000
            }
        );
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/train/saveCourse',
            'data'  : $('#course-form').serialize()+'&messageList='+JSON.stringify(messageList),//+'&outlineList='+JSON.stringify(outlineList)
            'dataType'  : 'json',
            'success'  : function(ret){
                layer.close(load_index);
                if(ret.ec == 200){
                    window.location.href='/wxapp/train/courseList';
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    }

    /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                $('#'+nowId).attr('src',allSrc[0]);
                if(nowId == 'upload-cover'){
                    $('#course_cover_img').val(allSrc[0]);
                }else if(nowId == 'upload-share-img'){
                    $('#course_share_img').val(allSrc[0]);
                }
            }else{
                var img_html = '';
                var cur_num = $('#'+nowId+'-num').val();
                for(var i=0 ; i< allSrc.length ; i++){
                    var key = i + parseInt(cur_num);
                    img_html += '<p>';
                    img_html += '<img class="img-thumbnail col" layer-src="'+allSrc[i]+'"  layer-pid="" src="'+allSrc[i]+'" >';
                    img_html += '<span class="delimg-btn">×</span>';
                    img_html += '<input type="hidden" id="slide_'+key+'" name="slide_'+key+'" value="'+allSrc[i]+'">';
                    img_html += '<input type="hidden" id="slide_id_'+key+'" name="slide_id_'+key+'" value="0">';
                    img_html += '</p>';
                }
                var now_num = parseInt(cur_num)+allSrc.length;
                if(now_num <= maxNum){
                    $('#'+nowId+'-num').val(now_num);
                    $('#'+nowId).prepend(img_html);
                }else{
                    layer.msg('幻灯图片最多'+maxNum+'张');
                }
            }
        }
    }

    $('.time').click(function(){
        WdatePicker({
            dateFmt:'yyyy-MM-dd',
        })
    });


</script>

