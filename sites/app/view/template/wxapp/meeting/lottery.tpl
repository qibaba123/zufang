<link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/index/temp9/css/index.css?5">
<link rel="stylesheet" href="/public/wxapp/index/temp9/css/style.css?1">
<style>
	/*.index-con .index-main {
		background-color: #e94949;
	}
	.service-wrap {
		padding: 15px;
		background-color: #e94949;
		margin-bottom: 0;
		border-radius: 22px;
	}
	.banner-manage .edit-img {
		background-color: #fff;
	}

	.lottery-box{
		background: url(/public/wxapp/meeting/images/lottery-bg.png) no-repeat;
		background-size: 100%;
		padding: 24px;
		border-radius: 20px;
		padding-top: 19px;
	}

	.article-con img{
		width: 100%;
	}
*/
    .index-con .index-main {
        background-color: #7254a7;
    }
    .service-wrap {
        padding: 15px;
        background-color: #7254a7;
        margin-bottom: 0;
        /*border-radius: 22px;*/
    }
    .banner-manage .edit-img {
        background-color: #fff;
    }

    .lottery-box{
        background: url(/public/wxapp/meeting/images/lottary-new.png) no-repeat;
        background-size: 100%;
        padding: 24px;
        border-radius: 20px;
        padding-top: 19px;
    }

    .article-con img{
        width: 100%;
    }
    div[data-left-preview].cur-edit::after, div[data-left-preview].cur-edit:hover::after{
        border:2px dashed #670a77 ;
    }
