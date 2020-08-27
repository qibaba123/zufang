//ZeroClipboard.config(['ngClipProvider', function(ngClipProvider) {
//    ngClipProvider.setPath("/public/manage/vendor/ZeroClipboard.swf");
//}]);

var shop_module = angular.module('ShopIndex', ['RootModule']);

shop_module.controller('ShopOperController', ['$scope', '$http', function($scope, $http) {

}]);

shop_module.controller('ShopInfoController', ['$scope', '$http', function($scope, $http) {
    //有赞店铺授权
    $scope.youzanAction = function() {
        bootbox.dialog({
            message: "有赞店铺授权是否成功？",
            title: "提示",
            buttons: {
                success: {
                    label: "成功",
                    className: "btn-success",
                    callback: function() {

                    }
                },
                failure: {
                    label: "失败",
                    className: "btn",
                    callback: function() {

                    }
                }
            }
        });
    };
    $scope.hasChange = 0;
    $scope.showModel = function($event){
        var target = $event.target;
        if(target.getAttribute('data-id')){
            var type = target.getAttribute('data-type');

            $scope.shop_id      = target.getAttribute('data-id');
            $scope.quantity     = target.getAttribute('data-name');
            $scope.shop_name    = target.getAttribute('data-name');
            $scope.shop_contact = target.getAttribute('data-contact');
            $scope.shop_phone   = target.getAttribute('data-phone');
            $scope.shop_url     = target.getAttribute('data-url');
            $scope.user_center  = target.getAttribute('data-user-center');


            $scope.first_ratio  = target.getAttribute('data-first');
            $scope.second_ratio = target.getAttribute('data-second');
            $scope.third_ratio  = target.getAttribute('data-third');
            $scope.shop_follow  = target.getAttribute('data-follow');

            $scope.wx_app_id    = target.getAttribute('data-wx-appid');
            $scope.wx_app_secret= target.getAttribute('data-wx-appsecret');
            $scope.wx_token     = target.getAttribute('data-wx-token');
            $scope.wx_call_back = target.getAttribute('data-wx-call-back');
            $scope.wx_name      = target.getAttribute('data-wx-name');
            $scope.wx_id        = target.getAttribute('data-wx-id');
            $scope.wx_no        = target.getAttribute('data-wx-no');

            $scope.app_id       = target.getAttribute('data-appid');
            $scope.app_secret   = target.getAttribute('data-appsecret');
            $('#modal-info-form').modal('show');
        }
    };
    $scope.tip  = false;
    $scope.saveShop = function() {
        var data = {
            'shopId'      : $scope.shop_id,
            'name'        : $scope.shop_name,
            'contact'     : $scope.shop_contact,
            'phone'       : $scope.shop_phone,
            'url'         : $scope.shop_url,
            'first_ratio' : $scope.first_ratio,
            'second_ratio': $scope.second_ratio,
            'third_ratio' : $scope.third_ratio,
            'follow'      : $scope.shop_follow,
            'app_id'      : $scope.app_id,
            'app_secret'  : $scope.app_secret,

            'wx_app_id'   : $scope.wx_app_id,
            'wx_app_secret': $scope.wx_app_secret,
            'wx_name'     : $scope.wx_name,
            'wx_id'       : $scope.wx_id,
            'wx_no'       : $scope.wx_no

        };
        $http({
            method: 'POST',
            url:    '/manage/shop/saveShop',
            data:   data,
            dataType : 'json'
        }).then(function(response) {
            if(response.data.ec == 200){
                $('#hasChange').val(1);
            }
            fade_in_out_msg('saveResult',response.data.em,response.data.ec);
        });

    };
}]);




