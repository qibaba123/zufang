var app = angular.module('shopApp', ['RootModule']);
app.controller('shopCtrl', ['$scope', '$http', function($scope, $http) {
    //页面顶部
    $scope.pageTop = {
        pageName: "店铺主页",
        searchBgColor:"#76AC26",
        inputBgColor:"#9FC567",
        placeHolder:"请输入搜索内容"
    };
    //搜索区域数据
    $scope.logoSearch = {
    	imgSrc:"/public/manage/newTemThree/images/logo.jpeg",
    	placeHolder:"请输入搜索内容"
    };
    //幻灯数据
    $scope.banners = [{
    	index:0,
    	imgSrc:"/public/manage/newTemThree/images/sy_02-banner.png",
    	link:"http://www.tdotit.com/"
    },{
    	index:1,
    	imgSrc:"/public/manage/newTemThree/images/sy_02-banner.png",
    	link:"http://www.tdotit.com/"
    }];
    //分类导航数据
    $scope.fenleiNavs = [{
    	index:0,
    	imgSrc:"/public/manage/newTemThree/images/icon_index_yongpin.png",
    	name:'餐饮用品',
    	link:"http://www.tdotit.com/"
    },{
    	index:1,
    	imgSrc:"/public/manage/newTemThree/images/icon_index_dingzhi.png",
    	name:'品牌定制',
    	link:"http://www.tdotit.com/"
    },{
    	index:2,
    	imgSrc:"/public/manage/newTemThree/images/icon_index_anli.png",
    	name:'案例精选',
    	link:"http://www.tdotit.com/"
    },{
    	index:3,
    	imgSrc:"/public/manage/newTemThree/images/icon_index_weihuo.png",
    	name:'尾货特卖',
    	link:"http://www.tdotit.com/"
    }];
    //橱窗数据
    $scope.shopwindows = [
    	{
    		index:0,
    		styleType:1,
    		goods:[
    			{imgSrc:"/public/manage/newTemThree/images/tuijian-img01.jpg",link:""},
    			{imgSrc:"/public/manage/newTemThree/images/tuijian-img02.jpg",link:""},
    			{imgSrc:"/public/manage/newTemThree/images/tuijian-img03.jpg",link:""}
    		]
    	},{
    		index:1,
    		styleType:2,
    		goods:[
    			{imgSrc:"/public/manage/newTemThree/images/chuchuang1.png",link:""},
    			{imgSrc:"/public/manage/newTemThree/images/chuchuang2.jpg",link:""},
    			{imgSrc:"/public/manage/newTemThree/images/chuchuang3.jpg",link:""}
    		]
    	},{
    		index:2,
    		styleType:3,
    		goods:[
    			{imgSrc:"/public/manage/newTemThree/images/tuijian-img09.jpg",link:""},
    			{imgSrc:"/public/manage/newTemThree/images/tuijian-img10.jpg",link:""},
    			{imgSrc:"/public/manage/newTemThree/images/tuijian-img11.jpg",link:""},
    			{imgSrc:"/public/manage/newTemThree/images/tuijian-img12.jpg",link:""},
    			{imgSrc:"/public/manage/newTemThree/images/tuijian-img12.jpg",link:""}
    		]
    	}
    ];
    //传递添加橱窗索引位置
    $scope.addShopWindowIndex = -1;
    $scope.hotGoods = [
    	{
    		index:0,
    		imgSrc:"/public/manage/newTemThree/images/goodsfenlei1.png",
    		showStyle:1,
    		goods:[
    			{
    				index:0,
                    imgSrc:"/public/manage/img/zhanwei/zw_fxb_45_45.png",
    				title:"双层热饮杯 防烫 环保 新款",
    				price:"￥999"
    			},{
    				index:1,
                    imgSrc:"/public/manage/img/zhanwei/zw_fxb_45_45.png",
    				title:"双层热饮杯 防烫 环保 新款",
    				price:"￥999"
    			},{
    				index:2,
                    imgSrc:"/public/manage/img/zhanwei/zw_fxb_45_45.png",
    				title:"双层热饮杯 防烫 环保 新款",
    				price:"￥999"
    			},{
    				index:3,
                    imgSrc:"/public/manage/img/zhanwei/zw_fxb_45_45.png",
    				title:"双层热饮杯 防烫 环保 新款",
    				price:"￥999"
    			}
    		]
    	},{
    		index:1,
    		imgSrc:"/public/manage/newTemThree/images/goodsfenlei2.png",
    		showStyle:2,
    		goods:[
    			{
                    index:0,
    				imgSrc:"/public/manage/img/zhanwei/zw_fxb_45_45.png",
    				title:"双层热饮杯 防烫 环保 新款",
    				price:"￥999"
    			},{
                    index:1,
    				imgSrc:"/public/manage/img/zhanwei/zw_fxb_45_45.png",
    				title:"双层热饮杯 防烫 环保 新款",
    				price:"￥999"
    			},{
                    index:2,
    				imgSrc:"/public/manage/img/zhanwei/zw_fxb_45_45.png",
    				title:"双层热饮杯 防烫 环保 新款",
    				price:"￥999"
    			},{
                    index:3,
    				imgSrc:"/public/manage/img/zhanwei/zw_fxb_45_45.png",
    				title:"双层热饮杯 防烫 环保 新款",
    				price:"￥999"
    			}
    		]
    	},{
    		index:2,
    		imgSrc:"/public/manage/newTemThree/images/goodsfenlei3.png",
    		showStyle:3,
    		goods:[
    			{
                    index:0,
    				imgSrc:"/public/manage/img/zhanwei/zw_fxb_45_45.png",
    				title:"双层热饮杯 防烫 环保 新款",
    				price:"￥999"
    			},{
                    index:1,
    				imgSrc:"/public/manage/img/zhanwei/zw_fxb_45_45.png",
    				title:"双层热饮杯 防烫 环保 新款",
    				price:"￥999"
    			},{
                    index:2,
    				imgSrc:"/public/manage/img/zhanwei/zw_fxb_45_45.png",
    				title:"双层热饮杯 防烫 环保 新款",
    				price:"￥999"
    			},{
                    index:3,
    				imgSrc:"/public/manage/img/zhanwei/zw_fxb_45_45.png",
    				title:"双层热饮杯 防烫 环保 新款",
    				price:"￥999"
    			}
    		]
    	},{
    		index:3,
    		imgSrc:"/public/manage/newTemThree/images/goodsfenlei1.png",
    		showStyle:4,
    		goods:[
    			{
                    index:0,
    				imgSrc:"/public/manage/img/zhanwei/zw_fxb_45_45.png",
    				title:"双层热饮杯 防烫 环保 新款",
    				price:"￥999"
    			},{
                    index:1,
    				imgSrc:"/public/manage/img/zhanwei/zw_fxb_45_45.png",
    				title:"双层热饮杯 防烫 环保 新款",
    				price:"￥999"
    			},{
                    index:2,
    				imgSrc:"/public/manage/img/zhanwei/zw_fxb_45_45.png",
    				title:"双层热饮杯 防烫 环保 新款",
    				price:"￥999"
    			},{
                    index:3,
    				imgSrc:"/public/manage/img/zhanwei/zw_fxb_45_45.png",
    				title:"双层热饮杯 防烫 环保 新款",
    				price:"￥999"
    			}
    		]
    	}
    ];

    //添加幻灯
    $scope.addNewBanner = function(){
        var banner_length = $scope.banners.length;
        for( var i=0;i< banner_length;i++){
            if( banner_length===$scope.banners[i].index){
                 banner_length = "a"+ banner_length;
            }else{
                 banner_length = banner_length;
            }
        }

        if(banner_length>=5){
            layer.msg('最多只能添加5张广告图哦!');
        }else{
            var banner_Default = {
                index: banner_length,
                imgSrc: '/public/manage/newTemThree/images/banner-260.jpg',
                link: 'http://www.fenxiaobao.xin/manage/index/index'
            };
            $scope.banners.push(banner_Default);
        }
    }
    //添加分类导航
    $scope.addFenleiNav = function(){
        var fenleiNav_length = $scope.fenleiNavs.length;
        for( var i=0;i< fenleiNav_length;i++){
            if( fenleiNav_length===$scope.fenleiNavs[i].index){
                 fenleiNav_length = "a"+ fenleiNav_length;
            }else{
                 fenleiNav_length = fenleiNav_length;
            }
        }

        if(fenleiNav_length>=8){
            layer.msg('最多只能添加8个分类导航哦!');
        }else{
            var fenleiNav_Default = {
                index: fenleiNav_length,
                imgSrc: '/public/manage/img/zhanwei/fenleinav.png',
                name:'分类名称',
                link: 'http://www.fenxiaobao.xin/manage/index/index'
            };
            $scope.fenleiNavs.push(fenleiNav_Default);
        }
    }
    /*获取传递添加橱窗位置索引*/
    $scope.getShopWindowIndex = function(type,index){
        $scope.addShopWindowIndex = $scope.getRealIndex($scope[type],index);
    }
    /*添加新橱窗*/
    $scope.addShopWindow = function($event){
    	var elem = $($event.target);
    	var insertIndex = $scope.addShopWindowIndex + 1;
    	var insertStyle = elem.data('style');
    	var shopwindow_length = $scope.shopwindows.length;
    	for( var i=0;i< shopwindow_length;i++){
    	    if( shopwindow_length===$scope.shopwindows[i].index){
    	         shopwindow_length = "a"+ shopwindow_length;
    	    }else{
    	         shopwindow_length = shopwindow_length;
    	    }
    	}
    	var shopwindowStyle = "";
    	if(insertStyle==1){
    		shopwindowStyle = {
    			index:shopwindow_length,
    			styleType:1,
    			goods:[
    				{imgSrc:"/public/manage/newTemThree/images/tuijian-img01.jpg",link:""},
    				{imgSrc:"/public/manage/newTemThree/images/tuijian-img02.jpg",link:""},
    				{imgSrc:"/public/manage/newTemThree/images/tuijian-img03.jpg",link:""}
    			]
    		}
    	}else if(insertStyle==2){
    		shopwindowStyle = {
    			index:shopwindow_length,
    			styleType:2,
	    		goods:[
	    			{imgSrc:"/public/manage/newTemThree/images/chuchuang1.png",link:""},
	    			{imgSrc:"/public/manage/newTemThree/images/chuchuang2.jpg",link:""},
	    			{imgSrc:"/public/manage/newTemThree/images/chuchuang3.jpg",link:""}
	    		]
    		}
    	}else if(insertStyle==3){
    		shopwindowStyle = {
    			index:shopwindow_length,
    			styleType:3,
	    		goods:[
	    			{imgSrc:"/public/manage/newTemThree/images/tuijian-img09.jpg",link:""},
	    			{imgSrc:"/public/manage/newTemThree/images/tuijian-img10.jpg",link:""},
	    			{imgSrc:"/public/manage/newTemThree/images/tuijian-img11.jpg",link:""},
	    			{imgSrc:"/public/manage/newTemThree/images/tuijian-img12.jpg",link:""},
	    			{imgSrc:"/public/manage/newTemThree/images/tuijian-img12.jpg",link:""}
	    		]
    		}
    	}
    	$scope.shopwindows.splice(insertIndex,0,shopwindowStyle);
    	$(".edit-con").stop().hide();
    }
    /*添加商品分类*/
    $scope.addHotGoods = function(type,index){
        var curRealIndex = $scope.getRealIndex($scope[type],index);
    	var insertIndex = curRealIndex + 1;
        var showType = -1;
        if($scope[type].length>0){
            showType = $scope[type][curRealIndex].showStyle;
        }else{
            showType = 2;
        }
    	var hotGood_length = $scope.hotGoods.length;
    	for( var i=0;i< hotGood_length;i++){
    	    if( hotGood_length===$scope.hotGoods[i].index){
    	         hotGood_length = "a"+ hotGood_length;
    	    }else{
    	         hotGood_length = hotGood_length;
    	    }
    	}
    	var hotGoodsDefault = {
    		index:hotGood_length,
    		imgSrc:"/public/manage/newTemThree/images/zw2.png",
    		showStyle:showType,
    		goods:[
    			{
                    index:0,
    				imgSrc:"/public/manage/img/zhanwei/zw_fxb_45_45.png",
    				title:"双层热饮杯 防烫 环保 新款",
    				price:"￥999"
    			},{
                    index:1,
    				imgSrc:"/public/manage/img/zhanwei/zw_fxb_45_45.png",
    				title:"双层热饮杯 防烫 环保 新款",
    				price:"￥999"
    			},{
                    index:2,
    				imgSrc:"/public/manage/img/zhanwei/zw_fxb_45_45.png",
    				title:"双层热饮杯 防烫 环保 新款",
    				price:"￥999"
    			},{
                    index:3,
    				imgSrc:"/public/manage/img/zhanwei/zw_fxb_45_45.png",
    				title:"双层热饮杯 防烫 环保 新款",
    				price:"￥999"
    			}
    		]
    	}
    	$scope.hotGoods.splice(insertIndex,0,hotGoodsDefault);
    }
    $scope.getNewGoodIndex = function(index){
        $scope.addGoodIndex = $scope.getRealIndex($scope.hotGoods,index);
        var goodsItem = $scope.hotGoods[$scope.addGoodIndex].goods;
        var goodsLength = goodsItem.length;
        var arrayVal = [];
        var elem = $('#myGoodslist').find('.choose-goods-content');
        elem.find("input[type=checkbox]").prop("checked",false);
        for(var i=0;i<goodsLength;i++){
            arrayVal.push(goodsItem[i].index);
        }
        for(var m=0;m<arrayVal.length;m++){
            elem.find('.good-info-item').each(function(index, el) {
                var $this = $(this);
                if(arrayVal[m]==$this.attr("data-goodId")){
                    $this.find('input').prop("checked",true);
                }
            });
        }
        if(elem.find('.good-info-item input:checked').length == elem.find('.good-info-item input').length){
            elem.find("input[type=checkbox]").prop("checked",true);
        }
    }
    $scope.addNewGood = function($event){
        var addIndex = $scope.addGoodIndex;
        var elem = $($event.target).parents('#myGoodslist').find('.choose-goods-content .good-info-item');
        var insertArray = [];
        var selectedGoodNum = elem.find('input[type=checkbox]:checked').length;
        if(selectedGoodNum<1){
            layer.msg('请选择商品');
        }else{
            elem.each(function(index, el) {
                var $this = $(this);
                var isChoosed = $this.find('input[type=checkbox]').is(':checked');
                if(isChoosed){
                    var goodIndex = $this.attr('data-goodId'),
                        imgSrc = $this.find('img').attr("src"),
                        goodsTitle = $this.find('p.title').text(),
                        goodsPrice = $this.find('p.price').text();
                    var insertItem = {};
                    insertItem.index = goodIndex;
                    insertItem.imgSrc = imgSrc;
                    insertItem.title = goodsTitle;
                    insertItem.price = goodsPrice;
                    insertArray.push(insertItem);
                }
            });
            $scope.hotGoods[addIndex].goods = insertArray;
            $('#myGoodslist').modal('hide');
            // elem.find('input[type=checkbox]').prop("checked",false);
        }
    }

    /*更改商品列表样式*/
    $scope.changeStyle = function($event,type,index){
        $event.preventDefault();
        var that =$($event.target).prev('input:eq(0)');
        var value = that.data('styleid');
        that.get(0).checked=true;
        var realIndex = -1;
        realIndex = $scope.getRealIndex($scope[type],index);
        // console.log(type+"--"+realIndex+"--"+value);
        $scope[type][realIndex].showStyle = value;
    }
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
    $scope.delGood = function(firstindex,secondindex){
        var firstRealIndex = $scope.getRealIndex($scope.hotGoods,firstindex);
        var secondRealIndex = $scope.getRealIndex($scope.hotGoods[firstRealIndex].goods,secondindex);
        layer.confirm('您确定要删除吗？', {
            title:'删除提示',
            btn: ['确定','取消']
        }, function(){
            $scope.$apply(function(){
                $scope.hotGoods[firstRealIndex].goods.splice(secondRealIndex,1);
            });
            layer.msg('删除成功');
        });
    }
    /*删除元素*/
    $scope.delItem = function(type,index,delType){
        var realIndex = -1;
        /*获取要删除的真正索引*/
        realIndex = $scope.getRealIndex($scope[type],index);
        console.log(index+"---"+type + "-->" + realIndex);
        layer.confirm('您确定要删除吗？', {
            title:'删除提示',
            btn: ['确定','取消']
        }, function(){
            $scope.$apply(function(){
                $scope[type].splice(realIndex,1);
            });
            console.log($scope[type].length);
            layer.msg('删除成功');
            if(delType==1){
                $(".edit-con").stop().hide();
            }
        });
    }

    $(function() {
    	/*添加当前编辑正在样式*/
        $(".mobile-con").on('click', '[data-content]', function(event) {
            event.preventDefault();
            $(".edit-con").stop().hide();
            var $this = $(this);
            var name = $this.data('content');
            var pageScrollTop = $(".page-content").scrollTop();
            var marginTop = $this.offset().top + pageScrollTop - 117;
            $('.page-content').animate({
                scrollTop:(marginTop-150)+'px'
            }, 600);
            $this.parents('.mobile-con').find('[data-content]').removeClass('cur-edit');
            $this.addClass('cur-edit');
            $(".edit-con").css({
                "margin-top": marginTop + 'px'
            });
            $(".edit-con").stop().show();
            $this.parents(".preview-page").find(".edit-con [data-edit=" + name + "]").stop().show().siblings('div').stop().hide();
        });
        /*橱窗鼠标滑过编辑样式*/
        $(".shopwindow").on('mouseenter mouseleave', '.window-wrapper', function(event) {
        	event.preventDefault();
        	var eventType = event.type;
        	if(eventType=='mouseenter' && !$(this).hasClass('now-edit')){
        		$(this).addClass('now-edit').siblings().removeClass('now-edit');
        	}else{
        		$(this).parents('.shopwindow').find('.window-wrapper').removeClass('now-edit');
        	}
        });
        $(".hot-product").on('click', '.goods-show .edit-goodsfenlei span', function(event) {
        	event.stopPropagation();
        });
        /*商品全选*/
        $('#myGoodslist').on('click', '.choose-goods-content .check,.choose-goods-content .checkall', function(event) {
            var $this = $(this);
            if($this.hasClass('checkall')){
                if($this.find('input').is(':checked')){
                    $this.parents('.choose-goods-content').find('input').prop("checked",true);
                }else{
                    $this.parents('.choose-goods-content').find('input').prop("checked",false);
                }
            }else{
                var inputLength = $this.parents('.choose-goods-content').find('.check input').length;
                var inputCheckLength = $this.parents('.choose-goods-content').find('.check input:checked').length;
                console.log(inputLength+"--"+inputCheckLength);
                if(inputLength === inputCheckLength){
                    $this.parents('.choose-goods-content').find('.checkall input').prop("checked",true);
                }else{
                    $this.parents('.choose-goods-content').find('.checkall input').prop("checked",false);
                }
            }
        });
        // 搜索区域背景色
        $("#searchBgColor").spectrum({
            color: "#76AC26",
            showButtons: false,
            showInitial: true,
            showPalette: true,
            showSelectionPalette: true,
            maxPaletteSize: 10,
            preferredFormat: "hex",
            move: function (color) {
                var realColor = color.toHexString();
                $(".index-top").css("background-color",realColor);
                $scope.pageTop.searchBgColor = realColor;
            },
            palette: [
                    ['black', 'white', 'blanchedalmond',
                    'rgb(255, 128, 0);', '#6bc86b'],
                    ['red', 'yellow', '#16cfc0', 'blue', 'violet']
                ]
            
        });
        // 输入框背景色
        $("#inputBgColor").spectrum({
            color: "#9FC567",
            showButtons: false,
            showInitial: true,
            showPalette: true,
            showSelectionPalette: true,
            maxPaletteSize: 10,
            preferredFormat: "hex",
            move: function (color) {
                var realColor = color.toHexString();
                $("#searchInput").css("background-color",realColor);
                $scope.pageTop.searchBgColor = realColor;
            },
            palette: [
                    ['black', 'white', 'blanchedalmond',
                    'rgb(255, 128, 0);', '#6bc86b'],
                    ['red', 'yellow', '#16cfc0', 'blue', 'violet']
                ]
            
        });
    });

}]);


