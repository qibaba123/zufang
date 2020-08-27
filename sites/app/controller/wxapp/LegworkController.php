<?php

class App_Controller_Wxapp_LegworkController extends App_Controller_Wxapp_InitController
{
    public function __construct()
    {
        parent::__construct();
    }

    
    private function _get_list_for_select($type = ''){
        $linkList = plum_parse_config('link','system');
        $linkType = $linkTypeNew = plum_parse_config('link_type','system');
        $groupType = plum_parse_config('link_type_legwork','system');
        $link = $linkList[$this->wxapp_cfg['ac_type']];
        unset($linkType[4]);

        $this->output['linkList'] = json_encode($link);
        $this->output['linkType'] = json_encode(array_merge($linkType,$groupType));
    }


    
    private function showIndexTpl($tpl_id=66){
        $tpl_model = new App_Model_Legwork_MysqlLegworkIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid($tpl_id);
        if(empty($tpl)){
            $tpl = array(
                'ali_title'         => '首页',
                'ali_tpl_id'        => $tpl_id,
                'ali_buy_title'     => '代我买',
                'ali_buy_open'      => 1,
                'ali_receive_title'  => '代我取',
                'ali_receive_open'   => 1,
                'ali_send_title'     => '代我送',
                'ali_send_open'      => 1,
                'ali_coupon_open'    => 0,
                'ali_coupon_img'     => '',
                'ali_notice_title'   => '公告',
                'ali_buy_sort'      => 0,
                'ali_receive_sort'  => 0,
                'ali_send_sort'      => 0,
            );
        }

        $this->output['tpl'] = $tpl;
    }

    
    private function _shop_information(){
        $where         = array();
        $where[]       = array('name'=>'ai_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]       = array('name'=>'ai_deleted','oper'=>'=','value'=>0);
        $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
        $sort          = array('ai_create_time' => 'DESC');
        $list          = $information_storage->getList($where,0,50,$sort);
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'      => $val['ai_id'],
                    'title'   => $val['ai_title'],
                    'brief'   => $val['ai_brief'],
                    'cover'   => $val['ai_cover']
                );
            }
        }
        $this->output['information'] = json_encode($data);
    }

    
    private function _show_tpl_notice(){
        $notice_storage = new App_Model_Train_MysqlTrainNoticeStorage($this->curr_sid);
        $notice_list = $notice_storage->fetchNoticeShowList();
        $data = array();
        if($notice_list){
            foreach ($notice_list as $val){
                $data[] = array(
                    'index'         => $val['atn_weight'],
                    'title'         => $val['atn_title'],
                    'articleId'     => $val['atn_article_id'],
                    'articleTitle'  => $val['atn_article_title']
                );
            }
        }
        $this->output['noticeList'] = json_encode($data);
    }

    
    private function _get_information_category(){
        $data = array();
        $category_storage = new App_Model_Applet_MysqlAppletInformationCategoryStorage($this->curr_sid);
        $where[] = array('name'=>'aic_deleted','oper'=>'=','value'=>0);
        $where[] = array('name'=>'aic_s_id','oper'=>'=','value'=>$this->curr_sid);
        $list = $category_storage->getList($where,0,0,array('aic_create_time'=>'DESC'));
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id' => $val['aic_id'],
                    'name' => $val['aic_name']
                );
            }
        }
        $this->output['infocateList'] = json_encode($data);
        $this->output['infocateSelect'] = $data;
    }
    private function _save_train_notice(){
        $noticeInfo = $this->request->getArrParam('notice');
        $notice_storage = new App_Model_Train_MysqlTrainNoticeStorage($this->curr_sid);
        if(!empty($noticeInfo)){
            $notice_list = $notice_storage->fetchNoticeShowList();
            if(!empty($notice_list)){
                $del_id = array();
                foreach($notice_list as $val){
                    if(isset($noticeInfo[$val['atn_weight']])){
                        $set = array(
                            'atn_weight'            => $noticeInfo[$val['atn_weight']]['index'],
                            'atn_title'             => $noticeInfo[$val['atn_weight']]['title'],
                            'atn_article_id'        => $noticeInfo[$val['atn_weight']]['articleId'],
                            'atn_article_title'     => $noticeInfo[$val['atn_weight']]['articleTitle'],
                        );
                        $up_ret = $notice_storage->updateById($set,$val['atn_id']);
                        unset($noticeInfo[$val['atn_weight']]);
                    }else{
                        $del_id[] = $val['atn_id'];
                    }
                }
                if(!empty($del_id)){
                    $notice_where = array();
                    $notice_where[] = array('name' => 'atn_id','oper' => 'in' , 'value' => $del_id);
                    $del_ret = $notice_storage->deleteValue($notice_where);
                }

            }
            if(!empty($noticeInfo)){
                $insert = array();
                foreach($noticeInfo as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}','{$val['title']}','','{$val['articleId']}','{$val['articleTitle']}','{$val['index']}','".time()."') ";
                }
                $ins_ret = $notice_storage->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'atn_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $del     = $notice_storage->deleteValue($where);
        }
        if($up_ret || $ins_ret || $del_ret || $del){
            return true;
        }else{
            return false;
        }
    }





    
    public function riderListAction(){
        $page = $this->request->getIntParam('page');
        $index = $this->count * $page;

        $riderName = $this->request->getStrParam('riderName');
        $mobile = $this->request->getStrParam('mobile');

        $where = [];
        $where[] = array('name'=>'alr_s_id','oper'=>'=','value'=>$this->curr_sid);
        if($riderName){
            $where[] = array('name'=>'alr_name','oper'=>'like','value'=>"%{$riderName}%");
        }
        if($mobile){
            $where[] = array('name'=>'alr_mobile','oper'=>'=','value'=>$mobile);
        }
        $rider_model = new App_Model_Legwork_MysqlLegworkRiderStorage($this->curr_sid);
        $total = $rider_model->getRiderCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list = [];
        if($index < $total){
            $sort          = array('alr_create_time' => 'DESC');
            $list          = $rider_model->getRiderList($where,$index,$this->count,$sort);
        }
        $cfg_model = new App_Model_Legwork_MysqlLegworkCfgStorage($this->curr_sid);
        $cfg = $cfg_model->findUpdateBySid();

        $link = App_Helper_Legwork::$trade_link_status;
        $this->output['link'] = $link;
        $this->output['applyRule'] = $cfg['alc_apply_rule'] ? $cfg['alc_apply_rule'] : '';
        $this->output['list'] = $list;
        $this->output['riderName'] = $riderName;
        $this->output['mobile'] = $mobile;
        $this->buildBreadcrumbs(array(
            array('title' => '骑手管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/legwork/rider-list.tpl');
    }



    
    public function show_trade_list_data($where= array(),$isShop=0){

        $output['status'] = $this->request->getStrParam('status','all');
        $expressMethod = array(
            1 => '商家配送',
            2 => '门店自取',
            3 => '快递发货'
        );
        if($this->wxapp_cfg['ac_type'] == 32){
            unset($expressMethod[3]);
        }
        $output['expressMethod'] = $expressMethod;
        $link = App_Helper_Legwork::$trade_link_status;
        if($output['status'] && isset($link[$output['status']]) && $link[$output['status']]['id'] > 0){
            $where[]= array('name'=>'alt_status','oper'=>'=','value'=>$link[$output['status']]['id']);
        }

        $status_note = App_Helper_Legwork::$trade_status_note;


        $this->output['link'] = $link;
        $this->output['statusNote'] = $status_note;
        $this->output['trade_screen'] = plum_parse_config('trade_screen');

        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $sort       = array('alt_create_time' => 'DESC');

        $where[]    = array('name'=>'alt_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]    = array('name'=>'alt_status','oper'=>'>','value'=>0);
        if($isShop){
            $where[]    = array('name'=>'alt_other_sid','oper'=>'>','value'=>0);
        }

        $output['riderName'] = $this->request->getStrParam('riderName');
        if($output['riderName']){
            $where[]= array('name'=>'alr_name','oper'=>'like','value'=>"%{$output['riderName']}%");
        }
        $output['tid'] = $this->request->getStrParam('tid');
        if($output['tid']){
            if($isShop){
                $where[]= array('name'=>'alt_other_tid','oper'=>'=','value'=>$output['tid']);
            }else{
                $where[]= array('name'=>'alt_tid','oper'=>'=','value'=>$output['tid']);
            }

        }
        $output['buyer']  = $this->request->getStrParam('buyer');
        if($output['buyer']){
            $where[]= array('name'=>'m_nickname','oper'=>'like','value'=>"%{$output['buyer']}%");
        }


        $output['start']   = $this->request->getStrParam('start');
        if($output['start']){
            $where[]    = array('name' => 'alt_create_time', 'oper' => '>=', 'value' => strtotime($output['start']));
        }
        $output['end']     = $this->request->getStrParam('end');
        if($output['end']){
            $where[]    = array('name' => 'alt_create_time', 'oper' => '<=', 'value' => (strtotime($output['end']) + 86400));
        }

        $output['tradeType'] = $this->request->getIntParam('tradeType',0);
        if($output['tradeType'] > 0){
            $where[]    = array('name' => 'alt_type', 'oper' => '=', 'value' => $output['tradeType']);
        }
        $trade_model = new App_Model_Legwork_MysqlLegworkTradeStorage($this->curr_sid);

        $total       = $trade_model->getTradeMemberCount($where);
        $page_lib    = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['page_html'] = $page_lib->render();
        $list     = array();
        if($total > $index){
            $list = $trade_model->getTradeMemberList($where,$index,$this->count,$sort);

        }
        $date_now = date('Y-m-d');

        foreach ($list as $key=>$val){
            if($val['alt_type'] == App_Helper_Legwork::TRADE_TYPE_BUY){
                $status_note[4] = '待买货';
                $status_note[5] = '已买货';
                $timeNote = '立即购买';
            }else{
                $status_note[4] = '待取货';
                $status_note[5] = '已取货';
                $timeNote = '立即送达';
            }
            if($val['alt_cancel_type'] == 1){
                $status_note[7] = '用户取消';
            }elseif ($val['alt_cancel_type'] == 2){
                $status_note[7] = '平台取消';
            }
            $totalRiderFee = $val['alt_basic_price'] + $val['alt_plus_price'] + $val['alt_tip_fee']  + $val['alt_format_price'];
            $postPercent = floatval($val['alt_post_percent']);
            $list[$key]['statusNote'] = $status_note[$val['alt_status']];
            $list[$key]['toAddr'] = $val['alt_termini_type'] == 2 ? '就近购买' : ($val['alt_termini'] ? ($val['alt_termini_detail'] ? $val['alt_termini_detail'].'—' : '').$val['alt_termini'] :($val['terminiDetail'] ? $val['terminiDetail'].'—' : '').$val['terminiProvince'].$val['terminiCity'].$val['terminiZone']);
            $list[$key]['fromAddr'] = $val['alt_addr'] ? ($val['alt_addr_detail'] ? $val['alt_addr_detail'].'—' : '').$val['alt_addr'] : ($val['addrDetail'] ? $val['addrDetail'].'—' : '').$val['addrProvince'].$val['addrCity'].$val['addrZone'];
            $list[$key]['addrPhone'] = $val['alt_addr_mobile'] ? $val['alt_addr_mobile'] : $val['addrPhone'] ;
            $list[$key]['terminiPhone'] = $val['alt_termini_mobile'] ? $val['alt_termini_mobile'] : $val['terminiPhone'] ;
            $list[$key]['addrName'] = $val['alt_addr_name'] ? $val['alt_addr_name'] : $val['addrName'] ;
            $list[$key]['terminiName'] = $val['alt_termini_name'] ? $val['alt_termini_name'] : $val['terminiName'] ;
            $list[$key]['totalPostFee'] = $val['alt_basic_price'] + $val['alt_plus_price'];
            $list[$key]['alt_total_fee'] = floatval($val['alt_total_fee']);
            $list[$key]['alt_goods_fee'] = floatval($val['alt_goods_fee']);
            $list[$key]['alt_diff_fee'] = floatval($val['alt_diff_fee']);
            $list[$key]['alt_format_price'] = floatval($val['alt_format_price']);
            $list[$key]['alt_tip_fee'] = floatval($val['alt_tip_fee']);
            $list[$key]['totalRiderFee'] = $postPercent > 0 ? round($totalRiderFee - $totalRiderFee*$postPercent/100,2) : $totalRiderFee;
            $list[$key]['alt_remark_extra'] = json_decode($val['alt_remark_extra'], true);
            $list[$key]['altc_rider_star']  = $val['altc_rider_star'];
            $list[$key]['altc_goods_star']  = $val['altc_goods_star'];
            $list[$key]['altc_comment']     = $val['altc_comment'];
            $list[$key]['comment_pics'] = $val['alt_comment_pics'];
            if($val['alt_other_num'] > 0){
                if(date('Y-m-d',$val['alt_create_time']) == $date_now){
                    $list[$key]['legworkNum'] = '今日 '.$val['alt_other_num'].'号';
                }else{
                    $list[$key]['legworkNum'] = date('Y年m月d日').' '.$val['alt_other_num'].'号';
                }
            }

        }
        $output['list']   = $list;
        $this->showOutput($output);
    }

    
    public function finishTradeAction($tid = 0,$sid = 0,$display = true,$call = false,$other_shop = []){
        $tid    = $tid ? $tid : $this->request->getStrParam('tid');
        $this->curr_sid = $sid ? $sid : $this->curr_sid;
        $this->curr_shop = $other_shop ? $other_shop : $this->curr_shop;
        $trade_model = new App_Model_Legwork_MysqlLegworkTradeStorage($this->curr_sid);
        $legwork_helper = new App_Helper_Legwork($this->curr_sid);
        $trade = $trade_model->findUpdateTradeByTid($tid);
        $result = [
            'ec' => 400,
            'em' => '操作失败'
        ];

        if($trade){
            if($trade['alt_other_tid'] && $trade['alt_other_sid'] > 0){
                $order_controller = new App_Controller_Wxapp_OrderController();
                $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
                $otherShop = $shop_model->getRowById($trade['alt_other_sid']);
                $order_controller->finishOrderAction($trade['alt_other_tid'],$trade['alt_other_sid'],false,true,$otherShop);
            }

            if(in_array($trade['alt_status'],[3,4,5])){
                $timeNow = time();
                $overtime = 0;
                if($trade['alt_overtime_time'] > 0 && $timeNow > $trade['alt_overtime_time']){
                    $overtime = 1;
                }
                if($trade['alt_take_time']){
                    $costTime = $timeNow - $trade['alt_take_time'];
                }else{
                    $costTime = 0;
                }

                $set = [
                    'alt_status' => App_Helper_Legwork::TRADE_FINISH,
                    'alt_finish_time' => $timeNow,
                    'alt_cost_time' => $costTime,
                    'alt_is_overtime' => $overtime
                ];
                $res = $trade_model->updateById($set,$trade['alt_id']);
                if($res){
                    if($trade['alt_rider']){//已有骑手
                        $rider_model = new App_Model_Legwork_MysqlLegworkRiderStorage($this->curr_sid);
                        $rider = $rider_model->getRowById($trade['alt_rider']);
                        if($rider){
                            if($trade['alt_type'] == 1 && $trade['alt_goods_fee'] > 0){
                                $legwork_helper->_save_rider_pay($rider['alr_id'],$trade);
                            }

                            if($trade['alt_basic_price'] > 0  || $trade['alt_plus_price'] > 0 || $trade['alt_tip_fee'] > 0 || $trade['alt_format_price'] > 0 || $trade['alt_weight_fee'] > 0 || $trade['alt_time_fee'] > 0 || $trade['alt_volume_fee'] > 0){
                                $legwork_helper->_save_rider_income($rider['alr_id'],$trade,$timeNow);
                            }
                            $jiguang_model = new App_Helper_JiguangPush($this->curr_sid);
                            $jiguang_model->pushNotice($jiguang_model::LEGWORK_TRADE_FINISH,$trade,'',true);
                        }

                    }
                    plum_open_backend('templmsg', 'sendLegworkTempl', array('sid' => $this->curr_sid, 'tid' => $trade['alt_tid'], 'type' => 'legwork_finish'));
                    $result = [
                        'em' => '操作成功',
                        'ec' => 200
                    ];
                    $member_model=new App_Model_Member_MysqlMemberCoreStorage();
                    $member_model->incrementMemberTrade($trade['alt_m_id'],$trade['alt_payment']);


                    App_Helper_OperateLog::saveOperateLog("完成订单【{$tid}】");
                }else{
                    $result['em'] = '操作失败';
                }
            }else{
                $result['em'] = '该订单无法完成';
            }
        }else{
            $result['em'] = '未找到订单信息';
        }
        if($display){
            $this->displayJson($result);
        }

    }

    
    private function _rider_income($riderId){
        $rider_model = new App_Model_Legwork_MysqlLegworkRiderStorage($this->curr_sid);
        $rider = $rider_model->getRowById($riderId);
        $info = [
            'ktx' => floatval($rider['alr_income_ktx']),
            'ytx' => floatval($rider['alr_income_ytx']),
            'dsh' => floatval($rider['alr_income_dsh']),
        ];
        $this->output['info'] = $info;
    }
    private function _rider_goodsfee($riderId){
        $rider_model = new App_Model_Legwork_MysqlLegworkRiderStorage($this->curr_sid);
        $rider = $rider_model->getRowById($riderId);
        $info = [
            'ktx' => floatval($rider['alr_goodsfee_ktx']),
            'ytx' => floatval($rider['alr_goodsfee_ytx']),
            'dsh' => floatval($rider['alr_goodsfee_dsh']),
        ];
        $this->output['info'] = $info;
    }


    
    public function riderWithdrawAction(){
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;

        $output = array();
        $sort = array('alrw_create_time' => 'DESC');

        $where = array();
        $where[] = array('name' => 'alrw_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $output['name']   = $this->request->getStrParam('name');
        if($output['name']){
            $where[] = array('name' => 'alr_name', 'oper' => 'like', 'value' => "%{$output['name']}%");
        }
        $output['mobile'] = $this->request->getStrParam('mobile');
        if($output['mobile']){
            $where[] = array('name' => 'alr_mobile', 'oper' => '=', 'value' => $output['mobile']);
        }
        $output['audit']  = $this->request->getStrParam('audit');
        switch($output['audit']){
            case 'refuse':
                $where[] = array('name' => 'alrw_status', 'oper' => '=', 'value' => 3);
                break;
            case 'pass':
                $where[] = array('name' => 'alrw_status', 'oper' => '=', 'value' => 2);
                break;
            case 'audit':
                $where[] = array('name' => 'alrw_status', 'oper' => '=', 'value' => 1);
                break;
        }

        $withdraw_model = new App_Model_Legwork_MysqlLegworkRiderWithdrawStorage($this->curr_sid);
        $total          = $withdraw_model->getRiderCount($where);
        $page_plugin    = new Libs_Pagination_Paginator($total,$this->count,'jquery',1);
        $output['paginator'] = $page_plugin->render();
        $list  = array();
        if($total > $index){
            $list = $withdraw_model->getRiderList($where,$index,$this->count,$sort);
        }
        $output['list'] = $list;
        $output['withdraw_status'] = [
            1 => ['css' => 'danger','label'=>'待审核'],
            2 => ['css' => 'primary','label'=>'审核通过'],
            3 => ['css' => 'warning','label'=>'审核拒绝'],
        ];
        $output['withdraw_status_new'] = [
            1 => ['class' => 'font-color-audit','label'=>'待审核'],
            2 => ['class' => 'font-color-pass','label'=>'审核通过'],
            3 => ['class' => 'font-color-refuse','label'=>'审核拒绝'],
        ];
        $output['withdrawType'] = App_Helper_Legwork::$withdraw_note;
        $output['banks'] = plum_parse_config('banks');
        $this->showOutput($output);
        $this->buildBreadcrumbs(array(
            array('title' => '骑手管理', 'link' => '#'),
            array('title' => '骑手提现', 'link' => '#'),

        ));

        $this->displaySmarty('wxapp/legwork/rider-withdraw-list.tpl');

    }

    public function noticeListAction(){
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $title = $this->request->getStrParam('title');

        $where = [];
        $where[] = array('name'=>'aln_s_id','oper'=>'=','value'=>$this->curr_sid);
        if($title){
            $where[]       = array('name'=>'aln_title','oper'=>'like','value'=>"%{$title}%");
        }
        $this->output['title'] = $title;
        $startTime   = $this->request->getStrParam('start');
        if($startTime){
            $where[]    = array('name' => 'aln_update_time', 'oper' => '>=', 'value' => strtotime($startTime));
        }
        $this->output['start'] = $startTime;

        $endTime     = $this->request->getStrParam('end');
        if($endTime){
            $where[]    = array('name' => 'aln_update_time', 'oper' => '<=', 'value' => (strtotime($endTime) + 86400));
        }
        $this->output['end'] = $endTime;
        $notice_model = new App_Model_Legwork_MysqlLegworkNoticeStorage($this->curr_sid);
        $total = $notice_model->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination']   = $pageCfg->render();
        $list = [];
        if($index < $total){
            $sort = ['aln_create_time'=>'DESC'];
            $list = $notice_model->getList($where,$index,$this->count,$sort);
        }
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '骑手管理', 'link' => '#'),
            array('title' => '通知管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/legwork/notice-list.tpl');
    }

    
    private function _record_push($id){
        $applet_redis = new App_Model_Applet_RedisAppletStorage($this->curr_sid);
        $time = 60*60;
        $applet_redis->setLegworkNoticePushLast($this->curr_sid, $id,$time);
        $timeNow = time();
        $record_model = new App_Model_Legwork_MysqlLegworkNoticePushStorage($this->curr_sid);
        $record = [
            'alnp_s_id' => $this->curr_sid,
            'alnp_notice' => $id,
            'alnp_create_time' => $timeNow
        ];
        $record_model->insertValue($record);
        $set = [
            'aln_push_time' => $timeNow
        ];
        $notice_model = new App_Model_Legwork_MysqlLegworkNoticeStorage($this->curr_sid);
        $notice_model->updateById($set,$id);
    }

    private function _check_push_time($id){
        $applet_redis = new App_Model_Applet_RedisAppletStorage($this->curr_sid);
        $ttl    = $applet_redis->getLegworkNoticePushLast($this->curr_sid,$id);
        if ($ttl > 0){
            if($ttl>60*60){
                $hour = floor($ttl/3600);
                $min = floor(($ttl-3600 * $hour)/60);
                $second = floor((($ttl-3600 * $hour) - 60 * $min) % 60);
                $this->displayJsonError("推送频率过高,请于{$hour}时{$min}分{$second}秒后再试");
            }elseif($ttl>60){
                $min = floor($ttl/60);
                $second = fmod($ttl,60);
                $this->displayJsonError("推送频率过高,请于{$min}分{$second}秒后再试");
            }else{
                $this->displayJsonError("推送频率过高,请于{$ttl}秒后再试");
            }
        }
    }

    
    public function shopListAction(){
        $name  = $this->request->getStrParam('name');
        $this->output['name'] = $name;
        $page  = $this->request->getIntParam('page');
        $shop_id = $this->request->getIntParam('shop_id',0);
        $index = $page*$this->count;
        $where = [];
        $where[] = ['name'=>'aolc_appid','oper'=>'=','value'=>$this->wxapp_cfg['ac_appid']];
        if($shop_id){
            $where[] = ['name'=>'aolc_s_id','oper'=>'=','value'=>$shop_id];
            $where[] = ['name'=>'aolc_es_id','oper'=>'>','value'=>0];
        }else{
            $where[] = ['name'=>'aolc_es_id','oper'=>'=','value'=>0];
        }
        $this->output['shop_id'] = $shop_id;

        if($name){
            if($shop_id){
                $where[] = ['name'=>'es_name','oper'=>'like','value'=>"%{$name}%"];
            }else{
                $where[] = ['name'=>'ac_name','oper'=>'like','value'=>"%{$name}%"];
            }
        }
        $sort = ['aolc_id'=>'DESC'];
        $other_cfg_model = new App_Model_Legwork_MysqlOtherLegworkCfgStorage(0);
        $total              = $other_cfg_model->getShopCount($where);
        $page_libs          = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['pageHtml'] =$page_libs->render();
        $list = $other_cfg_model->getShopList($where,$index,$this->count,$sort);
        $this->output['list'] = $list;

        if($shop_id > 0){
            $bread = [
                array('title' => '商家管理', 'link' => '#'),
                array('title' => '商家列表', 'link' => '/wxapp/legwork/shopList'),
                array('title' => '店铺列表', 'link' => '#'),
            ];
        }else{
            $bread = [
                array('title' => '商家管理', 'link' => '#'),
                array('title' => '商家列表', 'link' => '#'),
            ];
        }

        $this->buildBreadcrumbs(
            $bread
        );
        $this->displaySmarty('wxapp/legwork/shop-list.tpl');
    }

    
    public function confirmPostAction(){
        $sid = $this->request->getIntParam('sid');
        $esid = $this->request->getIntParam('esid');
        $other_cfg_model = new App_Model_Legwork_MysqlOtherLegworkCfgStorage($this->curr_sid);
        $where = [];
        $where[] = ['name'=>'aolc_s_id','oper'=>'=','value'=>$sid];
        $where[] = ['name'=>'aolc_es_id','oper'=>'=','value'=>$esid];
        $where[] = ['name'=>'aolc_appid','oper'=>'=','value'=>$this->wxapp_cfg['ac_appid']];
        $shop = $other_cfg_model->getRow($where);
        if($shop){
            $post_model = new App_Model_Legwork_MysqlLegworkShopPostStorage($this->curr_sid);
            $where = [];
            $where[] = ['name'=>'alsp_s_id','oper'=>'=','value'=>$this->curr_sid];
            $where[] = ['name'=>'alsp_other_sid','oper'=>'=','value'=>$sid];
            $where[] = ['name'=>'alsp_other_esid','oper'=>'=','value'=>$esid];
            $where[] = ['name'=>'alsp_status','oper'=>'=','value'=>1];
            $total_money = $post_model->getSum($where);
            $res = $post_model->updateValue(['alsp_status'=>2],$where);

        if($res){
            $confirm_model = new App_Model_Legwork_MysqlLegworkShopPostConfirmStorage($this->curr_sid);
            $data = array(
                'lspc_s_id' => $this->curr_sid,
                'lspc_other_sid' => $sid,
                'lspc_other_esid' => $esid,
                'lspc_money'  => $total_money ? floatval($total_money) : 0,
                'lspc_create_time' => time()
            );
            $confirm_model->insertValue($data);
            App_Helper_OperateLog::saveOperateLog("配送费结算成功");
        }


        $this->showAjaxResult($res,'操作');
        }else{
            if($esid){
                $msg = '店铺';
            }else{
                $msg = '商家';
            }
            $this->displayJsonError('未找到'.$msg);
        }

    }


    
    private function getDistrictCode($province,$city,$dist){
        $api_url='https://restapi.amap.com/v3/geocode/geo';
        $params=[
            'key'       =>plum_parse_config('mapKay'),//'f12325dd65880e63de2b8509289cc0ca'
            'address'  =>$province.$city.$dist,
            'city'     =>$city,
        ];
        $res=Libs_Http_Client::get($api_url,$params);
        $map_data=json_decode($res,true);
        if($map_data['status']==1){
            return $map_data['geocodes'][0]['adcode'];
        }else
            return 0;
    }

    
    private function _save_goods_cate($type = 0){
        $cateList = $this->request->getArrParam('cateList');
        $cate_model = new App_Model_Legwork_MysqlLegworkGoodsCateStorage($this->curr_sid);
        if(!empty($cateList)){
            $cate_list = $cate_model->getCateList(0,0,$type);
            if(!empty($cate_list)){
                $del_id = array();
                foreach($cate_list as $val){
                    if(isset($cateList[$val['algc_sort']])){
                        $set = array(
                            'algc_sort' => $cateList[$val['algc_sort']]['index'],
                            'algc_name'   => $cateList[$val['algc_sort']]['name'],
                        );
                        $up_ret = $cate_model->updateById($set,$val['algc_id']);
                        unset($cateList[$val['algc_sort']]);
                    }else{
                        $del_id[] = $val['algc_id'];
                    }
                }
                if(!empty($del_id)){
                    $cate_where = array();
                    $cate_where[] = array('name' => 'algc_id','oper' => 'in' , 'value' => $del_id);
                    $cate_model->deleteValue($cate_where);
                }

            }
            if(!empty($cateList)){
                $insert = array();
                foreach($cateList as $val){
                    $insert[] = " (NULL, {$this->curr_sid},'{$val['name']}', '{$val['index']}', '{$type}', '".time()."')";
                }
                $ins_ret = $cate_model->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'algc_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'algc_type','oper' => '=' , 'value' => $type);
            $cate_model->deleteValue($where);
        }
        return true;
    }

    
    private function _is_price_cross($min1 = '', $max1 = '', $min2 = '', $max2 = '') {
        $status = $min2 - $min1;
        if ($status > 0) {
            $diff = $min2 - $max1;
            if ($diff >= 0) {
                return false;
            } else {
                return true;
            }
        } else {
            $diff = $max2 - $min1;
            if ($diff > 0) {
                return true;
            } else {
                return false;
            }
        }
    }


    private function _save_goods_volume($type = 0,$tradeType = 0){
        $volumeList = $this->request->getArrParam('volumeList');
        $volume_model = new App_Model_Legwork_MysqlLegworkGoodsVolumeStorage($this->curr_sid);
        if(is_array($volumeList) && !empty($volumeList)){
            $volume_list = $volume_model->getVolumeTradeTypeList(0,0,$type,$tradeType);
            if(!empty($volume_list)){
                $del_id = array();
                foreach($volume_list as $val){
                    if(isset($volumeList[$val['algv_sort']])){
                        $set = array(
                            'algv_sort' => $volumeList[$val['algv_sort']]['index'],
                            'algv_name'   => $volumeList[$val['algv_sort']]['name'],
                            'algv_price'   => $volumeList[$val['algv_sort']]['price'],
                        );
                        $up_ret = $volume_model->updateById($set,$val['algv_id']);
                        unset($volumeList[$val['algv_sort']]);
                    }else{
                        $del_id[] = $val['algv_id'];
                    }
                }
                if(!empty($del_id)){
                    $volume_where = array();
                    $volume_where[] = array('name' => 'algv_id','oper' => 'in' , 'value' => $del_id);
                    $volume_model->deleteValue($volume_where);
                }

            }
            if(!empty($volumeList)){
                $insert = array();
                foreach($volumeList as $val){
                    $insert[] = " (NULL, {$this->curr_sid},'{$val['name']}', '{$val['index']}','{$val['price']}', '{$type}', '{$tradeType}', '".time()."')";
                }
                $ins_ret = $volume_model->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'algv_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'algv_type','oper' => '=' , 'value' => $type);
            $where[] = array('name' => 'algv_trade_type','oper' => '=' , 'value' => $tradeType);
            $volume_model->deleteValue($where);
        }
        return true;
    }

    private function _save_goods_price($type = 0){
        $priceList = $this->request->getArrParam('priceList');
        $price_model = new App_Model_Legwork_MysqlLegworkGoodsPriceStorage($this->curr_sid);
        if(is_array($priceList) && !empty($priceList)){
            for($i=0;$i<count($priceList);$i++){


                if($i == 0 && !($priceList[$i]['min'] > 0)){
                    $priceList[$i]['flag'] = 1;//表示开始
                }elseif($i == count($priceList) -1 && !($priceList[$i]['max'] > 0)){
                    $priceList[$i]['flag'] = 2;//表示结束
                }else{
                    if($priceList[$i]['min'] >0 && $priceList[$i]['max'] > 0 ){
                        if($priceList[$i]['min'] >= $priceList[$i]['max']){
                            $this->displayJsonError('费用最小值必须小于最大值');
                        }
                    }else{
                        $this->displayJsonError('中间费用必须大于0');
                    }

                    $priceList[$i]['flag'] = 0;
                }
                for($j=$i+1;$j<count($priceList);$j++){
                    $cross = $this->_is_price_cross($priceList[$i]['min'],$priceList[$i]['max'],$priceList[$j]['min'],$priceList[$j]['max']);
                    if($cross){
                        $this->displayJsonError('价格标签有重复区间');
                    }
                }
            }


            $price_list = $price_model->getPriceList(0,0,$type);
            if(!empty($price_list)){
                $del_id = array();
                foreach($price_list as $val){
                    if(isset($priceList[$val['algp_sort']])){
                        $set = array(
                            'algp_sort' => $priceList[$val['algp_sort']]['index'],
                            'algp_min'   => $priceList[$val['algp_sort']]['min'],
                            'algp_max'   => $priceList[$val['algp_sort']]['max'],
                            'algp_flag'  => $priceList[$val['algp_sort']]['flag']
                        );
                        $up_ret = $price_model->updateById($set,$val['algp_id']);
                        unset($priceList[$val['algp_sort']]);
                    }else{
                        $del_id[] = $val['algp_id'];
                    }
                }
                if(!empty($del_id)){
                    $price_where = array();
                    $price_where[] = array('name' => 'algp_id','oper' => 'in' , 'value' => $del_id);
                    $price_model->deleteValue($price_where);
                }

            }
            if(!empty($priceList)){
                $insert = array();
                foreach($priceList as $val){
                    $insert[] = " (NULL, {$this->curr_sid},'{$val['min']}','{$val['max']}', '{$val['index']}','{$val['flag']}', '{$type}', '".time()."')";
                }
                $ins_ret = $price_model->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'algp_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'algp_type','oper' => '=' , 'value' => $type);
            $price_model->deleteValue($where);
        }
        return true;
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

    
    private function utf8_str_to_unicode($utf8_str) {
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

    
    public function saveLegworkPriceCfgAction(){
        $max_distance = $this->request->getFloatParam('max_distance');
        $max_weight = $this->request->getFloatParam('max_weight');
        $basic_distance = $this->request->getFloatParam('basic_distance');
        $basic_price = $this->request->getFloatParam('basic_price');
        $distanceList = $this->request->getArrParam('distanceList');
        $weightList = $this->request->getArrParam('weightList');
        $timeList = $this->request->getArrParam('timeList');
        $using = $this->request->getIntParam('using',0);
        $type = $this->request->getIntParam('type');
        $distanceValue = [];
        $weightValue = [];
        $timeValue = [];

        if($max_distance < 0 || $basic_distance < 0 || $basic_price < 0 ){
            $this->displayJsonError('配送费用设置不能为0');
        }

        if(is_array($distanceList) && !empty($distanceList)){
            foreach ($distanceList as $key => $distance){
                if($distance['min'] >= 0 && $distance['max'] > 0){
                    if($distance['min'] >= $distance['max']){
                        $this->displayJsonError('距离最小值必须小于最大值');
                    }
                    $distanceValue[] = $distance;
                }else{
                    $this->displayJsonError('请将距离分段信息填写完整');
                }
            }
            if(!empty($distanceValue)){
                for($i=0;$i<count($distanceValue);$i++){
                    for($j=$i+1;$j<count($distanceValue);$j++){
                        $cross = $this->_is_price_cross($distanceValue[$i]['min'],$distanceValue[$i]['max'],$distanceValue[$j]['min'],$distanceValue[$j]['max']);
                        if($cross){
                            $this->displayJsonError('距离分段有重复区间');
                        }
                    }
                }
            }
        }
        $distanceValue = json_encode($distanceValue);

        if(is_array($weightList) && !empty($weightList)){
            foreach ($weightList as $weight){
                if($weight['min'] >= 0 && $weight['max'] > 0 ){
                    if($weight['min'] >= $weight['max']){
                        $this->displayJsonError('重量最小值必须小于最大值');
                    }
                    $weightValue[] = $weight;
                }else{
                    $this->displayJsonError('请将重量分段信息填写完整');
                }
            }
            if(!empty($weightValue)){
                for($i=0;$i<count($weightValue);$i++){
                    for($j=$i+1;$j<count($weightValue);$j++){
                        $cross = $this->_is_price_cross($weightValue[$i]['min'],$weightValue[$i]['max'],$weightValue[$j]['min'],$weightValue[$j]['max']);
                        if($cross){
                            $this->displayJsonError('重量分段有重复区间');
                        }
                    }
                }
            }
        }
        $weightValue = json_encode($weightValue);
        $timeValue_temp = [];
        if(is_array($timeList) && !empty($timeList)){
            foreach ($timeList as $time){
                if($time['min']  && $time['max']){
                    $min_temp = strtotime($time['min']);
                    $max_temp = strtotime($time['max']);
                    if($min_temp >= $max_temp){
                        $this->displayJsonError('时间最小值必须小于最大值');
                    }
                    $timeValue[] = $time;
                    $timeValue_temp[] = [
                        'min' => $min_temp,
                        'max' => $max_temp
                    ];
                }else{
                    $this->displayJsonError('请将时间分段信息填写完整');
                }
            }
            if(!empty($timeValue_temp)){
                for($i=0;$i<count($timeValue_temp);$i++){
                    for($j=$i+1;$j<count($timeValue_temp);$j++){
                        $cross = $this->_is_price_cross($timeValue_temp[$i]['min'],$timeValue_temp[$i]['max'],$timeValue_temp[$j]['min'],$timeValue_temp[$j]['max']);
                        if($cross){
                            $this->displayJsonError('时间分段有重复区间');
                        }
                    }
                }
            }
        }
        $timeValue = json_encode($timeValue);

        $set = [
            'alc_max_distance' => $max_distance,
            'alc_basic_distance' => $basic_distance,
            'alc_basic_price' => $basic_price,
            'alc_max_weight' => $max_weight,
            'alc_update_time' => time(),
            'alc_distance_section' => $distanceValue,
            'alc_weight_section' => $weightValue,
            'alc_time_section' => $timeValue,
        ];

        if($type == 0){
            $set['alc_using'] = 1;
        }else{
            $set['alc_using'] = $using;
        }


        $cfg_model = new App_Model_Legwork_MysqlLegworkPriceCfgStorage($this->curr_sid);
        $exist = $cfg_model->findUpdateBySid($type);
        if($exist){
            $res = $cfg_model->findUpdateBySid($type,0,$set);
        }else{
            $set['alc_s_id'] = $this->curr_sid;
            $set['alc_trade_type'] = $type;
            $set['alc_create_time'] = time();
            $res = $cfg_model->insertValue($set);
        }
        $this->_save_goods_volume(0,$type);

        if($res){
            App_Helper_OperateLog::saveOperateLog("订单价格配置保存成功");
        }

        $this->showAjaxResult($res);

    }
}