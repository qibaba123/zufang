<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/8/23
 * Time: 下午4:52
 */

class App_Helper_Knowledge{
    private $sid;

    public function __construct($sid)
    {
        $this->sid  = $sid;
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $this->shop = $shop_model->getRowById($sid);
    }


    /*
     * 问题无回答自动退款并关闭问题
     * id 问题id
     */
    public function autoQuestionRefund($id){
        $question_model = new App_Model_Knowledge_MysqlKnowledgeQuestionStorage($this->sid);
        $row = $question_model->getRowById($id);
        // 如果第一次取不到数据就再取一次
        if(!$row){
            $row = $question_model->getRowById($id);
        }
        // 判断记录是否存在
        if(!$row){
            return FALSE;
        }
        //判断是否为待回答状态
        if($row['akq_status'] == 1 && ($row['akq_auto_refund']-60) < time()){
            $set = array(
                'akq_status' => 4 //关闭问题
            );
            //如果是会员发布问题且未被平台删除  将金额退至可提现余额
            if($row['akq_m_id'] && $row['akq_manage_deleted'] == 0){
                $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                $member_model->incrementMemberDeduct($row['akq_m_id'],$row['akq_money']);
            }
            return $question_model->updateById($set,$id);
        }
        return FALSE;
    }

    /*
     * 问题有回答且未作出选择  所有答案瓜分奖励
     * id 问题id
     */
    public function autoQuestionCheck($id){

        //获得当前问题的所有回答
        $answer_model = new App_Model_Knowledge_MysqlKnowledgeAnswerStorage($this->sid);
        $where[] = array('name'=>'aka_qid','oper'=>'=','value'=>$id);
        $where[] = array('name'=>'aka_s_id','oper'=>'=','value'=>$this->sid);
        $list = $answer_model->getList($where,0,0,array(),array('aka_id','aka_m_id'));

        $question_model = new App_Model_Knowledge_MysqlKnowledgeQuestionStorage($this->sid);
        $question = $question_model->getRowById($id);

        //获得分享奖金配置
        $threeCfg = array();
        $three_model = new App_Model_Knowledge_MysqlKnowledgeThreeStorage($this->sid);
        $threeList = $three_model->getThreeCfg();
        if($threeList){
            foreach ($threeList as $val){
                $threeCfg[$val['akt_level']] = array(
                    'main' => $val['akt_main']/100,
                    1      => $val['akt_lv1']/100,
                    2      => $val['akt_lv2']/100,
                    3      => $val['akt_lv3']/100,
                );
            }
        }

        if($list && ($question['akq_auto_check']-60) < time() && $question['akq_status'] == 2){
            $aidArr = array();
            foreach ($list as $val){
                $aidArr[] = $val['aka_id'];
            }
            $count = count($aidArr);
            //获得提问金额
            $totalMoney = floatval($question['akq_money']);
            //计算每人分得金额
            $money = sprintf("%.2f",substr(sprintf("%.3f", ($totalMoney/$count)), 0, -1)); //不四舍五入取两位小数
            //将问题状态改为已解决
            $res_q = $question_model->updateById(array('akq_status'=>3),$id);
            $answer_model = new App_Model_Knowledge_MysqlKnowledgeAnswerStorage($this->sid);

            //将分得金额记录至每一个回答并改为已获奖
//            $where_a[] = array('name'=>'aka_id','oper'=>'in','value'=>$aidArr);
//            $where_a[] = array('name'=>'aka_s_id','oper'=>'=','value'=>$this->sid);
//            $res_a = $answer_model->updateValue(array('aka_status'=>3,'aka_money'=>$money),$where_a);

            //该问题 将所有分享改为改为未获奖
            $share_model = new App_Model_Knowledge_MysqlKnowledgeQuestionShareStorage($this->sid);
            $where_share[] = array('name'=>'akqs_q_id','oper'=>'=','value'=>$id);
            $where_share[] = array('name'=>'akqs_s_id','oper'=>'=','value'=>$this->sid);
            $share_model->updateValue(array('akqs_status'=>2),$where_share);
            //获得回答会员id及对应奖励
            $mids = array();
            $shares = array();
            foreach ($list as $val){
                $trueMoney = $money;
                if($threeCfg){
                    //如果设置了转发配置
                    $share_list = array();
                    $this->_get_share_three($id,$val['aka_m_id'],$share_list,0);
                    $level = count($share_list);
                    if($level > 0){
                        $trueMoney = sprintf("%.2f",substr(sprintf("%.3f", ($trueMoney * $threeCfg[$level]['main'])), 0, -1));
                        foreach ($share_list as $value){
                            $shareMoney = sprintf("%.2f",substr(sprintf("%.3f", ($money * $threeCfg[$level][$value['level']])), 0, -1));
                            if($shareMoney > 0){
                                //将转发用户id及收益记录至数组
                                if(array_key_exists($value['mid'],$mids)){
                                    $moneyNow = floatval($mids[$value['mid']]) ;
                                    $mids[$value['mid']] = ($moneyNow + $shareMoney);
                                }else{
                                    $mids[$value['mid']] = floatval($shareMoney);
                                }
                                //将转发记录id及收益记录至数组
                                if(array_key_exists($value['id'],$shares)){
                                    $shares[$value['id']] = $shares[$value['id']] + $shareMoney;
                                }else{
                                    $shares[$value['id']] = floatval($shareMoney);
                                }
                            }
                        }
                    }
                }
                if(array_key_exists($val['aka_m_id'],$mids)){
                    $moneyNow = floatval($mids[$val['aka_m_id']]) ;
                    $mids[$val['aka_m_id']] = ($moneyNow + $trueMoney);
                }else{
                    $mids[$val['aka_m_id']] = floatval($trueMoney);
                }
                //对于答对的回答  改为已获奖 将分得金额记录至每一个回答
                $res_a = $answer_model->updateById(array('aka_status'=>3,'aka_money'=>$trueMoney),$val['aka_id']);

                //将当前回答的分享记录也改为已获奖
                $where_share[] = array('name'=>'akqs_m_id','oper'=>'=','value'=>$val['aka_m_id']);
                $share_model->updateValue(array('akqs_status'=>3),$where_share);

            }
            //对于答对的转发  改为已获奖 将分得金额记录至每一个转发记录
            if(!empty($shares)){
                foreach ($shares as $k => $v){
                    $share_model->updateById(array('akqs_status'=>3,'akqs_money'=>$v),$k);
                }
            }
//            foreach ($list as $val){
//                if(array_key_exists($val['aka_m_id'],$mids)){
//                    $moneyNow = floatval($mids[$val['aka_m_id']]) ;
//                    $mids[$val['aka_m_id']] = ($moneyNow + $money);//如果一个人回答了多次 累加
//                }else{
//                    $mids[$val['aka_m_id']] = floatval($money);
//                }
//            }
            //将会员可提现金额增加
            if(!empty($mids)){
                $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                foreach ($mids as $key => $val){
                    $member_model->incrementMemberDeduct($key,$val);
                    usleep(100000); //0.01秒
                }
            }
            if($res_a && $res_q){
                return true;
            }
        }
        return false;
    }


