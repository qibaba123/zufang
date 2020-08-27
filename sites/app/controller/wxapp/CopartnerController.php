<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/9/2
 * Time: 下午3:20
 *
 */
class App_Controller_Wxapp_CopartnerController extends App_Controller_Wxapp_InitController {

    const PROMOTION_TOOL_KEY    = 'hhr';
    const WEIXIN_PAT_REDPACK    = 1;//微信红包形式
    const WEIXIN_PAY_TRANSFER   = 2;//微信企业转账到零钱
    const WEIXIN_PAY_BANK       = 3;//微信企业转账到银行卡

    private $application_status = null;
    //生成图片存储实际路径
    private $hold_dir;
    //生成图片访问路径
    private $access_path;

    public function __construct() {
        parent::__construct();
        $expire = "  应用已开通, 到期时间: ".date('Y-m-d H:i:s', $this->wxapp_cfg['ac_expire_time']);
        $this->application_status   = array('code'=>0,'expire'=>$this->wxapp_cfg['ac_expire_time'],'msg' => trim($expire),'level'=>3);
        $this->checkToolUsable(self::PROMOTION_TOOL_KEY);
        $this->hold_dir     = PLUM_APP_BUILD.'/spread/';
        $this->access_path  = PLUM_PATH_PUBLIC.'/build/spread/';
    }
    /**
     * @param string $type
     * 自定义二级链接，根据类型，确定默认选中
     */
    public function secondLink($type='index'){

        $link = array(
            array(
                'label' => '分销配置',
                'link'  => '/wxapp/copartner/index',
                'active'=> 'index'
            ),
            array(
                'label' => '分销中心',
                'link'  => '/wxapp/copartner/center',
                'active'=> 'center'
            ),
            array(
                'label' => '分销等级',
                'link'  => '/wxapp/copartner/setCopartnerLevel',
                'active'=> 'deduct'
            ),
            /*array(
                'label' => '单品分销',
                'link'  => '/wxapp/copartner/goodsRatio',
                'active'=> 'goods'
            ),*/
            array(
                'label' => '会员关系',
                'link'  => '/wxapp/copartner/member',
                'active'=> 'member'
            ),
            array(
                'label' => '分销订单',
                'link'  => '/wxapp/copartner/order',
                'active'=> 'order'
            ),
            array(
                'label' => '会员卡订单',
                'link'  => '/wxapp/copartner/cardorder',
                'active'=> 'cardorder'
            ),
            array(
                'label' => '会员提现',
                'link'  => '/wxapp/copartner/withdraw',
                'active'=> 'withdraw'
            ),
            array(
                'label' => '购买记录',
                'link'  => '/wxapp/copartner/branch',
                'active'=> 'branch'
            ),
        );
        $this->output['link']       = $link;
        $this->output['linkType']   = $type;
        $this->output['snTitle']    = '合伙人分销';
    }
    /**
     * 开启微分销
     */
    public function indexAction(){
        $this->secondLink('index');
        $center_model   = new App_Model_Member_MysqlMemberCenterStorage();
        $row            = $center_model->findUpdateBySid($this->curr_sid);
        //@todo 查询分销配置
        $copartner_cfg  = new App_Model_Three_MysqlCfgStorage($this->curr_sid);
        $tcRow         = $copartner_cfg->findShopCfg();
        if(!$tcRow){
            $updata = array(
                'tc_type'           => 1,
                'tc_open_time'      => $this->wxapp_cfg['ac_open_time'],
                'tc_expire_time'    => $this->wxapp_cfg['ac_expire_time'],
                'tc_update_time'    => time(),
                'tc_s_id'           => $this->curr_sid,
                'tc_is_branch'      => 0,
                'tc_level'          => 3,
                'tc_domain'         => $this->_get_domain()
            );
            $copartner_cfg->insertValue($updata);
        }
        $row['tc_level']     = $tcRow['tc_level'];
        $row['tc_istip']     = $tcRow['tc_istip'];
        $row['tc_shop_join'] = $tcRow['tc_shop_join'];
        $this->output['row'] = $row;
        $this->output['tcRow'] = $tcRow;
        $this->output['appletCfg'] = $this->wxapp_cfg;
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '分销中心', 'link' => '/wxapp/copartner/index'),
            array('title' => '分销配置', 'link' => '#'),
        ));
        $this->output['app_status'] = $this->application_status;
        $this->displaySmarty('wxapp/copartner/copartner-cfg.tpl');
    }

    /*
     * 获取可用域名
     *
     */
    private function _get_domain(){
        // 获取可用域名
        $domain_storage   = new App_Model_Applet_MysqlAppletDomainStorage();
        $domain = $domain_storage->getListFirst();
        return $domain['asd_domain'];
    }

    /*private function _check_copartner_level(){
        $copartnerSale  = App_Helper_ShopWeixin::checkShopThreeLevel($this->curr_sid, ); //分销等级
        if($copartnerSale == 0){
            plum_url_location('','/wxapp/copartner/index');
        }
    }*/

    /*二维码页面配置*/
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

        //@todo 查询分销配置
        $copartner_cfg  = new App_Model_Three_MysqlCfgStorage($this->curr_sid);
        $tcRow         = $copartner_cfg->findShopCfg();
        if(!$tcRow){
            $updata = array(
                'tc_type'           => 1,
                'tc_open_time'      => $this->wxapp_cfg['ac_open_time'],
                'tc_expire_time'    => $this->wxapp_cfg['ac_expire_time'],
                'tc_update_time'    => time(),
                'tc_s_id'           => $this->curr_sid,
                'tc_is_branch'      => 0,
                'tc_level'          => 3,
                'tc_domain'         => $this->_get_domain()
            );
            $copartner_cfg->insertValue($updata);
        }
        $row['tc_level']     = $tcRow['tc_level'];
        $row['tc_istip']     = $tcRow['tc_istip'];
        $this->output['tcRow'] = $tcRow;

        if($this->request->getIntParam('test')==1){
            plum_msg_dump($row);
        }

        //图片上传
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '分销中心', 'link' => '/wxapp/copartner/index'),
            array('title' => '微海报设置', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/copartner/code.tpl');
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
        $data['cc_avatar_loc']   = $this->request->getStrParam('userInfoPos'); //文字颜色
        $data['cc_qrcode_loc']   = $this->request->getStrParam('codePos'); //文字颜色
        $data['cc_qrcode_bg']    = $this->request->getStrParam('codeBg'); //二维码背景图
        $data['cc_qrcode_size']  = $this->request->getIntParam('codeSize'); //二维码背景图
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
            App_Helper_OperateLog::saveOperateLog("分销海报保存成功");
        }

        $this->showAjaxResult($ret,'保存');
    }

    /**
     * 设置合伙人等级
     */
    public function setCopartnerLevelAction(){
        $this->secondLink('deduct');
        $threeSale  = App_Helper_ShopWeixin::checkShopThreeLevel($this->curr_sid); //分销等级
        $this->output['level'] = $threeSale;
        $level_model = new App_Model_Copartner_MysqlCopartnerLevelStorage($this->curr_sid);
        $list = $level_model->getListBySid($this->curr_sid, 0, 0);
        $deduct_model = new App_Model_Copartner_MysqlCopartnerDeductCfgStorage();
        foreach ($list as $key => $value){
            $list[$key]['deductList'] =  $deduct_model->getListByShopId($this->curr_sid, $value['cl_id']);
        }
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '分销中心', 'link' => '/wxapp/copartner/index'),
            array('title' => '佣金配置', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/copartner/level.tpl');
    }

    /**
     * 保存合伙人等级
     */
    public function saveLevelAction(){
        $id     = $this->request->getIntParam('id');
        $name   = $this->request->getStrParam('name');
        $price  = $this->request->getFloatParam('money');
        $desc   = $this->request->getStrParam('desc');
        $weight = $this->request->getIntParam('weight');

        $data['cl_s_id']   = $this->curr_sid;
        $data['cl_name']   = $name;
        $data['cl_money']  = $price;
        $data['cl_desc']   = $desc;
        $data['cl_weight'] = $weight;
        $data['cl_update_time'] = time();

        $level_model = new App_Model_Copartner_MysqlCopartnerLevelStorage($this->curr_sid);
        if($id){
            $ret = $level_model->updateById($data, $id);
        }else{
            $data['cl_create_time'] = time();
            $ret = $level_model->insertValue($data);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("保存分销等级【{$name}】成功");
        }

        $this->showAjaxResult($ret);
    }

    /**
     * 删除合伙人等级
     */
    public function delLevelAction(){
        $id        = $this->request->getIntParam('id');
        $level_model = new App_Model_Copartner_MysqlCopartnerLevelStorage($this->curr_sid);
        $level = $level_model->getRowById($id);
        $ret = $level_model->deleteBySidId($id,$this->curr_sid);
        if($ret){
            //删除等级下对应的佣金
            $deduct_model = new App_Model_Copartner_MysqlCopartnerDeductCfgStorage();
            $deduct_model->deleteByLid($id, $this->curr_sid);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("删除合伙人等级【{$level['cl_name']}】成功");
        }

        $this->showAjaxResult($ret);
    }

    /******************佣金设置开始**********************/
    /**
     * 保存比例设置
     */
    public function saveDeductAction(){
        $id        = $this->request->getIntParam('id'); //编辑ID
        $lid       = $this->request->getIntParam('lid'); //合伙人等级id
        $buy_num   = $this->request->getIntParam('buy_num');//购买次数
        if($buy_num < 1){
            $this->displayJsonError('购买次数不得小于1次');
        }

        $data      = array();
        $data['cdc_buy_num']  = $buy_num;
        $data['cdc_l_id']  = $lid;
        $data['cdc_back_num'] = 0;
        for($i=0;$i<=3;$i++){
            $data['cdc_'.$i.'f_ratio']= $this->request->getFloatParam('ratio'.$i);
        }
        $data['cdc_update_time'] = time();

        $deduct_model = new App_Model_Copartner_MysqlCopartnerDeductCfgStorage();
        //@todo 校验：购买次数唯一
        $deduct       = $deduct_model->checkBuyNum($data['cdc_buy_num'],$this->curr_sid,$id, $lid);

        if($deduct == 0){
            if($id){
                $ret = $deduct_model->updateById($data,$id);
            }else{
                $data['cdc_create_time'] = time();
                $data['cdc_s_id']        = $this->curr_sid;
                $ret = $deduct_model->insertValue($data);
            }

            if($ret){
                App_Helper_OperateLog::saveOperateLog("保存分佣比例成功");
            }

            $this->showAjaxResult($ret,'保存');
        }else{
            $this->displayJsonError('购买次数已经存在');
        }
    }

    /**
     * 删除佣金比例设置
     */
    public function delDeductAction(){
        $id = $this->request->getIntParam('id');
        $deduct_model = new App_Model_Copartner_MysqlCopartnerDeductCfgStorage();
        $ret = $deduct_model->deleteBySidId($id,$this->curr_sid);
        $this->showAjaxResult($ret,'删除');
    }

    /**
     * 佣金比例设置
     */
    public function vipDeductAction(){
        //$this->_check_copartner_level();
        $deduct_model = new App_Model_Shop_MysqlDeductStorage();
        $list = $deduct_model->getListByShopId($this->curr_sid, 2);
        $copartnerSale  = App_Helper_ShopWeixin::checkShopThreeLevel($this->curr_sid); //分销等级
        $this->output['level'] = $copartnerSale;
        $this->output['list']  = $list;
        $this->output['type']  = 2;
        $this->buildBreadcrumbs(array(
            array('title' => '会员营销', 'link' => '#'),
            array('title' => '佣金配置', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/copartner/vip-deduct-list.tpl');
    }

    /******************佣金设置结束**********************/

    /******************分销中心**********************/
    public function centerAction(){
        $this->secondLink('center');
        $center_model   = new App_Model_Member_MysqlMemberCenterStorage();
        $row            = $center_model->findUpdateBySid($this->curr_sid);
        //@todo 查询分销配置
        $row['tc_level']     =  App_Helper_ShopWeixin::checkShopThreeLevel($this->curr_sid);
        $this->output['row'] = $row;
        $this->_show_tpl_notice();
        $this->_show_shop_article();
        $this->_shop_information();
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '分销中心', 'link' => '/wxapp/copartner/index'),
            array('title' => '分销中心', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/copartner/sale-center.tpl');
    }


    /**
     * 获取滚动的通知公告
     */
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

    /**
     * 保存会员主页设置
     */
    public function saveCenterCfgAction(){
        $data  = array();
        $data['cc_center_title'] = $this->request->getStrParam('title');//主页标题
        $data['cc_center_color'] = $this->request->getStrParam('color'); //文字颜色
        $data['cc_min_num']      = $this->request->getIntParam('number'); //最低消费数量
        $data['cc_min_amount']   = $this->request->getFloatParam('money'); //最低消费额度
        $data['cc_show_refer']   = $this->request->getIntParam('refer'); //是否先是最高级
        $data['cc_must_set']     = $this->request->getIntParam('must'); //设置官方推荐人
        $data['cc_recharge_amount'] = $this->request->getIntParam('recharge'); //是否将充值金额计算到消费金额
        $qrcode   = $this->request->getStrParam('qrcode_bg');//二维码图片
        if($qrcode){
            $data['cc_qrcode_bg']  = $qrcode;
        }
        $bground    = $this->request->getStrParam('center_bg');//主页标题
        if($bground){
            $data['cc_center_bg'] = $bground;
        }

        //主页底部四个导航
        for($i=1;$i<=4;$i++){
            $temp = $this->request->getStrParam('tab'.$i);
            if($temp){
                $data['cc_tab'.$i] = $temp;
            }
        }
        $data['cc_update_time'] = time();
        //保存整理的数据
        $center_model = new App_Model_Member_MysqlMemberCenterStorage();
        $centerRow    = $center_model->isExistBySid($this->curr_sid);
        if(!empty($centerRow)){
            $this->_check_qrcode_change($centerRow['cc_qrcode_bg'],$data['cc_qrcode_bg']);
            $ret = $center_model->findUpdateBySid($this->curr_sid,$data);
        }else{
            $data['cc_s_id'] = $this->curr_sid;
            $data['cc_create_time'] = time();
            $ret = $center_model->insertValue($data);
        }
        //$this->_save_copartner_cfg();

        if($ret){
            App_Helper_OperateLog::saveOperateLog("保存分销配置成功");
        }

        $this->showAjaxResult($ret,'保存');
    }

    public function saveCenterAction(){
        $data  = array();
        $pageType = $this->request->getStrParam('pageType');//页面来源
        if($pageType == 'cfg'){ //配置信息
            $data['cc_min_num']      = $this->request->getIntParam('number'); //最低消费数量
            $data['cc_min_amount']   = $this->request->getFloatParam('money'); //最低消费额度
            $data['cc_show_refer']   = $this->request->getIntParam('refer'); //是否先是最高级
            $data['cc_must_set']     = $this->request->getIntParam('must'); //设置官方推荐人
            $data['cc_noqr_tip']     = $this->request->getStrParam('noqrTip'); //未获取到微海报时提醒
            $data['cc_recharge_amount'] = $this->request->getIntParam('recharge'); //是否将充值金额计算到消费金额
            //$data['']

            $qrcode   = $this->request->getStrParam('qrcode_bg');//二维码图片
            if($qrcode){
                $data['cc_qrcode_bg']  = $qrcode;
            }
            //@todo 保存分销等级
            $this->_save_copartner_cfg();
        }else{
            $data['cc_center_title'] = $this->request->getStrParam('title');//主页标题
            $data['cc_center_color'] = $this->request->getStrParam('color'); //文字颜色
            $bground    = $this->request->getStrParam('center_bg');//主页标题
            if($bground){
                $data['cc_center_bg'] = $bground;
            }

            $show = array('myuser','myshare','mycash','myorder','myrefer','myinfo','mywith','mycode','myrank','mynotice','myupgrade');
            //控制显示与不显示
            foreach($show as $val){
                //显示
                $temp = $this->request->getIntParam($val);
                if(in_array($temp,array(0,1))){
                    $data['cc_'.$val.'_show'] = $temp;
                }

                //名称
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


            //保存通知公告信息
            $this->_save_train_notice();


        }

        $data['cc_update_time'] = time();
        //保存整理的数据
        $center_model = new App_Model_Member_MysqlMemberCenterStorage();
        $centerRow    = $center_model->isExistBySid($this->curr_sid);
        if(!empty($centerRow)){
            $ret = $center_model->findUpdateBySid($this->curr_sid,$data);
            //二维码背景图更新的话，清空会员我的二维码
            if(isset($data['cc_qrcode_bg']) && $data['cc_qrcode_bg'] && $centerRow['cc_qrcode_bg'] != $data['cc_qrcode_bg']){
                $this->_check_qrcode_change($centerRow['cc_qrcode_bg'],$data['cc_qrcode_bg']);
            }
        }else{
            $data['cc_s_id'] = $this->curr_sid;
            $data['cc_create_time'] = time();
            $ret = $center_model->insertValue($data);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("保存分销配置成功");
        }

        $this->showAjaxResult($ret,'保存');
    }

    /**
     *保存首页通知公告
     */
    private function _save_train_notice(){
        $noticeInfo = $this->request->getArrParam('notice');
        $notice_storage = new App_Model_Train_MysqlTrainNoticeStorage($this->curr_sid);
        if(!empty($noticeInfo)){
            $notice_list = $notice_storage->fetchNoticeShowList();
            if(!empty($notice_list)){
                $del_id = array();
                foreach($notice_list as $val){
                    if(isset($noticeInfo[$val['atn_weight']])){  //存在这个位置的活动，更新
                        $set = array(
                            'atn_weight'            => $noticeInfo[$val['atn_weight']]['index'],
                            'atn_title'             => $noticeInfo[$val['atn_weight']]['title'],
                            'atn_article_id'        => $noticeInfo[$val['atn_weight']]['articleId'],
                            'atn_article_title'     => $noticeInfo[$val['atn_weight']]['articleTitle'],
                        );
                        $up_ret = $notice_storage->updateById($set,$val['atn_id']);
                        unset($noticeInfo[$val['atn_weight']]); //然后清理前端传过来的活动
                    }else{ //多余的删除
                        $del_id[] = $val['atn_id'];
                    }
                }
                if(!empty($del_id)){
                    $notice_where = array();
                    $notice_where[] = array('name' => 'atn_id','oper' => 'in' , 'value' => $del_id);
                    $del_ret = $notice_storage->deleteValue($notice_where);
                }

            }

            //新增的课程
            if(!empty($noticeInfo)){
                $insert = array();
                foreach($noticeInfo as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}','{$val['title']}','','{$val['articleId']}','{$val['articleTitle']}','{$val['index']}','".time()."') ";
                }
                $ins_ret = $notice_storage->insertBatch($insert);
            }
        }else{ //若数组为空，则清空该店铺通知
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
    /*
     * 查询首页公告
    */
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

    /**
     * 保存三级分销配置
     */
    private function _save_copartner_cfg(){
        $level = $this->request->getIntParam('level');
        //新增是否开启三级分销提醒
        $istip   = $this->request->getIntParam('istip');
        //入驻店铺是否参与分销
        $shopJoin   = $this->request->getIntParam('shopJoin');
        $set   = array();
        if($level){
            $set['tc_level'] = $level;
            $set['tc_shop_join'] = $shopJoin;
            $set['tc_istip'] = $istip;
        }

        /* if(isset$istip){

         }*/
        if(!empty($level)){
            $copartner_cfg = new App_Model_Three_MysqlCfgStorage($this->curr_sid);
            $copartner_cfg->findShopCfg($set);
        }
    }
    /**
     * @param $old
     * @param $new
     * 判断文件不一样，则更新会员二维码
     */
    private function _check_qrcode_change($old,$new){
        $old_arr = explode('/',$old);
        $new_arr = explode('/',$new);
        //文件名不一样
        if($old_arr[count($old_arr) - 1] != $new_arr[count($new_arr) - 1]){
            $member_helper = new App_Helper_MemberLevel();
            $member_helper->clearSpreadImage($this->curr_sid);
        }
    }
    /******************分销中心*结束*********************/

    /****************** 分销会员 **********************/
    public function memberAction(){
        //$this->_check_copartner_level();
        $this->secondLink('member');
        $this->_show_member_data_list();
        $this->output['choseLink'] = array(
            array(
                'href'  => '/wxapp/copartner/member?type=all',
                'key'   => 'all',
                'label' => '全部合伙人'
            ),
            array(
                'href'  => '/wxapp/copartner/member?type=highest',
                'key'   => 'highest',
                'label' => '最高级'
            ),
        );;
        $level_model = new App_Model_Member_MysqlLevelStorage();
        $this->output['mLevel'] = $level_model->getListBySidForSelect($this->curr_sid);
        $three_level_model = new App_Model_Copartner_MysqlCopartnerLevelStorage($this->curr_sid);
        $this->output['threeLevelList'] = $three_level_model->getListBySidForSelect($this->curr_sid);
        $copartnerSale  = App_Helper_ShopWeixin::checkShopThreeLevel($this->curr_sid); //分销等级
        $this->output['threeLevel'] = $copartnerSale;
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '分销中心', 'link' => '/wxapp/copartner/index'),
            array('title' => '会员关系', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/copartner/member-list.tpl');
    }
    private function _show_member_data_list(){

        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;

        $where = array();
        $where[] = array('name' => 'm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $output = array();
        //会员昵称查询
        $output['nickname'] = $this->request->getStrParam('nickname');
        if($output['nickname']){
            $where[] = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$output['nickname']}%");
        }

        //类型枚举，all全部，highest最高级会员，refer推荐人,out跑路人（没有关注或不再关注人,slient观望者
        $output['type'] = $this->request->getStrParam('type','all');
        if($output['type'] == 'slient'){
            $where[] = array('name' => 'm_is_slient', 'oper' => '=', 'value' => 1);
        }else{ //除了观望者，其他状态都过滤掉观望者
            //$where[] = array('name' => 'm_is_slient', 'oper' => '=', 'value' => 0);
            if($output['type'] == 'highest'){
                $where[] = array('name' => 'm_is_highest', 'oper' => '=', 'value' => 1);
            }elseif($output['type'] == 'refer'){
                $where[] = array('name' => 'm_is_refer', 'oper' => '=', 'value' => 1);
            }elseif($output['type'] == 'out'){
                $where[] = array('name' => 'm_is_follow', 'oper' => '=', 'value' => 0);
            }
        }

        //会员编号查询
        $output['mid'] = $this->request->getIntParam('mid');
        if($output['mid']){
            $where[] = array('name' => 'm_show_id', 'oper' => '=', 'value' => $output['mid']);
        }
        $output['rmid'] = $this->request->getIntParam('realMid'); //真正的Mid
        if($output['rmid']){
            $where[] = array('name' => 'm_id', 'oper' => '=', 'value' => $output['rmid']);
        }
        //会员手机号查询
        $output['mobile'] = $this->request->getStrParam('mobile');
        if($output['mobile']){
            $where[] = array('name' => 'm_mobile', 'oper' => '=', 'value' => $output['mobile']);
        }

        //会员备注查询
        $output['remark'] = $this->request->getStrParam('remark');
        if($output['remark']){
            $where[] = array('name' => 'm_remark', 'oper' => 'like', 'value' => "%{$output['remark']}%");
        }


        $hasfid = false;
        //上级，上二级，上三级查询功能
        for($i=1;$i<=3;$i++){
            $fid = $this->request->getIntParam($i.'f_id');
            if($fid){
                $hasfid = true;
                $where[] = array('name' => 'm_'.$i.'f_id', 'oper' => '=', 'value' => $fid);
            }
        }
        if(!$hasfid){
            if($this->curr_sid != 12338){
                $where[] = array('name' => 'ame_copartner', 'oper' => '>', 'value' => 0);
            }
        }

        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $total = $member_model->getCopartnerCount($where);

        $page_plugin = new Libs_Pagination_Paginator($total,$this->count,'jquery',1);
        $output['paginator'] = $page_plugin->render();
        $list = array();
        if($total > $index){

            $list = $member_model->getMemberBySubordinateList($where,$index,$this->count);
            $output['level'] = $this->show_member_level_info($list);
        }
        $level_model = new App_Model_Copartner_MysqlCopartnerLevelStorage($this->curr_sid);
        foreach($list as $key=>$val){
            $level = $level_model->getRowById($val['ame_copartner']);
            $list[$key]['levelName'] = $level['cl_name'];
            for ($i=1; $i<=3; $i++) {
                $where = array();
                $where[] = array('name' => 'm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
                $where[] = array('name' => 'm_'.$i.'f_id', 'oper' => '=', 'value' => $val['m_id']);
                $total = $member_model->getCount($where);
                $list[$key]['total'.$i] = $total;
            }
        }
        $output['list'] = $list;

        //获得统计信息
        $where_total = $where_highest = [];
        $where_total[] = ' ( m_1f_id != 0 OR m_is_highest = 1 ) ';
        $where_total[] = $where_highest[] = ['name' => 'm_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where_highest[] = ['name' => 'm_is_highest', 'oper' => '=', 'value' => 1];
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


    /******************分销订单**********************/
    public function orderAction() {
        //$this->_check_copartner_level();
        $this->secondLink('order');
        $this->showTypeByKey('trade_status');
        $this->output['choseLink'] = array(
            array(
                'href'  => '/wxapp/copartner/order?status=all',
                'key'   => 'all',
                'label' => '全部'
            ),
            array(
                'href'  => '/wxapp/copartner/order?status=nopay',
                'key'   => 'nopay',
                'label' => '待付款'
            ),
            array(
                'href'  => '/wxapp/copartner/order?status=pay',
                'key'   => 'pay',
                'label' => '已付款'
            ),
            array(
                'href'  => '/wxapp/copartner/order?status=complete',
                'key'   => 'complete',
                'label' => '已完成'
            ),
            array(
                'href'  => '/wxapp/copartner/order?status=refund',
                'key'   => 'refund',
                'label' => '已退款'
            ),
            array(
                'href'  => '/wxapp/copartner/order?status=close',
                'key'   => 'close',
                'label' => '已关闭'
            ),
        );
        $copartnerSale  = App_Helper_ShopWeixin::checkShopThreeLevel($this->curr_sid); //分销等级
        $this->output['threeLevel'] = $copartnerSale;

        $where[] = array('name'=>'t_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET );
        $this->output['todayTradeInfo'] = $this->_show_order_stat($where,true);

        $this->_show_order_data_list();
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '分销中心', 'link' => '/wxapp/copartner/index'),
            array('title' => '分销订单', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/copartner/order-list.tpl');
    }

    private function _show_order_data_list(){
        $page = $this->request->getIntParam('page');
        $index= $page * $this->count;
        $sort   = array('od_create_time' => 'DESC');//订单生成时间倒序排列
        //必须是自己公司，当前店铺的订单
        $where = array();
        $where[] = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name'=>'t_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET );

        //检索查询，条件整理
        $output = array();

        //订单编号
        $output['tid'] = $this->request->getStrParam('tid');
        if($output['tid']){
            $where[] = array('name' => 't_tid', 'oper' => '=', 'value' => $output['tid']);
        }
        //商品标题检索
        $output['title'] = $this->request->getStrParam('title');
        if($output['title']){
            $where[] = array('name' => 't_title', 'oper' => 'like', 'value' => "%{$output['title']}%");
        }

        //购买人昵称检索
        $output['nickname'] = $this->request->getStrParam('nickname');
        if($output['nickname']){
            $where[] = array('name' => 't_buyer_nick', 'oper' => 'like', 'value' => "%{$output['nickname']}%");
        }

        //订单状态
        $output['status'] = $this->request->getStrParam('status','all');
        $status = plum_parse_config('trade_status_search');
        if(isset($status[$output['status']]) && $status[$output['status']]){
            $where[] = array('name' => 't_status', 'oper' => '=', 'value' => $status[$output['status']]);
        }

        //上级，上二级，上三级查询功能
        for($i=1;$i<=3;$i++){
            $fid = $this->request->getIntParam($i.'f_id');
            if($fid){
                $where[] = array('name' => 'od_'.$i.'f_id', 'oper' => '=', 'value' => $fid);
            }
        }


        //会员编号检索
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

        $deduct_storage  = new App_Model_Shop_MysqlOrderDeductStorage($this->curr_sid);
        //订单总数
        $total = $deduct_storage->getDeductByMidSidCount($where);
        $output['searchTradeInfo'] = $this->_show_order_stat($where,FALSE);
        //分页功能
        $page_plugin = new Libs_Pagination_Paginator($total,$this->count,'jquery',1);
        $this->output['paginator'] = $page_plugin->render();

        //订单列表数据
        $list = array();
        if($total > $index){
            $list = $deduct_storage->getDeductByMidSid($where,$index,$this->count,$sort);
            $this->output['level'] = $this->show_member_level_info($list,'od_');
        }
        $output['list'] = $list;
        $this->showOutput($output);
    }

    /**
     * 佣金流水
     */
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
            /**
             * 流水记录类型
             * 收入：1、返现；2、分享
             * 支出：3、退款；4、提现
             */
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
            $this->output['choseLink'] = $table_menu->showTableLink('copartner_day_book',array('mid'=>$output['mid']));

            $this->buildBreadcrumbs(array(
                array('title' => '分销会员', 'link' => '/wxapp/copartner/member'),
                array('title' => '佣金流水', 'link' => '#'),
            ));
            $this->displaySmarty('wxapp/member/day-book.tpl');
        }else{
            plum_url_location('非法请求');
        }
    }


    /******************分销会员*结束*********************/



    /******************佣金提现（withdraw）**********************/
    /*
     * 提现
     */
    public function withdrawAction() {
        //$this->_check_copartner_level();
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
            array('title' => '分销中心', 'link' => '/wxapp/copartner/index'),
            array('title' => '会员提现', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/copartner/withdraw-list.tpl');
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
        $page_plugin    = new Libs_Pagination_Paginator($total,$this->count,'jquery',1);
        $output['paginator'] = $page_plugin->render();
        $list  = array();
        if($total > $index){
            $list = $withdraw_model->getMemberList($where,$index,$this->count,$sort);
        }
        $output['list'] = $list;

        //获得统计信息
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
    /**
     * 申请提现处理
     * 只能处理状态为0的订单
     */
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
            //未处理的申请，才能进行操作
            $where[] = array('name'=>'wd_audit','oper'=>'=','value'=>0);
            $withdraw_model = new App_Model_Member_MysqlWithDrawalStorage();
            $record = $withdraw_model->getRow($where);
            if($record){
                $flag = true; //状态
                $tid  = '';
                if(($record['wd_type'] == 1 || $record['wd_type'] == 3) && $status == 1 && in_array($type,array(1,2,3))){ //微信红包,转账到零钱，转账到银行卡
                    $payRes = $this->_applet_weixin_auto_deal($record,$type);
                    if(!empty($payRes) && $payRes['errno'] == true){
                        $tid = $payRes['send_listid']; //汇款订单号
                    }else{
                        $flag = false;
                        $result['em'] = isset($payRes['errmsg']) ? $payRes['errmsg'] :'微信红包支付失败';
                    }
                }
                //可以更改订单状态
                if($flag){
                    if($status == 1){
                        $set['wd_curr_type']  = $type;
                    }
                    $ret = $withdraw_model->updateValue($set,$where);
                    //修改用户金额，并通过时记录交易流水
                    $this->_deal_withdraw_result($record,$status,$tid);
                    if($ret){
                        $result = array(
                            'ec' => 200,
                            'em' => '处理成功'
                        );
                        $str = $status == 1 ? '通过' : '不通过';
                        App_Helper_OperateLog::saveOperateLog("审核提现申请成功，审核结果：{$str}");
                    }else{
                        $result['em'] = '处理失败';
                    }
                }
            }
        }
        $this->displayJson($result);
    }

    /*
     * 微信自动提现处理
     */
    private function _weixin_auto_deal(array $record, $pay_type = self::WEIXIN_PAT_REDPACK) {
        //非微信转账类型
        if ($record['wd_type'] != 1) {
            return array('errno' => false, 'errmsg' => '非微信转账类型');
        }
        //待审核才能提现
        if ($record['wd_audit'] != 0) {
            return array('errno' => false, 'errmsg' => '非待审核状态');
        }
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->getRowById($record['wd_m_id']);

        $pay_model      = new App_Model_Trade_MysqlPayTypeStorage($this->curr_sid);
        $type           = $pay_model->findUpdateCfgBySid();
        //开通微信自有
        if ($type && $type['pt_wxpay_zy']) {
            $wxpay_plugin   = new App_Plugin_Weixin_NewPay($this->curr_sid);
            if ($pay_type == self::WEIXIN_PAT_REDPACK) {
                $ret    = $wxpay_plugin->sendRedpack($member['m_openid'], $record['wd_money']);
            } else {
                $ret    = $wxpay_plugin->payTransfer($member['m_openid'], $record['wd_money'], $record['wd_realname']);
            }
        } else {
            //使用微信代销,使用店铺充值金额作为提现金额
            $balance    = floatval($this->shops[$this->curr_sid]['s_recharge']);
            if ($balance < floatval($record['wd_money'])) {
                //店铺余额不足以支持本次提现
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
            //提现成功,扣除店铺余额,并记录
            if (!$ret['code']) {
                $inout_model    = new App_Model_Shop_MysqlBalanceInoutStorage($this->curr_sid);
                $indata = array(
                    'bi_s_id'       => $this->curr_sid,
                    'bi_title'       => "会员ID{$member['m_id']}申请提现{$record['wd_money']}元",
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

    /**
     * @param array $record
     * @param $status
     * @param string $tid
     * @return bool
     * 转账成功后，1、处理用户金额；2、记录流水
     */
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

    /**
     * 回滚
     */
    public function rollbackWithdrawAction(){
        $data = array(
            'ec' => 400,
            'em' => '状态错误'
        );
        $this->displayJson($data,true); //回滚暂时隐藏

        $id = $this->request->getIntParam('id');
        $withdraw_model = new App_Model_Member_MysqlWithDrawalStorage();
        $row            = $withdraw_model->getRowByIdSid($id,$this->curr_sid);
        if($row['wd_audit'] == 1){
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $deduct_ret   = $member_model->rollbackWithdraw($row['wd_money'],$this->curr_sid,$row['wd_m_id']);
            if($deduct_ret){
                $set = array(
                    'wd_audit' => 0 //再次回到待审核
                );
                $ret  = $withdraw_model->getRowUpdateByIdSid($id,$this->curr_sid,$set);
                $data = $this->showAjaxResult($ret,'回滚',1);
                App_Helper_OperateLog::saveOperateLog("回滚提现审核成功");
            }else{
                $data['em'] = '回滚金额失败';
            }
        }

        $this->displayJson($data);
    }

    /**
     * 微信配置
     */
    public function withdrawCfgAction(){
        //$this->_check_copartner_level();
        $this->secondLink('withdraw');
        $cgf_model =  new App_Model_Shop_MysqlWithdrawCfgStorage();
        $row = $cgf_model->findCfgBySid($this->curr_sid);
        $this->output['row'] = $row;
        $this->buildBreadcrumbs(array(
            array('title' => '提现管理', 'link' => '/wxapp/copartner/withdraw'),
            array('title' => '提现配置', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/copartner/withdraw-cfg.tpl');
    }
    public function branchAction(){
        //$this->_check_copartner_level();
        $this->secondLink('branch');
        $this->branch_list_data();

        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '分销中心', 'link' => '/wxapp/copartner/index'),
            array('title' => '购买记录', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/copartner/branch-list.tpl');
    }
    /**
     * 重新生成商品二维码
     */
    public function createQrcodeAction(){
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        $str = '1'; //此参数传空无法请求到二维码
        $apply_qrcode = $client_plugin->fetchWxappShareCode($str, $client_plugin::DISTRIB_BECOME_PARTNER_PATH, 210);
        $copartner_cfg  = new App_Model_Three_MysqlCfgStorage($this->curr_sid);
        if($apply_qrcode){
            $updata = array('tc_apply_qrcode'=>$apply_qrcode);
            $copartner_cfg->findShopCfg($updata);
        }
        $res = array('ec'=> 200,'em'=> '创建成功！','url'=> $apply_qrcode);
        $this->displayJson($res);
    }
    /*
     * 下载二维码
     */
    public function downloadQrcodeAction(){
        $copartner_cfg  = new App_Model_Three_MysqlCfgStorage($this->curr_sid);
        $tcRow         = $copartner_cfg->findShopCfg();
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
        //$this->_check_copartner_level();
        $this->secondLink('branchCfg');
        $copartner_model = new App_Model_Three_MysqlCfgStorage($this->curr_sid);
        $row         = $copartner_model->getRowValue();
        $this->output['row'] = $row;

        //@todo 查询分销配置
        $copartner_cfg  = new App_Model_Three_MysqlCfgStorage($this->curr_sid);
        $tcRow         = $copartner_cfg->findShopCfg();
        if(!$tcRow){
            $updata = array(
                'tc_type'           => 1,
                'tc_open_time'      => $this->wxapp_cfg['ac_open_time'],
                'tc_expire_time'    => $this->wxapp_cfg['ac_expire_time'],
                'tc_update_time'    => time(),
                'tc_s_id'           => $this->curr_sid,
                'tc_is_branch'      => 0,
                'tc_level'          => 3,
                'tc_domain'         => $this->_get_domain(),
                'tc_ios_apply'      => 1
            );
            $copartner_cfg->insertValue($updata);
        }
        $row['tc_level']     = $tcRow['tc_level'];
        $row['tc_istip']     = $tcRow['tc_istip'];
        $this->output['tcRow'] = $tcRow;

        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '合伙人审核', 'link' => '/distrib/copartner/branch'),
            array('title' => '页面配置', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/copartner/branch-cfg.tpl');
    }

    /**
     * 保存配置信息
     */
    public function saveBranchCenterAction(){
        $field = array('vip','hasname','hasphone','haswx');
        $data  = $this->getIntByField($field,'tc_fx_');
        $data['tc_fx_banner']     = $this->request->getStrParam('banner');
        $data['tc_fx_page_title'] = $this->request->getStrParam('pageTitle');
        $data['tc_fx_btn_text']   = $this->request->getStrParam('btnText');
        $data['tc_fx_welcome_text']   = $this->request->getStrParam('welcomeText');
        $data['tc_ios_apply']     = $this->request->getIntParam('iosApply');
        $data['tc_fx_desc']       = plum_nl_br($this->request->getStrParam('desc'));
        $data['tc_update_time']   = $_SERVER['REQUEST_TIME'];
        $three_model = new App_Model_Three_MysqlCfgStorage($this->curr_sid);
        $ret         = $three_model->findShopCfg($data);
        if($ret){
            App_Helper_OperateLog::saveOperateLog("保存合伙人申请页配置成功");
        }
        $this->showAjaxResult($ret,'保存');
    }


    private function branch_list_data(){
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $where      = array();
        $where[]    = array('name' => 'cr_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $output['mobile'] = $this->request->getStrParam('mobile');
        if($output['mobile']){
            $where[]    = array('name' => 'm_mobile', 'oper' => 'like', 'value' => "%{$output['mobile']}%");
        }
        $output['realname'] = $this->request->getStrParam('realname');
        if($output['realname']){
            $where[]    = array('name' => 'm_realname', 'oper' => 'like', 'value' => "%{$output['realname']}%");
        }

        $record_model = new App_Model_Copartner_MysqlCopartnerRecordStorage($this->curr_sid);
        $total      = $record_model->getOrderCount($where);
        $page_lib   = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $list       = array();
        if($total > $index){
            $list   = $record_model->getOrderList($where,$index,$this->count, array('cr_create_time' => 'desc'));
        }
        $output['paginator']  = $page_lib->render();
        $output['list']       = $list;

        //获得统计信息
        $where_total = [];
        $where_total[] = ['name' => 'cr_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $totalInfo = $record_model->getStatInfo($where_total);
        $memberCount = $record_model->getCountMember($where_total);
        $statInfo = [
            'total' => intval($totalInfo['total']),
            'money' => floatval($totalInfo['money']),
            'member' => intval($memberCount)
        ];
        $output['statInfo'] = $statInfo;
        $output['payType'] = array(
            1 => '微信支付',
            2 => '支付宝支付',
            3 => '余额支付'
        );
        $this->showOutput($output);
    }

    /**
     * 提现相关配置
     */
    public function saveWithdrawCfgAction(){
        $result = array(
            'ec' => 400,
            'em' => '请求参数错误'
        );
        $data['wc_desc']       = $this->request->getStrParam('wc_desc');
        $data['wc_min']        = $this->request->getIntParam('wc_min');
        //$data['wc_wx_actname'] = $this->request->getStrParam('wc_wx_actname');
        //$data['wc_wx_open']    = $this->request->getIntParam('wc_wx_open');   // 红包提现
        $data['wc_change_open']= $this->request->getIntParam('wc_wx_open');     // 微信零钱提现
        $data['wc_bank_open']  = $this->request->getIntParam('wc_bank_open');   // 银行卡提现
        $data['wc_auto']  = $this->request->getIntParam('wc_auto');   // 自动提现
        $data['wc_mobile_open']  = $this->request->getIntParam('wc_mobile_open');   // 微信提现手机开启
        $data['wc_account_open']  = $this->request->getIntParam('wc_account_open');   // 微信提现账户开启
        $data['wc_bank_mobile_open']  = $this->request->getIntParam('wc_bank_mobile_open');   // 银行卡提现手机开启
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
                App_Helper_OperateLog::saveOperateLog("保存提现配置成功");
            }else{
                $result['em'] = '保存失败';
            }
        }
        $this->displayJson($result);
    }
    /**
     * 保存支付配置公钥
     */
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
    /******************佣金提现结束**********************/

    /*
    * 小程序微信自动提现处理
    */
    private function _applet_weixin_auto_deal(array $record, $pay_type = self::WEIXIN_PAT_REDPACK) {
        //非微信转账类型
        if (!in_array($record['wd_type'],array(self::WEIXIN_PAT_REDPACK,self::WEIXIN_PAY_BANK))) {
            return array('errno' => false, 'errmsg' => '非微信转账类型');
        }
        //待审核才能提现
        if ($record['wd_audit'] != 0) {
            return array('errno' => false, 'errmsg' => '非待审核状态');
        }
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->getRowById($record['wd_m_id']);

        $pay_storage    = new App_Model_Auth_MysqlPayTypeStorage($this->curr_sid);
        $payCfg = $pay_storage->findRowPay();
        //开通微信自有
        if ($payCfg && $payCfg['pt_wxpay_applet']) {
            $wxpay_plugin   = new App_Plugin_Weixin_NewPay($this->curr_sid);
            $money          = $record['wd_money']-$record['wd_service_money'];
            if ($pay_type == self::WEIXIN_PAT_REDPACK) {  //$record['wd_money']
                $ret    = $wxpay_plugin->appletSendRedpack($member['m_openid'],$money);
            } else if($pay_type == self::WEIXIN_PAY_TRANSFER) {
                $ret    = $wxpay_plugin->appletPayTransfer($member['m_openid'], $record['wd_real_money'], $record['wd_realname']);  //微信转账到零钱
            } else if($pay_type == self::WEIXIN_PAY_BANK) {
                $ret    = $wxpay_plugin->appletPayBank($record['wd_account'], $record['wd_realname'], $record['wd_bank'],$record['wd_real_money']);  // 微信转账到银行卡
            }
            Libs_Log_Logger::outputLog($ret);
        }

        if (!$ret['code']) {
            return array('errno' => true, 'errmsg' => '微信转账成功');
        } else {
            return array('errno' => false, 'errmsg' => $ret['errmsg']);
        }
    }

    /**
     * 添加单品分销
     */
    public function goodsRatioAction(){
        $this->secondLink('goods');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '分销中心', 'link' => '/wxapp/copartner/index'),
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
        $this->output['copartnerSale']  = App_Helper_ShopWeixin::checkShopThreeLevel($this->curr_sid); //分销等级
        $this->displaySmarty('wxapp/copartner/addGoods.tpl');
    }

    private function get_goods_list(){
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $sort        = array('g_weight' => 'DESC','g_update_time'=>'DESC');
        $field       = array('g_id','g_name');
        $where[]     = array('name' => 'g_es_id', 'oper' => '=', 'value' => 0);
        $goods       = $goods_model->fetchShopGoodsList($this->curr_sid,0,0,'',0,$sort,$field, 0, 0, 1, $where);
        $this->output['goodsList'] = $goods;
    }

    /*
     * 培训用 获得课程
     */
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

    /**
     * 开启或关闭三级分销
     */
    public function openThreeDistribAction(){
        $status = $this->request->getIntParam('status');
        $copartner_cfg  = new App_Model_Three_MysqlCfgStorage($this->curr_sid);
        $tcRow         = $copartner_cfg->findShopCfg();
        if($tcRow){
            $set = array('tc_copartner_isopen'=>$status);
            $ret = $copartner_cfg->findShopCfg($set);
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
            $ret = $copartner_cfg->insertValue($updata);
        }
        if($ret){
            $str = $status == 1 ? '开启' : '关闭';
            App_Helper_OperateLog::saveOperateLog("{$str}三级分销成功");
        }

        $this->showAjaxResult($ret);
    }

    /*
     * 设置不同等级分销比例
     */
    public function setupLevelAction(){
        $this->showTypeByKey('yesNo');
        $this->secondLink('level');
        $level_model = new App_Model_Member_MysqlLevelStorage();
        $this->output['list'] = $level_model->getListBySid($this->curr_sid);
        $this->buildBreadcrumbs(array(
            array('title' => '分销设置', 'link' => '/wxapp/copartner/index'),
            array('title' => '会员等级', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/member/distrib-setup.tpl');
    }

    /**
     * 统计订单信息
     */
    private function _show_order_stat($where,$today = true){
        if($today){
            $time = strtotime(date('Y-m-d',time())); // 获取今天0点的时间
            $where[] = array('name'=>'t_create_time','oper'=>'>=','value'=>$time);
        }

        $where[] = array('name'=>'t_status','oper'=>'in','value'=>array(3,4,5,6));  //获取已付款,已发货,确认收货,已完成的订单,
        $where[] = array('name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid);
        $order_model = new App_Model_Shop_MysqlOrderDeductStorage($this->curr_sid);
        return $order_model->statOrderStatistic($where);
    }

    /*
     * 获取会员上月的销售额排行
     */

    public function LastMonthLevelAction($mid){
        $member_relation = new App_Model_Member_MysqlMemberRelationStorage();
        $where = array();
        // 获取上月的开始时间和上月的截止时间
        $startTime = strtotime(date('Y',time()).'-'.(date('m',time())-1).'-01');  // 上月1号时间
        $endTime = strtotime(date('Y-m',time()).'-01');  // 本月1号时间
        $where[] = array('name'=>'mr_f_id','oper'=>'=','value'=>$mid);
        $where[] = array('name'=>'mr_create_time','oper'=>'>','value'=>$startTime);
        $where[] = array('name'=>'mr_create_time','oper'=>'<','value'=>$endTime);
        $oneCount = $member_relation->getCount($where);  // 获取上月直接发展的上一级的数量

        // 获取该会员上月发展的下二级的数量 (也就是该会员下级发展的下一级)
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();

        $memberList = $member_storage->fetchFirstLevelList($mid,0,0);
    }

    /**
     * 会员关系图
     */
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
            array('title' => '分销中心', 'link' => '/wxapp/copartner/index'),
            array('title' => '会员关系', 'link' => '/wxapp/copartner/member'),
            array('title' => '查看会员关系', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/copartner/relation.tpl');
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

    /**
     * 设置最高级
     */
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
                //修改下级的上级
                if($i!=3){
                    $where = array();
                    $where[] = array('name' => 'm_'.$i.'f_id', 'oper' => '=', 'value' => $mid);
                    $set = array('m_'.($i+1).'f_id' => 0);
                    $member_model->updateValue($set, $where);
                }
            }

            if($ret){
                $nickname = $member['m_nickname'];
                App_Helper_OperateLog::saveOperateLog("设置用户【{$nickname}】为最高级");
            }

            $this->showAjaxResult($ret, '设置');
        }
    }

    /**
     * utf8字符转换成Unicode字符
     */
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

    /*
     * 过滤掉昵称中特殊字符
     */
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

    /**
     * 清空其所有下级的关系
     */
    public function emptyChildrenAction(){
        $mid = $this->request->getIntParam('mid');
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
            //删除和上级的关系记录
            $member_relation = new App_Model_Member_MysqlMemberRelationStorage();
            $where = array();
            $where[] = array('name'=>'mr_f_id','oper'=>'=','value'=>$member['m_1f_id']);
            $where[] = array('name'=>'mr_s_id','oper'=>'=','value'=>$member['m_id']);
            $member_relation->deletedMemberRelation($where, true);
            //清空所有下级
            $this->_empty_children($mid);
            //删除分销会员等级
            $extra_model = new App_Model_Member_MysqlMemberExtraStorage($this->curr_sid);
            $extra_model->findUpdateExtraByMid($mid, array('ame_copartner' => 0));
        }

        $nickname = $member['m_nickname'];
        App_Helper_OperateLog::saveOperateLog("清空用户【{$nickname}】下级关系");

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

    /**
     * 为会员设置下级
     */
    public function setChildrenAction(){
        $mid = $this->request->getIntParam('mid');
        $sid = $this->request->getIntParam('sid');
        if($mid && $sid){
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $member = $member_model->getRowById($sid);
            if($mid != $sid && !$member['m_is_highest'] && !$member['m_1f_id']){
                App_Helper_MemberLevel::setLevelSendMessage($this->curr_sid, $sid, $mid);

                $nickname = $member['m_nickname'];
                App_Helper_OperateLog::saveOperateLog("设置用户【{$nickname}】下级");

                $this->showAjaxResult(1, '设置');
            }else{
                $this->showAjaxResult(0, '设置');
            }
        }
        $this->showAjaxResult(0, '设置');
    }

    /**
     * 修改分销等级
     */
    public function changeThreeLevelAction(){
        $mid = $this->request->getIntParam('id');
        $level = $this->request->getIntParam('level');

        if($mid && $level !=0 ){
            $set   = array(
                'ame_copartner'     => $level > 0 ? $level : 0, //分销等级
            );
            $extra_model = new App_Model_Member_MysqlMemberExtraStorage($this->curr_sid);
            $ret          = $extra_model->findUpdateExtraByMid($mid, $set);

            if($ret){
                $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                $level_model = new App_Model_Copartner_MysqlCopartnerLevelStorage($this->curr_sid);
                $member = $member_model->getRowById($mid);
                $level = $level_model->getRowById($level);
                $nickname = $member['m_nickname'];
                App_Helper_OperateLog::saveOperateLog("修改用户【{$nickname}】分销等级为【{$level['cl_name']}】");
            }

            $result       = $this->showAjaxResult($ret,'保存',true);
        }
        $this->displayJson($result);
    }

    /**
     * 创建分销海报
     */
    public function threePostCreateAction(){
        $mid = $this->request->getIntParam('mid');

        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_storage->getRowById($mid);
        //合伙人 检查是否已购买等级
        $copartner_cfg  = new App_Model_Three_MysqlCfgStorage($this->curr_sid);
        $tcRow         = $copartner_cfg->findShopCfg();
        if($tcRow['tc_copartner_isopen'] == 1){
            $extra_model = new App_Model_Member_MysqlMemberExtraStorage($this->curr_sid);
            $extra = $extra_model->findUpdateExtraByMid($mid);
            if(!$extra || $extra['ame_copartner'] == 0){
                $this->displayJsonError('请先购买合伙人');
            }
        }
        //检查是否是真实会员
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
        //获取会员等级说明
        $level      = App_Helper_MemberLevel::fetchMemberLevel($this->curr_sid, $member['m_id']);
        //推广二维码不存在或已失效
        $qrcodeVerify = getimagesize(PLUM_DIR_ROOT.$member['m_spread_qrcode']);  // 验证二维码是否存现
        if (!$member['m_spread_qrcode'] || !$member['m_spread_image'] || !$qrcodeVerify) {
            $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
            $str = "mid=".$member['m_id'];
            if($this->wxapp_cfg['ac_type'] == 6 || $this->wxapp_cfg['ac_type'] == 8){
                $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::CITY_DISTRIB_SHARE_CODE_PATH, 210);
            }else{
                $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::DISTRIB_SHARE_CODE_PATH, 210);
            }

            //设置并存储会员推广二维码
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
        $qrcodeVerify = getimagesize(PLUM_DIR_ROOT.$qrcode);  // 验证二维码是否存现
        if(!$qrcodeVerify){
            $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
            $str = "mid=".$member['m_id'];
            $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::DISTRIB_SHARE_CODE_PATH, 210);

            //设置并存储会员推广二维码
            $qrcode = $url;
        }
        //推广二维码画报重新生成
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
            //将二维码图片放置在指定坐标处
            $dst_x      = intval($qrcode_loc[0]);
            $dst_y      = intval($qrcode_loc[1]);

            imagecopyresampled($bs_img, $qr_img, $dst_x, $dst_y, 0, 0, $center_cfg['cc_qrcode_size']*2, $center_cfg['cc_qrcode_size']*2,$q_w, $q_h);

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
            //保存推广二维码图片
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
            $member_storage->updateById($updata, $member['m_id']);
        }
        return $spread_image;
    }

    /******************会员卡分销订单**********************/
    public function cardOrderAction() {
        //$this->_check_three_level();
        $this->secondLink('cardorder');
        $this->showTypeByKey('trade_status');
        $table_menu = new App_Helper_TableMenu();
        $this->output['choseLink'] = $table_menu->showTableLink('wxappThreeOrder');
        $threeSale  = App_Helper_ShopWeixin::checkShopThreeLevel($this->curr_sid); //分销等级
        $this->output['threeLevel'] = $threeSale;

        $where[] = array('name'=>'oo_status','oper'=>'=','value'=>2 );
        $this->output['todayTradeInfo'] = $this->_show_card_order_stat($where,true);

        $this->_show_card_order_data_list();
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

        $goodsName = '会员卡';
        $this->output['threeType'] = 'copartner';
        $this->output['threeMember'] = $threeMember;
        $this->output['goodsName'] = $goodsName;
        $this->output['appletCfg'] = $this->wxapp_cfg;
        $this->displaySmarty('wxapp/three/card-order-list.tpl');
    }
    private function _show_card_order_data_list(){
        $page = $this->request->getIntParam('page');
        $index= $page * $this->count;
        $sort   = array('od_create_time' => 'DESC');//订单生成时间倒序排列
        //必须是自己公司，当前店铺的订单
        $where = array();
        $where[] = array('name' => 'oo_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'oo_status', 'oper' => '=', 'value' => 2);
        $where[] = array('name' => 'od_type', 'oper' => '=', 'value' => 3); //会员卡分销记录
        //检索查询，条件整理
        $output = array();

        //订单编号
        $output['tid'] = $this->request->getStrParam('tid');
        if($output['tid']){
            $where[] = array('name' => 'oo_tid', 'oper' => '=', 'value' => $output['tid']);
        }
        //商品标题检索
        $output['title'] = $this->request->getStrParam('title');
        if($output['title']){
            $where[] = array('name' => 'oo_title', 'oper' => 'like', 'value' => "%{$output['title']}%");
        }

        //购买人昵称检索
        $output['nickname'] = $this->request->getStrParam('nickname');
        if($output['nickname']){
            $where[] = array('name' => 'oo_buyer_nick', 'oper' => 'like', 'value' => "%{$output['nickname']}%");
        }

        //会员id检索
        $output['mid'] = $this->request->getIntParam('mid');
        if($output['mid']){
            $where[] = array('name' => 'oo_m_id', 'oper' => '=', 'value' => $output['mid']);
        }

        //上级，上二级，上三级查询功能
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
        //订单总数
        $total = $deduct_storage->getDeductCardOrderCountByMidSid($where);
        $output['searchTradeInfo'] = $this->_show_card_order_stat($where,FALSE);
        //分页功能
        $page_plugin = new Libs_Pagination_Paginator($total,$this->count,'jquery');
        $this->output['paginator'] = $page_plugin->render();

        //订单列表数据
        $list = array();
        if($total > $index){
            $list = $deduct_storage->getDeductCardOrderByMidSid($where,$index,$this->count,$sort);
            $this->output['level'] = $this->show_member_level_info($list,'od_');
        }
        $output['list'] = $list;
        $this->showOutput($output);
    }

    /**
     * 统计订单信息
     */
    private function _show_card_order_stat($where,$today = true){
        if($today){
            $time = strtotime(date('Y-m-d',time())); // 获取今天0点的时间
            $where[] = array('name'=>'oo_create_time','oper'=>'>=','value'=>$time);
        }
        $where[] = array('name'=>'oo_status','oper'=>'=','value'=>2);  //已付款,
        $where[] = array('name'=>'oo_s_id','oper'=>'=','value'=>$this->curr_sid);
        $order_model = new App_Model_Shop_MysqlOrderDeductStorage($this->curr_sid);
        return $order_model->statCardOrderStatistic($where);
    }

}