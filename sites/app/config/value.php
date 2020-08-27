<?php
/**
 * 默认值配置文件
 */
return array(
	//合伙人默认配置
	'branch_cfg'	=> array(
		'tc_fx_banner'		=> '/public/manage/branch/images/shouye.png',
		'tc_fx_desc'		=> '合伙人的商品销售统一由厂家直接收款,直接发货,并提供产品的售后服务,分销佣金由厂家统一设置。',
		'tc_fx_privilege'	=> array(
			array(
				'index' 	 => 0,
				'iconSrc' 	 => '/public/manage/branch/images/chaoshi@2x.png',
				'firstTitle' => '分销二维码',
				'secondTitle'=> '拥有自己推广二维码'
			),
			array(
				'index' 	 => 1,
				'iconSrc' 	 => '/public/manage/branch/images/renminbi@2x.png',
				'firstTitle' => '销售拿佣金',
				'secondTitle'=> '卖出商品可获取收益'
			)
		),
		'tc_fx_hasname'      => 1,
		'tc_fx_hasphone'     => 1,
		'tc_fx_haswx' 		 => 1
	),
	//模版橱窗
	'tpl_window' => array(
		'index'     => 0,
		'styleType' => 1,
		'goods' 	=> array(
			array(
				'index'  => 0,
				'imgSrc' => "/public/manage/newTemThree/images/tuijian-img01.jpg",
				'link'   => ''
			),
			array(
				'index'  => 1,
				'imgSrc' => "/public/manage/newTemThree/images/tuijian-img02.jpg",
				'link'   => ''
			),
			array(
				'index'  => 2,
				'imgSrc' => "/public/manage/newTemThree/images/tuijian-img03.jpg",
				'link'   => ''
			),
		),
	),
	'tpl_goods_group' => array(
		'index'     => 0,
		'imgSrc'    => '/public/manage/newTemThree/images/goodsfenlei1.png',
		'styleType' => 1,
		'goods' 	=> array(
			array(
				'index'  => 0,
				'imgSrc' => '/public/manage/img/zhanwei/zw_fxb_45_45.png',
				'title'  => '双层热饮杯 防烫 环保 新款',
				'price'	 => '￥999',
			),
			array(
				'index'  => 1,
				'imgSrc' => '/public/manage/img/zhanwei/zw_fxb_45_45.png',
				'title'  => '双层热饮杯 防烫 环保 新款',
				'price'	 => '￥999',
			),
			array(
				'index'  => 2,
				'imgSrc' => '/public/manage/img/zhanwei/zw_fxb_45_45.png',
				'title'  => '双层热饮杯 防烫 环保 新款',
				'price'	 => '￥999',
			),
		),
	),
	'store_card' => array(
		'oc_id'  		=> 0,
		'oc_name' 		=> '门店消费折扣月卡',
		'oc_name_sub' 	=> '每月都有优惠',
		'oc_bg_type' 	=> 1,
		'oc_long' 		=> 30,
		'oc_long_type' 	=> 2,
		'oc_price' 		=> 0.00,
		'oc_times' 		=> 0,
		'oc_rights' 	=> '',
		'oc_notice' 	=> '',
		'oc_0f_deduct'  => 0,
		'oc_1f_deduct'  => 0,
		'oc_2f_deduct'  => 0,
		'oc_3f_deduct'  => 0,
	),
	'single_graphic' => array(
		'wn_id' 	=> 0 ,
		'wn_pic' 	=> '/public/manage/img/zhanwei/zw_fxb_75_36.png',
		'wn_title' 	=> '',
		'wn_brief' 	=> '',
		'wn_url' 	=> '',
		'items'		=> '[
				{
					index:0,
					imgSrc:"/public/manage/img/zhanwei/zw_fxb_75_36.png",
					title:"小条目内容标题一",
					link:"",
				},{
					index:1,
					imgSrc:"/public/manage/img/zhanwei/zw_fxb_75_36.png",
					title:"小条目内容标题二",
					link:"",
				}
			]',
	),
	'default_avatar'	=> array(
		-1	=> array('avatar' => '', '' => ''),
		-2	=> array('avatar' => '', '' => ''),
		-3	=> array('avatar' => '', '' => ''),
		-4	=> array('avatar' => '', '' => ''),
		-5	=> array('avatar' => '', '' => ''),
		-6	=> array('avatar' => '', '' => ''),
		-7	=> array('avatar' => '', '' => ''),
		-8	=> array('avatar' => '', '' => ''),
		-9	=> array('avatar' => '', '' => ''),
	),

	// app店铺id
	'app_shop_id' => 0,
);