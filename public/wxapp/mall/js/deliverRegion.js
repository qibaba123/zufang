//获取初始的状态数据
function getSelectAreaData(){
	var selectAreaList = angular.copy(LocalAreaList);
	var firstPrice = [];
	var firstNum   = [];
	var addNum     = [];
	var addPrice   = [];

	for (var i =0;i< selectAreaList.length;i++) {
		var flag = true;
		var cflag = true;
		var n = 0;
		for(var v=0;v<list.length;v++){
			if(list[v]){
			for(var k=0;k<list[v].length;k++){
				if(list[v][k]['sdc_area_name'] == selectAreaList[i].region.name){
					//匹配到青海省海南市，过滤海南省
					//dn 2019.08.06
					if(list[v][k]['sdc_area_id'] == 279 && selectAreaList[i].region.code == 9){
						continue;
					}

					// console.log('匹配到的地区名称第一层---↓↓------');
					// console.log(selectAreaList[i].region.name);
					// console.log(selectAreaList[i].region.code);
					// console.log('------↑↑------');

					if(!singalFinalRes[v]){
						singalFinalRes[v] = [];
					}
					flag = false;
					//显示出来的城市数量
					selectAreaList[i].region.stateShow=selectAreaList[i].region.state.length;
					selectAreaList[i].region.stateShowAll = true;
					selectAreaList[i].region.index=i;
					singalFinalRes[v][i]=selectAreaList[i];
				}

				selectAreaList[i].region.index=i;
				firstNum[v]=[];
				firstPrice[v]=[];
				addNum[v]=[];
				addPrice[v]=[];

				firstNum[v].push(list[v][k]['sdc_first_num']);
				firstPrice[v].push(list[v][k]['sdc_first_fee']);
				addNum[v].push(list[v][k]['sdc_add_num']);
				addPrice[v].push(list[v][k]['sdc_add_fee']);

				//遍历地区 给地区增加是否被选的标记
				var cityList = selectAreaList[i].region.state;

				for(var j in cityList){
					cityList[j].p_id = i;//省ID
					var regionList = cityList[j].city;
					if(list[v][k]['sdc_area_name'] ==selectAreaList[i].region.state[j].name){
						//匹配到海南省时，过滤青海省海南市
						//dn 2019.08.06
						if(list[v][k]['sdc_area_id'] == 9 && selectAreaList[i].region.state[j].code == 279){
							continue;
						}
						// console.log('匹配到的地区名称第二层---↓↓------');
						// console.log(regionList);
						// console.log(selectAreaList[i].region.code);
						// console.log(selectAreaList[i].region.state[j].name);
						// console.log(selectAreaList[i].region.state[j].code);
						// console.log('------↑↑------');

						n++;
						if(!singalFinalRes[v]){
							singalFinalRes[v] = [];
						}

						selectAreaList[i].region.stateShow=list[v].length;
						selectAreaList[i].region.state[j].index=j;

						singalFinalRes[v][i]=angular.copy(selectAreaList[i]);

						cflag = false;
						//显示出来的地区数量
						selectAreaList[i].region.state[j].cityShow=selectAreaList[i].region.state[j].city.length;
						selectAreaList[i].region.state[j].index=j;
					}
					if(cflag){
						//显示出来的地区数量
						selectAreaList[i].region.state[j].cityShow=0;
						selectAreaList[i].region.state[j].index=j;
					}

					for(var m in regionList){
						regionList[m].p_id = i;//省ID
						regionList[m].s_id = j;//市ID
						regionList[m].isShow = false;
						regionList[m].index = m;
					}
				}
			}
			}
		}


		if(flag){
			//显示出来的城市数量
			selectAreaList[i].region.stateShow=0;
			selectAreaList[i].region.index=i;
		}

		if(n==selectAreaList[i].region.state.length){
			selectAreaList[i].region.stateShowAll = true;
			selectAreaList[i].region.stateShow=selectAreaList[i].region.state.length;
		}

		var cityList = selectAreaList[i].region.state;
		for(var j in cityList){
			cityList[j].p_id = i;//省ID
			var regionList = cityList[j].city;
			if(cflag || !selectAreaList[i].region.state[j].cityShow){
				//显示出来的地区数量
				selectAreaList[i].region.state[j].cityShow=0;
				selectAreaList[i].region.state[j].index=j;
			}
		}
	}
	
	for(var i=0;i<singalFinalRes.length; i++){
		for(var k in singalFinalRes[i]){
			for(var n in singalFinalRes[i][k].region.state){
				if(groupName[i].indexOf(singalFinalRes[i][k].region.state[n].name) == -1){
					singalFinalRes[i][k].region.state[n].cityShow=0;
					singalFinalRes[i][k].region.state[n].index = n;
				}else{
					singalFinalRes[i][k].region.state[n].cityShow=singalFinalRes[i][k].region.state[n].city.length;
					singalFinalRes[i][k].region.state[n].index = n;
				}
			}
		}


		if(singalFinalRes[i]){

			for(var v=0;v<singalFinalRes[i].length;v++){
				if(singalFinalRes[i][v]){
					if(singalFinalRes[i][v].region.stateShow == singalFinalRes[i][v].region.state.length){
						for(var j=0;j<singalFinalRes[i][v].region.state.length;j++){
							singalFinalRes[i][v].region.state[j].cityShow=singalFinalRes[i][v].region.state[j].city.length
						}
					}else{
						var n = 0;
						for(var j=0;j<singalFinalRes[i][v].region.state.length;j++){
							if(singalFinalRes[i][v].region.state[j].cityShow>0){
								n++;
							}
						}
						singalFinalRes[i][v].region.stateShow=n;
					}
				}
			}
		}


		templateList[i] = {
			singalFinalRes:singalFinalRes[i]?singalFinalRes[i]:null,
			firstNum:firstNum[i]?firstNum[i][0]:[],
			firstFee:firstPrice[i]?firstPrice[i][0]:0,
			addNum:addNum[i]?addNum[i][0]:0,
			addFee:addPrice[i]?addPrice[i][0]:0
		};
	}

	return selectAreaList;
}
var app = angular.module('areaApp',['RootModule']);
app.controller('areaCtrl', ['$scope', '$http', function($scope, $http){
	// $scope.areaList = LocalAreaList;//省市区数组
	// $scope.areaList = getSelectAreaData();//省市区数组
	$scope.selectAreaList = getSelectAreaData();//已选数组
	$scope.waitSelectList = [];//待选数组
	$scope.singalFinalRes = singalFinalRes;//最终结果
	$scope.templateList   = templateList;//运费模板数组
	$scope.rightList       = [];
	$scope.actionIndex     = 0;
	/*
	 *折叠隐藏城市切换
	 */
	$scope.ladderToggle = function($event){
		$event.stopPropagation();
		var _this = $($event.target);
		var ulElem = $($event.target).closest('li').parent();

		if(ulElem.hasClass('area-editor-depth0')){
			var liIndex = _this.closest('li').index();
			if(_this.hasClass('extend')){
				_this.parents('.area-editor-wrap').find('.area-editor-depth0').each(function(index, el) {
					var thisLi = $(this).children('li').eq(liIndex);
					thisLi.children('.area-editor-depth1').stop().show();
					thisLi.children('.area-editor-list-title').find('.js-ladder-toggle').removeClass('extend').text('-');
				});
			}else{
				_this.parents('.area-editor-wrap').find('.area-editor-depth0').each(function(index, el) {
					var thisLi = $(this).children('li').eq(liIndex);
					thisLi.children('.area-editor-depth1').stop().hide();
					thisLi.children('.area-editor-list-title').find('.js-ladder-toggle').addClass('extend').text('+');
				});
			}
		}else if(ulElem.hasClass('area-editor-depth1')){
			var parentLiIndex = _this.closest('li').parent().parent().index();
			var liIndex = _this.closest('li').index();
			if(_this.hasClass('extend')){
				_this.parents('.area-editor-wrap').find('.area-editor-depth0').each(function(index, el) {
					var ulThis = $(this);
					ulThis.children('li').eq(parentLiIndex).find('.area-editor-depth1').each(function(index, el) {
						var thisLi = $(this).children('li').eq(liIndex);
						thisLi.children('.area-editor-depth2').stop().show();
						thisLi.children('.area-editor-list-title').find('.js-ladder-toggle').removeClass('extend').text('-');
					});
				});
			}else{
				_this.parents('.area-editor-wrap').find('.area-editor-depth0').each(function(index, el) {
					var ulThis = $(this);
					ulThis.children('li').eq(parentLiIndex).find('.area-editor-depth1').each(function(index, el) {
						var thisLi = $(this).children('li').eq(liIndex);
						thisLi.children('.area-editor-depth2').stop().hide();
						thisLi.children('.area-editor-list-title').find('.js-ladder-toggle').addClass('extend').text('+');
					});
				});
			}
			
		}
	};

	$scope.showChooseArea = function(index, selectList){
		$(".area-modal-wrap").stop().fadeIn();
		if(selectList){
			$scope.rightList = selectList;
			$scope.actionIndex = index;
		}else{
			$scope.rightList = [];
			$scope.actionIndex = -1;
			for (var i =0;i< $scope.selectAreaList.length;i++) {
				var cityList = $scope.selectAreaList[i].region.state;
				for(var j in cityList){
					if($scope.selectAreaList[i].region.state[j].cityShow!=0){
						$scope.selectAreaList[i].region.state[j].cityShow = 0.5;
						//$scope.selectAreaList[i].region.state[j].cityShow = $scope.selectAreaList[i].region.state[j].city.length;
					}
				}
			}
		}

	};

	$scope.hideChooseArea = function(){
		$(".area-modal-wrap").stop().fadeOut();
	};

	$scope.deleteChooseArea = function(index, selectList){
		$scope.templateList[index]=[];
		for(var i=0;i<selectList.length;i++){
			if(selectList[i]){
				$scope.unselectAllAreaByP(i);
			}
		}
	};

	/*
	 *是否选中城市切换
	 */
	$scope.selectToggle = function($event,item){

		var _this = $($event.target).parents('.area-editor-list-title');
		var type = $scope.getType(item);


		if(type == 'p' && $scope.selectAreaList[item.region.index].region.stateShow != 0 && $scope.selectAreaList[item.region.index].region.stateShow != $scope.selectAreaList[item.region.index].region.length){
			return false;
		}
		if(_this.hasClass('area-editor-list-select')){
			var waitobj = $scope.getWaitObj(type,item);
			waitobj.action = 'remove';
			$scope.waitSelectList.push(waitobj);
			// $scope.deleteFromWaitSelect(waitobj);
		}else{
			var waitobj = $scope.getWaitObj(type,item);
			waitobj.action = 'add';
			$scope.waitSelectList.push(waitobj);

		}

		_this.toggleClass('area-editor-list-select');
		var curParent = _this.closest('ul');
		if(_this.hasClass('area-editor-list-select')){
			_this.next().find('.area-editor-list-title').addClass('area-editor-list-select');
		}else{
			_this.next().find('.area-editor-list-title').removeClass('area-editor-list-select');
		}
		if(curParent.hasClass('area-editor-depth0')){
			
		}else{
			var liNum = curParent.children('li').length;
			var selectLiNum = "";
			curParent.children('li').each(function(index, el) {
				if($(this).children('.area-editor-list-title').hasClass('area-editor-list-select')){
					selectLiNum++;
				}
			});
			if(selectLiNum == liNum){
				curParent.prev().addClass('area-editor-list-select');
			}else{
				curParent.prev().removeClass('area-editor-list-select');
				
			}
			if(curParent.hasClass('area-editor-depth2')){
				var parentLiNum = curParent.parents('.area-editor-depth1').children('li').length;
				var parentSelectLiNum = "";
				curParent.parents('.area-editor-depth1').children('li').each(function(index, el) {
					if($(this).children('.area-editor-list-title').hasClass('area-editor-list-select')){
						parentSelectLiNum++;
					}
				});
				if(parentLiNum == parentSelectLiNum){
					curParent.parents('.area-editor-depth1').prev().addClass('area-editor-list-select');
				}else{
					curParent.parents('.area-editor-depth1').prev().removeClass('area-editor-list-select');
				}
			}
		}
	};
	//获取类型 p省 c城市 a地区
	$scope.getType = function(item){
		var type = "";
		if(item.region){
			type = "p";
		}
		if(item.city){
			type = "c";
		}
		if(item.s_id){
			type = "a";
		}else{
			console.log('++++');
		}

		return type;
	}
	//获取待选obj
	$scope.getWaitObj = function(type,item){
		var obj = {
			type:type,
			pid:-1,
			cid:-1,
			aid:-1
		}
		if(type == 'p'){
			obj.pid = item.region.index;
		}
		if(type == 'c'){
			obj.pid = item.p_id;
			obj.cid = item.index;
		}
		if(type == 'a'){
			obj.pid = item.p_id;
			obj.cid = item.s_id;
			obj.aid = item.index;
		}

		return obj;
	}
	//取消选择的时候从待选数组里面删除已经插入的元素
	$scope.deleteFromWaitSelect = function(dItem){
		for(var i=0;i<$scope.waitSelectList.length;i++){
			var item = $scope.waitSelectList[i];
			if(dItem.type == item.type && dItem.pid == item.pid && dItem.cid == item.cid && dItem.aid == item.aid){
				$scope.waitSelectList.splice(i,1);
			}
			
		}
	}
	// 添加到右侧选中
	$scope.addToRight = function(){
		for(var i=0;i<$scope.waitSelectList.length;i++){
			var item = $scope.waitSelectList[i];
			if(item.action=='add'){
				switch(item.type){
					case 'p':
						$scope.selectAllAreasByP(item.pid);
						break;
					case 'c':
						
						$scope.selectAllAreasByC(item.pid,item.cid);
						break;
					case 'a':
						$scope.selectAllAreasByA(item.pid,item.cid,item.aid)
						break;
				}
			}else{
				switch(item.type){
					case 'p':
						$scope.unselectAllAreaByP(item.pid);
						break;
					case 'c':
						$scope.unselectAllAreaByC(item.pid,item.cid);
						break;
					case 'a':
						$scope.unselectAllAreaByA(item.pid,item.cid,item.aid)
						break;
				}
			}
		}
		$scope.waitSelectList = [];
		$(".area-editor-list-select").removeClass('area-editor-list-select');
	}
	$scope.deleteSelectItem = function(event,item){
		var type = $scope.getType(item);
		//判断要添加的类型
		switch(type){
			case 'p':
				$scope.unselectAllAreaByP(item.region.index);
				break;
			case 'c':
				$scope.unselectAllAreaByC(item.p_id,item.index);
				break;
			case 'a':
				$scope.unselectAllAreaByA(item.p_id,item.s_id,item.index);
				break;
		}

	} 
	//选中某省下所有区域 参数为省的索引
	$scope.selectAllAreasByP = function(p_id){
		// 要选中的省
		var n = 0;
		for(var i = 0;i<$scope.selectAreaList[p_id].region.state.length;i++){
			if($scope.selectAreaList[p_id].region.state[i].city.length>0){
				//设置城市的显示区域为该城市下所有的区域数目
				if($scope.selectAreaList[p_id].region.state[i].cityShow == $scope.selectAreaList[p_id].region.state[i].city.length){
					$scope.selectAreaList[p_id].region.state[i].cityShow = 0.5;
				}

				if($scope.selectAreaList[p_id].region.state[i].cityShow != 0.5){
					n++;
					$scope.selectAreaList[p_id].region.state[i].cityShow = $scope.selectAreaList[p_id].region.state[i].city.length;
				}

				for(var j = 0;j<$scope.selectAreaList[p_id].region.state[i].city.length;j++){
					//显示所有区域
					$scope.selectAreaList[p_id].region.state[i].city[j].isShow = true;
				}
			}else{
				n++;
				$scope.selectAreaList[p_id].region.state[i].cityShow = 1;
			}
			$scope.selectAreaList[p_id].region.state[i].cityShowAll = true;
		}
		if(n==$scope.selectAreaList[p_id].region.state.length){
			$scope.selectAreaList[p_id].region.stateShow = $scope.selectAreaList[p_id].region.state.length;
			$scope.selectAreaList[p_id].region.stateShowAll = true;
		}
		$scope.selectAreaList[p_id].region.hide = true;
		$scope.rightList[p_id] = $scope.selectAreaList[p_id];
	}
	// 选中某省下的某市下所有区域 参数 省索引 市索引
	$scope.selectAllAreasByC = function(p_id,c_id){
		if(!$scope.rightList[p_id]){
			$scope.rightList[p_id] = angular.copy($scope.selectAreaList[p_id]);
			for(var i=0; i<$scope.rightList[p_id].region.state;i++){
				$scope.rightList[p_id].region.state[c_id].cityShow = 0;
			}
		}
		// 要选中的城市
		// 设置城市的显示区域为该城市下所有的区域数目
		
		if($scope.selectAreaList[p_id].region.state[c_id].city.length>0){
			$scope.selectAreaList[p_id].region.state[c_id].cityShow = $scope.selectAreaList[p_id].region.state[c_id].city.length;
			for(var j = 0;j<$scope.selectAreaList[p_id].region.state[c_id].city.length;j++){
				// 显示所有区域
				$scope.selectAreaList[p_id].region.state[c_id].city[j].isShow = true;
			}
			$scope.selectAreaList[p_id].region.state[c_id].cityShowAll = true;
		}else{
			$scope.selectAreaList[p_id].region.state[c_id].cityShow = 1;
		}
		
		//逻辑处理 如果当前省下已经选中了一个城市 这个时候在选中省的选中城市数目+1
		//相反删除则是-1
		$scope.selectAreaList[p_id].region.stateShow+=1;
		$scope.rightList[p_id].region.stateShow+=1;
		// 查看所有市选中
		var cityShowAllNum = 0
		var stateShowNUm = 0;
		for(var i=0;i<$scope.selectAreaList[p_id].region.state.length;i++){
			if($scope.selectAreaList[p_id].region.state[i].cityShowAll){
				cityShowAllNum++;
			}
			if($scope.selectAreaList[p_id].region.state[i].cityShow==0){
				stateShowNUm++
			}
		}
		if(stateShowNUm == 0){
			$scope.selectAreaList[p_id].region.stateShow=$scope.selectAreaList[p_id].region.state.length;
		}

		if(cityShowAllNum == $scope.selectAreaList[p_id].region.state.length){
			$scope.selectAreaList[p_id].region.stateShowAll = true;
		}else{
			$scope.selectAreaList[p_id].region.stateShowAll = false;
		}
		$scope.rightList[p_id].region.state[c_id].cityShow = $scope.selectAreaList[p_id].region.state[c_id].cityShow;
	}

	//选中某区 参数为省索引 市索引 区域索引
	$scope.selectAllAreasByA = function(p_id,c_id,a_id){
		$scope.selectAreaList[p_id].region.state[c_id].city[a_id].isShow = true;

		// 区域数+1
		$scope.selectAreaList[p_id].region.state[c_id].cityShow+=1;
		var sum = 0;
		for(var i=0;i<$scope.selectAreaList[p_id].region.state.length;i++){
			if($scope.selectAreaList[p_id].region.state[i].cityShow>0){
				//城市数+1
				sum++;
			}
		}
		$scope.selectAreaList[p_id].region.stateShow = sum;

		// 查看所有区选中
		var isShowNum = 0;
		for(var j=0;j<$scope.selectAreaList[p_id].region.state[c_id].city.length;j++){
			if($scope.selectAreaList[p_id].region.state[c_id].city[j].isShow){
				isShowNum++;
			}
		}
		if(isShowNum == $scope.selectAreaList[p_id].region.state[c_id].city.length){
			$scope.selectAreaList[p_id].region.state[c_id].cityShowAll = true;
		}else{
			$scope.selectAreaList[p_id].region.state[c_id].cityShowAll = false;
		}
		// 查看所有市选中
		var cityShowAllNum = 0;
		for(var i=0;i<$scope.selectAreaList[p_id].region.state.length;i++){
			if($scope.selectAreaList[p_id].region.state[i].cityShowAll){
				cityShowAllNum++;
			}
		}
		if(cityShowAllNum == $scope.selectAreaList[p_id].region.state.length){
			$scope.selectAreaList[p_id].region.stateShowAll = true;
		}else{
			$scope.selectAreaList[p_id].region.stateShowAll = false;
		}
	}

	// 取消选择某省下所有区域
	$scope.unselectAllAreaByP = function(p_id){
		//要选中的省
		for(var i=0;i<$scope.selectAreaList[p_id].region.state.length;i++){
			//设置城市的显示区域为该城市下所有的区域数目

			if($scope.rightList[p_id].region.state[i].cityShow==$scope.rightList[p_id].region.state[i].city.length){
				$scope.selectAreaList[p_id].region.state[i].cityShow = 0;
			}
			for(var j=0;j<$scope.selectAreaList[p_id].region.state[i].city.length;j++){
				//显示所有的区域
				$scope.selectAreaList[p_id].region.state[i].city[j].isShow = false;
			}
			$scope.selectAreaList[p_id].region.state[i].cityShowAll = false;
		}
		$scope.selectAreaList[p_id].region.stateShow = 0;
		$scope.selectAreaList[p_id].region.stateShowAll = false;
		$scope.selectAreaList[p_id].region.hide = false;
		$scope.rightList.splice(p_id,1);
	}
	// 取消选择某省下的某市下所有区域
	$scope.unselectAllAreaByC = function(p_id,c_id){

		//要选中的城市
		//设置城市的显示区域为该城市下所有的区域数目
		$scope.selectAreaList[p_id].region.state[c_id].cityShow = 0;
		$scope.rightList[p_id].region.state[c_id].cityShow = 0;
		for(var j=0;j<$scope.rightList[p_id].region.state.length;j++){
			//显示所有区域
			if($scope.rightList[p_id].region.state[j].city.length != $scope.rightList[p_id].region.state[j].cityShow && $scope.rightList[p_id].region.state[j].cityShow!=0){
				$scope.rightList[p_id].region.stateShow-=1;
			}
		}

		for(var j=0;j<$scope.selectAreaList[p_id].region.state[c_id].city.length;j++){
			//显示所有区域
			$scope.selectAreaList[p_id].region.state[c_id].city[j].isShow = false;
		}
		$scope.selectAreaList[p_id].region.state[c_id].cityShowAll = false;
		// 逻辑处理 如果当前省下已经选中了一个城市 这个时候则在选中省的城市数目+1 
		// 相反删除则是-1
		$scope.selectAreaList[p_id].region.stateShow-=1;

		var showNUm = 0;
		for(var i=0;i<$scope.rightList[p_id].region.state.length;i++){
			if($scope.rightList[p_id].region.state[i].cityShow>0){
				showNUm++;
			}
		}

		if(showNUm == 0){
			$scope.unselectAllAreaByP(p_id);
		}


		// 查看所有市选中
		var cityShowAllNum = 0;
		for(var i=0;i<$scope.selectAreaList[p_id].region.state.length;i++){
			if($scope.selectAreaList[p_id].region.state[i].cityShowAll){
				cityShowAllNum++;
			}
		}
		if(cityShowAllNum == $scope.selectAreaList[p_id].region.state.length){
			$scope.selectAreaList[p_id].region.stateShowAll = true;
		}else{
			$scope.selectAreaList[p_id].region.stateShowAll = false;
		}


	}

	// 取消选中某区
	$scope.unselectAllAreaByA = function(p_id,c_id,a_id){
		$scope.selectAreaList[p_id].region.state[c_id].city[a_id].isShow = false;
		// 区域数-1
		$scope.selectAreaList[p_id].region.state[c_id].cityShow-=1;
		//如果区域删除完了 则减少城市显示数目
		if($scope.selectAreaList[p_id].region.state[c_id].cityShow==0){
			$scope.selectAreaList[p_id].region.stateShow-=1;
		}
		// 查看所有区选中
		var isShowNum = 0;
		for(var j=0;j<$scope.selectAreaList[p_id].region.state[c_id].city.length;j++){
			if($scope.selectAreaList[p_id].region.state[c_id].city[j].isShow){
				isShowNum++;
			}
		}
		if(isShowNum == $scope.selectAreaList[p_id].region.state[c_id].city.length){
			$scope.selectAreaList[p_id].region.state[c_id].cityShowAll = true;
		}else{
			$scope.selectAreaList[p_id].region.state[c_id].cityShowAll = false;
		}
		// 查看所有市选中
		var cityShowAllNum = 0;
		for(var i=0;i<$scope.selectAreaList[p_id].region.state.length;i++){
			if($scope.selectAreaList[p_id].region.state[i].cityShowAll){
				cityShowAllNum++;
			}
		}
		if(cityShowAllNum == $scope.selectAreaList[p_id].region.state.length){
			$scope.selectAreaList[p_id].region.stateShowAll = true;
		}else{
			$scope.selectAreaList[p_id].region.stateShowAll = false;
		}
	}
	$scope.getFinalData = function(){
		var singalFinalRes = [];		
		var selectAreaList = $scope.rightList;
		
		 console.log('获得selectAreaList---↓------');
		 console.log(selectAreaList);
		// console.log('------↑------');

		for (var i = 0;i< selectAreaList.length;i++) {
			if(selectAreaList[i]){
				var proviceItem = angular.copy(selectAreaList[i]);
				if(proviceItem.region.stateShow>0){
					proviceItem.region.state = [];
					var cityList = angular.copy(selectAreaList[i].region.state);
					for(var j in cityList){
						var cityItem = angular.copy(selectAreaList[i].region.state[j]);
						// if(cityItem.cityShow==cityItem.city.length){
						 if(cityItem.city.length){
							cityItem.city = [];
							for(var m in selectAreaList[i].region.state[j].city){
								var areaItem = angular.copy(selectAreaList[i].region.state[j].city[m]);
								if(areaItem.isShow){
									cityItem.city.push(areaItem);
								}
							}
							//push city
							proviceItem.region.state.push(cityItem);
						}else{
							continue;
						}
					}
					singalFinalRes[i] = proviceItem;
				}else{
					continue;
				}
			}
		}
		$scope.singalFinalRes = singalFinalRes;
		$scope.hideChooseArea();
		var templateItem={};
		if($scope.actionIndex > -1){
			templateItem = {
				'singalFinalRes':singalFinalRes,
				'firstNum':$scope.templateList[$scope.actionIndex].firstNum,
				'firstFee':$scope.templateList[$scope.actionIndex].firstFee,
				'addNum':$scope.templateList[$scope.actionIndex].addNum,
				'addFee':$scope.templateList[$scope.actionIndex].addFee
			}
			$scope.templateList[$scope.actionIndex] = templateItem;
		}else{
			templateItem = {
				'singalFinalRes':singalFinalRes,
				'firstNum':0,
				'firstFee':0.00,
				'addNum':0,
				'addFee':0.00
			}
			$scope.templateList.push(templateItem);
		}
		 //console.log('获得singalFinalRes---↓------');
		 //console.log($scope.singalFinalRes);
		 //console.log('------↑------');

	}
	$scope.editSelect = function($event,item){
		var obj = $($event.target);
		var selectList = item;
	}

	// 保存数据
	$scope.saveTemplate = function(){
		var templateListData = [];
		for(var i=0; i<$scope.templateList.length; i++){
			console.log($scope.templateList[i]);
			templateListData[i] = {
				'firstNum':$scope.templateList[i].firstNum?$scope.templateList[i].firstNum:0,
				'firstFee':$scope.templateList[i].firstFee?$scope.templateList[i].firstFee:0,
				'addNum':$scope.templateList[i].addNum?$scope.templateList[i].addNum:0,
				'addFee':$scope.templateList[i].addFee?$scope.templateList[i].addFee:0,
				'singalFinalResData': $scope.formatCityList($scope.templateList[i].singalFinalRes)
			}
		}
		var data = {
			'id'   : $('#id').val(),
			'name' 	 : $('#temp-name').val(),
			'type' : $("input[name='valuation_type']:checked").val(),
			'templateList': templateListData //格式化城市数据
		};
		var esId = $('#esId').val();
		var request_url;
		var jump_url;
		if(esId > 0){
			request_url = '/shop/delivery/saveTemplate';
			jump_url = '/shop/delivery/index'
		}else{
			request_url = '/wxapp/delivery/saveTemplate';
			jump_url = '/wxapp/delivery/index'
		}

		if(data.name && data.type){
			var index = layer.load(1, {
				shade: [0.1,'#fff'] //0.1透明度的白色背景
			},{
				time : 10*1000
			});
			$http({
				method: 'POST',
				url:    request_url,
				data:   data
			}).then(function(response) {
				layer.close(index);
				layer.msg(response.data.em);
				//window.location.href=jump_url;
			});
		}else{
			layer.msg("请完善模板信息");
		}
	};

	$scope.formatCityList = function(list){
		console.log('处理前')
		console.log(list)
		var areaList = [];
		if(list){
			for(var i=0; i<list.length; i++){
				if(list[i]){
					if((list[i].region.stateShow == $scope.selectAreaList[list[i].region.index].region.state.length)&&list[i].region.stateShow==list[i].region.state.length){
						areaList.push({
							'name': list[i].region.name,
							'type': 1
						})
					}else{
						for(var j=0; j<list[i].region.state.length;j++){
							if(list[i].region.state[j].cityShow>0){
								areaList.push({
									'name': list[i].region.state[j].name,
									'prov': list[i].region.name,
									'type': 2
								})
							}
						}
						console.log('处理失败的');
						console.log(list[i]);
					}
				}
			}
			console.log('处理后')
			console.log(areaList)
			return areaList;
		}else{
			return [];
		}
	}
}]);