var member_login_module = angular.module('powderNewsAdd', ['RootModule']);

member_login_module.controller('add', ['$scope', '$http', function($scope, $http){
    //设置提示
    $scope.saveSource   = function() {
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        },{
            time : 10*1000
        });
        var cover = document.getElementById('source_image').value;
        var data = {
            'title' : $scope.title,
            'image' : cover,
            'content': $scope.contxt,
            'id'    : $scope.hid_id
        };
        $http({
            method  :  'POST',
            url     :  '/manage/powder/saveSource',
            data    :  data,
            dataType: 'json'
        }).then(function(response) {
            layer.close(index);
            layer.msg(response.data.em);
            if(response.data.ec == 200) window.location.href='/manage/powder/news/source/list';
        });
    };
}]);