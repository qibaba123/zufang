var member_login_module = angular.module('MemberLogin', ['RootModule']);

member_login_module.controller('MemberRegisterController', ['$scope', '$http', '$timeout', function($scope, $http, $timeout) {
    //设置提示
    //$scope.tip  = false;
    $scope.tip  = "";//天店通 - 做生意，更容易

    $scope.interval = 0;
    $scope.inputDisabled = false;
    $scope.sign = 0;
    $scope.timestamp = 0;

    $scope.fetchCode        = function() {
        if ($scope.inputDisabled) {
            return;
        }
        if (!$scope.mobile) {
            $scope.tip = '请输入正确的手机号';
            return;
        }
        if (!$scope.imgCode) {
            $scope.tip = '请输入图片验证码';
            return;
        }
        $scope.inputDisabled = true;
        $('.code').val('发送中')
            .css('background-color', '#ccc')
            .css('color', '#fff');

        var data = {
            'mobile'    : $scope.mobile,
            'code'      : $scope.imgCode,
            'type'      : 'register'
        };
        $http({
            method: 'POST',
            url:    '/manage/user/sendCode',
            data:   data
        }).then(function(response) {
            if (response.data.ec == 200) {
                $scope.sign     = response.data.data.sign;
                $scope.timestamp    = response.data.data.timestamp;
                var intTime = 60;
                $scope.interval = window.setInterval(function() {
                    intTime--;
                    if (intTime > 0) {
                        $('.code').val('重新发送('+intTime+')')
                            .css('background-color', '#ccc')
                            .css('color', '#fff');
                    } else {
                        window.clearInterval($scope.interval);
                        $('.code').val('获取验证码')
                            .css('background-color', '#FFA74E')
                            .css('color', '#fff');
                        $scope.inputDisabled = false;
                    }
                }, 1000);
                $scope.tip = '验证码已发送';
            } else {
                $scope.tip = response.data.em;
                $(".get-code").attr("src",'/manage/user/validate&random='+Math.random());
                $('.code').val('获取验证码')
                    .css('background-color', '#FFA74E')
                    .css('color', '#fff');
                $scope.inputDisabled = false;
                console.log(13333323456);
            }
        });
    };

    $scope.keyEvent         = function() {
        window.clearInterval($scope.interval);
        $('.code').val('获取验证码')
            .css('background-color', '#FFA74E')
            .css('color', '#fff');
        $scope.inputDisabled = false;
    };

    $scope.registerAction   = function() {
        $scope.tip  = '注册中，请稍候...';
        var cityprovBox = $("#city_choose");
        var province = cityprovBox.find('.prov').val();
        var city = cityprovBox.find('.city').val();
        var registerType = $('#registerType').val();
        var data = {
            'company'   : $scope.nickname,
            'mobile'    : $scope.mobile,
            'nickname'  : $scope.nickname,
            'password'  : $scope.password,
            'sign'      : $scope.sign,
            'timestamp' : $scope.timestamp,
            'code'      : $scope.code,
            'province'  : province,
            'city'      : city,
            'type'      : registerType
        };
        $http({
            method: 'POST',
            url:    '/manage/user/register',
            data:   data
        }).then(function(response) {
            if (response.data.ec == 200) {
                $scope.company  = '';
                $scope.mobile   = '';
                $scope.nickname = '';
                $scope.password = '';
                $scope.sign     = '';
                $scope.code     = '';
                $scope.tip  = response.data.data.status;
                $timeout(function () {
                    jQuery('.widget-box.visible').removeClass('visible');
                    jQuery('#login-box').addClass('visible');
                }, 1000);
            } else {
                $scope.tip = response.data.em;
            }
        });
    };
}]);

