<?php


class App_Controller_Applet_RedbagController extends App_Controller_Applet_InitController
{

    public function __construct()
    {
        parent::__construct();

    }

    /*
     * 活动详情
     */
    public function activityDetailAction(){
        $mid = $this->request->getIntParam('mid');
        $groupId = $this->request->getIntParam('groupId',0);//通过分享的活动组队id

        //获得当前店铺开启的活动
        $activity_model = new App_Model_Redbag_MysqlRedbagActivityStorage($this->sid);
        $activity = $activity_model->getRowOpen();
        $join_model = new App_Model_Redbag_MysqlRedbagJoinStorage($this->sid);

        $hadGroup = $this->_get_group_had_join($activity['ara_id']);//已经参与的仍在进行的活动组队

        if($groupId){
            $data = $this->_deal_activity_detail_with_group($groupId,$mid,$hadGroup);
        }else{
            $data = $this->_deal_activity_detail_no_group($activity,$hadGroup);
        }
        if($data){
            //获得活动参与人数
            $where = [];
            $activity_ava = [];
            $where[] = ['name' => 'arj_s_id', 'oper' => '=', 'value' => $this->sid];
            $where[] = ['name' => 'arj_a_id', 'oper' => '=', 'value' => $data['aid']];
//            $activity_total = $join_model->getCountMemberGroup($where);
            $activity_total = $join_model->getJoinCountGroup($where);
            //获得活动参与前五人头像
//            $activity_join = $join_model->getListMemberGroup($where,0,5,['arj_create_time'=>'DESC']);
            $activity_join = $join_model->getJoinListGroup($where,0,5,['arj_create_time'=>'DESC']);
            if($activity_join){
                foreach ($activity_join as $activity_val){
//                    $activity_ava[] = $activity_val['m_avatar'] ? $this->dealImagePath($activity_val['m_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png');
                    $activity_ava[] = $activity_val['arj_avatar'] ? $this->dealImagePath($activity_val['arj_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png');
                }
            }
            $data['activityTotal'] = $activity_total ? intval($activity_total) : 0;
            $data['activityAvatars'] = $activity_ava;
            //获得活动领取记录
            $where_reveive = [];
            $receive_data = [];
            $where_reveive[] = ['name' => 'arr_s_id', 'oper' => '=', 'value' => $this->sid];
            $where_reveive[] = ['name' => 'arr_a_id', 'oper' => '=', 'value' => $data['aid']];
            $receive_model = new App_Model_Redbag_MysqlRedbagReceiveStorage($this->sid);
//            $receive_list = $receive_model->getListMember($where_reveive,0,10,['arr_create_time'=>'DESC']);
            $receive_list = $receive_model->getList($where_reveive,0,10,['arr_create_time'=>'DESC']);
            if($receive_list){
                foreach ($receive_list as $receive_val){
                    $receive_data[] = [
//                        'avatar' => $receive_val['m_avatar'] ? $this->dealImagePath($receive_val['m_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
//                        'desc' => ($receive_val['m_nickname'] ? $receive_val['arr_nickname'] : '匿名用户').'刚刚领取'.floatval($receive_val['arr_money']).'元'
                        'avatar' => $receive_val['arr_avatar'] ? $this->dealImagePath($receive_val['arr_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
                        'desc' => ($receive_val['arr_nickname'] ? $receive_val['arr_nickname'] : '匿名用户').'刚刚领取'.floatval($receive_val['arr_money']).'元'
                    ];
                }
            }
            $data['receiveList'] = $receive_data;
            //获得分享人信息
            $data['shareAvatar'] = '';
            if($mid){
                $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                $shareMember = $member_model->getRowById($mid);
                if($shareMember){
                    $data['shareAvatar'] = $shareMember['m_avatar'] ? $this->dealImagePath($shareMember['m_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png');
                }
            }

            $data['shareTitle'] = $activity['ara_share_title'] ? $activity['ara_share_title'] : '';
            $data['shareImg'] = $activity['ara_share_img'] ? $this->dealImagePath($activity['ara_share_img']) : '';

            $info['data'] = $data;
            $this->outputSuccess($info);
        }else{
            $this->outputError('未找到活动信息');
        }
    }


    /*
     * 获得当前用户已经参与的群组
     */
    private function _get_group_had_join($aid){
        $join_model = new App_Model_Redbag_MysqlRedbagJoinStorage($this->sid);
        $group = [];
        //获得我参与的未结束的群组
        $timeNow = time();
        $where_join = [];
        $where_join[] = ['name' => 'arj_s_id', 'oper' => '=', 'value' => $this->sid];
        $where_join[] = ['name' => 'arj_a_id', 'oper' => '=', 'value' => $aid];
        $where_join[] = ['name' => 'arj_m_id', 'oper' => '=', 'value' => $this->member['m_id']];
        //未完成未结束或已完成未领取
        $where_join[] = "( (arg_status = 1 and arg_overtime_time > {$timeNow} and ara_status = 1) or (arg_status = 2 and arj_receive = 0) )";
        $join = $join_model->getRowGroup($where_join);
        if($join){
            $group = $join;
        }
        return $group;
    }

    /*
     * 获得当前用户参与次数
     */
    private function _get_member_join_count($aid,$today = true){

        $where = [];
        $where[] = ['name' => 'arj_s_id', 'oper' => '=', 'value' => $this->sid];
        $where[] = ['name' => 'arj_m_id', 'oper' => '=', 'value' => $this->member['m_id']];
        $where[] = ['name' => 'arj_a_id', 'oper' => '=', 'value' => $aid];
        if($today){
            $time_0 = strtotime(date('Y-m-d'));
            $time_24 = $time_0 + 86399;
            $where[] = ['name' => 'arj_create_time', 'oper' => '>=', 'value' => $time_0];
            $where[] = ['name' => 'arj_create_time', 'oper' => '<=', 'value' => $time_24];
        }
        $join_model = new App_Model_Redbag_MysqlRedbagJoinStorage($this->sid);
        $total = $join_model->getCount($where);
        return $total ? intval($total) : 0;
    }

    /*
     * 获得群组参与用户
     */
    private function _get_group_join_member($groupId,$num){
        $where_group = [];
        $where_group[] = ['name' => 'arj_s_id', 'oper' => '=', 'value' => $this->sid];
        $where_group[] = ['name' => 'arj_group', 'oper' => '=', 'value' => $groupId];
        $join_model = new App_Model_Redbag_MysqlRedbagJoinStorage($this->sid);
        $sort = ['arj_id' => 'asc'];
//        $group_join = $join_model->getListMember($where_group,0,$num,$sort);
        $group_join = $join_model->getList($where_group,0,$num,$sort);
        $group_member = [
            'mids' => [],
            'avatars' => []
        ];
        if($group_join){
            foreach ($group_join as $group_val){
                $group_member['avatars'][] = $group_val['arj_avatar'] ? $this->dealImagePath($group_val['arj_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png');
                $group_member['mids'][] = $group_val['arj_m_id'];
            }
        }



        return $group_member;
    }

    /*
     * 处理有群组id的活动详情
     */
    private function _deal_activity_detail_with_group($groupId,$mid,$hadGroup){

        $group_model = new App_Model_Redbag_MysqlRedbagGroupStorage($this->sid);
        $row = $group_model->getRowActivity($groupId);
        if($row && $row['ara_id']){
            $otherGroup = false;//是否有正在进行的其他组队
            $canCreate = false; //可以发起组队
            $canReceive = false; //可以领取红包
            $canJoin = false; //可以加入组队
            $hadJoin = false; //是否已经加入组队
            if($hadGroup['arg_id'] && $hadGroup['arg_id'] != $groupId){
                $otherGroup = true;
            }
            $timeNow = time();
            //获得群组参与用户
            $num = intval($row['ara_num']);
            $group_member = $this->_get_group_join_member($groupId,$num);

            if(in_array($this->member['m_id'],$group_member['mids'])){
                $hadJoin = true;
            }
            $group_limit = $this->_check_group_limit($row);
            $numJoin = count($group_member['mids']);
            $time = $row['arg_overtime_time'] - $timeNow;
            $today_count = $this->_get_member_join_count($row['ara_id']);//今日已参与的次数
            $total_count = $this->_get_member_join_count($row['ara_id'],false);
            //判断活动状态
            if(($row['arg_status'] == 2 || $numJoin >= $row['ara_num']) && in_array($this->member['m_id'],$group_member['mids'])){
                //组队成功且当前用户参与组队
                $status = 2;
                $statusNote = '组队成功';
                $join_model = new App_Model_Redbag_MysqlRedbagJoinStorage($this->sid);
                //判断是否可以领取
                $where_join = [];
                $where_join[] = ['name' => 'arj_s_id', 'oper' => '=', 'value' => $this->sid];
                $where_join[] = ['name' => 'arj_group', 'oper' => '=', 'value' => $groupId];
                $where_join[] = ['name' => 'arj_m_id', 'oper' => '=', 'value' => $this->member['m_id']];
                $join_row = $join_model->getRow($where_join);
                if($join_row['arj_receive'] == 0){
                    $canReceive = true;
                }

                if($row['arg_status'] != 2 && $numJoin >= $row['ara_num']){
                    //&& empty(json_decode($row['arg_money_arr'],1))
                    //更新正确的状态
                    $group_model->updateById(['arg_status' => 2],$row['arg_id']);
                }

            }else{
                if($otherGroup){
                    //有正在进行
                    $status = 5;
                    $statusNote = '您有正在进行中的组队';
                }elseif(!in_array($this->member['m_id'],$group_member['mids']) && (($row['ara_limit'] > 0 && $today_count >= $row['ara_limit']) || ($row['ara_limit_total'] > 0 && $total_count >= $row['ara_limit_total']) || $group_limit)){
                    //还未参加且到次数了
                    $status = 4;
                    if(($row['ara_limit_total'] > 0 && $total_count >= $row['ara_limit_total']) || $group_limit){
                        $statusNote = '组队次数达到上限';
                    }else{
                        $statusNote = '今日组队次数达到上限';
                    }
                }elseif (($row['ara_status'] == 2 && !($row['arg_status'] == 2 || $numJoin >= $row['ara_num'])) || ($row['arg_status'] == 1 && $row['arg_overtime_time'] < $timeNow)){
                    //活动已下线组队未成功 或 组队未成功组队超时
                    $status = 3;
                    $statusNote = $mid ? '该组队已失效' : '组队失败';
                    $canCreate = true;
                }elseif (($row['arg_status'] == 2 || $numJoin >= $row['ara_num']) && !in_array($this->member['m_id'],$group_member['mids'])){
                    //组队已成功且用户未参与
                    $status = 2;
                    $statusNote = '已组队完成';
                    $canCreate = true;

                    if($row['arg_status'] != 2 && $numJoin >= $row['ara_num']){
                        //&& empty(json_decode($row['arg_money_arr'],1))
                        //更新正确的状态
                        $group_model->updateById(['arg_status' => 2],$row['arg_id']);
                    }

                }else{
                    $status = 1;
                    $statusNote = '';
                    $canCreate = true;
                    $canJoin = true;
                }
            }
            if($otherGroup){
                //有正在进行的未完成/失效的组队 则不能创建或加入
                $canCreate = false;
                $canJoin = false;
            }

            $data = [
                'aid' => $row['ara_id'],
                'groupId' => $row['arg_id'],
                'money' => floatval($row['ara_money']),
                'numTotal' => $num,
                'numLeft' => $num - $numJoin,
                'status' => $status,
                'statusNote' => $statusNote,
                'time' => $time > 0 ? $time : 0,
                'groupAvatars' => $group_member['avatars'],
                'rule' => $row['ara_rule'] ? $row['ara_rule'] : '',
                'canCreate' => $canCreate,
                'canJoin' => $canJoin,
                'canReceive' => $canReceive,
                'hadJoin' => $hadJoin,
                'otherGroupId' => $hadGroup['arg_id'] && $otherGroup ? intval($hadGroup['arg_id']) : 0
            ];
            return $data;

        }else{
            $this->outputError('未找到活动信息');
        }
    }


    /*
     * 处理有没有群组id的活动详情
     */
    private function _deal_activity_detail_no_group($activity,$hadGroup){
        $data = [];
        if($activity){
            //已有参与且为当前活动
            if($hadGroup && $hadGroup['arg_a_id'] == $activity['ara_id']){
                $data = $this->_deal_activity_detail_with_group($hadGroup['arg_id'],0,$hadGroup);
            }else{
                //获得最近一条失败的组队
                $join_model = new App_Model_Redbag_MysqlRedbagJoinStorage($this->sid);
                $where_join = [];
                $timeNow = time();
                $where_join[] = ['name' => 'arj_s_id', 'oper' => '=', 'value' => $this->sid];
                $where_join[] = ['name' => 'arj_m_id', 'oper' => '=', 'value' => $this->member['m_id']];
                $where_join[] = ['name' => 'arg_a_id', 'oper' => '=', 'value' => $activity['ara_id']];
                $where_join[] = "( arg_status = 1 AND ( arg_overtime_time < {$timeNow} OR ara_status = 2 ) )";//组队中且（活动下架或组队时间到期）
                $join = $join_model->getListGroup($where_join,0,1,['arg_id'=>'DESC'])[0];
                if($join['arg_id']){
                    $data = $this->_deal_activity_detail_with_group($join['arg_id'],0,array());
                }else{
                    //无进行中的或失败的组队 直接发起新组队
                    $data = [
                        'aid' => $activity['ara_id'],
                        'groupId' => 0,
                        'money' => floatval($activity['ara_money']),
                        'numTotal' => $activity['ara_num'],
                        'numLeft' => $activity['ara_num'] - 1,
                        'status' => 1,//一定是进行中
                        'statusNote' => '',
                        'time' => $activity['ara_hour'] * 3600,
                        'groupAvatars' => [],
                        'rule' => $activity['ara_rule'] ? $activity['ara_rule'] : '',
                        'canCreate' => false,//可以发起组队
                        'canReceive' => false,//可以领取红包
                        'canJoin' => false,//可以加入组队
                        'hadJoin' => false,//是否已经加入组队,
                        'otherGroupId' => 0
                    ];
                    $check_limit = $this->_check_limit($activity,true);
                    if($check_limit){
                        if($check_limit == 2 || $check_limit = 3){
                            $data['statusNote'] = '组队达到上限';
                        }else{
                            $data['statusNote'] = '今日组队达到上限';
                        }
                        $data['status'] = 4;
                    }else{
                        //发起并加入活动
                        //创建群组
                        $groupId = $this->_create_group($activity);
                        if($groupId){
                            //添加加入记录
                            $joinId = $this->_create_join($groupId,$activity,1);
                            $data['groupId'] = $groupId;
                            $data['groupAvatars'][] = $this->member['m_avatar'] ? $this->dealImagePath($this->member['m_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png');
                            $data['hadJoin'] = true;

                        }else{
                            $this->outputError('未找到活动信息');
                        }
                    }
                }
            }
        }else{
            $this->outputError('未找到活动信息');
        }
        return $data;
    }

    /*
     * 创建活动组队
     */
    private function _create_group($activity){
        $hadGroup = $this->_get_group_had_join($activity['ara_id']);
        $groupId = 0;
        if($hadGroup){
            $this->outputError('您有正在进行中的组队');
        }else{
            $moneyArr = $this->_get_random_money($activity['ara_money'],$activity['ara_num']);
            $timeNow = time();
            $group = [
                'arg_s_id' => $this->sid,
                'arg_create_mid' => $this->member['m_id'],
                'arg_a_id' => $activity['ara_id'],
                'arg_overtime_time' => $timeNow + $activity['ara_hour'] * 3600,
//                'arg_overtime_time' => $timeNow + 60,
                'arg_status' => 1,
                'arg_money_arr' => json_encode($moneyArr),
                'arg_create_time' => $timeNow
            ];
            $group_model = new App_Model_Redbag_MysqlRedbagGroupStorage($this->sid);
            $groupId = $group_model->insertValue($group);
        }
        return $groupId;
    }

    /*
     * 添加组队加入记录
     */
    private function _create_join($groupId,$activity,$isCreate = 0){
        //查找当前组队最新一条加入信息
        $group_model = new App_Model_Redbag_MysqlRedbagGroupStorage($this->sid);
        $group = $group_model->getRowById($groupId);
        $moneyArr = json_decode($group['arg_money_arr'],1);
        $joinId = 0;
        if($moneyArr){
            $money = $moneyArr[0];
            unset($moneyArr[0]);
            $moneyArr = array_values($moneyArr);//重置索引
            $moneyArrJson = json_encode($moneyArr);
            $group_model->updateById(['arg_money_arr'=>$moneyArrJson],$groupId);
            //重新取出用户信息
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $member = $member_model->getRowById($this->member['m_id']);
            $join = [
                'arj_s_id' => $this->sid,
                'arj_a_id' => $activity['ara_id'],
                'arj_m_id' => $this->member['m_id'],
                'arj_nickname' => $member['m_nickname'],
                'arj_avatar' => $member['m_avatar'],
                'arj_group' => $groupId,
                'arj_money' => $money,
                'arj_is_create' => $isCreate,
                'arj_overtime_time' => $group['arg_overtime_time'],
                'arj_create_time' => time()
            ];
            $join_model = new App_Model_Redbag_MysqlRedbagJoinStorage($this->sid);
            $joinId = $join_model->insertValue($join);
            if(!$joinId){
                //把钱加回去
                $moneyArr[] = $money;
                $moneyArrJson = json_encode($moneyArr);
                $group_model->updateById(['arg_money_arr'=>$moneyArrJson],$groupId);
                $this->outputError('参与失败');
            }
        }else{
            $this->outputError('参与失败');
        }
        return $joinId;
    }

    /*
     * 随机拆分生成红包数组
     */
    private function _get_random_money($total,$num,$min = 0.01){
        $money_right=$total;
        $randMoney=[];
        for($i=1;$i<=$num;$i++){
            if($i== $num){
                $money=$money_right;
            }else{
                $max=$money_right*100 - ($num - $i ) * $min *100;
                $money= rand($min*100,$max) /100;
                $money=sprintf("%.2f",$money);
            }
            $randMoney[]=$money;
            $money_right=$money_right - $money;
            $money_right=sprintf("%.2f",$money_right);
        }
        shuffle($randMoney);
        return $randMoney;
    }

    private function _check_group_limit($activity){
        $limit = false;
        if($activity['ara_limit_group'] > 0){
            $group_model = new App_Model_Redbag_MysqlRedbagGroupStorage($this->sid);
            $where[] = ['name' => 'arg_s_id', 'oper' => '=', 'value' => $this->sid];
            $where[] = ['name' => 'arg_a_id', 'oper' => '=', 'value' => $activity['ara_id']];
            $group_count = $group_model->getCount($where);
            $group_count = intval($group_count);
            if($group_count >= $activity['ara_limit_group']){
                $limit = true;
            }
        }
        return $limit;
    }

    private function _check_limit($activity,$createGroup = false){
        $today_count = $this->_get_member_join_count($activity['ara_id']);
        $total_count = $this->_get_member_join_count($activity['ara_id'],false);
        $status = 0;
        if($createGroup){
            //判断总组队次数限制
            $limit = $this->_check_group_limit($activity);
            if($limit){
                //如果达到总组队次数限制，直接返回
                return 3;
            }
        }
        if(($activity['ara_limit'] > 0 && $today_count >= $activity['ara_limit']) || ($activity['ara_limit_total'] > 0 && $total_count >= $activity['ara_limit_total'])){
            if($activity['ara_limit_total'] > 0 && $total_count >= $activity['ara_limit_total']){
                $status = 2;//组队达到上限
            }else{
                $status = 1;//今日组队达到上限
            }
        }
        return $status;
    }

    /*
     * 发起活动组队
     */
    public function createGroupAction(){
        $aid = $this->request->getIntParam('aid');
        $activity_model = new App_Model_Redbag_MysqlRedbagActivityStorage($this->sid);
        $activity = $activity_model->getRowById($aid);
        if($activity && $activity['ara_status'] == 1){
            $check_limit = $this->_check_limit($activity,true);
            if($check_limit){
                if($check_limit == 2 || $check_limit == 3){
                    $this->outputError('组队达到上限');
                }else{
                    $this->outputError('今日组队达到上限');
                }
            }
            $groupId = $this->_create_group($activity);
            if($groupId){
                $this->_create_join($groupId,$activity,1);
                $info['data'] = [
                    'msg' => '发起组队成功',
                    'aid' => $activity['ara_id'],
                    'groupId' => $groupId
                ];
                $this->outputSuccess($info);
            }else{
                $this->outputError('发起组队失败');
            }
        }else{
            $this->outputError('活动不存在或已结束');
        }
    }

    /*
     * 参加组队
     */
    public function joinGroupAction(){
        $groupId = $this->request->getIntParam('groupId');
        $mid = $this->request->getIntParam('mid');
        $group_model = new App_Model_Redbag_MysqlRedbagGroupStorage($this->sid);
        $group = $group_model->getRowById($groupId);
        $activity_model = new App_Model_Redbag_MysqlRedbagActivityStorage($this->sid);
        $activity = $activity_model->getRowById($group['arg_a_id']);
        if($activity && $activity['ara_status'] == 1){
            $hadGroup = $this->_get_group_had_join($activity['ara_id']);
            if($hadGroup){
                $this->outputError('您有正在进行中的组队');
            }
            //获得今天参与次数
            $check_limit = $this->_check_limit($activity);
            if($check_limit){
                if($check_limit == 2){
                    $this->outputError('组队达到上限');
                }else{
                    $this->outputError('今日组队达到上限');
                }
            }
            $where_group[] = ['name' => 'arj_s_id', 'oper' => '=', 'value' => $this->sid];
            $where_group[] = ['name' => 'arj_m_id', 'oper' => '=', 'value' => $this->member['m_id']];
            $where_group[] = ['name' => 'arj_group', 'oper' => '=', 'value' => $groupId];
            $join_model = new App_Model_Redbag_MysqlRedbagJoinStorage($this->sid);
            $join_exist = $join_model->getRow($where_group);
            if($join_exist){
                $this->outputError('您已经参与了此活动');
            }

            $res = $this->_create_join($groupId,$activity);
            if($res){
                $info['data'] = [
                    'msg' => '参与组队成功',
                    'groupId' => $groupId,
                    'mid' => $mid
                ];
                //获得群组中已组队的人数
                $where_join = [];
                $where_join[] = ['name' => 'arj_s_id', 'oper' => '=', 'value' => $this->sid];
                $where_join[] = ['name' => 'arj_group', 'oper' => '=', 'value' => $groupId];
                $join_total = $join_model->getCount($where_join);
                if($join_total >= $activity['ara_num']){
                    //修改群组状态为已完成
                    $group_model->updateById(['arg_status'=>2],$groupId);
                    //发送组队成功消息
                    plum_open_backend('templmsg', 'redbagSuccessTempl', array('sid' => $this->sid, 'id' => $res));
                }
                $this->outputSuccess($info);
            }else{
                $this->outputError('参与组队失败');
            }
        }else{
            $this->outputError('活动不存在或已结束');
        }
    }

    /*
     * 领取红包
     */
    public function receiveAction(){
        $groupId = $this->request->getIntParam('groupId');
        $join_model = new App_Model_Redbag_MysqlRedbagJoinStorage($this->sid);
        $where = [];
        $where[] = ['name' => 'arj_s_id', 'oper' => '=', 'value' => $this->sid];
        $where[] = ['name' => 'arj_group', 'oper' => '=', 'value' => $groupId];
        $where[] = ['name' => 'arj_m_id', 'oper' => '=', 'value' => $this->member['m_id']];
        $where[] = ['name' => 'arj_receive', 'oper' => '=', 'value' => 0];
        $join = $join_model->getRowGroup($where);
        if($join && $join['arg_status'] == 2){
            $money = floatval($join['arj_money']);
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $res = $member_model->incrementMemberGoldcoin($this->member['m_id'],$money);
            if($res){
                //将领取状态改为已领取
                $join_model->updateById(['arj_receive'=>1],$join['arj_id']);
                //记录余额收益
                $record_storage = new App_Model_Member_MysqlRechargeStorage($this->sid);
                $indata = array(
                    'rr_tid'        => '',
                    'rr_s_id'       => $this->sid,
                    'rr_m_id'       => $this->member['m_id'],
                    'rr_amount'     => 0,
                    'rr_gold_coin'  => $money,
                    'rr_status'     => 1,//标识金币增加
                    'rr_pay_type'   => 11,//组队红包收入
                    'rr_remark'     => '组队红包收入',
                    'rr_create_time'=> time(),
                );
                $record_storage->insertValue($indata);
                //记录领取
                $receive_model = new App_Model_Redbag_MysqlRedbagReceiveStorage($this->sid);
                //重新取出用户信息
                $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                $member = $member_model->getRowById($this->member['m_id']);
                $receive = [
                    'arr_s_id' => $this->sid,
                    'arr_m_id' => $this->member['m_id'],
                    'arr_avatar' => $member['m_avatar'],
                    'arr_nickname' => $member['m_nickname'],
                    'arr_a_id' => $join['arg_a_id'],
                    'arr_group' => $join['arg_id'],
                    'arr_money' => $money,
                    'arr_create_time' => time()
                ];
                $receive_model->insertValue($receive);
                $info['data'] = [
                    'msg' => '已发放至您的钱包',
                    'money' => $money
                ];
                $this->outputSuccess($info);
            }
        }else{
            $this->outputError('领取失败');
        }


    }

    /*
     * 活动参与情况详情
     */
    public function activityJoinDetailAction(){
        $this->count = 45;
        $aid = $this->request->getIntParam('aid');
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $join_model = new App_Model_Redbag_MysqlRedbagJoinStorage($this->sid);
        $where = [];
        $activity_ava = [];
        $where[] = ['name' => 'arj_s_id', 'oper' => '=', 'value' => $this->sid];
        $where[] = ['name' => 'arj_a_id', 'oper' => '=', 'value' => $aid];
        $activity_total = $join_model->getJoinCountGroup($where);
        //获得活动参与人头像
        $activity_join = $join_model->getJoinListGroup($where,$index,$this->count,['arj_create_time'=>'DESC']);
        if($activity_join){
            foreach ($activity_join as $activity_val){
                $activity_ava[] = $activity_val['arj_avatar'] ? $this->dealImagePath($activity_val['arj_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png');
            }
        }
        $data['total'] = $activity_total ? intval($activity_total) : 0;
        $data['avatars'] = $activity_ava;
        $info['data'] = $data;
        $this->outputSuccess($info);
    }


    /*
     * 组队列表
     */
    public function groupListAction(){
        $page = $this->request->getIntParam('page',0);
        $type = $this->request->getStrParam('type','create');

        $index = $page * $this->count;

        $where = [];
        $data = [];
        $timeNow = time();
        $where[] = ['name' => 'arj_s_id', 'oper' => '=', 'value' => $this->sid];
        $where[] = ['name' => 'arj_m_id', 'oper' => '=', 'value' => $this->member['m_id']];
        if($type == 'create'){
            //我发起的
            $where[] = ['name' => 'arj_is_create', 'oper' => '=', 'value' => 1];
        }else{
            $where[] = ['name' => 'arj_is_create', 'oper' => '=', 'value' => 0];
        }
        $sort = ['arj_create_time' => 'desc'];
        $join_model = new App_Model_Redbag_MysqlRedbagJoinStorage($this->sid);
        $list = $join_model->getListGroup($where,$index,$this->count,$sort);
        if($list){
            foreach ($list as $val){
                //获得组队状态
                if($val['arg_status'] == 2){
                    $statusNote = '组队成功';
                }elseif (($val['ara_status'] == 2 && $val['arg_status'] != 2) || ($val['arg_status'] == 1 && $val['arg_overtime_time'] < $timeNow)){
                    $statusNote = '组队失败';
                }else{
                    $statusNote = '正在组队';
                }

                //获得当前组队人数和头像
                $avatars = [];
                $where_stat = [['name' => 'arj_s_id', 'oper' => '=', 'value' => $this->sid],['name' => 'arj_group', 'oper' => '=', 'value' => $val['arj_group']]];
                $joinCount = $join_model->getCount($where_stat);
                $join_list = $join_model->getList($where_stat,0,0,['arj_create_time'=>'DESC']);
                if($join_list){
                    foreach ($join_list as $row){
                        $avatars[] = $row['arj_avatar'] ? $this->dealImagePath($row['arj_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png');
                    }
                }

                $data[] = [
                    'groupId' => $val['arj_group'],
                    'time' => date('Y年m月d日 H:i',$val['arj_create_time']),
                    'statusNote' => $statusNote,
                    'count' => intval($joinCount),
                    'avatars' => $avatars
                ];
            }

            $info['data'] = $data;
            $this->outputSuccess($info);

        }else{
            $this->outputError('没有更多信息了');
        }
    }

    /*
     * 红包记录
     */
    public function receiveRecordAction(){
        $page = $this->request->getIntParam('page');
        $index = $this->count * $page;
        $receive_model = new App_Model_Redbag_MysqlRedbagReceiveStorage($this->sid);
        $where = [];
        $data = [];
        $where[] = ['name' => 'arr_s_id', 'oper' => '=', 'value' => $this->sid];
        $where[] = ['name' => 'arr_m_id', 'oper' => '=', 'value' => $this->member['m_id']];
        $sort = ['arr_create_time' => 'DESC'];
        $list = $receive_model->getListGroup($where,$index,$this->count,$sort);
        if($list){
            foreach ($list as $val){
                $data[] = [
                    'money' => floatval($val['arr_money']),
                    'time' => date('Y年m月d日 H:i',$val['arr_create_time']),
                    'note' => '由'.($val['arj_nickname'] ? $val['arj_nickname'] : '匿名用户').'发起'
                ];
            }
            $info['data'] = $data;
            $this->outputSuccess($info);
        }else{
            $this->outputError('没有更多信息了');
        }
    }

    /*
     * 参与组队的用户头像列表
     */
    public function getGroupMemberAction(){
        $groupId = $this->request->getIntParam('groupId');
        $group_model = new App_Model_Redbag_MysqlRedbagGroupStorage($this->sid);
        $join_model = new App_Model_Redbag_MysqlRedbagJoinStorage($this->sid);
        $group = $group_model->getRowActivity($groupId);



        //获得组队状态
        if($group['arg_status'] == 2){
            $statusNote = '组队成功';
            $status = 2;
        }elseif (($group['ara_status'] == 2 && $group['arg_status'] != 2) || ($group['arg_status'] == 1 && $group['arg_overtime_time'] < time())){
            $statusNote = '组队失败';
            $status = 3;
        }else{
            $statusNote = '正在组队';
            $status = 1;
        }
        //获得发起人信息
        $create_member = [];
        if($group['arg_create_mid']){
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $create_member = $member_model->getRowById($group['arg_create_mid']);
        }
        $info['data']['leaderName'] = $create_member['m_nickname'] ? $create_member['m_nickname'] : '匿名用户';
        $info['data']['leaderAvatar'] = $create_member['m_avatar'] ? $this->dealImagePath($create_member['m_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png');
        $info['data']['money'] = floatval($group['ara_money']);
        $info['data']['nameNote'] =  '由'.$info['data']['leaderName'].'发起的组队';

        //获得当前组队头像
        $avatars = [];
        $where_stat = [['name' => 'arj_s_id', 'oper' => '=', 'value' => $this->sid],['name' => 'arj_group', 'oper' => '=', 'value' => $groupId]];
        $join_list = $join_model->getList($where_stat,0,0,['arj_create_time'=>'DESC']);
        if($join_list){
            foreach ($join_list as $row){
                $avatars[] = $row['arj_avatar'] ? $this->dealImagePath($row['arj_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png');
            }
        }
        $info['data']['status'] = $status;
        $info['data']['statusNote'] = $statusNote;
        $info['data']['avatars'] = $avatars;
        $this->outputSuccess($info);
    }



}