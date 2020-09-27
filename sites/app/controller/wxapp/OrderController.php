<?php


class App_Controller_Wxapp_OrderController extends App_Controller_Wxapp_OrderCommonController {
    const MAX_EXPORT_EXCEL_ROWS=15000;
    
    private $order_storage;

    public function __construct() {
        parent::__construct();
        $this->order_storage = new App_Model_Shop_MysqlOrderCoreStorage();
    }

    private function _show_order_data_list(){
        $page = $this->request->getIntParam('page');
        $index= $page * $this->count;
        $sort = array('o_id' => 'DESC');//订单生成时间倒序排列
        $filed= array();
        $where = array();
        $where[] = array('name' => 'o_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $output = array();
        $output['tid'] = $this->request->getStrParam('tid');
        if($output['tid']){
            $where[] = array('name' => 'o_tid', 'oper' => '=', 'value' => $output['tid']);
        }
        $output['title'] = $this->request->getStrParam('title');
        if($output['title']){
            $where[] = array('name' => 'o_title', 'oper' => 'like', 'value' => "%{$output['title']}%");
        }
        $output['nickname'] = $this->request->getStrParam('nickname');
        if($output['nickname']){
            $where[] = array('name' => 'o_buyer_nick', 'oper' => 'like', 'value' => "%{$output['nickname']}%");
        }
        $output['status'] = $this->request->getStrParam('status');
        $status = plum_parse_config('order_status_search');
        if(isset($status[$output['status']]) && $status[$output['status']]){
            $where[] = array('name' => 'o_status', 'oper' => '=', 'value' => $status[$output['status']]);
        }
        for($i=1;$i<=3;$i++){
            $fid = $this->request->getIntParam($i.'f_id');
            if($fid){
                $where[] = array('name' => 'o_'.$i.'f_id', 'oper' => '=', 'value' => $fid);
            }
        }
        $output['mid'] = $this->request->getIntParam('mid');
        if($output['mid']){
            $where[] = array('name' => 'o_m_id', 'oper' => '=', 'value' => $output['mid']);
        }
        $total = $this->order_storage->getCount($where);
        $page_plugin = new Libs_Pagination_Paginator($total,$this->count,'jquery',1);
        $this->output['paginator'] = $page_plugin->render();
        $list = array();
        if($total > $index){
            $list = $this->order_storage->getList($where,$index,$this->count,$sort,$filed);
            $this->output['level'] = $this->show_member_level_info($list,'o_');
        }
        $output['list'] = $list;
        $this->showOutput($output);
    }
    
    public function refundAction() {
        $refundResult = array(
            'ec' => 400,
            'em' => '保存失败'
        );
        $this->displayJson($refundResult);

        $order_model = new App_Model_Shop_MysqlOrderCoreStorage();
        $oid    = $this->request->getIntParam('oid');
        $order  = $order_model->getRowById($oid);

        if (!$order || $order['o_s_id'] != $this->curr_sid) {
            $refundResult['em'] = '订单编号错误';
            $this->displayJson($refundResult);
            return;
        }
        if ($order['o_status'] == App_Helper_OrderLevel::ORDER_REFUND || $order['o_status'] == App_Helper_OrderLevel::ORDER_NO_PAY) {
            $refundResult['em'] = '订单已退款订单';
            $this->displayJson($refundResult);
            return;
        }
        $order_redis    = new App_Model_Shop_RedisOrderStatusStorage($this->curr_sid);
        $order_redis->delTidFromHash($order['o_tid']);

        $payment    = (float)$order['o_payment'];
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $weixin_client  = new App_Plugin_Weixin_ClientPlugin($this->curr_sid);
        switch (intval($order['o_status'])) {
            case App_Helper_OrderLevel::ORDER_HAD_PAY :
            case App_Helper_OrderLevel::ORDER_HAD_COMPLETE :
                for ($i=0; $i<4; $i++) {
                    $tmp    = "{$i}f";
                    if ($order["o_{$tmp}_id"]) {
                        $deduct = (float)$order["o_{$tmp}_deduct"];
                        $member_storage->incrementMemberAmount($order["o_{$tmp}_id"], -$payment, -$deduct);
                    } else {
                        break;
                    }
                }
                $send_text  = "会员{$order['o_buyer_nick']}的订单{$order['o_tid']} 申请退款，未能生效分享收入";
                for ($i=0; $i<4; $i++) {
                    $tmp    = "{$i}f";
                    if ($order["o_{$tmp}_id"]) {
                        $text = $send_text . $order["o_{$tmp}_deduct"]."元";
                        $f_member   = $member_storage->getRowById($order["o_{$tmp}_id"]);
                        $weixin_client->sendTextMessage($f_member['m_openid'], $text);
                    } else {
                        break;
                    }
                }
                break;
            case App_Helper_OrderLevel::ORDER_HAD_CLOSED :

                break;
        }
        $member_storage->incrementMemberTrade($order['o_m_id'], -$payment, -1);
        $this->_record_deduct_daybook($order);
        $updata = array(
            'o_update_time' => date('Y-m-d H:i:s', time()),
            'o_status'  => App_Helper_OrderLevel::ORDER_REFUND
        );
        $refundRet = $order_model->updateById($updata, $order['o_id']);
        
        if($refundRet){
            $refundResult = array(
                'ec' => 200,
                'em' => '退款成功'
            );
        }else{
            $refundResult['em'] = '退款失败';
        }
        $this->displayJson($refundResult);
    }

    
    private function _record_deduct_daybook($order) {
        if ($order['o_status'] != App_Helper_OrderLevel::ORDER_HAD_COMPLETE) {
            return;
        }

        $dd_storage     = new App_Model_Deduct_MysqlDeductDaybookStorage();
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        for ($i=0; $i<4; $i++) {
            $tmp    = "{$i}f";
            $deduct = (float)$order["o_{$tmp}_deduct"];
            if ($order["o_{$tmp}_id"] && $deduct > 0) {
                $indata = array(
                    'dd_s_id'       => $order['o_s_id'],
                    'dd_m_id'       => $order['o_m_id'],
                    'dd_o_id'       => $order['o_id'],
                    'dd_tid'        => $order['o_tid'],
                    'dd_amount'     => $deduct,
                    'dd_level'      => $i,
                    'dd_record_type'=> App_Helper_OrderLevel::DEDUCT_REFUND_PAY,//退款支出
                    'dd_record_time'=> time(),
                );
                $dd_storage->insertValue($indata);

                $member_storage->incrementMemberDeduct($order["o_{$tmp}_id"], -$deduct);
            }
        }
    }
    
    public function synOrderAction(){
        $result = array(
            'ec' => 400,
            'em' => '请求数据错误'
        );
        $tid = $this->request->getStrParam('tid');
        if($tid){
            $oauth_client   = new App_Plugin_Youzan_OauthClient($this->curr_sid);
            $ret = $oauth_client->getTradeOnly($tid);
            if($ret){
                $result = array(
                    'ec'    => 200,
                    'em'    => '同步完成'
                );
            }else{
                $result['em'] = '同步失败';
            }
        }
        $this->displayJson($result);
    }

    
    public function tradeListAction() {
        if(in_array($this->wxapp_cfg['ac_type'],[4,7,27])){
            $independent = 1;
        }else{
            $independent = 0;
        }
        $where_trade[] = $where_stat[] = ['name' => 't_independent_mall', 'oper' => '=', 'value' => $independent];
        $this->output['independent'] = $independent;
        $this->show_mall_trade_list_data($where_trade);
        $this->_get_offline_store(true);
        $this->_entershop_for_select(true);
        $this->_get_md_list_data();
        $this->output['print']  = plum_parse_config('type','print');
        $this->output['formAct']='/wxapp/order/tradeList';
        $this->output['tradePay'] =  App_Helper_Trade::$trade_pay_type;

        $where_stat[] = array('name'=>'t_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET );
        $this->output['todayTradeInfo'] = $this->_show_order_stat($where_stat,true);
        if(in_array($this->wxapp_cfg['ac_type'],[21])){
            $this->output['expressNote'] = 1;
        }

        $this->buildBreadcrumbs(array(
            array('title' => '订单管理', 'link' => '#'),
            array('title' => '商城订单', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/order/trade-list.tpl');
    }

    
    private function _get_md_list_data(){
        $where      = array();
        $where[]    = array('name' => 'os_s_id','oper' => '=','value' =>$this->curr_sid);
        $store_model    = new App_Model_Store_MysqlStoreStorage($this->curr_sid);
        $sort = array('os_create_time' => 'DESC');
        $list = $store_model->getList($where,0,0,$sort);
        $this->output['md_list'] = $list;
    }


    
    private function _entershop_for_select($all = false){
        $where[] = array('name'=>'es_s_id','oper'=>'=','value'=>$this->curr_sid);
        if(!$all){
            $where[] = array('name'=>'es_status','oper'=>'=','value'=>0);
        }


        $shop_model = new App_Model_Entershop_MysqlEnterShopStorage();
        $sort    = array('es_createtime' => 'DESC');
        $list    = $shop_model->getList($where,0,0,$sort);

        $data = array();
        $selectShop = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'   => $val['es_id'],
                    'name' => $val['es_name']
                );
                $selectShop[$val['es_id']] = $val['es_name'];
            }
        }
        $this->output['shoplist'] = json_encode($data);
        $this->output['selectShop'] = $selectShop;
    }


    
    public function refundListAction(){

        if(in_array($this->wxapp_cfg['ac_type'],[4,7,27])){
            $independent = 1;
        }else{
            $independent = 0;
        }

        $where      = array();
        $where[]    = array('name'=>'t_feedback','oper'=>'!=','value'=>0);
        $where[]    = array('name'=>'t_independent_mall','oper'=>'=','value'=>$independent);

        $showShopName = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[6,8])){
            $showShopName = 1;
        }
        $this->output['showShopName'] = $showShopName;

        $this->show_trade_list_data($where,0,1);
        $this->output['tradePay'] =  App_Helper_Trade::$trade_pay_type;
        $this->buildBreadcrumbs(array(
            array('title' => '订单管理', 'link' => '#'),
            array('title' => '维权订单', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/order/trade-refund-list.tpl');
    }

    
    public function tradeDetailAction($isActivity = '') {
        $this->output['tradePay'] = App_Helper_Trade::$trade_pay_type;
        $this->output['tradeType']= App_Helper_Trade::$trade_applet_type;
        if($isActivity){
            $this->output['isActivity'] = 1;
            switch ($isActivity){
                case 'group':
                    $group_controller = new App_Controller_Wxapp_GroupController();
                    $secondLink = $group_controller->secondLink('order',true);
                    break;
                case 'bargain':
                    $bargain_controller = new App_Controller_Wxapp_BargainController();
                    $secondLink = $bargain_controller->secondLink('order',true);
                    break;
            }
            $this->output['link']       = $secondLink['link'];
            $this->output['linkType']   = $secondLink['linkType'];
            $this->output['snTitle']    = $secondLink['snTitle'];
        }
        $this->show_trade_detail_data();

        if($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36){
            $url = '/wxapp/sequence/tradeList';
        }elseif ($this->wxapp_cfg['ac_type'] == 8){
            $url = '/wxapp/community/tradeList';
        }else{
            $url = '/wxapp/order/tradeList';
        }
        if(in_array($this->wxapp_cfg['ac_type'],[21])){
            $this->output['expressNote'] = 1;
        }

        $noExpress = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[32])){
            $noExpress = 1;
        }
        $this->output['noExpress'] = $noExpress;

        $this->buildBreadcrumbs(array(
            array('title' => '商城订单', 'link' => $url),
            array('title' => '订单详情', 'link' => '#'),
        ));
        $feie_model = new App_Model_Feie_MysqlFeieListStorage($this->curr_sid);
        $printlist = $feie_model->findListBySid();
        $this->output['printlist'] = $printlist;
        if($this->wxapp_cfg['ac_type'] == 27){
            $goodsName = '课程';
        }else{
            $goodsName = '商品';
        }
        $this->output['goodsName'] = $goodsName;


        $this->displaySmarty('wxapp/order/trade-detail.tpl');
    }
    
    private function show_trade_detail_data(){
        $tid = $this->request->getStrParam('order_no');
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $where      = array();
        $where[]    = array('name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]    = array('name'=>'t_tid','oper'=>'=','value'=>$tid);
        $list       = $trade_model->getAddressList($where,0,1,array());
        if(!empty($list) && isset($list[0])){
            $row = $list[0];
            $deduct_row = [];
            if(($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36) && $row['t_status'] == 6){
                $deduct_model = new App_Model_Sequence_MysqlSequenceDeductStorage($this->curr_sid);
                $deduct_row = $deduct_model->getRowByTidAction($row['t_tid'],$row['t_se_leader']);
            }
            $this->output['deduct_row'] = $deduct_row;

            $row['t_remark_extra'] = json_decode($row['t_remark_extra'], true);
            if($row['t_legwork_num'] > 0){
                if(date('Y-m-d',$row['t_pay_time']) == date('Y-m-d')){
                    $row['legworkNum'] = '今日 '.$row['t_legwork_num'].'号';
                }else{
                    $row['legworkNum'] = date('Y年m月d日').$row['t_legwork_num'].'号';
                }
            }

        $output['row']  = $row;
            $output['rowJson'] = json_encode($row);
            $express = array();
            $needSend= 0;
            if($row['t_status'] == App_Helper_Trade::TRADE_HAD_PAY){
                $express_model  = new App_Model_Trade_MysqlExpressStorage();
                $express        = $express_model->getExpressList(1);
                $needSend       = 1;
            }
            $output['needSend'] = $needSend;
            $output['express']  = $express;
            $coupon = array();
            if($row['t_discount_fee']){
                $trade_coupon_model = new App_Model_Trade_MysqlTradeCouponStorage($this->curr_sid);
                $coupon             = $trade_coupon_model->getListByTid($row['t_tid']);
            }
            $output['coupon']       = $coupon;
            $full   = array();
            if($row['t_promotion_fee']){
                $trade_full_model   = new App_Model_Trade_MysqlTradeFullStorage($this->curr_sid);
                $full               = $trade_full_model->getListByTid($row['t_tid']);
            }
            $output['full']         = $full;
            $trade_order        = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
            $order_list = $trade_order->getGoodsListByTid($row['t_id']);

            foreach ($order_list as $key => $order_row){
                $order_list[$key]['sendDate'] = $order_row['to_se_send_time'] ? date('Y-m-d',$order_row['to_se_send_time']) : ($row['t_se_send_time'] ? date('Y-m-d',$row['to_se_send_time']) : '');
            }

            $output['list']     = $order_list;
            
            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
            foreach ($output['list'] as $item){
                if($item['g_is_global']==1){
                    $output['member'] = $member_storage->getRowById($row['t_m_id']);
                    break;
                }
            }

            $this->_trade_detail_status_desc($row);
            $output['statusNote'] = plum_parse_config('trade_status');
            $output['legworkStatusNote'] = App_Helper_Legwork::$trade_status_note;
            $this->express_detail_new($row['t_express_code']);

            $this->showOutput($output);
        }else{
            plum_url_location('订单号错误');
        }
    }

    
    private function express_detail_new($code){
        $aliyun_storage = new App_Plugin_Aliyun_Apiset();
        $result = $aliyun_storage->queryExpressData($code);
        $data = array();
        if(!$result['errcode']){
            $status = $result['deliverystatus'];
            $statusNote = array(
                1 => '[在途中]',
                2 => '[正在派件]',
                3 => '[已签收]',
                4 => '[派送失败]',
            );
            $nowStatus = $statusNote[$status] ? $statusNote[$status] : '[在途中]';
            if($result['result']['list']){
                foreach ($result['result']['list'] as $val){
                    $data[] = array(
                        'AcceptTime' => $val['time'],
                        'AcceptStation' => $val['status'],
                    );
                }
            }
            $nowStatus = $data[count($data)-1]['AcceptTime'].' '.$nowStatus.' '. $data[count($data)-1]['AcceptStation'];
            $this->output['nowStatus']  = $nowStatus;
            $this->output['last']       = count($data)-1;
            $this->output['track']      = $data;
        }
    }

    private function _trade_detail_status_desc($row){
        $desc = array();
        switch($row['t_status']){
            case App_Helper_Trade::TRADE_NO_PAY:
                $desc = array(
                    'icon'      => '!',
                    'class'     => 'primary',
                    'desc'      => '<div>等待买家付款款</div>'
                );
                break;
            case App_Helper_Trade::TRADE_HAD_PAY:
                if(App_Helper_Trade::TRADE_PAY_WXZFZY == $row['t_pay_type']){
                    $account = '<div>买家已将货款支付至您的 微信对公账户，请到<a href="http://pay.weixin.qq.com" target="_blank">微信商户平台</a>查收。</div>';
                }elseif(App_Helper_Trade::TRADE_PAY_HDFK == $row['t_pay_type']){
                    $account = '该订单为 货到付款订单 ';
                }else{
                }
                $desc = array(
                    'icon'      => '!',
                    'class'     => 'primary',
                    'desc'      => $account
                );
                break;
            case App_Helper_Trade::TRADE_SHIP:
                if($row['t_express_method'] == 7){
                    $desc = array(
                        'icon'      => '!',
                        'class'     => 'primary',
                        'desc'      => '<div>骑手已接单，等待骑手取货</div>'
                    );
                }else{
                    $desc = array(
                        'icon'      => '!',
                        'class'     => 'primary',
                        'desc'      => '<div>已发货、等待用户确认收货。</div>'
                    );
                }
                break;
            case App_Helper_Trade::TRADE_ACCEPT:
                if($row['t_express_method'] == 7){
                    $desc = array(
                        'icon'      => '!',
                        'class'     => 'primary',
                        'desc'      => '<div>骑手已取货</div>'
                    );
                }
                break;
            case App_Helper_Trade::TRADE_FINISH:
                $desc = array(
                    'icon'      => '√',
                    'class'     => 'success',
                    'desc'      => '<div>用户已确认收货，订单已经完成。</div>'
                );
                break;
            case App_Helper_Trade::TRADE_CLOSED:
                $desc = array(
                    'icon'      => 'X',
                    'class'     => 'danger',
                    'desc'      => '<div>订单已关闭。</div>'
                );
                break;
            case App_Helper_Trade::TRADE_REFUND:
                $desc = array(
                    'icon'      => 'X',
                    'class'     => 'danger',
                    'desc'      => '<div>退款订单。</div>'
                );
                break;
        }
        $this->output['desc'] = $desc;
    }

    private function express_detail($code,$num){
        $data = array();
        $nowStatus = '';
        if($code && $num){
            $track_model = new App_Helper_ExpressTrack();
            $track = $track_model->fetchJsonTrack($code,$num);
            if(!empty($track) && $track['Success']){
                $data = $track['Traces'];
                switch ($track['State']){
                    case 2 :
                        $status = '[在途中]';
                        break;
                    case 3 :
                        $status = '[签收]';
                        break;
                    case 4 :
                        $status = '[问题件]';
                        break;
                    default:
                        $status = '[在途中]';
                        break;
                }
                $nowStatus = $data[count($data)-1]['AcceptTime'].' '.$status.' '. $data[count($data)-1]['AcceptStation'];
            }
        }

        $this->output['nowStatus']  = $nowStatus;
        $this->output['last']       = count($data)-1;
        $this->output['track']      = $data;
    }

    
    public function expressTradeAction(){
        $tid     = $this->request->getStrParam('tid');
        $code    = $this->request->getStrParam('code');
        $company = $this->request->getStrParam('company');
        $express = $this->request->getStrParam('express');
        $need    = $this->request->getIntParam('need');
        $expressNote = $this->request->getStrParam('expressNote','');
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $trade = $trade_model->findUpdateTradeByTid($tid);
        if($trade['t_express_method'] == 2){
            $this->displayJsonError('门店自提订单，无需发货');
        }
        $trade_helper   = new App_Helper_Trade($this->curr_sid);
        $ret = $trade_helper->orderDeliverUpdateTrade($tid,$company,$code,$need,$express,$expressNote);
        plum_open_backend('index', 'updateOrder', array('sid' => $this->curr_sid, 'tid' => $tid));

        App_Helper_OperateLog::saveOperateLog("发货订单【".$tid."】");

        $this->showAjaxResult($ret,'发货');
    }

    
    public function deductAction(){
        $tid    = $this->request->getStrParam('tid');
        $deduct_model = new App_Model_Shop_MysqlOrderDeductStorage($this->curr_sid);
        $list   = $deduct_model->findOrderDeductListByTid($tid);
        if(!empty($list)){
            $data   = array(
                'ec'        => 200,
                'list'      => $list,
                'member'    => array(),
                'goods'     => array(),
            );
            $mids   = array();
            $goids  = array();
            foreach($list as $val){
                for($i=0;$i<=3;$i++){
                    if($val['od_'.$i.'f_id'] > 0) $mids[] = $val['od_'.$i.'f_id'];
                }
                if($val['od_g_id']) $goids[] = $val['od_g_id'];
            }
            if(!empty($mids)){
                $mwhere     = array();
                $mwhere[]     = array('name' => 'm_id', 'oper' => 'in', 'value' => $mids);
                $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                $member       = $member_model->getList($mwhere,0,0);
                foreach($member as $mal){
                    $data['member'][$mal['m_id']] = $mal['m_nickname'];
                }
            }
            if(!empty($goids)){
                $gowhere     = array();
                $gowhere[]   = array('name' => 'g_id', 'oper' => 'in', 'value' => $goids);
                $goods_model = new App_Model_Goods_MysqlGoodsStorage();
                $goods       = $goods_model->getList($gowhere,0,0);
                foreach($goods as $gal){
                    $data['goods'][$gal['g_id']] = $gal['g_name'];
                }
            }
        }else{
            $data   = array(
                'ec' => 400,
                'em' => '该订单尚未产生分销',
            );
        }
        $this->displayJson($data);
    }

    
    public function tradeRefundAction($isActivity = ''){
        $tradeType = $this->request->getStrParam('tradeType');
         if($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36){
            $url = '/wxapp/sequence/tradeList';
        }elseif($this->wxapp_cfg['ac_type'] == 13){
            $url = '/wxapp/cake/tradeList';
        }elseif($tradeType == 'appo'){
            $url = '/wxapp/appointment/tradeList';
        }else{
            $url = '/wxapp/order/tradeList';
        }
        if($isActivity){
            $this->output['isActivity'] = 1;
            switch ($isActivity){
                case 'bargain':
                    $bargain_controller = new App_Controller_Wxapp_BargainController();
                    $secondLink = $bargain_controller->secondLink('order',true);
                    break;
                case 'appo':
                    $appo_controller = new App_Controller_Wxapp_AppointmentController();
                    $secondLink = $appo_controller->secondLink('tradeList',true);
                    break;
            }
            $this->output['link']       = $secondLink['link'];
            $this->output['linkType']   = $secondLink['linkType'];
            $this->output['snTitle']    = $secondLink['snTitle'];
        }

        $this->show_trade_refund_detail();
        $this->output['option'] = array(
            'refuse' => App_Helper_Trade::FEEDBACK_RESULT_REFUSE ,
            'agree'  => App_Helper_Trade::FEEDBACK_RESULT_AGREE ,
        );
        $this->output['refundStatus'] = array(
            App_Helper_Trade::FEEDBACK_RESULT_REFUSE => '拒绝',
            App_Helper_Trade::FEEDBACK_RESULT_AGREE  => '同意',
        );
        $this->buildBreadcrumbs(array(
            array('title' => '商城订单', 'link' => $url),
            array('title' => '订单维权', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/order/trade-refund.tpl');
    }

    
    private function show_trade_refund_detail()
    {
        $tid = $this->request->getStrParam('order_no');
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $where = array();
        $where[] = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 't_tid', 'oper' => '=', 'value' => $tid);
        $where[] = array('name' => 't_feedback', 'oper' => 'in', 'value' => array(1, 2));
        $row = $trade_model->getRow($where);
        if (!empty($row)) {
            $redis_model        = new App_Model_Trade_RedisTradeStorage($this->curr_sid);
            $endTime            = $redis_model->getTradeRefundTtl($row['t_id']);
            $output['endTime']  = $endTime;
            $trade_order        = new App_Model_Trade_MysqlTradeRefundStorage($this->curr_sid);
            $refundList = $trade_order->getAllRecord($row['t_tid']);
            $output['refundList'] = $refundList;
            $output['refund']  = $refundList[0];
            $order_model=new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
            $refund_order_list=[];

            foreach ($refundList as $key => $value) {
                if($value['tr_to_id'] && $value['tr_status']==0){
                    $order_info=$order_model->getRowById($value['tr_to_id']);
                    $endTime            = $redis_model->getTradeOrderRefundTtl($value['tr_to_id']);
                    $order_temp=[
                        't_title'     =>$order_info['to_title'],
                        't_pic'       =>$order_info['to_pic'],
                        'tr_reason'   =>$value['tr_reason'],
                        'status'      =>$order_info['to_fd_status'],
                        'tr_wid'      =>$value['tr_wid'],
                        'tr_money'    =>$value['tr_money'],
                        'to_id'       =>$value['tr_to_id'],
                        'to_fd_status'=>$order_info['to_fd_status'],
                        'canAgree'    =>(($order_info['to_feedback'] == 1 && $order_info['to_fd_status'] == 1 ) || ($order_info['to_feedback'] == 2 && $order_info['to_fd_result'] == 1 ) && $output['alert']['errno'] == 0) ? 1 : 0,
                        'canRefuse'   =>($order_info['to_feedback'] == 1 && $order_info['to_fd_status'] == 1 ) ? 1 : 0,
                        'endTime'    =>$endTime,
                    ];
                    $refund_order_list[$value['tr_to_id']]=$order_temp;
                }
            }
            $this->output['refund_order_list']=$refund_order_list;
            $helper_model       = new App_Helper_Trade($this->curr_sid);
            $output['alert']    = $helper_model->checkAppletTradeRefund($output['row']['t_pay_type'],$output['refund']['tr_money']);
            $output['canAgree']   = (($row['t_feedback'] == 1 && $row['t_fd_status'] == 1 ) || ($row['t_feedback'] == 2 && $row['t_fd_result'] == 1 ) && $output['alert']['errno'] == 0) ? 1 : 0;
            $output['canRefuse']   = ($row['t_feedback'] == 1 && $row['t_fd_status'] == 1 ) ? 1 : 0;

            $output['statusNote'] = plum_parse_config('trade_status');
            $output['refundNote'] = plum_parse_config('refund_status');
            $output['tradePay']   = App_Helper_Trade::$trade_pay_type;
            $output['row']      = $row;
            $this->showOutput($output);
        } else {
            plum_url_location('订单号错误');
        }
    }

    
    public function refundTradeAction()
    {
        $result = array(
            'ec' => 400,
            'em' => '订单状态错误'
        );
        $tid  = $this->request->getStrParam('tid');
        $toid =$this->request->getStrParam('toid',0);
        $status = $this->request->getIntParam('status');
        $note = $this->request->getStrParam('note','后台处理用户退款');
        $group  = $this->request->getIntParam('group');

        if($this->wxapp_cfg['ac_type'] == 21){
            $manager = $this->manager;
        }else{
            $manager = [];
        }

        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $trade = $trade_model->findUpdateTradeByTid($tid);
        if($tid && in_array($status,array(1,2)) && $trade['t_fd_status'] != 3){
            if($group){
                $ret = $this->_refund_data($tid);
                if(!empty($ret)){
                    $refund=1;
                    $result = array(
                        'ec' => 200,
                        'em' => '退款处理成功'
                    );
                }
            }else{
                if($this->curr_shop['s_accountant_refund'] == 1 && $status == 2 && ($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36)){
                    $accountant_model = new App_Model_Accountant_MysqlAccountantConfirmStorage($this->curr_sid);
                    $exist_where=[
                        ['name'=>'aac_s_id','oper'=>'=','value'=>$this->curr_sid],
                        ['name'=>'aac_confirm_id','oper'=>'=','value'=>$trade['t_id']], 
                    ];
                    if($toid)
                        $exist_where[]=['name'=>'aac_confirm_to_id','oper'=>'=','value'=>$toid];
                    $is_exist_account_record=$accountant_model->getCount($exist_where);
   
                    if($is_exist_account_record)
                        $this->displayJsonError('当前退款已提交至会计审核中心，请勿重复提交！');
                    $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                    $member = $member_model->getMemberLeaderRow($trade['t_m_id']);
                    $trade_order        = new App_Model_Trade_MysqlTradeRefundStorage($this->curr_sid);
                    $refundList = $trade_order->getAllRecord($tid,$toid);
                    $refund = $refundList[0];
                    if($toid){
                        $trade_order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
                        $order = $trade_order_model->getRowById($toid);
                        $title=$order['to_title'];
                    }else{
                        $title='';
                    }
                    
                    $confirm = [
                        'aac_s_id' => $this->curr_sid,
                        'aac_manager_id' => $this->manager['m_id'],
                        'aac_manager_name' => $this->manager['m_nickname'],
                        'aac_confirm_id' => $trade['t_id'],
                        'aac_confirm_tid' => $tid,
                        'aac_confirm_to_id' =>$refund['tr_to_id'],
                        'aac_confirm_to_name'=>$title,
                        'aac_type' => 2,//订单退款
                        'aac_nickname' => $member['m_nickname'],
                        'aac_realname' => '',
                        'aac_avatar'   => $member['m_avatar'],
                        'aac_member_type' => $member['asl_status'] == 2 ? 2 : 1,
                        'aac_money' => $refund['tr_money'],
                        'aac_pay_type' => $trade['t_pay_type'],
                        'aac_handle_status' => 1,
                        'aac_handle_remark' => $note,
                        'aac_create_time' => time()
                    ];
                    $res = $accountant_model->insertValue($confirm);
                    if($res){
                        $result = [
                            'ec' => 200,
                            'em' => '处理已提交，请等待会计审核'
                        ];
                        $set_trade = [
                            't_fd_status' => 4
                        ];
                        $trade_model->updateById($set_trade,$trade['t_id']);
                    }
                }else{
                    $trade_helper = new App_Helper_Trade($this->curr_sid);
                    $result = $trade_helper->appletHandleRefund($tid,$status,$note,2,$manager,$toid);
                }
                App_Helper_OperateLog::saveOperateLog("退款订单【".$tid."】");
            }
        }
        $this->displayJson($result);
    }

    
    public function activeRefundAction(){


        $tid = $this->request->getStrParam('tid');
        $group = $this->request->getIntParam('group');
        $custom = $this->request->getIntParam('custom');
        $currRefund = $this->request->getFloatParam('curr_refund');
        $refund_reason = $this->request->getIntParam('refund_reason');
        $refund_note = $this->request->getIntParam('refund_note');
        $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $area_info=$this->get_area_manager();
        if($area_info){
            $trade      = $trade_model->findTradeByTidInRegion($tid,$area_info['m_area_id'],$area_info['m_area_type']);
        }else{
            $trade      = $trade_model->findUpdateTradeByTid($tid);
        }


        if($this->curr_shop['s_accountant_refund'] == 1 && ($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36)){
            $accountant_model = new App_Model_Accountant_MysqlAccountantConfirmStorage($this->curr_sid);
            $exist = $accountant_model->getRowByTypeId(2,$trade['t_id']);
            if($exist){
                if($exist['aac_handle_status'] == 1){
                    $this->displayJsonError('退款申请已经提交，请等待会计审核');
                }
                if($exist['aac_handle_status'] == 2){
                    $this->displayJsonError('退款申请已审核通过，请勿重复提交');
                }
            }
        }

        if($currRefund > ($trade['t_payment'] + $trade['t_coin_payment'])){
            $this->displayJsonError('退款金额不能大于实付金额');
        }
        $customMoney = 0;
        if($custom && $currRefund > 0){
            $customMoney = $currRefund;
        }else{
            $customMoney = $trade['t_payment'] + $trade['t_coin_payment'];
        }

        $active_refund_reason = '';
        if($refund_reason > 0){
            $reason_cfg = plum_parse_config('active_refund_reason');
            $active_refund_reason = $reason_cfg[$refund_reason];
        }elseif ($refund_reason < 0){
            $active_refund_reason = $refund_note ? $refund_note : '其它';
        }
        $curr_reason = $active_refund_reason ? $active_refund_reason :'系统自动退款';
        if($trade && $trade['t_fd_status'] != 3 && ($trade['t_status']==2 || $trade['t_status']==3 || $trade['t_status']==4 || ($trade['t_status'] == 5 && $trade['t_express_method'] == 7))){
            if($group){
                $ret = $this->_refund_data($tid,$customMoney);
                if(!empty($ret)){
                    $refund=1;
                    $result = array(
                        'ec' => 200,
                        'em' => '退款处理成功'
                    );
                    $this->displayJson($result);
                }else{
                    $this->displayJsonError('退款处理失败');
                }
            }else{
                $result = array(
                    'ec' => 400,
                    'em' => '退款处理失败'
                );
                $refund_model   = new App_Model_Trade_MysqlTradeRefundStorage($this->curr_sid);
                $has_refund_trade=$refund_model->getRowTid($tid);
                if($has_refund_trade && $has_refund_trade['tr_status']==0){
                    $this->displayJsonError('当前订单存在未处理的用户退款申请，请优先进行处理');
                }

                if($this->curr_shop['s_accountant_refund'] == 1 && ($this->wxapp_cfg['ac_type'] == 32  || $this->wxapp_cfg['ac_type'] == 36)){
                   
                    $indata     = array(
                        'tr_s_id'       => $this->curr_sid,
                        'tr_wid'        => App_Plugin_Weixin_PayPlugin::makeMchOrderid('W'),
                        'tr_tid'        => $tid,
                        'tr_reason'     => $curr_reason,//退款原因
                        'tr_money'      => $customMoney > 0 ? $customMoney : $trade['t_payment'] + $trade['t_coin_payment'],
                        'tr_create_time'=> time(),
                        'tr_status'     => 0,//退款待处理
                    );
                    $ret = $refund_model->insertValue($indata);
                    $accountant_model = new App_Model_Accountant_MysqlAccountantConfirmStorage($this->curr_sid);
                    $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
                    $trade = $trade_model->findUpdateTradeByTid($tid);
                    $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                    $member = $member_model->getMemberLeaderRow($trade['t_m_id']);
                    $trade_order        = new App_Model_Trade_MysqlTradeRefundStorage($this->curr_sid);
                    $refundList = $trade_order->getAllRecord($tid);
                    $refund = $refundList[0];

                    $confirm = [
                        'aac_s_id' => $this->curr_sid,
                        'aac_manager_id' => $this->manager['m_id'],
                        'aac_manager_name' => $this->manager['m_nickname'],
                        'aac_confirm_id' => $trade['t_id'],
                        'aac_confirm_tid' => $tid,
                        'aac_confirm_remark' => $active_refund_reason,
                        'aac_type' => 2,//订单退款
                        'aac_nickname' => $member['m_nickname'],
                        'aac_realname' => '',
                        'aac_avatar'   => $member['m_avatar'],
                        'aac_member_type' => $member['asl_status'] == 2 ? 2 : 1,
                        'aac_money' => $refund['tr_money'],
                        'aac_pay_type' => $trade['t_pay_type'],
                        'aac_handle_status' => 1,
                        'aac_handle_remark' => '',
                        'aac_create_time' => time()
                    ];
                    $res = $accountant_model->insertValue($confirm);
                    if($res){
                        $result = [
                            'ec' => 200,
                            'em' => '处理已提交，请等待会计审核'
                        ];
                        $set_trade = [
                            't_fd_status' => 4
                        ];
                        $trade_model->updateById($set_trade,$trade['t_id']);
                    }
                }else{
                    $trade_helper = new App_Helper_Trade($this->curr_sid);

                    if($this->wxapp_cfg['ac_type'] == 21){
                        $manager = $this->manager;
                    }else{
                        $manager = [];
                    }
                    $source = 2;
                    if($this->curr_sid==7449){
                        $source = 1;
                    }
                    $result = $trade_helper->appletHandleRefund($tid,2,$curr_reason,$source,$manager,0,$customMoney);
                }
                App_Helper_OperateLog::saveOperateLog("退款订单【".$tid."】");

                $this->displayJson($result);
            }
        }else{
            $this->displayJsonError('订单状态错误');
        }
    }


    
    private function _refund_data($tid,$customMoney = 0){
        $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $trade      = $trade_model->findUpdateTradeByTid($tid);
        if($trade){
            $refund_model   = new App_Model_Trade_MysqlTradeRefundStorage($this->curr_sid);
            $indata     = array(
                'tr_s_id'       => $this->curr_sid,
                'tr_wid'        => App_Plugin_Weixin_PayPlugin::makeMchOrderid('W'),
                'tr_tid'        => $tid,
                'tr_reason'     => '组团失败,系统自动退款',//退款原因
                'tr_money'      => $customMoney > 0 ? $customMoney : $trade['t_total_fee'],
                'tr_create_time'=> time(),
                'tr_status'     => 0,//退款已处理
            );
            $ret = $refund_model->insertValue($indata);
            if($ret){
                $where      = array();
                $mem_model  = new App_Model_Group_MysqlMemStorage($this->curr_sid);
                $where[]    = array('name'=>'gm_s_id','oper'=>'=','value'=>$this->curr_sid);
                $where[]    = array('name'=>'gm_tid','oper'=>'=','value'=>$tid);
                $where[]    = array('name'=>'gm_is_robot','oper'=>'=','value'=>0);
                $list       = $mem_model->getMemOrgList($where,0,0);
                $trade_helper      = new App_Helper_Trade($this->curr_sid);
                $group_helper      = new App_Helper_Group($this->curr_sid);
                $ids        = array();
                $org_model  = new App_Model_Group_MysqlOrgStorage($this->curr_sid);
                foreach($list as $val){
                    $set = array('go_status' => 2);
                    $org_model->updateById($set, $val['gm_go_id']);
                    $ret = $trade_helper->dealRefund($val['gm_tid'],'tid');
                    if(!$ret['errcode']){
                        $ids[] = $val['gm_id'];
                    }
                    $group_helper->refundNoticeMsgAction($val['gm_tid']);
                }
                if(!empty($ids)){
                    $mem_model->updateHadRefund($ids);
                }
                return $ids;
            }
        }
    }


    private function trade_tips($row){
        $data = array();
        if($row['t_pay_type'] == App_Helper_Trade::TRADE_PAY_WXZFZY){
            switch($row['t_status']){
                case App_Helper_Trade::TRADE_HAD_PAY:
                    $data['statusNote'] = '买家已付款至天店通待结算账户，请尽快发货，否则买家有权申请退款';
                    break;

            }
        }

    }

    
    public function deliverAction() {
        $uploader   = new Libs_File_Transfer_Uploader('document|deliver');
        $ret = $uploader->receiveFile('order_deliver');
        $ext = substr(strrchr($ret['order_deliver'], '.'), 1);
      
        if($ret){ 
            $url = DRUPAL_ROOT.$ret['order_deliver'];
            $file=$this->readUseExcel($url,$ext);

            $num = $this->_batch_order_deliver($file);
 
            if($num && $num['success']>0){
                $this->displayJsonSuccess($num);
            }else{
                $this->displayJsonError('批量发货失败，请检查订单信息');
            }
        }else{
            $this->displayJsonError('上传文件类型有误请重试');
        }

    }
    
    private function readUseCsv($url,$ext){
        if($ext!='csv')
            $this->displayJsonError('上传文件类型有误请重试');
        $file_source = fopen($url,'r');
        $file='';
        if(gettype($file_source)=='resource'){
            while (!feof($file_source)) {
                $file.= fread($file_source,1024);
            }
        }
        $pattern="/[+-]?[\d]+([\.][\d]*)?([Ee][+-]?[0-9]{0,2})/";
        if(preg_match($pattern,$file)){
            $this->displayJsonError('请去除掉表格中的科学计数后再重新上传');
        }
        $file_encode=mb_detect_encoding($file,['ASCII','GBK','UTF-8']);
        if($file_encode!='UTF-8')
            $file=iconv($file_encode,'utf-8',$file);
        $file = explode("\n",$file);
        array_shift($file);
        array_pop($file);
        return $file;
    }
    
    private function readUseExcel($url,$ext){
        if($ext!='xls')
            $this->displayJsonError('请上传xls格式的文件');
        require_once(PLUM_APP_PLUGIN.'/phpexcel/PHPExcel/IOFactory.php');
        $excel_model=PHPExcel_IOFactory::load($url);
        $sheet_count=$excel_model->getSheetCount();
        for ($i=0; $i < $sheet_count; $i++) { 
            $sheet_data=$excel_model->getSheet($i)->toArray();
        }
        $temp_str=json_encode($sheet_data,JSON_UNESCAPED_UNICODE);

        $pattern="/[+-]?[\d]+([\.][\d]*)?([Ee][+-]?[0-9]{0,2})/";
        if(preg_match($pattern,$temp_str)){
            $this->displayJsonError('请去除掉表格中的科学计数后再重新上传');
        }
        array_shift($sheet_data);
        return $sheet_data;
    }

    

    public function _batch_order_deliver($data){
        $num = array(
            'success' => 0,
            'error'   => 0,
        );
        if($data && !empty($data)){
            foreach($data as $val){
                if(is_array($val))
                    $info=$val;
                else
                    $info = explode(',',$val);
                $tid = $info[0];
                $company = $info[1];
                $code = $info[2];
                $trade_helper   = new App_Helper_Trade($this->curr_sid);
                $ret = $trade_helper->orderDeliverUpdateTrade($tid,$company,$code,1);
                if($ret){
                    $num['success']+=1;
                }else{
                    $num['error']+=1;
                }
            }
        }
        return $num;

    }

    
    public function groupSynchronAction(){
        $res = array(
            'ec' => 400,
            'em' => '处理失败'
        );
        $goId = $this->request->getIntParam('goid');
        if($goId){
            $group_help = new App_Helper_Group($this->curr_sid);
            $ret = $group_help->groupOrgOvertime($goId);
            if($ret){
                $res = array(
                    'ec' => 200,
                    'em' => '处理成功'
                );
                App_Helper_OperateLog::saveOperateLog("手动同步拼团状态成功");
            }
        }
        $this->displayJson($res);
    }

    
    public function expressSynchronAction(){
        $res = array(
            'ec' => 400,
            'em' => '同步失败'
        );
        $tid = $this->request->getIntParam('tid');
        if($tid){
            $trade_help = new App_Helper_Trade($this->curr_sid);
            $ret = $trade_help->completeOvertimeTrade($tid);
            if($ret){
                $res = array(
                    'ec' => 200,
                    'em' => '同步成功'
                );
                App_Helper_OperateLog::saveOperateLog("订单【{$tid}】手动同步状态成功");
            }
        }
        $this->displayJson($res);
    }

    
    public function orderSynchronAction(){
        $res = array(
            'ec' => 400,
            'em' => '同步失败'
        );
        $tid = $this->request->getStrParam('tid');
        if($tid){
            $trade_model= new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
            $trade      = $trade_model->findUpdateTradeByTid($tid);

            $trade_helper   = new App_Helper_Trade($this->curr_sid);
            $ret = $trade_helper->dealTradeType($trade);
            if($ret){
                $res = array(
                    'ec' => 200,
                    'em' => '同步成功'
                );
                App_Helper_OperateLog::saveOperateLog("订单【{$tid}】手动同步状态成功");
            }
        }
        $this->displayJson($res);
    }



    

    public function microOrderSynchronAction(){
        $result = array(
            'ec' => 400,
            'em' => '请求数据错误'
        );
        $tid = $this->request->getStrParam('tid');
        $wd_client      = new App_Plugin_Weidian_Client($this->curr_sid);
        $detail     = $wd_client->getOrderDetail($tid);
        if ($detail) {
            $status = $detail['status'];
            switch ($status) {
                case 'unpay' :
                    $curr_status    = App_Helper_OrderLevel::ORDER_NO_PAY;
                    break;
                case 'pay' :
                case 'ship' :
                    $curr_status    = App_Helper_OrderLevel::ORDER_HAD_PAY;
                    break;
                case 'accept' :
                case 'finish' :
                    $curr_status    = App_Helper_OrderLevel::ORDER_HAD_COMPLETE;
                    break;
                case 'close' :
                    $curr_status    = App_Helper_OrderLevel::ORDER_HAD_CLOSED;
                    break;
                case 'seller_refund' :
                    $curr_status    = App_Helper_OrderLevel::ORDER_REFUND;
                    break;
                default :
                    $curr_status    = 0;
                    break;
            }
            if ($curr_status) {
                $order_level    = new App_Helper_OrderLevel($this->curr_sid);
                $ret = $order_level->weidianOrderUpdateDeal($detail, $curr_status);
                Libs_Log_Logger::outputConsoleLog("订单{$detail['trade_no']}已处理完成");
                if($ret){
                    $result = array(
                        'ec' => 200,
                        'em' => '同步成功'
                    );
                    App_Helper_OperateLog::saveOperateLog("订单【{$tid}】手动同步状态成功");
                }else{
                    $result = array(
                        'ec' => 400,
                        'em' => '同步失败'
                    );
                }
            }
        }
        $this->displayJson($result);
    }


    
    public function editPriceAction(){
        $tid   = $this->request->getStrParam('tid');
        $price = $this->request->getFloatParam('price');

        if($price < 0){
            $this->displayJsonError('价格不能低于0');
        }

        $trade_model= new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $data = array(
            't_total_fee' => $price,
            't_tid_spare' => $tid.rand(1000,9999)
        );
        $ret      = $trade_model->findUpdateTradeByTid($tid, $data);
        if($ret && $price == 0){
            $trade = $trade_model->findUpdateTradeByTid($tid);
            $this->_wx_pay_notify($trade);
            sleep(1);
            App_Helper_OperateLog::saveOperateLog("订单【{$tid}】手动修改价格【{$price}】成功");
        }
        $this->showAjaxResult($ret);
    }

    private function _wx_pay_notify($trade){
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $tid = $trade['t_tid'];
        if($trade['t_applet_type']==App_Helper_Trade::TRADE_ORDER_MEETING){
            $order_model      = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
            $where = array();
            $where[]          = array('name' => 'to_t_id', 'oper' => '=', 'value' => $trade['t_id']);
            $where[]          = array('name' => 'to_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $order            = $order_model->getRow($where);
            $ticket_storage   = new App_Model_Meeting_MysqlMeetingTicketStorage($this->curr_sid);
            $ticket           = $ticket_storage->getRowById($order['to_gf_id']);
            $set=array('amt_buy_num'=>$ticket['amt_buy_num']+1);
            $ticket_storage->updateById($set,$ticket['amt_id']);
        }
        if(json_decode($trade['t_extra_data'],true)['type'] == 'meal' && $trade['t_home_id'] > 0){
            $table_model = new App_Model_Meal_MysqlMealTableStorage($this->curr_sid);
            $where_meal[] = array('name'=>'amt_id','oper'=>'=','value'=>$trade['t_home_id']);
            $where_meal[] = array('name'=>'amt_s_id','oper'=>'=','value'=>$this->curr_sid);
            $row_meal = $table_model->getRow($where_meal);
            if(!$row_meal['amt_use']){
                $set_meal = array(
                    'amt_use' => 1,
                );
                $table_model->updateValue($set_meal,$where_meal);
            }
            $meal_end = $trade['t_meal_type'] == 2 ? 1 : 0;
        }
        $updata = array(
            't_pay_type'        => $trade['t_pay_type'] == App_Helper_Trade::TRADE_PAY_HHZF?App_Helper_Trade::TRADE_PAY_HHZF:App_Helper_Trade::TRADE_PAY_WXZFZY,
            't_status'          => App_Helper_Trade::TRADE_WAIT_PAY_RETURN,
            't_pay_time'        => time(),
            't_meal_end'        => isset($meal_end) ? 1 : 0,
            't_payment'         => 0,
        );
        $trade_model->findUpdateTradeByTid($tid, $updata);
        if($trade['t_es_id']>0){
            $trade_helper   = new App_Helper_Trade($this->curr_sid);
            if($trade['t_express_method'] == 4 || $trade['t_express_method'] == 5){//平台配送, 蜂鸟配送，跑腿配送，减去配送费
                $trade['t_total_fee'] = $trade['t_total_fee'] - $trade['t_post_fee'];
            }
            if($trade['t_express_method'] == 7){
                $legworkExtra = json_decode($trade['t_legwork_extra'],1);
                if(isset($legworkExtra['price']) && $legworkExtra['price'] > 0){
                    $trade['t_total_fee'] = $trade['t_total_fee'] - $legworkExtra['price'];
                }
            }
            $trade_helper->recordPendingSettled($tid, $trade['t_total_fee'], $trade['t_title'], $trade['t_es_id']);
        }
        plum_open_backend('index', 'tradeBack', array('sid' => $this->curr_sid, 'tid' => $tid));
        plum_open_backend('index', 'wxappTempl', array('sid' => $this->curr_sid, 'tid' => $tid, 'type' => App_Helper_WxappApplet::SEND_SETUP_ZFCG));
    }


    
    public function finishOrderAction($tid = 0,$sid = 0,$display = true,$call = false,$other_shop = []){
        $result = array(
            'ec' => 400,
            'em' => '请求数据错误'
        );
        $tid    = $tid ? $tid : $this->request->getStrParam('tid');
        $this->curr_sid = $sid ? $sid : $this->curr_sid;
        $this->curr_shop = $other_shop ? $other_shop : $this->curr_shop;
        $trade_model= new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $trade      = $trade_model->findUpdateTradeByTid($tid);
        if($trade){
            if($trade['t_fd_status'] > 0 && $trade['t_fd_status'] != 3){
                $this->displayJsonError('该订单有未完成的退款处理');
            }
            if($trade['t_status'] == App_Helper_Trade::TRADE_SHIP || $trade['t_status'] == App_Helper_Trade::TRADE_HAD_PAY || ($trade['t_express_method'] == 7 && $trade['t_status'] == App_Helper_Legwork::TRADE_HAD_GET)){

                $updata = array(
                    't_finish_time' => time(),
                    't_status'      => App_Helper_Trade::TRADE_FINISH,//置于完成状态
                );

                if(in_array($this->wxapp_cfg['ac_type'],[21,6]) && $call == false){
                    $updata['t_manager_id'] = $this->manager['m_id'];
                    $updata['t_manager_name'] = $this->manager['m_nickname'];
                }
                if($call == false){
                    $updata['t_finish_manager'] = $this->manager['m_nickname'];
                }

                $trade_helper   = new App_Helper_Trade($this->curr_sid);
                $trade_redis    = new App_Model_Trade_RedisTradeStorage($this->curr_sid);
                $trade_redis->delTradeFinish($trade['t_id']);
                $settled_model  = new App_Model_Trade_MysqlTradeSettledStorage($this->curr_sid);
                $settled        = $settled_model->findSettledByTid($tid);


                if ($settled && $settled['ts_status'] == App_Helper_Trade::TRADE_SETTLED_PENDING) {
                    $set = array('ts_order_finish_time' => time());
                    $settled_model->updateById($set, $settled['ts_id']);
                    if($this->curr_shop['s_enter_settle'] > 0) {

                        $countdown = plum_parse_config('trade_overtime');
                        $trade_redis = new App_Model_Trade_RedisTradeStorage($this->curr_sid);
                        $trade_redis->setTradeSettledTtl($settled['ts_id'], $this->curr_shop['s_enter_settle'] ? $this->curr_shop['s_enter_settle'] * 24 * 60 * 60 : $countdown['settled']);
                    }else{

                        $trade_redis->delTradeSettledTtl($settled['ts_id']);
                        if($trade['t_es_id']>0){
                            $trade_helper->recordEnterShopSuccessSettled($settled['ts_id']);
                        }else{
                            $trade_helper->recordSuccessSettled($settled['ts_id']);
                        }
                    }
                }
             
               if($this->curr_shop['s_return_time'] > 0){
                    $trade_redis = new App_Model_Trade_RedisTradeStorage($this->curr_sid);
                    $trade_redis->setTradeReturn($tid,$this->curr_shop['s_return_time'] * 24 * 60 * 60);
                }else{
                    //交易佣金完成通知
                    $order_deduct   = new App_Helper_OrderDeduct($this->curr_sid);
                    $order_deduct->completeOrderDeduct($tid, $trade['t_m_id']);
                }
                $ret = $trade_model->findUpdateTradeByTid($tid, $updata);
                $returnModel = new App_Model_Shop_MysqlOrderReturnStorage($this->curr_sid);
                $return = $returnModel->findUpdateDeductByTid($tid);
                if($return){
                    if(App_Helper_MemberLevel::goldCoinTrans($this->curr_sid, $return['or_m_id'], $return['or_return'])){
                        $returnSet = array('or_status' => 1);
                        $returnModel->findUpdateDeductByTid($tid, $returnSet);
                    }
                }

                if($this->wxapp_cfg['ac_type'] != 12 && $this->wxapp_cfg['ac_type'] != 9){
                    $trade_helper->modifyGoodsSold($trade['t_id']);
                }elseif ($this->wxapp_cfg['ac_type'] == 12){
                    $trade_helper->adjustTradeCourseApply($trade['t_id']);
                }

                if($ret){
                    plum_open_backend('index', 'updateOrder', array('sid' => $this->curr_sid, 'tid' => $tid));
                    if($trade['t_express_method'] == 7 && $call == false){
                        $legwork_trade_model = new App_Model_Legwork_MysqlLegworkTradeStorage(0);
                        $legworkTrade = $legwork_trade_model->findUpdateTradeByOtherTid($trade['t_tid'],$trade['t_s_id']);
                        if($legworkTrade && $legworkTrade['alt_status'] != App_Helper_Legwork::TRADE_CLOSED){
                            $legwork_controller = new App_Controller_Wxapp_LegworkController();
                            $shop_model = new App_Model_Shop_MysqlShopCoreStorage(0);
                            $legworkShop = $shop_model->getRowById($legworkTrade['alt_s_id']);

                            $legwork_controller->finishTradeAction($legworkTrade['alt_tid'],$legworkTrade['alt_s_id'],false,true,$legworkShop);
                        }

                    }

                    App_Helper_OperateLog::saveOperateLog("完成订单【".$tid."】");

                    $result = array(
                        'ec' => 200,
                        'em' => '订单已完成'
                    );
                }else{
                    $result = array(
                        'ec' => 400,
                        'em' => '确认收货失败'
                    );
                }
            }else{
                $result = array(
                        'ec' => 400,
                        'em' => '订单状态不正确'
                    );
            }

        }else{
            $result = array(
                        'ec' => 400,
                        'em' => '订单不存在'
                    );
        }
        if($display){
            $this->displayJson($result);
        }

    }

    
    public function finishSequenceOrderAction(){
        $result = array(
            'ec' => 400,
            'em' => '请求数据错误'
        );
        $tid    = $this->request->getStrParam('tid');
        $trade_model= new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $area_info=$this->get_area_manager();
        if($area_info){
            $trade      = $trade_model->findTradeByTidInRegion($tid,$area_info['m_area_id'],$area_info['m_area_type']);
        }else{
            $trade      = $trade_model->findUpdateTradeByTid($tid);
        }


        
        if($trade){
            if($trade['t_fd_status'] > 0 && $trade['t_fd_status'] != 3){
                $this->displayJsonError('该订单有未完成的退款处理');
            }
            if($trade['t_status'] == App_Helper_Trade::TRADE_SHIP || $trade['t_status'] == App_Helper_Trade::TRADE_HAD_PAY){
                $updata = array(
                    't_finish_time' => time(),
                    't_status'      => App_Helper_Trade::TRADE_FINISH,//置于完成状态
                );
                $ret = $trade_model->findUpdateTradeByTid($tid, $updata);


                if($ret){
                        $where_confirm[] = ['name'=>'aac_s_id','oper'=>'=','value'=>$this->curr_sid];
                        $where_confirm[] = ['name'=>'aac_confirm_id','oper'=>'=','value'=>$trade['t_id']];
                        $where_confirm[] = ['name'=>'aac_type','oper'=>'=','value'=>2];
                        $accountant_model = new App_Model_Accountant_MysqlAccountantConfirmStorage($this->curr_sid);
                        $accountant_model->deleteValue($where_confirm);
                    $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
                    $orderIds = [];
                    $where_order = [];
                    $where_order[] = ['name'=>'to_t_id','oper'=>'=','value'=>$trade['t_id']];
                    $where_order[] = ['name'=>'to_se_verify','oper'=>'=','value'=>0];
                    $order_list = $order_model->getList($where_order,0,0);
                    foreach ($order_list as $order){
                        $orderIds[] = $order['to_id'];
                    }
                    if(!empty($orderIds)){
                        $where_order = [];
                        $set = [
                            'to_se_verify' => 1,
                            'to_se_verify_time' => time()
                        ];
                        $where_order[] = ['name'=>'to_id','oper'=>'in','value'=>$orderIds];
                        $order_model->updateValue($set,$where_order);
                    }


                    $sequence_helper = new App_Helper_Sequence($this->curr_sid);
                    $sequence_helper->dealSequenceVerify($trade,0);
                    $result = array(
                        'ec' => 200,
                        'em' => '操作成功'
                    );
                    $region_brokerage_model=new App_Model_Sequence_MysqlSequenceRegionBrokerageStorage($this->curr_sid);
                    $region_res=$region_brokerage_model->updateValue(
                        [
                            'armb_status'   =>1,
                            'armb_update_at'=>time()
                        ],
                        [
                            ['name'=>'armb_tid','oper'=>'=','value'=>$tid]
                        ]
                    );
                    if(!$region_res)
                        Libs_Log_Logger::outputLog('区域管理合伙人佣金状态更新失败：'.$tid,'region.log');

                }else{
                    $result = array(
                        'ec' => 400,
                        'em' => '操作失败'
                    );
                }
            }else{
                $result = array(
                    'ec' => 400,
                    'em' => '订单状态不正确'
                );
            }

        }else{
            $result = array(
                'ec' => 400,
                'em' => '订单不存在'
            );
        }
        $this->displayJson($result);
    }

    
    public function commentListAction(){
        $page = $this->request->getIntParam('page');

        if(in_array($this->wxapp_cfg['ac_type'],[4,7,27])){
            $independent = 1;
        }else{
            $independent = 0;
        }
        if($this->wxapp_cfg['ac_type']==12){
            $table_pre='acc';
        }else{
            $table_pre='gc';
        }
        
        $index = $page * $this->count;
        $where = array();
        $goods_id=$this->request->getIntParam('goods_id');
        if($goods_id){
            $where_total[]= $where[]=['name'=>$table_pre.'_g_id','oper'=>'=','value'=>$goods_id];
        }
        $this->output['nickname'] = $this->request->getStrParam('nickname');
        if($this->output['nickname']){
            $where[]        = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$this->output['nickname']}%");
        }
        $this->output['content'] = $this->request->getStrParam('content');
        if($this->output['content']){
            $where[]        = array('name' => $table_pre.'_content', 'oper' => 'like', 'value' => "%{$this->output['content']}%");
        }
        $this->output['start']   = $this->request->getStrParam('start');
        if($this->output['start']){
            $where[]    = array('name' => $table_pre.'_create_time', 'oper' => '>=', 'value' => strtotime($this->output['start']));
        }
        $this->output['end']     = $this->request->getStrParam('end');
        if($this->output['end']){
            $where[]    = array('name' => $table_pre.'_create_time', 'oper' => '<=', 'value' => (strtotime($this->output['end']) + 86400));
        }
        $this->output['sortType'] = $this->request->getStrParam('sort_type');
        if($this->output['sortType']){
            switch ($this->output['sortType']){
                case 'star_asc':
                    $sort = [$table_pre.'_star' => 'ASC',$table_pre.'_create_time' => 'DESC'];
                    break;
                case 'star_desc':
                    $sort = [$table_pre.'_star' => 'DESC',$table_pre.'_create_time' => 'DESC'];
                    break;
                default:
                    $sort   = [$table_pre.'_create_time' => 'DESC'];
            }
        }else{
            $sort   = [$table_pre.'_create_time' => 'DESC'];
        }

        $this->output['searchStatus'] = $this->request->getStrParam('search_status');
        if($this->output['searchStatus']){
            switch ($this->output['searchStatus']){
                case 'had_reply':
                    $where[] = array('name' => $table_pre.'_reply', 'oper' => '>', 'value' => 0);
                    break;
                case 'no_reply':
                    $where[]  = array('name' => $table_pre.'_reply', 'oper' => '=', 'value' => '');
                    break;
                default:

            }
        }

        $where[] = array('name'=>$table_pre.'_s_id','oper'=>'=','value'=>$this->curr_sid);
        
        $where[] = $where_total[] = array('name'=>$table_pre.'_deleted','oper'=>'=','value'=> 0);
        if($this->wxapp_cfg['ac_type']==12){
            $post_storage =new App_Model_Train_MysqlTrainCourseCommentStorage($this->curr_sid);
        }else{
            $where[] = array('name'=>$table_pre.'_es_id','oper'=>'=','value'=> 0);
            $where[] = array('name'=>'g_independent_mall','oper'=>'=','value'=> $independent);
            $where_total[] = ['name'=>'g_independent_mall','oper'=>'=','value'=> $independent];
            $where_total[] = ['name'=>'g_es_id','oper'=>'=','value'=> 0];
            $post_storage = new App_Model_Goods_MysqlCommentStorage($this->curr_sid);
        }
        
        
        $total      = $post_storage->getCommentListMemberCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $this->output['showPage'] = $total > $this->count ? 1 : 0;
        $list = array();
        if($index < $total){
            $list          = $post_storage->getCommentListMember($where, $index,$this->count,$sort);
        }
  
        foreach($list as $key=>$val){
            $list[$key]['gc_content']   = $this->utf8_str_to_unicode($val[$table_pre.'_content']);
            $list[$key]['gc_tid']       = $val[$table_pre.'_tid'];
            $list[$key]['gc_title']     = $val[$table_pre.'_title'];
            $list[$key]['gc_star']      = $val[$table_pre.'_star'];
            $list[$key]['gc_create_time'] = $val[$table_pre.'_create_time'];
            $list[$key]['gc_id']        = $val[$table_pre.'_id'];
        }
        $this->output['list'] = $list;
        
        $total_1 = $post_storage->getCommentCount(1,$where_total);
        $total_2 = $post_storage->getCommentCount(2,$where_total);
        $total_3 = $post_storage->getCommentCount(3,$where_total);
        $total_4 = $post_storage->getCommentCount(4,$where_total);
        $total_5 = $post_storage->getCommentCount(5,$where_total);
        $this->output['statInfo'] = [
            'total_1' => intval($total_1),
            'total_2' => intval($total_2),
            'total_3' => intval($total_3),
            'total_4' => intval($total_4),
            'total_5' => intval($total_5),
            'total'   => intval($total_1) + intval($total_2) + intval($total_3) + intval($total_4) + intval($total_5)
        ];


        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => '#'),
            array('title' => '评论列表', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/order/comment-list.tpl');
    }

    
    private function utf8_str_to_unicode($utf8_str) {
        $unicode_str = '';
        for($i=0;$i<mb_strlen($utf8_str);$i++){
            $val = mb_substr($utf8_str,$i,1,'utf-8');
            if(strlen($val) >= 4){
                $unicode = (ord($val[0]) & 0xF) << 18;
                $unicode |= (ord($val[1]) & 0x3F) << 12;
                $unicode |= (ord($val[2]) & 0x3F) << 6;
                $unicode |= (ord($val[3]) & 0x3F);
                $unicode_str.= '<span class="emoji-inner emoji'.dechex($unicode).'"></span>';
            }else{
                $unicode_str.=$val;
            }
        }
        return $unicode_str;
    }

    
    public function deleteCommentAction(){
        $cid = $this->request->getIntParam('cid');
        $course = $this->request->getIntParam('course');
        $ret = 0;
        if($cid){
            if($course == 1 || $this->wxapp_cfg['ac_type']==12){
                $post_storage = new App_Model_Train_MysqlTrainCourseCommentStorage($this->curr_sid);
                $set = array('acc_deleted' => 1);
            }else{
                $post_storage = new App_Model_Goods_MysqlCommentStorage($this->curr_sid);
                $set = array('gc_deleted' => 1);
            }

            $ret = $post_storage->updateById($set,$cid);

            if($ret){
                App_Helper_OperateLog::saveOperateLog("评论删除成功");
            }

        }
        $this->showAjaxResult($ret,'删除');
    }

    
    public function commentDetailsAction(){
        $id = $this->request->getIntParam('id');
        $course = $this->request->getIntParam('course',0);
        if($course || $this->wxapp_cfg['ac_type']==12){
            $post_storage = new App_Model_Train_MysqlTrainCourseCommentStorage($this->curr_sid);
            $post = $post_storage->getCommentRowMember($id);
            $post['gc_content'] = $this->utf8_str_to_unicode($post['acc_content']);
            $post['gc_id'] = $post['acc_id'];
            $post['gc_reply'] = $post['acc_reply'];
            $this->output['post'] = $post;
            $this->output['imgList'] = json_decode($post['acc_comment_img']);
        }else{
            $post_storage = new App_Model_Goods_MysqlCommentStorage($this->curr_sid);
            $post = $post_storage->getCommentRowMember($id);
            $post['gc_content'] = $this->utf8_str_to_unicode($post['gc_content']);
            $this->output['post'] = $post;
            $this->output['imgList'] = json_decode($post['gc_comment_img']);
        }
        $this->output['course'] = $course;
        $this->buildBreadcrumbs(array(
            array('title' => '评论列表', 'link' => '/wxapp/order/commentList'),
            array('title' => '评论详情', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/order/comment-details.tpl');
    }

    
    public function replyCommentAction(){
        $cid = $this->request->getIntParam('cid');
        $reply = $this->request->getStrParam('reply');
        $course = $this->request->getIntParam('course');
        $ret = 0;
        if($cid){
            if($course || $this->wxapp_cfg['ac_type']==12){
                $post_storage = new App_Model_Train_MysqlTrainCourseCommentStorage($this->curr_sid);
                $set = array('acc_reply'=>$reply);
            }else{
                $post_storage = new App_Model_Goods_MysqlCommentStorage($this->curr_sid);
                $set = array('gc_reply'=>$reply);
            }
            $ret = $post_storage->updateById($set,$cid);

            if($ret){
                App_Helper_OperateLog::saveOperateLog("评论回复成功");
            }

        }
        $this->showAjaxResult($ret);
    }

  

    
    public function excelOrderAction(){
        $startDate      = $this->request->getStrParam('startDate');
        $startTime      = $this->request->getStrParam('startTime');
        $endDate        = $this->request->getStrParam('endDate');
        $endTime        = $this->request->getStrParam('endTime');
        $esId           = $this->request->getIntParam('esId');
        $orderType      = $this->request->getIntParam('orderType', -1);
        $groupType      = $this->request->getStrParam('groupType');
        $addressOrder   = $this->request->getStrParam('addressOrder');
        $goodsOrder     = $this->request->getStrParam('goodsOrder');
        $storeOrder     = $this->request->getStrParam('storeOrder');
        $mergeOrder     = $this->request->getStrParam('mergeOrder');
        $entershop      = $this->request->getIntParam('entershop');
        $cash           = $this->request->getStrParam('cash');
        $orderStatus    = $this->request->getStrParam('orderStatus','all');
        $postType       = $this->request->getIntParam('postType');
        $ssMd           = $this->request->getIntParam('ssMd');
        $communityId    = $this->request->getIntParam('communityId',0);
        $goodstitle     = $this->request->getStrParam('goodstitle');
        $_independent   = $this->request->getIntParam('independent',0); 
        $excel_independent = $this->request->getIntParam('excel_independent',0);
        $independent = $excel_independent ? $excel_independent : $_independent;
        $start          = $startDate.' '.$startTime;
        $end            = $endDate.' '.$endTime;
        $startTime      = strtotime($start);
        $endTime        = strtotime($end);
        if(!$startTime || !$endTime)
            $this->displayJsonError('日期格式错误，请检查后重试!');
        $filename  =sprintf('orders_%s_%s_%s_%s.xlsx',$this->curr_sid,$startDate,$endDate,rand());
        $where=[
            ['name'=>'t_create_time','oper'=>'>=','value'=>$startTime],
            ['name'=>'t_create_time','oper'=>'<','value'=>$endTime],
            ['name'=>'t_independent_mall','oper'=>'=','value'=>$independent],
            ['name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid]
        ]; 

        if($orderType != -1){
            $where[]=['name'=>'t_applet_type','oper'=>'=','value'=>$orderType];
        }
        if($postType){
            $where[]=['name'=>'t_express_method','oper'=>'=','value'=>$postType];
        }
        if($ssMd){
            $where[]=['name'=>'t_store_id','oper'=>'=','value'=>$ssMd];
        }
        if($communityId){
            $where[]=['name'=>'asc_id','oper'=>'=','value'=>$communityId];
        }
        if($esId){
            $where[]=['name'=>'t_es_id','oper'=>'=','value'=>$esId];
        }
        if($entershop < 0){
            $where[]=['name'=>'t_es_id','oper'=>'=','value'=>0];
        }else if($entershop > 0){
            $where[]=['name'=>'t_es_id','oper'=>'=','value'=>$entershop];
        }
        $group_link = App_Helper_Group::$group_trade_status;
        $groupStatus = -1;
        if($groupType && isset($group_link[$groupType]) && $group_link[$groupType]['id'] >= 0){
            $groupStatus = $group_link[$groupType]['id'];
        }
        if($groupStatus >= 0) {
            $where[]=['name'=>'go_status','oper'=>'=','value'=>$groupStatus];
        }

        if($cash == 'cash') {
            $where[]=['name'=>'t_type','oper'=>'=','value'=>9];
        }else {
            $where[]=['name'=>'t_type','oper'=>'=','value'=>5];
        }
        if($goodstitle){
            $title = str_replace(" ", "", $goodstitle);
            $where[]=['name'=>'replace(t_title, " ", "")','oper'=>'like','value'=>"%{$title}%"];
        }
        $trade_link = App_Helper_Trade::$trade_link_status;
        if($orderStatus && isset($trade_link[$orderStatus]) && $trade_link[$orderStatus]['id'] > 0){
            $where[]=['name'=>'t_status','oper'=>'=','value'=>$trade_link[$orderStatus]['id']];
        }else{
            $where[]=['name'=>'t_status','oper'=>'>','value'=>0];
        }
        $sort = ['t_create_time' => 'DESC'];
        if($addressOrder=='on'){
            $sort = ['ma_province' => 'DESC', 'ma_city' => 'DESC' , 'ma_zone' => 'DESC', 'ma_detail' => 'DESC'];
        }
        if($storeOrder=='on'){
            $sort = ['t_store_id' => 'DESC'];
        }
        $trade_order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
   
        $export_num=$trade_order_model->getCountWithTrade($where);
        if($export_num > self::MAX_EXPORT_EXCEL_ROWS){
            $this->displayJsonError('单次导出的（子）订单数量不得超过'.self::MAX_EXPORT_EXCEL_ROWS.'行');
        }
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $main_trade_list = $trade_model->getAddressListNew($where,0,0,$sort);

        if(empty($main_trade_list))
            $this->displayJsonError('当前时间段内没有订单!');

        $tradePay   =  App_Helper_Trade::$trade_pay_type;
        $groupType  =  plum_parse_config('group_type');
        $statusNote =  plum_parse_config('trade_status');
        $expressMethod =[
            1 => '商家配送',
            2 => '门店自取',
            3 => '快递发货'
        ];
        $excel_data         =[];//导出到的excel的拼装数据数组
        $merge_order_nums   =[];//相同单行的订单合并时的行数
        foreach($main_trade_list as $key => $trade_value){
            $gid_sales_nums[$trade_value['to_g_id']] += $trade_value['to_num'];
            $gfid_sales_nums[$trade_value['to_g_id'].'-'.$trade_value['to_gf_id']] += $trade_value['to_num'];
            $excel_data['t_tid']           = $trade_value['t_tid'];
            if($this->wxapp_cfg['ac_type'] == 8)
                $excel_data['es_name']         = $trade_value['es_name'];
            $excel_data['t_buyer_nick']    = $this->utf8_orderstr_to_unicode($trade_value['t_buyer_nick']);
            $excel_data['s_name']          = $trade_value['ma_name'];
            $excel_data['s_phone']         = $trade_value['ma_phone'];
            $excel_data['s_province']      = $trade_value['ma_province'];
            if(in_array($trade_value['ma_province'],array('北京市','上海市','天津市','重庆市'))){
              $city = $trade_value['ma_province'];
            }else{
              $city = $trade_value['ma_city'];
            }
            $excel_data['s_city']          = $city;
            $excel_data['s_zone']          = $trade_value['ma_zone'];
            $excel_data['s_detail']        = $excel_data['s_province'].$excel_data['s_city'].$excel_data['s_zone'].$trade_value['ma_detail'];
            $excel_data['s_post']          = $trade_value['ma_post'];
            $excel_data['o_exp_code']      = $trade_value['t_express_code'];
            $excel_data['o_post_price']    = $trade_value['t_post_fee'];
            $excel_data['o_total_price']   = $trade_value['t_payment'];
            $excel_data['g_title']         = $trade_value['to_title'];
            $excel_data['g_gg']            = $trade_value['to_gf_name'];
            $excel_data['g_tp']            = $trade_value['to_price'];
            $excel_data['g_num']           = $trade_value['to_num'];
            $excel_data['o_discount_fee']  = $trade_value['t_discount_fee'];
            $excel_data['o_promotion_fee'] = $trade_value['t_promotion_fee'];
            $excel_data['o_createtime']    = $trade_value['t_create_time'] ? date('Y-m-d H:i:s',$trade_value['t_create_time']) : '';
            $excel_data['o_paytime']       = $trade_value['t_pay_time'] ? date('Y-m-d H:i:s',$trade_value['t_pay_time']) : '';
            $excel_data['o_sendtime']      = $trade_value['t_express_time'] ? date('Y-m-d H:i:s',$trade_value['t_express_time']) : '';
            $excel_data['o_sale_note']     = $trade_value['t_note']?'备注: '.$trade_value['t_note'].';':'';
            foreach (json_decode($trade_value['t_remark_extra'], true) as $item){
                if($item['value']){
                    $excel_data['o_sale_note'] .= $item['name'].':'.$item['value'].';';
                }
            }
            $excel_data['o_exp_company']   = $trade_value['t_express_company'];
            $excel_data['o_store_name']    = $trade_value['os_name'] ? $trade_value['os_name'] : '';
            if($trade_value['t_status'] == 8){
              $excel_data['o_status']      = '已退款';
            }else{
              $excel_data['o_status']      = $statusNote[$trade_value['t_status']];
            }
            $excel_data['o_paytype']       = $tradePay[$trade_value['t_pay_type']];
            $excel_data['o_express_method']= $expressMethod[$trade_value['t_express_method']];//配送方式
            $excel_data['o_finishtime']    = $trade_value['t_finish_time'] ? date('Y-m-d H:i:s',$trade_value['t_finish_time']) : '';
            if($goodsOrder=='on'){
                $excel_data['g_id']            = $trade_value['to_g_id'];
                $excel_data['gf_id']           = $trade_value['to_gf_id'];
            }
            $this->deleteUsaelessFieldsWithAppletType($excel_data);
            
            $excel_rows[]                  = $excel_data;
            if($mergeOrder=='on'){ 
                $merge_order_nums[$trade_value['t_id']] += 1;
            }


        }


        $plugin    = new App_Plugin_xlsxwriter_XLSXWriterPlugin($filename);
        if($goodsOrder=='on'){
            $gids = array_column($excel_rows,'g_id');
            $gfids = array_column($excel_rows,'gf_id');
            array_multisort($gids,SORT_DESC, $gfids,SORT_DESC, $excel_rows);
            unset($gids);
            unset($gfids);

            $merge_gids =$merge_gfids=[];
            foreach ($excel_rows as $key => $val){
                $merge_gids[$val['g_id']] += 1;
                $merge_gfids[$val['g_id'].'-'.$val['gf_id']] +=1;
                $part1=array_splice($val,0,13);          
                $part2=['goodsnums'=>$gid_sales_nums[$val['g_id']]];

                $part3=array_splice($val,0,1);   
                $part4=['formatnums'=>$gfid_sales_nums[$val['g_id'].'-'.$val['gf_id']]];
                $part5=array_splice($val,0,(count($val)-1));
                $excel_rows[$key]=array_merge($part1,$part2,$part3,$part4,$part5);

                unset($excel_rows[$key]['g_id']);
                unset($excel_rows[$key]['gf_id']);
            }
            $merge_gids  = array_values($merge_gids);
            $merge_gfids = array_values($merge_gfids);

            $url=$plugin->tradeExportWithGoodsSort($excel_rows,$merge_gids,$merge_gfids,$this->wxapp_cfg['ac_type']);
            
        }else{
            $url=$plugin->tradeExport($excel_rows,$merge_order_nums,$this->wxapp_cfg['ac_type']);  
        }
        if($url)
            $this->displayJsonSuccess(['url'=>substr($url, 1)]);
        else
            $this->displayJsonError('导出数据失败');
    }

    
    private function deleteUsaelessFieldsWithAppletType(&$excel_data){
        if($this->wxapp_cfg['ac_type'] == 12){
            unset($excel_data['s_name']);
            unset($excel_data['s_phone']); 
            unset($excel_data['s_province']);
            unset($excel_data['s_city']);
            unset($excel_data['s_zone']); 
            unset($excel_data['s_detail']);
            unset($excel_data['s_post']); 
            unset($excel_data['o_exp_code']);
            unset($excel_data['o_post_price']); 
            unset($excel_data['g_gg']);
            unset($excel_data['o_sendtime']);
            unset($excel_data['o_exp_company']);
            unset($excel_data['o_store_name']);
        }
    }

    
    private function utf8_orderstr_to_unicode($utf8_str) {
        $unicode_str = '';
        for($i=0;$i<mb_strlen($utf8_str);$i++){
            $val = mb_substr($utf8_str,$i,1,'utf-8');
            if(strlen($val) >= 4){
                $unicode = (ord($val[0]) & 0xF) << 18;
                $unicode |= (ord($val[1]) & 0x3F) << 12;
                $unicode |= (ord($val[2]) & 0x3F) << 6;
                $unicode |= (ord($val[3]) & 0x3F);
                $unicode_str.= '';
            }else{
                $unicode_str.=$val;
            }
        }
        $unicode_str = $this->_filter_character($unicode_str);
        return $unicode_str;
    }
    
    private function _filter_character($nickname) {
        $nickname = preg_replace('/[\x{1F600}-\x{1F64F}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{1F300}-\x{1F5FF}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{1F680}-\x{1F6FF}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{2600}-\x{26FF}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{2700}-\x{27BF}]/u', '', $nickname);
        $nickname = preg_replace('/[=]/u', '', $nickname);
        $nickname = str_replace(array('"','\''), '', $nickname);
        $nickname  = addslashes(trim($nickname));
        return $nickname;
    }


    
    public function printOrderAction(){
        $tid = $this->request->getStrParam('tid');
        $sn  = $this->request->getStrParam('sn');
        if($tid && $sn){
            $print_model = new App_Helper_Print($this->curr_sid);
            $ret = $print_model->printOrder($tid,$sn);
        }
        $label='发送订单';
        if(is_array($ret)){
            $label=$ret['msg'];
            $ret=false;
        }

        $this->showAjaxResult($ret,$label);

    }

    
    public function pushEleOrderAction(){
        $tid = $this->request->getIntParam('tid');
        $trade_helper = new App_Helper_Trade($this->curr_sid);
        $ret = $trade_helper->dealEleDelivery($tid);
        if($ret['ec'] == 200){
            $this->showAjaxResult($ret, '推单');
        }else{
            $this->displayJsonError($ret['msg']);
        }
    }

    
    private function get_area_manager(){
        $manager_model = new App_Model_Member_MysqlManagerStorage();
        $info=$manager_model->getSingleManagerWithArea($this->uid,$this->company['c_id']);
        if($info){
            return [
                'm_area_id'     =>$info['m_area_id'],
                'm_area_type'   =>$info['m_area_type'],
                'region_name'   =>$info['region_name'],
            ];
        }else{
            return null;
        }
    }


    public function pushLegworkOrderAction(){
        $tid = $this->request->getStrParam('tid');
        $trade_model= new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $trade      = $trade_model->getRowById($tid);

        if($this->wxapp_cfg['ac_type'] == 4 && $trade['t_meal_type'] == 1 && $trade['t_meal_send_time'] && $trade['t_meal_send_time'] != '立即送达'){
            if(date('Y-m-d') != date('Y-m-d',strtotime($trade['t_meal_send_time']))){
                $this->displayJsonError('非本日外送订单不能使用跑腿配送');
            }
        }


        if($trade && $trade['t_status'] == App_Helper_Trade::TRADE_WAIT_GROUP){
            $trade_status   = App_Helper_Trade::TRADE_HAD_PAY;
            $trade_model->findUpdateTradeByTid($trade['t_tid'],array('t_status' => $trade_status));
            if($this->curr_shop['s_auto_refund'] > 0){
                $trade_redis = new App_Model_Trade_RedisTradeStorage($this->curr_sid);
                $trade_redis->setTradePrintTtl($trade['t_id'], $this->curr_shop['s_auto_refund']*60);
            }else{
                $print_model = new App_Helper_Print($this->curr_sid);
                $print_model->printOrder($trade['t_tid'],'',$trade['t_es_id']);
            }
        }

        $legwork_model = new App_Model_Legwork_MysqlOtherLegworkCfgStorage($this->curr_sid);
        $legworkCfg = $legwork_model->findUpdateBySidEsId($trade['t_es_id']);

        if(!$legworkCfg){
            $legwork_model = new App_Model_Legwork_MysqlOtherLegworkCfgStorage($this->curr_sid);
            $legworkCfg = $legwork_model->findUpdateBySidEsId($trade['t_es_id']);
        }
        $applet_model = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        $where = [];
        $where[] = ['name' => 'ac_appid' , 'oper' => '=', 'value' => $legworkCfg['aolc_appid']];
        $applet = $applet_model->getRow($where);
        $legwork_sid = $applet['ac_s_id'];
        if($legwork_sid && $trade['t_express_method'] == 7 && $trade['t_applet_type'] != App_Helper_Trade::TRADE_APPLET_GROUP){
            $hold_dir     = PLUM_APP_BUILD.'/spread/';
            $access_path  = PLUM_PATH_PUBLIC.'/build/spread/';

            $tid = App_Plugin_Weixin_PayPlugin::makeMchOrderid($legwork_sid);
            $legworkExtra = json_decode($trade['t_legwork_extra'],1);

            $legwork_code =  plum_random_code(5);
            $filename = $trade['t_m_id'].'-'.$legwork_code. '.png';
            $text = $legwork_code;
            Libs_Qrcode_QRCode::png($text, $hold_dir . $filename, 'Q', 6, 1);
            $insert = [
                'alt_s_id' => $legwork_sid,
                'alt_m_id' => $trade['t_m_id'],
                'alt_tid'  => $tid,
                'alt_status' => 3,
                'alt_distance' => $legworkExtra['distance'],
                'alt_basic_distance' => $legworkExtra['basicDistance'],
                'alt_plus_distance' => $legworkExtra['plusDistance'],
                'alt_basic_price' => $legworkExtra['basicPrice'],
                'alt_plus_price' => $legworkExtra['plusPrice'],
                'alt_create_time' => time(),
                'alt_other_tid' => $trade['t_tid'],
                'alt_other_sid' => $trade['t_s_id'],
                'alt_other_discount' => $legworkExtra['discountPost'],
                'alt_other_esid' => $trade['t_es_id'],
                'alt_buyer_openid' => $trade['t_buyer_openid'],
                'alt_type' => 3,
                'alt_code' => $legwork_code,
                'alt_qrcode' => $access_path.$filename
            ];
            $appletCfg = $applet_model->findShopCfg();
            if($appletCfg['ac_type'] == 4){
                $insert['alt_termini_id'] = $trade['t_addr_id'];
                $insert['alt_addr'] = $legworkExtra['shopAddr'];
                $insert['alt_addr_lng'] = $legworkExtra['fromLng'];
                $insert['alt_addr_lat'] = $legworkExtra['fromLat'];
                $insert['alt_addr_mobile'] = $legworkExtra['shopMobile'];
                $insert['alt_time_fee'] = $legworkExtra['timePrice'];
                $insert['alt_note'] = $trade['t_note'];
                if($trade['t_meal_send_time'] && $trade['t_meal_send_time'] != '立即送达'){
                    $insert['alt_time'] = strtotime($trade['t_meal_send_time']);
                }
            }else{
                $insert['alt_termini_id'] = $trade['t_addr_id'];
                $insert['alt_addr'] = $legworkExtra['shopAddr'];
                $insert['alt_addr_lng'] = $legworkExtra['fromLng'];
                $insert['alt_addr_lat'] = $legworkExtra['fromLat'];
                $insert['alt_addr_mobile'] = $legworkExtra['shopMobile'];
                $insert['alt_note'] = $trade['t_note'];
            }
            $legwork_trade_model = new App_Model_Legwork_MysqlLegworkTradeStorage($legwork_sid);
            $res = $legwork_trade_model->insertValue($insert);
            if($res){
                $jiguang_model = new App_Helper_JiguangPush($insert['alt_s_id']);
                $jiguang_model->pushNotice($jiguang_model::LEGWORK_NEW_TRADE,$insert,'',true);
                App_Helper_OperateLog::saveOperateLog("跑腿订单推送成功");

                $this->showAjaxResult($res, '操作');
            }else{
                $this->displayJsonError("操作失败");
            }
        }
    }

    
    public function editOrderRemarkAction(){
        $tid = $this->request->getStrParam('tid');
        $remark = $this->request->getStrParam('remark');
        $type = $this->request->getIntParam('type');
        $trade_model= new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        if($type && $type==1){
            $set = array('t_note' => $remark);
        }else{
            $set = array('t_remark_extra' => $remark);
        }
        $ret = $trade_model->findUpdateTradeByTid($tid, $set);

        if($ret){
            App_Helper_OperateLog::saveOperateLog("订单【{$tid}】备注修改成功");
        }

        $this->showAjaxResult($ret, '修改');
    }


    
    public function excelOrderNewAction(){
        $startDate  = $this->request->getStrParam('startDate');
        $startTime  = $this->request->getStrParam('startTime');
        $endDate    = $this->request->getStrParam('endDate');
        $endTime    = $this->request->getStrParam('endTime');





        if($startDate && $startTime && $endDate && $endTime){
            $start = $startDate.' '.$startTime;
            $end = $endDate.' '.$endTime;
            $startTime  = strtotime($start);
            $endTime    = strtotime($end);
            $where      = array();
            $where[]    = array('name'=>'rt_create_time','oper'=>'>=','value'=>$startTime);
            $where[]    = array('name'=>'rt_create_time','oper'=>'<','value'=>$endTime);

            $orderStatus = $this->request->getIntParam('orderStatus');
            $orderType   = $this->request->getIntParam('orderType');
            $sort       = array('rt_create_time' => 'DESC');
            //$where[]    = array('name'=>'rt_s_id','oper'=>'=','value'=>$this->curr_sid);
            if($orderStatus){
                $where[]    = array('name'=>'rt_status','oper'=>'=','value'=>$orderStatus);
            }
            if($orderType){
                $where[]    = array('name'=>'rt_type','oper'=>'=','value'=>$orderType);
            }
            $goodstitle = $this->request->getStrParam('goodstitle');
            if($goodstitle){
                $title = str_replace(" ", "", $goodstitle);
                $where[]= array('name'=>'replace(rt_g_name, " ", "")','oper'=>'like','value'=>"%{$title}%");
            }
            $trade_model = new App_Model_Trade_MysqlReserveTradeStorage();
            $list = $trade_model->getList($where,0,0,$sort);


            if(!empty($list)){
                $time_type = array(
                    1 => '天',
                    2 => '月',
                    3 => '年'
                );
                $statusNote = array(
                    1 => '待付款',
                    2 => '已付款',
                    3 => '已到期',
                );
                $goods_type = array(
                    1 => '园区服务',
                    2 => '企业服务',
                    3 => 'VIP服务'
                );
                //数据处理
                $rows    = array();
                $rows[]  = array('商品名称','类型','预约人名称','预约人电话','备注','开始时间','到期时间','订单状态');
                $width   = array(
                    'A' => 30,
                    'B' => 20,
                    'C' => 20,
                    'D' => 30,
                    'E' => 50,
                    'F' => 30,
                    'G' => 30,
                    'H' => 20,
                );
                foreach($list as $key => $val){
                    $rows[] = array(
                        $val['rt_g_name'],
                        $goods_type[$val['rt_type']],
                        $val['rt_m_name'],
                        $val['rt_m_mobile'],
                        $val['rt_note'],
                        $val['rt_start_time'] > 0 ? date('Y-m-d', $val['rt_start_time']) : '无',
                        $val['rt_end_time'] > 0 ? date('Y-m-d', $val['rt_end_time']) : '无',
                        $statusNote[$val['rt_status']],
                    );
                }
                $excel = new App_Plugin_PHPExcel_PHPExcelPlugin();
                $excel->down_common_excel($rows,'付费订单导出.xls',$width);
            }else{
                plum_url_location('当前时间段内没有订单!');
            }
        }else{
            plum_url_location('日期请填写完整!');
        }
    }

}