    /*
     * 递归获得上级信息 除自身 最多三级
     */
    public function _get_share_three($qid,$mid,&$list,$level){

        $share_model = new App_Model_Knowledge_MysqlKnowledgeQuestionShareStorage($this->sid);
        $row = $share_model->findRowByQidmid($qid,$mid);

        if($row && $level <= 3 ){
            if($level > 0){
                $list[] = array(
                    'id'    => $row['akqs_id'],
                    'level' => $level,
                    'mid'   => $row['akqs_m_id']
                );
            }
            $level++;
            $this->_get_share_three($qid,$row['akqs_m_fid'],$list,$level);
        }
    }

    /*
     * 自动审核通过并退款
     */
    public function autoApplyHandle($id){
        $apply_model = new App_Model_Knowledge_MysqlKnowledgeRefundApplyStorage($this->sid);
        $apply = $apply_model->getRowById($id);
        //如果取不到 再来一次
        if(!$apply){
            $apply = $apply_model->getRowById($id);
        }

        // 判断记录是否存在
        if(!$apply){
            return FALSE;
        }
        if($apply['akra_status'] == 1){
            $res = 0;
            $question_model = new App_Model_Knowledge_MysqlKnowledgeQuestionStorage($this->sid);
            $question = $question_model->getRowById($apply['akra_qid']);
            $money = floatval($question['akq_money']);
            if($money > 0){
                $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                //退回至可提现金额
                $res = $member_model->incrementMemberDeduct($question['akq_m_id'],$money);
            }
            if($res || $money <= 0){
                //更新退款状态
                $question_model->updateById(array(
                    'akq_refund_status'=>3,
                    'akq_status'=>4 //将问题改为已关闭
                ),$question['akq_id']);
                $apply_model->updateById(array('akra_status'=>3,'akra_handle_remark'=>'','akra_handle_time'=>time()),$id);
            }
        }
    }

}
