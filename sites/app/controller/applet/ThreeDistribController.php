<?php


class App_Controller_Applet_ThreeDistribController extends App_Controller_Applet_InitController
{
    //生成图片存储实际路径
    private $hold_dir;
    //生成图片访问路径
    private $access_path;

    private $three_level;
    public function __construct()
    {
        parent::__construct();
        $this->hold_dir     = PLUM_APP_BUILD.'/spread/';
        $this->access_path  = PLUM_PATH_PUBLIC.'/build/spread/';
        $this->_check_three();
    }
    
    private function _check_three() {
        $three_level    = App_Helper_ShopWeixin::checkShopThreeLevel($this->sid);
        // if (
        //     !$three_level  //没有配置分销等级
        //     || ($this->applet_cfg['ac_type'] != 29 && $this->applet_cfg['ac_type'] != 6 && $this->applet_cfg['ac_type'] != 8 && !$this->checkToolUsable('wfx'))  //非同城未开启分销
        //     || (($this->applet_cfg['ac_type'] == 29 || $this->applet_cfg['ac_type'] == 6 || $this->applet_cfg['ac_type'] == 8) && !$this->checkToolUsable('hhr')) //同城未开启分销
        // ) {
        //     $this->displayJsonError("暂未开通分销功能");
        // }
        $this->three_level  = $three_level;
    }


    
    public function memberInfoAction()
    {
        $member = $this->member;
        if($member){
            $info['data'] = array(
                'mid'       => $member['m_id'],
                'showId'    => $member['m_show_id'],
                'nickname'  => $member['m_nickname'],
                'avatar'    => $member['m_avatar'] ? $member['m_avatar'] : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
                'sex'       => $member['m_sex'],
                'plum_session_applet' => session_id(),
                'mobile'       => $member['m_mobile'],
                'deduct_ktx'   => $member['m_deduct_ktx'],
                'deduct_ytx'   => $member['m_deduct_ytx'],
                'deduct_dsh'   => $member['m_deduct_dsh'],
                'followTime'   => $member['m_follow_time'],
                'isdistrib'    => ($member['m_is_highest'] > 0 || $member['m_1f_id'] > 0) ? 1 : 0,
                'isapply'      => $this->_is_apply_branch($member),
            );
            $this->outputSuccess($info);
        }else{
            $this->outputError('获取用户信息失败');
        }
    }

    
    private function _is_apply_branch($member){
        $ispply = 0;
        $branch_model = new App_Model_Shop_MysqlShopBranchStorage($this->sid);
        $row = $branch_model->findBranchByMid($member['m_id'], $member['m_1f_id']);
        if($row){
            if($row['sb_status']==0){  // 正在审核中
                $ispply = 1;
            }elseif ($row['sb_status']==2){  // 被拒绝
                $ispply = 0;
            }else{  // 已通过
                if(($member['m_is_highest'] > 0 || $member['m_1f_id'] > 0)){
                    $ispply = 2;
                }else{
                    $ispply = 0;
                }
            }
        }else{
            $ispply = 0;
        }
        return $ispply;
    }

    
    public function distribCenterAction(){
        //获取邀请码
        $this->_gen_invite_code();
        //获取父级信息
        $this->_fetch_father_info();
        $center_model   = new App_Model_Member_MysqlMemberCenterStorage();
        $row            = $center_model->findUpdateBySid($this->sid);

        if(empty($row)){
            $row = plum_parse_config('center_cfg');
        }
        //生成会员数据
        $down_total = 0;
        $down_link  = array();
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        Libs_Log_Logger::outputLog($this->three_level,'hai.log'); 
        for ($i=1; $i<=$this->three_level; $i++) {
        	Libs_Log_Logger::outputLog('获取分销信息4444','hai.log'); 
            $where = array();
            $where[] = array('name' => 'm_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[] = array('name' => 'm_'.$i.'f_id', 'oper' => '=', 'value' => $this->member['m_id']);
            $total = $member_model->getCount($where);
            //$down_total += intval($this->member["m_{$i}c_count"]);
            $down_total += intval($total);
            Libs_Log_Logger::outputLog($down_total,'hai.log');
            Libs_Log_Logger::outputLog('获取分销信息5555','hai.log');
            $down_link[] = array(
                'level' => $i,
                'name'  => $row["cc_myuser_name{$i}"],
                'count' => intval($total),
            );
        }

        $info['data'] = array(
//            'uid' => $this->uid,
            'background'  => $this->dealImagePath($row['cc_center_bg']),     // 背景
            'member'      => $this->_format_member_info($this->member),
            'down_total'  => $down_total, //我的会员总数
            'down_level'  => $down_link,  //各级下的数量
            'myuserShow'  => $row['cc_myuser_show'],//我的会员
            'upgradeShow'	=> $row['cc_myupgrade_show'],//分享收入
            'myshareShow'	=> $row['cc_myshare_show'],//分享收入
            'mycashShow'	=> $row['cc_mycash_show'], //返现收入
            'myorderShow'	=> $row['cc_myorder_show'],//分销订单
            'myreferShow'	=> $row['cc_myrefer_show'],//我的推荐人
            'myinfoShow'	=> $row['cc_myinfo_show'],  //我的资料
            'mycodeShow'	=> $row['cc_mycode_show'],//推广二维码
            'mywithShow'	=> $row['cc_mywith_show'],//申请提现
            'myrankShow'	=> $row['cc_myrank_show'],//销售排行榜
            'mynoticeShow'  => $row['cc_mynotice_show'],    //新增获取广播是否显示
            'goodsratioShow'=> $row['cc_goodsratio_show'], //单品分销详情
            'mybranchauditShow'=> $row['cc_mybranch_audit_show'], //下级分销商审核显示


            'myuserName'  => $row['cc_myuser_name0'],//我的会员
            'myshareName'	=> $row['cc_myshare_name'],//分享收入
            'upgradeName'	=> $row['cc_myupgrade_name'],//分享收入
            'mycashName'	=> $row['cc_mycash_name'],//返现收入
            'myorderName'	=> $row['cc_myorder_name'],//分销订单
            'myreferName'	=> $row['cc_myrefer_name'],//我的推荐人
            'myinfoName'	=> $row['cc_myinfo_name'],//我的资料
            'mycodeName'	=> $row['cc_mycode_name'],//推广二维码
            'mywithName'	=> $row['cc_mywith_name'],//申请提现
            'myrankName'	=> $row['cc_myrank_name'],//销售排行榜
            'mynoticeName' => $row['cc_mynotice_name'],   //广播名称  //新增
            'goodsratioName'=> $row['cc_goodsratio_name'], //单品分销详情
            'mybranchauditName'=> $row['cc_mybranch_audit_name'], //下级分销商审核名称
            'level'         => $this->three_level,
            'noticeList'   => $this->_index_notice_list(),
        );
        $extra_model = new App_Model_Member_MysqlMemberExtraStorage($this->sid);
        $extra = $extra_model->findUpdateExtraByMid($this->member['m_id']);
        $level_model = new App_Model_Copartner_MysqlCopartnerLevelStorage($this->sid);
        $level = $level_model->getRowById($extra['ame_copartner']);
        $info['data']['currLevel'] = $level?$level['cl_name']:'';
        //新增获取该店铺的广播信息

        $this->outputSuccess($info);
    }

    private function _index_notice_list(){
        $notice_storage = new App_Model_Train_MysqlTrainNoticeStorage($this->sid);
        $notice_list = $notice_storage->fetchNoticeShowList();
        $data = array();
        if($notice_list){
            foreach ($notice_list as $val){
                $data[] = array(
                    'title'    => $val['atn_title'],
                    'link'     => $val['atn_article_id'],
                );
            }
        }
        return $data;
    }

    
    private function _format_member_info($member){
        $data = array(
            'mid'          => $member['m_id'],
            'showId'      => $member['m_show_id'],
            'nickname'    => $member['m_nickname'],
            'mobile'    => $member['m_mobile'],
            'avatar'      => $member['m_avatar'] ? $member['m_avatar'] : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
            'sex'         => $member['m_sex'],
            'followTime' => $member['m_follow_time'],
            'plum_session_applet' => session_id(),
            'refer'         => $member['m_1f_id'] ? $member['f_m_nickname'] : '系统',
            'saleAmount'   => $member['m_sale_amount'],
            'deductAmount' => $member['m_deduct_amount'],
            'inviteCode'   => $member['m_invite_code'],
            'deduct_ktx'   => $member['m_deduct_ktx'],
            'deduct_ytx'   => $member['m_deduct_ytx'],
            'deduct_dsh'   => $member['m_deduct_dsh'],
        );
        //获取待返现的金额

        $order_deduct_storage = new App_Model_Shop_MysqlOrderDeductStorage($this->sid);
        $data['deductDelay'] = $order_deduct_storage->delaySum($member['m_id']);

        return $data;
    }

    
    private function _gen_invite_code() {
        if (!$this->member['m_invite_code']) {
            $code   = plum_random_code();
            //将生成的邀请码插入数据库
            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
            $updata = array(
                'm_invite_code' => $code
            );
            $member_storage->updateById($updata, $this->member['m_id']);
            $this->member['m_invite_code'] = $code;
        }
    }

    
    private function _fetch_father_info() {
        if ($this->member['m_1f_id']) {
            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();

            $info   = $member_storage->getRowById($this->member['m_1f_id']);

            $this->member['f_m_nickname'] = $info['m_nickname'];
        }
    }

    
    public function levelAction() {
        $uid    = $this->member['m_id'];
        $level  = $this->request->getIntParam('level', 1);
        $page   = $this->request->getIntParam('page');
        $keyword = $this->request->getStrParam('keyword');
        $index  = $page * $this->count;
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        //获取当前店铺会员级别
        $grade_model    = new App_Model_Member_MysqlLevelStorage();
        $grade      = $grade_model->getListBySid($this->sid);

        $refer = array();
        switch($level) {
            case 2 :
                $list = $member_storage->fetchSecondLevelList($uid, $index, $this->count,$keyword);
                if ($list) {
                    $ids = array();
                    foreach ($list as $item) {
                        array_push($ids, $item['m_1f_id']);
                    }
                    $ids = array_unique($ids, SORT_NUMERIC);
                    $refer = $member_storage->fetchMembersByids($ids);
                }
                break;
            case 3 :
                $list = $member_storage->fetchThirdLevelList($uid, $index, $this->count,$keyword);
                if ($list) {
                    $ids = array();
                    foreach ($list as $item) {
                        array_push($ids, $item['m_1f_id']);
                    }
                    $ids = array_unique($ids, SORT_NUMERIC);
                    $refer = $member_storage->fetchMembersByids($ids);
                }
                break;
            case 1 :

            default :
                $refer  = array($uid => array('m_nickname' => $this->member['m_nickname']));
                $list = $member_storage->fetchFirstLevelList($uid, $index, $this->count,$keyword);
                break;
        }

        if (!$list) {
            $this->outputError('未找到任何下级');
        }
        
      

        //顶部导航处理
        $center_model   = new App_Model_Member_MysqlMemberCenterStorage();
        $center_cfg     = $center_model->findUpdateBySid($this->sid);
        $default_cfg    = plum_parse_config('center_cfg');

        $level_link     = array();
        for ($i = 1; $i <= $this->three_level; $i++) {
            $level_link[] = array(
                'name'  => $center_cfg && $center_cfg["cc_myuser_name{$i}"] ? $center_cfg["cc_myuser_name{$i}"] : $default_cfg["cc_myuser_name{$i}"],
                'level'  => $i,
            );
        }

        //格式化会员信息
        $memberList = array();
        $deduct_storage = new App_Model_Shop_MysqlOrderDeductStorage($this->sid);
        // 获取会员卡等级
        // zhangzc
        // 2019-08-21
        $offline_member = new App_Model_Store_MysqlMemberStorage($this->sid);
        $timeNow=time();
        $card_model = new App_Model_Store_MysqlCardStorage($this->sid);

        foreach($list as $val){
            // 获取会员卡等级
            // zhangzc
            // 2019-08-21
            $where_offline = [];
            $where_offline[]    = ['name' => 'om_s_id', 'oper' => '=', 'value' => $this->sid];
            $where_offline[]    = ['name' => 'om_m_id', 'oper' => '=', 'value' => $val['m_id']];
            $where_offline[]    = ['name' => 'om_type', 'oper' => '=', 'value' => 2];
            $where_offline[]    = ['name' => 'om_expire_time', 'oper' => '>', 'value' => $timeNow];
            $member_card    = $offline_member->getList($where_offline, 0, 1,['om_update_time' => 'desc']);
            $cardid = $member_card[0]['om_card_id'];
            $card   = $card_model->getRowById($cardid);
            $offlineCard= $card['oc_name'] ? $card['oc_name'] : '';


            $deduct = $deduct_storage->getCountSum($val['m_id'], $uid, $level);
            $memberList[] = array(
                'mid'      => $val['m_id'],
                'avatar'   => $val['m_avatar'] ? $val['m_avatar'] : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
                'showId'   => $val['m_show_id'],
                'nickname' => $val['m_nickname'],
                'grade'    => $grade[$val['m_level']]['ml_name'] ? $grade[$val['m_level']]['ml_name'] : '',
                'followTime' => $val['m_follow_time'],
                'tradeNum' => $deduct['num']?$deduct['num']:0,
                'tradeMoney' => $deduct['total']?$deduct['total']:0,
                'refer'    => $refer[$val['m_1f_id']]['m_nickname'],
                'cardName'  =>$offlineCard,
                'sort'      =>$val['m_level']?$val['m_level']:'0',
            );
        }
        // 分销会员按照等级排序
        // zhangzc
        // 2019-09-04
        array_multisort(array_column($memberList,'sort'),SORT_DESC,$memberList);

        $info = array(
            'data'  => $memberList
        );
        $this->outputSuccess($info);
    }


    
    public function orderAction() {
        $page = $this->request->getIntParam('page');
        $status = $this->request->getIntParam('status', 2); //返现状态  1待返现 2已返现
        $index = $page * $this->count;
        $orderList = array();

        if($status == 1){
            //待返现
            $deduct_storage  = new App_Model_Shop_MysqlOrderDeductStorage($this->sid);
            $list = $deduct_storage->getShareDelayBackList($this->member['m_id'], $index,$this->count);
            foreach($list as $val){
                $amount = 0;
                if($val['od_1f_id'] == $this->member['m_id']){
                    $statusNote = '一级会员收入';
                    $amount = $val['amount1'];
                }
                if($val['od_2f_id'] == $this->member['m_id']){
                    $statusNote = '二级会员收入';
                    $amount = $val['amount2'];
                }
                if($val['od_3f_id'] == $this->member['m_id']){
                    $statusNote = '三级会员收入';
                    $amount = $val['amount3'];
                }
                $orderList[] = array(
                    'tid'    => $val['od_tid'],
                    'status' => $statusNote,
                    'recordTime' => date('Y-m-d H:i:s', $val['od_create_time']),
                    'amount' => $amount,
                );
            }
        }else{
            $statusNote = array(
                1   => '一级会员收入',
                2   => '二级会员收入',
                3   => '三级会员收入',
            );
            //从提成记录表中获取分享收入
            $ddb_model  = new App_Model_Deduct_MysqlDeductDaybookStorage();
            //获取会员订单信息
            $list   = $ddb_model->fetchMemberRecord($this->member['m_id'], App_Helper_OrderDeduct::DEDUCT_SHARE_INCOME,$index,$this->count);

            foreach($list as $val){
                $orderList[] = array(
                    'tid'    => $val['dd_tid'],
                    'status' => $statusNote[$val['dd_level']],
                    'recordTime' => date('Y-m-d H:i:s', $val['dd_record_time']),
                    'amount' => $val['dd_amount'],
                );
            }
        }

        if($list){
            $info = array(
                'data' => $orderList
            );
            $this->outputSuccess($info);
        }else{
            $this->outputError("暂无分享收入记录");
        }
    }
  
  
  
  public function subordinateBackNewAction(){
        //$mid = $this->request->getIntParam('mid');
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;



//        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
//        $member = $member_storage->getRowById($mid);

        $deduct_storage  = new App_Model_Shop_MysqlOrderDeductStorage($this->sid);
        $where[] = array('name' => 'od_s_id', 'oper' => '=', 'value' => $this->sid);
 //       $where[] = array('name' => 'od_status', 'oper' => '=', 'value' => 1);
//        if($this->member['m_id'] == $member['m_1f_id']){
//            $where[] = array('name' => 'od_1f_id', 'oper' => '=', 'value' => $this->member['m_id']);
//        }
//        if($this->member['m_id'] == $member['m_2f_id']){
//            $where[] = array('name' => 'od_2f_id', 'oper' => '=', 'value' => $this->member['m_id']);
//        }
//        if($this->member['m_id'] == $member['m_3f_id']){
//            $where[] = array('name' => 'od_3f_id', 'oper' => '=', 'value' => $this->member['m_id']);
//        }

        $sort = array('od_create_time' => 'desc');

        $list = $deduct_storage->getBackTradenewList($this->member['m_id'],$where, $index, $this->count, $sort);

        $orderList = [];
 		$odstatus  = array(
            0 => '待返现',
            1 => '已返现',
            2 => '已退款',
            3 => '已取消',
            99 => '拼团未成功'
        );
        foreach($list as $val){

            if($val['od_type'] == 3){
                //会员卡佣金
                $title = $val['oo_title']?$val['oo_title']:'1';
            }else{
                $title = $val['t_title']?$val['t_title']:'';
            }

            $temp = array(
//                'id' => $val['oo_id'],
                'createTime' => $val['t_create_time']?date('Y-m-d H:i:s', $val['t_create_time']):date('Y-m-d H:i:s', $val['od_create_time']),
                'title' => $title,
                'amount' => $val['od_amount'],
              	'name'   => $val['m_nickname'],
               'status'     => $odstatus[$val['od_status']]
            );
            if($this->member['m_id'] == $val['m_1f_id']){
                $temp['backMoney'] = $val['od_1f_deduct'];
            }
            if($this->member['m_id'] == $val['m_2f_id']){
                $temp['backMoney'] = $val['od_2f_deduct'];
            }
            if($this->member['m_id'] == $val['m_3f_id']){
                $temp['backMoney'] = $val['od_3f_deduct'];
            }
            $orderList[] = $temp;
        }

        if($list){
            $info = array(
                'data' => $orderList
            );
            $this->outputSuccess($info);
        }else{
            $this->outputError("暂无返佣记录");
        }
    }

    
   /**
     * 根据下级id, 获取此下级的返佣记录
     */
    public function subordinateBackAction()
    {
        $mid   = $this->request->getIntParam('mid');
        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;

        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member         = $member_storage->getRowById($mid);

        $deduct_storage = new App_Model_Shop_MysqlOrderDeductStorage($this->sid);
        $where[]        = array('name' => 'od_s_id', 'oper' => '=', 'value' => $this->sid);
       // $where[]        = array('name' => 'od_status', 'oper' => '=', 'value' => 1);
        $where[]        = array('name' => 'od_0f_id', 'oper' => '=', 'value' => $mid);
        if ($this->member['m_id'] == $member['m_1f_id']) {
            $where[] = array('name' => 'od_1f_id', 'oper' => '=', 'value' => $this->member['m_id']);
        }
        if ($this->member['m_id'] == $member['m_2f_id']) {
            $where[] = array('name' => 'od_2f_id', 'oper' => '=', 'value' => $this->member['m_id']);
        }
        if ($this->member['m_id'] == $member['m_3f_id']) {
            $where[] = array('name' => 'od_3f_id', 'oper' => '=', 'value' => $this->member['m_id']);
        }

        $sort = array('od_create_time' => 'desc');

        $list = $deduct_storage->getBackTradeList($where, $index, $this->count, $sort);

        $orderList = [];
        $odstatus  = array(
            0 => '待返现',
            1 => '已返现',
            2 => '已退款',
            3 => '已取消',
            99 => '拼团未成功'
        );
        foreach ($list as $val) {

            if ($val['od_type'] == 3) {
                //会员卡佣金
                $title = $val['oo_title'] ? $val['oo_title'] : '1';
            } else {
                $title = $val['t_title'] ? $val['t_title'] : '';
            }

            $temp = array(
//                'id' => $val['oo_id'],
                'createTime' => $val['t_create_time'] ? date('Y-m-d H:i:s', $val['t_create_time']) : date('Y-m-d H:i:s', $val['od_create_time']),
                'title'      => $title,
                'amount'     => $val['od_amount'],
                'status'     => $odstatus[$val['od_status']]
            );
            if ($this->member['m_id'] == $member['m_1f_id']) {
                $temp['backMoney'] = $val['od_1f_deduct'];
            }
            if ($this->member['m_id'] == $member['m_2f_id']) {
                $temp['backMoney'] = $val['od_2f_deduct'];
            }
            if ($this->member['m_id'] == $member['m_3f_id']) {
                $temp['backMoney'] = $val['od_3f_deduct'];
            }
            $orderList[] = $temp;
        }

        if ($list) {
            $info = array(
                'data' => $orderList,
            );
            $this->outputSuccess($info);
        } else {
            $this->outputError("暂无返佣记录");
        }
    }


    
    public function cashbackAction() {
        $page = $this->request->getIntParam('page');
        $status = $this->request->getIntParam('status', 2); //返现状态  1待返现 2已返现
        $index = $page * $this->count;
        //从提成记录表中获取分享收入

        $cashBackList = array();
        //获取会员订单信息
        if($status == 1){
            //待返现
            $deduct_storage  = new App_Model_Shop_MysqlOrderDeductStorage($this->sid);
            $list = $deduct_storage->getDelayBackList($this->member['m_id'],$index,$this->count);
            foreach($list as $val){
                $cashBackList[] = array(
                    'tid'    => $val['od_tid'],
                    'recordTime' => date('Y-m-d H:i:s', $val['od_create_time']),
                    'amount' => $val['amount'],
                    'statusNote' => '待返现'
                );
            }
        }else{
            //已返现
            $ddb_model  = new App_Model_Deduct_MysqlDeductDaybookStorage();
            $list   = $ddb_model->fetchMemberRecord($this->member['m_id'], App_Helper_OrderDeduct::DEDUCT_CASHBACK_INCOME,$index,$this->count);
            foreach($list as $val){
                $cashBackList[] = array(
                    'tid'    => $val['dd_tid'],
                    'recordTime' => date('Y-m-d H:i:s', $val['dd_record_time']),
                    'amount' => $val['dd_amount'],
                    'statusNote' => '已返现'
                );
            }
        }
        if($list){
            $info = array(
                'data' => $cashBackList
            );
            $this->outputSuccess($info);
        }else{
            $this->outputError("暂无返现收入记录");
        }
    }

    
    public function myOrderAction() {
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $deduct_storage  = new App_Model_Shop_MysqlOrderDeductStorage($this->sid);
        $list   = array();
        //获取会员订单信息
        $sort   = array('od_create_time' => 'DESC');

        $where[] = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 't_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $list   = $deduct_storage->getDeductByMidSid($where, $index, $this->count, $sort);
        if($list){
            $order_status_desc = array(
                App_Helper_Trade::TRADE_NO_PAY      => '待付款',
                App_Helper_Trade::TRADE_WAIT_PAY_RETURN => '待支付确认',
                App_Helper_Trade::TRADE_HAD_PAY     => $this->applet_cfg['ac_type'] == 7?'待入住':'待发货',
                App_Helper_Trade::TRADE_SHIP        => '待收货',
                App_Helper_Trade::TRADE_FINISH      => '已完成',
                App_Helper_Trade::TRADE_CLOSED      => '已关闭',
                App_Helper_Trade::TRADE_REFUND      => '已退款',
            );
            $orderList = array();
            foreach($list as $val){
                $orderList[] = array(
                    'status'   => $order_status_desc[$val['t_status']],
                    'statusCode' => $val['t_status'],
                    'tid'      => $val['t_tid'],
                    'total'   => $val['t_total_fee'],
                    'goods'   => $this->show_trade_goods_detail_data($val['t_id']),
                );
            }
            $info = array(
                'data' => $orderList
            );

            $this->outputSuccess($info);
        }else{
            $this->outputError("暂无分销订单记录");
        }
    }

    
    private function show_trade_goods_detail_data($tid){
        //获取交易订单商品
        $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        $order = $order_model->fetchOrderListByTid($tid);
        $data = array();
        if ($order) {
            foreach ($order as $val) {
                $data[] = array(
                    'gid'   => $val['to_g_id'],
                    'title' => $val['to_title'],
                    'spec'  => isset($val['to_gf_name']) ? $val['to_gf_name'] : '',
                    'img'   => isset($val['to_pic']) ? plum_deal_image_url($val['to_pic']) : '',
                    'price' => $val['to_price'],
                    'num' => $val['to_num'],
                    'total' => $val['to_total'],
                );
            }
        }
        return $data;
    }

    
    public function myReferAction() {
        //最高级会员无推荐人
        if ($this->member['m_is_highest']) {
            $this->outputError("您是最高级会员，无上级推荐人");
        }
        if (!$this->member['m_1f_id']) {
            $this->outputError("推荐人为系统，没有更多上级推荐人");
        }
        //获取当前会员向上三级推荐人
        $ids    = array();
        for ($i=1; $i<=3; $i++) {
            $tmp    = "{$i}f";
            if ($this->member["m_{$tmp}_id"]) {
                array_push($ids, $this->member["m_{$tmp}_id"]);
            } else {
                break;
            }
        }
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $f_members = $member_storage->fetchMembersByids($ids);
        $refer = array();
        foreach ($ids as $key) {
            $count  = count($refer);
            $index  = '';
            switch($count) {
                case 0 :
                    $index = "一";
                    break;
                case 1 :
                    $index = "二";
                    break;
                case 2 :
                    $index = "三";
                    break;
            }
            $refer[$index]    = $f_members[$key];
        }
        $referList = array();
        foreach($refer as $index => $val){
            $referList[] = array(
                'index' => $index,
                'avatar' => $val['m_avatar'] ? $val['m_avatar'] : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
                'showId' => $val['m_show_id'],
                'followTime' => $val['m_follow_time'],
                'nickname' => $val['m_nickname'],
                'saleMount' => $val['m_sale_amount'],
                'inviteCode' => $val['m_invite_code'],
            );
        }
        $info = array(
            'data' => $referList
        );

        $this->outputSuccess($info);
    }

    
    public function saveProfileAction() {
        $avatar     = $this->request->getStrParam('avatar');
        $nickname   = $this->request->getStrParam('nickname');
        $sex        = $this->request->getStrParam('sex');
        $sex        = in_array($sex, array('男', '女')) ? $sex : '无';

        if ($avatar && $nickname) {
            $updata = array(
                'm_avatar'      => $avatar,
                'm_nickname'    => $nickname,
                'm_sex'         => $sex,
            );
            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
            $member_storage->updateById($updata, $this->member['m_id']);
            $info = array(
                'data' => "修改成功"
            );
            $this->outputSuccess($info);
        }else{
            $this->outputError("修改失败，请重试");
        }
    }

    
    public function savePhoneAction(){
        $code          = $this->request->getStrParam('code');   // 用户code
        $iv            = $this->request->getStrParam('iv');     // 加密算法的初始向量
        $encryptedData = $this->request->getParam('encryptedData');  // 加密后的数据
        $appid         = $this->request->getStrParam('appid');  // 小程序APPID

        if($code){
            // 通过code换取用户的openID
            // $result = App_Helper_WeixinEvent::getWxopenid($this->applet_cfg['ac_appid'],$this->applet_cfg['ac_appsecret'],$code);
            // 获取用户的openID
            if($appid && mb_strlen($appid)==18){
                $curr_appid = $appid;
            }else{
                $curr_appid = $this->applet_cfg['ac_appid'];
            }
            $wxxcx_client   = new App_Plugin_Weixin_WxxcxClient($this->sid);
            $result    = $wxxcx_client->fetchOpenidByCode($curr_appid,$code);
            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
            // 获取到用户的openID
            if($result){
                if($result['session_key'] && $iv && $encryptedData){
                    $mobileinfo = $this->_get_user_info($result['session_key'],$iv,$encryptedData);
                    if($mobileinfo){
                        $data = array(
                            'm_mobile'    => $mobileinfo['phoneNumber'],
                        );
                        $uid  = $member_storage->getRowUpdateByIdSid($this->member['m_id'], $this->sid, $data);
                        $info = array(
                            'data' => $mobileinfo['phoneNumber']
                        );
                        $this->outputSuccess($info);
                    }else{
                        $this->outputError('获取信息失败，请重试');
                    }
                }else{
                    $this->outputError('获取信息失败，请重试');
                }
            }else{
                $this->outputError('获取用户信息失败');
            }
        }else{
            $this->outputError('获取用户信息失败');
        }
    }

    
    private function _get_user_info($sessionKey,$iv,$encryptedData){
        if($sessionKey && $iv && $encryptedData){
            // 解密数据
            $wxBizDataCrypt = new App_Plugin_Weixin_DecryptInfo();
            $decryptData = $wxBizDataCrypt->getUserInfo($this->applet_cfg['ac_appid'],$sessionKey,$encryptedData, $iv);
            $userInfo = json_decode($decryptData['data'],true);
            if($decryptData['code']==0){
                return $userInfo;
            }
        }
        return false;
    }

    
    public function rankAction() {
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        //获取当前店铺成员的销售排行榜
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $where[]    = array('name' => 'm_s_id', 'oper' => '=', 'value' => $this->shop['s_id']);

        $sort       = array('m_sale_amount' => 'DESC', 'm_id' => 'ASC');
        $fields     = array('m_id', 'm_s_id', 'm_c_id', 'm_nickname', 'm_avatar', 'm_sex', 'm_follow_time', 'm_sale_amount');
        $rank_list  = $member_storage->getList($where, $index, $this->count, $sort, $fields);

        if($rank_list){
            $rankList = array();
            foreach($rank_list as $index=>$val){
                $rankList[] = array(
                    'avatar'   => $val['m_avatar'] ? $val['m_avatar'] : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
                    'nickname' => $val['m_nickname'],
                    'rank'     => $page*$this->count+$index+1,
                    'followTime' => $val['m_follow_time'],
                    'saleAmount' => $val['m_sale_amount'],
                    'serviceMoney'=>$val['wd_service_money']>0?$val['wd_service_money']:0
                );
            }
            $info= array(
                'data' => $rankList,
            );
            $this->outputSuccess($info);
        }else{
            $this->outputError("暂无销售排行信息");
        }
    }


    
    public function applyTxAction() {
        $money      = $this->request->getIntParam('money');
        $account    = $this->request->getStrParam('account', '');
        $name       = $this->request->getStrParam('name');
        $tel        = $this->request->getStrParam('phone');
        $bankCode   = $this->request->getStrParam('bankCode');
        $type       = $this->request->getStrParam('type', 'wx');
        $tx_type    = plum_parse_config('apply_tx_type', 'app');
        $type       = plum_check_array_key($type, $tx_type, 1);
        $wdcfg_storage  = new App_Model_Shop_MysqlWithdrawCfgStorage();
        $withdraw_cfg   = $wdcfg_storage->findCfgBySid($this->sid);
        if($withdraw_cfg['wc_rate']>0){
            $serviceMoney   = round($money*$withdraw_cfg['wc_rate']/100,2);
        }else{
            $serviceMoney   = 0;
        }
        if(($withdraw_cfg['ac_mobile_open'] && $type=='wx') || ($withdraw_cfg['ac_bank_mobile_open'] && $type=='bank')){
            if(!plum_is_mobile($tel)){
                $this->outputError('请输入正确的手机号');
            }
        }
        if ($money <= 0 || $money > (int)$this->member['m_deduct_ktx']) {
            $this->outputError('请重新输入提现金额，必须为整数');
        } else {
            $member_storage     = new App_Model_Member_MysqlMemberCoreStorage();
            //减少可提现，增加待审核
            $updata = array(
                'm_deduct_ktx'  => (float)$this->member['m_deduct_ktx'] - $money,
                'm_deduct_dsh'  => (float)$this->member['m_deduct_dsh'] + $money,
            );
            $member_storage->updateById($updata, $this->member['m_id']);

            $withdraw_storage   = new App_Model_Member_MysqlWithDrawalStorage();

            $indata = array(
                'wd_m_id'       => $this->member['m_id'],
                'wd_c_id'       => $this->member['m_c_id'],
                'wd_s_id'       => $this->member['m_s_id'],
                'wd_realname'   => $name,
                'wd_mobile'     => $tel,
                'wd_account'    => $account,
                'wd_money'      => $money,
                'wd_bank'       => $bankCode,
                'wd_type'       => $type,
                'wd_create_time'=> time(),
                'wd_service_money'=>$serviceMoney,
                'wd_real_money' => $money-$serviceMoney,
            );

            $ret = $withdraw_storage->insertValue($indata);
            if($withdraw_cfg['wc_auto'] && $ret){
                //自动提现
                plum_open_backend('index', 'withdraw', array('sid' => $this->sid,'rid' => $ret));
            }
            //申请提现向管理员推送通知
            $help_model = new App_Helper_XingePush($this->member['m_s_id']);
            $help_model->pushNotice($help_model::APPLY_WITHDRAW);  // 推送提现申请通知
            $notice_model = new App_Helper_JiguangPush($this->sid);
            $notice_model->pushNotice($notice_model::APPLY_WITHDRAW);
            $message_helper = new App_Helper_ShopMessage($this->sid);
            $message['money'] = $money;
            $message_helper->messageRecord($message_helper::APPLY_THREE_WITHDRAW,$message);
            $info['data']= array(
                'msg' => "提现申请提交成功",
            );
            $this->outputSuccess($info);
        }
    }

    
    public function recordTxAction() {
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $with_storage   = new App_Model_Member_MysqlWithDrawalStorage();

        $where[]    = array('name' => 'wd_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $where[]    = array('name' => 'wd_delete', 'oper' => '=', 'value' => 0);//未被删除数据
        $sort       = array('wd_create_time' => 'DESC');

        $list = $with_storage->getList($where, $index, $this->count, $sort);

        if (!$list) {
            $this->outputError('暂无提现申请记录');
        }
        $tx_map     = plum_parse_config('tx_map', 'app');
        $recordList = array();
        $tipMap = array(0 => '待审核', 1 => '已提现', 2 => '未通过');
        foreach($list as $val){
            $recordList[] = array(
                'type' => $tx_map[$val['wd_type']]."提现",
                'time' => date('Y-m-d H:i:s', $val['wd_create_time']),
                'status' => $tipMap[$val['wd_audit']],
                'statusCode' => $val['wd_audit'],
                'money' => $val['wd_money'],
               // 'realMoney' => $val['wd_real_money'],  //实际获得的金额
                'serviceMoney' => $val['wd_service_money']>0?$val['wd_service_money']:0  //手续费
            );
        }
        $info = array(
            'data'  => $recordList,
        );

        $this->outputSuccess($info);
    }

    
    public function qrcodeAction() {
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_storage->getRowById($this->member['m_id']);
        //合伙人 检查是否已购买等级
        $copartner_cfg  = new App_Model_Three_MysqlCfgStorage($this->sid);
        $tcRow         = $copartner_cfg->findShopCfg();
        if($tcRow['tc_copartner_isopen'] == 1){
            $extra_model = new App_Model_Member_MysqlMemberExtraStorage($this->sid);
            $extra = $extra_model->findUpdateExtraByMid($this->member['m_id']);
            if(!$extra || $extra['ame_copartner'] == 0){
                $this->outputError('请先购买合伙人');
            }
        }
        //检查是否是真实会员
        $is_real_member = App_Helper_MemberLevel::isRealMember($this->shop['s_id'], $member['m_id']);
        if (!$is_real_member) {
            $center_model   = new App_Model_Member_MysqlMemberCenterStorage();
            $center_cfg     = $center_model->findUpdateBySid($this->shop['s_id']);
            $default_cfg    = plum_parse_config('center_cfg');
            if ($center_cfg && $center_cfg['cc_noqr_tip']) {
                $tip    = $center_cfg['cc_noqr_tip'];
            } else {
                $tip    = $default_cfg['cc_noqr_tip'];
            }

            $this->outputError($tip);
        }
        //获取会员等级说明
        $level      = App_Helper_MemberLevel::fetchMemberLevel($this->shop['s_id'], $member['m_id']);
        //推广二维码不存在或已失效
        $qrcodeVerify = getimagesize($this->dealImagePath($member['m_spread_qrcode'],true));  // 验证二维码是否存现
        if (!$member['m_spread_qrcode'] || !$member['m_spread_image'] || !$qrcodeVerify) {
            $str = "mid=".$this->member['m_id'].'&join_type=1';
            $appid = $this->request->getStrParam('appid');
            //获取分身小程序信息
            $child_cfg = new App_Model_Applet_MysqlChildStorage();
            $child = $child_cfg->fetchUpdateWxcfgByAid($appid);
            if($child){
                $client_plugin  = new App_Plugin_Weixin_WxxcxChild($this->shop['s_id'], $appid);
            }else{
                $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->shop['s_id']);
            }
            if($this->appletType == 5 && $this->member['m_source'] == 1){
                $filename = plum_uniqid_base36(true).".png";
                if($this->applet_cfg['ac_type'] == 27){
                    $text = "http://".plum_parse_config('auth_domain','weixin')."/mobile/knowpay/index?suid={$this->shop['s_unique_id']}&appletType=5&share=/?refer_mid=".$this->member['m_id'];
                    Libs_Qrcode_QRCode::png($text,$this->hold_dir.$filename, 'Q', 6, 1);

                }elseif ($this->applet_cfg['ac_type'] == 6){
                    $text = "http://".plum_parse_config('auth_domain','weixin')."/mobile/city/index?suid={$this->shop['s_unique_id']}&appletType=5&share=/?refer_mid=".$this->member['m_id'];
                    Libs_Qrcode_QRCode::png($text,$this->hold_dir.$filename, 'Q', 6, 1);
                }
                $url = $this->access_path.$filename;
                $urlVerify = getimagesize($this->dealImagePath($url,true));  // 验证二维码是否存现
                if(!$urlVerify){
                    $url = '';
                }

            }else{
                if($this->applet_cfg['ac_type'] == 6 || $this->applet_cfg['ac_type'] == 8){
                    $url = $client_plugin->fetchWxappShareCode($str, App_Plugin_Weixin_WxxcxClient::APPLET_ENTER_CODE_PATH, 210);
                }else{
                    $url = $client_plugin->fetchWxappShareCode($str, App_Plugin_Weixin_WxxcxClient::APPLET_ENTER_CODE_PATH, 210);
                }
            }


            //设置并存储会员推广二维码
            $member['m_spread_qrcode'] = $url;

            $updata = array(
                'm_spread_qrcode'   => $member['m_spread_qrcode'],
                'm_ticket_qrcode_url' => $url,
                'm_spread_image'    => '',//二维码推广图片清空，便于重新生成
            );
            $member_storage->updateById($updata, $this->member['m_id']);
            if($this->sid==7163 || $this->sid==7224){
                $this->_create_spread_image_new();
            }else{
                $this->_create_spread_image();
            }
        }

        $member = $member_storage->getRowById($this->member['m_id']);
        $info = array(
            'data'  =>array(
                'qrcode'      => $this->dealImagePath($member['m_spread_qrcode'],true),
                'spreadImage' => $this->dealImagePath($member['m_spread_image'],true),
                'level'       => $level
            )
        );
        $this->outputSuccess($info);
    }

    private function _create_spread_image(){
        //获取会员信息

        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->getRowById($this->member['m_id']);
        $qrcode     = $member['m_spread_qrcode'];//推广二维码

        $qrcodeVerify = getimagesize($this->dealImagePath($qrcode,true));  // 验证二维码是否存现

        if(!$qrcodeVerify && $this->appletType == 5){
            return '';
        }
        if(!$qrcodeVerify){
            $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->shop['s_id']);
            $str = "mid=".$this->member['m_id'].'&join_type=1';
            $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::APPLET_ENTER_CODE_PATH, 210);
            //设置并存储会员推广二维码
            $qrcode = $url;
        }
        //推广二维码画报重新生成
        $center_storage = new App_Model_Member_MysqlMemberCenterStorage();
        $center_cfg     = $center_storage->findUpdateBySid($this->member['m_s_id']);
        $default_cfg    = plum_parse_config('center_cfg');

