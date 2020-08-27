<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/1/11
 * Time: 下午10:00
 */

//求职内推小程序配置文件
return array(
    //薪资范围
    'salary' => array(
        array(
            'id' => 1,
            'title' => '面议',
            'min' => 0,
            'max' => 0
        ),
        array(
            'id' => 2,
            'title' => '1K以下',
            'min' => 0,
            'max' => 1,
        ),
        array(
            'id' => 3,
            'title' => '1K-2K',
            'min' => 1,
            'max' => 2,
        ),
        array(
            'id' => 4,
            'title' => '2K-3K',
            'min' => 2,
            'max' => 3,
        ),
        array(
            'id' => 5,
            'title' => '3K-5K',
            'min' => 3,
            'max' => 5,
        ),
        array(
            'id' => 6,
            'title' => '5K-8K',
            'min' => 5,
            'max' => 8,
        ),
        array(
            'id' => 7,
            'title' => '8K-12K',
            'min' => 8,
            'max' => 12,
        ),
        array(
            'id' => 8,
            'title' => '12K-20K',
            'min' => 12,
            'max' => 20,
        ),
        array(
            'id' => 9,
            'title' => '20K-25K',
            'min' => 20,
            'max' => 25,
        ),
        array(
            'id' => 10,
            'title' => '25K以上',
            'min' => 25,
            'max' => 100000000,
        ),
    ),
    //学历要求
    'education' => array(
        array(
            'id' => '0',
            'title' => '学历不限'
        ),
        array(
            'id' => '1',
            'title' => '初中及以下'
        ),
        array(
            'id' => '2',
            'title' => '高中'
        ),
        array(
            'id' => '3',
            'title' => '技校'
        ),
        array(
            'id' => '4',
            'title' => '中专'
        ),
        array(
            'id' => '5',
            'title' => '大专'
        ),
        array(
            'id' => '6',
            'title' => '本科'
        ),
        array(
            'id' => '7',
            'title' => '硕士'
        ),
        array(
            'id' => '8',
            'title' => '博士'
        ),
    ),
    //工作经验
    'workYears' => array(
        array(
            'id' => '0',
            'title' => '经验不限'
        ),
        array(
            'id' => '1',
            'title' => '应届毕业生'
        ),
        array(
            'id' => '2',
            'title' => '1年以下'
        ),
        array(
            'id' => '3',
            'title' => '1-2年'
        ),
        array(
            'id' => '4',
            'title' => '3-5年'
        ),
        array(
            'id' => '5',
            'title' => '6-7年'
        ),
        array(
            'id' => '6',
            'title' => '8-10年'
        ),
        array(
            'id' => '7',
            'title' => '10年以上'
        ),
    ),

    //工作状态
    'workStatus' => array(
        array(
            'id' => 1,
            'title' => '离职-随时到岗'
        ),
        array(
            'id' => 2,
            'title' => '在职-暂不考虑'
        ),
        array(
            'id' => 3,
            'title' => '在职-考虑机会'
        ),
        array(
            'id' => 4,
            'title' => '在职-月内到岗'
        ),
    ),

    //到岗时间
    'arrivalTime' => array(
        array(
            'id' => 1,
            'title' => '一周内'
        ),
        array(
            'id' => 2,
            'title' => '一月内'
        ),
    ),

    //工作性质
    'workType' => array(
        array(
            'id' => 1,
            'title' => '全职',
        ),
        array(
            'id' => 2,
            'title' => '兼职',
        ),
        array(
            'id' => 3,
            'title' => '实习',
        ),
    ),

    //融资情况
    'finance' => array(
        array(
            'id' => 1,
            'title' => '未融资',
        ),
        array(
            'id' => 2,
            'title' => '天使轮',
        ),
        array(
            'id' => 3,
            'title' => 'A轮',
        ),
        array(
            'id' => 4,
            'title' => 'B轮',
        ),
        array(
            'id' => 5,
            'title' => 'C轮',
        ),
        array(
            'id' => 6,
            'title' => 'D轮及以上',
        ),
        array(
            'id' => 7,
            'title' => '上市公司',
        ),
        array(
            'id' => 8,
            'title' => '不需要融资',
        ),
    ),

    //投递状态
    'sendStatus' => array(
        'all'   => array(
            'id'    => 0,
            'label' => '全部'
        ),
        'send'   => array(
            'id'    => 1,
            'label' => '已投递'
        ),
        /*'invite'   => array(
            'id'    => 2,
            'label' => '待邀请'
        ),*/
        'confirm'   => array(
            'id'    => 3,
            'label' => '面试待确认'
        ),
        'interview'   => array(
            'id'    => 4,
            'label' => '待面试'
        ),
        'hadInterview'   => array(
            'id'    => 5,
            'label' => '已面试'
        ),
        'entry'   => array(
            'id'    => 6,
            'label' => '已入职'
        ),
        'hanEntry'   => array(
            'id'    => 7,
            'label' => '已入职',
            'desc'  => '已领取入职奖'
        ),
        'refuse'   => array(
            'id'    => 8,
            'label' => '不合适'
        ),
        'notInterview'   => array(
            'id'    => 9,
            'label' => '未面试'
        ),
    ),

    'sendStatusSelect' => array(
        1 => '已投递',
        //2 => '待邀请',
        3 => '面试待确认',
        4 => '待面试',
        5 => '已面试',
        6 => '已入职',
        7 => '已入职',
        8 => '不合适',
        9 => '未面试'
    ),

    'companySize' => array(
        array(
            'id'    => 1,
            'title' => '20人以下'
        ),
        array(
            'id'    => 2,
            'title' => '20-99人'
        ),
        array(
            'id'    => 3,
            'title' => '100-499人'
        ),
        array(
            'id'    => 4,
            'title' => '500-999人'
        ),
        array(
            'id'    => 5,
            'title' => '1000-9999人'
        ),
        array(
            'id'    => 6,
            'title' => '10000人以上'
        ),
    ),

    'salaryUnit' => array(
        array(
            'id'    => 1,
            'title' => '元'
        ),
        array(
            'id'    => 2,
            'title' => 'k'
        ),
        array(
            'id'    => 3,
            'title' => '万'
        ),
    ),

    'salaryType' => array(
        array(
            'id'    => 1,
            'title' => '年'
        ),
        array(
            'id'    => 2,
            'title' => '月'
        ),
        array(
            'id'    => 3,
            'title' => '日'
        ),
        array(
            'id'    => 4,
            'title' => '小时'
        ),
    ),

    'trialPeriod' => array(
        array(
            'id'    => 0,
            'title' => '无'
        ),
        array(
            'id'    => 1,
            'title' => '1个月'
        ),
        array(
            'id'    => 2,
            'title' => '2个月'
        ),
        array(
            'id'    => 3,
            'title' => '3个月'
        ),
        array(
            'id'    => 4,
            'title' => '6个月'
        ),
        array(
            'id'    => 5,
            'title' => '12个月'
        ),
    ),

    //会员中心默认配置
    'center_tool'	=> array(
        'ct_style_type'       => 1,
        'ct_center_title'	  => '个人中心',
        'ct_service_title'    => '更多功能', //新版会员中心内容标题
        'ct_myresume_show'	  => 1,//我的简历
        'ct_myrecommend_show' => 1,//我的推荐
        'ct_myposition_show'  => 1,//职位收藏
        'ct_mywallet_show'	  => 1,//我的钱包
        'ct_mycompany_show'	  => 1,//我的公司
        'ct_mykefu_show'	  => 1,//在线客服
        'ct_mychat_show'	  => 1,//私信
        'ct_myresume_name'	  => '我的简历',
        'ct_myrecommend_name' => '我的推荐',
        'ct_myposition_name'  => '职位收藏',
        'ct_mywallet_name'	  => '我的钱包',
        'ct_mycompany_name'	  => '我的公司',
        'ct_mykefu_name'	  => '在线客服',
        'ct_mychat_name'	  => '私信',
        'ct_verify_mobile'    => 0 ,
        'ct_myphone_show'	  => 0,//我的手机号
        'ct_myphone_name'	  => '我的手机号',//我的手机号
    ),

    //会员中心默认配置
    'company_center_tool'	  => array(
        'ct_style_type'       => 1,
        'ct_center_title'	  => '企业中心',
        'ct_service_title'    => '更多功能', //新版会员中心内容标题
        'ct_mycompany_show'	  => 1,//我的公司
        'ct_myposition_show'  => 1,//职位管理
        'ct_myteam_show'      => 1,//我的团队
        'ct_mywallet_show'	  => 1,//我的钱包
        'ct_myvip_show'	      => 1,//会员中心
        'ct_mykefu_show'	  => 1,//在线客服
        'ct_mysetting_show'	  => 1,//设置
        'ct_allresume_show'	  => 1,//简历大厅
        'ct_mychat_show'	  => 1,//私信
        'ct_mycompany_name'	  => '我的公司',
        'ct_myposition_name'  => '职位管理',
        'ct_myteam_name'      => '我的团队',
        'ct_mywallet_name'	  => '我的钱包',
        'ct_myvip_name'	      => '会员中心',
        'ct_mykefu_name'	  => '在线客服',
        'ct_mysetting_name'	  => '设置',
        'ct_allresume_name'	  => '简历大厅',
        'ct_mychat_name'	  => '私信',
        'ct_verify_mobile'    => 0 ,
        'ct_myphone_show'	  => 0,//我的手机号
        'ct_myphone_name'	  => '我的手机号',//我的手机号
    ),

    /*
     * 兼职 身份要求
     */
    'identity_type' => [
        1 => '不限身份',
        2 => '学生可做',
        3 => '非学生可做'
    ],

    /*
     * 兼职 性别要求
     */
    'sex_type' => [
        1 => '不限性别',
        2 => '男性',
        3 => '女性'
    ],
);