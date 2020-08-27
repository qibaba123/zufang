//ZeroClipboard.config(['ngClipProvider', function(ngClipProvider) {
//    ngClipProvider.setPath("/public/manage/vendor/ZeroClipboard.swf");
//}]);

var shop_module = angular.module('ShopIndex', ['RootModule']);

shop_module.controller('ShopInfoController', ['$scope', '$http', function($scope, $http) {
    $scope.edit = function($event){
        var target = $event.target;
        if(target.getAttribute('data-id')){
            var type = target.getAttribute('data-type');
            $scope.deduct_id    = target.getAttribute('data-id');
            $scope.buy_num      = target.getAttribute('data-num');
            $scope.back_num     = target.getAttribute('data-back-num');
            $scope.ratio        = target.getAttribute('data-ratio');
            $scope.first_ratio  = target.getAttribute('data-f-ratio');
            $scope.second_ratio = target.getAttribute('data-ff-ratio');
            $scope.third_ratio  = target.getAttribute('data-fff-ratio');
        }
        $('#modal-info-form').modal('show');
    };
    $scope.add = function(){
        $scope.deduct_id    = 0;
        $scope.buy_num      = '';
        $scope.back_num     = '';
        $scope.ratio        = '';
        $scope.first_ratio  = '';
        $scope.second_ratio = '';
        $scope.third_ratio  = '';
        $('#modal-info-form').modal('show');
    };
    $scope.tip  = false;
    $scope.save = function() {
        if($scope.buy_num && ($scope.ratio || $scope.first_ratio || $scope.second_ratio || $scope.third_ratio)){
            var data = {
                'deductId'    : $scope.deduct_id,
                'buy_num'     : $scope.buy_num,
                'back_num'    : $scope.back_num, //后台暂定废弃
                'ratio0'      : $scope.ratio,
                'ratio1'      : $scope.first_ratio,
                'ratio2'      : $scope.second_ratio,
                'ratio3'      : $scope.third_ratio
            };
            $http({
                method   : 'POST',
                url      :    '/manage/three/saveDeduct',
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
                'deductId'    : id
            };
            $http({
                method   : 'POST',
                url      : '/manage/three/delDeduct',
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




