<?php


class App_Controller_Applet_SubjectController extends App_Controller_Applet_InitController
{

    public function __construct()
    {
        parent::__construct();

    }

    
    public function getSubjectNewAction(){
        //获取店铺配置
        $subject_cfg = new App_Model_Applet_MysqlAppletSubjectCfgStorage($this->sid);
        $cfg = $subject_cfg->findUpdateBySid();
        if($cfg && $cfg['asc_open']){
            if(strtotime($cfg['asc_open_time'])>time()){
                $this->outputError('活动即将开始，请稍等');
            }
            if(strtotime($cfg['asc_end_time'])<time()){
                $this->outputError('活动已结束，请等待下一场');
            }

            $type = $this->request->getStrParam('type','red'); //red 红包,award 奖品,points 积分
            $answerNum = 0; //今日答题次数
            $subjectNum = 0; //题目数量
            $answerNumAll = 0; //每日答题总数
            switch ($type){
                case 'red':
                    $answerNum = $this->_answer_question_num();
                    $subjectNum = $cfg['asc_subject_num'];
                    $answerNumAll = $cfg['asc_answer_num'];
                    break;
                case 'award':
                    $answerNum = $this->_answer_award_question_num();
                    $subjectNum = $cfg['asc_award_sub_num'];
                    $answerNumAll = $cfg['asc_award_answer_num'];
                    break;
                case 'points':
                    $answerNum = $this->_answer_points_question_num('normal');
                    $plusAnswerNum = $this->_points_chance_num();
                    $subjectNum = $cfg['asc_points_sub_num'];
                    $answerNumAll = $cfg['asc_points_answer_num']+$plusAnswerNum;
                    break;
            }
//            if($this->member['m_id'] == 1105848){
//                $answerNum = 0; //今日答题次数
//                $subjectNum = 1; //题目数量
//                $answerNumAll = 10; //每日答题总数
//            }
            if($answerNumAll>$answerNum){
                $where = array();
                $sids = array($this->sid);
                if($cfg['asc_open_public_question']){
                    $sids[] = 0;
                }
                $where[] = array('name'=>'as_s_id','oper'=>'in','value'=> $sids);
                $where[] = array('name'=>'as_degree','oper'=>'<=','value'=> 3);
                $where[] = array('name'=>'as_deleted','oper'=>'=','value'=> 0);
                $subject_storage = new App_Model_Applet_MysqlAppletSubjectStorage($this->sid);
                $list = $subject_storage->fetchRandomSubject($where,$subjectNum);
                // 今日已经答题的次数
//                $answerNum = $this->_answer_question_num();
                $info['data']['reviveCard'] = $this->member['m_revive_card'];
                $info['data']['allowCard']  = $cfg['asc_allow_card'];
                $info['data']['remainder']  = $answerNumAll-$answerNum;
                $info['data']['type']       = $type;
                if($list){
                    foreach ($list as $val){
                        $info['data']['list'][] = array(
                            'id'           => $val['as_id'],
                            'question'     => $val['as_question'],
                            'questionCover' => $val['as_question_cover'] && isset($val['as_question_cover']) ? $this->dealImagePath($val['as_question_cover']) : '',
                            'answers'      => $this->_subject_answer($val),
                            'answer'       => intval($val['as_answer']),
                            'chooseAnswer' => '',
                        );
                    }
                    $this->outputSuccess($info);
                }else{
                    $this->outputError('暂未添加题目');
                }
            }else{
                $this->outputError('今日的答题次数已用完');
            }
        }else{
            $this->outputError('活动暂无开启');
        }
    }

    
    private function _subject_answer($val){
        $answer = array();
        if($val){
            for ($i=1;$i<5;$i++){
                $answer[] = array(
                    'id'      => $i,
                    'name'    => $val['as_item'.$i],
                    'isRight' => $i==$val['as_answer'] ? 1 : 0
                );
            }
        }
        return $answer;
    }

    
    public function getOrUseSubjectCardAction(){
        $type = $this->request->getStrParam('type','use'); // type = fetch 获取复活卡，use 使用复活卡
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $card_record = new App_Model_Applet_MysqlAppletSubjectCardRecordStorage($this->sid);
        $subject_cfg = new App_Model_Applet_MysqlAppletSubjectCfgStorage($this->sid);
        $cfg = $subject_cfg->findUpdateBySid();
        $data = array(
            'acr_s_id' => $this->sid,
            'acr_m_id' => $this->uid,
            'acr_create_time' => time(),
        );
        $msg = '';
        $num = $this->member['m_revive_card'];
        if(in_array($type,array('fetch','use'))){
            if($type=='use'){  //使用复活卡
                if($this->member['m_revive_card']>0){
                    // 获取今天已使用复活卡的数量
                    //$useNum = $this->_get_use_card_count(2);
                    $ret = $member_storage->incrementMemberCard($this->uid, -1);
                    $data['acr_type'] = 2; // 支出
                    $msg = '使用复活卡成功';
                    $num -=1;
                }else{
                    $this->outputError('复活卡已使用完');
                }
            }elseif($type=='fetch'){
                if($cfg['asc_open_share_card']){
                    $total = $card_record->getUseCardCountByMid($this->uid,1); // 每天获取的复活张数
                    if(($total<$cfg['asc_share_num'] && $cfg['asc_share_num']>0) || $cfg['asc_share_num']==0){
                        $ret = $member_storage->incrementMemberCard($this->uid, 1);
                        $data['acr_type'] = 1; // 收入
                        $msg = '恭喜你获得一张复活卡，下次答题即可使用';
                        $num +=1;
                    }else{
                        $this->outputError('今日领取次数已超过限制');
                    }
                }else{
                    $this->outputError('暂未开启分享获取复活卡');
                }
            }
            $result = $card_record->insertValue($data);
            if($result){
                $info['data'] = array(
                    'result' => true,
                    'msg'    => $msg,
                    'num'    => $num
                );
                $this->outputSuccess($info);
            }else{
                $this->outputError('操作失败');
            }
        }else{
            $this->outputError('操作错误，请稍后重试');
        }
    }

    
    public function answerEndByTypeAction(){
        $list = $this->request->getStrParam('list');
        $card = $this->request->getStrParam('cardNum');
        $type = $this->request->getStrParam('type','red'); //red 红包,award 奖品,points 积分
        $list = json_decode($list,true);
        $rightNum = $card;
        //获取店铺配置
        $subject_cfg = new App_Model_Applet_MysqlAppletSubjectCfgStorage($this->sid);
        $cfg = $subject_cfg->findUpdateBySid();

        //dn 2019-09-27
        //前端改为只传问题id和选择的答案 避免在ios因过长报错
        //目前没找到传完整的问题在哪里有用了 但还是先把问题再次查出 与之前保持数据一致
        if($list && !isset($list[0]['answers'])){
            $curr_list = $list;
            $ids = [];
            $chooseAnswer = [];
            foreach ($list as $row){
                $ids[] = $row['id'];
                $chooseAnswer[$row['id']] = $row['chooseAnswer'];
            }
            if(!empty($ids) && is_array($ids)){
                $where = [];
                $count = count($ids);
                $where[] = array('name'=>'as_id','oper'=>'in','value'=> $ids);
                $subject_storage = new App_Model_Applet_MysqlAppletSubjectStorage($this->sid);
                $list = $subject_storage->getList($where,0,$count);
                if($list){
                    $curr_list = [];
                    foreach ($list as $val){
                        $curr_list[] = [
                            'id'           => $val['as_id'],
                            'question'     => $val['as_question'],
                            'questionCover' => $val['as_question_cover'] && isset($val['as_question_cover']) ? $this->dealImagePath($val['as_question_cover']) : '',
                            'answers'      => $this->_subject_answer($val),
                            'answer'       => intval($val['as_answer']),
                            'chooseAnswer' => $chooseAnswer[$val['as_id']],
                        ];
                    }
                }

            }
            $list = $curr_list;
        }

        //根据类型选择处理方法
        switch ($type){
            case 'red':
                $this->_deal_red_end($cfg,$rightNum,$card,$list);
                break;
            case 'award':
                $this->_deal_award_end($cfg,$rightNum,$card,$list);
                break;
            case 'points':
                $this->_deal_points_end($cfg,$rightNum,$card,$list);
                break;
            }

    }

    
    private function _deal_red_end($cfg,$rightNum,$card,$list){
        $answerNum = $this->_answer_question_num();  //今日红包赛已答题总次数
        if(!empty($list) && $cfg && ($cfg['asc_answer_num']>$answerNum)){
            foreach($list as $val){
                if($val['chooseAnswer'] && ($val['chooseAnswer'] == $val['answer'])){
                    $rightNum += 1;
                }
            }

            $redInfo = $this->_receive_red_packet($cfg,$rightNum);
            //判断是否增加胜场
            $this->_set_win_num($cfg['asc_subject_num'],$rightNum);
            $data = array(
                'asr_s_id'          => $this->sid,
                'asr_m_id'          => $this->uid,
                'asr_right_num'     => $rightNum,
                'asr_total_num'     => $cfg['asc_subject_num'],
                'asr_use_card'      => $card,
                'asr_redpacket'     => $redInfo['redpacket'],
                'asr_answer_record' => json_encode($list),
                'asr_create_time'   => time()
            );
            $record_storage = new App_Model_Applet_MysqlAppletSubjectRecordStorage($this->sid);
            $ret = $record_storage->insertValue($data);

            if($ret){
                $info['data'] = array(
                    'result'   => true,
                    'rightNum' => $rightNum,
                    'totalNum' => $cfg['asc_subject_num'],
                    'type'     => 'red',
                    'redpack'  => $redInfo['redpacket'],
                    'status'   => $redInfo['redpacket'] > 0 ? 1 : ($redInfo['sendOut'] ? 1 : 0),
                    'msg'      => $redInfo['redpacket'] > 0 ? '恭喜你获得'.$redInfo['redpacket'].'元红包' : ($redInfo['sendOut'] ? '晚了一步，红包已经被抢光了' : '挑战失败,请再接再厉挑战下一场'),
                );
                $this->outputSuccess($info);
            }else{
                $this->outputError('系统错误，请稍后重试');
            }
        }else{
            $this->outputError('挑战失败，请稍后重试');
        }
    }

    
    private function _deal_award_end($cfg,$rightNum,$card,$list){
        $answerNum = $this->_answer_award_question_num();  //今日奖品赛已答题总次数
        if(!empty($list) && $cfg && ($cfg['asc_award_answer_num']>$answerNum)){
            foreach($list as $val){
                if($val['chooseAnswer'] && ($val['chooseAnswer'] == $val['answer'])){
                    $rightNum += 1;
                }
            }
            //$awardInfo['awardName']存在表示通关 , $awardInfo['awardId']存在表示获得奖品
            $awardInfo = $this->_receive_award($cfg,$rightNum);
             //判断是否增加胜场
            $this->_set_win_num($cfg['asc_award_sub_num'],$rightNum);
            $data = array(
                'asar_s_id'          => $this->sid,
                'asar_m_id'          => $this->uid,
                'asar_right_num'     => $rightNum,
                'asar_total_num'     => $cfg['asc_award_sub_num'],
                'asar_use_card'      => $card,
                'asar_award_id'      => $awardInfo['awardId'] ? $awardInfo['awardId'] : '',
                'asar_name'          => $awardInfo['awardId'] ? $awardInfo['awardName'] : '',
                'asar_cover'         => $awardInfo['awardId'] ? $awardInfo['awardCover'] : '',
                'asar_code'          => $awardInfo['awardId'] ? $awardInfo['code'] : '',
                'asar_answer_record' => json_encode($list),
                'asar_create_time'   => time()
            );
            $record_storage = new App_Model_Answer_MysqlSubjectAwardRecordStorage($this->sid);
            $ret = $record_storage->insertValue($data);
            if($ret){
                $info['data'] = array(
                    'result'   => true,
                    'rightNum' => $rightNum,
                    'totalNum' => $cfg['asc_award_sub_num'],
                    'type'     => 'award',
                    'status'   => $awardInfo['awardName'] ? 1 : 0,
//                    'name'     => $awardInfo['awardName'] ? $awardInfo['awardName'] : '',
                    'msg'      => $awardInfo['awardName'] ? ($awardInfo['awardId'] ? '恭喜你获得奖品'.$awardInfo['awardName'].'一份' : '晚了一步，奖品已经被抢光了') : '挑战失败,请再接再厉挑战下一场',
                );
                $this->outputSuccess($info);
            }else{
                $this->outputError('系统错误，请稍后重试');
            }
        }else{
            $this->outputError('挑战失败，请稍后重试');
        }
    }

    
    private function _deal_points_end($cfg,$rightNum,$card,$list){
        $answerNum = $this->_answer_points_question_num('normal');  //今日积分赛免费机会已答题总次数
        $plusPointsNum = $this->_points_chance_num(); //额外机会
        if(!empty($list) && $cfg && (($cfg['asc_points_answer_num'] + $plusPointsNum) > $answerNum)){

            foreach($list as $val){
                if($val['chooseAnswer'] && ($val['chooseAnswer'] == $val['answer'])){
                    $rightNum += 1;
                }
            }
            $points = $this->_receive_points($cfg,$rightNum);
            //判断是否增加胜场
            $this->_set_win_num($cfg['asc_points_sub_num'],$rightNum);
            //判断是否使用了额外机会
            $useChance = 0;
            if($cfg['asc_points_answer_num'] <= $answerNum){
                $useChance = 1;
                $ascl_model = new App_Model_Answer_MysqlSubjectChanceStorage($this->sid);
                $ascl_model->changeStatus($this->member['m_id']);
            }
            $data = array(
                'aspr_s_id'          => $this->sid,
                'aspr_m_id'          => $this->uid,
                'aspr_right_num'     => $rightNum,
                'aspr_total_num'     => $cfg['asc_points_sub_num'],
                'aspr_use_card'      => $card,
                'aspr_points'        => $points,
                'aspr_use_chance'    => $useChance,
                'aspr_answer_record' => json_encode($list),
                'aspr_create_time'   => time()
            );
            $record_storage = new App_Model_Answer_MysqlSubjectPointsRecordStorage($this->sid);
            $ret = $record_storage->insertValue($data);
            if($ret){

                $info['data'] = array(
                    'result'   => true,
                    'rightNum' => $rightNum,
                    'totalNum' => $cfg['asc_award_sub_num'],
                    'type'     => 'points',
                    'status'   => $points > 0 ? 1 : 0,
                    'points'   => $this->member['m_points'] + $points, //当前积分
                    'msg'      => $points ? '恭喜你获得'.$points.'积分' : '挑战失败,请再接再厉挑战下一场',
                );
                $this->outputSuccess($info);
            }else{
                $this->outputError('系统错误，请稍后重试');
            }
        }else{
            $this->outputError('挑战失败，请稍后重试..');
        }
    }
    
