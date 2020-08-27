var app = angular.module('chApp', ["ui.sortable"]);
app.controller('chCtrl', function($scope) {
    $scope.banners = [
    	{
    		index: 0,
    		imgsrc: 'images/1.jpg',
    		link: 'http://www.fenxiaobao.xin/manage/index/index'
    	},
    	{
    		index: 1,
    		imgsrc: 'images/2.jpg',
    		link: ''
    	}
    ];
    $scope.fenleiNavs = [
    	{
    		index: 0,
    		imgsrc: 'images/icon_index_yongpin.png',
    		title: '餐饮用品',
    		link: 'http://www.caihewang.cn/mobile/index'
    	},
    	{
    		index: 1,
    		imgsrc: 'images/icon_index_dingzhi.png',
    		title: '品牌定制',
    		link: ''
    	},
    	{
    		index: 2,
    		imgsrc: 'images/icon_index_anli.png',
    		title: '案例精选',
    		link: ''
    	},
    	{
    		index: 3,
    		imgsrc: 'images/icon_index_weihuo.png',
    		title: '尾货特卖',
    		link: ''
    	}
    ];
    $scope.noticeTxts = [
    	{
    		index: 0,
    		text: '水果忍者：穿靴子的猫',
    		link:'http://www.caihewang.cn/mobile/index'
    	},
    	{
    		index: 1,
    		text: '乐动魔方 Plus',
    		link:''
    	},
    	{
    		index: 2,
    		text: '亡灵杀手 汉化版',
    		link:''
    	},
    	{
    		index: 3,
    		text: 'jq22 搜集整理',
    		link:''
    	},
    	{
    		index: 4,
    		text: '你疯啦 iphone壁纸',
    		link:''
    	}
    ];
    $scope.productLists = [
    	{
    		index: 0,
    		imgsrc: 'images/sxjg_06.png',
    		name:'双层热饮杯 防烫 环保 新款',
    		price: '￥120',
    		link: ''
    	},
    	{
    		index: 1,
    		imgsrc: 'images/sxjg_06.png',
    		name:'双层热饮杯 防烫 环保 新款',
    		price: '￥120',
    		link: ''
    	},
    	{
    		index: 2,
    		imgsrc: 'images/sxjg_06.png',
    		name:'双层热饮杯 防烫 环保 新款',
    		price: '￥120',
    		link: ''
    	},
    	{
    		index: 3,
    		imgsrc: 'images/sxjg_06.png',
    		name:'双层热饮杯 防烫 环保 新款',
    		price: '￥120',
    		link: ''
    	},
    	{
    		index: 4,
    		imgsrc: 'images/sxjg_06.png',
    		name:'双层热饮杯 防烫 环保 新款',
    		price: '￥120',
    		link: ''
    	}
    ];
    $scope.addNewBanner = function(){
        var banner_length = $scope.banners.length;
        if(banner_length>=8){
            layer.open({
                type: 1,
                title: false,
                shade:0,
                skin: 'layui-layer-error', 
                closeBtn: 0, 
                shift: 5,
                content: '最多只能添加8张广告图哦',
                time: 2000
            });
        }else{
            var banner_Default = {
                index: banner_length,
                imgsrc: 'images/banner.jpg',
                link: 'http://www.fenxiaobao.xin/manage/index/index'
            };
            $scope.banners.push(banner_Default);
        }
    }
    /*添加分类导航方法*/
    $scope.addNewfenleiNav = function(){
        var fenleiNav_length = $scope.fenleiNavs.length;
        if(fenleiNav_length>=8){
            layer.open({
                type: 1,
                title: false,
                shade:0,
                skin: 'layui-layer-error', 
                closeBtn: 0, 
                shift: 5,
                content: '最多只能添加8个分类导航哦',
                time: 2000
            });
        }else{
            var fenleiNav_Default = {
                index: fenleiNav_length,
                imgsrc: 'images/icon_index_yongpin.png',
                title: '默认导航',
                link: 'http://www.caihewang.cn/mobile/index'
            };
            $scope.fenleiNavs.push(fenleiNav_Default);
        }
    }
    /*添加幻灯方法*/
    $scope.addNewnoticeTxt = function(){
        var noticeTxt_length = $scope.noticeTxts.length;
        var noticeTxt_Default = {
            index: noticeTxt_length,
            text: '新通知文字',
            link:''
        };
        $scope.noticeTxts.push(noticeTxt_Default);
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
    /*删除元素*/
    $scope.delIndex=function(type,index){
        var realIndex=-1;
        /*获取要删除的真正索引*/
        realIndex = $scope.getRealIndex($scope[type],index);
        console.log(type+"-->"+realIndex);
        layer.confirm('您确定要删除吗？', {
            title:'删除提示',
            btn: ['确定','取消'] 
        }, function(){
            if($scope[type].length>1){
                $scope.$apply(function(){
                    $scope[type].splice(realIndex,1);
                });
                layer.msg('删除成功');
            }else{
                layer.msg('最少要留一个哦');
            }
        });
    }
    

    //监控菜单改变 刷新菜单
    /*$scope.$watch("banners",function(newvalue){
        console.log(newvalue);
        for(index in newvalue){
            $scope.banners.index=index;
        }
    },true);*/
});