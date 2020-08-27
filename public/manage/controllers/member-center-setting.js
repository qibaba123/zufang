var member_login_module = angular.module('CenterSetting', ['RootModule']);

member_login_module.controller('Center', ['$scope', '$http', function($scope, $http){



    $scope.recommend    = "<{$tpl['tc_level']}>";
    /*是否店长推荐*/
    $(".recommendChoose").on('click', 'input[type=radio]', function(event) {
        var val = $(this).parent("span").data("val");
        $scope.recommend = val;
        console.log($scope.recommend);
    });

    //设置提示
    $scope.tip  = false;
    $scope.saveSetting   = function() {
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        },{
            time : 10*1000
        });
        var refer = document.getElementById('cc_show_refer');
        var must  = document.getElementById('cc_must_set');
        var data = {
            'title' : $scope.title,
            'color' : $scope.font_color,
            'number': $scope.limitNumber,
            'money' : $scope.limitMoney,
            'tab1'  : $scope.tab1,
            'tab2'  : $scope.tab2,
            'tab3'  : $scope.tab3,
            'tab4'  : $scope.tab4,
            'refer' : refer.checked ? 1 : 0,
            'must'  : must.checked ? 1 : 0,
            'qrcode_bg' : document.getElementById('qrcode_bg').value,
            'center_bg' : document.getElementById('center_bg').value
        };
        $http({
            method: 'POST',
            url:    '/manage/three/saveCenter',
            data:   data
        }).then(function(response) {
            layer.close(index);
            layer.msg(response.data.em);
        });
    };
}]);