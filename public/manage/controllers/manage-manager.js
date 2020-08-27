var manage_manager_module = angular.module('ManagerIndex', ['RootModule']);
manage_manager_module.controller('managerList', ['$scope', '$http', function($scope, $http) {
    $scope.showAddModel = function(){
        //$('#modal-info-form').modal('show');
        $scope.hid_id    = 0;
        $scope.nickname  = '';
        $scope.mobile    = '';
        $('#modal-info-form').modal('show');

    };
    //编辑和修改
    $scope.showModel = function($event){
        var target = $event.target;
        if(target.getAttribute('data-id')){
            $scope.hid_id    = target.getAttribute('data-id');
            $scope.nickname  = target.getAttribute('data-name');
            $scope.mobile    = target.getAttribute('data-mobile');
            $scope.sex       = target.getAttribute('data-sex');
            $('#modal-info-form').modal('show');
        }
    };
    //保存
    $scope.tip  = false;
    $scope.saveManager = function() {
        var pattern = /^1[23456789]\d{9}$/;
        if (!pattern.test($scope.mobile)) {
            $scope.tip  = '请输入有效的手机号';
            return false;
        }

        $scope.tip  = '注册中，请稍候...';

        var data = {
            'id'   : $scope.hid_id,
            'mobile'    : $scope.mobile,
            'nickname'  : $scope.nickname,
            'password'  : $scope.password,
            'sex'       : $scope.sex
        };
        console.log(data);
        $http({
            method: 'POST',
            url:    '/manage/manager/saveManager',
            data:   data
        }).then(function(response) {
            $scope.tip  = response.data.em;
            console.log(response.data);
            if (response.data.ec == 200) {
                window.location.reload();
            }
        });
    };
    //删除
    $scope.deleteManager = function(mid){
        if(mid){
            var data = {
                'id'   : mid
            };
            $http({
                method: 'POST',
                url:    '/manage/manager/deleteManager',
                data:   data
            }).then(function(response) {
                if (response.data.ec == 200) {
                    $('#tr_id_'+mid).hide();
                } else {
                    $scope.tip  = response.data.em;
                }
            });
        }
    };
}]);