</style>
<{include file="../article-kind-editor.tpl"}>
<div class="preview-page" ng-app="chApp" ng-controller="chCtrl">
	<div class="mobile-page">
		<div class="mobile-header"></div>
		<div class="mobile-con">
			<div class="title-bar cur-edit">
				抽奖活动
			</div>
			<!-- 主体内容部分 -->
			<div class="index-con">
				<!-- 首页主题内容 -->
				<div class="index-main">
					<div class="service-wrap cur-edit" data-left-preview data-id="1">
						<div class="lottery-box">
							<div style="width: 27%;display: inline-block;margin: 5px;box-shadow: 0px 5px 0px #e07bcb;border-radius: 6px">
								<img ng-src="{{showGoodsList[0].img}}" alt="" style="width: 100%;border-radius: 6px"/>
							</div>
							<div style="width: 27%;display: inline-block;margin: 5px;box-shadow: 0px 5px 0px #e07bcb;border-radius: 6px">
								<img ng-src="{{showGoodsList[1].img}}" alt="" style="width: 100%;border-radius: 6px"/>
							</div>
							<div style="width: 27%;display: inline-block;margin: 5px;box-shadow: 0px 5px 0px #e07bcb;border-radius: 6px">
								<img ng-src="{{showGoodsList[2].img}}" alt="" style="width: 100%;border-radius: 6px"/>
							</div>
							<div style="width: 27%;display: inline-block;margin: 5px;box-shadow: 0px 5px 0px #e07bcb;border-radius: 6px">
								<img ng-src="{{showGoodsList[8].img}}" alt="" style="width: 100%;border-radius: 6px"/>
							</div>
							<div style="width: 27%;display: inline-block;margin: 5px;box-shadow: 0px 5px 0px #e07bcb;border-radius: 6px">
								<img ng-src="{{showGoodsList[4].img}}" alt="" style="width: 100%;border-radius: 6px"/>
							</div>
							<div style="width: 27%;display: inline-block;margin: 5px;box-shadow: 0px 5px 0px #e07bcb;border-radius: 6px">
								<img ng-src="{{showGoodsList[3].img}}" alt="" style="width: 100%;border-radius: 6px"/>
							</div>
							<div style="width: 27%;display: inline-block;margin: 5px;box-shadow: 0px 5px 0px #e07bcb;border-radius: 6px">
								<img ng-src="{{showGoodsList[7].img}}" alt="" style="width: 100%;border-radius: 6px"/>
							</div>
							<div style="width: 27%;display: inline-block;margin: 5px;box-shadow: 0px 5px 0px #e07bcb;border-radius: 6px">
								<img ng-src="{{showGoodsList[6].img}}" alt="" style="width: 100%;border-radius: 6px"/>
							</div>
							<div style="width: 27%;display: inline-block;margin: 5px;box-shadow: 0px 5px 0px #e07bcb;border-radius: 6px">
								<img ng-src="{{showGoodsList[5].img}}" alt="" style="width: 100%;border-radius: 6px"/>
							</div>
						</div>
					</div>
					<div class="service-wrap" data-left-preview data-id="2">
						<div style="color: gold">抽奖规则（点击操作此区域）:</div>
						<div class="article-con" id="article-con" style="min-height: 100px;color: #fff">
							<{$row['amll_rule']}>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="mobile-footer"><span></span></div>
	</div>
	<div class="edit-right">
		<div class="edit-con">
			<div class="banner" data-right-edit data-id="1" ng-model="goodsList"  style="display: block;">
				<label style="width: 100%">奖品管理<span>(图片尺寸：200px*200px)</span></label>
				<div class="input-groups" style="margin-top: 10px;margin-bottom:15px">
					<label for="" style="margin-right: 10px">中奖率：中奖率的计算方式为当前奖品数量/（奖品总数量+未中奖总数量）；例如：奖品一5个，奖品二10个，奖品三35，其余5个设置为未中奖总数为950个则：总的中奖概率为（5+10+35）/(5+10+35+950)=5%,奖品一的中奖概率为5/(5+10+35+950)=0.5%；未中奖数量一定要设置</label>
				</div>
				<div class="banner-manage" ng-repeat="goods in goodsList">
					<div class="edit-img">
						<div style="text-align: center">
							<img  data-limit="8" onload="changeSrc(this)"  data-width="200" data-height="200" imageonload="doThis('goodsList',{{$index}})" data-dom-id="upload-goodsList{{$index}}" id="upload-goodsList{{$index}}"  ng-src="{{goods.img}}"  height="100%" style="width:100px;display:inline-block;margin-left:0;">
							<input type="hidden" id="goodsList"  class="avatar-field bg-img" name="goodsList" ng-value="goods.img"/>
						</div>
					</div>
					<div class="edit-txt" style="margin-top: 15px">
						<div class="input-group-box">
							<label for="" style="display: inline-block; width: 20%;">类型：</label>
							<select style="display: inline-block; width: 79%;" ng-change="changeType({{$index}})" class="cus-input" ng-model="goods.type" ng-options="x.id as x.name for x in type"></select>
						</div>
						<!--<div class="input-group-box no-prize"  style="margin-top: 10px;" ng-show="goods.type=='2'">
							<label for="" style="display: inline-block; width: 20%;">奖品名称：</label>
							<input style="display: inline-block; width: 79%;" type="text" class="cus-input" ng-disabled="goods.type=='2'" ng-model="goods.name">
						</div>-->
						<div class="input-group-box has-prize"  style="margin-top: 10px;" ng-show="goods.type==1">
							<label for="" style="display: inline-block; width: 20%;">奖品选择：</label>
							<select style="display: inline-block; width: 79%;" ng-change="changeImg({{$index}})"  class="cus-input" ng-model="goods.pid" ng-options="x.id as x.name for x in prizeList"></select>
							<input style="display: inline-block;  width: 79%;" type="hidden" class="cus-input"  ng-model="goods.name">
						</div>
						<div class="input-group-box" style="margin-top: 10px">
							<label for="" style="display: inline-block; width: 20%;">商品数量：</label>
							<input style="display: inline-block; width: 79%;" type="text" class="cus-input" ng-model="goods.num">
						</div>
					</div>
				</div>
			</div>
			<div data-right-edit data-id="2">
				<div>
					<div class="input-groups" style="margin-top: 10px;margin-bottom:15px">
						<label for="" style="margin-right: 10px">每天转发赠送次数</label>
						<input type="number" id="shareGive" placeholder="请输入抽奖次数" maxlength="10" value="<{$row['amll_share_give']}>" style="border: 1px solid #ddd;padding: 0 10px;">
						<label for="">（每人每天转发可获得抽奖次数，0表示转发不赠送抽奖次数）</label>
					</div>
					<div class="input-groups" style="margin-top: 10px;margin-bottom:15px">
						<label for="" style="margin-right: 10px">抽奖次数</label>
						<input type="number" id="frequency" placeholder="请输入抽奖次数" maxlength="10" <{if $row['amll_status'] == 1}>disabled="disabled"<{/if}> value="<{$row['amll_frequency']}>" style="border: 1px solid #ddd;padding: 0 10px;">
						<label for="">（每人可抽奖次数）</label>
						<p style="color: red">注：活动开始后，不可修改</p>
					</div>
					<div class="input-groups" style="margin-top: 10px;margin-bottom:15px">
						<label for="" style="margin-right: 10px">是否开启积分兑换次数</label>
						<span class='tg-list-item'>
                                <input class='tgl tgl-light' id='points_open' type='checkbox' ng-model="pointsOpen">
                                <label class='tgl-btn' for='points_open' style="width: 56px;"></label>
						</span>
					</div>
					<div class="input-groups" style="margin-top: 10px;margin-bottom:15px">
						<label for="" style="margin-right: 10px">积分兑换</label>
						<input type="number" id="change-points" placeholder="请输入兑换一次抽奖所需积分" maxlength="10" value="<{$row['amll_change_points']}>" style="border: 1px solid #ddd;padding: 0 10px;">
						<label for="">（兑换一次抽奖次数所需积分）</label>
					</div>
					<div class="form-textarea">
						<textarea class="form-control" style="width:100%;height:350px;visibility:hidden;text-align: left; resize:vertical;"  id="content-detail" name="article-detail" placeholder="文章内容"  rows="20"><{$row['amll_rule']}></textarea>
						<input type="hidden" name="sub_dir" id="sub-dir" value="default" />
						<input type="hidden" name="ke_textarea_name" value="article-detail" />
					</div>
				</div>
			</div>

		</div>
	</div>
	<div class="alert alert-warning save-btn-box" role="alert"><button class="btn btn-blue btn-sm" ng-click="saveData()">  保 存 </button></div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>

