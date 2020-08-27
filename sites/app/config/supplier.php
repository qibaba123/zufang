<?php
/**
 * 社区团购 供应商后台菜单
 * 2019-04-16
 * zhangzc
 */
return [
	'menu'	=>[
		// [
		// 	'title'		=>'首页',
		// 	'link'		=>'/index/index',
		// 	'icon'		=>'fas fa-tachometer-alt',
		// 	'access'	=>'',
		// ],
		// 配送管理
		[
			'title'		=>'配送中心',
			'link'		=>'/delivery/delivery',
			'icon'		=>'fas fa-truck',
			'access'	=>'',
			// 'submenu'	=>[
			// 	[
			// 		'title'     => '配送管理',
   //                  'link'      => '/delivery/delivery',
   //                  'icon'      => 'fas fa-cart-arrow-down',
			// 	],
			// 	[
			// 		'title'     => '配送记录',
   //                  'link'      => '/delivery/deliveryRecord',
   //                  'icon'      => 'fas fa-clipboard-list',
			// 	],
			// ]
		],
		[
			'title'		=>'申请产品管理',
			'link'		=>'#',
			'icon'		=>'fa fa-paper-plane',
			'access'	=>'',
			'submenu'	=>[
				[
					'title'		=>'商品列表',
					'link'		=>'/goods/supplierGoodsList',
					'icon'		=>'fa fa-list-ul',
					'access'	=>'',
				],
				[
					'title'		=>'新增商品',
					'link'		=>'/goods/goodsEdit',
					'icon'		=>'fa fa-plus-square',
					'access'	=>'',
				],
			],
		],
		[
			'title'		=>'在售商品',
			'link'		=>'/goods/goodsList',
			'icon'		=>'fas fa-gift',
			'access'	=>'',
		],
		[
			'title'		=>'商品销售排行',
			'link'		=>'/goods/goodsRank',
			'icon'		=>'fas fa-crown',
			'access'	=>'',
		],
		[
			'title'		=>'商品评价',
			'link'		=>'/goods/goodsComment',
			'icon'		=>'fas fa-comment',
			'access'	=>'',
		],
		[
			'title'		=>'订单管理',
			'link'		=>'/trade/tradeList',
			'icon'		=>'fas fa-bars',
			'access'	=>'',
		],
	]
];