    private function _receive_red_packet($cfg,$num){
        $info = [];
        if($num) {
            // 判断是否允许获取红包
            if ($cfg && $cfg['asc_answer_right'] <= $num) {
                //判断红包是否还有剩余
                $have = $this->_check_total_by_type($cfg, 'red');
                if($have) {
                    $info['sendOut'] = 0;
                    //获取红包金额
                    if ($cfg['asc_redpacket_type'] == 1) {   // 红包金额固定
                        $info['redpacket'] = $cfg['asc_redpacket_min'];
                    }
                    else {
                        $info['redpacket'] = rand(($cfg['asc_redpacket_min'] * 100), ($cfg['asc_redpacket_max'] * 100)) / 100;
                    }
                }else{
                    $info['redpacket'] = 0;
                    $info['sendOut'] = 1;
                }
            }
        }
        if($info['redpacket'] > 0){
            //增加会员同城账户的余额
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $mset = array(
                'm_deduct_ktx' => $this->member['m_deduct_ktx'] + $info['redpacket']
            );
            $member_model->updateById($mset, $this->uid);
        }

        return $info;
    }

    
    private function _receive_award($cfg,$num){
        $awardInfo = []; //奖品兑换信息
        if($num){
            // 判断是否允许获得奖品
            $award_model = new App_Model_Answer_MysqlSubjectAwardStorage($this->sid);
            $row = $award_model->getRowById($cfg['asc_award_id']);
            if ($cfg && $cfg['asc_award_sub_right'] <= $num && $row) {

                $awardInfo['awardName'] = $row['asa_name'];
                $awardInfo['awardCover'] = $row['asa_cover'];
                //判断奖品是否还有剩余
                $have = $this->_check_total_by_type($cfg,'award');
                if($have) {
                    $codeCfg = plum_parse_config('reward_code_cfg','app');
                    $awardInfo['awardId'] = $cfg['asc_award_id'];
                    $awardInfo['code'] = $codeCfg['answer']['flag'].plum_random_code($codeCfg['answer']['length']);
                    //增加奖品获奖人数
                    $award_model->changeWinnerNum($awardInfo['awardId'], 'add');
                }
            }


        }
        return $awardInfo;
    }

    
    private function _receive_points($cfg,$num){
        $points = 0;
        if($num){
            // 判断是否允许获取积分
            if($cfg && $cfg['asc_points_sub_right']<=$num){
                //获取奖励积分
                if ($cfg['asc_points_type'] == 1) {   // 红包金额固定
                    $points = $cfg['asc_points'];
                }else {
                    $points = rand($cfg['asc_points'], $cfg['asc_points_max']) ;
                }

            }
        }
        if($points>0){
            //增加会员同城账户的余额
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $mset = array(
                'm_points' => $this->member['m_points'] + $points
            );
            $member_model->updateById($mset, $this->uid);
        }
        return $points;
    }

    
    public function redPacketListAction(){
        $page = $this->request->getIntParam('page');
        $where = array();
        $sort  = array('asr_redpacket'=>'DESC');
        $index = $page*$this->count;
        $record_storage = new App_Model_Applet_MysqlAppletSubjectRecordStorage($this->sid);
        $list = $record_storage->fetchRedPacketList($where,$index,$this->count,$sort);
        if($list){
            $info = array();
            foreach ($list as $val){
                $info['data'][] = array(
                    'id'        => $val['asr_id'],
                    'mid'       => $val['m_id'],
                    'rightNum'  => $val['asr_right_num'],
                    'redpacket' => $val['asr_redpacket'].$val['acc_name'],
                    'nickname'  => $val['m_nickname'],
                    'avatar'    => $val['m_avatar'] ? $val['m_avatar'] : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
                    'time'      => date('m-d H:i',$val['asr_create_time'])
                );
            }
            $this->outputSuccess($info);
        }else{
            $this->outputError('数据加载完毕');
        }
    }

    
    public function subjectCfgAction(){
        //获取店铺配置
        $subject_cfg = new App_Model_Applet_MysqlAppletSubjectCfgStorage($this->sid);
        $cfg = $subject_cfg->findUpdateBySid();
        if($cfg){
            // 今日已经答题的次数
            $answerNum = $this->_answer_question_num(); //红包
            $answerAwardNum  = $this->_answer_award_question_num(); //奖品
            $answerPointsNum = $this->_answer_points_question_num('normal'); //免费次数内积分答题次数
            $plusPointsNum   = $this->_points_chance_num(); //积分赛额外答题次数
            $info['data'] = array(
                'slide'       => $this->_get_slide($cfg),
                'phone'       => $cfg['asc_award_phone'],
                'redTotalNum' => $cfg['asc_redpacket_num'],
                'receiveNum'  => $this->_answer_red_num(),
                'allowCard'   => $cfg['asc_allow_card'],
                'totalCard'   => $this->member['m_revive_card'], //复活卡
                'totalProfit' => $this->member['m_deduct_ktx'], //可提现红包
                'totalPoints' => $this->member['m_points'],     //积分
                'totalAwards' => $this->_get_awards_count(),
                'pointsCost'  => $cfg['asc_points_chance_cost'], //兑换答题机会所需积分
//                'haveRed'     => $this->_check_total_by_type($cfg,'red'), //是否有剩余红包
//                'haveAward'   => $this->_check_total_by_type($cfg,'award'), //是否有剩余奖品
                'remainder'   => $cfg['asc_answer_num']-$answerNum,
                'remainderAward'    => $cfg['asc_award_answer_num']-$answerAwardNum,
                'remainderPoints'   => $cfg['asc_points_answer_num']+$plusPointsNum-$answerPointsNum,
                'rule'        => plum_parse_img_path($cfg['asc_rule']),
                'tips'        => '请在答题开始之前，进入答题页面等待！答题如果开始后，则不允许再答题',
                'open'        => $cfg['asc_open'],
                'redOpen'     => $this->_check_open_by_type($cfg,'red'),
                'pointsOpen'  => $this->_check_open_by_type($cfg,'points'),
                'awardOpen'   => $this->_check_open_by_type($cfg,'award'),
                'openTime'    => strtotime($cfg['asc_open_time']),
                'endTime'     => strtotime($cfg['asc_end_time']),
                'shareCover'  => $cfg['asc_share_cover'] ? $this->dealImagePath($cfg['asc_share_cover']) : '',
                'shareTitle'  => $cfg['asc_share_title'] ? $cfg['asc_share_title'] : '',
                'answerTime'  => $cfg['asc_answer_time']
            );
            $this->outputSuccess($info);
        }else{
            $this->outputError('暂未开启该功能');
        }
    }

