<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/8/17
 * Time: 上午：11：30
 * 微同城需要授权的相关接口
 */

class App_Controller_Applet_MeetingAuthController extends App_Controller_Applet_InitController {
    private $restNum;
    public function __construct() {
        parent::__construct();
        $this->_check_add_once();
    }
    /**
     * 判断是不是第一次参与活动,第一次根据设置增加抽奖机会
     */
    private function _check_add_once(){
        $list_model = new App_Model_Meeting_MysqlMeetingLotteryListStorage($this->sid);
        $where = array();
        $where[] = array('name' => 'amll_status', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => 'amll_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'amll_deleted', 'oper' => '=', 'value' => 0);
        $row = $list_model->getRow($where);
        if($row){
           $amln_model  =  new  App_Model_Meeting_MysqlMeetingLotteryNumberStorage($this->sid);
           $amlnData    =  $amln_model->checkMemNum($this->uid,$row['amll_id']);
            if(!$amlnData){
                $insertData = array(
                    'amln_s_id'  => $this->sid,
                    'amln_mid'   => $this->uid,
                    'amln_l_id'  => $row['amll_id'],
                    'amln_num'   => $row['amll_frequency'],
                    'amln_create_time' => time(),
                    'amln_update_time' => time()
                );
                $amln_model->insertValue($insertData);
                $this->restNum = $row['amll_frequency'];
            }else{
                $this->restNum = $amlnData['amln_num']?$amlnData['amln_num']:0;
            }
        }
    }



    /**
     * 抽奖页面
     */
    public function lotteryAction(){
        $data = array();
        $list_model = new App_Model_Meeting_MysqlMeetingLotteryListStorage($this->sid);
        $where = array();
        $where[] = array('name' => 'amll_status', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => 'amll_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'amll_deleted', 'oper' => '=', 'value' => 0);
        $row = $list_model->getRow($where);
        if($row){
            $where = array();
            $record_model = new App_Model_Meeting_MysqlMeetingRecordStorage($this->sid);
            $where[] = array('name' => 'amr_s_id' , 'oper' => '=', 'value' => $this->sid);
            $where[] = array('name' => 'amr_l_id' , 'oper' => '=', 'value' => $row['amll_id']);
            $where[] = array('name' => 'amr_m_id' , 'oper' => '=', 'value' => $this->uid);
            $record = $record_model->getRow($where);
            $myRecord = '';
            if($record){
                $myRecord = array(
                    'img' => $this->dealImagePath($record['amr_img']),
                    'name' => $record['amr_name']
                );
            }
            $info['data']['actId']     = $row['amll_id'];
            $info['data']['joinNum']   = $record_model->getJoinNum($row['amll_id']);
            $info['data']['myLottery'] = $myRecord;
            $info['data']['mobile']    = $this->member['m_mobile'];
            $info['data']['rule']      = plum_parse_img_path($row['amll_rule']);
            $info['data']['goodsList'] = $this->_get_lottery_goods($row);
            $info['data']['restNum']    = $this->restNum;
            $info['data']['shareGive']  = $row['amll_share_give'];
            $info['data']['recordList'] = $this->get_lottery_record($row['amll_id'],'',1);
            //增加兑换所需积分
            $info['data']['pointsTotal'] = $this->member['m_points'];   // 会员当前所剩余积分
            $info['data']['pointsNum']  = $row['amll_change_points'];
            $info['data']['pointsOpen'] = intval($row['amll_points_open']);  // 积分兑换是否开启
            // 抽奖开始时间控制
            $info['data']['startTime']  =$row['amll_start_time']; //抽奖开始时间：为空的话不限制
            $info['data']['status']     =$row['amll_customer_status']; //是否手动控制活动是否开启
            $this->outputSuccess($info);
        }else{
            $this->outputError('活动暂未开始');
        }
    }

    /**
     * @param $row
     * @return array 获取活动的获奖纪录
     */
    private function get_lottery_record($lid,$mid='',$type = 0){
        $record_model = new App_Model_Meeting_MysqlMeetingRecordStorage($this->sid);
        $where[] = array('name' => 'amr_s_id' , 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'amr_l_id' , 'oper' => '=', 'value' => $lid);
        $str     = '已获得';
        if($mid){
            $where[] = array('name' => 'amr_m_id' , 'oper' => '=', 'value' => $mid);
            $str     = '';
        }
        if($type){
            $where[] = array('name' => 'amr_type' , 'oper' => '=', 'value' => $type);
        }
        $list    = $record_model->getList($where,0,100,array('amr_create_time'=>'DESC'));
        $data    = array();
        $codeCfg = plum_parse_config('reward_code_cfg','app');
        if($list){
            foreach ($list as $key=>$val){
                $data[] = array(
                    'userName'  => $val['amr_m_name']?$val['amr_m_name']:'佚名',
                    'goodName'  => $val['amr_name']?trim($str.$val['amr_name']):'',
                    'time'      => $val['amr_create_time']?date('y-m-d H:i',$val['amr_create_time']):'',
                    'code'      => $val['amr_code']?$val['amr_code']:$codeCfg['lottery']['flag'].plum_random_code($codeCfg['lottery']['length']),
                    'status'    => $val['amr_status'],
                    'dealTime'  => $val['amr_deal_time'] && $val['amr_deal_time']>0 ? date('y-m-d H:i',$val['amr_deal_time']):'',
                    'qrcode'    => $val['amr_qrcode'] && isset($val['amr_qrcode']) ? $this->dealImagePath($val['amr_qrcode']) : $this->dealImagePath($this->_fetch_qrcode($val,$codeCfg))
                );
            }
        }
        return $data;
    }

    /*
     * 生成兑奖二维码
     */
    private function _fetch_qrcode($data,$codeCfg){
        // 生成奖品核销二维码
        $filename = $data['amr_code'].plum_random_code($codeCfg['lottery']['length']).'.png';
        Libs_Qrcode_QRCode::png($data['amr_code'], PLUM_APP_BUILD.'/spread/' . $filename, 'Q', 6, 1);
        $set['amr_qrcode'] = PLUM_PATH_PUBLIC.'/build/spread/'.$filename;
        $record_model = new App_Model_Meeting_MysqlMeetingRecordStorage($this->sid);
        $record_model->updateById($set,$data['amr_id']);
        return $set['amr_qrcode'];
    }
    /**
     * 获取我的中奖纪录
     */
    public function getMyLotteryRecordAction(){
        $lid   = $this->request->getIntParam('id');
        $data  = $this->get_lottery_record($lid,$this->uid);
        if($data){
            $info['data']['recordList'] = $data;
            $this->outputSuccess($info);
        }else{
            $this->outputError('您还没有中奖纪录哦');
        }
    }





    private function _get_lottery_goods($row){
        $lottery_model = new App_Model_Meeting_MysqlMeetingLotteryStorage($this->sid);
        $goods_list = $lottery_model->getListBySid($row['amll_id']);
        $data = array();
        foreach($goods_list as $val){
            $data[] = array(
                'id'  => $val['aml_id'],
                'img' => $this->dealImagePath($val['aml_img']),
            );
        }
        if($data){
            return $data;
        }else{
            $this->outputError('活动暂未开始');
        }
    }

    /**
     * 开始抽奖
     */
    public function startLotteryAction(){
        $id = $this->request->getIntParam('id');
        /*$record_model = new App_Model_Meeting_MysqlMeetingRecordStorage($this->sid);
        $where[] = array('name' => 'amr_s_id' , 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'amr_l_id' , 'oper' => '=', 'value' => $id);
        $where[] = array('name' => 'amr_m_id' , 'oper' => '=', 'value' => $this->uid);
        $record = $record_model->getRow($where);*/

        //判断抽奖活动是否开启 
        $lottery_model = new App_Model_Meeting_MysqlMeetingLotteryListStorage($this->sid);
        $lottery=$lottery_model->getRowById($id);
        if($lottery['amll_customer_status']==0)
            $this->outputError('活动暂未开启');
        if(!empty($lottery['amll_start_time'])&&($lottery['amll_start_time']>time()))
            $this->outputError('活动暂未开始，开始时间：'.date('Y年m月d日 H:i:s',$lottery['amll_start_time']));


        $amln_model  =  new  App_Model_Meeting_MysqlMeetingLotteryNumberStorage($this->sid);
        $amlnData    =  $amln_model->checkMemNum($this->uid,$id);
        if($amlnData['amln_num']>0){
            $lottery_model = new App_Model_Meeting_MysqlMeetingLotteryStorage($this->sid);
            $num = $lottery_model->getGoodsSum($id);
            $goods_list = $lottery_model->getListBySid($id);
            if($num>0 && !empty($goods_list)){
                    $lotteryId = 0;
                    $chanceArr = $this->_get_lottery_chance($goods_list);
                    $rand = mt_rand(1, intval($num));
//                    $rand = 200;
                    for ($j = 0 ; $j< count($chanceArr) ; $j++){
                        if($rand > $chanceArr[$j]['chanceKey'] && $rand <= $chanceArr[$j + 1]['chanceKey']){
                            $lotteryId = $chanceArr[$j + 1]['id'];
                            break;
                        }
                    }
//                    $info['data']['randInfo'] = array(
//                        'chanceArr' => $chanceArr,
//                        'lotteryId' => $lotteryId,
//                        'rand'      => $rand
//                    );

                    $this->_save_record($lotteryId, $id);

                    $amlnDatas = $amln_model->checkMemNum($this->uid,$id);
                    $amln_model->checkMemNum($this->uid,$id,array('amln_num'=>($amlnDatas['amln_num']-1)));

                    $lottery = $lottery_model->getRowById($lotteryId);


//                    $ids = array();
//                    foreach($goods_list as $val){
//                        for($i = 0; $i< intval($val['aml_num']); $i++){
//                            $ids[] = $val['aml_id'];
//                        }
//                    }
//                    $rand = mt_rand(0, count($ids)-1);
//                    $lotteryId = $ids[$rand];
//                    $this->_save_record($lotteryId, $id);
//                    $amln_model->checkMemNum($this->uid,$id,array('amln_num'=>$amlnData['amln_num']-1));
//                    $lottery = $lottery_model->getRowById($lotteryId);

                //$amlnData1    =  $amln_model->checkMemNum($this->uid,$id);
                if($this->applet_cfg['ac_type'] == 30){
                    //触发完成任务
                    App_Helper_Tool::checkGameTask($this->sid, $this->member['m_id'], 7);
                }

                $info['data']['index'] = $lottery['aml_weight'];
                $info['data']['name']  = $lottery['aml_name'];
                $info['data']['img']   = $this->dealImagePath($lottery['aml_img']);
                $info['data']['msg']   = $lottery['aml_type'] == 1?'恭喜您，中奖了':'很遗憾，您没有中奖';
                $info['data']['restNum']   = $amlnDatas['amln_num']-1;//剩余抽奖次数
                $info['data']['status']    = $lottery['aml_type']==1?true:false;//代表中奖了,代表未中奖
                $this->outputSuccess($info);
            }else{
//                $info['data']['status']    = false;//代表中奖了,代表未中奖
//                $info['data']['restNum']   = $amlnData['amln_num'];//
//                $info['data']['msg']       = '活动已结束';
//                $this->outputSuccess($info);
                $this->outputError('活动已结束');
            }
        }else{
            $info['data']['status']    =  false;//代表中奖了,代表未中奖
            $info['data']['restNum']   =  $amlnData['amln_num']?$amlnData['amln_num']:0;//
            $info['data']['msg']       = '很遗憾您没有抽奖次数了哦';
            $this->outputSuccess($info);
        }
    }

    /*
     * 获得概率数组
     */
    private function _get_lottery_chance($goods_list){
        $chanceArr = [];
        $chanceArr[] = array(
            'chanceKey' => 0,
            'id'        => 0
        );
        $numKey = 0;
        foreach ($goods_list as $goods){
            //数量为0不计入中奖概率
            if($goods['aml_num'] > 0){
                $numKey += $goods['aml_num'];
                $chanceArr[] = array(
                    'chanceKey' => $numKey,
                    'id'        => $goods['aml_id']
                );
            }
        }

        return $chanceArr;
    }

    /**
     * 记录中奖
     */
    private function _save_record($id, $lid){
        $record_model = new App_Model_Meeting_MysqlMeetingRecordStorage($this->sid);
        $lottery_model = new App_Model_Meeting_MysqlMeetingLotteryStorage($this->sid);
        $lottery = $lottery_model->getRowById($id);

        $set = array(
            'aml_num' => intval($lottery['aml_num']) - 1
        );
        $lottery_model->updateById($set, $id);
        $codeCfg = plum_parse_config('reward_code_cfg','app');

        $data = array(
            'amr_s_id'   => $this->sid,
            'amr_l_id'   => $lid,
            'amr_m_id'   => $this->uid,
            'amr_name'   => $lottery['aml_name'],
            'amr_m_name' => $this->member['m_nickname'],
            'amr_img'    => $lottery['aml_img'],
            'amr_type'   => $lottery['aml_type'],
            'amr_code'   => $codeCfg['lottery']['flag'].plum_random_code($codeCfg['lottery']['length']),
            'amr_pid'    => $lottery['aml_pid'],
            'amr_create_time' => time(),
        );
        // 生成奖品核销二维码
        $filename = $data['amr_code'].plum_random_code($codeCfg['lottery']['length']).'.png';
        Libs_Qrcode_QRCode::png($data['amr_code'], PLUM_APP_BUILD.'/spread/' . $filename, 'Q', 6, 1);
        $data['amr_qrcode'] = PLUM_PATH_PUBLIC.'/build/spread/'.$filename;
        $recordId= $record_model->insertValue($data);
        //根据中奖的奖品进行相关操作，判断是什么类型
        $this->_deal_reward($lottery['aml_pid'],$recordId,$lid);


    }
    /*
     * 处理奖品相关
     * $pid 奖品编号  $recordId  中奖纪录id,$id活动id
     */
    private function _deal_reward($pid,$recordId,$id){
         //根据奖品编号判断是什么类型，并增加相应的积分或者答题次数
        $prize_model  = new App_Model_Meeting_MysqlMeetingPrizeListStorage($this->sid);
        $prize        = $prize_model->getRowById($pid);
        $type         = $prize['ampl_type'];
        if($type == 2){  //奖品类型  积分奖品
             //为永户增加相应的积分
            $memberModel = new App_Model_Member_MysqlMemberCoreStorage();
            $res=$memberModel->incrementMemberPoint($this->uid,$prize['ampl_pnum']);
            $this->_dealPointSource($prize['ampl_pnum'],'prize');
        }else if($type == 3){    //增加用户的抽奖次数
            $amln_model  =  new  App_Model_Meeting_MysqlMeetingLotteryNumberStorage($this->sid);
            $amlnData    =  $amln_model->checkMemNum($this->uid,$id);
            $amln_model->checkMemNum($this->uid,$id,array('amln_num'=>$amlnData['amln_num']+$prize['ampl_pnum']));
        }else if($type == 4){   //增加用户的答题次数

        }elseif($type == 5){
            //增加用户金币数
            $rcgrcd_storage = new App_Model_Member_MysqlRechargeStorage($this->shop['s_id']);
            $indata = array(
                'rr_tid'        => '',
                'rr_s_id'       => $this->shop['s_id'],
                'rr_m_id'       => $this->member['m_id'],
                'rr_amount'     => $prize['ampl_pnum'],
                'rr_gold_coin'  => $prize['ampl_pnum'],
                'rr_pay_type'   => 8,
                'rr_remark'     => '抽奖',
                'rr_create_time'=> time(),
            );
            $rcgrcd_storage->insertValue($indata);
            App_Helper_MemberLevel::goldCoinTrans($this->shop['s_id'], $this->member['m_id'], $prize['ampl_pnum']);
        }
        if($type !=1){
           //修改获奖纪录为已核销
            $record_model = new App_Model_Meeting_MysqlMeetingRecordStorage($this->sid);
            $set          = array('amr_status'=>1);
            $record_model->updateById($set,$recordId);

        }


    }
    /*
     * 积分兑换抽奖次数
     */
    public function exchangeLotteryNumAction(){
        //
        $lid           = $this->request->getIntParam('id');  //活动id
        $num           = $this->request->getIntParam('num',1); //要兑换的次数
        $lottery_model = new App_Model_Meeting_MysqlMeetingLotteryListStorage($this->sid);
        //查看活动是否存在
        $row           = $lottery_model->getRowByIdSid($lid,$this->sid);
        if($row && $row['amll_status']==1){    //说明活动存在且没有结束
            //为用户增加该活动可抽奖次数，并且扣除积分
            $memberModel = new App_Model_Member_MysqlMemberCoreStorage();
            $points      = $num*$row['amll_change_points'];
            if($this->member['m_points']>=$points){
                //增加抽奖次数
                $amln_model  =  new  App_Model_Meeting_MysqlMeetingLotteryNumberStorage($this->sid);
                $amlnData    =  $amln_model->checkMemNum($this->uid,$lid);
                $amln_model->checkMemNum($this->uid,$lid,array('amln_num'=>$amlnData['amln_num']+$num));
                //扣除会员积分
                $memberModel->incrementMemberPoint($this->uid,-$points);
                //增加积分明细
                $this->_dealPointSource($points,'exchange');
                $info['data'] = array('msg'=>'兑换成功!');
                $this->outputSuccess($info);

            }else{
                $this->outputError('抱歉，你的积分不足以兑换');
            }
            //$res=$memberModel->incrementMemberPoint($this->uid,$prize['ampl_pnum']);

        }else{
            $this->outputError('该活动已经结束，请选择别的进行兑换');
        }


    }
    /*
     * 增加积分来源
     */
    private function _dealPointSource($points,$source){
        $point_model = new App_Model_Point_MysqlInoutStorage();
        //pi_id`, `pi_s_id`, `pi_m_id`, `pi_type`, `pi_title`, `pi_point` , `pi_source`, `pi_extra` , `pi_create_time`
        $data = array(
            'pi_s_id'=> $this->sid,
            'pi_m_id'=> $this->uid,
            'pi_type'=> 1,
            'pi_point'=> $points,
            'pi_title'=> '抽奖奖励积分'.$points,
            'pi_source'=>App_Helper_Point::POINT_SOURCE_PRIZE,
            'pi_extra' =>'',
            'pi_create_time'=> time(),
        );
        if($source == 'prize'){
            $data['pi_source']=App_Helper_Point::POINT_SOURCE_PRIZE;
            $data['pi_title'] = '抽奖奖励积分'.$points;
        }else{     //change
            $data['pi_source']=App_Helper_Point::POINT_SOURCE_EXCHANGE_PNUM;
            $data['pi_title'] = '兑换抽奖次数减去'.$points.'积分';
            $data['pi_type'] = 2;

        }
        $point_model->insertValue($data);
    }
    /**
     * 分享后增加抽奖次数
     */
    public function addShareLotteryNumAction(){
        $lid  =  $this->request->getIntParam('id');
        if($lid){
            $list_model = new App_Model_Meeting_MysqlMeetingLotteryListStorage($this->sid);
            $where = array();
            $where[] = array('name' => 'amll_status', 'oper' => '=', 'value' => 1);
            $where[] = array('name' => 'amll_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[] = array('name' => 'amll_deleted', 'oper' => '=', 'value' => 0);
            $row = $list_model->getRow($where);
            // 判断是否允许分享赠送抽奖次数
            if($row && $row['amll_share_give']>0){
                $amln_model  =  new  App_Model_Meeting_MysqlMeetingLotteryNumberStorage($this->sid);
                $amlnData    =  $amln_model->checkMemNum($this->uid,$lid);
                if($amlnData){
                    $info['data']['num'] = $this->restNum;
                    // 获取今天的分享次数
                    $num     =  $this->_check_share_record($lid);
                    if($num < $row['amll_share_give']){
                        $data        =  array('amln_num'=>$this->restNum+1);
                        $amln_model->checkMemNum($this->uid,$lid,$data);
                        $info['data']['num'] = $this->restNum+1;
                    }
                    $this->outputSuccess($info);
                }else{
                    $this->outputError('活动已经取消了哦');
                }
            }else{
                $this->outputError('分享成功');
            }
        }else{
            $this->outputError('分享活动失败哦');
        }
    }
    /**
     * 判断是否在今天已经有分享记录
     */
    private function _check_share_record($lid){
        $amsr_model  =  new App_Model_Meeting_MysqlMeetingShareRecordStorage($this->sid);
        $amsrData    =  $amsr_model->checkMemNum($this->uid,$lid);
        if($amsrData){
            $data    =  array('amsr_update_time'=>time());
            if($amsrData['amsr_update_time']<= strtotime(date('Y-m-d'))){
                $data['amsr_today_num'] = 1;
            }else{
                $data['amsr_today_num'] = $amsrData['amsr_today_num']+1;
            }
            $amsr_model->checkMemNum($this->uid,$lid,$data);
            return $data['amsr_today_num']-1;
        }else{
            $data    =  array(
                'amsr_s_id'  => $this->sid,
                'amsr_mid'   => $this->uid,
                'amsr_l_id'  => $lid,
                'amsr_today_num' => 1 ,
                'amsr_create_time' => time(),
                'amsr_update_time' => time()
            );
            $amsr_model->insertValue($data);
            return $data['amsr_today_num']-1;
        }
    }







}
