<?php

class App_Controller_Wxapp_ThreeController extends App_Controller_Wxapp_InitController {

    const PROMOTION_TOOL_KEY    = 'wfx';
    const WEIXIN_PAT_REDPACK    = 1;//微信红包形式
    const WEIXIN_PAY_TRANSFER   = 2;//微信企业转账到零钱
    const WEIXIN_PAY_BANK       = 3;//微信企业转账到银行卡

    private $application_status = null;
    private $hold_dir;
    private $access_path;

    public function __construct() {
        parent::__construct();
        $expire = "  应用已开通, 到期时间: ".date('Y-m-d H:i:s', $this->wxapp_cfg['ac_expire_time']);
        $this->application_status   = array('code'=>0,'expire'=>$this->wxapp_cfg['ac_expire_time'],'msg' => trim($expire),'level'=>3);
        
        $this->hold_dir     = PLUM_APP_BUILD.'/spread/';
        $this->access_path  = PLUM_PATH_PUBLIC.'/build/spread/';
    }
    
    public function secondLink($type='index'){
        $shopType = $this->shops[$this->curr_sid]['s_type'];
        $shop     = plum_parse_config('shopType');
        $name     = $shop[$shopType];
        $name     = mb_substr($name,0,mb_strlen($name)-2);
        $link = array(
            array(
                'label' => '分销配置',
                'link'  => '/wxapp/three/index',
                'active'=> 'index'
            ),
            array(
                'label' => '分销中心',
                'link'  => '/wxapp/three/center',
                'active'=> 'center'
            ),
            array(
                'label' => '佣金设置',
                'link'  => '/wxapp/three/deduct',
                'active'=> 'deduct'
            ),
            array(
                'label' => '单品分销',
                'link'  => '/wxapp/three/goodsRatio',
                'active'=> 'goods'
            ),
            array(
                'label' => '会员关系',
                'link'  => '/wxapp/three/member',
                'active'=> 'member'
            ),
            array(
                'label' => '分销订单',
                'link'  => '/wxapp/three/order',
                'active'=> 'order'
            ),
            array(
                'label' => '会员提现',
                'link'  => '/wxapp/three/withdraw',
                'active'=> 'withdraw'
            ),
        );
        if($this->curr_sid==7163 || $this->curr_sid==7224){
            $link[] = array(
                'label' => '会员等级',
                'link'  => '/wxapp/three/setupLevel',
                'active'=> 'level'
            );
        }
        $this->output['link']       = $link;
        $this->output['linkType']   = $type;
        $this->output['snTitle']    = '微分销';
    }
    