<script>
	var app = angular.module('chApp', ['RootModule']);
	app.controller('chCtrl', ['$scope','$http','$timeout',function($scope,$http,$timeout){
		$scope.goodsList     = <{$goodsList}>;
		$scope.showGoodsList = <{$goodsList}>;
		$scope.prizeList     = <{$prizeList}>;
		$scope.pointsOpen    = <{$row['amll_points_open']}> ? true : false ;
		var start = {
			'img': '/public/wxapp/meeting/images/start.png'
		};
		$scope.showGoodsList.splice(4, 0,start);
		$scope.type = [{
			'id': '1',
			'name': '奖品'
		},{
			'id': '2',
			'name': '未中奖'
		}];


	    $scope.tpl_id		= '<{$tpl['ami_tpl_id']}>';

		$scope.changeType=function(index){
			if($scope.goodsList[index].type == '2'){
				$scope.goodsList[index].name = '谢谢惠顾';
				$scope.goodsList[index].pid  = '0';

				$scope.goodsList[index].img = '/public/wxapp/meeting/images/no-lettery-new.png';



			}
		};

	    $scope.doThis=function(type,index){
	    	var typeArr = type.split('.');
            var realIndex=-1;
            /*获取要删除的真正索引*/
            // console.log($scope[type][realIndex].imgsrc);
            //console.log($scope[type][realIndex].imgsrc);
            if(typeArr.length>1){
            	realIndex = $scope.getRealIndex($scope[typeArr[0]][typeArr[1]],index);
            	$scope[typeArr[0]][typeArr[1]][realIndex].img = imgNowsrc;
            }else{
            	realIndex = $scope.getRealIndex($scope[typeArr[0]],index);
            	$scope[typeArr[0]][realIndex].img = imgNowsrc;
            }

			if(realIndex < 4){
				$scope.showGoodsList[realIndex].img=imgNowsrc;
			}else{
				$scope.showGoodsList[(realIndex+1)].img=imgNowsrc;
			}

        };

        $scope.changeBg=function(){
            if(imgNowsrc){
                $scope.bottomImg = imgNowsrc;
            }
        };


	    /*获取真正索引*/
	    $scope.getRealIndex = function(type,index){
	        var resultIndex = -1;
	        for(var i=0;i<type.length;i++){
	            if(type[i].index==index){
	                resultIndex = i;
	                break;
	            }
	        }
	        return resultIndex;
	    }

	    /*删除元素*/
	    $scope.delIndex=function(type,index,parentType){
	        var realIndex=-1;
	        /*获取要删除的真正索引*/
	        if(parentType){
	        	realIndex = $scope.getRealIndex($scope[parentType][type],index);
	        }else{
	        	realIndex = $scope.getRealIndex($scope[type],index);
	        }
	        
	        
	        console.log(type+"-->"+realIndex);
	        layer.confirm('您确定要删除吗？', {
	            title:'删除提示',
	            btn: ['确定','取消'] 
	        }, function(){
	            if(parentType){
			        $scope.$apply(function(){
		                $scope[parentType][type].splice(realIndex,1);
		            });
			    }else{
			        $scope.$apply(function(){
		                $scope[type].splice(realIndex,1);
		            });
			    }
	            layer.msg('删除成功');
	        });
	        console.log($scope.appointInfo);
	    }
         // 保存数据
        $scope.saveData = function(){
        	layer.confirm('确定要保存吗？', {
	            btn: ['确定','取消'] //按钮
	        }, function(){
	           var index = layer.load(1, {
	                shade: [0.1,'#fff'] //0.1透明度的白色背景
	            },{
	                time : 10*1000
	            });
	
	            var data = {
					'id' : '<{$id}>',
					'rule'     : $('#content-detail').val(),
					'goodsList': $scope.goodsList,
					'number':$('#frequency').val(),
					'points':$('#change-points').val(),
					'give':$('#shareGive').val(),
					'pointOpen' : $scope.pointsOpen == true ?1:0
	            };
	            console.log(data);
	            $http({
	                method: 'POST',
	                url:    '/wxapp/meeting/saveRule',
	                data:   data
	            }).then(function(response) {
	                layer.close(index);
	                layer.msg(response.data.em);
					//window.location.href='/wxapp/meeting/lotteryList';
	            }); 
	        });
            
        };

		$scope.changeImg = function(index){
			var prizeId  = $scope.goodsList[index].pid;
			for(var i=0;i<$scope.prizeList.length;i++){
				if($scope.prizeList[i].id == prizeId){
					$scope.goodsList[index].img  = $scope.prizeList[i].cover;
					$scope.goodsList[index].name = $scope.prizeList[i].name;
					console.log($scope.prizeList[i].name);
					break;
				}
			}
		}



	    $(function(){
	    	$('.mobile-page').on('click', '[data-left-preview]', function(event) {
	    		var id = $(this).data('id');
	    		$(this).parents('.mobile-page').find('[data-left-preview]').removeClass('cur-edit');
	    		$(this).addClass('cur-edit');
	    		$("[data-right-edit][data-id="+id+"]").stop().show().siblings().stop().hide();
	    	});

	    });
	}]);

	//图片上传完成时，图片加载事件绑定angularjs
    app.directive('imageonload', function () {
        return {
            restrict: 'A', link: function (scope, element, attrs) {
                element.bind('load', function () {
                    scope.$apply(attrs.imageonload);
                });
            }
        };
    });
    // 修改图片
    function changeSrc(elem){
        imgNowsrc = $(elem).attr("src");
    }
</script>
<{include file="../img-upload-modal.tpl"}>