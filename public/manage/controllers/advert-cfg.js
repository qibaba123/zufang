var member_login_module = angular.module('Advert', ['RootModule']);

member_login_module.controller('AdvertCfg', ['$scope', '$http', function($scope, $http){
    //设置提示
    $scope.saveCfg   = function() {
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        },{
            time : 10*1000
        });
        var data = {
            'bg'   	 : document.getElementById('bg_image').value,
            'company': $scope.company,
            'address': $scope.address,
            'phone'  : $scope.phone,
            'contact': $scope.contact,
            'qrcode' :document.getElementById('ac_qrcode').value
        };
        console.log(data);
        $http({
            method: 'POST',
            url:    '/manage/advert/cfg',
            data:   data
        }).then(function(response) {
            layer.close(index);
            layer.msg(response.data.em);
        });
    };
}]);