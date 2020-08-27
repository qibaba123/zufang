<?php

class App_Helper_Answerpay {
    /*
     * 店铺ID
     */
    private $sid;
    /*
     * 店铺数据，字段名参考pre_shop
     */
    private $shop;
    private $member_model;
    private $question_model;
    private $cfg_model;
    public function __construct($sid){
        $this->sid  = $sid;
        //获取店铺信息
        $shop_storage   = new App_Model_Shop_MysqlShopCoreStorage();
        $this->shop     = $shop_storage->getRowById($sid);
        $this->member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $this->question_model = new App_Model_Answerpay_MysqlAnswerpayQuestionStorage($this->sid);
        $this->cfg_model = new App_Model_Answerpay_MysqlAnswerpayCfgStorage($this->sid);
    }

    public function dealAnswerBuy($mid,$aid,$questionType,$money = 0){
        $buy_model = new App_Model_Answerpay_MysqlAnswerpayAnswerBuyStorage($this->sid);
        $buy_insert = [
            'aaab_s_id' => $this->sid,
            'aaab_m_id' => $mid,
            'aaab_a_id' => $aid,
            'aaab_a_type' => $questionType,
            'aaab_create_time' => $_SERVER["REQUEST_TIME"]
        ];
        $buy_model->insertValue($buy_insert);
        $this->dealAnswerBuyDeduct($aid,$questionType,$money);
    }

    /*
     * 处理购买
     */
    public function dealAnswerBuyDeduct($aid,$questionType,$money = 0){
        if($money <= 0){
            return;
        }

        $cfg = $this->cfg_model->findUpdateCfg();
        if(
            ($questionType == 2 && ($cfg['aac_expert_answer_percent'] > 0 || $cfg['aac_expert_question_percent'] > 0)) ||
            ($questionType == 3 && ($cfg['aac_manager_answer_percent'] > 0 || $cfg['aac_manager_question_percent'] > 0))
        ){
            $insert = [];
            $answer_model = new App_Model_Answerpay_MysqlAnswerpayAnswerStorage($this->sid);
            $row = $answer_model->getAnswerQuestionRow($aid);
            if($questionType == 2){
                //专家提问 回答者专家增加收入
                if($cfg['aac_expert_answer_percent'] > 0 && $row['aaa_manager_id'] > 0){
                    $deduct_answer = $money * $cfg['aac_expert_answer_percent'] / 100;

                    if($deduct_answer > 0){
                        //$this->member_model->incrementMemberDeductAmount($row['aaa_m_id'],$deduct_answer);
                        $manager_model = new App_Model_Entershop_MysqlManagerStorage();
                        $manager_model->incrementManagerDeductAmount($row['aaa_manager_id'],$deduct_answer);
                        $insert[] =  " (NULL, '{$this->sid}','{$row['aaa_m_id']}','2','{$questionType}','{$money}','{$deduct_answer}','".$_SERVER['REQUEST_TIME']."','{$row['aaa_manager_id']}','1','2','{$row['aaa_q_id']}','{$row['aaa_id']}') ";
                    }
                }

                if($cfg['aac_expert_question_percent'] > 0 && $row['aaq_m_id'] > 0){
                    $deduct_question = $money * $cfg['aac_expert_question_percent'] / 100;
                    if($deduct_question > 0){
                        $this->member_model->incrementMemberDeductAmount($row['aaq_m_id'],$deduct_question);
                        $insert[] =  " (NULL, '{$this->sid}','{$row['aaq_m_id']}','1','{$questionType}','{$money}','{$deduct_question}','".$_SERVER['REQUEST_TIME']."','0','1','1','{$row['aaa_q_id']}','{$row['aaa_id']}') ";
                    }
                }
            //管理人回答 由于管理人已经是平台本身 不做佣金增加 仅做记录
            }elseif ($questionType == 3){
                if($cfg['aac_manager_answer_percent'] > 0 && $row['aaa_type'] == 3){
                    $deduct_answer = $money * $cfg['aac_manager_answer_percent'] / 100;
                    if($deduct_answer > 0){
                        //$this->member_model->incrementMemberDeductAmount($row['aaa_m_id'],$deduct_answer);
                        $insert[] =  " (NULL, '{$this->sid}','{$row['aaa_m_id']}','2','{$questionType}','{$money}','{$deduct_answer}','".$_SERVER['REQUEST_TIME']."','0','1','3','{$row['aaa_q_id']}','{$row['aaa_id']}') ";
                    }
                }

                if($cfg['aac_manager_question_percent'] > 0 && $row['aaq_m_id'] > 0){
                    $deduct_question = $money * $cfg['aac_manager_question_percent'] / 100;
                    if($deduct_question > 0){
                        $this->member_model->incrementMemberDeductAmount($row['aaq_m_id'],$deduct_question);
                        $insert[] =  " (NULL, '{$this->sid}','{$row['aaq_m_id']}','1','{$questionType}','{$money}','{$deduct_question}','".$_SERVER['REQUEST_TIME']."','0','1','1','{$row['aaa_q_id']}','{$row['aaa_id']}') ";
                    }
                }
            }
            if($insert){
                $income_model = new App_Model_Answerpay_MysqlAnswerpayIncomeRecordStorage($this->sid);
                $income_model->insertBatch($insert);
            }
        }
    }

