var member_login_module = angular.module('MemberLogin', ['RootModule']);

member_login_module.controller('MemberLoginController', ['$scope', '$http', function($scope, $http){
    //设置提示
    $scope.tip  = false;
    $scope.remember = 1;//设置记住账号，默认选中

    $scope.loginAction   = function() {
        $scope.tip  = '登录中，请稍候...';

        var data = {
            'mobile'    : $scope.mobile,
            'password'  : $scope.password,
            'remember'  : $scope.remember,
            'from'      : from
        };
        $http({
            method    : 'POST',
            url       : '/index/auth',
            data      :  data
        }).then(function(response) {
            if (response.data.ec == 200) {
                window.location.replace(response.data.data.url);
            } else {
                $scope.tip = response.data.em;
            }
        });
    };
}]);
