<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 19/9/16
 * Time: 下午8:07
 */
class App_Helper_Cashier{
    private $machine_cfg;
    private $managerList;
    private $store;
    private $curr_sid;
    private $manager;
    private $code;
    private $isFrom;
    const IMG_HOST_PATH = 'http://imgcov.tiandiantong.com';  //'http://alicdn.tiandiantong.com';
    public function __construct($machine_cfg,$store,$curr_sid,$manager,$code,$isFrom=1)
    {
        $this->machine_cfg = $machine_cfg;
        $this->store       = $store;
        $this->curr_sid    = $curr_sid;
        $this->manager     = $manager;
        $this->code        = $code;
        $this->managerList = $this->_get_all_keeper(true);
        $this->isFrom      = $isFrom;
    }
    //各个场景的处理 check = 手动打印的场景使用
    public function _check_machine_cfg_type($print,$voice,$tid,$check=false,$rowData=array()){
        $ret       = array(
            'print' => array('val'=>0,'data'=>[]),
            'voice' => array('val'=>0,'data'=>[])
        );
        $print_cfg = $this->machine_cfg['cmc_print_cfg']?json_decode($this->machine_cfg['cmc_print_cfg'],1):[];
        $voice_cfg = $this->machine_cfg['cmc_voice_cfg']?json_decode($this->machine_cfg['cmc_voice_cfg'],1):[];
        $managerList   = $this->managerList;


//        $voiceCfg = $this->_get_voice_cfg();
//        if(!empty($voiceCfg)) {
//            $showData      = $this->_get_print_voice_data_new($print,$tid,$managerList,$rowData);
//        } else {
//            $showData      = $this->_get_print_voice_data($print,$tid,$managerList,$rowData,$test);
//        }
        $showData      = $this->_get_print_voice_data_new($print,$tid,$managerList,$rowData);


        if($print_cfg){
            $printArr  = array_column($print_cfg,null,'id');
            if($printArr[$print]['value'] || $check == true){ //判断对应类型开启 打印的数据格式
                $ret['print']['data'] = array(
                    'html'     => $showData['html'],
                    'printNum' => $this->machine_cfg['cmc_print_num']?$this->machine_cfg['cmc_print_num']:1,
                    'printUsb' => $this->machine_cfg['cmc_print_usb']?$this->machine_cfg['cmc_print_usb']:'',
                    'isApp'    => 1,
                );
            }
        }
        if($voice_cfg){
            $voiceArr  = array_column($voice_cfg,null,'id');
            if($voiceArr[$voice]['value'] || $check == true || $this->curr_sid == '5655'){
               /* $note = $voiceArr[$voice]['note']?$voiceArr[$voice]['note']:'操作成功';
                $mp3_file = $this->_get_voice_mp3($note);
                $mp3_file = $mp3_file?$this->dealImagePath('/upload/tts/'.$mp3_file):'';*/
                $ret['voice'] = array('val'=>1,'data'=>$showData['note']);
            }
        }

        return $ret;
    }
    //获取语音播报的内容
    private function _get_voice_mp3($note){
        $fileNow  = sha1($this->code.$note).'.mp3';
        if(!file_exists(PLUM_DIR_UPLOAD.'/tts')){
            mkdir(PLUM_DIR_UPLOAD.'/tts','755');
        }

        if(!file_exists(PLUM_DIR_UPLOAD.'/tts/'.$fileNow)){
            $text   = $note;
            $textUrlEncode = urlencode($text);
            $textUrlEncode = preg_replace('/\+/', '%20', $textUrlEncode);
            $textUrlEncode = preg_replace('/\*/', '%2A', $textUrlEncode);
            $textUrlEncode = preg_replace('/%7E/', '~', $textUrlEncode);
            $audioSaveFile = PLUM_DIR_UPLOAD.'/tts/'.$fileNow;
            $format     = "mp3";
            $sampleRate = 16000;
            $tts_cfg  = plum_parse_config('tts_cfg','cashier');
            $plugin   = new App_Plugin_Tts_TtsDemoPlugin();
            $ret      = $plugin->processGETRequest($tts_cfg['appkey'], $tts_cfg['token'], $textUrlEncode, $audioSaveFile, $format, $sampleRate);
            return $ret['ec'] = 200?$fileNow:'';
        }else{
            return $fileNow;
        }

    }


