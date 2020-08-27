<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 16/9/14
 * Time: 上午11:23
 */
class App_Controller_Wxapp_AuctionController extends App_Controller_Wxapp_OrderCommonController{
    const PROMOTION_TOOL_KEY = 'pm';

    public function __construct(){
        parent::__construct();

        // $this->checkToolUsable(self::PROMOTION_TOOL_KEY);
    }
    /**
     * @param string $type
     * 自定义二级链接，根据类型，确定默认选中
     */
    public function secondLink($type='index'){
        $link = array(
            array(
                'label' => '首页配置',
                'link'  => '/wxapp/auction/indexCfg',
                'active'=> 'index'
            ),
            array(
                'label' => '拍卖活动',
                'link'  => '/wxapp/auction/auctionList',
                'active'=> 'list'
            ),
            array(
                'label' => '拍卖订单',
                'link'  => '/wxapp/auction/orderList',
                'active'=> 'order'
            ),
        );
        $this->output['link']       = $link;
        $this->output['linkType']   = $type;
        $this->output['snTitle']    = '拍卖';
    }


    /**
     * 拍卖首页设置
     */
    public function indexCfgAction(){
        $this->secondLink('index');
        //同城和多店有拼团活动开启申请按钮
        $cfg        = $this->wxapp_cfg;
        $this->output['shopType']    = $cfg['ac_type'];
        //首页基本配置
        $this->showIndexTpl();
        $this->showShopTplSlide(0, 10);

        $page = $this->_fetch_shop_outside();
        $page_data = $this->_fetch_page_data();
        $this->output['page_list'] = json_encode(array_merge($page,$page_data));
        // 链接列表及分类
        $this->_get_list_for_select();
        //获取文章列表
        $this->_shop_information();
        //获取文章资讯分类
        $this->_get_information_category();
        //获得跳转小程序
        $this->_get_jump_list();

        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '拍卖管理', 'link' => '/wxapp/auction/indexCfg'),
            array('title' => '拼团设置', 'link' => '#'),
        ));
        $this->output['sid'] = $this->curr_sid;

        $this->displaySmarty("wxapp/auction/auction-cfg.tpl");
    }

    /**
     * 获取拼团页面配置
     * @param  [type] $tpl_id [description]
     * @return [type]         [description]
     */
    private function showIndexTpl(){
        $tpl_model = new App_Model_Auction_MysqlAuctionIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid();
        if(empty($tpl)){
            $tpl = array(
                'aai_title'         => '拍卖'
            );
        }
        $this->output['tpl'] = $tpl;
    }


    /*
     * 保存拼团首页设置
     */
    public function saveCfgAction(){
        $title      = $this->request->getStrParam('title');
        $listTitle  = $this->request->getStrParam('listTitle');
        $orderTitle = $this->request->getStrParam('orderTitle');
        $phone      = $this->request->getStrParam('phone');
        $confirmTime      = $this->request->getStrParam('confirmTime');
        $serviceStartTime = $this->request->getStrParam('serviceStartTime');
        $serviceEndTime   = $this->request->getStrParam('serviceEndTime');

        $data = array(
            'aai_s_id'         => $this->curr_sid,
            'aai_title'        => $title,
            'aai_list_title'   => $listTitle,
            'aai_order_title'  => $orderTitle,
            'aai_confirm_time' => $confirmTime,
            'aai_phone'        => $phone,
            'aai_service_start_time' => $serviceStartTime,
            'aai_service_end_time'   => $serviceEndTime,
            'aai_update_time'        => time(),
        );

        // 校验店铺是否可用改模板
        $tpl_model = new App_Model_Auction_MysqlAuctionIndexStorage($this->curr_sid);
        $tpl_row   = $tpl_model->findUpdateBySid();
        if(!empty($tpl_row)){
            $ret = $tpl_model->findUpdateBySid($data);
        }else{
            $tpl['aai_create_time']= time();
            $ret = $tpl_model->insertValue($data);
        }
        if($ret){
            $this->save_shop_slide_new(0, 10);//保存幻灯

            $result = array(
                'ec' => 200,
                'em' => '信息保存成功'
            );
            App_Helper_OperateLog::saveOperateLog("拍卖首页设置保存成功");
        }else{
            $result = array(
                'ec' => 400,
                'em' => '模版不可用'
            );
        }
        $this->displayJson($result);
    }

    /**
     * 拍卖活动列表
     */
    public function auctionListAction(){
        $this->secondLink('list');
        $page = $this->request->getIntParam('page');
        $name = $this->request->getStrParam('name');
        $index = $page * $this->count;
        $auction_model = new App_Model_Auction_MysqlAuctionListStorage($this->curr_sid);
        $where = array();
        $where[] = array('name' => 'aal_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'aal_deleted', 'oper' => '=', 'value' => 0);
        if($name){
            $where[] = array('name' => 'aal_title', 'oper' => 'like', 'value' => "%{$name}%");
        }
        //分页处理
        $total          = $auction_model->getCount($where);
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['paginator'] = $pageCfg->render();
        //列表数据
        $list   = array();
        if($index <= $total){
            $sort = array('aal_create_time' => 'DESC');
            $list = $auction_model->getList($where,$index,$this->count,$sort);
        }
        $this->output['list'] = $list;
        $this->output['name'] = $name;
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '拍卖管理', 'link' => '/wxapp/auction/indexCfg'),
            array('title' => '拍卖列表', 'link' => '#'),
        ));

        //获取统计信息
        $where = array();
        $where[] = array('name' => 'aal_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'aal_deleted', 'oper' => '=', 'value' => 0);
        $total = $auction_model->getCount($where);  //全部活动

        $where[] = array('name' => 'aal_is_end', 'oper' => '=', 'value' => 0);
        $total_jxz = $auction_model->getCount($where);  //进行中

        $where[1] = array('name' => 'aal_is_end', 'oper' => '=', 'value' => 1);
        $total_yjs = $auction_model->getCount($where);  //已结束

        $aaj_model = new App_Model_Auction_MysqlAuctionJoinStorage($this->curr_sid);
        $where = [];
        $total_ljcyrs = $aaj_model->getJoinPersonCount();  //累计参与人数
        $total_ljcycs = $aaj_model->getCount($where);  //累计参与次数

        $this->output['statInfo'] = [
            'total'     => $total,      //全部活动
            'total_jxz' => $total_jxz,  //进行中
            'total_yjs' => $total_yjs,  //已结束
            'total_ljcyrs' => $total_ljcyrs,  //累计参与人数
            'total_ljcycs'=> $total_ljcycs, //累计参与次数
        ];
        $this->displaySmarty('wxapp/auction/auction-list.tpl');
    }

    /**
     * 编辑拍卖
     */
    public function editAuctionAction(){
        $id = $this->request->getIntParam('id');
        if($id){
            $auction_model = new App_Model_Auction_MysqlAuctionListStorage($this->curr_sid);
            $auction = $auction_model->getRowById($id);
            if($auction){
                $slide_model    = new App_Model_Auction_MysqlAuctionSlideStorage($this->curr_sid);
                $slide          = $slide_model->getSlideByGid($auction['aal_id']);
                $this->output['slide'] = $slide;
            }
            $this->output['row'] = $auction;
        }
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/auction/edit-auction.tpl');
    }

    /**
     * 保存拍卖
     */
    public function saveAuctionAction(){
        $id         = $this->request->getIntParam('id');
        $title      = $this->request->getStrParam('aal_title');
        $cover      = $this->request->getStrParam('aal_cover');
        $brief      = $this->request->getStrParam('aal_brief');
        $deposit    = $this->request->getFloatParam('aal_deposit_price');
        $startPrice = $this->request->getFloatParam('aal_start_price');
        $addLimit   = $this->request->getFloatParam('aal_add_limit');
        $showNum    = $this->request->getIntParam('aal_show_num');
        $showNumShow= $this->request->getStrParam('aal_show_num_show'); //访问量是否显示
        $startTime  = $this->request->getStrParam('startTime');
        $endTime    = $this->request->getStrParam('endTime');
        $detail     = $this->request->getStrParam('aal_detail');
        $isShow     = $this->request->getStrParam('aal_is_show');
        $fictitiousNum     = $this->request->getStrParam('aal_fictitious_join_num');
        /*if($startTime && $endTime && (strtotime($endTime) < time() || strtotime($startTime) > strtotime($endTime))){
            $this->displayJsonError('时间选择不正确');
        }*/
        if($startTime){
            $data['aal_start_time'] = strtotime($startTime);
        }
        if($endTime){
            $data['aal_end_time'] = strtotime($endTime);
        }
        $data['aal_title']       = $title;
        $data['aal_cover']       = $cover;
        $data['aal_deposit_price'] = $deposit;
        $data['aal_start_price'] = $startPrice;
        $data['aal_add_limit']   = $addLimit;
        $data['aal_brief']       = $brief;
        $data['aal_show_num']    = $showNum;
        $data['aal_fictitious_join_num']    = $fictitiousNum;
        $data['aal_detail']      = $detail;
        $data['aal_s_id']        = $this->curr_sid;
        $data['aal_show_num_show']= ($showNumShow == 'on' || $showNumShow == 1)? 1 : 0;
        $data['aal_is_show']     = ($isShow == 'on' || $isShow == 1)? 1 : 0;

        $auction_model = new App_Model_Auction_MysqlAuctionListStorage($this->curr_sid);
        $is_add = 0;
        if($id){
            $data['aal_update_time'] = time();
            $ret = $auction_model->updateById($data, $id);
        }else{
            $is_add = 1;
            $data['aal_curr_price'] = $startPrice;
            $data['aal_create_time'] = time();
            $ret = $auction_model->insertValue($data);
            $id  = $ret;
        }
        //拍卖结束倒计时
        if($data['aal_end_time']){
            $applet_redis = new App_Model_Applet_RedisAppletStorage($this->curr_sid);
            $leftTime = $data['aal_end_time'] - time();
            $applet_redis->setAuctionEndTtl($id, $leftTime>0?$leftTime:0);
        }
        if($ret){
            $this->batchSlide($id,$is_add);
            App_Helper_OperateLog::saveOperateLog("保存拍卖活动【".$title."】成功");
        }
        $this->showAjaxResult($ret);
    }

    /**
     * @param $goId
     * @param int $is_add 1标注新增
     * 根据商品ID处理商品幻灯
     */
    public function batchSlide($goId,$is_add=0){
        $slide_model    = new App_Model_Auction_MysqlAuctionSlideStorage($this->curr_sid);
        $maxNum         = $this->request->getStrParam('slide-img-num');
        $slide          = array();
        if($is_add){ //新增，则批量插入
            for($i=0; $i<= $maxNum; $i++){
                $temp = $this->request->getStrParam('slide_'.$i);
                $temp = plum_sql_quote($temp);
                if($temp){
                    $slide[] = "(NULL, '{$this->curr_sid}', '{$goId}', '{$temp}', 0, '".time()."')";
                }
            }
            $slide_model->batchSave($slide);
        }else{ //循环更新
            $sl_id = array();
            for($i=0; $i<= $maxNum; $i++){
                $temp = $this->request->getStrParam('slide_'.$i);
                $temp = plum_sql_quote($temp);
                $temp_id = $this->request->getIntParam('slide_id_'.$i);
                if($temp && $temp_id == 0){ //新增
                    $slide[] = $temp;
                }
                if($temp_id){ //不变的
                    $sl_id[] = $temp_id;
                }
            }

            //@todo 统计需删除的幻灯
            $del_id = array();
            $old_slide = $slide_model->getListByGidSid($goId,$this->curr_sid);
            foreach($old_slide as $val){
                if(!in_array($val['aas_id'],$sl_id)){
                    $del_id[] = $val['aas_id'];
                }
            }

            //@todo 新增和删除的幻灯，进行处理
            if(count($slide) <= count($del_id)){ //删除的大于等于新增的
                for($d=0 ; $d < count($del_id) ; $d++){
                    if(isset($slide[$d]) && $slide[$d]){
                        $slide_model->updateSlide($del_id[$d],$slide[$d]);
                        unset($del_id[$d]); //移除被占用的幻灯
                    }
                }
                //@todo 真实删除多余的幻灯
                if(!empty($del_id)){
                    $slide_model->deleteSlide($goId,$del_id);
                }
            }else{ //新增的多
                $batch_slide = array();
                for($s=0 ; $s < count($slide) ; $s++){
                    if(isset($del_id[$s]) && $del_id[$s]){
                        $slide_model->updateSlide($del_id[$s],$slide[$s]);
                        unset($slide[$s]); //移除已经更改的幻灯
                    }else{
                        $sTemp = plum_sql_quote($slide[$s]);
                        $batch_slide[] = "(NULL, '{$this->curr_sid}', '{$goId}', '{$sTemp}', 0, '".time()."')";
                    }
                }
                //@todo  批量新增幻灯
                if(!empty($batch_slide)){
                    $slide_model->batchSave($batch_slide);
                }
            }
        }
    }


    /**
     * 修改拍卖状态
     */
    public function changeAuctionAction(){
        $id = $this->request->getIntParam('id');
        $show = $this->request->getIntParam('show');

        if($id){
            $auction_model = new App_Model_Auction_MysqlAuctionListStorage($this->curr_sid);
            $set = array('aal_is_show' => $show);
            $ret = $auction_model->updateById($set, $id);

            if($ret){
                $auction = $auction_model->getRowById($id);
                $str = $show == 1 ? '展示' : '不展示';
                App_Helper_OperateLog::saveOperateLog("修改拍卖活动【".$auction['aal_title']."】".$str);
            }
        }


        $this->showAjaxResult($ret);
    }

    /**
     * 订单列表
     */
    public function orderListAction(){
        $where   = array();
        $this->show_trade_list_data($where, 1, 0, App_Helper_Trade::TRADE_AUCTION);
        $auction_model = new App_Model_Auction_MysqlAuctionListStorage($this->curr_sid);
        foreach ($this->output['list'] as $key => $value){
            $data = json_decode($value['t_extra_data'], true);
            $actId = $data['gid'];
            $auction = $auction_model->getRowById($actId);
            $this->output['list'][$key]['aal_start_price'] = $auction['aal_start_price'];
            $this->output['list'][$key]['aal_curr_price'] = $auction['aal_curr_price'];
        }
        $this->secondLink('order');
        $this->output['orderLink']  = $this->showTableLink('order');
        $this->output['statusNote'] = array( 2	=> '竞拍中', 3 => '已付款',4 => '已发货', 5 => '确认收货', 6 => '已完成', 8 => '未获拍', 11 => '未支付');

        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '拍卖管理', 'link' => '/wxapp/auction/indexCfg'),
            array('title' => '预约订单', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/auction/trade-list.tpl');
    }

    public function showTableLink($type,$param=array()){
        $extra = '';
        if(!empty($param) && is_array($param)){
            foreach($param as $key=>$val){
                $extra .= '&'.$key.'='.$val;
            }
        }
        $link = array();
        switch($type){
            case 'order' :
                $link = array(
                    array(
                        'href'  => '/wxapp/auction/orderList?status=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/wxapp/auction/orderList?status=tuan'.$extra,
                        'key'   => 'tuan',
                        'label' => '竞拍中'
                    ),
                    array(
                        'href'  => '/wxapp/auction/orderList?status=hadpay'.$extra,
                        'key'   => 'hadpay',
                        'label' => '待发货'
                    ),
                    array(
                        'href'  => '/wxapp/auction/orderList?status=ship'.$extra,
                        'key'   => 'ship',
                        'label' => '已发货'
                    ),
                    array(
                        'href'  => '/wxapp/auction/orderList?status=finish'.$extra,
                        'key'   => 'finish',
                        'label' => '已完成'
                    ),
                    array(
                        'href'  => '/wxapp/auction/orderList?status=refund'.$extra,
                        'key'   => 'refund',
                        'label' => '未获拍'
                    ),
                    array(
                        'href'  => '/wxapp/auction/orderList?status=winNOPay'.$extra,
                        'key'   => 'winNOPay',
                        'label' => '未支付'
                    ),
                );
                break;
        }
        return $link;
    }

    /*
     * 订单详情
     */
    public function tradeDetailAction() {
        $this->secondLink('tradeList');
        $this->output['tradePay'] = App_Helper_Trade::$trade_pay_type;
        $this->output['tradeType']= App_Helper_Trade::$trade_type;
        $this->show_trade_detail_data();
        $this->output['statusNote'] = array( 2	=> '竞拍中', 3 => '已付款',4 => '已发货', 5 => '确认收货', 6 => '已完成', 8 => '未获拍');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '拍卖管理', 'link' => '/wxapp/auction/indexCfg'),
            array('title' => '订单列表', 'link' => '/wxapp/auction/orderList'),
            array('title' => '订单详情', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/auction/trade-detail.tpl');
    }

    /**
     * 订单详情数据
     */
    private function show_trade_detail_data(){
        $tid         = $this->request->getStrParam('order_no');
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $where       = array();
        $where[]     = array('name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]     = array('name'=>'t_tid','oper'=>'=','value'=>$tid);
        $list        = $trade_model->getAddressList($where, 0, 1, array());
        if(!empty($list) && isset($list[0])){
            $row = $list[0];
            $row['t_remark_extra'] = json_decode($row['t_remark_extra'], true);
            $output['row']  = $row;
            //一单多个项目情况
            $trade_order        = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
            $output['list']     = $trade_order->getGoodsListByTid($row['t_id']);
            $this->_trade_detail_status_desc($row);
            $output['statusNote'] = plum_parse_config('trade_status');
            $this->showOutput($output);
        }else{
            plum_url_location('订单号错误');
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
                    //$account = '<div>买家已将货款支付至您的 平台账户，请到<a href="/manage/shop/basic" target="_blank">店铺概况</a>查收。</div>';
                }
                $desc = array(
                    'icon'      => '!',
                    'class'     => 'primary',
                    'desc'      => $account
                );
                break;
            case App_Helper_Trade::TRADE_SHIP:
                $desc = array(
                    'icon'      => '!',
                    'class'     => 'primary',
                    'desc'      => '<div>已发货、等待用户确认收货。</div>'
                );
                break;
            case App_Helper_Trade::TRADE_FINISH:
                $desc = array(
                    'icon'      => '√',
                    'class'     => 'success',
                    'desc'      => '<div>订单已经完成。</div>'
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

    /**
     * 获取店铺保存的外链地址
     */
    private function _fetch_shop_outside(){
        $webcfg_storage = new App_Model_Applet_MysqlAppletWebcfgStorage($this->curr_sid);
        $cfg = $webcfg_storage->findUpdateBySid();
        $data = array();
        $page_data = array();
        if($cfg && ($cfg["awc_web1"] || $cfg["awc_web2"] ||$cfg["awc_web3"] || $cfg["awc_web4"] || $cfg["awc_web5"])){
            for($i=1;$i<=5;$i++){
                if(isset($cfg["awc_web$i"]) && $cfg["awc_web$i"]){
                    $data[] = array(
                        'index' => $i,
                        'link'  => $cfg["awc_web$i"],
                        'title' => '链接地址'.$i,
                    );
                    $page_data[] = array(
                        'path' => 'pages/webviewTab'.$i.'/webviewTab'.$i,
                        'name' => '链接地址'.$i,
                    );
                }
            }
        }else{
            $data[] = array(
                'index' => 0,
                'link'  => '',
                'title' => '链接地址1',
            );
        }
        $this->output['outsideLink'] = json_encode($data);
        return $page_data;
    }

    private function _fetch_page_data(){
        $page_storage = new App_Model_Applet_MysqlAppletPageStorage();
        $page_list = $page_storage->fetchAction($this->wxapp_cfg['ac_type']);
        $page_data = array();
        if($page_list){
            foreach ($page_list as $val){
                $path = $val['ap_path'];
                if($val['ap_path'] == "pages/generalFormTab/generalFormTab"){
                    $path = str_replace('generalFormTab', 'generalForm', $val['ap_path']);
                }
                if($val['ap_path'] == "pages/groupIndex/groupIndex"){
                    $path = str_replace('groupIndex', 'groupIndexPage', $val['ap_path']);
                }
                if($val['ap_path'] == "pages/goodIndex/goodIndex"){
                    $path = str_replace('goodIndex', 'goodIndexPage', $val['ap_path']);
                }
                if($val['ap_path'] == "pages/seckillPage/seckillPage"){
                    $path = str_replace('seckillPage', 'seckillPageShow', $val['ap_path']);
                }
                if($val['ap_path'] == "pages/storeMember/storeMember"){
                    $path = str_replace('pages/storeMember/storeMember', 'subpages/memberCard/memberCard', $val['ap_path']);
                }
                if($val['ap_path'] == "pages/distributionCenterTab/distributionCenterTab"){
                    if(in_array($this->wxapp_cfg['ac_type'],array(21,8,6))){
                        $path = 'subpages0/distributionCenter/distributionCenter';
                    }else{
                        $path = str_replace('distributionCenterTab', 'distributionCenter', $val['ap_path']);
                    }
                }
                $page_data[] = array(
                    'path' => $path,
                    'name' => $val['ap_desc']." （".$path."）"
                );
            }
        }
        return $page_data;
    }

    /**
     * 获取列表以供使用
     */
    private function _get_list_for_select(){
        $foldType = plum_parse_config('fold_menu','system');
        $linkList = plum_parse_config('link','system');
        $linkType = plum_parse_config('link_type','system');
        //$weedingType = plum_parse_config('link_type_goods','system');
        $link = $linkList[$this->wxapp_cfg['ac_type']];
        $this->output['linkList'] = json_encode($link);
        unset($foldType[0]); //去掉客服
        $this->output['linkType'] = json_encode(array_merge($linkType,$foldType));
    }
    private function _shop_information(){
        $where         = array();
        $where[]       = array('name'=>'ai_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]       = array('name'=>'ai_deleted','oper'=>'=','value'=>0);
        $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
        $sort          = array('ai_create_time' => 'DESC');
        $list          = $information_storage->getList($where,0,0,$sort);
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
    /*
         * 获得全部文章分类
         */
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

}