        $qrcode_bg      = $center_cfg && $center_cfg['cc_qrcode_bg'] ? $center_cfg['cc_qrcode_bg'] : $default_cfg['cc_qrcode_bg'];
        $avatar_loc     = $center_cfg && $center_cfg['cc_avatar_loc'] ? $center_cfg['cc_avatar_loc'] : $default_cfg['cc_avatar_loc'];
        $avatar_loc     = explode(',', trim($avatar_loc, "()"));
        $qrcode_loc     = $center_cfg && $center_cfg['cc_qrcode_loc'] ? $center_cfg['cc_qrcode_loc'] : $default_cfg['cc_qrcode_loc'];
        $qrcode_loc     = explode(',', trim($qrcode_loc, "()"));

        $basic_path     = PLUM_DIR_ROOT.$qrcode_bg;

        list($b_w, $b_h, $b_type) = getimagesize($basic_path);

        if (in_array($b_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG))) {
            $imagecreate    = "imagecreatefrom";
            $imageoutput    = "image";
            $imageext       = '';
            switch ($b_type) {
                case IMAGETYPE_GIF :
                    $imagecreate    .= "gif";
                    $imageoutput    .= "gif";
                    $imageext       = '.gif';
                    break;
                case IMAGETYPE_JPEG :
                    $imagecreate    .= "jpeg";
                    $imageoutput    .= "jpeg";
                    $imageext       = '.jpg';
                    break;
                case IMAGETYPE_PNG :
                    $imagecreate    .= "png";
                    $imageoutput    .= "png";
                    $imageext       = '.png';
                    break;
            }
            $bs_img     = $imagecreate($basic_path);
            list($b_w, $b_h, $qr_type) = getimagesize(PLUM_DIR_ROOT.$qrcode);
            if($qr_type==2){   //jpg类型的图片
                $qr_img     = imagecreatefromjpeg(PLUM_DIR_ROOT.$qrcode);//210*210
            }else{             //png类型的图片
                $qr_img     = imagecreatefrompng(PLUM_DIR_ROOT.$qrcode);//210*210
            }
            $q_w        = imagesx($qr_img);
            $q_h        = imagesy($qr_img);
            //将二维码图片放置在指定坐标处
            $dst_x      = intval($qrcode_loc[0]);
            $dst_y      = intval($qrcode_loc[1]);

            $ret = imagecopyresampled($bs_img, $qr_img, $dst_x, $dst_y, 0, 0, $center_cfg['cc_qrcode_size']*2, $center_cfg['cc_qrcode_size']*2,$q_w, $q_h);
            //生成头像
            if ($member['m_avatar']) {
                $tx_c   = imagecolorallocate($bs_img, 0, 0, 0);
                $fontface   = PLUM_DIR_LIB . "/captcha/font/wrvistafs.ttf"; //字体文件

                $avatar_url = substr($member['m_avatar'], -2) == '/0' ? substr($member['m_avatar'], 0, strlen($member['m_avatar'])-2).'/96' : $member['m_avatar'];

                $image_data = file_get_contents($avatar_url);

                list($a_w, $a_h, $a_type) = getimagesizefromstring($image_data);
                $a_x    = intval($avatar_loc[0]);
                $a_y    = intval($avatar_loc[1]);

                if (in_array($a_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG))) {

                    $avatar_img = imagecreatefromstring($image_data);
                    imagecopyresampled($bs_img, $avatar_img, $a_x, $a_y, 0, 0, 100, 100, $a_w, $a_h);
                    imagedestroy($avatar_img);
                }
                //生成昵称
                if ($member['m_nickname']) {
                    $nick   = $member['m_nickname'];

                    $nt_x   = $a_x+100+10;//留出图片空间
                    $nt_y   = $a_y+55;//留出图片高度


                    imagettftext($bs_img, 24, 0, $nt_x, $nt_y, $tx_c, $fontface, $nick);
                    imagettftext($bs_img, 24, 0, $nt_x+1, $nt_y, $tx_c, $fontface, $nick);
                }
            }

            $filename   = plum_random_code(8, false) . '-' . plum_random_code(6, false) . $imageext;
            $imageoutput($bs_img, $this->hold_dir . $filename);

            imagedestroy($bs_img);
            imagedestroy($qr_img);
            $spread   = $this->access_path . $filename;
            //保存推广二维码图片
            $updata     = array(
                'm_spread_image' => $spread,
            );
            if(!$qrcodeVerify){
                $updata['m_spread_qrcode'] = $qrcode;

            }

            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
            $member_storage->updateById($updata, $this->member['m_id']);
        }
        return $spread;
    }

    
