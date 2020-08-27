<?php


class App_Controller_Wxapp_MeetingController extends App_Controller_Wxapp_InitController {

    public function __construct() {
        parent::__construct();

    }

    
    public function secondLink($type='prize'){
        $link = array(
            array(
                'label' => '活动管理',
                'link'  => '/wxapp/meeting/lotteryList',
                'active'=> 'lottery'
            ),
            array(
                'label' => '奖品管理',
                'link'  => '/wxapp/meeting/prizeList',
                'active'=> 'prize'
            ),
        );

        if(in_array($this->wxapp_cfg['ac_type'],[8,21,32])){
            $link[] = array(
                'label' => '订单抽奖',
                'link'  => '/wxapp/meeting/sendLottery',
                'active'=> 'sendLottery'
            );
        }

        $this->output['secondLink'] = $link;
        $this->output['linkType']   = $type;
        $this->output['snTitle']    = '抽奖活动管理';
    }

    
    public function _get_progress_list(){
        $progress_storage = new App_Model_Meeting_MysqlMeetingProgressStorage($this->curr_sid);
        $progress_list = $progress_storage->fetchProgressShowList();
        $data = array();
        if($progress_list){
            foreach ($progress_list as $val){
                $data[] = array(
                    'cid'        => $val['amp_c_id'],
                    'index'      => $val['amp_weight'],
                    'title'      => $val['amp_title'],
                    'brief'      => $val['amp_brief'],
                    'startTime' => $val['amp_start_time'],
                    'endTime'   => $val['amp_end_time'],
                );
            }
        }
        $this->output['progressList'] = json_encode($data);
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

    
    public function get_link_list_for_select(){
        $linkList = plum_parse_config('link','system');
        $linkType = plum_parse_config('link_type','system');
        $link = $linkList[$this->wxapp_cfg['ac_type']];
        $this->output['linkList'] = json_encode($link);
        $this->output['linkType'] = json_encode($linkType);
    }

    
    private function _show_category_list(){
        $category_model = new App_Model_Meeting_MysqlMeetingCategoryStorage($this->curr_sid);
        $list = $category_model->getListBySid();
        $categoryList = array();
        if($list){
            foreach ($list as $key => $val){
                $categoryList[] = array(
                    'id'    => $val['amc_id'],
                    'index' => $key,
                    'name'  => $val['amc_name']
                );
            }
        }
        $this->output['categoryList'] = json_encode($categoryList);
    }
    
    private function _new_show_category_list($amid){
        $category_model = new App_Model_Meeting_MysqlMeetingCategoryStorage($this->curr_sid);
        $list = $category_model->newGetListBySid($amid);
        $categoryList = array();
        if($list){
            foreach ($list as $key => $val){
                $categoryList[] = array(
                    'amid'  => $amid,
                    'id'    => $val['amc_id'],
                    'index' => $key,
                    'name'  => $val['amc_name']
                );
            }
        }
        $this->output['categoryList'] = json_encode($categoryList);
    }
    
    private function _shop_default_tpl(){
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        $cfg        = $applet_cfg->findShopCfg();
        if(!$cfg['ac_index_tpl']){
            $data = array('ac_index_tpl'=>42);
            $applet_cfg->findShopCfg($data);
        }
    }

    
    private function showIndexTpl($tpl_id=42){
        $tpl_model = new App_Model_Meeting_MysqlMeetingIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid($tpl_id);
        if(empty($tpl)){
            $tpl = array(
                'ami_title'         => '议程',
                'ami_tpl_id'        => $tpl_id,
            );
        }
        $this->output['tpl'] = $tpl;
    }
    public function lotteryListAction(){
        $this->secondLink('lottery');
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $list_model = new App_Model_Meeting_MysqlMeetingLotteryListStorage($this->curr_sid);
        $total = $list_model->getListCount();
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['paginator'] = $pageCfg->render();
        $list   = array();
        if($index <= $total){
            $list = $list_model->getListBySid($index, $this->count);
        }
        $this->output['list'] = $list;

        $record_model = new App_Model_Meeting_MysqlMeetingRecordStorage($this->curr_sid);
        $where_total = $where_prize = $where_verify = [];
        $where_total[] = $where_prize[] = $where_verify[] = ['name'=>'amr_s_id','oper'=>'=','value'=>$this->curr_sid];
        $where_prize[] = $where_verify[] = ['name'=>'amr_type','oper'=>'=','value'=>1];//已中奖
        $where_verify[] = ['name'=>'amr_status','oper'=>'=','value'=>1];//已中奖已核销
        $total = $record_model->getCount($where_total);
        $prize = $record_model->getCount($where_prize);
        $verify = $record_model->getCount($where_verify);
        $noPrize = intval($total) - intval($prize);
        $noVerify = intval($prize) -intval($verify);
        $statInfo = [
            'total' => intval($total),
            'prize' => intval($prize),
            'noPrize' => $noPrize >0 ? $noPrize : 0,
            'noVerify' => $noVerify > 0 ? $noVerify : 0,
            'verify' => $verify
        ];
        $this->output['statInfo'] = $statInfo;

        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '抽奖管理', 'link' => '/wxapp/meeting/prizeList'),
            array('title' => '抽奖活动', 'link' => '#'),
        ));

        $this->output['ac_type']=$this->wxapp_cfg['ac_type'];

        $this->displaySmarty('wxapp/meeting/lottery-list.tpl');
    }
    
    public function getQrcodeAction(){
        $test = $this->request->getIntParam('test');
        $path='subpages/getReward/getReward';
        $str = 'id=1';
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        $image=$client_plugin->getQrcodeDynamic($path,$str);
        if($test && $test==9){
            plum_msg_dump($image);
        }
        if($image){
            header("Content-type: image/png");
            echo $image;
        }
    }
    
    public function sendLotteryAction(){
        $this->secondLink('sendLottery');
        $shopModel  = new App_Model_Shop_MysqlShopCoreStorage();
        $row        = $shopModel->getRowById($this->curr_sid);
        $this->output['row']  = $row;
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '抽奖管理', 'link' => '/wxapp/meeting/prizeList'),
            array('title' => '订单抽奖', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/meeting/send-lottery1.tpl');
    }
    
    public function savePrizeCfgAction(){
        $isopen  = $this->request->getStrParam('isopen');
        $pnum    = $this->request->getIntParam('prizeNum');
        $cover   = $this->request->getStrParam('cover');
        $shopModel  = new App_Model_Shop_MysqlShopCoreStorage();
        if($isopen == 'on'){
            $open = 1;
        }else{
            $open = 0;
        }
        $set = array('s_isopen_prize'=> $open,'s_send_pnum'=>$pnum,'s_prize_cover'=>$cover);
        $res = $shopModel->updateById($set,$this->curr_sid);
        if($res){
            $this->showAjaxResult($res,'保存');
        }else{
            $this->displayJsonError('保存失败');
        }

    }

    
    public function saveActAction(){
        $id = $this->request->getIntParam('id');
        $name = $this->request->getStrParam('name');
        $start_time=$this->request->getStrParam('start_time');
        $status=$this->request->getStrParam('status');
        $list_model = new App_Model_Meeting_MysqlMeetingLotteryListStorage($this->curr_sid);
        if($id){
            $data = array(
                'amll_name' => $name,
                'amll_start_time'  =>strtotime($start_time),
                'amll_customer_status'=>$status,
            );
            $ret = $list_model->updateById($data, $id);
        }else{
            $data = array(
                'amll_s_id' => $this->curr_sid,
                'amll_name' => $name,
                'amll_status' => 0,
                'amll_create_time' => time(),
            );
            $ret = $list_model->insertValue($data);
        }
        App_Helper_OperateLog::saveOperateLog("抽奖活动【".$data['amll_name']."】保存成功");
        $this->showAjaxResult($ret);
    }

    
    public function delActAction(){
        $id = $this->request->getIntParam('id');
        $list_model = new App_Model_Meeting_MysqlMeetingLotteryListStorage($this->curr_sid);
        if($id){
            $set = array(
                'amll_deleted' => 1
            );
            $lottery = $list_model->getRowById($id);
            $ret = $list_model->updateById($set, $id);
            App_Helper_OperateLog::saveOperateLog("满减活动【".$lottery['amll_name']."】删除成功");
            $this->showAjaxResult($ret);
        }
    }
    
    public function changeIndexStatusAction(){
        $id     = $this->request->getIntParam('id');
        $status = $this->request->getIntParam('status');
        $ret    = '';
        if($id && $status){
            $list_model = new App_Model_Meeting_MysqlMeetingLotteryListStorage($this->curr_sid);
            $set = array(
                'amll_index_status' => $status
            );
            $ret = $list_model->updateById($set, $id);

        }
        $this->showAjaxResult($ret);
    }




    
    public function lotteryAction(){
        $id = $this->request->getIntParam('id');
        $tpl_id  = $this->request->getIntParam('tpl', 42);
        $list_model = new App_Model_Meeting_MysqlMeetingLotteryListStorage($this->curr_sid);
        $row        = $list_model->getRowById($id);
        $this->output['row'] = $row;
        $lottery_model = new App_Model_Meeting_MysqlMeetingLotteryStorage($this->curr_sid);
        $goodsList     = $lottery_model->getListBySid($id);
        $data          = array();
        if(empty($goodsList)){
            for($i = 0; $i<8;$i++){
                $data[] = array(
                    'id' => 0,
                    'type'  => '2',
                    'pid'   => '0',
                    'index' => $i,
                    'img'   => '/public/wxapp/meeting/images/no-lettery-new.png',
                    'name'  => '谢谢惠顾',//'谢谢惠顾',
                    'num'   => 0,
                );
            }
        }else{
            foreach($goodsList as $val){
                $data[] = array(
                    'id'    => $val['aml_id'],
                    'type'  => $val['aml_type'],
                    'index' => $val['aml_weight'],
                    'img'   => $val['aml_img'],
                    'name'  => $val['aml_name'],
                    'pid'   => $val['aml_pid'],
                    'num'   => $val['aml_num'],
                );
            }
        }
        $this->output['id'] = $id;
        $this->output['goodsList'] = json_encode($data);
        $this->buildBreadcrumbs(array(
            array('title' => '抽奖活动', 'link' => '/wxapp/meeting/lotteryList'),
            array('title' => '抽奖配置', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->_get_all_prize_goods_list();
        if($this->request->getIntParam('test')){
            $this->displaySmarty('wxapp/meeting/lottery-test2.tpl');
        }else{
            $this->displaySmarty('wxapp/meeting/lottery.tpl');
        }


    }

    
    private function _get_all_prize_goods_list(){
        $list_model = new App_Model_Meeting_MysqlMeetingPrizeListStorage($this->curr_sid);
        $prizeList  = $list_model->getListBySid();
        $data       = array();
        if($prizeList){
            foreach ($prizeList as $key=>$val){
                $data[] = array(
                    'id'    => $val['ampl_id'],
                    'name'  => $val['ampl_name'],
                    'cover' => $val['ampl_cover']
                );
            }
        }
        $this->output['prizeList']  =  json_encode($data);
    }
    public function saveRuleAction(){
        $id = $this->request->getIntParam('id');
        $number = $this->request->getIntParam('number');
        $rule = $this->request->getStrParam('rule');
        $points = $this->request->getIntParam('points');
        $give = $this->request->getIntParam('give');
        $pointOpen = $this->request->getIntParam('pointOpen');
        $list_model = new App_Model_Meeting_MysqlMeetingLotteryListStorage($this->curr_sid);
        $set = array(
            'amll_status' => 2,
        );
        $where[] = array('name'=>'amll_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'amll_status','oper'=>'=','value'=>1);
        $list_model->updateValue($set, $where);

        $curr_lottery = $list_model->getRowById($id);
        $set = array(
            'amll_status' => 1,
            'amll_rule'          => $rule,
            'amll_change_points' => $points,
            'amll_share_give'    => $give,
            'amll_points_open'   => $pointOpen

        );

        if($curr_lottery['amll_status']==0){
            $set['amll_frequency'] = $number;
        }

        $list_model->updateById($set,$id);
        $this->save_goods($id);

        App_Helper_OperateLog::saveOperateLog("抽奖配置保存成功");

        $this->showAjaxResult(1);
    }
    private function save_goods($id){
        $goodsList = $this->request->getArrParam('goodsList');
        $lottery_model = new App_Model_Meeting_MysqlMeetingLotteryStorage($this->curr_sid);
        $goods_list = $lottery_model->getListBySid($id);
        if($goods_list){
            foreach($goodsList as $val){
                $data = array(
                    'aml_s_id' => $this->curr_sid,
                    'aml_l_id' => $id,
                    'aml_type' => $val['type'],
                    'aml_name' => $val['type']==2 ? '谢谢惠顾' : $val['name'],
                    'aml_pid'  => $val['type']==2 ? 0 :$val['pid'],
                    'aml_img'  => $val['img'],
                    'aml_num'  => $val['num'],
                    'aml_weight' => $val['index']
                );
                $lottery_model->updateById($data, $val['id']);
            }
        }else{
            foreach($goodsList as $val){
                $data = array(
                    'aml_s_id' => $this->curr_sid,
                    'aml_l_id' => $id,
                    'aml_type' => $val['type'],
                    'aml_name' => $val['name'],
                    'aml_pid'  => $val['pid'],
                    'aml_img'  => $val['img'],
                    'aml_num'  => $val['num'],
                    'aml_weight' => $val['index']
                );
                $lottery_model->insertValue($data);
            }
        }
    }

    
    public function recordAction(){
        $id       = $this->request->getIntParam('id');
        $page     = $this->request->getIntParam('page');
        $type     = $this->request->getIntParam('type',0);
        $nickname = $this->request->getStrParam('nickname');
        $mobile   = $this->request->getStrParam('mobile');
        $code     = $this->request->getStrParam('code');
        $index    = $this->count * $page;
        $where[]  = array('name' => 'amr_s_id' , 'oper' => '=', 'value' => $this->curr_sid);
        $where[]  = array('name' => 'amr_l_id' , 'oper' => '=', 'value' => $id);
        if($type){
            $where[] = array('name' => 'amr_type' , 'oper' => '=', 'value' => $type);
        }
        if($nickname){
            $where[] = array('name' => 'm_nickname' , 'oper' => 'like', 'value' => "%{$nickname}%");
        }
        if($mobile){
            $where[] = array('name' => 'm_mobile' , 'oper' => '=', 'value' => $mobile);
        }
        if($code){
            $where[] = array('name' => 'amr_code' , 'oper' => '=', 'value' => $code);
        }
        $record_model   = new App_Model_Meeting_MysqlMeetingRecordStorage($this->curr_sid);
        $total          = $record_model->getListCount($where);
        $pageCfg        = new Libs_Pagination_Paginator($total['total'],$this->count,'jquery',true);
        $this->output['paginator'] = $pageCfg->render();
        $list           = array();
        if($index <= $total['total']){
            $list = $record_model->getListMember($where, $index, $this->count);
        }
        $this->output['type']     = $type;
        $this->output['mobile']   = $mobile;
        $this->output['nickname'] = $nickname;
        $this->output['id']       = $id;
        $this->output['list']     = $list;

        $this->buildBreadcrumbs(array(
            array('title' => '抽奖活动', 'link' => '/wxapp/meeting/lotteryList'),
            array('title' => '抽奖记录', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/meeting/record.tpl');
    }

    
    public function dealLotteryAction(){
        $id = $this->request->getIntParam('id');
        $note = $this->request->getStrParam('note');
        if($id){
            $record_model = new App_Model_Meeting_MysqlMeetingRecordStorage($this->curr_sid);
            $set = array(
                'amr_status' => 1,
                'amr_note' => $note,
                'amr_deal_time'=>time()
            );
            $ret = $record_model->updateById($set, $id);

            if($ret){
                App_Helper_OperateLog::saveOperateLog("中奖纪录处理成功");
            }

            $this->showAjaxResult($ret);
        }
    }

    
    public function prizeListAction(){
        $this->secondLink('prize');
        $page       = $this->request->getIntParam('page');
        $name       = $this->request->getStrParam('name');
        $index      = $page * $this->count;
        $where      = array();
        $where[]    = array('name'=>'ampl_s_id','oper'=>'=','value'=>$this->curr_sid);
        if($name){
            $where[]    = array('name'=>'ampl_name','oper'=>'like','value'=>"%{$name}%");
            $this->output['name']  = $name;
        }
        $list_model = new App_Model_Meeting_MysqlMeetingPrizeListStorage($this->curr_sid);
        $total      = $list_model->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['paginator'] = $pageCfg->render();
        $list       = array();
        if($index <= $total){
            $list   = $list_model->getList($where,$index,$this->count,array('ampl_update_time'=>'DESC'));
        }
        $this->output['list']    = $list;
        if($this->wxapp_cfg['ac_type'] != 30){
            $typeArr = array(1=>'普通商品',2=>'积分',3=>'抽奖次数');
        }else{
            $typeArr = array(1=>'普通商品',2=>'积分',5=>'金币');
        }
        $this->output['typeArr'] = $typeArr;
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '抽奖管理', 'link' => '/wxapp/meeting/prizeList'),
            array('title' => '奖品管理', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/meeting/prize-list.tpl');
    }
    
    public function addPrizeAction(){
        $id   =  $this->request->getIntParam('id');
        if($id){
            $list_model = new App_Model_Meeting_MysqlMeetingPrizeListStorage($this->curr_sid);
            $this->output['row'] = $list_model->getRowById($id);
        }
        $this->buildBreadcrumbs(array(
            array('title' => '奖品管理', 'link' => '/wxapp/meeting/prizeList'),
            array('title' => '奖品', 'link' => '#'),
        ));
        $this->output['typeArr'] = array(1=>'普通商品',2=>'积分',3=>'抽奖次数',4=>'答题次数');
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/meeting/add-prize.tpl');
    }
    
    public function savePrizeAction(){
        $result = array(
            'ec' => 400,
            'em' => '状态错误',
        );
        $id    = $this->request->getIntParam('id');
        $name  = $this->request->getStrParam('name');
        $cover = $this->request->getStrParam('cover');
        $type  = $this->request->getIntParam('type');
        $pnum   = $this->request->getIntParam('pnum');
        if($name && $cover && $type){
            $list_model = new App_Model_Meeting_MysqlMeetingPrizeListStorage($this->curr_sid);
            $data = array(
                'ampl_s_id'    => $this->curr_sid,
                'ampl_cover'   => $cover,
                'ampl_name'    => $name,
                'ampl_type'    => $type,
                'ampl_update_time'  => time(),
                'ampl_pnum'    => $pnum
            );
            if($id){
                $ret = $list_model->updateById($data,$id);
                $flg = '奖品编辑';
            }else{
                $nameExit   = $list_model->getListBySid($name);
                if(!$nameExit){
                    $data['ampl_create_time'] = time();
                    $ret = $list_model->insertValue($data);
                    $flg = '奖品添加';
                }else{
                    $flg = '同名奖品添加';
                }

            }
            if($ret){
                App_Helper_OperateLog::saveOperateLog("抽奖奖品【".$data['ampl_name']."】保存成功");
                $result = array(
                    'ec' => 200,
                    'em' => $flg.'成功！',
                );
            }else{
                $result = array(
                    'ec' => 400,
                    'em' => $flg.'失败！',
                );
            }

        }
        $this->displayJson($result);
    }
    
    public function delPrizeAction(){
        $id         = $this->request->getIntParam('id');
        $list_model = new App_Model_Meeting_MysqlMeetingPrizeListStorage($this->curr_sid);
        if($id){
            $set    = array(
                'ampl_deleted' => 1
            );
            $prize = $list_model->getRowById($id);
            $ret    = $list_model->updateById($set, $id);
            App_Helper_OperateLog::saveOperateLog("抽奖奖品【".$prize['ampl_name']."】删除成功");
            $this->showAjaxResult($ret);
        }
    }
    
    public function meetingListAction(){
        $page        = $this->request->getIntParam('page');
        $title       = $this->request->getStrParam('name');
        $index       = $page * $this->count;
        $where       = array();
        $where[]     = array('name'=>'am_s_id','oper'=>'=','value'=>$this->curr_sid);
        if($title){
            $where[]    = array('name'=>'am_title','oper'=>'like','value'=>"%{$title}%");
            $this->output['title']  = $title;
        }
        $meeting_storage  = new App_Model_Meeting_MysqlMeetingStorage($this->curr_sid);
        $total      = $meeting_storage->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['paginator'] = $pageCfg->render();
        $meeting_list       = array();
        $set=array('am_sort'=>'DESC','am_create_time'=>'DESC');
        if($index <= $total){
            $meeting_list   = $meeting_storage->getList($where,$index,$this->count,$set);
        }
        $data = array();
        if($meeting_list){
            foreach ($meeting_list as $val){
                $ticket_num =$this->_ticket_buy_total($val['am_id']);
                $sign_total=$this->_ticket_sign_total($val['am_id']);
                $data[] = array(
                    'id'        => $val['am_id'],
                    'title'     => $val['am_title'],
                    'cover'     => $val['am_cover'],
                    'startTime' => $val['am_start_time'],
                    'total'     => $ticket_num['total'],
                    'buy_total' => $ticket_num['buy_total'],
                    'sign_total'=> $sign_total,
                );
            }
        }
        $this->output['list']  = $data;
        $this->buildBreadcrumbs(array(
            array('title' => '会议管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/meeting/meeting-list.tpl');
    }
    
    private function _ticket_buy_total($amid){
        $ticket_storage   = new App_Model_Meeting_MysqlMeetingTicketStorage($this->curr_sid);
        $where = array();
        $where[] = array('name'=>'amt_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'amt_am_id','oper'=>'=','value'=>$amid);
        $where[] = array('name'=>'amt_deleted','oper'=>'=','value'=>0);
        $ticket  = $ticket_storage->getList($where);
        $buy_total=0;
        $total=0;
        foreach($ticket as $val){
            $buy_total+=$val['amt_buy_num'];
            $total+=$val['amt_total'];
        }
        $data=array(
            'buy_total'=>$buy_total,
            'total'=>$total
        );
        return $data;
    }
    
    private function _ticket_sign_total($amid){
        $meeting_storage  = new App_Model_Meeting_MysqlMeetingStorage($this->curr_sid);
        $where = array();
        $where[]        = array('name' => 'to_s_id', 'oper' => '=', 'value' =>$this->curr_sid);
        $where[]        = array('name' => 'to_g_id', 'oper' => '=', 'value' =>$amid);
        $where[]        = array('name' => 't_status', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_FINISH );
        $num            = $meeting_storage->getEnrolment($where);
        return $num;
    }
    
    public function addMeetingAction(){
        $id  = $this->request->getIntParam('id');
        $row = array(); $slide = array();
        if($id){
            $meeting_storage = new App_Model_Meeting_MysqlMeetingStorage($this->curr_sid);
            $row = $meeting_storage->getRowById($id);
            if(!empty($row)){
                $slide_model    = new App_Model_Meeting_MysqlMeetingSlideStorage($this->curr_sid);
                $slide          = $slide_model->getListByGidSid($row['am_id']);
            }
        }
        $this->output['messageList'] = $row['am_extra_message']?$row['am_extra_message']:json_encode(array());
        $this->output['slide']  = $slide;
        $this->output['row']    = $row;
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '会议管理', 'link' => '/wxapp/meeting/meetingList'),
            array('title' => '添加/编辑会议', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/meeting/add-meeting.tpl');
    }
    
    public function saveAction(){
        $result = array(
            'ec' => 400,
            'em' => '请填写完整会议信息'
        );
        $id       = $this->request->getIntParam('id');
        $data     = array();
        $data['am_title']       = $this->request->getStrParam('name');
        $data['am_cover']       = $this->request->getStrParam('cover');
        $delivery               = $this->request->getStrParam('start_time');
        $endTime                = $this->request->getStrParam('end_time');
        $data['am_start_time']  = strtotime($delivery);
        $data['am_end_time']    = strtotime($endTime);
        $data['am_price_range'] = $this->request->getStrParam('price');//价格范围
        $data['am_content']     = $this->request->getStrParam('content');//详情
        $data['am_province']    = $this->request->getStrParam('province');//省份
        $data['am_city']        = $this->request->getStrParam('city');//市
        $data['am_zone']        = $this->request->getStrParam('zone');//县/区
        $data['am_address']     = $this->request->getStrParam('address');//地址
        $data['am_extra_message']= $this->request->getStrParam('messageList');
        $data['am_lng']         = $this->request->getStrParam('lng');//经纬度
        $data['am_lat']         = $this->request->getStrParam('lat');
        $label                  = $this->request->getStrParam('label');
        $data['am_s_id']        = $this->curr_sid;
        $meeting_storage = new App_Model_Meeting_MysqlMeetingStorage($this->curr_sid);
        $is_add = 0;
        if(mb_strlen($label)>300){
            $this->displayJsonError('标签长度不能超过300个字符');
        }
        if($label){
            $data['am_label'] = $label;
        }
        if($id){
            $data['am_update_time']= $_SERVER['REQUEST_TIME'];
            $ret = $meeting_storage->UpdateById($data,$id);
        }else{
            $data['am_create_time']= $_SERVER['REQUEST_TIME'];
            $ret = $meeting_storage->insertValue($data);
            $id  = $ret;
            $is_add = 1;
        }
        if($ret){
            $this->batchSlide($id,$is_add);
            $result = array(
                'ec' => 200,
                'em' => '保存成功',
            );
            App_Helper_OperateLog::saveOperateLog("会议【{$data['am_title']}】保存成功");
        }else{
            $result['em'] = '保存失败';
        }
        $this->displayJson($result);
    }
    
    public function delMeetingAction(){
        $id         = $this->request->getIntParam('id');
        $meeting_storage = new App_Model_Meeting_MysqlMeetingStorage($this->curr_sid);
        if($id){
            $set    = array(
                'am_deleted' => 1
            );
            $row = $meeting_storage->getRowById($id);
            $ret    = $meeting_storage->updateById($set, $id);

            if($ret){
                App_Helper_OperateLog::saveOperateLog("会议【{$row['am_title']}】删除成功");
            }

            $this->showAjaxResult($ret);
        }
    }
    
    public function batchSlide($resId,$is_add=0){
        $slide_model    = new App_Model_Meeting_MysqlMeetingSlideStorage($this->curr_sid);
        $maxNum         = $this->request->getStrParam('slide-img-num');
        $slide          = array();
        if($is_add){
            for($i=0; $i<= $maxNum; $i++){
                $temp = $this->request->getStrParam('slide_'.$i);
                $temp = plum_sql_quote($temp);
                if($temp){
                    $slide[] = "(NULL, '{$this->curr_sid}', '{$resId}','{$temp}', 0, '".time()."')";
                }
            }
            $slide_model->batchSave($slide);
        }else{
            $sl_id = array();
            for($i=0; $i<= $maxNum; $i++){
                $temp = $this->request->getStrParam('slide_'.$i);
                $temp = plum_sql_quote($temp);
                $temp_id = $this->request->getIntParam('slide_id_'.$i);
                if($temp && $temp_id == 0){
                    $slide[] = $temp;
                }
                if($temp_id){
                    $sl_id[] = $temp_id;
                }
            }
            $del_id = array();
            $old_slide = $slide_model->getListByGidSid($resId);
            foreach($old_slide as $val){
                if(!in_array($val['ams_id'],$sl_id)){
                    $del_id[] = $val['ams_id'];
                }
            }
            if(count($slide) <= count($del_id)){
                for($d=0 ; $d < count($del_id) ; $d++){
                    if(isset($slide[$d]) && $slide[$d]){
                        $slide_model->updateSlide($del_id[$d],$slide[$d]);
                        unset($del_id[$d]);
                    }
                }
                if(!empty($del_id)){
                    $slide_model->deleteSlide($resId,$del_id);
                }
            }else{
                $batch_slide = array();
                for($s=0 ; $s < count($slide) ; $s++){
                    if(isset($del_id[$s]) && $del_id[$s]){
                        $slide_model->updateSlide($del_id[$s],$slide[$s]);
                        unset($slide[$s]);
                    }else{
                        $sTemp = plum_sql_quote($slide[$s]);
                        $batch_slide[] = "(NULL, '{$this->curr_sid}', '{$resId}','{$sTemp}', 0, '".time()."')";
                    }
                }
                if(!empty($batch_slide)){
                    $slide_model->batchSave($batch_slide);
                }
            }
        }
    }
    
    public function participantsAction(){
        $page     = $this->request->getIntParam('page');
        $id       = $this->request->getIntParam('id');
        $name     = $this->request->getStrParam('name');
        $mobile   = $this->request->getStrParam('mobile');
        $company  = $this->request->getStrParam('company');
        $status   = $this->request->getIntParam('status');
        $index       = $page * $this->count;
        $meeting_storage  = new App_Model_Meeting_MysqlMeetingStorage($this->curr_sid);
        $member_storage   = new App_Model_Member_MysqlMemberCoreStorage();
        $ticket_storage   = new App_Model_Meeting_MysqlMeetingTicketStorage($this->curr_sid);
        $where = array();
        if($name){
            $where[]        = array('name' => 'm_nickname', 'oper' => 'like', 'value' =>"%{$name}%");
            $this->output['name'] = $name;
        }
        if($mobile){
            $where[]        = array('name' => 'm_mobile', 'oper' => 'like', 'value' =>"%{$mobile}%");
            $this->output['mobile'] = $mobile;
        }
        if($company){
            $where[]        = array('name' => 'm_company', 'oper' => 'like', 'value' =>"%{$company}%");
            $this->output['company'] = $company;
        }
        if(!$status){
            $where[]        = array('name' => 't_status', 'oper' => '>=', 'value' => App_Helper_Trade::TRADE_HAD_PAY );
            $where[]        = array('name' => 't_status', 'oper' => '<=', 'value' => App_Helper_Trade::TRADE_FINISH );
        }elseif($status==2){
            $where[]        = array('name' => 't_status', 'oper' => '=', 'value' =>App_Helper_Trade::TRADE_HAD_PAY);
            $this->output['status'] = $status;
        }elseif($status==1){
            $where[]        = array('name' => 't_status', 'oper' => '=', 'value' =>App_Helper_Trade::TRADE_FINISH);
            $this->output['status'] = $status;
        }
        $where[]        = array('name' => 't_deleted', 'oper' => '=', 'value' => 0 );
        $where[]        = array('name' => 'to_s_id', 'oper' => '=', 'value' =>$this->curr_sid);
        $where[]        = array('name' => 'to_g_id', 'oper' => '=', 'value' =>$id);
        $total          = $meeting_storage->enrolmentUserNum($where);
        $trade          = $meeting_storage->enrolmentUser($where,$index,$this->count);
        $data=array();
        foreach($trade as $k=>$v){
            $member  = $member_storage->getRowById($v['to_m_id']);
            $ticket  =  $ticket_storage->getRowById($v['to_gf_id']);
            if($v['t_status']==App_Helper_Trade::TRADE_HAD_PAY){
                    $status='未签到';
            }elseif($v['t_status']==App_Helper_Trade::TRADE_FINISH){
                $status='已签到';
            }
            $data[]=array(
                'name'    => $member['m_nickname'],
                'mobile'  => $member['m_mobile'],
                'ticket'  => $ticket['amt_name'],
                'company' => $member['m_company'],
                'status'  => $status,
                'tid'     => $v['t_id'],
                'remarkExtra' => json_decode($v['t_remark_extra'],true),
            );
        }
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['paginator'] = $pageCfg->render();
        $this->output['list'] = $data;
        $this->output['id']   = $id;
        $this->buildBreadcrumbs(array(
            array('title' => '会议管理', 'link' => '/wxapp/meeting/meetingList'),
            array('title' => '参会人员', 'link' => '#'),
        ));
        $test = $this->request->getIntParam('test');
        if($test==99){
            plum_msg_dump($data);
        }
        $this->displaySmarty('wxapp/meeting/ticketsale-list.tpl');
    }
    
    public function confirmAction(){
        $tid             = $this->request->getIntParam('tid');
        $trade_model     = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $data=array(
            't_status'=>App_Helper_Trade::TRADE_FINISH,
            );
        $ret=$trade_model->updateById($data,$tid);
        if($ret){
            $trade = $trade_model->getRowById($tid);
            $result = array(
                'ec'   => 200,
                'em'   => '签到成功',
            );
            $nickname = $trade['t_buyer_nick'];
            App_Helper_OperateLog::saveOperateLog("参会人员【{$nickname}】签到成功");
        }else{
            $result['em'] = '签到失败';
        }
        $this->displayJson($result);

    }
    
    public function userDeletedAction(){
        $tid             = $this->request->getIntParam('tid');
        $trade_model     = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $trade = $trade_model->getRowById($tid);
        $data=array(
            't_deleted'=>2,
        );
        $ret=$trade_model->updateById($data,$tid);
        if($ret){
            $nickname = $trade['t_buyer_nick'];
            App_Helper_OperateLog::saveOperateLog("参会人员【{$nickname}】删除成功");
            $result = array(
                'ec'   => 200,
                'em'   => '删除成功',
            );
        }else{
            $result['em'] = '删除失败';
        }
        $this->displayJson($result);

    }
    
    public function newProgressAction(){
        $amid             = $this->request->getIntParam('id');
        $meeting_storage  = new App_Model_Meeting_MysqlMeetingStorage($this->curr_sid);
        $meeting          = $meeting_storage->getRowById($amid);
        $progress_storage = new App_Model_Meeting_MysqlMeetingProgressStorage($this->curr_sid);
        $where            = array();
        $where[]          = array('name' => 'amp_am_id', 'oper' => '=', 'value' => $amid);
        $progress_list    = $progress_storage->newFetchProgressShowList($where);
        $data = array();
        if($progress_list){
            foreach ($progress_list as $val){
                $data[] = array(
                    'amid'       => $val['amp_am_id'],
                    'cid'        => $val['amp_c_id'],
                    'index'      => $val['amp_weight'],
                    'title'      => $val['amp_title'],
                    'brief'      => $val['amp_brief'],
                    'startTime'  => $val['amp_start_time'],
                    'endTime'    => $val['amp_end_time'],
                    'content'    => $val['amp_detail']
                );
            }
        }
        $this->_new_show_category_list($amid);
        $this->output['progressList'] = json_encode($data);
        $this->output['amid']         = $amid;
        $this->output['banners']      = $meeting['am_progress_cover'];
        $this->output['draw']         = $meeting['am_draw_cover'];
        $this->output['content']      = $meeting['am_prg_content'] ? json_encode(array('prgcontent'=>$meeting['am_prg_content'])) : json_encode(array('prgcontent'=>'此处添加会议嘉宾'));
        $this->output['ison']         = $meeting['am_draw_ison'];
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '会议管理', 'link' => '/wxapp/meeting/meetingList'),
            array('title' => '议程管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/meeting/newprogress.tpl');
    }
    public function newSaveProgressAction(){
        $progressList = $this->request->getArrParam('progressList');
        $amid         = $this->request->getIntParam('amid');
        $banners      = $this->request->getstrParam('banners');
        $draw         = $this->request->getstrParam('draw');
        $content      = $this->request->getstrParam('content');
        $ison         = $this->request->getstrParam('ison');
        $meeting_storage  = new App_Model_Meeting_MysqlMeetingStorage($this->curr_sid);
        $set              = array(
            'am_progress_cover'=>$banners,
            'am_draw_cover'    =>$draw,
            'am_prg_content'   =>$content,
            'am_draw_ison'     =>$ison=='false'?0:1,
            'am_update_time'   =>time(),
        );
        $cover_ret        = $meeting_storage->updateById($set,$amid);
        $progress_storage = new App_Model_Meeting_MysqlMeetingProgressStorage($this->curr_sid);
        if(!empty($progressList)){
            $where            = array();
            $where[]          = array('name' => 'amp_am_id', 'oper' => '=', 'value' =>$amid);
            $progress_list = $progress_storage->newFetchProgressShowList($where);
            if(!empty($progress_list)){
                $del_id = array();
                $up_num = 0;
                foreach($progress_list as $val){
                    if(isset($progressList[$val['amp_weight']])){
                        $set = array(
                            'amp_c_id'     => $progressList[$val['amp_weight']]['cid'],
                            'amp_weight'   => $progressList[$val['amp_weight']]['index'],
                            'amp_title'    => $progressList[$val['amp_weight']]['title'],
                            'amp_brief'   => $progressList[$val['amp_weight']]['brief'],
                            'amp_detail'  => $progressList[$val['amp_weight']]['content'],
                            'amp_start_time' => $progressList[$val['amp_weight']]['startTime'],
                            'amp_end_time'  => $progressList[$val['amp_weight']]['endTime'],
                        );
                        $up_ret = $progress_storage->updateById($set,$val['amp_id']);
                        $up_num += $up_ret;
                        unset($progressList[$val['amp_weight']]);
                    }else{
                        $del_id[] = $val['amp_id'];
                    }
                }
                if(!empty($del_id)){
                    $progress_where = array();
                    $progress_where[] = array('name' => 'amp_id','oper' => 'in' , 'value' => $del_id);
                    $del_ret = $progress_storage->deleteValue($progress_where);
                }

            }
            if(!empty($progressList)){
                $insert = array();
                foreach($progressList as $val){
                    $content = plum_sql_quote($val['content']);
                    $insert[] =  " (NULL, '{$this->curr_sid}','{$amid}','{$val['cid']}','{$val['title']}','{$val['brief']}','{$val['startTime']}','{$val['endTime']}','{$val['index']}','{$val['content']}','".time()."','0') ";
                }
                $ins_ret = $progress_storage->newInsertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'amp_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $del     = $progress_storage->deleteValue($where);
        }
        if($up_num || $ins_ret || $del_ret || $del||$cover_ret){
            $ret = 1;
        }else{
            $ret = 0;
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("议程保存成功");
        }

        $this->showAjaxResult($ret);
    }
    
    public function newSaveCategoryAction(){
        $categoryList = $this->request->getArrParam('categoryList');
        $amid         = $this->request->getstrParam('amid');
        $category_storage = new App_Model_Meeting_MysqlMeetingCategoryStorage($this->curr_sid);
        $num = 0;
        if(!empty($categoryList)){
            $category_list = $category_storage->newGetListBySid($amid);
            if(!empty($category_list)){
                $del_id = array();
                foreach($category_list as $val){
                    $has = false;
                    $index = 0;
                    foreach($categoryList as $key => $v){
                        if($v['id'] == $val['amc_id']){
                            $index = $key;
                            $has = true;
                        }
                    }
                    if($has){
                        $set = array(
                            'amc_sort'  => $index,
                            'amc_name'  => $categoryList[$index]['name']
                        );
                        $up_ret = $category_storage->updateById($set,$val['amc_id']);
                        unset($categoryList[$index]);
                        $num += 1;
                    }else{
                        $del_id[] = $val['amc_id'];
                    }
                }
                if(!empty($del_id)){
                    $shortcut_where = array();
                    $shortcut_where[] = array('name' => 'amc_id','oper' => 'in' , 'value' => $del_id);
                    $del_ret = $category_storage->deleteValue($shortcut_where);
                }

            }
            if(!empty($categoryList)){
                $insert = array();
                foreach($categoryList as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}','{$amid}','{$val['name']}','{$val['index']}', '0', '".time()."') ";
                }
                $ins_ret = $category_storage->newInsertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'amc_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $del_ret = $category_storage->deleteValue($where);
        }
        if($up_ret || $del_ret || $ins_ret || $num>0){
            $ret = 1;
        }else{
            $ret = 0;
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("议程保存成功");
        }

        $this->showAjaxResult($ret);
    }
    
    public function ticketAction(){
        $amid             = $this->request->getIntParam('id');
        $ticket_storage = new App_Model_Meeting_MysqlMeetingTicketStorage($this->curr_sid);
        $where=array();
        $where[]        = array('name'=>'amt_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]        = array('name'=>'amt_am_id','oper'=>'=','value'=>$amid);
        $set=array('amt_create_time'=>'DESC');
        $ticket_list   = $ticket_storage->getList($where,0,0,$set);
        $data = array();
        if($ticket_list){
            foreach ($ticket_list as $val){
                $data[] = array(
                    'id'         => $val['amt_id'],
                    'name'       => $val['amt_name'],
                    'total'      => $val['amt_total'],
                    'buy_num'    => $val['amt_buy_num'],
                    'price'      => $val['amt_price'],
                    'createTime' => $val['amt_create_time'],
                );
            }
        }
        $this->output['list']    = $data;
        $this->output['amid']    = $amid;
        $this->buildBreadcrumbs(array(
            array('title' => '会议管理', 'link' => '/wxapp/meeting/meetingList'),
            array('title' => '门票管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/meeting/ticket-list.tpl');
    }
    
    public function addTicketAction(){
        $id               = $this->request->getIntParam('id');
        $amid             = $this->request->getIntParam('amid');
        $ticket_storage = new App_Model_Meeting_MysqlMeetingTicketStorage($this->curr_sid);
        $ticket         = $ticket_storage->getRowById($id);
        $this->output['ticket']    = $ticket;
        $this->output['amid']      = $amid;
        $this->buildBreadcrumbs(array(
            array('title' => '门票管理', 'link' => "/wxapp/meeting/ticket?id=$amid"),
            array('title' => '门票添加/编辑', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/meeting/add-ticket.tpl');
    }
    
    public function saveTicketAction(){
        $result = array(
            'ec' => 400,
            'em' => '请填写完整票类信息'
        );
        $id       = $this->request->getIntParam('id');
        $amid     = $this->request->getIntParam('amid');
        $data     = array();
        $data['amt_name']          = $this->request->getStrParam('name');
        $data['amt_price']         = $this->request->getStrParam('price');
        $data['amt_total']         = $this->request->getIntParam('total');
        $data['amt_content']       = $this->request->getStrParam('content');
        $data['amt_s_id']          = $this->curr_sid;
        $data['amt_am_id']         = $amid;
        $ticket_storage = new App_Model_Meeting_MysqlMeetingTicketStorage($this->curr_sid);
        if($id){
            $ret = $ticket_storage->UpdateById($data,$id);
        }else{
            $data['amt_create_time']= $_SERVER['REQUEST_TIME'];
            $ret = $ticket_storage->insertValue($data);
        }
        if($ret){
            $result = array(
                'ec'   => 200,
                'em'   => '保存成功',
                'amid' => $amid,
            );
            App_Helper_OperateLog::saveOperateLog("门票类别【{$data['amt_name']}】保存成功");
        }else{
            $result['em'] = '保存失败';
        }
        $this->displayJson($result);
    }
    
    public function delTicketAction(){
        $id         = $this->request->getIntParam('id');
        $ticket_storage = new App_Model_Meeting_MysqlMeetingTicketStorage($this->curr_sid);
        if($id){
            $set    = array(
                'amt_deleted' => 1
            );
            $row = $ticket_storage->getRowById($id);
            $ret    = $ticket_storage->updateById($set, $id);

            if($ret){
                App_Helper_OperateLog::saveOperateLog("门票类别【{$row['amt_name']}】删除成功");
            }

            $this->showAjaxResult($ret);
        }
    }
    
    private function showIndexSlide(){
        $slide_model = new App_Model_Shop_MysqlShopSlideStorage($this->curr_sid);
        $slide = $slide_model->fetchSlideShowList();
        $json = array();
        foreach($slide as $key => $val){
            $json[] = array(
                'index'     => $key ,
                'imgsrc'    => $val['ss_path'],
                'link'      => $val['ss_link'],
                'articleId' => $val['ss_link'],
                'articleTitle' => $val['ss_article_title'],
                'type'         => $val['ss_link_type']

            );
        }
        $this->output['slide'] = json_encode($json);
    }
    
    private function _get_meeting(){
        $meeting_storage = new App_Model_Meeting_MysqlMeetingStorage($this->curr_sid);
        $region_model = new App_Model_Member_MysqlRegionStorage();
        $where           = array();
        $where[]         = array('name'=>'am_s_id','oper'=>'=','value'=>$this->curr_sid);
        $set=array('am_sort'=>'DESC','am_create_time'=>'DESC');
        $meeting_list    = $meeting_storage->getList($where,0,0,$set);
        $json=array();
        foreach($meeting_list as $key => $val){
            if ($val['am_city']) {
                $city_name = $region_model->get_address_name($val['am_city']);
            }
            $json[] = array(
                'id'        => $val['am_id'],
                'title'     => $val['am_title'],
                'cover'     => $val['am_cover'],
                'price'     => $val['am_price_range'],
                'brows'     => $val['am_brows_num'],
                'city'      => isset($city_name['region_name']) ? $city_name['region_name'] : '',
                'startTime' => date('Y/m/d',$val['am_start_time']),

            );
        }
        $this->output['meeting'] = json_encode($json);
    }
    
    private function _show_index(){
        $tpl_model  = new App_Model_Meeting_MysqlMeetingIndexStorage($this->curr_sid);
        $where      = array();
        $where[]    = array('name' => 'ami_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $tpl        = $tpl_model->getRow($where);
        if(empty($tpl)){
            $tpl = array(
                'ami_title'         => '微会务',
                'ami_list_title'    => '会议列表',
                'ami_open_coupon'   =>0,
                'ami_coupon_cover'  => ''
            );
        }
        $this->output['tpl'] = $tpl;
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

}
