//ZeroClipboard.config(['ngClipProvider', function(ngClipProvider) {
//    ngClipProvider.setPath("/public/manage/vendor/ZeroClipboard.swf");
//}]);

//var shop_module = angular.module('Withdraw', ['RootModule']);
//
//shop_module.controller('WithdrawList', ['$scope', '$http', function($scope, $http) {
//    $('#myModal').modal('show');
//    $scope.showModel = function($event){
//        var target      = $event.target;
//        console.log(target);
//        $scope.hid_id   = target.getAttribute('data-id');
//
//    };
//
//    $scope.tip  = false;
//    $scope.saveDeal = function($event){
//        var id      = $scope.hid_id;
//        var status  = $scope.deal_status;
//        var note    = $scope.note;
//        if(id){
//            var data = {
//                id          : id,
//                'status'    : status,
//                'note'      : note
//            };
//            /*$http({
//                method  : 'post',
//                url     : '/manage/withdraw/dealApply',
//                data    : data
//            }).then(function(response){
//                if(response.data.ec == 200){
//                    window.location.reload();
//                }
//                fade_in_out_msg('saveResult',response.data.em,response.data.ec);
//            });*/
//
//        }
//
//
//    }
//
//}]);

function rollbackWithdraw(data){
    //遮挡，防止多次点击
    var index = layer.load(1, {
        shade: [0.1,'#fff'] //0.1透明度的白色背景
    },{time:10*1000});
    $.ajax({
        'type'  : 'post',
        'url'   : '/distrib/three/rollbackWithdraw',
        'data'  : data,
        'dataType'  : 'json',
        success : function(ret){
            layer.close(index);
            layer.msg(ret.em);
            if(ret.ec == 200){
                window.location.reload();

            }
        }

    })
}