//    private function _create_spread_image_new(){
//        //获取会员信息
//        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
//        $member     = $member_storage->getRowById($this->member['m_id']);
//
//        $qrcode     = $member['m_spread_qrcode'];//推广二维码
//
//        //推广二维码画报重新生成
//        $center_storage = new App_Model_Member_MysqlMemberCenterStorage();
//        $center_cfg     = $center_storage->findUpdateBySid($this->sid);
//        $default_cfg    = plum_parse_config('center_cfg');
//
//        // 获取海报背景图
//        $poster      = $center_cfg && $center_cfg['cc_qrcode_bg'] ? $center_cfg['cc_qrcode_bg'] : $default_cfg['cc_qrcode_bg'];
//
//        $poster     = PLUM_DIR_ROOT.$poster;
//        list($b_w, $b_h, $b_type) = getimagesize($poster);  // 获取上传海报背景图的尺寸和类型
//
//        $qr_bg = plum_parse_config('distrib_bg');  //获取二维码图片背景
//
//        if (in_array($b_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG))) {
//            $imagecreate    = "imagecreatefrom";
//            $imageoutput    = "image";
//            $imageext       = '';
//            switch ($b_type) {
//                case IMAGETYPE_GIF :
//                    $imagecreate    .= "gif";
//                    $imageoutput    .= "gif";
//                    $imageext       = '.gif';
//                    break;
//                case IMAGETYPE_JPEG :
//                    $imagecreate    .= "jpeg";
//                    $imageoutput    .= "jpeg";
//                    $imageext       = '.jpg';
//                    break;
//                case IMAGETYPE_PNG :
//                    $imagecreate    .= "png";
//                    $imageoutput    .= "png";
//                    $imageext       = '.png';
//                    break;
//            }
//            $qr_img_bg     = imagecreatefromjpeg($qr_bg);  // 二维码及头像背景图片
//            $poster_img     = $imagecreate($poster);  // 海报图片
//            $qr_img     = imagecreatefromjpeg(PLUM_DIR_ROOT.$qrcode);// 二维码图片210*210
//
//            // 修改二维码图片大小
//            $qr_img_new = imagecreatetruecolor(140, 140);
//            imagecopyresized($qr_img_new, $qr_img, 0, 0, 0, 0, 140, 140, 210, 210);
//            // 合成二维码图片
//            imagecopy($qr_img_bg, $qr_img_new, 477, 20, 0, 0, 140, 140);
//            //生成头像
//            if ($member['m_avatar']) {
//                $avatar_url = substr($member['m_avatar'], -2) == '/0' ? substr($member['m_avatar'], 0, strlen($member['m_avatar'])-2).'/96' : $member['m_avatar'];
//
//                $image_data = file_get_contents($avatar_url);
//
//                list($a_w, $a_h, $a_type) = getimagesizefromstring($image_data);
//
//                if (in_array($a_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG))) {
//
//                    $avatar_img = imagecreatefromstring($image_data);
//                    $avatar_new = imagecreatetruecolor(105, 105);
//                    imagecopyresized($avatar_new, $avatar_img, 0, 0, 0, 0, 105, 105, $a_w, $a_h);
//                    imagecopy($qr_img_bg, $avatar_new, 25, 55, 0, 0, 105, 105);
//                    imagedestroy($avatar_new);
//                    imagedestroy($avatar_img);
//                }
//            }
//
//            //合成昵称
//            if ($member['m_nickname']) {
//                $nick   = $member['m_nickname'];
//
//                $nt_x   = 25+100+15;//留出图片空间
//                $nt_y   = 55+45;//留出图片高度
//                $tx_c   = imagecolorallocate($qr_img_bg, 0, 0, 0);
//                $fontface   = PLUM_DIR_LIB . "/captcha/font/wrvistafs.ttf"; //字体文件
//                imagettftext($qr_img_bg, 18, 0, $nt_x, $nt_y, $tx_c, $fontface, $nick);
//            }
//
//            // 生成一个新背景图片,将合成的图片合成一个新的图片
//            $background = imagecreatetruecolor(640,928);
//            $color = imagecolorallocate($background, 202, 201, 201); // 为真彩色画布创建白色背景，再设置为透明
//            imagefill($background, 0, 0, $color);
//            imageColorTransparent($background, $color);
//
//            // 拼接图片
//            imagecopy($background,$poster_img,0,0,0,0,$b_w,$b_h);
//            imagecopy($background,$qr_img_bg,0,$b_h,0,0,640,178);
//
//
//            $filename   = plum_random_code(8, false) . '-' . plum_random_code(6, false) . $imageext;
//            $imageoutput($background, $this->hold_dir . $filename);
//
//            // 释放资源
//            imagedestroy($poster_img);
//            imagedestroy($qr_img_bg);
//            imagedestroy($qr_img);
//            $spread   = $this->access_path . $filename;
//            //保存推广二维码图片
//            $updata     = array(
//                'm_spread_image' => $spread
//            );
//            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
//            $member_storage->updateById($updata, $this->member['m_id']);
//        }
//        return $spread;
//    }

    private function _create_spread_image_new() {

        $member = $this->member;
        $center_storage = new App_Model_Member_MysqlMemberCenterStorage();
        $center_cfg     = $center_storage->findUpdateBySid($this->sid);

        $qrcode_bg = plum_parse_config('distrib_bg');

        $basic_path = PLUM_DIR_ROOT.$qrcode_bg;
        $new_bg = PLUM_DIR_ROOT.$center_cfg['cc_qrcode_bg'];
        list($b_w, $b_h, $b_type) = getimagesize($new_bg);

        if (in_array($b_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG))) {
            $imagecreate = "imagecreatefrom";
            $imageoutput = "image";
            $imageext = '';
            switch ($b_type) {
                case IMAGETYPE_GIF :
                    $imagecreate .= "gif";
                    $imageoutput .= "gif";
                    $imageext = '.gif';
                    break;
                case IMAGETYPE_JPEG :
                    $imagecreate .= "jpeg";
                    $imageoutput .= "jpeg";
                    $imageext = '.jpg';
                    break;
                case IMAGETYPE_PNG :
                    $imagecreate .= "png";
                    $imageoutput .= "png";
                    $imageext = '.png';
                    break;
            }
            $new_bg = $imagecreate($new_bg);
            $bs_img = imagecreatefromjpeg($basic_path);
            $qr_img = imagecreatefromjpeg(PLUM_DIR_ROOT.$member['m_spread_qrcode']);//210*210
            $thumb = imagecreatetruecolor(140, 140);
            imagecopyresampled($thumb, $qr_img, 0, 0, 0, 0, 140, 140, 280, 280);
            $q_w = imagesx($qr_img);
            $q_h = imagesy($qr_img);
            //将二维码图片放置推广图片中间位置
            $dst_x = ceil(($b_w - $q_w) / 2);
            $dst_y = ceil(($b_h - $q_h) / 2);

            imagecopy($bs_img, $thumb, 477, 20, 0, 0, 140, 140);
            imagedestroy($thumb);
            $tx_c = imagecolorallocate($bs_img, 0, 0, 0);
            $fontface = PLUM_DIR_LIB . "/captcha/font/wrvistafs.ttf"; //字体文件

            //生成头像
            if ($member['m_avatar']) {
                $avatar_url = substr($member['m_avatar'], -2) == '/0' ? substr($member['m_avatar'], 0, strlen($member['m_avatar']) - 2) . '/96' : $member['m_avatar'];

                $image_data = file_get_contents($avatar_url);

                list($a_w, $a_h, $a_type) = getimagesizefromstring($image_data);

                if (in_array($a_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG))) {

                    $avatar_img = imagecreatefromstring($image_data);
                    $avatar_new = imagecreatetruecolor(105, 105);
                    imagecopyresized($avatar_new, $avatar_img, 0, 0, 0, 0, 105, 105, $a_w, $a_h);
                    imagecopy($bs_img, $avatar_new, 25, 55, 0, 0, 105, 105);
                    imagedestroy($avatar_new);
                    imagedestroy($avatar_img);
                }
            }
            //生成昵称
            if ($member['m_nickname']) {
                $nick = $member['m_nickname'];

                $nt_x = 25 + 100 + 15;//留出图片空间
                $nt_y = 55 + 45;//留出图片高度

                imagettftext($bs_img, 18, 0, $nt_x, $nt_y, $tx_c, $fontface, $nick);
            }
            $background = imagecreatetruecolor(640, 928); // 生成一个新背景图片
            $color = imagecolorallocate($background, 202, 201, 201); // 为真彩色画布创建白色背景，再设置为透明
            imagefill($background, 0, 0, $color);
            imageColorTransparent($background, $color);
            // 拼接图片
            imagecopy($background, $new_bg, 0, 0, 0, 0, 640, 758);
            imagecopy($background, $bs_img, 0, 758, 0, 0, 640, 170);

            $filename = plum_random_code(8, false) . '-' . plum_random_code(6, false) . $imageext;
            $imageoutput($background, $this->hold_dir . $filename);

            imagedestroy($new_bg);
            imagedestroy($bs_img);
            imagedestroy($qr_img);
            $spread_image = $this->access_path . $filename;
            //保存推广二维码图片
            $updata     = array(
                'm_spread_image' => $spread_image
            );
            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
            $member_storage->updateById($updata, $this->member['m_id']);
        }
        return $spread_image;
    }



    
    public function setLevelAction() {
        //扫码关注的话，用于获取上级id
        $mid = $this->request->getStrParam('mid');

        if(strpos($mid ,'=') !== false){
            $mid = explode("=", $mid)[1];
        }
//        if($this->sid == 11247){
//            Libs_Log_Logger::outputLog('执行分销关系','test.log');
//            Libs_Log_Logger::outputLog($mid,'test.log');
//        }


        //父级存在
        if ($mid) {
            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
            $member = $member_storage->findMemberByIdSid($this->member['m_id'], $this->shop['s_id']);
            $refer = $member_storage->findMemberByIdSid($mid, $this->shop['s_id']);
            if(!$refer){
                $info = array(
                    'data' => array(
                        'tip'   => '推荐失败，推荐人不存在',
                        'refer' => $refer['m_nickname'],
                        'name'  => $this->shop['s_name'],
                        'brief' => $this->shop['s_brief'],
                        'status'=> false
                    )
                );
                $this->outputSuccess($info);
                die();
            }

            if($mid == $member['m_id']){
                $info = array(
                    'data' => array(
                        'tip'   => '推荐失败，不能推荐自身',
                        'refer' => $refer['m_nickname'],
                        'name'  => $this->shop['s_name'],
                        'brief' => $this->shop['s_brief'],
                        'status'=> false
                    )
                );
                $this->outputSuccess($info);
                die();
            }
            if ($member) {
                //非最高级且无上级
                if (!$member['m_is_highest'] && !$member['m_1f_id']) {
                    //检查是否是真实会员
                    $copartner_cfg  = new App_Model_Three_MysqlCfgStorage($this->sid);
                    $tcRow         = $copartner_cfg->findShopCfg();
                    if($tcRow['tc_copartner_isopen'] == 1){
                        $extra_model = new App_Model_Member_MysqlMemberExtraStorage($this->sid);
                        if(!is_array($mid)){
                            $extra = $extra_model->findUpdateExtraByMid($mid);
                        }
                        if(!$extra || $extra['ame_copartner'] == 0){
                            $info = array(
                                'data' => array(
                                    'tip'   => '请先购买合伙人',
                                    'refer' => $refer['m_nickname'],
                                    'name'  => $this->shop['s_name'],
                                    'brief' => $this->shop['s_brief'],
                                    'status'=> false
                                )
                            );
                            $this->outputSuccess($info);
                            die();
                        }
                    }
                    $is_real_member = App_Helper_MemberLevel::isRealMember($this->shop['s_id'], $mid);
                    if (!$is_real_member) {
                        $info = array(
                            'data' => array(
                                'tip'   => '推荐失败，推荐人未满足分销条件',
                                'refer' => $refer['m_nickname'],
                                'name'  => $this->shop['s_name'],
                                'brief' => $this->shop['s_brief'],
                                'status'=> false
                            )
                        );
                        $this->outputSuccess($info);
                        die();
                    }
                    $ret = App_Helper_MemberLevel::setLevelSendMessage($this->shop['s_id'], $member['m_id'], $mid);
                    if($ret){
                        $info = array(
                            'data' => array(
                                'tip'   => '推荐成功，你已成为分销会员',
                                'refer' => $refer['m_nickname'],
                                'name'  => $this->shop['s_name'],
                                'brief' => $this->shop['s_brief'],
                                'status'=> true
                            )
                        );
                        $this->outputSuccess($info);
                        die();
                    }else{
                        $info = array(
                            'data' => array(
                                'tip'   => '上级已存在',
                                'refer' => $refer['m_nickname'],
                                'name'  => $this->shop['s_name'],
                                'brief' => $this->shop['s_brief'],
                                'status'=> false
                            )
                        );
                        $this->outputSuccess($info);
                        die();
                    }
                }else{
                    $info = array(
                        'data' => array(
                            'tip'   => '已是最高推荐人或上级已存在',
                            'refer' => $refer['m_nickname'],
                            'name'  => $this->shop['s_name'],
                            'brief' => $this->shop['s_brief'],
                            'status'=> false
                        )
                    );
                    $this->outputSuccess($info);
                    die();
                }
            }else{
                $info = array(
                    'data' => array(
                        'tip'   => '用户不存在',
                        'refer' => $refer['m_nickname'],
                        'name'  => $this->shop['s_name'],
                        'brief' => $this->shop['s_brief'],
                        'status'=> false
                    )
                );
                $this->outputSuccess($info);
                die();
            }
        }
    }

    
    public function resetSpreadAction(){
        //检查是否是真实会员
        $is_real_member = App_Helper_MemberLevel::isRealMember($this->shop['s_id'], $this->member['m_id']);
        if (!$is_real_member) {
            $center_model   = new App_Model_Member_MysqlMemberCenterStorage();
            $center_cfg     = $center_model->findUpdateBySid($this->shop['s_id']);
            $default_cfg    = plum_parse_config('center_cfg');
            if ($center_cfg && $center_cfg['cc_noqr_tip']) {
                $tip    = $center_cfg['cc_noqr_tip'];
            } else {
                $tip    = $default_cfg['cc_noqr_tip'];
            }

            $this->outputError($tip);
        }
        $updata     = array(
            'm_spread_image' => ''
        );
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member_storage->updateById($updata, $this->member['m_id']);
        if($this->sid==7163 || $this->sid==7224){
            $this->_create_spread_image_new();
        }else{
            $this->_create_spread_image();
        }
        $member = $member_storage->getRowById($this->member['m_id']);
        //获取会员等级说明
        $level      = App_Helper_MemberLevel::fetchMemberLevel($this->shop['s_id'], $member['m_id']);
        $info = array(
            'data'  =>array(
                'qrcode' => $this->dealImagePath($member['m_spread_qrcode']),
                'spreadImage' => $this->dealImagePath($member['m_spread_image'],true),
                'level' => $level
            )
        );
        $this->outputSuccess($info);
    }

    
    public function threeCfgAction(){
        $three_model = new App_Model_Three_MysqlCfgStorage($this->sid);
        $row         = $three_model->getRowValue();
        if($row){
            $privilege = json_decode($row['tc_fx_privilege'],true);
            if($privilege){
                foreach ($privilege as $val){
                    $data[] = array(
                        'iconSrc'      => $this->dealImagePath($val['iconSrc']),
                        'firstTitle'   => $val['firstTitle'],
                        'secondTitle'  => $val['secondTitle'],
                    );
                }
            }

            $extra_model = new App_Model_Member_MysqlMemberExtraStorage($this->sid);
            $extra = $extra_model->findUpdateExtraByMid($this->member['m_id']);
            $level_model = new App_Model_Copartner_MysqlCopartnerLevelStorage($this->sid);
            $level = $level_model->getRowById($extra['ame_copartner']);
            if($this->member['m_1f_id']){
                $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
                $fmember = $member_storage->getRowById($this->member['m_1f_id']);
            }

            $info['data'] = array(
                'shopName'    => $this->shop['s_name'],
                'recommender' => $fmember?$fmember['m_nickname']:'官方推荐',
                'banner'      => $this->dealImagePath($row['tc_fx_banner']),
                'hasname'      => $row['tc_fx_hasname'],
                'hasphone'     => $row['tc_fx_hasphone'],
                'haswx'        => $row['tc_fx_haswx'],
                'privilege'     => $data,
                'desc'         => $row['tc_fx_desc'],
                'isdistrib'    => ($this->member['m_is_highest'] > 0) ? 1 : 0,
                'isapply'      => $this->_is_apply_branch($this->member),
                'threeLevel'   => $this->three_level,
                'pageTitle'    => $row['tc_fx_page_title'] ? $row['tc_fx_page_title'] : '',
                'btnText'      => $row['tc_fx_btn_text'] ? $row['tc_fx_btn_text'] : '',
                'welcomeText' => $row['tc_fx_welcome_text'] ? $row['tc_fx_welcome_text'] : '',
                'rightsTitle'  => $row['tc_fx_rights_title'] ? $row['tc_fx_rights_title'] : '合伙人特权',
                'levelList'    => $this->_get_copartner_level_list($row['tc_level'])
            );
            if($this->applet_cfg['ac_type'] == '6' || $this->applet_cfg['ac_type'] == '8'){
                $info['data']['isdistrib'] = ($this->member['m_is_highest'] > 0) ? 1 : 0;
            }
            $info['data']['currLevel'] = $level;
            $info['data']['currLevelName'] = $level?$level['cl_name']:'';
          	 $area_model = new App_Model_Address_MysqlAddressCoreStorage();
    $where      = array();
    $where[]    = array('name'=>'region_type','oper'=>'=','value'=>1);
    $prolist    = $area_model->getList($where,0,0,array());
    foreach($prolist as $val){
        $where = array();
        $where[]    = array('name'=>'region_type','oper'=>'=','value'=>2);
        $where[]    = array('name'=>'parent_id','oper'=>'=','value'=>$val['region_id']);
        $city       = $area_model->getList($where,0,0,array());
        $citylist   = array();
        foreach($city as $v){
            $where = array();
            $where[]    = array('name'=>'region_type','oper'=>'=','value'=>3);
            $where[]    = array('name'=>'parent_id','oper'=>'=','value'=>$v['region_id']);
            $area       = $area_model->getList($where,0,0,array());
            $arealist   = array();
            foreach($area as $vv){
                $arealist[] = array(
                    'id'   => $vv['region_id'],
                    'name' => $vv['region_name']
                );
            }
            $citylist[] = array(
                'id'   => $v['region_id'],
                'name' => $v['region_name'],
                'arealist' => $arealist
            );
        }
        $info['pro'][] = array(
            'id'   => $val['region_id'],
            'name' => $val['region_name'],
            'citylist' => $citylist
        );
    }
            $this->outputSuccess($info);
        }else{
            $this->outputError('暂未开通分销功能1111');
        }

    }

    
    private function _get_copartner_level_list($level){
        $level_model = new App_Model_Copartner_MysqlCopartnerLevelStorage($this->sid);
        $list = $level_model->getListBySid($this->sid, 0, 0);
        $deduct_model = new App_Model_Copartner_MysqlCopartnerDeductCfgStorage();
        $return = array();
        foreach ($list as $key => $value){
            $data = array(
                'levelId'   => $value['cl_id'],
                'levelName' => $value['cl_name'],
                'levelPrice' => $value['cl_money']
            );
            $deductList = $deduct_model->getListByShopId($this->sid, $value['cl_id']);
            $data['deduct'] = array(
                'firstRatio' => $deductList[0]['cdc_1f_ratio'] ? $deductList[0]['cdc_1f_ratio'] : 0,
                'secondRatio' => $deductList[0]['cdc_2f_ratio'] && $level>1 ? $deductList[0]['cdc_2f_ratio'] : 0,
                'threeRatio' => $deductList[0]['cdc_3f_ratio'] && $level>2 ? $deductList[0]['cdc_3f_ratio'] : 0,
            );
            $return[] = $data;
        }
        return $return;
    }

    
    public function applyDistributionAction(){
        // 姓名
        $realname = $this->request->getStrParam('realname');
        $mobile   = $this->request->getStrParam('mobile');
        $wxno     = $this->request->getStrParam('wxno');
        $pro      = $this->request->getIntParam('pro');
        $city     = $this->request->getIntParam('city');
        $area     = $this->request->getIntParam('area');
        $branch_model = new App_Model_Shop_MysqlShopBranchStorage($this->sid);
        $row = $branch_model->findBranchByMid($this->member['m_id'], $this->member['m_1f_id']);

        $three_model    = new App_Model_Three_MysqlCfgStorage($this->sid);
        $three_cfg      = $three_model->getRowValue();
        if($this->member['m_is_slient'] == 1){
        	 $this->outputError('请先授权小程序信息');
        }
        if ($three_cfg['tc_fx_vip'] && !App_Helper_MemberLevel::newCheckVipMember($this->sid, $this->member['m_id'])) {
            $this->outputError('对不起,您还不是我们的会员,请先购买VIP会员');
        }
	   $member_model  = new App_Model_Member_MysqlMemberCoreStorage();
       $extra_model =  new App_Model_Member_MysqlMemberExtraStorage();
       $where       =  array();
       $where[]     = array('name'=>'ame_pro','oper'=>'=','value'=>$pro);
       $where[]     = array('name'=>'ame_city','oper'=>'=','value'=>$city);
       $where[]     = array('name'=>'ame_area','oper'=>'=','value'=>$area);
       $extra       = $extra_model->getRow($where);
       if($extra){
        $fmember = $member_model->getRowById($extra['ame_m_id']);
        if($fmember['m_is_highest'] > 0){
           $this->outputError('对不起,此区域已有分销商');
        }
       }
      
        $data = array(
            'sb_m_id'     => $this->member['m_id'],
            'sb_s_id'     => $this->sid,
            'sb_realname' => $realname,
            'sb_f_id'     => $this->member['m_1f_id'],
            'sb_phone'    => $mobile,
            'sb_wxno'     => $wxno,
            'sb_status'   => 0,
            'sb_web_hide' => 0,
            'sb_pro'      => $pro,
            'sb_area'     => $area,
            'sb_city'     => $city,
            'sb_update_time' => time(),
        );
        // 获取分销配置
        $audit = $this->_fetch_distribution();
        if($audit==0 && !$data['sb_f_id']){
            $data['sb_status'] = 1;
            if($this->member['m_is_highest']==0 && $this->member['m_1f_id']==0){
                $update = array('m_is_highest'=>1);
                $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                $member_model->updateById($update,$this->uid);
            }
        }
        if($row){
            $ret = $branch_model->updateById($data,$row['sb_id']);
        }else{
            $data['sb_create_time'] = time();
            $ret = $branch_model->insertValue($data);
        }
        if($ret){
            $info['data'] = array(
                'result'  => true,
                'msg'     => '申请成功',
                'isapply' => 1
            );
            $this->outputSuccess($info);
        }else{
            $this->outputError('申请失败');
        }

    }

    
    public function _fetch_distribution(){
        $three_model = new App_Model_Three_MysqlCfgStorage($this->sid);
        $threeCfg         = $three_model->findShopCfg();
        return $threeCfg['tc_fx_audit'];
    }

    
    public function applyWithdrawCfgAction(){
        //提现配置
        $wdcfg_storage  = new App_Model_Shop_MysqlWithdrawCfgStorage();
        $withdraw_cfg   = $wdcfg_storage->findCfgBySid($this->sid);
        if($withdraw_cfg){
            $support_bank = plum_parse_config('support_bank','system');
            $info['data'] = array(
                'desc'        => isset($withdraw_cfg['wc_desc']) ? $withdraw_cfg['wc_desc'] : '',
                'min'         => $withdraw_cfg['wc_min'],
                'wxOpen'      => $withdraw_cfg['wc_change_open'],  // 微信零钱提现
                'bankOen'     => $withdraw_cfg['wc_bank_open'],    // 微信银行卡提现
                'mobileOpen'  => $withdraw_cfg['wc_mobile_open'],    // 微信手机开启
                'accountOpen'  => $withdraw_cfg['wc_account_open'],    // 微信账户开启
                'bankMobileOpen'  => $withdraw_cfg['wc_bank_mobile_open'],    // 银行卡手机开启
                'supportBank' => $support_bank,
                'wxHistory'   => $this->_get_withdraw_history(1),
                'bankHistory'   => $this->_get_withdraw_history(3),
                'serviceMsg'    => $withdraw_cfg['wc_rate']>0?'本次提现收取'.$withdraw_cfg['wc_rate'].'%的手续费':'',    //提现手续费
            );
            $this->outputSuccess($info);
        }else{
            $this->outputError('商家暂未配置');
        }
    }
    private function _get_withdraw_history($type){
        $withdraw_storage   = new App_Model_Member_MysqlWithDrawalStorage();
        $history = $withdraw_storage->getLastHistory($type,$this->sid, $this->uid);
        $data = array();
        if($history){
            $data = array(
                'realname' => $history['wd_realname'],
                'mobile' => $history['wd_mobile'],
                'account' => $history['wd_account'],
                'bank' => $history['wd_bank'],
                'money' => $history['wd_money'],
                'serviceMoney' => $history['wd_service_money'],

            );
        }
        return $data;
    }


    
    private function _recharge_copartner_order_deduct($tid, $total, $id) {

        $goods_deduct   = new App_Model_Goods_MysqlDeductStorage($this->sid);
        $order_deduct   = new App_Helper_OrderDeduct($this->sid);

        //使用店铺分佣设置
        $ratio  = $this->_deduct_copartner_translate();
        Libs_Log_Logger::outputLog($ratio);
        //设置商品分佣
        $order_deduct->createOrderDeduct($this->member['m_id'], $tid, $total, $ratio, $id, 8);
    }

    
    private function _deduct_copartner_translate() {
        $three_level  = App_Helper_ShopWeixin::checkShopThreeLevel($this->sid);
        $member_storage   = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->getRowById($this->uid);
        $deduct_model   = new App_Model_Copartner_MysqlCopartnerDeductCfgStorage();
        $data = array();
        for ($i=0; $i<=$three_level; $i++) {
            $tmp    = "{$i}f";
            //购买人或其上级存在
            $benefit    = $i == 0 ? $member['m_id'] : $member["m_{$tmp}_id"];
            $extra_model = new App_Model_Member_MysqlMemberExtraStorage($this->sid);
            $extra = $extra_model->findUpdateExtraByMid($benefit);
            $deduct_list    = $deduct_model->fetchDeductListBySid($this->sid, $extra['ame_copartner']);
            $deduct = $deduct_list[1];
            $data[$i] = $deduct['cdc_'.$i.'f_ratio'];
        }
        return $data;
    }

    
    public function branchApplyAuditAction(){
        $id = $this->request->getIntParam('id');
        $status = $this->request->getIntParam('status');  //1通过  2拒绝
        $set      = array(
            'sb_update_time' => time(),
            'sb_status'      => $status == 1 ? 1 : 2
        );
        $branch_model = new App_Model_Shop_MysqlShopBranchStorage($this->sid);
        $ret = $branch_model->getRowUpdateByIdSid($id,$this->sid,$set);
        if($ret && $status==1){
            $branch = $branch_model->getRowUpdateByIdSid($id,$this->sid);
            $extra_model = new App_Model_Member_MysqlMemberExtraStorage($this->sid);
            $set = array('ame_distrib_faudit' => 0);
            $extra_model->findUpdateExtraByMid($branch['sb_m_id'], $set);
        }
        if($ret){
            $info['data'] = array(
                'result' => true,
                'msg'    => '操作成功',
            );
            $this->outputSuccess($info);
        }else{
            $this->outputError('操作失败');
        }
    }

}