member_login_module.controller('MemberLoginController', ['$scope', '$http', function($scope, $http){
    //设置提示
    $scope.tip  = false;
    $scope.remember = 1;//设置记住账号，默认选中

    $scope.loginAction   = function() {
        $scope.tip  = '登录中，请稍候...';

        var data = {
            'mobile'    : $scope.mobile,
            'password'  : $scope.password,
            'remember'  : $scope.remember
        };
        $http({
            method: 'POST',
            url:    '/manage/user/login',
            data:   data
        }).then(function(response) {
            if (response.data.ec == 200) {
                $scope.tip  = response.data.data.status;
                window.location.replace(response.data.data.redirect_url);
            } else {
                $scope.tip = response.data.em;
            }
        });
    };
}]);

member_login_module.controller('MemberForgetController', ['$scope', '$http', function($scope, $http, $timeout){
    //设置提示
    $scope.tip  = false;
    $scope.interval = 0;
    $scope.inputDisabled = false;
    $scope.sign = 0;
    $scope.timestamp = 0;

    $scope.fetchCode        = function() {
        if ($scope.inputDisabled) {
            return;
        }
        if (!$scope.mobile) {
            $scope.tip = '请输入正确的手机号';
            return;
        }
        if (!$scope.imgCode) {
            $scope.tip = '请输入图片验证码';
            return;
        }
        $scope.inputDisabled = true;
        $('.code').val('发送中')
            //.css('background-color', 'gray')
            //.css('color', 'black');
            .css('color', 'gray');

        var data = {
            'mobile'    : $scope.mobile,
            'code'      : $scope.imgCode,
            'type'      : 'forget'
        };
        $http({
            method: 'POST',
            url:    '/manage/user/sendCode',
            data:   data
        }).then(function(response) {
            if (response.data.ec == 200) {
                $scope.sign     = response.data.data.sign;
                $scope.timestamp    = response.data.data.timestamp;
                var intTime = 60;
                $scope.interval = window.setInterval(function() {
                    intTime--;
                    if (intTime > 0) {
                        $('.code').val('重新发送('+intTime+')')
                            //.css('background-color', '#ccc')
                            //.css('color', '#fff');
                            .css('color', 'gray');
                    } else {
                        window.clearInterval($scope.interval);
                        $('.code').val('获取验证码')
                            //.css('background-color', '#FFA74E')
                            //.css('color', '#fff');
                            .css('color', '#2993ff');
                        $scope.inputDisabled = false;
                    }
                }, 1000);
                $scope.tip = '验证码已发送';
            } else {
                $scope.tip = response.data.em;
                $('.code').val('获取验证码')
                    //.css('background-color', '#FFA74E')
                    //.css('color', '#fff');
                    .css('color', '#2993ff');
                $scope.inputDisabled = false;
            }
        });
    };

    $scope.keyEvent         = function() {
        window.clearInterval($scope.interval);
        $('.code').val('获取验证码')
            //.css('background-color', '#FFA74E')
            //.css('color', '#fff');
            .css('color', '#2993ff');
        $scope.inputDisabled = false;
    };

    $scope.forgetAction   = function() {
        if ($scope.password != $scope.repwd) {
            $scope.tip  = '设置密码与确认密码不一致，请核实';
            return false;
        }

        $scope.tip  = '密码重置中，请稍候...';

        var data = {
            'mobile'    : $scope.mobile,
            'password'  : $scope.password,
            'sign'      : $scope.sign,
            'timestamp' : $scope.timestamp,
            'code'      : $scope.code
        };
        $http({
            method: 'POST',
            url:    '/manage/user/forget',
            data:   data
        }).then(function(response) {
            if (response.data.ec == 200) {
                $scope.mobile   = '';
                $scope.password = '';
                $scope.sign     = '';
                $scope.code     = '';
                $scope.repwd    = '';
                $scope.imgCode  = '';
                $scope.tip  = response.data.data.status;
                $timeout(function () {
                    jQuery('.widget-box.visible').removeClass('visible');
                    jQuery('#login-box').addClass('visible');
                }, 2000);
            } else {
                $scope.tip = response.data.em;
            }
        });
    };
}]);