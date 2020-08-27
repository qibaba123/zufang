<?php
/**
 * Created by PhpStorm.
 * 自定义模板组件
 */
return array(
    //基础组件
    'base' => array(
        array(//0
            'type'        => 'slide',
            'typeText'    => '轮播',
            'icon'        => 'slide',
            'isShowvideo' => true,
            'style'       => array(
                'height'       => 200,
                'marginTop'    => 0,
                'paddingLeft'  => 0,
                'paddingRight' => 0,
                'marginBottom' => 0
            ),
            'borderRadius' => 0,
            'autoplay'     => true,
            'interval'     => 4000, //滑动间隔时长
            'duration'     => 1000, //动画时长
            'indicatorColor' => '#fff',
            'indicatorActiveColor' => '#000',
            'slideimgs' => array(
                array(
                    "img"  => '/public/wxapp/customtpl/images/banner_750_400.png',
                    'link' =>array(
                        'type' =>1,
                        'url'  =>''
                    ),
                )
            )
        ),
        array(//1
            'type'        => 'video',
            'typeText'    => '视频',
            'icon'        => 'shipin',
            'autoplay'    => false,
            'style'       => array(
                'height'       => 200,
                'marginTop'    => 0,
                'paddingLeft'  => 0,
                'paddingRight' => 0,
                'marginBottom' => 0
            ),
            'videolink'  => '',
            'videocover' => ''
        ),
        array(//2
            'type'     => 'fenlei',
            'typeText' => '分类导航',
            'icon'     => 'fenleiye',
            'style'    => array(
                'color'        => '#666',
                'width'        => 100,
                'marginTop'    => 0,
                'marginBottom' => 0,
                'backgroundColor' => '',
                'borderRadius' => 0,
                'fontSize'     => 13
            ),
            'iconRadius' =>10,
            'briefColor' =>'#999',
            'indicatorColor' =>'#fff',
            'indicatorActiveColor'=> '#000',
            'navNumber'  =>4,
            'navpages'   =>[1],
            'styleType'  =>1,//1单行滑动 2、双行滑屏 3、带简介导航
            'flitems'    => array(
                    array(
                        "icon"  =>  '/public/wxapp/customtpl/images/banner_750_400.png',
                        "name"  => '分类名称',
                        "brief" => '内容简介',
                        'link'  => array(
                            'type' => 1,
                            'url'  => ''
                        )
                    ),
            )
        ),
        array(//3
            'type'     => 'search',
            'typeText' =>'搜索',
            'placeHolder' =>'请输入搜索内容',
            'icon'     => 'dibianlansousuodianji',
            'searchType' => 1,
            'searchiconColor'=>'black',//white或black
            'searchArea' =>array(
                'backgroundColor' => '#fff',
                'marginTop'     => 0,
                'marginBottom'  => 0,
                'paddingTop'    => 10,
                'paddingBottom' =>10
            ),
            'style'=>array(
                'height'   => 40,
                'width'    =>90,
                'fontSize' =>14,
                'backgroundColor' => '#fff',
                'borderRadius' => 45,
                'color'        =>'#999',
                'borderColor'  =>'#ddd'
            ),
        ),
        array(//4
            'type'     => 'address',
            'typeText' => '地址',
            'icon'     => 'dizhi1',
            'addressStyle' => 1,//1单地址 2电话地址 3店铺简介
            'companyLogo'  => '/public/wxapp/customtpl/images/banner_750_400.png',
            'companyName'  => '公司名称',
            'businessTime' => '09:00-18:00',
            'companyBrief' => '公司内容简介',
            'companyLink'  => '',
            'mobile'       => '15534876467',
            'address'      => array(
                'longitude' => '113.72052',
                'latitude'  => '34.77485',
                'addr'      => '郑州市郑东新区CBD商务内环11号金成东方国际24楼2402室'
            ),
            'lat'   => '',
            'lng'   => '',
            'style' => array(
                'color'     => '#777',
                'fontSize'  => 14 ,
                'marginTop' => 0,
                'marginBottom' => 0
            ),
        ),
        array(//5
            'type'       => 'notice',
            'typeText'   => '通知公告',
            'icon'       => 'tzgg',
            'isBold'     => false,
            'titleTxt'   =>'最新头条',
            'titleColor' =>'#38f',
            'noticeTxt'  =>array(
                    [
                        'text' => '公告标题',
                        'link' => ''
                    ],
                    [
                        'text' => '公告标题',
                        'link' => ''
                    ],[
                        'text' => '公告标题',
                        'link' => ''
                    ]
                ),
            'style' => array(
                'color'           => '#777',
                'fontSize'        => 14 ,
                'marginTop'       => 0,
                'marginBottom'    => 0,
                'backgroundColor' => '#fff'
            ),
        ),
        array(//6
            'type'       => 'title',
            'typeText'   => '标题',
            'icon'       => 'biaoti',
            'titleStyle' => 1,
            'titleBg'    => '/public/wxapp/customtpl/images/banner_750_400.png',
            'isBold'     => false,
            'lineColor'  => '#38f',
            'style'      => array(
                'color'         => '#333',
                'paddingTop'    =>13,
                'paddingBottom' =>13,
                'marginBottom'  =>0 ,
                'marginTop'     =>0,
                'backgroundColor' => '#fff',
                'textAlign'     =>'left',
                'fontSize'      =>15
            ),
            'link' =>array(
                'type' => 1,
                'url'  => ''
            ),
            "titleTxt"   => "标题文本"
        ),
        array(//7
            'type'     => 'image',
            'typeText' => '图片',
            'icon'     => 'tupian',
            'imageUrl' => '/public/wxapp/customtpl/images/banner_750_400.png',
            'imageLocation' => 'center',
            'link' =>array(
                'type' => 1,
                'url'  => ''
            ),
            'imageStyle' => array(
                'width'        => 375,
                'height'       => 100,
                'borderRadius' => 0
            ),
            'style'=> array(
                'marginBottom'  => 0,
                'marginTop'     => 0,
                'paddingLeft'   => 0,
                'paddingTop'    => 0,
                'paddingBottom' => 0,
                'textAlign'     => 'left',
                'backgroundColor' => '#fff'
            ),
        ),
        array(//8
            'type'     => 'window',
            'typeText' => '橱窗',
            'icon'     => 'chuchuang',
            'windowStyle' => 1, //1双列 2左一右二 3左二右一
            'imageStyle' => array(
                'borderRadius' => 0,
                'padding' => 3
            ),
            'link1' =>array(
                'imageUrl' => '/public/wxapp/customtpl/images/banner_750_400.png',
                'type' => 1,
                'url'  => ''
            ),
            'link2' =>array(
                'imageUrl' => '/public/wxapp/customtpl/images/banner_750_400.png',
                'type' => 1,
                'url'  => ''
            ),
            'link3' =>array(
                'imageUrl' => '/public/wxapp/customtpl/images/banner_750_400.png',
                'type' => 1,
                'url'  => ''
            ),
            'style'=> array(
                'height'        => 187,
                'marginBottom'  => 0,
                'marginTop'     => 0,
                'paddingLeft'   => 0,
                'paddingRight'  => 0,
                'paddingTop'    => 0,
                'paddingBottom' => 0,
                'backgroundColor' => '#fff'
            ),
        ),
        array(//9
            'type'     => 'button',
            'typeText' => '按钮',
            'icon'     => 'anniu',
            'link'     => array(
                'type' => 1,
                'url'  => ''
            ),
            'btntxt'   => '分享',
            'buttonStyle' => array(
                'width'  => 100,
                'height' => 45,
                'lineHeight' => 45,
                'borderRadius' => 8,
                'backgroundColor' => 'red',
                'borderColor' => 'red',
                'color' => '#fff',
                'fontSize' => 15
            ),
            'style' => array(
                'paddingTop'    => 10,
                'paddingBottom' => 10,
                'textAlign'     => 'center'
            ),
        ),
        array(//10
            'type'     => 'space',
            'typeText' => '分割线',
            'icon'     => 'Cutoff',
            'spaceStyle' => array(
                'width' =>375,
                'borderTopColor' => 'red',
                'borderTopStyle' => 'solid',
                'borderTopWidth' => 2
            ),
            'style' => array(
                'textAlign'   => 'center',
                'paddingLeft' => 0,
                'marginTop'   => 0
            ),
        ),
        array(//12
            'type'      => 'pictxt',
            'typeText'  => '图文列表',
            'icon'      => 'ai-img-list',
            'picStyle'     => 1,//1单行滑动 2正常平铺
            'titleStyle'   => 1,//1悬浮标题 2正常标题 3无标题
            'singleImgNum' => 1,
            'isShowbrief'  => true,
            'briefFontcolor' =>'#999',
            'titleCss'     => array(
                'fontSize'   => 14,
                'color'      => '#eee',
                'lineHeight' => 20
            ),
            'imageStyle'   => array(
                'height' => 100,
                'borderRadius' => 0
            ),
            'style' => array(
                'marginTop' => 0,
                'marginBottom' => 0,
                'textAlign' => 'left'
            ),
            'picData'=>[
                [
                    'title' => '标题名称',
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '内容简介简介简介',
                    'link'  => [
                        'type'  => 1,
                        'url' =>''
                    ],
                ],
                [
                    'title' => '标题名称',
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '内容简介简介简介',
                    'link'  => [
                        'type'  => 1,
                        'url' =>''
                    ],
                ],
                [
                    'title' => '标题名称',
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '内容简介简介简介',
                    'link'  => [
                        'type'  => 1,
                        'url' =>''
                    ],
                ],
                [
                    'title' => '标题名称',
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '内容简介简介简介',
                    'link'  => [
                        'type'  => 1,
                        'url' =>''
                    ],
                ],
            ]
        ),
        array(//13
            'type'      => 'advertisement',
            'typeText'  => '广告位',
            'icon'      => 'guanggaoweiguanli',
            'unitId'    => '',
            'style' => array(
                'marginBottom'  => 0,
                'marginTop'     => 0,
            ),
        ),
        array(//18
            'type'       => 'courselist',
            'typeText'   => '课程列表',
            'icon'       => 'shangpinliebiao1',
            'goodStyle'  => 1,
            'isShowsold' => true,
            'isShowcart' => true,
            'isShowmore' => false,
            'priceBold'  => false,
            'cartBgcolor' => '#b6d7a8',
            'goodSourceType' => 1,
            'goodSource' => '',
            'goodsNum'   => 4,
            'titleStyle' => array(
                'color'    => '#333',
                'fontSize' => 15
            ),
            'priceStyle' => array(
                'color'    => 'red',
                'fontSize' => 15),
            'style'      => array(
                'marginTop' => 0,
                'marginBottom' => 0
            ),
            'labelStyle' => array(
                'background' => '#faf2f5',
                'color' => '#c69693'
            ),
            'goodsData'=>[
                [
                    'title' => '课程标题',
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '商品简介',
                    'price' => 99,
                    'sold'  => 67,
                ],
                [
                    'title' => '课程标题',
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '商品简介',
                    'price' => 99,
                    'sold'  => 67,
                ],
                [
                    'title' => '课程标题',
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '商品简介',
                    'price' => 99,
                    'sold'  => 67,
                ],
                [
                    'title' => '课程标题',
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '商品简介',
                    'price' => 99,
                    'sold'  => 67,
                ],
                [
                    'title' => '课程标题',
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '商品简介',
                    'price' => 99,
                    'sold'  => 67,
                ],
                [
                    'title' => '课程标题',
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '商品简介',
                    'price' => 99,
                    'sold'  => 67,
                ],
                [
                    'title' => '课程标题',
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '商品简介',
                    'price' => 99,
                    'sold'  => 67,
                ],
                [
                    'title' => '课程标题',
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '商品简介',
                    'price' => 99,
                    'sold'  => 67,
                ],
                [
                    'title' => '课程标题',
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '商品简介',
                    'price' => 99,
                    'sold'  => 67,
                ],
                [
                    'title' => '课程标题',
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '商品简介',
                    'price' => 99,
                    'sold'  => 67,
                ]
            ]
        ),
        array(//22
            'type'       => 'quotationList',
            'typeText'   => '经典语录',
            'icon'       => 'shangpinliebiao1',
            'isShowmore' => false,
            'quotationNum'   => 1,
            'fontStyle' => array(
                'color'    => '#333',
                'fontSize' => 15
            ),
            'style'      => array(
                'marginTop' => 0,
                'marginBottom' => 0
            ),
            'quotationId'  => 0,
            'quotationData'=>[
                [
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '经典语录经典语录经典语录经典语录经典语录经典语录经典语录经典语录经典语录',
                ],
                [
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '经典语录经典语录经典语录经典语录经典语录经典语录经典语录经典语录经典语录',
                ],
                [
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '经典语录经典语录经典语录经典语录经典语录经典语录经典语录经典语录经典语录',
                ],
                [
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '经典语录经典语录经典语录经典语录经典语录经典语录经典语录经典语录经典语录',
                ],
                [
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '经典语录经典语录经典语录经典语录经典语录经典语录经典语录经典语录经典语录',
                ],
                [
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '经典语录经典语录经典语录经典语录经典语录经典语录经典语录经典语录经典语录',
                ],
                [
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '经典语录经典语录经典语录经典语录经典语录经典语录经典语录经典语录经典语录',
                ],
                [
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '经典语录经典语录经典语录经典语录经典语录经典语录经典语录经典语录经典语录',
                ],
                [
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '经典语录经典语录经典语录经典语录经典语录经典语录经典语录经典语录经典语录',
                ],
                [
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '经典语录经典语录经典语录经典语录经典语录经典语录经典语录经典语录经典语录',
                ]
            ]
        ),
        array(//23
            'type'      => 'recommendList',
            'typeText'  => '推荐列表',
            'icon'      => 'ai-img-list',
            'isShowmore' => 0,
            'recommendNum' => 4,
            'picStyle'     => 1,//1单行滑动 2正常平铺
            'titleStyle'   => 1,//1悬浮标题 2正常标题 3无标题
            'singleImgNum' => 1,
            'isShowbrief'  => true,
            'recommendTypeList' => [//推荐内容类型，以具体小程序类型为准
                [
                    'id' => 1,
                    'name' => '资讯'
                ],
                [
                    'id' => 2,
                    'name' => '课程'
                ],
            ],
            'recommendType' => 1,
            'briefFontcolor' =>'#999',
            'titleCss'     => array(
                'fontSize'   => 14,
                'color'      => '#eee',
                'lineHeight' => 20
            ),
            'imageStyle'   => array(
                'height' => 100,
                'borderRadius' => 0
            ),
            'style' => array(
                'marginTop' => 0,
                'marginBottom' => 0,
                'textAlign' => 'left'
            ),
            'picData'=>[
                [
                    'title' => '标题名称',
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '内容简介简介简介',
                    'link'  => [
                        'type'  => 1,
                        'url' =>''
                    ],
                ],
                [
                    'title' => '标题名称',
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '内容简介简介简介',
                    'link'  => [
                        'type'  => 1,
                        'url' =>''
                    ],
                ],
                [
                    'title' => '标题名称',
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '内容简介简介简介',
                    'link'  => [
                        'type'  => 1,
                        'url' =>''
                    ],
                ],
                [
                    'title' => '标题名称',
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '内容简介简介简介',
                    'link'  => [
                        'type'  => 1,
                        'url' =>''
                    ],
                ],
                [
                    'title' => '标题名称',
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '内容简介简介简介',
                    'link'  => [
                        'type'  => 1,
                        'url' =>''
                    ],
                ],
                [
                    'title' => '标题名称',
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '内容简介简介简介',
                    'link'  => [
                        'type'  => 1,
                        'url' =>''
                    ],
                ],
                [
                    'title' => '标题名称',
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '内容简介简介简介',
                    'link'  => [
                        'type'  => 1,
                        'url' =>''
                    ],
                ],
                [
                    'title' => '标题名称',
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '内容简介简介简介',
                    'link'  => [
                        'type'  => 1,
                        'url' =>''
                    ],
                ],
                [
                    'title' => '标题名称',
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '内容简介简介简介',
                    'link'  => [
                        'type'  => 1,
                        'url' =>''
                    ],
                ],
                [
                    'title' => '标题名称',
                    'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                    'brief' => '内容简介简介简介',
                    'link'  => [
                        'type'  => 1,
                        'url' =>''
                    ],
                ],
            ]
        ),
    ),
    'marketing' => array(
        //营销组件
        array(
            'type'       => 'coupon',
            'typeText'   => '优惠券',
            'icon'       => 'youhuiquan',
            'getType'    => 1,
            'isShowover' => false,
            'valueStyle' => array(
                'color'    => '#fff',
                'fontSize' => 18
            ),
            'limitStyle' => array(
                'color'    => '#fff',
                'fontSize' => 14
            ),
            'receiveStyle' => array(
                'color' => '#FFD48C'
            ),
            'style'      => array(
                'marginTop' => 0,
                'marginBottom' => 0,
                'paddingTop' => 10,
                'paddingBottom' => 10,
            ),
            'couponData'=>array()
        ),
        array(
            'type'       => 'group',
            'typeText'   => '拼团',
            'icon'       => 'pintuangou',
            'goodStyle'  => 1,
            'getType'    => 1,
            'isShowmore' => false,
            'priceBold'  => false,
            'openBgcolor' => 'red',
            'goodsNum'   => 4,
            'titleStyle' => array(
                'color'    => '#333',
                'fontSize' => 15
            ),
            'priceStyle' => array(
                'color'    => 'red',
                'fontSize' => 15
            ),
            'style'      => array(
                'marginTop' => 0,
                'marginBottom' => 0
            ),
            'goodsData'=>array()
        ),
        array(
            'type'       => 'seckill',
            'typeText'   => '秒杀',
            'icon'       => 'miaosha',
            'goodStyle'  => 1,
            'getType'    => 1,
            'isShowmore' => false,
            'priceBold'  => false,
            'openBgcolor' => 'red',
            'goodsNum'   => 4,
            'titleStyle' => array(
                'color'    => '#333',
                'fontSize' => 15
            ),
            'priceStyle' => array(
                'color'    => 'red',
                'fontSize' => 15
            ),
            'style'      => array(
                'marginTop' => 0,
                'marginBottom' => 0
            ),
            'goodsData'=>array()
        ),
        array(
            'type'       => 'bargain',
            'typeText'   => '砍价',
            'icon'       => 'kanjia-',
            'goodStyle'  => 1,
            'getType'    => 1,
            'isShowmore' => false,
            'priceBold'  => false,
            'openBgcolor' => 'red',
            'goodsNum'   => 4,
            'titleStyle' => array(
                'color'    => '#333',
                'fontSize' => 15
            ),
            'priceStyle' => array(
                'color'    => 'red',
                'fontSize' => 15),
            'style'      => array(
                'marginTop' => 0,
                'marginBottom' => 0
            ),
            'goodsData'=>array()
        ),
    )
);