    private function _get_print_voice_data($print,$tid,$managerList,$rowData,$test=false){
        switch ($print){
            case 1://支付成功
                $showData = $this->_get_pay_data($tid,$managerList);
                break;
            case 2://核销
                if(strlen($tid)==12){
                    $showData['html'] = $this->_get_mem_card($tid,$managerList);//获取会员核销数据
                    $showData['note'] = '会员卡核销成功';
                }else{
                    $showData['html'] = $this->_get_trade_data($tid,$managerList);
                    $showData['note'] = '订单核销成功';
                }
                break;
            case 3://余额
                $showData = $this->_get_mem_coin_data($tid,$managerList);
                break;
            case 4://积分
                $showData = $this->_get_mem_points_data($tid,$managerList);
                break;
            case 5://退款
                $showData = $this->_get_refund_data($tid,$managerList);
                break;
            case 6:
                $showData['html']    = $this->_get_handover_data($rowData);
                $showData['note']    = '交接班成功';
                break;
        }
        return $showData;
    }






    //获取支付成功数据
    private function _get_pay_data($tid,$managerList){
        $cash_model = new App_Model_Cash_MysqlRecordStorage($this->curr_sid);
        $rowData    = $cash_model->findUpdateTradeByTid($tid);
        $html       = '';
        if($rowData){
            $html  .= '<div style="text-align: center">订单支付</div>';
            $html  .= '<div>------------------------------------------</div>';
            $html  .= '<div>支付状态: 支付成功</div>';
            $html  .= '<div>门店名称: '.$this->store['os_name'].'</div>';
            $html  .= '<div>操作员工: '.$managerList['cr_uid'].'</div>';
            $html  .= '<div>支付金额: <b>'.$rowData['cr_money'].'</b></div>';
            $html  .= '<div>支付方式: '.App_Helper_Trade::$trade_pay_type['cr_pay_type'].'</div>';
            $html  .= '<div>订单名称: '.$tid.'</div>';
            $html  .= '<div>------------------------------------------</div>';
            $html  .= '<div style="text-align: center">谢谢惠顾</div>';
            $note   = '收款成功'.$rowData['cr_money'].'元';
        }
        return array('html'=>$html,'note'=>$note);
    }
    //获取会员卡核销数据
    private function _get_mem_card($cardNumber,$managerList){
        $where          = array();
        $where[]        = array('name' => 'om_card_num' ,'oper' => '=','value' => $cardNumber);
        $member_model   = new App_Model_Store_MysqlMemberStorage($this->curr_sid);
        $member         = $member_model->getMemberCard($where);
        $html   = '';
        if($member){
            $html  .= '<div style="text-align: center">卡券核销</div>';
            $html  .= '<div>------------------------------------------</div>';
            $html  .= '<div>核销状态: 核销成功</div>';
            $html  .= '<div>门店名称: '.$this->store['os_name'].'</div>';
            $html  .= '<div>操作员工: '.$this->manager['m_name'].'</div>';
            $html  .= '<div>核销时间: '.date('Y-m-d H:i',time()).'</div>';
            $html  .= '<div>核销次数: 1</div>';
            $html  .= '<div>剩余次数: '.$member['om_left_num'].'</div>';
            $html  .= '<div>会员卡号: '.$member['om_card_num'].'</div>';
            $html  .= '<div>会员名称: '.$member['m_nickname'].'</div>';
            $html  .= '<div>------------------------------------------</div>';
            $html  .= '<div style="text-align: center">谢谢惠顾</div>';
        }
        return $html;
    }
    //获取订单核销数据
    private function _get_trade_data($cardNumber,$managerList){
        $verify_model = new App_Model_Store_MysqlVerifyStorage($this->curr_sid);
        $where        = array();
        $where[]      = array('name'=>'ov_se_tid','oper'=>'=','value'=>$cardNumber);
        $trade        = $verify_model->getStoreMemberListCashier($where,0,1,array('ov_record_time' => 'DESC'))[0];
        $html         = '';
        if($trade){
            $goodsList = $this->_get_trade_goods($trade['t_id']);
            $html  .= '<div style="text-align: center">订单核销</div>';
            $html  .= '<div>------------------------------------------</div>';
            $html  .= '<div>核销状态:  核销成功</div>';
            $html  .= '<div>门店名称:  '.$this->store['os_name'].'</div>';
            $html  .= '<div>操作员工:  '.$managerList['ov_manager_id'].'</div>';
            $html  .= '<div>核销时间:  '.date('Y-m-d H:i',time()).'</div>';
            $html  .= '<div>订单名称:  '.$trade['t_title'].'</div>';
            $html  .= '<div>商品数量:  '.$trade['t_num'].'</div>';
            $html  .= '<div>商品名称:  </div>';
            if($goodsList){
                foreach ($goodsList as $key=>$val){
                    $html  .= '<div>商品名称:  '.$val['name'].'  X'.$val['num'].'</div>';
                }
            }
            $html  .= '<div>订单金额:  <b>'.$trade['t_total_fee'].'</b></div>';
            $html  .= '<div>------------------------------------------</div>';
            $html  .= '<div style="text-align: center">谢谢惠顾</div>';
        }
        return $html;
    }
    //获得订单商品
    private function _get_trade_goods($t_id){
        $data = array();
        $to_model = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
        $list = $to_model->getGoodsListByTid($t_id);
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'gid'  => $val['to_g_id'],
                    'name' => $val['g_name'],
                    'num'  => $val['to_num'],
                    'cover' => $this->dealImagePath($val['g_cover']),
                    'price' => $val['to_price'],
                    'total' => $val['to_total'],
                );
            }
        }
        return $data;
    }

    //储值变动播报,余额变动记录id
    private function _get_mem_coin_data($tid,$managerList){
        $record_model = new App_Model_Member_MysqlRechargeStorage($this->curr_sid);
        $rowData      = $record_model->getMemberRow($tid);
        $html         = '';
        $note         = '';
        if($rowData){
            $statusDesc = $rowData['rr_status'] == 1?'储值':'扣除';
            $money  = $rowData['rr_status'] == 1?'+'.$rowData['rr_amount']:'-'.$rowData['rr_amount'];
            $html  .= '<div style="text-align: center">余额'.$statusDesc.'</div>';
            $html  .= '<div>------------------------------------------</div>';
            $html  .= '<div>门店名称:  '.$this->store['os_name'].'</div>';
            $html  .= '<div>操作员工:  '.$managerList['rr_manager_id'].'</div>';
            $html  .= '<div>'.$statusDesc.'状态:  '.$statusDesc.'</div>';
            $html  .= '<div>'.$statusDesc.'时间:  '.date('Y-m-d H:i',$rowData['rr_create_time']).'</div>';
            $html  .= '<div>'.$statusDesc.'金额:  <b>'.$money.'</b></div>';
            $html  .= '<div>剩余余额:  <b>'.$rowData['m_gold_coin'].'</b></div>';
            $html  .= '<div>------------------------------------------</div>';
            $html  .= '<div style="text-align: center">谢谢惠顾</div>';
            $note   = '余额'.$statusDesc.$money.'元成功';
        }
        return array('html'=>$html,'note'=>$note);
    }

    //积分变动 tid :积分变动记录id
    private function _get_mem_points_data($tid,$managerList){
        $inout_model  = new App_Model_Point_MysqlInoutStorage($this->curr_sid);
        $where        = array();
        $where[]      = array('name'=>'pi_id','oper'=>'=','value'=>$tid);
        $rowData      = $inout_model->getListMember($where,0,1)[0];
        $html         = '';
        $note         = '';
        if($rowData){
            $statusDesc = $rowData['pi_type'] == 1?'储值':'扣除';
            $money  = $rowData['pi_type'] == 1?'+'.$rowData['pi_point']:'-'.$rowData['pi_point'];
            $html  .= '<div style="text-align: center">积分'.$statusDesc.'</div>';
            $html  .= '<div>------------------------------------------</div>';
            $html  .= '<div>门店名称:  '.$this->store['os_name'].'</div>';
            $html  .= '<div>操作员工:  '.$managerList['pi_manager_id'].'</div>';
            $html  .= '<div>'.$statusDesc.'状态:  '.$statusDesc.'</div>';
            $html  .= '<div>'.$statusDesc.'时间:  '.date('Y-m-d H:i',$rowData['pi_create_time']).'</div>';
            $html  .= '<div>'.$statusDesc.'积分:  <b>'.$money.'</b></div>';
            $html  .= '<div>剩余积分:  <b>'.$rowData['m_points'].'</b></div>';
            $html  .= '<div>------------------------------------------</div>';
            $html  .= '<div style="text-align: center">谢谢惠顾</div>';
            $note   = '积分'.$statusDesc.$money.'成功';
        }
        return array('html'=>$html,'note'=>$note);
    }

    //处理退款
    private function _get_refund_data($tid,$managerList){
        $crr_model = new App_Model_Cash_MysqlRefundRecordStorage($this->curr_sid);
        $where     = array();
        $where[]   = array('name'=>'crr_refund_tid','oper'=>'=','value'=>$tid);
        $rowData      = $crr_model->getRow($where);
        $html         = '';
        $note         = '';
        if($rowData){

            $html  .= '<div style="text-align: center">订单退款</div>';
            $html  .= '<div>------------------------------------------</div>';
            $html  .= '<div>门店名称:  '.$this->store['os_name'].'</div>';
            $html  .= '<div>操作员工:  '.$managerList['crr_uid'].'</div>';
            $html  .= '<div>退款状态:  退款成功</div>';
            $html  .= '<div>退款时间:  '.date('Y-m-d H:i',$rowData['crr_pay_time']).'</div>';
            $html  .= '<div>退款金额:  <b>'.$rowData['crr_refund_money'].'</b></div>';
            $html  .= '<div>退款方式:  <b>'.App_Helper_Trade::$trade_pay_type[$rowData['crr_pay_type']].'</b></div>';
            $html  .= '<div>------------------------------------------</div>';
            $html  .= '<div style="text-align: center">谢谢惠顾</div>';
            $note   = '订单退款'.$rowData['crr_refund_money'].'元';
        }
        return array('html'=>$html,'note'=>$note);

    }
    //处理交接
    private function _get_handover_data($rowData,$managerList=''){
        $html         = '';
        if($rowData){
            $html  .= '<div style="text-align: center">交接班</div>';
            $html  .= '<div>------------------------------------------</div>';
            $html  .= '<div>门店名称:  '.$this->store['os_name'].'</div>';
            $html  .= '<div>操作员工:  '.$this->manager['m_nickname'].'</div>';
            $html  .= '<div>开始时间:  '.date('Y-m-d H:i',$rowData['chr_login_time']).'</div>';
            $html  .= '<div>结束时间:  '.date('Y-m-d H:i',$rowData['chr_out_time']).'</div>';
            $html  .= '<div>收入金额:  <b>'.$rowData['chr_all_money'].'</b></div>';
            $html  .= '<div>退款金额:  <b>'.$rowData['chr_refund_money'].'</b></div>';
            $html  .= '<div>订单核销:  <b>'.$rowData['chr_hexiao_trade'].'</b></div>';
            $html  .= '<div>计次卡核销:  <b>'.$rowData['chr_hexiao_card'].'</b></div>';
        }
        return $html;
    }


    public function dealImagePath($path,$down=false) {
        $absolute   = false;
        $pattern    = '/^http[s]?:\/\//';
        if (preg_match($pattern, $path)) {
            $absolute = true;
        }
        if (!$absolute) {//非绝对路径
            // 小程序下载的图片必须和授权域名一致
            if($down){
                $path = plum_get_base_host() . '/' . ltrim($path, '/');
            }else{
                $path = self::IMG_HOST_PATH . '/' . ltrim($path, '/');
            }
        }
        return $path;
    }
    /**
     * 获取所有的收银员
     */
    private function _get_all_keeper($rel=false){
        $manager_model = new App_Model_Member_MysqlManagerStorage();
        $where   = array();
        $where[] = array('name'=>'m_bind_sid','oper'=>'=','value'=>$this->store['os_id']);
        $list    = $manager_model->getList($where,0,0,[],['m_id','m_nickname']);
        $newArr   = array();
        if($list){
            if($rel){
                foreach ($list as $key=>$val){
                    $newArr[$val['m_id']] = $val['m_nickname'];
                }
            }else{
                foreach ($list as $key=>$val){
                    $newArr[] = array(
                        'id'    => $val['m_id'],
                        'title' => $val['m_nickname']
                    );
                }
                array_unshift($newArr,['id'=>0,'title'=>'全部']);
            }

        }

        return $newArr;
    }

    private function _get_voice_cfg() {
        $mch_cfg  = new App_Model_Cash_MysqlMachineCfgStorage($this->curr_sid);
        $where[] = array('name'=>'cmc_s_id', 'oper'=>'=', 'value'=>$this->curr_sid);
        $where[] = array('name'=>'cmc_os_id', 'oper'=>'=', 'value'=>0);
        $where[] = array('name'=>'cmc_code', 'oper'=>'=', 'value'=>'');

        $row   = $mch_cfg->getRow($where);
        if($row) {
            $voice = json_decode($row['cmc_voice_cfg'], true);
        } else {
            // 默认配置
            $vt   = plum_parse_config('voice_type', 'cashier'); //播放类型
            $cvd   = plum_parse_config('cash_voice_default', 'cashier'); // 默认语音
            $voice = array();
            foreach($vt as $key => $value) {
                $voice[] = array(
                    'id' => $key,
                    'title' => $value,
                    'value' => 1,
                    'note'  => $cvd[$key],
                );
            }
        }
        return $voice;
    }


    private function _get_print_voice_data_new($print,$tid,$managerList,$rowData){
        $voiceCfg = $this->_get_voice_cfg();
        switch ($print){
            case 1://支付成功
                $showData = $this->_get_pay_data_new($tid,$managerList, $voiceCfg[0]['note']);
                break;
            case 2://核销
                if(strlen($tid)==12){
                    $showData = $this->_get_mem_card_new($tid,$managerList, $voiceCfg[1]['note']);//获取会员核销数据
                }else{
                    $showData = $this->_get_trade_data_new($tid,$managerList, $voiceCfg[1]['note']);
                }
                break;
            case 3://余额
                $showData = $this->_get_mem_coin_data_new($tid,$managerList, $voiceCfg[2]['note']);
                break;
            case 4://积分
                $showData = $this->_get_mem_points_data_new($tid,$managerList, $voiceCfg[3]['note']);
                break;
            case 5://退款
                $showData = $this->_get_refund_data_new($tid,$managerList, $voiceCfg[4]['note']);
                break;
            case 6:
                $showData = $this->_get_handover_data_new($rowData,$managerList, $voiceCfg[5]['note']);
                break;
        }
        return $showData;
    }


    //获取支付成功数据
    private function _get_pay_data_new($tid,$managerList, $voice){
        $cash_model = new App_Model_Cash_MysqlRecordStorage($this->curr_sid);
        $rowData    = $cash_model->findUpdateTradeByTid($tid);
        $html       = '';
        $note       = '';
        if($rowData){
            if($this->isFrom == 2){
                $print_cfg = plum_parse_config('ali_applet_print','cashier');
                $html    = $print_cfg[1];
                $order   = array('{title}','{time}','{store}','{keeper}','{tid}','{money}','{discount}');
                $replace = array('订单支付',date('Y-m-d H:i',time()),$this->store['os_name'],$managerList['cr_uid'],$tid,$rowData['cr_money'],'0.00');
                $html    = str_replace($order,$replace,$html);
                $html    = str_replace('"','\'',$html);
                $html    = str_replace('\'','"',$html);
                $html    = json_decode($html,1);
                /*$str     = $html;
                $str     = str_replace($order,$replace,$str);
                $str     = str_replace(':','=>',$str);
                $str     = str_replace('{','[',$str);
                $str     = str_replace('},',']|',$str);
                $html    = explode('|',$str);*/
            }else{
                $html  .= '<div style="text-align: center">订单支付</div>';
                $html  .= '<div>------------------------------------------</div>';
                $html  .= '<div>支付状态: 支付成功</div>';
                $html  .= '<div>门店名称: '.$this->store['os_name'].'</div>';
                $html  .= '<div>操作员工: '.$managerList['cr_uid'].'</div>';
                $html  .= '<div>支付金额: <b>'.$rowData['cr_money'].'</b></div>';
                $html  .= '<div>支付方式: '.App_Helper_Trade::$trade_pay_type['cr_pay_type'].'</div>';
                $html  .= '<div>订单名称: '.$tid.'</div>';
                $html  .= '<div>------------------------------------------</div>';
                $html  .= '<div style="text-align: center">谢谢惠顾</div>';
            }
            $note  = str_replace('{支付金额}',$rowData['cr_money'], $voice);
        }
        return array('html'=>$html,'note'=>$note);
    }

    //获取会员卡核销数据
    private function _get_mem_card_new($cardNumber,$managerList, $voice){
        $where          = array();
        $where[]        = array('name' => 'om_card_num' ,'oper' => '=','value' => $cardNumber);
        $member_model   = new App_Model_Store_MysqlMemberStorage($this->curr_sid);
        $member         = $member_model->getMemberCard($where);
        $html   = '';
        $note   = '';
        if($member){
            $html  .= '<div style="text-align: center">卡券核销</div>';
            $html  .= '<div>------------------------------------------</div>';
            $html  .= '<div>核销状态: 核销成功</div>';
            $html  .= '<div>门店名称: '.$this->store['os_name'].'</div>';
            $html  .= '<div>操作员工: '.$this->manager['m_name'].'</div>';
            $html  .= '<div>核销时间: '.date('Y-m-d H:i',time()).'</div>';
            $html  .= '<div>核销次数: 1</div>';
            $html  .= '<div>剩余次数: '.$member['om_left_num'].'</div>';
            $html  .= '<div>会员卡号: '.$member['om_card_num'].'</div>';
            $html  .= '<div>会员名称: '.$member['m_nickname'].'</div>';
            $html  .= '<div>------------------------------------------</div>';
            $html  .= '<div style="text-align: center">谢谢惠顾</div>';

//            $note  = '会员卡核销成功';
            $note  = $voice;
        }
        return array('html'=>$html, 'note'=>$note);
    }
    //获取订单核销数据
    private function _get_trade_data_new($cardNumber,$managerList, $voice){
        $verify_model = new App_Model_Store_MysqlVerifyStorage($this->curr_sid);
        $where        = array();
        $where[]      = array('name'=>'ov_se_tid','oper'=>'=','value'=>$cardNumber);
        $trade        = $verify_model->getStoreMemberListCashier($where,0,1,array('ov_record_time' => 'DESC'))[0];
        $html         = '';
        $note         = '';
        if($trade){
            $goodsList = $this->_get_trade_goods($trade['t_id']);
            $html  .= '<div style="text-align: center">订单核销</div>';
            $html  .= '<div>------------------------------------------</div>';
            $html  .= '<div>核销状态:  核销成功</div>';
            $html  .= '<div>门店名称:  '.$this->store['os_name'].'</div>';
            $html  .= '<div>操作员工:  '.$managerList['ov_manager_id'].'</div>';
            $html  .= '<div>核销时间:  '.date('Y-m-d H:i',time()).'</div>';
            $html  .= '<div>订单名称:  '.$trade['t_title'].'</div>';
            $html  .= '<div>商品数量:  '.$trade['t_num'].'</div>';
            $html  .= '<div>商品名称:  </div>';
            if($goodsList){
                foreach ($goodsList as $key=>$val){
                    $html  .= '<div>商品名称:  '.$val['name'].'  X'.$val['num'].'</div>';
                }
            }
            $html  .= '<div>订单金额:  <b>'.$trade['t_total_fee'].'</b></div>';
            $html  .= '<div>------------------------------------------</div>';
            $html  .= '<div style="text-align: center">谢谢惠顾</div>';

//            $note  = '订单核销成功';
            $note  = $voice;
        }
        return array('html'=>$html, 'note'=>$note);
    }

    //储值变动播报,余额变动记录id
    private function _get_mem_coin_data_new($tid,$managerList, $voice){
        $record_model = new App_Model_Member_MysqlRechargeStorage($this->curr_sid);
        $rowData      = $record_model->getMemberRow($tid);
        $html         = '';
        $note         = '';
        if($rowData){
            $statusDesc = $rowData['rr_status'] == 1?'储值':'扣除';
            $money  = $rowData['rr_status'] == 1?'+'.$rowData['rr_amount']:'-'.$rowData['rr_amount'];
            $html  .= '<div style="text-align: center">余额'.$statusDesc.'</div>';
            $html  .= '<div>------------------------------------------</div>';
            $html  .= '<div>门店名称:  '.$this->store['os_name'].'</div>';
            $html  .= '<div>操作员工:  '.$managerList['rr_manager_id'].'</div>';
            $html  .= '<div>'.$statusDesc.'状态:  '.$statusDesc.'</div>';
            $html  .= '<div>'.$statusDesc.'时间:  '.date('Y-m-d H:i',$rowData['rr_create_time']).'</div>';
            $html  .= '<div>'.$statusDesc.'金额:  <b>'.$money.'</b></div>';
            $html  .= '<div>剩余余额:  <b>'.$rowData['m_gold_coin'].'</b></div>';
            $html  .= '<div>------------------------------------------</div>';
            $html  .= '<div style="text-align: center">谢谢惠顾</div>';

//            $note   = '余额'.$statusDesc.$money.'元成功';
            $note   = str_replace('{变动状态}', $statusDesc, $voice);
            $note   = str_replace('{变动金额}', $money, $note);
        }
        return array('html'=>$html,'note'=>$note);
    }

    //积分变动 tid :积分变动记录id
    private function _get_mem_points_data_new($tid,$managerList, $voice){
        $inout_model  = new App_Model_Point_MysqlInoutStorage($this->curr_sid);
        $where        = array();
        $where[]      = array('name'=>'pi_id','oper'=>'=','value'=>$tid);
        $rowData      = $inout_model->getListMember($where,0,1)[0];
        $html         = '';
        $note         = '';
        if($rowData){
            $statusDesc = $rowData['pi_type'] == 1?'储值':'扣除';
            $money  = $rowData['pi_type'] == 1?'+'.$rowData['pi_point']:'-'.$rowData['pi_point'];
            $html  .= '<div style="text-align: center">积分'.$statusDesc.'</div>';
            $html  .= '<div>------------------------------------------</div>';
            $html  .= '<div>门店名称:  '.$this->store['os_name'].'</div>';
            $html  .= '<div>操作员工:  '.$managerList['pi_manager_id'].'</div>';
            $html  .= '<div>'.$statusDesc.'状态:  '.$statusDesc.'</div>';
            $html  .= '<div>'.$statusDesc.'时间:  '.date('Y-m-d H:i',$rowData['pi_create_time']).'</div>';
            $html  .= '<div>'.$statusDesc.'积分:  <b>'.$money.'</b></div>';
            $html  .= '<div>剩余积分:  <b>'.$rowData['m_points'].'</b></div>';
            $html  .= '<div>------------------------------------------</div>';
            $html  .= '<div style="text-align: center">谢谢惠顾</div>';

//            $note   = '积分'.$statusDesc.$money.'成功';
            $note   = str_replace('{变动状态}', $statusDesc, $voice);
            $note   = str_replace('{变动金额}', $money, $note);
        }
        return array('html'=>$html,'note'=>$note);
    }

    //处理退款
    private function _get_refund_data_new($tid,$managerList, $voice){
        $crr_model = new App_Model_Cash_MysqlRefundRecordStorage($this->curr_sid);
        $where     = array();
        $where[]   = array('name'=>'crr_refund_tid','oper'=>'=','value'=>$tid);
        $rowData      = $crr_model->getRow($where);
        $html         = '';
        $note         = '';
        if($rowData){

            $html  .= '<div style="text-align: center">订单退款</div>';
            $html  .= '<div>------------------------------------------</div>';
            $html  .= '<div>门店名称:  '.$this->store['os_name'].'</div>';
            $html  .= '<div>操作员工:  '.$managerList['crr_uid'].'</div>';
            $html  .= '<div>退款状态:  退款成功</div>';
            $html  .= '<div>退款时间:  '.date('Y-m-d H:i',$rowData['crr_pay_time']).'</div>';
            $html  .= '<div>退款金额:  <b>'.$rowData['crr_refund_money'].'</b></div>';
            $html  .= '<div>退款方式:  <b>'.App_Helper_Trade::$trade_pay_type[$rowData['crr_pay_type']].'</b></div>';
            $html  .= '<div>------------------------------------------</div>';
            $html  .= '<div style="text-align: center">谢谢惠顾</div>';

//            $note   = '订单退款'.$rowData['crr_refund_money'].'元';
            $note   = str_replace('{退款金额}', $rowData['crr_refund_money'], $voice);
        }
        return array('html'=>$html,'note'=>$note);
    }

    //处理交接
    private function _get_handover_data_new($rowData,$managerList='', $voice){
        $html         = '';
        $note         = '';
        if($rowData){
            if($this->isFrom == 2){
                $print_cfg = plum_parse_config('ali_applet_print','cashier');
                $html    = $print_cfg[6];
                $order   = array('{title}','{store}','{keeper}','{startTime}','{endTime}','{money}','{backMoney}','{hexiao}','{jici}');
                $replace = array('交接班',$this->store['os_name'],$this->manager['m_nickname'],date('Y-m-d H:i',$rowData['chr_login_time']),date('Y-m-d H:i',$rowData['chr_out_time']),$rowData['chr_all_money'],$rowData['chr_refund_money'],$rowData['chr_hexiao_trade'],$rowData['chr_hexiao_card']);
                $html    = str_replace($order,$replace,$html);
                $html    = str_replace($order,$replace,$html);
                $html    = str_replace('"','\'',$html);
                $html    = str_replace('\'','"',$html);
                $html    = json_decode($html,1);
            }else{
                $html  .= '<div style="text-align: center">交接班</div>';
                $html  .= '<div>------------------------------------------</div>';
                $html  .= '<div>门店名称:  '.$this->store['os_name'].'</div>';
                $html  .= '<div>操作员工:  '.$this->manager['m_nickname'].'</div>';
                $html  .= '<div>开始时间:  '.date('Y-m-d H:i',$rowData['chr_login_time']).'</div>';
                $html  .= '<div>结束时间:  '.date('Y-m-d H:i',$rowData['chr_out_time']).'</div>';
                $html  .= '<div>收入金额:  <b>'.$rowData['chr_all_money'].'</b></div>';
                $html  .= '<div>退款金额:  <b>'.$rowData['chr_refund_money'].'</b></div>';
                $html  .= '<div>订单核销:  <b>'.$rowData['chr_hexiao_trade'].'</b></div>';
                $html  .= '<div>计次卡核销:  <b>'.$rowData['chr_hexiao_card'].'</b></div>';
            }
            $note  = $voice;
        }
        return array('html'=>$html, 'note'=>$note);
    }
}