    public function indexAction(){
        $this->secondLink('index');
        $center_model   = new App_Model_Member_MysqlMemberCenterStorage();
        $row            = $center_model->findUpdateBySid($this->curr_sid);
        $three_cfg  = new App_Model_Three_MysqlCfgStorage($this->curr_sid);
        $tcRow         = $three_cfg->findShopCfg();
        if(!$tcRow){
            $updata = array(
                'tc_type'           => 1,
                'tc_open_time'      => $this->wxapp_cfg['ac_open_time'],
                'tc_expire_time'    => $this->wxapp_cfg['ac_expire_time'],
                'tc_update_time'    => time(),
                'tc_s_id'           => $this->curr_sid,
                'tc_is_branch'      => 0,
                'tc_level'          => 3,
                'tc_cashier_open'   => 0,
                'tc_show_deduct_open' => 0,
                'tc_domain'         => $this->_get_domain()
            );
            $three_cfg->insertValue($updata);
        }
        $row['tc_level']     = $tcRow['tc_level'];
        $row['tc_cashier_open'] = $tcRow['tc_cashier_open'];
        $row['tc_show_deduct_open'] = $tcRow['tc_show_deduct_open'];
        $row['tc_istip']     = $tcRow['tc_istip'];
        $row['tc_f_audit']   = $tcRow['tc_f_audit'];
        $row['tc_card_deduct']   = $tcRow['tc_card_deduct'];  
        $this->output['row'] = $row;
        $this->output['tcRow'] = $tcRow;

        $cgf_model =  new App_Model_Shop_MysqlWithdrawCfgStorage();
        $withdraw = $cgf_model->findCfgBySid($this->curr_sid);
        $this->output['withdraw'] = $withdraw;

        $showRoundType = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[21])){
            $showRoundType = 1;
        }
        $this->output['showRoundType'] = $showRoundType;
        $this->output['appletCfg'] = $this->wxapp_cfg;

        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '分销中心', 'link' => '/wxapp/three/index'),
            array('title' => '分销配置', 'link' => '#'),
        ));
        $this->output['app_status'] = $this->application_status;
        
        $this->displaySmarty('wxapp/three/three-cfg-new.tpl');
    }

    
    private function _get_domain(){
        $domain_storage   = new App_Model_Applet_MysqlAppletDomainStorage();
        $domain = $domain_storage->getListFirst();
        return $domain['asd_domain'];
    }

    
    public function codeAction(){
        $this->secondLink('index');
        $center_model   = new App_Model_Member_MysqlMemberCenterStorage();
        $row            = $center_model->findUpdateBySid($this->curr_sid);
        $avatar         = $this->get_left_top_by_pos($row['cc_avatar_loc'],'avatar');
        $row['avatar_l']= $avatar['left'];
        $row['avatar_t']= $avatar['top'];
        $code           = $this->get_left_top_by_pos($row['cc_qrcode_loc'],'code');
        $row['code_l']  = $code['left'];
        $row['code_t']  = $code['top'];
        $this->output['row'] = $row;
        if($this->request->getIntParam('test')==1){
            plum_msg_dump($row);
        }
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '分销中心', 'link' => '/wxapp/three/index'),
            array('title' => '微海报设置', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/three/code.tpl');
    }
    private function get_left_top_by_pos($pos,$type){
        if($type == 'avatar'){
            $ret    = array(
                'left' => 30,
                'top'  => 30
            );
        }else{
            $ret    = array(
                'left' => 70,
                'top'  => 150
            );
        }

        if($pos){
            $str    = str_replace('(','',$pos);
            $str    = str_replace(')','',$str);
            $temp   = explode(',',$str);
            $ret['left']    = intval($temp[0])/2;
            $ret['top']     = intval($temp[1])/2;
        }
        return $ret;
    }

    public function saveCodeAction(){
        $data = array();
        $data['cc_avatar_loc']   = $this->request->getStrParam('userInfoPos');
        $data['cc_qrcode_loc']   = $this->request->getStrParam('codePos');
        $data['cc_qrcode_bg']    = $this->request->getStrParam('codeBg');
        $data['cc_qrcode_size']  = $this->request->getIntParam('codeSize');
        $center_model = new App_Model_Member_MysqlMemberCenterStorage();
        $centerRow    = $center_model->isExistBySid($this->curr_sid);
        if(empty($centerRow)){
            $data['cc_s_id'] = $this->curr_sid;
            $data['cc_create_time'] = time();
            $ret1 = $center_model->insertValue($data);
        }
        $center_model   = new App_Model_Member_MysqlMemberCenterStorage();
        $ret = $center_model->findUpdateBySid($this->curr_sid,$data);

        if($ret){
            App_Helper_OperateLog::saveOperateLog("分销海报配置保存成功");
        }

        $this->showAjaxResult($ret,'保存');
    }
    
    public function deductAction(){
        $this->secondLink('deduct');
        $deduct_model = new App_Model_Shop_MysqlDeductStorage();
        $list = $deduct_model->getListByShopId($this->curr_sid);
        $threeSale  = App_Helper_ShopWeixin::checkShopThreeLevel($this->curr_sid);
        $cfg_model = new App_Model_Three_MysqlCfgStorage($this->curr_sid);
        $cfg = $cfg_model->findShopCfg();
        $this->output['cfg'] = $cfg;

        $this->output['level'] = $threeSale;
        $this->output['list']  = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '分销中心', 'link' => '/wxapp/three/index'),
            array('title' => '佣金配置', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/three/deduct-list.tpl');
    }

    
    public function saveDeductAction(){
        $id        = $this->request->getIntParam('deductId');
        $buy_num   = $this->request->getStrParam('buy_num');//购买次数
        $back_num  = $this->request->getIntParam('back_num');
        $type      = $this->request->getIntParam('type', 1);
        $name      = $this->request->getStrParam('name');

        $data      = array();
        $data['dc_buy_num']  = $buy_num;
        $data['dc_type']  = $type;
        $data['dc_back_num'] = 0;
        for($i=0;$i<=3;$i++){
            $data['dc_'.$i.'f_ratio']= $this->request->getFloatParam('ratio'.$i);
        }
        $data['dc_update_time'] = time();

        $deduct_model = new App_Model_Shop_MysqlDeductStorage();
            if($id){
                $ret = $deduct_model->updateById($data,$id);
            }else{
                $data['dc_create_time'] = time();
                $data['dc_s_id']        = $this->curr_sid;
                $ret = $deduct_model->insertValue($data);
            }

            if($ret){
                App_Helper_OperateLog::saveOperateLog("分销佣金比例配置保存成功");
            }

            $this->showAjaxResult($ret,'保存');

    }

    
    public function delDeductAction(){
        $id = $this->request->getIntParam('deductId');
        $deduct_model = new App_Model_Shop_MysqlDeductStorage();
        $ret = $deduct_model->deleteBySidId($id,$this->curr_sid);

        if($ret){
            App_Helper_OperateLog::saveOperateLog("分销佣金比例配置删除成功");
        }

        $this->showAjaxResult($ret,'删除');
    }

    
    public function centerAction(){
        $this->secondLink('center');
        $center_model   = new App_Model_Member_MysqlMemberCenterStorage();
        $row            = $center_model->findUpdateBySid($this->curr_sid);
        $row['tc_level']     =  App_Helper_ShopWeixin::checkShopThreeLevel($this->curr_sid);
        $this->output['row'] = $row;
        $this->_show_tpl_notice();
        $this->_show_shop_article();
        $this->_shop_information();
        $this->output['appletCfg'] = $this->wxapp_cfg;
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '分销中心', 'link' => '/wxapp/three/index'),
            array('title' => '分销中心', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/three/sale-center.tpl');
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

    
    public function saveCenterAction(){
        $data  = array();
        $pageType = $this->request->getStrParam('pageType');//页面来源
        if($pageType == 'cfg'){
            $data['cc_min_num']      = $this->request->getIntParam('number');
            $data['cc_min_amount']   = $this->request->getFloatParam('money');
            $data['cc_show_refer']   = $this->request->getIntParam('refer');
            $data['cc_must_set']     = $this->request->getIntParam('must');
            $data['cc_noqr_tip']     = $this->request->getStrParam('noqrTip');
            $data['cc_recharge_amount'] = $this->request->getIntParam('recharge');

            $qrcode   = $this->request->getStrParam('qrcode_bg');//二维码图片
            if($qrcode){
                $data['cc_qrcode_bg']  = $qrcode;
            }
            $this->_save_three_cfg();
            if(in_array($this->wxapp_cfg['ac_type'],[21])){
                $roundType = $this->request->getIntParam('roundType');
                $this->_save_round_type($roundType);
            }

        }else{
            $data['cc_center_title'] = $this->request->getStrParam('title');//主页标题
            $data['cc_center_color'] = $this->request->getStrParam('color');
            $bground    = $this->request->getStrParam('center_bg');//主页标题
            if($bground){
                $data['cc_center_bg'] = $bground;
            }

            $show = array('myuser','myshare','mycash','myorder','myrefer','myinfo','mywith','mycode','myrank','mynotice','goodsratio', 'mybranch_audit');
            foreach($show as $val){
                $temp = $this->request->getIntParam($val);
                if(in_array($temp,array(0,1))){
                    $data['cc_'.$val.'_show'] = $temp;
                }
                if($val == 'myuser'){
                    for($i=0;$i<=3;$i++){
                        $name = $this->request->getStrParam($val.'_name'.$i);
                        $data['cc_'.$val.'_name'.$i] = $name;
                    }
                }else{
                    $name = $this->request->getStrParam($val.'_name');
                    $data['cc_'.$val.'_name'] = $name;
                }
            }
            $this->_save_train_notice();


        }

        $data['cc_update_time'] = time();
        $center_model = new App_Model_Member_MysqlMemberCenterStorage();
        $centerRow    = $center_model->isExistBySid($this->curr_sid);
        if(!empty($centerRow)){
            $ret = $center_model->findUpdateBySid($this->curr_sid,$data);
            if(isset($data['cc_qrcode_bg']) && $data['cc_qrcode_bg'] && $centerRow['cc_qrcode_bg'] != $data['cc_qrcode_bg']){
                $this->_check_qrcode_change($centerRow['cc_qrcode_bg'],$data['cc_qrcode_bg']);
            }
        }else{
            $data['cc_s_id'] = $this->curr_sid;
            $data['cc_create_time'] = time();
            $ret = $center_model->insertValue($data);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("分销中心配置保存成功");
        }

        $this->showAjaxResult($ret,'保存');
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
    
    private function _show_shop_article(){
        $article_model     = new App_Model_Applet_MysqlAppletInformationStorage();
        $where         = array();
        $where[]       = array('name'=>'ai_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]       = array('name'=>'ai_deleted','oper'=>'=','value'=>0);
        $sort          = array('ai_create_time' => 'DESC');
        $list          = $article_model->getList($where,0,0,$sort);
        $json = array();
        foreach ($list as $key => $value) {
            $json[] = array(
                'id'      => $value['ai_id'],
                'name'    => $value['ai_title'],
            );
        }
        if($this->request->getIntParam('test')==1){
            plum_msg_dump($json);
        }
        $this->output['articles'] = json_encode($json);
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

    
    private function _save_three_cfg(){
        $level = $this->request->getIntParam('level');
        $cashierOpen = $this->request->getIntParam('cashierOpen');
        $showDeductOpen = $this->request->getIntParam('showDeductOpen');
        $cardDeduct=$this->request->getIntParam('cardDeduct',0);
        $audit = $this->request->getIntParam('audit');
        $istip   = $this->request->getIntParam('istip');
        $set   = array();
        if($level){
            $set['tc_level'] = $level;
            $set['tc_istip'] = $istip;
            $set['tc_f_audit'] = $audit;
            $set['tc_cashier_open'] = $cashierOpen;
            $set['tc_show_deduct_open'] = $showDeductOpen;
            $set['tc_card_deduct']      =$cardDeduct;
        }

       
        if(!empty($level)){
            $three_cfg = new App_Model_Three_MysqlCfgStorage($this->curr_sid);
            $three_cfg->findShopCfg($set);
        }
    }
    
    private function _check_qrcode_change($old,$new){
        $old_arr = explode('/',$old);
        $new_arr = explode('/',$new);
        if($old_arr[count($old_arr) - 1] != $new_arr[count($new_arr) - 1]){
            $member_helper = new App_Helper_MemberLevel();
            $member_helper->clearSpreadImage($this->curr_sid);
        }
    }
    public function memberAction(){
        $this->secondLink('member');
        $this->_show_member_data_list();
        $table_menu = new App_Helper_TableMenu();
        $this->output['choseLink'] = $table_menu->showTableLink('wxappThreeMember');
        $level_model = new App_Model_Member_MysqlLevelStorage();
        $this->output['mLevel'] = $level_model->getListBySidForSelect($this->curr_sid);
        $threeSale  = App_Helper_ShopWeixin::checkShopThreeLevel($this->curr_sid);
        $this->output['threeLevel'] = $threeSale;
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '分销中心', 'link' => '/wxapp/three/index'),
            array('title' => '会员关系', 'link' => '#'),
        ));
        $deduct_model   = new App_Model_Shop_MysqlDeductStorage();
        $decuct         = $deduct_model->getList(array(),0,0,array());
        $this->output['deduct'] = array_column($decuct,'dc_buy_num','dc_id');
        $this->displaySmarty('wxapp/three/member-list.tpl');
    }
    private function _show_member_data_list(){
        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;

        $where = array();
        $where[] = array('name' => 'm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        
        $output = array();
        $output['nickname'] = $this->request->getStrParam('nickname');
        if($output['nickname']){
            $where[] = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$output['nickname']}%");
        }
        $output['type'] = $this->request->getStrParam('type','all');
//        if($output['type'] != 'highest' && $output['type'] != 'normal'){
//            $where[] = ' ( m_1f_id != 0 OR m_is_highest = 1 ) ';
//        }
        $where[] = array('name' => 'm_is_highest', 'oper' => '>', 'value' => 0);
//        if($output['type'] == 'slient'){
//            $where[] = array('name' => 'm_is_slient', 'oper' => '=', 'value' => 1);
//        }else{
//            if($output['type'] == 'highest'){
//                $where[] = array('name' => 'm_is_highest', 'oper' => '=', 'value' => 1);
//            }elseif($output['type'] == 'normal'){
//                $where[] = array('name' => 'm_is_highest', 'oper' => '=', 'value' => 0);
//                $where[] = array('name' => 'm_1f_id', 'oper' => '=', 'value' => 0);
//            }elseif($output['type'] == 'refer'){
//                $where[] = array('name' => 'm_is_refer', 'oper' => '=', 'value' => 1);
//            }elseif($output['type'] == 'out'){
//                $where[] = array('name' => 'm_is_follow', 'oper' => '=', 'value' => 0);
//            }
//        }
        $output['mid'] = $this->request->getIntParam('mid');
        if($output['mid']){
            $where[] = array('name' => 'm_show_id', 'oper' => '=', 'value' => $output['mid']);
        }
        $output['mobile'] = $this->request->getStrParam('mobile');
        if($output['mobile']){
            $where[] = array('name' => 'm_mobile', 'oper' => '=', 'value' => $output['mobile']);
        }
        $output['remark'] = $this->request->getStrParam('remark');
        if($output['remark']){
            $where[] = array('name' => 'm_remark', 'oper' => 'like', 'value' => "%{$output['remark']}%");
        }

        $output['rmid'] = $this->request->getIntParam('realMid');
        if($output['rmid']){
            $where[] = array('name' => 'm_id', 'oper' => '=', 'value' => $output['rmid']);
        }
        for($i=1;$i<=3;$i++){
            $fid = $this->request->getIntParam($i.'f_id');
            if($fid){
                $where[] = array('name' => 'm_'.$i.'f_id', 'oper' => '=', 'value' => $fid);
            }
        }

        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $total = $member_model->getCount($where);

        $page_plugin = new Libs_Pagination_Paginator($total,$this->count,'jquery',1);
        $output['paginator'] = $page_plugin->render();
        $list = array();
        if($total > $index){
            $list = $member_model->getMemberBySubordinateCount($where,$index,$this->count);
            $output['level'] = $this->show_member_level_info($list);
        }
        foreach($list as $key=>$val){
            for ($i=1; $i<=3; $i++) {
                $where = array();
                $where[] = array('name' => 'm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
                $where[] = array('name' => 'm_'.$i.'f_id', 'oper' => '=', 'value' => $val['m_id']);
                $total = $member_model->getCount($where);
                $list[$key]['total'.$i] = $total;
            }
          if($val['m_is_highest'] == 1){
                $extra_model = new App_Model_Member_MysqlMemberExtraStorage();
                $ewhere      = array();
                $ewhere[]    = array('name'=>'ame_m_id','oper'=>'=','value'=>$val['m_id']);
                $area        = $extra_model->getAreaRow($ewhere);
            	if($area){
                	$list[$key]['area'] = $area['p_name'].'-'.$area['c_name'].'-'.$area['a_name'];
                }else{
                    $list[$key]['area'] = '';
                }
            }else{
          		$list[$key]['area'] = '';
          }
        }
        $output['list'] = $list;
        $where_total = $where_highest = [];
       // $where_total[] = ' ( m_1f_id != 0 AND m_is_highest > 0 ) ';
        $where_total[] = ['name' => 'm_is_highest', 'oper' => '>', 'value' => 0];
        $where_total[] = $where_highest[] = ['name' => 'm_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where_highest[] = ['name' => 'm_1f_id', 'oper' => '=', 'value' => 0];
        $where_highest[] = ['name' => ' m_is_highest', 'oper' => '>', 'value' => 0];
        $totalInfo = $member_model->getThreeStatInfo($where_total);
        $highestCount = $member_model->getCount($where_highest);
        $statInfo = [
            'total' => intval($totalInfo['total']),
            'sale'  => intval($totalInfo['sale']),
            'deduct' => intval($totalInfo['deduct']),
            'highestTotal' => intval($highestCount)
        ];
        $output['statInfo'] = $statInfo;

        $this->showOutput($output);
    }
    public function orderAction() {
        $this->secondLink('order');
        $this->showTypeByKey('trade_status');
        $table_menu = new App_Helper_TableMenu();
        $this->output['choseLink'] = $table_menu->showTableLink('wxappThreeOrder');
        $threeSale  = App_Helper_ShopWeixin::checkShopThreeLevel($this->curr_sid);
        $this->output['threeLevel'] = $threeSale;

        $where[] = array('name'=>'t_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET );
        $this->output['todayTradeInfo'] = $this->_show_order_stat($where,true);

        $this->_show_order_data_list();
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '分销中心', 'link' => '/wxapp/three/index'),
            array('title' => '分销订单', 'link' => '#'),
        ));

        $where = array();
        $where[] = array('name' => 'm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = ' ( m_1f_id != 0 OR m_is_highest = 1 ) ';
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $threeMemberList = $member_model->getMemberBySubordinateCount($where,0,0);
        $threeMember = array();
        foreach ($threeMemberList as $value){
            $threeMember[$value['m_id']] = $value['m_nickname'];
        }

        if($this->wxapp_cfg['ac_type'] == 27){
            $goodsName = '课程';
        }else{
            $goodsName = '商品';
        }
        $this->output['threeMember'] = $threeMember;
        $this->output['goodsName'] = $goodsName;
        $this->output['appletCfg'] = $this->wxapp_cfg;
        $this->displaySmarty('wxapp/three/order-list.tpl');
    }
    private function _show_order_data_list(){
        $page = $this->request->getIntParam('page');
        $index= $page * $this->count;
        $sort   = array('od_create_time' => 'DESC');//订单生成时间倒序排列
        $where = array();
        $where[] = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name'=>'t_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET );
        $where[] = array('name'=>'od_share_goods','oper'=>'=','value'=>0 );
        $output = array();
        $output['tid'] = $this->request->getStrParam('tid');
        if($output['tid']){
            $where[] = array('name' => 't_tid', 'oper' => '=', 'value' => $output['tid']);
        }
        $output['title'] = $this->request->getStrParam('title');
        if($output['title']){
            $where[] = array('name' => 't_title', 'oper' => 'like', 'value' => "%{$output['title']}%");
        }
        $output['nickname'] = $this->request->getStrParam('nickname');
        if($output['nickname']){
            $where[] = array('name' => 't_buyer_nick', 'oper' => 'like', 'value' => "%{$output['nickname']}%");
        }
        $output['status'] = $this->request->getStrParam('status','all');
        $status = plum_parse_config('trade_status_search');
        if(isset($status[$output['status']]) && $status[$output['status']]){
            $where[] = array('name' => 't_status', 'oper' => '=', 'value' => $status[$output['status']]);
        }
        for($i=1;$i<=3;$i++){
            $fid = $this->request->getIntParam($i.'f_id');
            if($fid){
                $where[] = array('name' => 'od_'.$i.'f_id', 'oper' => '=', 'value' => $fid);
            }
        }
        $output['mid'] = $this->request->getIntParam('mid');
        if($output['mid']){
            $where[] = array('name' => 't_m_id', 'oper' => '=', 'value' => $output['mid']);
        }


        $output['start']   = $this->request->getStrParam('start');
        if($output['start']){
            $where[]    = array('name' => 't_create_time', 'oper' => '>=', 'value' => strtotime($output['start']));
        }
        $output['end']     = $this->request->getStrParam('end');
        if($output['end']){
            $where[]    = array('name' => 't_create_time', 'oper' => '<=', 'value' => (strtotime($output['end']) + 86400));
        }

        $output['fid'] = $this->request->getIntParam('fid');
        if($output['fid']){
            $where[] = " (od_1f_id=".$output['fid']." or od_2f_id=".$output['fid']." or od_3f_id=".$output['fid'].")";
        }

        $deduct_storage  = new App_Model_Shop_MysqlOrderDeductStorage($this->curr_sid);
        $total = $deduct_storage->getDeductByMidSidCount($where);
        $output['searchTradeInfo'] = $this->_show_order_stat($where,FALSE);
        $page_plugin = new Libs_Pagination_Paginator($total,$this->count,'jquery');
        $this->output['paginator'] = $page_plugin->render();
        $list = array();
        if($total > $index){
            if($this->wxapp_cfg['ac_type'] == 12){
                $list = $deduct_storage->getTrainDeductByMidSid($where,$index,$this->count,$sort);
            }else{
                $list = $deduct_storage->getDeductByMidSid($where,$index,$this->count,$sort);
            }
            $this->output['level'] = $this->show_member_level_info($list,'od_');
        }
        $output['list'] = $list;
        $this->showOutput($output);
    }

    private function _show_card_order_data_list(){
        $page = $this->request->getIntParam('page');
        $index= $page * $this->count;
        $sort   = array('od_create_time' => 'DESC');//订单生成时间倒序排列
        $where = array();
        $where[] = array('name' => 'oo_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'oo_status', 'oper' => '=', 'value' => 2);
        $where[] = array('name' => 'od_type', 'oper' => '=', 'value' => 3);
        $output = array();
        $output['tid'] = $this->request->getStrParam('tid');
        if($output['tid']){
            $where[] = array('name' => 'oo_tid', 'oper' => '=', 'value' => $output['tid']);
        }
        $output['title'] = $this->request->getStrParam('title');
        if($output['title']){
            $where[] = array('name' => 'oo_title', 'oper' => 'like', 'value' => "%{$output['title']}%");
        }
        $output['nickname'] = $this->request->getStrParam('nickname');
        if($output['nickname']){
            $where[] = array('name' => 'oo_buyer_nick', 'oper' => 'like', 'value' => "%{$output['nickname']}%");
        }
        $output['mid'] = $this->request->getIntParam('mid');
        if($output['mid']){
            $where[] = array('name' => 'oo_m_id', 'oper' => '=', 'value' => $output['mid']);
        }
        for($i=1;$i<=3;$i++){
            $fid = $this->request->getIntParam($i.'f_id');
            if($fid){
                $where[] = array('name' => 'od_'.$i.'f_id', 'oper' => '=', 'value' => $fid);
            }
        }


        $output['start']   = $this->request->getStrParam('start');
        if($output['start']){
            $where[]    = array('name' => 'oo_create_time', 'oper' => '>=', 'value' => strtotime($output['start']));
        }
        $output['end']     = $this->request->getStrParam('end');
        if($output['end']){
            $where[]    = array('name' => 'oo_create_time', 'oper' => '<=', 'value' => (strtotime($output['end']) + 86400));
        }

        $output['fid'] = $this->request->getIntParam('fid');
        if($output['fid']){
            $where[] = " (od_1f_id=".$output['fid']." or od_2f_id=".$output['fid']." or od_3f_id=".$output['fid'].")";
        }

        $deduct_storage  = new App_Model_Shop_MysqlOrderDeductStorage($this->curr_sid);
        $total = $deduct_storage->getDeductCardOrderCountByMidSid($where);
        $output['searchTradeInfo'] = $this->_show_card_order_stat($where,FALSE);
        $page_plugin = new Libs_Pagination_Paginator($total,$this->count,'jquery');
        $this->output['paginator'] = $page_plugin->render();
        $list = array();
        if($total > $index){
            $list = $deduct_storage->getDeductCardOrderByMidSid($where,$index,$this->count,$sort);
            $this->output['level'] = $this->show_member_level_info($list,'od_');
        }
        $output['list'] = $list;
        $this->showOutput($output);
    }

    
    public function dayBookAction(){
        $this->secondLink('member');
        $this->output['showSecond'] = 1;
        $page            = $this->request->getIntParam('page');
        $index           = $page * $this->count;
        $output          = array();
        $output['mid']   = $this->request->getIntParam('mid');
        $level           = $this->request->getIntParam('level');
        $output['type']  = $this->request->getStrParam('type','all');
        $member_model    = new App_Model_Member_MysqlMemberCoreStorage();
        $member          = $member_model->getRowByIdSid($output['mid'],$this->curr_sid);
        if($member){
            $output['member'] = $member;
            $where      = array();
            $where[]    = array('name' => 'dd_m_id', 'oper' => '=', 'value' => $member['m_id']);
            if($level){//提成级别搜索
                $where[] = array('name' => 'dd_level', 'oper' => '=', 'value' => $level-1);
            }
            
            if($output['type']){
                switch ($output['type']){
                    case 'cash':
                        $where[] = array('name' => 'dd_record_type', 'oper' => '=', 'value' => 1);
                        break;
                    case 'share':
                        $where[] = array('name' => 'dd_record_type', 'oper' => '=', 'value' => 2);
                        break;
                    case 'refund':
                        $where[] = array('name' => 'dd_record_type', 'oper' => '=', 'value' => 3);
                        break;
                    case 'withdraw':
                        $where[] = array('name' => 'dd_record_type', 'oper' => '=', 'value' => 4);
                        break;
                }
            }
            $dayBook_model = new App_Model_Deduct_MysqlDeductDaybookStorage();
            $total         = $dayBook_model->getCount($where);
            $page_libs     = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
            $list          = array();
            if($total > $index){
                $sort = array('dd_record_time' => 'DESC');
                $list = $dayBook_model->getList($where,$index,$this->count,$sort);
            }
            $output['list']      = $list;
            $output['paginator'] = $page_libs->render();
            $this->showOutput($output);
            $table_menu = new App_Helper_TableMenu();
            $this->output['choseLink'] = $table_menu->showTableLink('distrib_day_book',array('mid'=>$output['mid']));

            $this->buildBreadcrumbs(array(
                array('title' => '分销会员', 'link' => '/distrib/three/member'),
                array('title' => '佣金流水', 'link' => '#'),
            ));
            $this->displaySmarty('wxapp/member/day-book.tpl');
        }else{
            plum_url_location('非法请求');
        }
    }
    
    public function withdrawAction() {
        $this->secondLink('withdraw');
        $this->_get_withdraw_list_data();
        $this->output['tx_ma_map']      = plum_parse_config('applet_tx_ma_map');
        $this->output['withdrawType']   = plum_parse_config('applet_tx_map');
        $helper_model           = new App_Helper_ShopWeixin($this->curr_sid);
        $this->output['alert']  = $helper_model->checkShopMemberWithdraw();
        $this->showTypeByKey('withdraw_status');
        $this->output['bankList'] = plum_parse_config('withdraw_bank_ids');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '分销中心', 'link' => '/wxapp/three/index'),
            array('title' => '会员提现', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/three/withdraw-list.tpl');
    }

    private function _get_withdraw_list_data(){
        $output = array();
        $page = $this->request->getIntParam('page');
        $index= $page * $this->count;
        $sort = array('wd_create_time' => 'DESC');

        $where = array();
        $where[] = array('name' => 'wd_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $output['name']   = $this->request->getStrParam('name');
        if($output['name']){
            $where[] = array('name' => 'wd_realname', 'oper' => 'like', 'value' => "%{$output['name']}%");
        }
        $output['mobile'] = $this->request->getStrParam('mobile');
        if($output['mobile']){
            $where[] = array('name' => 'wd_mobile', 'oper' => '=', 'value' => $output['mobile']);
        }
        $output['audit']  = $this->request->getStrParam('audit');
        switch($output['audit']){
            case 'refuse':
                $where[] = array('name' => 'wd_audit', 'oper' => '=', 'value' => 2);
                break;
            case 'pass':
                $where[] = array('name' => 'wd_audit', 'oper' => '=', 'value' => 1);
                break;
            case 'audit':
                $where[] = array('name' => 'wd_audit', 'oper' => '=', 'value' => 0);
                break;
        }

        $withdraw_model = new App_Model_Member_MysqlWithDrawalStorage();
        $total          = $withdraw_model->getMemberCount($where);
        $page_plugin    = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $page_plugin->render();
        $list  = array();
        if($total > $index){
            $list = $withdraw_model->getMemberList($where,$index,$this->count,$sort);
        }
        $output['list'] = $list;
        $where_total = $where_pass = $where_audit = [];
        $where_total[] = $where_pass[] = $where_audit[] = ['name' => 'wd_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where_pass[] = ['name' => 'wd_audit', 'oper' => '=', 'value' => 1];
        $where_audit[] = ['name' => 'wd_audit', 'oper' => '=', 'value' => 0];
        $totalInfo = $withdraw_model->getStatInfo($where_total);
        $passInfo = $withdraw_model->getStatInfo($where_pass);
        $auditInfo = $withdraw_model->getStatInfo($where_audit);
        $statInfo = [
            'totalCount' => intval($totalInfo['total']),
            'totalMoney' => floatval($totalInfo['money']),
            'passCount' => intval($passInfo['total']),
            'passMoney' => floatval($passInfo['money']),
            'auditCount' => intval($auditInfo['total']),
            'auditMoney' => floatval($auditInfo['money']),
        ];
        $output['statInfo'] = $statInfo;

        $this->showOutput($output);
    }
    
    public function dealWithdrawAction(){
        $id     = $this->request->getIntParam('id');
        $status = $this->request->getIntParam('status');
        $type   = $this->request->getIntParam('type');
        $note   = $this->request->getStrParam('note');
        if($status == 1 && !$type){
            $this->displayJsonError('请选择转账方式');
        }
        $result = array(
            'ec' => 400,
            'em' => '请求参数错误'
        );
        if($id && $status){
            $set = array(
                'wd_audit'      => $status,
                'wd_audit_note' => $note,
                'wd_audit_time' => time()
            );
            $where   = array();
            $where[] = array('name'=>'wd_s_id','oper'=>'=','value'=>$this->curr_sid);
            $where[] = array('name'=>'wd_id','oper'=>'=','value'=>$id);
            $where[] = array('name'=>'wd_audit','oper'=>'=','value'=>0);
            $withdraw_model = new App_Model_Member_MysqlWithDrawalStorage();
            $record = $withdraw_model->getRow($where);
            if($record){
                $flag = true;
                $tid  = '';
                if(($record['wd_type'] == 1 || $record['wd_type'] == 3) && $status == 1 && in_array($type,array(1,2,3))){
                    $payRes = $this->_applet_weixin_auto_deal($record,$type);
                    if(!empty($payRes) && $payRes['errno'] == true){
                        $tid = $payRes['send_listid'];
                    }else{
                        $flag = false;
                        $result['em'] = isset($payRes['errmsg']) ? $payRes['errmsg'] :'微信红包支付失败';
                    }
                }
                if($flag){
                    if($status == 1){
                        $set['wd_curr_type']  = $type;
                    }
                    $ret = $withdraw_model->updateValue($set,$where);
                    $this->_deal_withdraw_result($record,$status,$tid);
                    if($ret){
                        $result = array(
                            'ec' => 200,
                            'em' => '处理成功'
                        );
                        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                        $member = $member_model->getRowById($record['wd_m_id']);
                        $str = $status == 1 ? '同意' : '不同意';
                        App_Helper_OperateLog::saveOperateLog("处理【{$member['m_nickname']}】提现申请成功，处理结果：{$str}");
                    }else{
                        $result['em'] = '处理失败';
                    }
                }
            }
        }
        $this->displayJson($result);
    }

    
    private function _weixin_auto_deal(array $record, $pay_type = self::WEIXIN_PAT_REDPACK) {
        if ($record['wd_type'] != 1) {
            return array('errno' => false, 'errmsg' => '非微信转账类型');
        }
        if ($record['wd_audit'] != 0) {
            return array('errno' => false, 'errmsg' => '非待审核状态');
        }
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->getRowById($record['wd_m_id']);

        $pay_model      = new App_Model_Trade_MysqlPayTypeStorage($this->curr_sid);
        $type           = $pay_model->findUpdateCfgBySid();
        if ($type && $type['pt_wxpay_zy']) {
            $wxpay_plugin   = new App_Plugin_Weixin_NewPay($this->curr_sid);
            if ($pay_type == self::WEIXIN_PAT_REDPACK) {
                $ret    = $wxpay_plugin->sendRedpack($member['m_openid'], $record['wd_money']);
            } else {
                $ret    = $wxpay_plugin->payTransfer($member['m_openid'], $record['wd_money'], $record['wd_realname']);
            }
        } else {
            $balance    = floatval($this->shops[$this->curr_sid]['s_recharge']);
            if ($balance < floatval($record['wd_money'])) {
                return array('errno' => false, 'errmsg' => '平台账户余额不足,请充值');
            }
            $fxb_plugin = new App_Plugin_Weixin_FxbPay($this->curr_sid);
            if (!$member['m_uid']) {
                return array('errno' => false, 'errmsg' => '会员信息有误');
            }
            $user_model = new App_Model_Member_MysqlUserStorage();
            $user   = $user_model->getRowById($member['m_uid']);
            $openid = $user['u_open_id'];
            if ($pay_type == self::WEIXIN_PAT_REDPACK) {
                $ret    = $fxb_plugin->sendRedpack($openid, $record['wd_money']);
                Libs_Log_Logger::outputLog($ret);
            } else {
                $ret    = $fxb_plugin->payTransfer($openid, $record['wd_money'], $record['wd_realname']);
            }
            if (!$ret['code']) {
                $inout_model    = new App_Model_Shop_MysqlBalanceInoutStorage($this->curr_sid);
                $indata = array(
                    'bi_s_id'       => $this->curr_sid,
                    'bi_title'       => "会员ID{$member['m_show_id']}申请提现{$record['wd_money']}元",
                    'bi_amount'     => $record['wd_money'],
                    'bi_balance'    => $balance-floatval($record['wd_money']),
                    'bi_type'       => 2,
                    'bi_create_time'=> time(),
                );
                $inout_model->insertValue($indata);

                $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
                $shop_model->incrementShopRecharge($this->curr_sid, -floatval($record['wd_money']));
            }
        }

        if (!$ret['code']) {
            return array('errno' => true, 'errmsg' => '微信转账成功');
        } else {
            return array('errno' => false, 'errmsg' => '微信转账失败');
        }
    }

    
    private function _deal_withdraw_result(array $record,$status,$tid=''){
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $money_ret = $member_model->dealWithdrawMoney($record['wd_m_id'],$record['wd_money'],$status);

        if($status == 1){//审核通过，则记录流水
            $data = array(
                'dd_s_id'           => $this->curr_sid,
                'dd_m_id'           => $record['wd_m_id'],
                'dd_o_id'           => $record['wd_id'],
                'dd_amount'         => $record['wd_money'],
                'dd_tid'            => $tid,
                'dd_level'          => 0,
                'dd_record_type'    => 4,
                'dd_record_time'    => time(),
                'dd_record_remark'  => '提现申请通过记录流水'
            );
            $book_model = new App_Model_Deduct_MysqlDeductDaybookStorage();
            $book_ret = $book_model->insertValue($data);
        }
        if($money_ret || $book_ret){
            return true;
        }else{
            return false;
        }
    }

    
    public function rollbackWithdrawAction(){
        $data = array(
            'ec' => 400,
            'em' => '状态错误'
        );
        $this->displayJson($data,true);

        $id = $this->request->getIntParam('id');
        $withdraw_model = new App_Model_Member_MysqlWithDrawalStorage();
        $row            = $withdraw_model->getRowByIdSid($id,$this->curr_sid);
        if($row['wd_audit'] == 1){
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $deduct_ret   = $member_model->rollbackWithdraw($row['wd_money'],$this->curr_sid,$row['wd_m_id']);
            if($deduct_ret){
                $set = array(
                    'wd_audit' => 0
                );
                $ret  = $withdraw_model->getRowUpdateByIdSid($id,$this->curr_sid,$set);
                $data = $this->showAjaxResult($ret,'回滚',1);
            }else{
                $data['em'] = '回滚金额失败';
            }
        }
        $this->displayJson($data);
    }

    
    public function withdrawCfgAction(){
        $this->secondLink('withdraw');
        $cgf_model =  new App_Model_Shop_MysqlWithdrawCfgStorage();
        $row = $cgf_model->findCfgBySid($this->curr_sid);
        $this->output['row'] = $row;
        $this->buildBreadcrumbs(array(
            array('title' => '提现管理', 'link' => '/wxapp/three/withdraw'),
            array('title' => '提现配置', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/three/withdraw-cfg.tpl');
    }
    public function branchAction(){
        $this->secondLink('branch');
        $this->branch_list_data();
        $this->output['statusDesc'] = plum_parse_config('audit','status');
        $this->output['color']      = plum_parse_config('color','status');
        $this->output['fontColor']  = plum_parse_config('fontColor','status');
        $three_cfg  = new App_Model_Three_MysqlCfgStorage($this->curr_sid);
        $tcRow         = $three_cfg->findShopCfg();
        if($tcRow['tc_apply_qrcode']){
            $apply_qrcode = $tcRow['tc_apply_qrcode'];
        }else{
            $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
            $str = '1';
            $apply_qrcode = $client_plugin->fetchWxappShareCode($str, $client_plugin::DISTRIB_BECOME_PARTNER_PATH, 210);
            if($apply_qrcode){
                $updata = array('tc_apply_qrcode'=>$apply_qrcode);
                $three_cfg->findShopCfg($updata);
            }
        }
        $this->output['apply_qrcode'] = $apply_qrcode;
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '分销中心', 'link' => '/wxapp/three/index'),
            array('title' => '分销商申请', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/branch/branch-list.tpl');
    }
    
    public function createQrcodeAction(){
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        $str = '1';
        $apply_qrcode = $client_plugin->fetchWxappShareCode($str, $client_plugin::DISTRIB_BECOME_PARTNER_PATH, 220);
        $three_cfg  = new App_Model_Three_MysqlCfgStorage($this->curr_sid);
        if($apply_qrcode){
            $updata = array('tc_apply_qrcode'=>$apply_qrcode);
            $three_cfg->findShopCfg($updata);
        }
        $res = array('ec'=> 200,'em'=> '创建成功！','url'=> $apply_qrcode);
        $this->displayJson($res);
    }
    
    public function downloadQrcodeAction(){
        $three_cfg  = new App_Model_Three_MysqlCfgStorage($this->curr_sid);
        $tcRow         = $three_cfg->findShopCfg();
        if($tcRow['tc_apply_qrcode']){
            $file       = PLUM_DIR_ROOT.$tcRow['tc_apply_qrcode'];
            $filesize   = filesize($file);
            $filename   = $this->curr_shop['s_name'].".jpg";

            plum_send_http_header("Content-type: application/octet-stream");
            plum_send_http_header("Accept-Ranges: bytes");
            plum_send_http_header("Accept-Length:".$filesize);
            plum_send_http_header("Content-Disposition: attachment; filename=".$filename);

            readfile($file);
        }
    }

    public function branchCfgAction(){
        $this->secondLink('branchCfg');
        $three_model = new App_Model_Three_MysqlCfgStorage($this->curr_sid);
        $row         = $three_model->getRowValue();
        $this->output['row'] = $row;
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '合伙人审核', 'link' => '/distrib/three/branch'),
            array('title' => '页面配置', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/branch/branch-cfg.tpl');
    }



    private function branch_list_data(){
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $where      = array();
        $where[]    = array('name' => 'sb_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]    = array('name' => 'sb_web_hide', 'oper' => '=', 'value' => 0);
        $where[]    = array('name' => 'sb_f_id', 'oper' => '=', 'value' => 0);
        $output['mobile'] = $this->request->getStrParam('mobile');
        if($output['mobile']){
            $where[]    = array('name' => 'sb_phone', 'oper' => 'like', 'value' => "%{$output['mobile']}%");
        }
        $output['realname'] = $this->request->getStrParam('realname');
        if($output['realname']){
            $where[]    = array('name' => 'sb_realname', 'oper' => 'like', 'value' => "%{$output['realname']}%");
        }

        $branch_model = new App_Model_Shop_MysqlShopBranchStorage($this->curr_sid);
        $total      = $branch_model->getCount($where);
        $page_lib   = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $list       = array();
        if($total > $index){
            $list   = $branch_model->getMemberList($where,$index,$this->count);
        }
        $output['paginator']  = $page_lib->render();
        $output['list']       = $list;
        $where_total = $where_pass = $where_audit = [];
        $where_total[] = $where_pass[] = $where_audit[] = ['name' => 'sb_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where_total[] = $where_pass[] = $where_audit[] = ['name' => 'sb_web_hide', 'oper' => '=', 'value' => 0];
        $where_total[] = $where_pass[] = $where_audit[] = ['name' => 'sb_f_id', 'oper' => '=', 'value' => 0];
        $where_pass[] = ['name' => 'sb_status', 'oper' => '=', 'value' => 1];
        $where_audit[] = ['name' => 'sb_status', 'oper' => '=', 'value' => 0];
        $totalCount = $branch_model->getCount($where_total);
        $passCount  = $branch_model->getCount($where_pass);
        $auditCount = $branch_model->getCount($where_audit);
        $refuseCount = intval($totalCount) - intval($passCount) - intval($auditCount);
        $statInfo = [
            'total' => intval($totalCount),
            'pass' => intval($passCount),
            'audit' => intval($auditCount),
            'refuse' => $refuseCount > 0 ? $refuseCount : 0
        ];
        $output['statInfo'] = $statInfo;
        $this->showOutput($output);
    }

    
    public function saveWithdrawCfgAction(){
        $result = array(
            'ec' => 400,
            'em' => '请求参数错误'
        );
        $data['wc_desc']       = $this->request->getStrParam('wc_desc');
        $data['wc_min']        = $this->request->getIntParam('wc_min');
        $data['wc_change_open']= $this->request->getIntParam('wc_wx_open');
        $data['wc_bank_open']  = $this->request->getIntParam('wc_bank_open');
        $data['wc_auto']  = $this->request->getIntParam('wc_auto');
        $data['wc_mobile_open']  = $this->request->getIntParam('wc_mobile_open');
        $data['wc_account_open']  = $this->request->getIntParam('wc_account_open');
        $data['wc_bank_mobile_open']  = $this->request->getIntParam('wc_bank_mobile_open');
        $data['wc_update_time']= time();
        $data['wc_rate']          = $this->request->getFloatParam('wc_rate');
        if($data['wc_min'] < 1){
            $result['em'] = '提现最低额度限制不得低于1元';
        }else{
            $cgf_model =  new App_Model_Shop_MysqlWithdrawCfgStorage();
            $row = $cgf_model->findCfgBySid($this->curr_sid);
            if($row && isset($row['wc_id']) && $row['wc_id']){
                $ret = $cgf_model->updateById($data,$row['wc_id']);
            }else{
                $data['wc_s_id'] = $this->curr_sid;
                $data['wc_createtime'] = time();
                $ret = $cgf_model->insertValue($data);
            }

            if($ret){
                $this->_save_applet_public_key();
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功'
                );
                App_Helper_OperateLog::saveOperateLog("提现配置保存成功");
            }else{
                $result['em'] = '保存失败';
            }
        }
        $this->displayJson($result);
    }
    
    private function _save_applet_public_key(){
        $pay_model      = new App_Model_Applet_MysqlAppletPayStorage($this->curr_sid);
        $payCfg = $pay_model->findRowPay();
        if($payCfg && $payCfg['ap_sslcert'] && $payCfg['ap_sslkey'] && !$payCfg['ap_pubpem']){
            $wxpay_plugin   = new App_Plugin_Weixin_NewPay($this->curr_sid);
            $retsult = $wxpay_plugin->appletPublicKey();
            if($retsult['code']==0){
                $updata = array(
                    'ap_pubpem' => $retsult['filename']
                );
                $pay_model->findRowPay($updata);
            }
        }
    }

    
    private function _applet_weixin_auto_deal(array $record, $pay_type = self::WEIXIN_PAT_REDPACK) {
        if (!in_array($record['wd_type'],array(self::WEIXIN_PAT_REDPACK,self::WEIXIN_PAY_BANK))) {
            return array('errno' => false, 'errmsg' => '非微信转账类型');
        }
        if ($record['wd_audit'] != 0) {
            return array('errno' => false, 'errmsg' => '非待审核状态');
        }
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->getRowById($record['wd_m_id']);
        $pay_storage    = new App_Model_Auth_MysqlPayTypeStorage($this->curr_sid);
        $payCfg = $pay_storage->findRowPay();
        if ($payCfg && $payCfg['pt_wxpay_applet']) {
            $wxpay_plugin   = new App_Plugin_Weixin_NewPay($this->curr_sid);
            $money          = $record['wd_money']-$record['wd_service_money'];
            if ($pay_type == self::WEIXIN_PAT_REDPACK) {
                $ret    = $wxpay_plugin->appletSendRedpack($member['m_openid'], $record['wd_real_money']);
            } else if($pay_type == self::WEIXIN_PAY_TRANSFER) {
                $ret    = $wxpay_plugin->appletPayTransfer($member['m_openid'], $record['wd_real_money'], $record['wd_realname']);
            } else if($pay_type == self::WEIXIN_PAY_BANK) {
                $ret    = $wxpay_plugin->appletPayBank($record['wd_account'], $record['wd_realname'], $record['wd_bank'],$record['wd_real_money']);
            }
            Libs_Log_Logger::outputLog($ret);
        }

        if (!$ret['code']) {
            return array('errno' => true, 'errmsg' => '微信转账成功');
        } else {
            return array('errno' => false, 'errmsg' => $ret['errmsg']);
        }
    }

    
    public function goodsRatioAction(){
        $this->secondLink('goods');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '分销中心', 'link' => '/wxapp/three/index'),
            array('title' => '单品分销', 'link' => '#'),
        ));
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        if($this->wxapp_cfg['ac_type'] == 12){
            $this->_get_course_list();
        }else{
            $this->get_goods_list();
        }

        $deduct_model = new App_Model_Goods_MysqlDeductStorage($this->curr_sid);
        $where[] = array('name' => 'gd_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $sort = array('gd_create_time' => 'desc');
        $total = $deduct_model->getCount($where);
        $pageCfg = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['paginator'] = $pageCfg->render();
        $list   = array();
        if($index <= $total) {
            if($this->wxapp_cfg['ac_type'] == 12){
                $list = $deduct_model->getCourseList($where, $index, $this->count, $sort);
            }else{
                $list = $deduct_model->getGoodsList($where, $index, $this->count, $sort);
            }

        }
        $this->output['list'] = $list;
        $this->output['threeSale']  = App_Helper_ShopWeixin::checkShopThreeLevel($this->curr_sid);

        if($this->wxapp_cfg['ac_type'] == 27){
            $goodsName = '课程';
        }else{
            $goodsName = '商品';
        }
        $this->output['goodsName'] = $goodsName;

        $this->displaySmarty('wxapp/three/addGoods.tpl');
    }

    private function get_goods_list(){
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $sort        = array('g_weight' => 'DESC','g_update_time'=>'DESC');
        $field       = array('g_id','g_name');
        $where[]     = array('name' => 'g_es_id', 'oper' => '=', 'value' => 0);
        $where[]     = array('name' => 'g_type','oper' => 'in','value' => array(1,2));
        $deduct_model = new App_Model_Goods_MysqlDeductStorage($this->curr_sid);
        $where_deduct[] = array('name' => 'gd_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        if($this->wxapp_cfg['ac_type'] == 12){
            $list = $deduct_model->getCourseList($where_deduct, 0, 0, []);
        }else{
            $list = $deduct_model->getGoodsList($where_deduct, 0, 0, []);
        }
        $discard_ids = [];
        foreach($list as $k => $v){
            $discard_ids[] = $v['g_id'];
        }
        if($discard_ids){
            $where[]     = array('name' => 'g_id', 'oper' => 'not in', 'value' => $discard_ids);
        }
        $goods       = $goods_model->fetchShopGoodsList($this->curr_sid,0,0,'',0,$sort,$field, 0, 0, 1, $where);
        $this->output['goodsList'] = $goods;
    }

    
    private function _get_course_list(){
        $course_model = new App_Model_Train_MysqlTrainCourseStorage($this->curr_sid);
        $sort = array('atc_create_time' => 'DESC');
        $field = array('atc_id','atc_title','atc_price');
        $where[] = array('name' => 'atc_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $course = $course_model->getList($where,0,0,$sort,$field);
        $goods = array();
        foreach ($course as $key => $val){
            if(is_numeric($val['atc_price'])){
                $goods[$key]['g_id'] = $val['atc_id'];
                $goods[$key]['g_name'] = $val['atc_title'];
            }
        }

        $this->output['goodsList'] = $goods;
    }

    
    public function openThreeDistribAction(){
        $status = $this->request->getIntParam('status');
        $three_cfg  = new App_Model_Three_MysqlCfgStorage($this->curr_sid);
        $tcRow         = $three_cfg->findShopCfg();
        if($tcRow){
            $set = array('tc_isopen'=>$status);
            $ret = $three_cfg->findShopCfg($set);
        }else{
            $updata = array(
                'tc_type'           => 1,
                'tc_open_time'      => $this->wxapp_cfg['ac_open_time'],
                'tc_expire_time'    => $this->wxapp_cfg['ac_expire_time'],
                'tc_update_time'    => time(),
                'tc_s_id'           => $this->curr_sid,
                'tc_is_branch'      => 0,
                'tc_level'          => 3,
                'tc_isopen'         => $status
            );
            $ret = $three_cfg->insertValue($updata);
        }

        if($ret){
            $str = $status > 0 ? '开启分销成功' : '关闭分销成功';
            App_Helper_OperateLog::saveOperateLog($str);
        }

        $this->showAjaxResult($ret);
    }

    
    public function changeRoundTypeAction(){
        $type = $this->request->getIntParam('type');
        $res = $this->_save_round_type($type);
        $this->showAjaxResult($res);
    }

    private function _save_round_type($type){
        $three_cfg  = new App_Model_Three_MysqlCfgStorage($this->curr_sid);
        $tcRow         = $three_cfg->findShopCfg();
        if($tcRow){
            $set = array('tc_round_type'=>$type,'tc_update_time'=>time());
            $ret = $three_cfg->findShopCfg($set);
        }else{
            $updata = array(
                'tc_type'           => 1,
                'tc_open_time'      => $this->wxapp_cfg['ac_open_time'],
                'tc_expire_time'    => $this->wxapp_cfg['ac_expire_time'],
                'tc_update_time'    => time(),
                'tc_s_id'           => $this->curr_sid,
                'tc_is_branch'      => 0,
                'tc_level'          => 3,
                'tc_round_type'     => $type
            );

            $ret = $three_cfg->insertValue($updata);

            if($ret){
                $str = '';
                if($type == 0){
                    $str = '不取整';
                }elseif ($type == 1){
                    $str = '向上取整';
                }elseif ($type == 2){
                    $str = '向下取整';
                }
                App_Helper_OperateLog::saveOperateLog("修改分销佣金取整类型为【{$str}】");
            }
        }
        return $ret;
    }

    
    public function setupLevelAction(){
        $this->showTypeByKey('yesNo');
        $this->secondLink('level');
        $level_model = new App_Model_Member_MysqlLevelStorage();
        $this->output['list'] = $level_model->getListBySid($this->curr_sid);
        $this->buildBreadcrumbs(array(
            array('title' => '分销设置', 'link' => '/wxapp/three/index'),
            array('title' => '会员等级', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/member/distrib-setup.tpl');
    }

    
    private function _show_order_stat($where,$today = true){
        if($today){
            $time = strtotime(date('Y-m-d',time()));
            $where[] = array('name'=>'t_create_time','oper'=>'>=','value'=>$time);
        }

        $where[] = array('name'=>'t_status','oper'=>'in','value'=>array(3,4,5,6));
        $where[] = array('name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid);
        $order_model = new App_Model_Shop_MysqlOrderDeductStorage($this->curr_sid);
        return $order_model->statOrderStatistic($where);
    }

    
    private function _show_card_order_stat($where,$today = true){
        if($today){
            $time = strtotime(date('Y-m-d',time()));
            $where[] = array('name'=>'oo_create_time','oper'=>'>=','value'=>$time);
        }
        $where[] = array('name'=>'oo_status','oper'=>'=','value'=>2);
        $where[] = array('name'=>'oo_s_id','oper'=>'=','value'=>$this->curr_sid);
        $order_model = new App_Model_Shop_MysqlOrderDeductStorage($this->curr_sid);
        return $order_model->statCardOrderStatistic($where);
    }

    

    public function LastMonthLevelAction($mid){
        $member_relation = new App_Model_Member_MysqlMemberRelationStorage();
        $where = array();
        $startTime = strtotime(date('Y',time()).'-'.(date('m',time())-1).'-01');
        $endTime = strtotime(date('Y-m',time()).'-01');
        $where[] = array('name'=>'mr_f_id','oper'=>'=','value'=>$mid);
        $where[] = array('name'=>'mr_create_time','oper'=>'>','value'=>$startTime);
        $where[] = array('name'=>'mr_create_time','oper'=>'<','value'=>$endTime);
        $oneCount = $member_relation->getCount($where);
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();

        $memberList = $member_storage->fetchFirstLevelList($mid,0,0);
    }

    

    public function emptyMemberShipAction(){
        $where = array();
        $where[] = array('name'=>'m_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'m_source','oper'=>'=','value'=>2);
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $list = $member_model->getList($where,0,0);
        if($this->curr_shop['s_empty_membership']){
            $this->displayJsonError('已经清空过一次，不能再操作了');
        }
        if($list){
            if(count($list)<50){
                $update = array(
                    'm_is_highest' => 0,
                    'm_1f_id'      => 0,
                    'm_2f_id'      => 0,
                    'm_3f_id'      => 0,
                    'm_1c_count'        => 0,
                    'm_2c_count'        => 0,
                    'm_3c_count'        => 0,
                    'm_deduct_amount'   => 0,
                    'm_deduct_ktx'      => 0,
                    'm_deduct_ytx'      => 0,
                    'm_deduct_dsh'      => 0,
                );
                $ret = $member_model->updateValue($update,$where);
                if($ret){
                    $mids = array();
                    foreach ($list as $value){
                        $mids[] = $value['m_id'];
                    }
                    if(!empty($mids)){
                        $member_relation = new App_Model_Member_MysqlMemberRelationStorage();
                        $where = array();
                        $where[] = array('name'=>'mr_f_id','oper'=>'in','value'=>$mids);
                        $where[] = array('name'=>'mr_s_id','oper'=>'in','value'=>$mids);
                        $member_relation->deletedMemberRelation($where);
                    }
                    $updateShop = array('s_empty_membership'=>1);
                    $shop_storage = new App_Model_Shop_MysqlShopCoreStorage();
                    $shop_storage->updateById($updateShop,$this->curr_shop['s_id']);
                }

                if($ret){
                    App_Helper_OperateLog::saveOperateLog("分销会员关系清除成功");
                }

                $this->showAjaxResult($ret,'清空信息');
            }else{
                $this->displayJsonError('会员人数超过限制不能清空会员');
            }
        }else{
            $this->displayJsonError('暂无会员信息');
        }
    }

    
    public function relationAction(){
        $mid = $this->request->getIntParam('mid');
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_model->getRowById($mid);
        $data = array();
        if($member['m_is_highest']){
            $data = $this->_get_relation($mid, $mid, array());
        }elseif($member['m_1f_id']){
            $data = $this->_get_relation($member['m_1f_id'], $mid, array());
        }elseif($member['m_2f_id']){
            $data = $this->_get_relation($member['m_2f_id'], $mid, array());
        }elseif($member['m_3f_id']){
            $data = $this->_get_relation($member['m_3f_id'], $mid, array());
        }

        $this->output['mid'] = $mid;
        $this->output['data'] = json_encode($data);
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '分销中心', 'link' => '/wxapp/three/index'),
            array('title' => '会员关系', 'link' => '/wxapp/three/member'),
            array('title' => '查看会员关系', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/three/relation.tpl');
    }

    private function _get_relation($mid, $rmid, $had = array()){
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_model->getRowById($mid);
        $where = array();
        $where[] = array('name' => 'm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'm_1f_id', 'oper' => '=', 'value' => $mid);
        $children = $member_model->getList($where, 0, 0);
        $data = array(
            'id'         => $mid,
            'symbolSize' => $mid == $rmid?[20, 20]:[10, 10],
            'name'       => $member['m_nickname'],
            'itemStyle'  => array(
                'normal' => array(
                    'color' => $mid == $rmid?'#f00':'#44b549'
                )
            ),
            'children'  => [],
        );
        $had[] = $mid;
        if($children){
            foreach ($children as $val){
                if(!in_array($val['m_id'], $had)){
                    $data['children'][] = $this->_get_relation($val['m_id'], $rmid, $had);
                }
            }
            return $data;
        }else{
            return $data;
        }
    }

    
    public function setHighestAction(){
        $mid = $this->request->getIntParam('mid');
        if($mid){
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $member = $member_model->getRowById($mid);
            $set = array('m_1f_id' => 0, 'm_2f_id' => 0, 'm_3f_id' => 0, 'm_is_highest' => 1);
            $ret = $member_model->updateById($set, $mid);
            if($member['m_1f_id']){
                $member_relation = new App_Model_Member_MysqlMemberRelationStorage();
                $where = array();
                $where[] = array('name'=>'mr_f_id','oper'=>'=','value'=>$member['m_1f_id']);
                $where[] = array('name'=>'mr_s_id','oper'=>'=','value'=>$mid);
                $member_relation->deletedMemberRelation($where,true);
            }
            for($i = 1; $i<=3; $i++){
                if($member['m_'.$i.'f_id']){//减少上级的下级数量
                    $fmember = $member_model->getRowById($member['m_'.$i.'f_id']);
                    if($i == 1){
                        $set = array('m_1c_count' => $fmember['m_1c_count']-1, 'm_2c_count' => $fmember['m_2c_count']-$member['m_1c_count'], 'm_3c_count' => $fmember['m_3c_count']-$member['m_2c_count']);
                    }
                    if($i == 2){
                        $set = array('m_2c_count' => $fmember['m_2c_count']-1, 'm_3c_count' => $fmember['m_3c_count']-$member['m_1c_count']);
                    }
                    if($i == 3){
                        $set = array('m_3c_count' => $fmember['m_3c_count']-1);
                    }
                    $member_model->updateById($set, $member['m_'.$i.'f_id']);
                }
                if($i!=3){
                    $where = array();
                    $where[] = array('name' => 'm_'.$i.'f_id', 'oper' => '=', 'value' => $mid);
                    $set = array('m_'.($i+1).'f_id' => 0);
                    $member_model->updateValue($set, $where);
                }
            }

            if($ret){
                App_Helper_OperateLog::saveOperateLog("设置用户【{$member['m_nickname']}】为最高级");
            }

            $this->showAjaxResult($ret, '设置');
        }
    }

    
    public function emptyChildrenAction(){
        $mid = $this->request->getIntParam('mid');
        if($this->curr_sid==11068){
            $this->displayJsonError('为保证数据的准确性，该功能已被暂停使用');
        }
        if($mid){
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $member = $member_model->getRowById($mid);
            $set = array(
                'm_1f_id'    => 0,
                'm_1c_count' => 0,
                'm_2c_count' => 0,
                'm_3c_count' => 0,
                'm_is_highest'     => 0,
                'm_deduct_amount'  => 0
            );
            $member_model->updateById($set, $mid);
            for($i = 1; $i<=3; $i++){//修改其上三级的下级数量
                $fmember = $member_model->getRowById($member['m_'.$i.'f_id']);
                if($i == 1){
                    $set = array('m_1c_count' => $fmember['m_1c_count']-1, 'm_2c_count' => $fmember['m_2c_count']-$member['m_1c_count'], 'm_3c_count' => $fmember['m_3c_count']-$member['m_2c_count']);
                }
                if($i == 2){
                    $set = array('m_2c_count' => $fmember['m_2c_count']-1, 'm_3c_count' => $fmember['m_3c_count']-$member['m_1c_count']);
                }
                if($i == 3){
                    $set = array('m_3c_count' => $fmember['m_3c_count']-1);
                }
                $member_model->updateById($set, $member['m_'.$i.'f_id']);
            }
            $member_relation = new App_Model_Member_MysqlMemberRelationStorage();
            $where = array();
            $where[] = array('name'=>'mr_f_id','oper'=>'=','value'=>$member['m_1f_id']);
            $where[] = array('name'=>'mr_s_id','oper'=>'=','value'=>$member['m_id']);
            $member_relation->deletedMemberRelation($where, true);
            $this->_empty_children($mid);

            App_Helper_OperateLog::saveOperateLog("清空用户【{$member['m_nickname']}】下级分销关系");
        }
        $this->showAjaxResult(1, '清空');
    }

    private function _empty_children($mid){
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $member_relation = new App_Model_Member_MysqlMemberRelationStorage();
        $where = array();
        $where[] = array('name' => 'm_1f_id', 'oper' => '=', 'value' => $mid);
        $children = $member_model->getList($where, 0, 0, array());
        if($children){
            foreach ($children as $val){
                $where = array();
                $where[] = array('name'=>'mr_f_id','oper'=>'=','value'=>$val['m_1f_id']);
                $where[] = array('name'=>'mr_s_id','oper'=>'=','value'=>$val['m_id']);
                $member_relation->deletedMemberRelation($where, true);
                $set = array(
                    'm_1f_id'    => 0,
                    'm_1c_count' => 0,
                    'm_2c_count' => 0,
                    'm_3c_count' => 0,
                    'm_deduct_amount'  => 0
                );
                $member_model->updateById($set, $val['m_id']);
                $this->_empty_children($val['m_id']);
            }
            return true;
        }else{
            return true;
        }
    }

    
    public function excelOrderAction(){
        $startDate  = $this->request->getStrParam('startDate');
        $startTime  = $this->request->getStrParam('startTime');
        $endDate    = $this->request->getStrParam('endDate');
        $endTime    = $this->request->getStrParam('endTime');
        $dfid        = $this->request->getIntParam('fid');
        $orderStatus = $this->request->getStrParam('orderStatus','all');

        if($startDate && $startTime && $endDate && $endTime){
            $start = $startDate.' '.$startTime;
            $end   = $endDate.' '.$endTime;
            $startTime  = strtotime($start);
            $endTime    = strtotime($end);

            $where = array();
            $where[] = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[] = array('name'=>'t_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET );
            $where[] = array('name'=>'od_share_goods','oper'=>'=','value'=>0 );
            $link = App_Helper_Trade::$trade_link_status;
            if($orderStatus && isset($link[$orderStatus]) && $link[$orderStatus]['id'] > 0){
                $where[]= array('name'=>'t_status','oper'=>'=','value'=>$link[$orderStatus]['id']);
            }
            for($i=1;$i<=3;$i++){
                $fid = $this->request->getIntParam($i.'f_id');
                if($fid){
                    $where[] = array('name' => 'od_'.$i.'f_id', 'oper' => '=', 'value' => $fid);
                }
            }

            $where[]    = array('name' => 't_create_time', 'oper' => '>=', 'value' => $startTime);
            $where[]    = array('name' => 't_create_time', 'oper' => '<=', 'value' => $endTime);

            if($dfid){
                $where[] = " (od_1f_id=".$dfid." or od_2f_id=".$dfid." or od_3f_id=".$dfid.")";
            }

            $deduct_storage  = new App_Model_Shop_MysqlOrderDeductStorage($this->curr_sid);
            $sort   = array('od_create_time' => 'DESC');//订单生成时间倒序排列
            $list = $deduct_storage->getDeductByMidSid($where,0,0,$sort);
            $level = $this->show_member_level_info($list,'od_');

            $trade_status = plum_parse_config('trade_status','app');

            if(!empty($list)){
                $date       = date('Ymd',$_SERVER['REQUEST_TIME']);
                $rows  = array();
                $rows[]  = array('订单编号','商品名称','商品数量','订单金额','购买人','购买人返现', '上级', '上级佣金', '上二级', '上二级佣金', '上三级', '上三级佣金', '订单状态', '购买时间');
                $width   = array(
                    'A' => 20,
                    'B' => 20,
                    'C' => 20,
                    'D' => 20,
                    'E' => 20,
                    'F' => 20,
                    'G' => 20,
                    'H' => 20,
                    'I' => 20,
                    'J' => 20,
                    'K' => 20,
                    'L' => 20,
                    'M' => 20,
                    'N' => 20,
                );

                foreach($list as $key => $val){
                    $rows[] = array(
                        $val['t_tid'].' ',
                        $val['g_name']?$this->utf8_str_to_unicode($val['g_name']):$this->utf8_str_to_unicode($val['t_title']),
                        $val['to_num']?$val['to_num']:$val['t_num'],
                        $val['t_total_fee'],
                        $this->utf8_str_to_unicode($val['t_buyer_nick']),
                        $val['od_0f_deduct'],
                        $this->utf8_str_to_unicode($level[$val['od_1f_id']]),
                        $val['od_1f_deduct'],
                        $this->utf8_str_to_unicode($level[$val['od_2f_id']]),
                        $val['od_2f_deduct'],
                        $this->utf8_str_to_unicode($level[$val['od_3f_id']]),
                        $val['od_3f_deduct'],
                        $trade_status[$val['t_status']],
                        date("Y-m-d H:i:s",$val['od_create_time'])
                    );
                }
                $excel = new App_Plugin_PHPExcel_PHPExcelPlugin();
                $excel->down_common_excel($rows,$date.'分销订单导出.xls',$width);
            }else{
                plum_url_location('当前时间段内没有订单记录!');
            }
        }else{
            plum_url_location('日期请填写完整!');
        }
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
        return $unicode_str;
    }

    
    public function threePostCreateAction(){
        $mid = $this->request->getIntParam('mid');

        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_storage->getRowById($mid);
        $copartner_cfg  = new App_Model_Three_MysqlCfgStorage($this->curr_sid);
        $tcRow         = $copartner_cfg->findShopCfg();
        if($tcRow['tc_copartner_isopen'] == 1){
            $extra_model = new App_Model_Member_MysqlMemberExtraStorage($this->curr_sid);
            $extra = $extra_model->findUpdateExtraByMid($mid);
            if(!$extra || $extra['ame_copartner'] == 0){
                $this->displayJsonError('请先购买合伙人');
            }
        }
        $is_real_member = App_Helper_MemberLevel::isRealMember($this->curr_sid, $mid);
        if (!$is_real_member) {
            $center_model   = new App_Model_Member_MysqlMemberCenterStorage();
            $center_cfg     = $center_model->findUpdateBySid($this->curr_sid);
            $default_cfg    = plum_parse_config('center_cfg');
            if ($center_cfg && $center_cfg['cc_noqr_tip']) {
                $tip    = $center_cfg['cc_noqr_tip'];
            } else {
                $tip    = $default_cfg['cc_noqr_tip'];
            }

            $this->displayJsonError($tip);
        }
        $level      = App_Helper_MemberLevel::fetchMemberLevel($this->curr_sid, $member['m_id']);
        $qrcodeVerify = getimagesize(PLUM_DIR_ROOT.$member['m_spread_qrcode']);
        if (!$member['m_spread_qrcode'] || !$member['m_spread_image'] || !$qrcodeVerify) {
            $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
            $str = "mid=".$member['m_id'].'&join_type=1';
            if($this->wxapp_cfg['ac_type'] == 6 || $this->wxapp_cfg['ac_type'] == 8){
                $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::APPLET_ENTER_CODE_PATH, 210);
            }else{
                $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::APPLET_ENTER_CODE_PATH, 210);
            }
            $member['m_spread_qrcode'] = $url;

            $updata = array(
                'm_spread_qrcode'   => $member['m_spread_qrcode'],
                'm_ticket_qrcode_url' => $url,
                'm_spread_image'    => '',//二维码推广图片清空，便于重新生成
            );
            $member_storage->updateById($updata, $member['m_id']);
            if($this->curr_sid==7163 || $this->curr_sid==7224){
                $this->_create_spread_image_new($member);
            }else{
                $this->_create_spread_image($member);
            }
        }

        $this->showAjaxResult(1, '创建');
    }

    private function _create_spread_image($member){
        $qrcode     = $member['m_spread_qrcode'];//推广二维码
        $qrcodeVerify = getimagesize(PLUM_DIR_ROOT.$qrcode);
        if(!$qrcodeVerify){
            $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
            $str = "mid=".$member['m_id'];
            $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::APPLET_ENTER_CODE_PATH, 210);
            $qrcode = $url;
        }
        $center_storage = new App_Model_Member_MysqlMemberCenterStorage();
        $center_cfg     = $center_storage->findUpdateBySid($this->curr_sid);
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

            $qr_img     = imagecreatefromjpeg(PLUM_DIR_ROOT.$qrcode);//210*210

            $q_w        = imagesx($qr_img);
            $q_h        = imagesy($qr_img);
            $dst_x      = intval($qrcode_loc[0]);
            $dst_y      = intval($qrcode_loc[1]);

            imagecopyresampled($bs_img, $qr_img, $dst_x, $dst_y, 0, 0, $center_cfg['cc_qrcode_size']*2, $center_cfg['cc_qrcode_size']*2,$q_w, $q_h);
            if ($member['m_avatar']) {
                $tx_c   = imagecolorallocate($bs_img, 0, 0, 0);
                $fontface   = PLUM_DIR_LIB . "/captcha/font/wrvistafs.ttf";

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
                if ($member['m_nickname']) {
                    $nick   = $member['m_nickname'];

                    $nt_x   = $a_x+100+10;//留出图片空间
                    $nt_y   = $a_y+55;//留出图片高度
                    if($this->curr_sid == 5655){
                        Libs_Log_Logger::outputLog('text-color'.$tx_c,'test.log');
                    }

                    imagettftext($bs_img, 24, 0, $nt_x, $nt_y, $tx_c, $fontface, $nick);
                    imagettftext($bs_img, 24, 0, $nt_x+1, $nt_y, $tx_c, $fontface, $nick);
                }
            }

            $filename   = plum_random_code(8, false) . '-' . plum_random_code(6, false) . $imageext;
            $imageoutput($bs_img, $this->hold_dir . $filename);

            imagedestroy($bs_img);
            imagedestroy($qr_img);
            $spread   = $this->access_path . $filename;
            $updata     = array(
                'm_spread_image' => $spread,
            );
            if(!$qrcodeVerify){
                $updata['m_spread_qrcode'] = $qrcode;

            }

            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
            $member_storage->updateById($updata, $member['m_id']);
        }
        return $spread;
    }

    private function _create_spread_image_new($member) {
        $center_storage = new App_Model_Member_MysqlMemberCenterStorage();
        $center_cfg     = $center_storage->findUpdateBySid($this->curr_sid);

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
            $dst_x = ceil(($b_w - $q_w) / 2);
            $dst_y = ceil(($b_h - $q_h) / 2);

            imagecopy($bs_img, $thumb, 477, 20, 0, 0, 140, 140);
            imagedestroy($thumb);
            $tx_c = imagecolorallocate($bs_img, 0, 0, 0);
            $fontface = PLUM_DIR_LIB . "/captcha/font/wrvistafs.ttf";
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
            if ($member['m_nickname']) {
                $nick = $member['m_nickname'];

                $nt_x = 25 + 100 + 15;//留出图片空间
                $nt_y = 55 + 45;//留出图片高度

                imagettftext($bs_img, 18, 0, $nt_x, $nt_y, $tx_c, $fontface, $nick);
            }
            $background = imagecreatetruecolor(640, 928);
            $color = imagecolorallocate($background, 202, 201, 201);
            imagefill($background, 0, 0, $color);
            imageColorTransparent($background, $color);
            imagecopy($background, $new_bg, 0, 0, 0, 0, 640, 758);
            imagecopy($background, $bs_img, 0, 758, 0, 0, 640, 170);

            $filename = plum_random_code(8, false) . '-' . plum_random_code(6, false) . $imageext;
            $imageoutput($background, $this->hold_dir . $filename);

            imagedestroy($new_bg);
            imagedestroy($bs_img);
            imagedestroy($qr_img);
            $spread_image = $this->access_path . $filename;
            $updata     = array(
                'm_spread_image' => $spread_image
            );
            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
            $member_storage->updateById($updata, $member['m_id']);
        }
        return $spread_image;
    }


}