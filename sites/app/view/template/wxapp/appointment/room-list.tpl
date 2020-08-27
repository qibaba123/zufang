<link rel="stylesheet" href="/public/manage/css/deduct.css" />
<div  id="mainContent">
    <div class="row" ng-app="ShopIndex" ng-controller="ShopInfoController">
        <div class="col-sm-12" style="margin-bottom: 20px;">
            <button class="btn btn-green" ng-click="add()" data-target="#modal-info-form">
                <i class="icon-plus bigger-80"></i> 添 加
            </button>
        </div>
        <div id="modal-info-form" class="modal fade" tabindex="-1">
            <div class="modal-dialog" style="width:450px;;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="blue bigger">包间设置</h4>
                    </div>

                    <div class="modal-body" style="overflow: hidden;">
                        <!-- <input type="hidden" class="form-control" ng-model="shop_id" > -->
                        <div class="col-sm-12" style="margin-bottom: 20px;">
                            <div class="tab-content">
                                <!--店铺基本信息-->
                                <div id="home" class="tab-pane in active">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon input-group-addon-title">包间名</div>
                                            <input type="text" class="form-control" ng-model="table" placeholder="例如：206厅或玫瑰厅">
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon input-group-addon-title">适合多少人</div>
                                            <input type="text" class="form-control" ng-model="table_fit" placeholder="例如：适合6-8人">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="left" style="text-align: center;">
                                            <button class="btn btn-sm btn-primary"  ng-click="save()"> &nbsp; 保 &nbsp; 存 &nbsp; </button>
                                        </div>
                                        <div class="right">
                                            <input type="hidden" name="deduct_id" id="deduct_id" value="0"/>
                                            <div id="saveResult" class="col-sm-9" style="text-align: center;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- PAGE CONTENT ENDS -->
        <!-- 列表 展示 -->
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="sample-table-1" class="table table-striped table-hover table-button">
                    <thead>
                    <tr>
                        <th class="center">
                            <label>
                                <input type="checkbox" class="ace" id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                <span class="lbl"></span>
                            </label>
                        </th>
                        <th>包间名</th>
                        <th>适合多少人</th>
                        <th>二维码</th>
                        <th>
                            <i class="icon-time bigger-110 hidden-480"></i>
                            更新时间
                        </th>
                        <th>操作</th>
                    </tr>
                    </thead>

                    <tbody>
                    <{foreach $list as $item}>
                        <tr id="tr_<{$item['amt_id']}>">
                            <td class="center">
                                <label>
                                    <input type="checkbox" class="ace" name="ids"  value="<{$val['s_id']}>"/>
                                    <span class="lbl"></span>
                                </label>
                            </td>
                            <td><{$item['amt_table']}></td>
                            <td><{$item['amt_table_fit']}></td>
                            <td>
                                <img class="img-thumbnail" width="80" src="<{$item['amt_applet_code']}>" />
                            </td>
                            <td><{date('Y-m-d H:i:s',$item['amt_create_time'])}></td>
                            <td>
                                <a href="javascript:;" ng-click="edit($event)"
                                   data-id="<{$item['amt_id']}>"
                                   data-table="<{$item['amt_table']}>"
                                   data-table-fit="<{$item['amt_table_fit']}>"
                                   role="button" data-toggle="modal">修改-</a>

                                <a href="javascript:;" ng-click="del($event)"
                                   data-id="<{$item['amt_id']}>"
                                   role="button">删除--</a>
                                <a href="/wxapp/meal/downloadTableQrcode/tableId/<{$item['amt_id']}>">下载二维码</a>
                            </td>
                        </tr>
                        <{/foreach}>
                    </tbody>
                </table>
                <{$page_html}>
            </div><!-- /.table-responsive -->
        </div><!-- /span -->
    </div>
</div>

<script type="text/javascript" src="/public/manage/vendor/angular.min.js"></script>
<script type="text/javascript" src="/public/manage/vendor/angular-root.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>
    var shop_module = angular.module('ShopIndex', ['RootModule']);

    shop_module.controller('ShopInfoController', ['$scope', '$http', function($scope, $http) {
        $scope.edit = function($event){
            var target = $event.target;
            if(target.getAttribute('data-id')){
                $scope.table_id   = target.getAttribute('data-id');
                $scope.table       = target.getAttribute('data-table');
                $scope.table_fit   = target.getAttribute('data-table-fit');
            }
            $('#modal-info-form').modal('show');
        };
        $scope.add = function(){
            $scope.table_id    = 0;
            $scope.table      = '';
            $scope.table_fit     = '';
            $('#modal-info-form').modal('show');
        };
        $scope.tip  = false;
        $scope.save = function() {
            if($scope.table){
                var data = {
                    'tableId'    : $scope.table_id,
                    'table'      : $scope.table,
                    'table_fit'  : $scope.table_fit
                };
                $http({
                    method   : 'POST',
                    url      :  '/wxapp/meal/saveTable',
                    data     :   data,
                    dataType : 'json'
                }).then(function(response) {
                    layer.msg(response.data.em);
                    if(response.data.ec == 200){
                        window.location.reload();
                    }
                });
            }else{
                layer.msg('请完善数据');
            }
        };
        $scope.del = function($event) {
            var target = $event.target;
            var id = target.getAttribute('data-id');
            if(id){
                var data = {
                    'tableId'    : id
                };
                $http({
                    method   : 'POST',
                    url      : '/wxapp/meal/delTable',
                    data     : data,
                    dataType : 'json'
                }).then(function(response) {
                    layer.msg(response.data.em);
                    if(response.data.ec == 200){
                        document.getElementById('tr_'+id).style.display='none';
                    }
                });
            }else{
                layer.msg('请完善数据');
            }


        };

    }]);
</script>