    /*
     * 自动关闭提问
     */
    public function autoCloseQuestion($id){
        $row = $this->question_model->getRowById($id);
        $refund = 0;
        if($row && $row['aaq_close'] == 0){
            if($row['aaq_number']  && $row['aaq_refund'] == 0){
                $refund_res = $this->dealRefund($row);
                if($refund_res['ec'] != 200){
                    return;
                }else{
                    $refund = 1;
                }
            }
            $update = [
                'aaq_close' => 1,
                'aaq_close_time' => time(),
                'aaq_refund' => $refund
            ];
            $this->question_model->updateById($update,$id);
        }else{
            return;
        }
    }

    /*
     * 处理付费问答退款
     */
    public function dealRefund($row){
//        $row = $this->question_model->getRowById($id);
        if($row['aaq_answer_num'] == 0){
            if($row['aaq_refund'] == 0){
                $record_model = new App_Model_Answerpay_MysqlAnswerpayPayRecordStorage($this->sid);
                $record = $record_model->findUpdateByNumber($row['aaq_number']);

                $trade_helper = new App_Helper_Trade($this->sid);
                $check_res = $trade_helper->checkAppletTradeRefund($record['aapr_pay_type'],$record['aapr_money']);


                if($check_res['errno'] < 0){
                    $result = [
                        'ec' => 400,
                        'em' => $check_res['errmsg']
                    ];
                }else{
                    $mid = $record['aapr_m_id'];
                    $money = $record['aapr_money'];
                    switch ($record['aapr_pay_type']){
                        case 1://微信支付
                            $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
                            $appcfg = $appletPay_Model->findRowPay();
                            if($appcfg && $appcfg['ap_sub_pay']==1){
                                $subPay_storage = new App_Plugin_Weixin_AppletSubPay($this->sid);
                                $ret = $subPay_storage->appletRefundPayOrder($appcfg['ap_appid'],$record['aapr_number'], $record['aapr_number'], $record['aapr_money'], $record['aapr_money'], 'sh');
                            }else{
                                //发起微信退款
                                $new_pay    = new App_Plugin_Weixin_NewPay($this->sid);
                                $ret = $new_pay->appletRefundPayOrder($record['aapr_number'], $record['aapr_number'], $record['aapr_money'], $record['aapr_money'], 'sh');
                            }

                            break;
                        case 3://余额支付
                            Libs_Log_Logger::outputLog('余额支付','test.log');
                            $res = App_Helper_MemberLevel::goldCoinTrans($this->sid, $mid, $money);
                            if($res){
                                $ret['code'] = 'SUCCESS';
                                $this->_recharge_record($record,$money);
                            }else{
                                $ret['errmsg'] = '退款失败';
                            }
                            break;
                    }

                    if(!$res || $ret['code'] != 'SUCCESS'){
                        $result = [
                            'ec' => 400,
                            'em' => $ret['errmsg'] ? $ret['errmsg'] : ''
                        ];
                    }else{
                        $result = [
                            'ec' => 200,
                            'em' => '退款成功'
                        ];
                    }
                }
            }else{
                $result = [
                    'ec' => 400,
                    'em' => '问题已退款'
                ];
            }
        }else{
            $result = [
                'ec' => 400,
                'em' => '问题已被回答'
            ];
        }

        return $result;
    }

    private function _recharge_record($record,$money){
        $record_storage = new App_Model_Member_MysqlRechargeStorage($this->sid);
        //消费记录保存
        $indata = array(
            'rr_tid'        => $record['aapr_number'],
            'rr_s_id'       => $this->sid,
            'rr_m_id'       => $record['aapr_m_id'],
            'rr_amount'     => 0,
            'rr_gold_coin'  => $money,
            'rr_status'     => 1,//标识金币增加
            'rr_pay_type'   => 16,//付费问答问题退款
            'rr_remark'     => '提问退款',
            'rr_create_time'=> time(),
        );
        $record_storage->insertValue($indata);
    }

    /*
     * 保存消息
     * type 1.收到回答 2.提问被退回 3.支付成功 4.提问被删除
     */
    public function saveMessageAction($type,$info,$extra){
        //id 提问或回答的id
        //mid 接收消息的mid
        //title 消息标题
        //content 消息内容
        $id2 = 0;
        switch ($type){
            //回答
            case 1:
                $title = "您的提问收到 ".$extra['name']." 回答";
                $content = $info['aaq_title'];
                $id = $info['aaq_id'];
                $id2 = $extra['aid'];
                $mid = $info['aaq_m_id'];
                break;
            //退回
            case 2:
                $title = "您的提问被 ".$extra['name']." 退回";
                $content = $info['aaq_title'];
                $id = $info['aaq_id'];
                $mid = $info['aaq_m_id'];
                break;
            //付费提问支付成功
            case 3:
                $title = "付费提问支付成功，共计".$extra['money'];
                $content = $info['aaq_title'];
                $id = $info['aaq_id'];
                $mid = $info['aaq_m_id'];
                break;
            //付费提问支付成功
//            case 4:
//                $title = "您的提问被管理员删除";
//                $content = $info['aaq_title'];
//                $id = $info['aaq_id'];
//                $mid = $info['aaq_m_id'];
//                break;
        }

        $message = [
            'aam_s_id' => $this->sid,
            'aam_m_id' => $mid,
            'aam_content' => $content,
            'aam_title' => $title,
            'aam_type' => $type,
            'aam_info_id' => $id,
            'aam_info_id2' => $id2,
            'aam_create_time' => time()
        ];
        $message_model = new App_Model_Answerpay_MysqlAnswerpayMessageStorage($this->sid);
        $message_model->insertValue($message);

    }


}