<link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
<style>
	.flex-wrap {
		display: flex; 
		align-items: center; 
		-webkit-align-items: center; 
		-moz-align-items: center; 
		-o-align-items: center; 
	}
	.flex-con {
		flex: 1; 
		-webkit-flex: 1; 
		-moz-flex: 1;
		-o-flex: 1; 
	}
    #change-color-box{
        padding: 10px;
        width: 300px;
        border-radius: 8px;
        box-shadow: 3px 3px 15px 0.5px #ccc;
    }
    #box-main{

    }
    #box-bottom{
        text-align: center;
    }
    .choose-row{
        border-radius: 8px;
        padding: 3px 1px;
        margin-bottom: 8px;
        cursor: pointer;
    }
    .choose-row-checked{
        border-radius: 8px;
        padding: 3px 1px;
        margin-bottom: 8px;
        cursor: pointer;
    }
    .choose-row-checked{
        background-color: #E3E3E3;
    }

    .row-title{
        display: inline-block;
        width: 40%;
        padding-left: 5px;
        font-size: 16px;
    }
    .row-select{
        display: inline-block;
        width: 59%;
    }
    /*扩大选择区域 隐藏边框*/
    .row-select .sp-replacer{
        width: auto !important;
        height: auto !important;
        /*border: none;*/
        /*background-color: transparent;*/
        margin: 4px;
        border-radius: 8px;
    }
    /*去掉选择箭头*/
    .row-select .sp-dd{
        display: none;
    }
    /*扩大预览区域 隐藏边框*/
    .row-select .sp-preview{
        height: 45px;
        width: 45px;
        border: none;
        margin: 0;
    }
    .color-div{
        width: 50px;
        height: 50px;
        display: inline-block;
        margin: 4px 6px 2px 6px;
        border-radius: 8px;
    }

    #example-box{
        width: 1150px;
        margin-left: 25px;
    }
    .payment-style{
        display: flex;
        width: 1700px;
        align-items: flex-start
    }
	
</style>
<div class="payment-style" ng-app="chApp" ng-controller="chCtrl" >
    <div id="change-color-box">
        <div id="box-mine">
            <div class="flex-wrap" ng-repeat="theme in themeColor track by $index" ng-class="{true:'choose-row-checked',false:'choose-row'}[theme.use]" ng-init="currindex=$index" ng-click="chooseTheme(currindex)">
                <div class="row-title" >
                    {{theme.title}}  <span ng-if="theme.use">（使用中）</span>
                </div>
                <div class="row-select" ng-if="theme.type == -1">
                    <input type="text" class="color-input" data-colortype="color1"  ng-model="theme.color1" data-currindex="{{currindex}}">
                    <input type="text" class="color-input" data-colortype="color2"  ng-model="theme.color2" data-currindex="{{currindex}}">
                </div>
                <div class="row-select" ng-if="theme.type != -1">
                    <div class="color-div" ng-style="{'background-color':theme.color1}">
                    </div>
                    <div class="color-div" ng-style="{'background-color':theme.color2}">
                    </div>
                </div>
            </div>
        </div>
        <div id="box-bottom">
            <button class="btn btn-sm btn-primary" style="margin: 10px auto;padding: 10px 25px" ng-click="saveData()">保存</button>
        </div>
    </div>

    <div id="example-box">
        <div class="example-row" ng-repeat="theme in themeColor track by $index" ng-show="theme.use" ng-init="customindex=$index" data-index="{{customindex}}">
            <img src="{{theme.example}}" alt="" style="width: 100%">
        </div>
    </div>

</div>

<script src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script src="/public/plugin/sortable/sortable.js"></script>
<script>

    var app = angular.module('chApp', ['RootModule',"ui.sortable"]);
    app.controller('chCtrl',['$scope','$http','$timeout', function($scope,$http,$timeout){
        $scope.themeColor = <{$themeColor}>;
        // $scope.customColor1 = '';
        // $scope.customColor2 = '';
        // $scope.useThemeIndex = '';

        $scope.initColor = function(obj,colorVal,type){
            obj.spectrum({
                color: colorVal,
                showButtons: false,
                showInput: true,
                showInitial: true,
                showPalette: true,
                showSelectionPalette: true,
                maxPaletteSize: 10,
                preferredFormat: "hex",
                move: function (color) {
                    var realColor = color.toHexString();
                    var colortype = $(obj)[0].dataset.colortype;
                    var currindex = $(obj)[0].dataset.currindex;
                    if(colortype == 'color1'){
                        $scope.themeColor[currindex].color1 = realColor;
                    }
                    if(colortype == 'color2'){
                        $scope.themeColor[currindex].color2 = realColor;
                    }

                },
                palette: [
                    ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)", "rgb(153, 153, 153)","rgb(183, 183, 183)",
                        "rgb(204, 204, 204)", "rgb(217, 217, 217)", "rgb(239, 239, 239)", "rgb(243, 243, 243)", "rgb(248, 248, 248)", "rgb(255, 255, 255)"],
                    ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
                        "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)", "rgb(0, 153, 255)"],
                    ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)",
                        "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)",
                        "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)",
                        "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)",
                        "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)",
                        "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
                        "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
                        "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
                        "rgb(133, 32, 12)", "rgb(153, 0, 0)", "rgb(180, 95, 6)", "rgb(191, 144, 0)", "rgb(56, 118, 29)",
                        "rgb(19, 79, 92)", "rgb(17, 85, 204)", "rgb(11, 83, 148)", "rgb(53, 28, 117)", "rgb(116, 27, 71)",
                        "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)",
                        "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
                ]
            });
        };

        $scope.chooseTheme = function(currindex){
            for(let i = 0;i<$scope.themeColor.length;i++){
                $scope.themeColor[i].use = false;
            }
            $scope.themeColor[currindex].use = true;
        }


        $scope.saveData = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });
            var data = {
                'data' :$scope.themeColor,
            };
            $http({
                method: 'POST',
                url:    '/wxapp/sequence/saveThemeColorCfg',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });

        };

        $(function(){
            $("input.color-input").each(function(index, el) {
                var obj = $(this);
                var type = obj.data('type');
                var val = obj.val();
                $scope.initColor(obj,val,type);
            });
        });
    }]);


</script>