    private function _get_slide($cfg){
        $arr = [];
        $imgs = json_decode($cfg['asc_slide'],1);
        if(!empty($imgs)){
            foreach ($imgs as $img){
                $arr[] = $this->dealImagePath($img);
            }
        }
        return $arr;
    }

    private function _get_awards_count(){
        $asar_model = new App_Model_Answer_MysqlSubjectAwardRecordStorage($this->sid);
        return $asar_model->getMemberAwardCount($this->member['m_id']);
    }

    
    private function _answer_question_num(){
        // 判断当日已领取的红包数量
        $record_storage = new App_Model_Applet_MysqlAppletSubjectRecordStorage($this->sid);
        return $record_storage->fetchAnswerQuestionNum($this->uid);
    }

    
    private function _answer_award_question_num(){
        // 判断当日已领取的红包数量
        $record_storage = new App_Model_Answer_MysqlSubjectAwardRecordStorage($this->sid);
        return $record_storage->fetchAnswerQuestionNum($this->uid);
    }

    
    private function _answer_points_question_num($type = 'all'){
        // 判断当日已领取的红包数量
        $record_storage = new App_Model_Answer_MysqlSubjectPointsRecordStorage($this->sid);
        return $record_storage->fetchAnswerQuestionNum($this->uid,$type);
    }

    
    private function _answer_red_num(){
        // 判断当日已领取的红包数量
        $record_storage = new App_Model_Applet_MysqlAppletSubjectRecordStorage($this->sid);
        return $record_storage->fetchAnswerRedNum();
    }

    // 每日获取或使用复活卡的张数
    private function _get_use_card_count($type=1){
        $card_record = new App_Model_Applet_MysqlAppletSubjectCardRecordStorage($this->sid);
        return $card_record->getUseCardCountByMid($this->uid,$type); // 每天获取的复活张数
    }


    
    private function _custom_receive_red_packet($cfg,$num){
        $redpack = 0;
        if($num){
            // 判断是否允许获取红包
            if($cfg && $cfg['asc_answer_right']<=$num){
                //获取红包金额
                if($cfg['asc_redpacket_type']==1){   // 红包金额固定
                    $redpack = $cfg['asc_redpacket_min'];
                }else{
                    $redpack = rand(($cfg['asc_redpacket_min']*100),($cfg['asc_redpacket_max']*100))/100;
                }
            }
        }
        if($redpack>0){
            //增加会员同城账户信息
            $account_model = new App_Model_City_MysqlCityAccountStorage($this->sid);
            $account = $account_model->findUpdateByNumber($this->uid,$cfg['asc_currency']);
            if($account){   //存在该账户
                $ret = $account_model->memberFetchGold($this->uid,$redpack,$cfg['asc_currency']);
            }else{
                $currency_model = new App_Model_Answer_MysqlCurrencyStorage($this->sid);
                $currency       = $currency_model->getRowById($cfg['asc_currency']);
                $data = array(
                    'aca_s_id' => $this->sid,
                    'aca_m_id' => $this->uid,
                    'aca_ktx'  => $redpack,
                    'aca_ytx'  => 0,
                    'aca_dsh'  => 0,
                    'aca_acc_id'   => $cfg['asc_currency'],
                    'aca_acc_name' => $currency['acc_name'],
                    'aca_update_time' => time(),
                );
                $ret = $account_model->insertValue($data);
            }
        }
        return $redpack;
    }


    
    public function ShareConfirmFetchCardAction(){
        $mid = $this->request->getIntParam('mid');    //分享者的会员id
        $curtime = $this->request->getStrParam('curtime');    //分享者的会员id
        if($mid && $this->uid!=$mid){   // 自己分享的自己打开无效
            $subject_cfg = new App_Model_Applet_MysqlAppletSubjectCfgStorage($this->sid);
            $cfg = $subject_cfg->findUpdateBySid();
            if($cfg['asc_open_share_card']){
                $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
                $card_record = new App_Model_Applet_MysqlAppletSubjectCardRecordStorage($this->sid);
                $total = $card_record->getUseCardCountByMid($mid,1); // 每天获取的复活张数
                // 获取该次分享已经被领取
                $where = array();
                //$where[] = array('name'=>'acr_m_id','oper'=>'=','value'=>$mid);
                $where[] = array('name'=>'acr_form_mid','oper'=>'=','value'=>$this->uid);
                // $where[] = array('name'=>'acr_share_time','oper'=>'=','value'=>$curtime);
                $row = $card_record->getRow($where);
                if(!$row && $total<$cfg['asc_share_num'] && $cfg['asc_share_num']>0){
                    $ret = $member_storage->incrementMemberCard($mid, 1);
                    $data = array(
                        'acr_s_id'        => $this->sid,
                        'acr_m_id'        => $mid,
                        'acr_create_time' => time(),
                        'acr_type'        => 1,
                        'acr_form_mid'    => $this->uid,
                        'acr_share_time'  => $curtime,
                    );
                    $card_record->insertValue($data);
                    if($ret){
                        $info['data'] = array(
                            'result' => true,
                            'msg'    => '复活卡发放成功',
                        );
                        $this->outputSuccess($info);
                    }else{
                        $this->outputError('复活卡发放失败');
                    }
                }else{
                    $this->outputError('今日领取次数已超过限制');
                }
            }else{
                $this->outputError('暂未开启分享获取复活卡');
            }
        }
    }

    
    public function myAwardListAction(){
        $page = $this->request->getIntParam('page',0);
        $index = $page * $this->count;
        $data  = [];
        $sort  = array('asar_create_time'=>'DESC');
        $field = array('asar_id','asar_code','asar_name','asar_status','asar_award_id','asar_create_time');
        $record_model = new App_Model_Answer_MysqlSubjectAwardRecordStorage($this->sid);
        $list = $record_model->getMemberAwardRecord($this->member['m_id'],$index,$this->count,$sort,$field);

        if(!empty($list)){
            foreach ($list as $val){
                $data[] = array(
                    'id'        => $val['asar_id'],
                    'content'   => '获得'.$val['asar_name'].'一个',
                    'code'      => $val['asar_code'],
                    'time'      => date('Y-m-d H:i',$val['asar_create_time']),
                    'status'    => $val['asar_status']
                );
            }
            $info['data'] = $data;
            $this->outputSuccess($info);
        }else{
            $this->outputError('数据加载完毕');
        }


    }

    
    public function getAnswerChanceAction(){
        //获取店铺配置
        $subject_cfg = new App_Model_Applet_MysqlAppletSubjectCfgStorage($this->sid);
        $cfg = $subject_cfg->findUpdateBySid();
        if($cfg['asc_points_chance_cost'] <= $this->member['m_points']){
            $insert = array(
                'ascl_s_id'     => $this->sid,
                'ascl_m_id'     => $this->member['m_id'],
                'ascl_create_time'  => time()
            );

            $ascl_model = new App_Model_Answer_MysqlSubjectChanceStorage($this->sid);
            $res = $ascl_model->insertValue($insert);
            if($res){
                //减少会员积分
                $m_model = new App_Model_Member_MysqlMemberCoreStorage();
                $m_model->incrementMemberPoint($this->member['m_id'],-$cfg['asc_points_chance_cost']);
                $info['data'] = array(
                    'result' => true,
                    'msg'    => '兑换成功',
                    'points' => $this->member['m_points']-$cfg['asc_points_chance_cost']
                );
                $this->outputSuccess($info);
            }
        }else{
            $this->outputError('您的积分不足');
        }
    }

    
    private function _points_chance_num(){
        $ascl_model = new App_Model_Answer_MysqlSubjectChanceStorage($this->sid);
        return $ascl_model->fetchChanceNum($this->member['m_id']);
    }

    
    public function winRankListAction(){
        $win_model = new App_Model_Answer_MysqlSubjectWinRankStorage($this->sid);
        //获取当前用户排名及胜场
        $memRank = $win_model->getMemberRank($this->member['m_id']);
        $data = array(
            'nickname' => $this->member['m_nickname'],
            'avatar'   => $this->member['m_avatar'] ? $this->dealImagePath($this->member['m_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
            'rank'     => $memRank['rank'] ? $memRank['rank'] : '未知',
            'win'      => ($memRank['win'] ? $memRank['win'] : 0).'场'
        );
        //获得排行榜列表
        $where = [];
        $list  = [];
        $rankList = $win_model->getRankList($where,0,10);

        foreach ($rankList as $val){
            $list[] = array(
                'avatar'    => $val['m_avatar'] ? $val['m_avatar'] : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
                'nickname'  => $val['m_nickname'],
                'win'       => $val['aswr_win'].'场'
            );
        }

        $data['list'] = $list;
        $info['data'] = $data;
        $this->outputSuccess($info);
    }

    
    private function _set_win_num($subNum,$rightNum){
        $win_model = new App_Model_Answer_MysqlSubjectWinRankStorage($this->sid);
        $where[] = array('name' => 'aswr_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'aswr_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $row = $win_model->getRow($where);
        if($row){
            //若全对,胜场数 +1
            if($rightNum == $subNum){
                $win_model->changeWinNum($row['aswr_id'],'add');
            }
        }else{
            //若全对,胜场数 +1
            if($rightNum == $subNum){
                $win = 1;
            }else{
                $win = 0;
            }
            $insert = array(
                'aswr_s_id'         => $this->sid,
                'aswr_m_id'         => $this->member['m_id'],
                'aswr_win'          => $win,
                'aswr_create_time'  => time()
            );
            $res = $win_model->insertValue($insert);

        }
    }

    
//    private function _check_total_by_type($cfg,$type){

        $totalCfg = 0; //设置总量
        $total    = 0; //当前总量

        switch ($type){
            case 'red' :
                $record_model = new App_Model_Applet_MysqlAppletSubjectRecordStorage($this->sid);
                $totalCfg = $cfg['asc_redpacket_num'];
                $total    = $record_model->fetchAnswerRedTotal();
                break;
            case 'award' :
                $record_model = new App_Model_Answer_MysqlSubjectAwardRecordStorage($this->sid);
                $totalCfg = $cfg['asc_award_num'];
                $total    = $record_model->fetchAnswerAwardTotal();
                break;
//            case 'points' :
//                $record_model = new App_Model_Answer_MysqlSubjectPointsRecordStorage($this->sid);
//                $totalCfg = $cfg['asc_points_num'];
//                $total    = $record_model->fetchAnswerPointsTotal();
//                break;
        }

        return $totalCfg > $total ? 1 : 0 ;
    }

    
    private function _check_open_by_type($cfg,$type){

        $status = 0; //开启状态
        $openTime = 0 ;
        $endTime  = 0 ;

        switch ($type){
            case 'red' :
                $status = $cfg['asc_redpacket_open'];
                $openTime = $cfg['asc_open_time'];
                $endTime = $cfg['asc_end_time'];
                break;
            case 'award' :
                $status = $cfg['asc_award_open'];
                $openTime = $cfg['asc_award_open_time'];
                $endTime = $cfg['asc_award_end_time'];
                break;
            case 'points' :
                $status = $cfg['asc_points_open'];
                $openTime = $cfg['asc_points_open_time'];
                $endTime = $cfg['asc_points_end_time'];
                break;
        }

        //在开启并设置了开始结束时间的条件下 判断开启状态
        if($status && $openTime && $endTime){
            if(strtotime($openTime) > time() || strtotime($endTime) < time()){
                $status = 0;
            }
        }
        return intval($status);

    }

}