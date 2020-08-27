<?php


class App_Controller_Applet_CustomtplBaseController extends App_Controller_Applet_InitController
{

    public function __construct()
    {
        parent::__construct(true);

    }
  
  
  
   public function getBargainDataAction(){
        $getType = $this->request->getIntParam('getType');
        $goodsData = json_decode($this->request->getStrParam('goodsData'), true);
        $goodsNum = $this->request->getIntParam('goodsNum');

        $uid = plum_app_user_islogin();
        $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($this->sid);
        $list = array();
        if($getType == 1){//自动获取
            $where      = array();
            $where[]    = array('name'=>'ba_s_id','oper'=>'=','value'=>$this->sid);
            $where[]  = array('name'=>'ba_end_time','oper'=>'>','value'=>time());
            $sort = array('ba_status'=>'DESC','ba_create_time' => 'DESC');

            if($this->applet_cfg['ac_type'] == 12){
                $bargainList = $bargain_model->getCourseActivityList($where,0,$goodsNum,$sort);
                foreach ($bargainList as $val) {
                    $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
                    $hadBuy = $order_model->getTradeByGid($val['atc_id'],$uid);
                    $join_storage   = new App_Model_Bargain_MysqlJoinStorage($this->sid);
                    $record     = $join_storage->findJoinerByAidMid($val['ba_id'], $uid);
                    //参与信息
                    $hadJoin     = $join_storage->getRowByIdSid($record['bj_id'], $this->sid);
                    $statusStock = $this->_fetch_status_and_stock($val);
                    $list[] = array(
                        'id'       => $val['ba_id'],
                        'cover'    => isset($val['atc_cover']) && $val['atc_cover'] ? $this->dealImagePath($val['atc_cover']) : $this->dealImagePath($val['ba_image']),
                        'name'     => $val['atc_title'],
                        'oriPrice' => $val['ba_price'],
                        'minPrice' => $val['ba_kj_price_limit'],
                        'sold'     => $val['ba_join_num'],
                        'type'     => 0,
                        //'status'   => $val['ba_status'],   //0 准备中  1进行中  2已结束
                        'brief'    => $val['atc_brief'],
                        'hadBuy' => $hadBuy?1:0,
                        'hadJoin' => $hadJoin?1:0,
                        'gid' => $val['atc_id'],
                        'showNum'    => $val['ba_view_num'],
                        'showNumShow'=> $val['ba_view_num_show'],
                        'avatars'  => $this->_get_mem_avatar($val['ba_id']),
                        'status'    => $this->_fetch_activity_status($val),   //0 准备中  1进行中  2已结束
                        'timeStatus' => $statusStock['status'],
                        'stock'      => intval($this->_fetch_status_and_stock($val)),
                    );
                }
            }else{
                $bargainList = $bargain_model->getActivityList($where,0,$goodsNum,$sort);
                foreach ($bargainList as $val) {
                    $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
                    $hadBuy = $order_model->getTradeByGid($val['g_id'],$uid);
                    $join_storage   = new App_Model_Bargain_MysqlJoinStorage($this->sid);
                    $record     = $join_storage->findJoinerByAidMid($val['ba_id'], $uid);
                    //参与信息
                    $hadJoin     = $join_storage->getRowByIdSid($record['bj_id'], $this->sid);
                    $statusStock = $this->_fetch_status_and_stock($val);

                    $list[] = array(
                        'id'       => $val['ba_id'],
                        'cover'    => isset($val['g_cover']) && $val['g_cover'] ? $this->dealImagePath($val['g_cover']) : $this->dealImagePath($val['ba_image']),
                        'name'     => $val['g_name'],
                        'oriPrice' => $val['ba_price'],
                        'minPrice' => $val['ba_kj_price_limit'],
                        'sold'     => $val['ba_join_num'],
                        'type'     => $val['g_knowledge_pay_type'],
                        //'status'   => $val['ba_status'],   //0 准备中  1进行中  2已结束
                        'brief'    => $val['g_brief'],
                        'hadBuy' => $hadBuy?1:0,
                        'hadJoin' => $hadJoin?1:0,
                        'gid' => $val['g_id'],
                        'showNum'    => $val['ba_view_num'],
                        'showNumShow'=> $val['ba_view_num_show'],
                        'avatars'  => $this->_get_mem_avatar($val['ba_id']),
                        'status'    => $this->_fetch_activity_status($val),   //0 准备中  1进行中  2已结束
                        'timeStatus' => $statusStock['status'],
                        'stock'      => intval($this->_fetch_status_and_stock($val)),
                    );
                }
            }


        }else{ //手动添加
            if($this->applet_cfg['ac_type'] == 12){
                foreach ($goodsData as $val){
                    $bargain = $bargain_model->getCourseActivityById($val['id']);
                    $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
                    $hadBuy = $order_model->getTradeByGid($val['atc_id'],$uid);
                    $join_storage   = new App_Model_Bargain_MysqlJoinStorage($this->sid);
                    $record     = $join_storage->findJoinerByAidMid($val['ba_id'], $uid);
                    //参与信息
                    $hadJoin     = $join_storage->getRowByIdSid($record['bj_id'], $this->sid);
                    $statusStock = $this->_fetch_status_and_stock($val);
                    $list[] = array(
                        'id'       => $bargain['ba_id'],
                        'cover'    => isset($bargain['atc_cover']) && $bargain['atc_cover'] ? $this->dealImagePath($bargain['atc_cover']) : $this->dealImagePath($bargain['ba_image']),
                        'name'     => $bargain['atc_title'],
                        'oriPrice' => $bargain['ba_price'],
                        'minPrice' => $bargain['ba_kj_price_limit'],
                        'sold'     => $bargain['ba_join_num'],
                        'type'     => 0,
                        //'status'   => $bargain['ba_status'],   //0 准备中  1进行中  2已结束
                        'brief'    => $bargain['atc_brief'],
                        'hadBuy' => $hadBuy?1:0,
                        'hadJoin' => $hadJoin?1:0,
                        'gid' => $bargain['atc_id'],
                        'showNum'    => $bargain['ba_view_num'],
                        'showNumShow'=> $bargain['ba_view_num_show'],
                        'avatars'  => $this->_get_mem_avatar($bargain['ba_id']),
                        'status'    => $this->_fetch_activity_status($bargain),   //0 准备中  1进行中  2已结束
                        'timeStatus' => $statusStock['status'],
                        'stock'      => intval($this->_fetch_status_and_stock($bargain)),
                    );
                }
            }else{
                foreach ($goodsData as $val){
                    $bargain = $bargain_model->getActivityById($val['id']);
                    $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
                    $hadBuy = $order_model->getTradeByGid($val['g_id'],$uid);
                    $join_storage   = new App_Model_Bargain_MysqlJoinStorage($this->sid);
                    $record     = $join_storage->findJoinerByAidMid($val['ba_id'], $uid);
                    //参与信息
                    $hadJoin     = $join_storage->getRowByIdSid($record['bj_id'], $this->sid);
                    $statusStock = $this->_fetch_status_and_stock($val);
                    $list[] = array(
                        'id'       => $bargain['ba_id'],
                        'cover'    => isset($bargain['g_cover']) && $bargain['g_cover'] ? $this->dealImagePath($bargain['g_cover']) : $this->dealImagePath($bargain['ba_image']),
                        'name'     => $bargain['g_name'],
                        'oriPrice' => $bargain['ba_price'],
                        'minPrice' => $bargain['ba_kj_price_limit'],
                        'sold'     => $bargain['ba_join_num'],
                        'type'     => $bargain['g_knowledge_pay_type'],
                        //'status'   => $bargain['ba_status'],   //0 准备中  1进行中  2已结束
                        'brief'    => $bargain['g_brief'],
                        'hadBuy'   => $hadBuy?1:0,
                        'hadJoin'  => $hadJoin?1:0,
                        'gid'      => $bargain['g_id'],
                        'showNum'    => $bargain['ba_view_num'],
                        'showNumShow'=> $bargain['ba_view_num_show'],
                        'avatars'  => $this->_get_mem_avatar($bargain['ba_id']),
                        'status'    => $this->_fetch_activity_status($bargain),   //0 准备中  1进行中  2已结束
                        'timeStatus' => $statusStock['status'],
                        'stock'      => intval($this->_fetch_status_and_stock($bargain)),
                    );
                }
            }
        }
        $info['data'] = $list;
        $this->outputSuccess($info);
    }
  
  
   /**
     * 拼团活动商品
     */
    public function getGroupDataAction(){
        $getType = $this->request->getIntParam('getType');
        $goodsData = json_decode($this->request->getStrParam('goodsData'), true);

        $goodsNum = $this->request->getIntParam('goodsNum');
        $group_model    = new App_Model_Group_MysqlBuyStorage($this->sid);
        $list = array();
        $uid = plum_app_user_islogin();
        if($getType == 1){//自动获取
            $goodsType = $this->applet_cfg['ac_type'] == 12 ? 'course' : '';
            $groupList    = $group_model->getCurrentListByType(0,0, $goodsNum, 0, $goodsType, 0);
            foreach ($groupList as &$one) {
                //新增拼团活动的状态，
                $status = 0;
                $statusNote = '';
                if(time()>$one['gb_end_time']){
                    $status     = 3;
                    $statusNote = '已结束';
                }else if(time()>= $one['gb_start_time'] && time()<=$one['gb_end_time']){
                    $status     = 2;
                    $statusNote = '进行中';
                }else if(time()<$one['gb_start_time']){
                    $status     = 1;
                    $statusNote = '未开始';
                }
                $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);


                if($goodsType == 'course'){
//                    $hadJoin = $order_model->getTuanTradeByGid($one['atc_id'], $uid);
//                    $hadBuy = $order_model->getTradeByGid($one['atc_id'],$uid);
                    $list[] = array(
                        'id'    => $one['gb_id'],
                        'cover' => $this->dealImagePath($one['gb_cover']),
                        'gcover'=> $this->dealImagePath($one['atc_cover']),
                        'name'  => $one['atc_title'],
                        'gprice'=> $one['gb_type']==3?$one['gb_tz_price']:$one['gb_price'],
                        'price' => $one['atc_price'],
                        'total' => $one['gb_total'],
                        'hadTotal' => $one['gb_joined'],
                        'statusNote'=> $statusNote,
                        'status'   => $status,
                        'brief' => $one['atc_brief'],
//                        'hadJoin' => $hadJoin?1:0,
//                        'tid'     => $hadJoin['t_tid'],
//                        'hadBuy' => $hadBuy?1:0,
                        'hadJoin' => 0,
                        'tid'     => '',
                        'hadBuy' => 0,
                        'type'       => 0,
                        'gid'   => $one['atc_id']
                    );
                }else{
                    $hadJoin = $order_model->getTuanTradeByGid($one['g_id'], $uid);
                    $hadBuy = $order_model->getTradeByGid($one['g_id'],$uid);
                    $list[] = array(
                        'id'    => $one['gb_id'],
                        'cover' => $this->dealImagePath($one['gb_cover']),
                        'gcover'=> $this->dealImagePath($one['g_cover']),
                        'name'  => $one['g_name'],
                        'gprice'=> $one['gb_type']==3?$one['gb_tz_price']:$one['gb_price'],
                        'price' => $one['g_price'],
                        'total' => $one['gb_total'],
                        'hadTotal' => $one['gb_joined'],
                        'statusNote'=> $statusNote,
                        'status'   => $status,
                        'brief' => $one['g_brief'],
                        'hadJoin' => $hadJoin?1:0,
                        'tid'     => $hadJoin['t_tid'],
                        'hadBuy' => $hadBuy?1:0,
                        'type'       => $one['g_knowledge_pay_type'],
                        'gid'   => $one['g_id']
                    );
                }
            }
        }else{ //手动添加
            foreach ($goodsData as $val){
                if($this->applet_cfg['ac_type'] == 12){
                    $group = $group_model->fetchGroupCourse($val['id']);
                }else{
                    $group = $group_model->fetchGroupGoods($val['id']);
                }

                $status = 0;
                $statusNote = '';
                //新增拼团活动的状态，
                if(time()>$group['gb_end_time']){
                    $status     = 3;
                    $statusNote = '已结束';
                }else if(time()>= $group['gb_start_time'] && time()<=$group['gb_end_time']){
                    $status     = 2;
                    $statusNote = '进行中';
                }else if(time()<$group['gb_start_time']){
                    $status     = 1;
                    $statusNote = '未开始';
                }
                $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
                if($this->applet_cfg['ac_type'] == 12){
                    $list[] = array(
                        'id'    => $group['gb_id'],
                        'cover' => $this->dealImagePath($group['gb_cover']),
                        'gcover'=> $this->dealImagePath($group['atc_cover']),
                        'name'  => $group['atc_title'],
                        'gprice'=> $group['gb_type']==3?$group['gb_tz_price']:$group['gb_price'],
                        'price' => $group['atc_price'],
                        'total' => $group['gb_total'],
                        'hadTotal' => $group['gb_joined'],
                        'statusNote'=> $statusNote,
                        'status'   => $status,
                        'brief' => $group['atc_brief'],
//                        'hadJoin' => $hadJoin?1:0,
//                        'tid'     => $hadJoin['t_tid'],
//                        'hadBuy' => $hadBuy?1:0,
                        'hadJoin' => 0,
                        'tid'     => '',
                        'hadBuy' => 0,
                        'type'       => 0,
                        'gid'   => $group['atc_id'],
                        'valId' => $val['id']
                    );
                }else{
                    $hadJoin = $order_model->getTuanTradeByGid($group['g_id'], $uid);
                    $hadBuy = $order_model->getTradeByGid($group['g_id'],$uid);
                    $list[] = array(
                        'id'    => $group['gb_id'],
                        'cover' => $this->dealImagePath($group['gb_cover']),
                        'gcover'=> $this->dealImagePath($group['g_cover']),
                        'name'  => $group['g_name'],
                        'gprice'=> $group['gb_type']==3?$group['gb_tz_price']:$group['gb_price'],
                        'price' => $group['g_price'],
                        'total' => $group['gb_total'],
                        'hadTotal' => $group['gb_joined'],
                        'statusNote'=> $statusNote,
                        'status'   => $status,
                        'brief' => $group['g_brief'],
                        'hadJoin' => $hadJoin?1:0,
                        'tid'     => $hadJoin['t_tid'],
                        'hadBuy' => $hadBuy?1:0,
                        'type'       => $group['g_knowledge_pay_type'],
                        'gid'   => $group['g_id']
                    );
                }

            }
        }
        $info['data'] = $list;
        $this->outputSuccess($info);
    }
  
  public function getSeckillDataAction(){
        $getType = $this->request->getIntParam('getType');
        $goodsData = json_decode($this->request->getStrParam('goodsData'), true);
        $goodsNum = $this->request->getIntParam('goodsNum');

        $limit_model = new App_Model_Limit_MysqlLimitActStorage($this->sid);
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $course_model = new App_Model_Train_MysqlTrainCourseStorage($this->sid);
        $list = array();
        if($getType == 1){//自动获取
            $where      = array();
            if($this->applet_cfg['ac_type'] == 12){
                $limitList  = $limit_model->getAllRunningNotBeginActCourse($where,0,$goodsNum);
            }else{
                $limitList  = $limit_model->getAllRunningNotBeginActGoods($where,0,$goodsNum);
            }
            if($this->applet_cfg['ac_type'] == 12){
                foreach ($limitList as $val) {
                    $goods = $this->_format_lesson($val,false,$val['la_id']);
                    if($goods['id']){
                        $list[] = $goods;
                    }
                }
            }else{
                foreach ($limitList as $val) {
                    $goods = $this->_format_goods_details($val,false,$val['la_id']);
                    if($goods['id']){
                        $list[] = $goods;
                    }
                }
            }

        }else{ //手动添加
            if($this->applet_cfg['ac_type'] == 12){
                foreach ($goodsData as $val){
                    $limit = $course_model->getRowById($val['id']);
                    $goods = $this->_format_lesson($limit,false,0);
                    if($limit && $goods['id']){
                        $list[] =  $goods;
                    }
                }
            }else{
                foreach ($goodsData as $val){
                    $limit = $goods_model->getRowById($val['id']);
                    $goods = $this->_format_goods_details($limit,false,0,false);
                    if($limit && $goods['id']){
                        $list[] =  $goods;
                    }
                }
            }

        }
        $info['data'] = $list;
        $this->outputSuccess($info);
    }
  
   public function getPointsDataAction(){
        $getType = $this->request->getIntParam('getType');
        $goodsData = json_decode($this->request->getStrParam('goodsData'), true);
        $goodsNum = $this->request->getIntParam('goodsNum');

        $goods_model    = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $list = array();
        if($getType == 1){//自动获取
            $goods    = $goods_model->fetchShopGoodsList($this->sid, 0, $goodsNum, '',  0, array(),array(),0,0,array(4,5),array(),0);
            $list = array();
            foreach($goods as $val){
                $list[] = array(
                    'id'        => $val['g_id'],
                    'name'      => $val['g_name'],
                    'cover'     => $this->dealImagePath($val['g_cover']),
                    'price'     => floatval($val['g_price']),
                    'points'    => $val['g_points'],
                    'oriPrice'  => floatval($val['g_ori_price']),
                    'listLabel' => $val['g_list_label'] ? $val['g_list_label'] : '',
                    'stock'     => $val['g_stock']<0?0:$val['g_stock'],
                    'sold'      => $val['g_sold'],
                    'stockShow'  => $val['g_stock_show'],
                    'soldShow'   => $val['g_sold_show'],
                );
            }
        }else{ //手动添加
            foreach ($goodsData as $val){
                $goods = $goods_model->getRowById($val['id']);
                $list[] = array(
                    'id'        => $goods['g_id'],
                    'name'      => $goods['g_name'],
                    'cover'     => $this->dealImagePath($goods['g_cover']),
                    'price'     => floatval($goods['g_price']),
                    'points'    => $goods['g_points'],
                    'oriPrice'  => floatval($goods['g_ori_price']),
                    'listLabel' => $goods['g_list_label'] ? $goods['g_list_label'] : '',
                    'stock'     => $goods['g_stock']<0?0:$goods['g_stock'],
                    'sold'      => $goods['g_sold'],
                    'stockShow'  => $goods['g_stock_show'],
                    'soldShow'   => $goods['g_sold_show'],
                );
            }
        }
        $info['data'] = $list;
        $this->outputSuccess($info);
    }
  
  
  /**
     * 获取商品列表
     */
    public function getGoodsListAction(){
        $independent = $this->request->getIntParam('independent');
        $type = $this->request->getIntParam('type');
        $kind = $this->request->getIntParam('kind');
        $num  = $this->request->getIntParam('num');
        $lng  = $this->request->getStrParam('lng');
        $lat  = $this->request->getStrParam('lat');
        $goodsSort = $this->request->getIntParam('sort');

        $info['data'] = $this->_goods_list_by_kind($type, $kind, $num, $goodsSort, $lng, $lat, $independent);
        $this->outputSuccess($info);
    }

    public function tplCfgAction(){
        $startTime = time();
        $tplId = $this->request->getIntParam('tplId');
        if($tplId){
            $template_model = new App_Model_Applet_MysqlAppletCommonTemplateStorage();
            $template = $template_model->getRowById($tplId);
        }else{
            $template_model = new App_Model_Applet_MysqlAppletTemplateStorage();
            $where[] = array('name' => 'act_s_id', 'oper' => '=', 'value' => $this->sid);
            $template = $template_model->getRow($where);
        }
        if($template){
            $data = json_decode($template['act_data'], true);
            $remove_chooseCommunity = false; //社区团购 是否确实移除了小区选择组件
            foreach ($data as $key => $val){
                //过滤没有类型的组件
//                if(!isset($val['type']) || (isset($val['type']) && !$val['type'])){
//                    continue;
//                }
                                
                //对不同的组件做处理
                if($val['type'] == 'slide'){
                    $data[$key] = $this->_deal_slide_data($val);
                }
                if($val['type'] == 'video'){
                    $data[$key] = $this->_deal_video_data($val);
                }
                if($val['type'] == 'fenlei'){
                    $data[$key] = $this->_deal_fenlei_data($val);
                }
                if($val['type'] == 'search'){
                    $data[$key] = $this->_deal_search_data($val);
                }
                if($val['type'] == 'address'){
                    $data[$key] = $this->_deal_address_data($val);
                }
                if($val['type'] == 'notice'){
                    $data[$key] = $this->_deal_notice_data($val);
                }
                if($val['type'] == 'title'){
                    $data[$key] = $this->_deal_title_data($val);
                }
                if($val['type'] == 'image'){
                    $data[$key] = $this->_deal_image_data($val);
                }
                if($val['type'] == 'button'){
                    $data[$key] = $this->_deal_button_data($val);
                }
                if($val['type'] == 'space'){
                    $data[$key] = $this->_deal_space_data($val);
                }
                if($val['type'] == 'goodlist'){
                    $data[$key] = $this->_deal_goodlist_data($val);
                }
                if($val['type'] == 'roomlist'){
                    $data[$key] = $this->_deal_roomlist_data($val);
                }
                if($val['type'] == 'pictxt'){
                    $data[$key] = $this->_deal_pictxt_data($val);
                }
                if($val['type'] == 'window'){
                    $data[$key] = $this->_deal_window_data($val);
                }
                if($val['type'] == 'coupon'){
                    $data[$key] = $this->_deal_coupon_data($val);
                }
                if($val['type'] == 'group'){
                    $data[$key] = $this->_deal_group_data($val);
                }
                if($val['type'] == 'seckill'){
                    $data[$key] = $this->_deal_seckill_data($val);
                }
                if($val['type'] == 'bargain'){
                    $data[$key] = $this->_deal_bargain_data($val);
                }
                if($val['type'] == 'points'){
                    $data[$key] = $this->_deal_points_data($val);
                }
                if($val['type'] == 'advertisement'){
                    $data[$key] = $this->_deal_advertisement_data($val);
                }
                if($val['type'] == 'shoplist'){
                    $data[$key] = $this->_deal_shoplist_data($val);
                }
                if($val['type'] == 'statistics'){
                    $data[$key] = $this->_deal_statistic_data($val);
                }
                if($val['type'] == 'gamelist'){
                    $data[$key] = $this->_deal_gamelist_data($val);
                }
                if($val['type'] == 'storelist'){
                    $data[$key] = $this->_deal_storelist_data($val);
                }
                if($val['type'] == 'hotelstorelist'){
                    $data[$key] = $this->_deal_hotelstorelist_data($val);
                }
                if($val['type'] == 'courselist'){
                    if($this->appletType == 4 && in_array($this->applet_cfg['ac_type'],[21]) && $this->applet_cfg['ac_show_knowledge'] == 0){
                        //营销商城抖音版未开启此功能,不再处理此组件
                        continue;
                    }

                    $data[$key] = $this->_deal_courselist_data($val);
                }
                if($val['type'] == 'carlist'){
                    $data[$key] = $this->_deal_carlist_data($val);
                }
                if($val['type'] == 'mealactivity'){
                    $data[$key] = $this->_deal_meal_activity_data($val);
                }
                if($val['type'] == 'cateGoods'){
                    $indexBottom = 0;

                    if((!$remove_chooseCommunity && $key == (count($data) - 1)) || ($remove_chooseCommunity && $key == count($data))){
                        $indexBottom = 1;
                    }

                   // $uid = plum_app_user_islogin();
                   // if(($this->sid == 10671 && $uid == 3478741) || ($this->sid == 9373 && $uid == 2453226)){
                   //     $print = [
                   //         'key' => $key,
                   //         'count' => count($data)
                   //     ];
                   //     Libs_Log_Logger::outputLog($print,'test.log');
                   // }

                    $data[$key] = $this->_deal_cate_goods_data($val, $indexBottom);
                }
                if($val['type'] == 'catelist'){
                    $data[$key] = $this->_deal_catelist_data($val);
                }
                if($val['type'] == 'activityList'){
                    $data[$key] = $this->_deal_sequence_activity_data($val);
                }
                if($val['type'] == 'quotationList'){
                    $data[$key] = $this->_deal_quotation_list_data($val);
                }
                if($val['type'] == 'recommendList'){
                    $data[$key] = $this->_deal_recommend_list_data($val);
                }
                if($val['type'] == 'chooseCommunity'){
                    if(isset($val['indexShow'])){
                        $indexShow = $val['indexShow']=='true'?true:false;
                    }else{
                        $indexShow = true;
                    }
                    if(!$indexShow){
                        unset($data[$key]);
                        $remove_chooseCommunity = true; //标记移除了选择小区组件
                    }else{
                        $data[$key]['componentStyle'] = $val['componentStyle'] == 2 ? 2 : 1;
                    }

                }
                if($val['type'] == 'lessonlist'){
                    $data[$key] = $this->_deal_lessonlist_data($val);
                }
            }
            $info['data'] = array(
                'headerTitle' => $template['act_header_title'],
                'pagebgColor' => $template['act_page_bgcolor'],
                'showPost'    => $template['act_show_post_list'],
                'showPostBtn' => $template['act_show_post_btn'],
                'templateData' => array_values($data)
            );
            if($this->applet_cfg['ac_type'] == 6){
                $type = array(
                    array('index'=>0,'name'=>'最新发布','must'=>true,'type'=>'time'),
                    array('index'=>1,'name'=>'红包福利','must'=>true,'type'=>'redPacket'),
                    array('index'=>2,'name'=>'最新回复','must'=>true,'type'=>'reply'),
                    array('index'=>3,'name'=>'距离最近','must'=>true,'type'=>'distance')
                );
                $tpl_model = new App_Model_City_MysqlCityIndexStorage($this->sid);
                $tpl = $tpl_model->findUpdateBySid(23);
                $info['data']['postType'] = isset($tpl['aci_post_type']) && $tpl['aci_post_type'] ? $this->_remove_post_quotes($tpl['aci_post_type'])['type'] : $type;
                $info['data']['postTab'] = $this->_shop_index_post_tab(0);
            }
            if($this->applet_cfg['ac_type'] == 33){
                $type = [
                    array('index'=>0,'name'=>'最新车源','must'=>true,'type'=>'resource'),
                    array('index'=>1,'name'=>'推荐服务','must'=>true,'type'=>'goods')
                ];
                $cfg_model = new App_Model_Car_MysqlCarCfgStorage($this->sid);
                $cfg = $cfg_model->findUpdateBySid();
                $info['data']['postType'] = isset($cfg['acc_index_tab']) && $cfg['acc_index_tab'] ? $this->_remove_post_quotes($cfg['acc_index_tab'])['type'] : $type;
                $info['data']['postTab'] = $this->_shop_index_post_tab(0);
            }

            if($this->applet_cfg['ac_type'] == 28){
                $type = array(
                    array('index'=>0,'name'=>'为您推荐','must'=>true,'type'=>'recommend'),
                    array('index'=>1,'name'=>'附近职位','must'=>true,'type'=>'nearby'),
                    array('index'=>2,'name'=>'高薪职位','must'=>true,'type'=>'fat'),
                    array('index'=>3,'name'=>'内推职位','must'=>true,'type'=>'award')
                );
                $tpl_model = new App_Model_Job_MysqlJobIndexStorage($this->sid);
                $tpl  = $tpl_model->findUpdateBySid(61);
                $info['data']['positionType'] = isset($tpl['aji_position_type']) && $tpl['aji_position_type'] ? $this->_remove_position_quotes($tpl['aji_position_type'])['type'] : $type;
            }

            if($this->applet_cfg['ac_type'] == 32){
               // $uid = plum_app_user_islogin();
               // $cart_model = new App_Model_Shop_MysqlShopCartStorage($this->sid);
               // $cartSum = $cart_model->getCartSum($uid);
                $cartSum = $this->_get_cart_sum(0);
                $info['data']['cartNum'] = $cartSum ? intval($cartSum) : 0;
            }

            if($this->sid == '8923'){
                Libs_Log_Logger::outputLog('程序执行事件：'.(time()-$startTime));
            }
            $this->outputSuccess($info);
        }else{
            $this->outputError('暂未配置页面');
        }
    }


    private function _remove_position_quotes($type){

        $data['type'] = json_decode($type,true);
        $data['redPacket'] = false;
        foreach ($data['type'] as $key => &$value){
            if($value['must']=='true'){
                $value['must'] = true;
                if($value['type']=='redPacket'){
                    $data['redPacket'] = true;
                }
            }else{
                //$value['must'] = false;
                unset($data['type'][$key]);
            }
        }
        $data['type'] = array_values($data['type']);
        return $data;
    }

    
    
    
    
    
    private function _shop_index_post_tab($tpl_id = 0){
        $data = array();
        //获取店铺幻灯
        $slide_storage  = new App_Model_City_MysqlCityPostTabStorage($this->sid);
        $slide      = $slide_storage->fetchShortcutShowList($tpl_id);
        if($slide){
            foreach ($slide as $val){
                $data[] = array(
                    'id'   => $val['acpt_id'],
                    'title' => $val['acpt_name'],
                    'link' => $val['acpt_link'], # /pages/index/index?id=8
                    'img'  => isset($val['acpt_icon']) ? $this->dealImagePath($val['acpt_icon']) : '',
                    'type' => $val['acpt_link_type'],
                    'url'  => $this->get_link_by_type($val['acpt_link_type'],$val['acpt_link'],$val['acpt_name']),
                );
            }
        }
        return $data;
    }

    private function _remove_post_quotes($type){

        $data['type'] = json_decode($type,true);
        $data['redPacket'] = false;
        foreach ($data['type'] as &$value){
            if($value['must']=='true'){
                $value['must'] = true;
                if($value['type']=='redPacket'){
                    $data['redPacket'] = true;
                }
            }else{
                $value['must'] = false;
            }

        }
        return $data;
    }

    private function _deal_slide_data($data){
        $data['autoplay']     = $data['autoplay'] =='true'?true:false;
        $data['borderRadius'] = intval($data['borderRadius']);
        $data['duration']     = intval($data['duration']);
        $data['interval']     = intval($data['interval']);
        $data['style']['height']       = intval($data['style']['height']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['style']['paddingLeft']  = intval($data['style']['paddingLeft']);
        $data['style']['paddingRight'] = intval($data['style']['paddingRight']);
        foreach ($data['slideimgs'] as $key => $val){
            $temp = $val;
            $data['slideimgs'][$key]['link'] = array();
            $data['slideimgs'][$key]['img'] = $this->dealImagePath($temp['img']);
            $data['slideimgs'][$key]['type'] = $temp['type'];
            if($data['slideimgs'][$key]['type'] == 107){
                $game_model = new App_Model_Gamebox_MysqlGameboxGameStorage($this->sid);
                $game = $game_model->getRowByIdSid($temp['link'],$this->sid);
                $data['slideimgs'][$key]['gameurl']  = $game['agg_url'] ? $game['agg_url'] : '';
                $data['slideimgs'][$key]['appid']    = $game['agg_appid'] ? $game['agg_appid'] : '';
                $data['slideimgs'][$key]['qrcode']   = $game['agg_qrcode'] ? $this->dealImagePath($game['agg_qrcode']) : '';
                $data['slideimgs'][$key]['jumpType'] = intval($game['agg_jump_type']);
            }else{
                $data['slideimgs'][$key]['link'] = $this->get_link_by_type($temp['type'], $temp['link'], '', $temp['articleTitle']);
            }
        }
        return $data;
    }

    private function _deal_video_data($data){
        $data['autoplay']              = $data['autoplay']=='true'?true:false;
        $data['videocover']            = $this->dealImagePath($data['videocover']);
        $data['style']['height']       = intval($data['style']['height']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['style']['paddingLeft']  = intval($data['style']['paddingLeft']);
        $data['style']['paddingRight'] = intval($data['style']['paddingRight']);
        return $data;
    }

    private function _deal_fenlei_data($data){
        $data['iconRadius']   = intval($data['iconRadius']);
        $data['navNumber']    = intval($data['navNumber']);
        $data['styleType']    = intval($data['styleType']);
        $data['style']['width']        = intval($data['style']['width']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['style']['fontSize']     = intval($data['style']['fontSize']);
        $data['style']['borderRadius'] = intval($data['style']['borderRadius']);
        if($this->applet_cfg['ac_type'] != 6){
            foreach ($data['flitems'] as $key => $val){
                $data['flitems'][$key]['icon'] = $this->dealImagePath($val['icon']);
                $data['flitems'][$key]['type'] = $val['link']['type'];
                if($data['flitems'][$key]['type'] == 107){
                    $game_model = new App_Model_Gamebox_MysqlGameboxGameStorage($this->sid);
                    $game = $game_model->getRowByIdSid($val['link']['url'],$this->sid);
                    $data['flitems'][$key]['gameurl']  = $game['agg_url'] ? $game['agg_url'] : '';
                    $data['flitems'][$key]['appid']    = $game['agg_appid'] ? $game['agg_appid'] : '';
                    $data['flitems'][$key]['qrcode']   = $game['agg_qrcode'] ? $this->dealImagePath($game['agg_qrcode']) : '';
                    $data['flitems'][$key]['jumpType'] = intval($game['agg_jump_type']);
                }else{
                    if($val['link']){
                        $data['flitems'][$key]['link']['url'] = $this->get_link_by_type($val['link']['type'], $val['link']['url'], $val['name'], $val['link']['articleTitle']);
                    }else{
                        $data['flitems'][$key]['link']['url'] = '';
                    }
                }
            }
        }else{
            $data['flitems'] = array();
            $shortcut_model = new App_Model_City_MysqlCityPostCategoryStorage($this->sid);
            $shortcut = $shortcut_model->fetchShortcutShowList(1);
            foreach($shortcut as $key => $val){
                if(true){
                    $data['flitems'][$key]['name'] = $val['acc_title'];
                    $data['flitems'][$key]['icon'] = $this->dealImagePath($val['acc_img']);
                    $data['flitems'][$key]['link']['type'] = $val['acc_service_type']==3 && $this->sid==5914 ? 2 : $val['acc_service_type'];
                    $data['flitems'][$key]['mobileShow']   = $val['acc_mobile_show'] ==1 ? true : false;
                    $data['flitems'][$key]['addressShow']  = $val['acc_address_show'] ==1 ? true : false;
                    $data['flitems'][$key]['allowComment'] = $val['acc_allow_comment'] ==1 ? true : false;
                    $data['flitems'][$key]['verifyComment']= $val['acc_verify_comment'] ==1 ? true : false;
                    $data['flitems'][$key]['isshow'] = $val['acc_isshow'] ==1 ? true : false;
                    switch ($val['acc_service_type']) {
                        case 2:
                            $data['flitems'][$key]['link']['url'] = '/pages/expressCheck/expressCheck?&&title='.$val['acc_title'];
                            break;
                        case 3:
                            $system = $this->request->getStrParam('system');
                            $link = $val['acc_link_url'].'?title='.$val['acc_title'];
                            if($system && $system == 'ios'){
                                if($val['acc_link_url'] == "/subpages/memberCard/memberCard"){
                                    $link = array(
                                        'msg' => '十分抱歉，由于相关规范，暂时无法使用此功能'
                                    );
                                }
                            }
                            $data['flitems'][$key]['link']['url'] = $link;
                            break;
                        case 4:
                            $data['flitems'][$key]['link']['url'] = '/pages/informationDetail/informationDetail?id='.$val['acc_link_url'];
                            break;
                        case 5 :   // 商城商品详情
                            $data['flitems'][$key]['link']['url'] = '/pages/goodDetail/goodDetail?id='.$val['acc_link_url'];
                            break;
                        case 106:
                            $data['flitems'][$key]['link']['url'] = $val['acc_link_url'];
                            break;
                        case 20 :   // 同城版入驻店铺详情
                            $data['flitems'][$key]['link']['url'] = '/pages/shopDetailnew/shopDetailnew?id='.$val['acc_link_url'];
                            break;
                        case 32:
                            $data['flitems'][$key]['link']['url'] = '/pages/informationPage/informationPage?id='.$val['acc_link_url'].'&title=';
                            break;
                        case 34:
                            $category_model = new App_Model_City_MysqlCityPostCategoryStorage(0);
                            $category = $category_model->getRowById($val['acc_link_url']);
                            $name = $category['acc_title'];
                            $data['flitems'][$key]['link']['url'] = '/pages/searchShop/searchShop?id='.$val['acc_link_url'].'&title='.$name;
                            break;
                        case 42 ://多店 入主店铺商品分组
                            $data['flitems'][$key]['link']['url'] = '/subpages/wnGoodsList/wnGoodsList?from=shop&goodType='.$val['acc_link_url'].'&title='.$val['acc_title'];
                            break;
                        case 55:
                            $data['flitems'][$key]['link']['url'] = '/pages/generalForm/generalForm?id='.$val['acc_link_url'];
                            break;
                        case 104:
                            $data['flitems'][$key]['link']['url'] = '/'.$val['acc_link_url'];
                            break;

                        default:
                            if($val['acc_isshow']){
                                $data['flitems'][$key]['link']['url'] = '/pages/postList/postList?id='.$val['acc_id'].'&title='.$val['acc_title'].'&price='.$val['acc_price'];
                            }else{
                                unset($data['flitems'][$key]);
                            }
                            break;
                    }
                    if($this->appletType == 5 && $data['flitems'][$key]['link']['url'] && !in_array($val['acc_service_type'],[101,102,103,105,106])){
                        $routeInfo = $this->getPageRoute($data['flitems'][$key]['link']['url']);
                        $data['flitems'][$key]['link']['url'] = $routeInfo['route'];
                    }
                }
            }
        }
        $data['flitems'] = array_values($data['flitems']);
        return $data;
    }

    private function _deal_search_data($data){
        $data['searchArea']['marginBottom']  = intval($data['searchArea']['marginBottom']);
        $data['searchArea']['marginTop']     = intval($data['searchArea']['marginTop']);
        $data['searchArea']['paddingBottom'] = intval($data['searchArea']['paddingBottom']);
        $data['searchArea']['paddingTop']    = intval($data['searchArea']['paddingTop']);
        $data['style']['borderRadius'] = intval($data['style']['borderRadius']);
        $data['style']['fontSize']     = intval($data['style']['fontSize']);
        $data['style']['height']       = intval($data['style']['height']);
        $data['style']['lineHeight']   = intval($data['style']['height']);
        $data['style']['width']        = intval($data['style']['width']);
        $data['searchType']            = $data['searchType']?intval($data['searchType']):2;
        $data['showWeather']           = ($data['showWeather']=='true' || !array_key_exists('showWeather', $data))?true:false;

        return $data;
    }

    private function _deal_choose_community_data($data){


        return $data;
    }

    private function _deal_address_data($data){
        $data['addressStyle'] = intval($data['addressStyle']);
        $data['style']['fontSize']     = intval($data['style']['fontSize']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['companyLogo'] = $this->dealImagePath($data['companyLogo']);
        return $data;
    }

    private function _deal_notice_data($data){
        $data['isBold']                = $data['isBold']=='true'?true:false;
        $data['style']['fontSize']     = intval($data['style']['fontSize']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        return $data;
    }

    private function _deal_title_data($data){
        $data['isBold']                = $data['isBold']=='true'?true:false;
        $data['titleStyle']            = intval($data['titleStyle']);
        $data['style']['fontSize']     = intval($data['style']['fontSize']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['style']['paddingBottom']= intval($data['style']['paddingBottom']);
        $data['style']['paddingTop']   = intval($data['style']['paddingTop']);
        $data['titleBg'] = $this->dealImagePath($data['titleBg']);
        if($data['link']['type'] == 107){
            $game_model = new App_Model_Gamebox_MysqlGameboxGameStorage($this->sid);
            $game = $game_model->getRowByIdSid($data['link']['url'],$this->sid);
            $data['link']['gameurl']  = $game['agg_url'] ? $game['agg_url'] : '';
            $data['link']['appid']    = $game['agg_appid'] ? $game['agg_appid'] : '';
            $data['link']['qrcode']   = $game['agg_qrcode'] ? $this->dealImagePath($game['agg_qrcode']) : '';
            $data['link']['jumpType'] = intval($game['agg_jump_type']);
        }else{
            $data['link']['url'] = $this->get_link_by_type($data['link']['type'], $data['link']['url'], '', $data['link']['articleTitle']);
        }
        return $data;
    }

    private function _deal_image_data($data){
        $data['imageStyle']['width']   = intval($data['imageStyle']['width'])>375?375:intval($data['imageStyle']['width']);
        $data['imageStyle']['height']  = intval($data['imageStyle']['width'])>375?(375/intval($data['imageStyle']['width'])*intval($data['imageStyle']['height'])):intval($data['imageStyle']['height']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['style']['paddingLeft']  = intval($data['style']['paddingLeft']);
        $data['style']['paddingRight'] = intval($data['style']['paddingRight']);
        $data['style']['paddingBottom']= intval($data['style']['paddingBottom']);
        $data['style']['paddingTop']   = intval($data['style']['paddingTop']);
        $data['imageUrl'] = $this->dealImagePath($data['imageUrl']);
        if($data['link']['type'] == 107){
            $game_model = new App_Model_Gamebox_MysqlGameboxGameStorage($this->sid);
            $game = $game_model->getRowByIdSid($data['link']['url'],$this->sid);
            $data['link']['gameurl']  = $game['agg_url'] ? $game['agg_url'] : '';
            $data['link']['appid']    = $game['agg_appid'] ? $game['agg_appid'] : '';
            $data['link']['qrcode']   = $game['agg_qrcode'] ? $this->dealImagePath($game['agg_qrcode']) : '';
            $data['link']['jumpType'] = intval($game['agg_jump_type']);
        }else{
            $data['link']['url'] = $this->get_link_by_type($data['link']['type'], $data['link']['url'], $data['link']['name'], $data['link']['articleTitle']);
        }
        return $data;
    }

    private function _deal_button_data($data){
        $data['buttonStyle']['borderRadius'] = intval($data['buttonStyle']['borderRadius']);
        $data['buttonStyle']['fontSize']     = intval($data['buttonStyle']['fontSize']) > 0 ? intval($data['buttonStyle']['fontSize']) : 14;
        $data['buttonStyle']['height']       = intval($data['buttonStyle']['height']);
        $data['buttonStyle']['lineHeight']   = intval($data['buttonStyle']['lineHeight']);
        $data['buttonStyle']['width']        = intval($data['buttonStyle']['width']);
        $data['style']['paddingLeft']   = intval($data['style']['paddingLeft']);
        $data['style']['paddingBottom'] = intval($data['style']['paddingBottom']);
        $data['style']['paddingTop']    = intval($data['style']['paddingTop']);
        if($data['link']['type'] == 107){
            $game_model = new App_Model_Gamebox_MysqlGameboxGameStorage($this->sid);
            $game = $game_model->getRowByIdSid($data['link']['url'],$this->sid);
            $data['link']['gameurl']  = $game['agg_url'] ? $game['agg_url'] : '';
            $data['link']['appid']    = $game['agg_appid'] ? $game['agg_appid'] : '';
            $data['link']['qrcode']   = $game['agg_qrcode'] ? $this->dealImagePath($game['agg_qrcode']) : '';
            $data['link']['jumpType'] = intval($game['agg_jump_type']);
        }else{
            $data['link']['url'] = $this->get_link_by_type($data['link']['type'], $data['link']['url'], '', $data['link']['articleTitle']);
        }
        return $data;
    }

    private function _deal_space_data($data){
        $data['spaceStyle']['borderTopWidth'] = intval($data['spaceStyle']['borderTopWidth']);
        $data['spaceStyle']['width']      = intval($data['spaceStyle']['width']);
        $data['style']['marginTop']       = intval($data['style']['marginTop']);
        $data['style']['paddingLeft']  = intval($data['style']['paddingLeft']);
        return $data;
    }

    private function _deal_goodlist_data($data){
        $lng    = $this->request->getStrParam('lng');
        $lat    = $this->request->getStrParam('lat');
        $data['goodStyle']  = intval($data['goodStyle']);
        $data['isShowcart'] = $data['isShowcart']=='true'?true:false;
        $data['isShowsold'] = $data['isShowsold']=='true'?true:false;
        $data['priceBold']  = $data['priceBold']=='true'?true:false;
        $data['isShowmore'] = $data['isShowmore']=='true'?true:false;
        $data['priceStyle']['fontSize']= intval($data['priceStyle']['fontSize']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['titleStyle']['fontSize']= intval($data['titleStyle']['fontSize']);
        $kind_model     = new App_Model_Shop_MysqlKindStorage($this->sid);
        $kind = $kind_model->getRowById($data['goodSource']);
        $data['sourceName'] = $kind['sk_name'];
        $data['goodsData'] = [];
        $data['requestDataCfg'] = array(
            'dataType' => 'goodsData',
            'api' => 'applet_custom_goods_data',
            'params' => "type=".$data['goodSourceType']."&kind=".$data['goodSource']."&num=".$data['goodsNum'].'&sort='.$data['goodsSort'].'&lng='.$lng.'&lat='.$lat
        );
        switch ($data['goodSourceType']){
            case 1 ://商品分类
                if($this->applet_cfg['ac_type'] == 13){
                    $data['goodsLink'] = '/pages/goodsList/goodsList?id='.$data['goodSource'].'&title=';
                }elseif($this->applet_cfg['ac_type'] == 6){
                    if($this->appletType == 4){
                        $data['goodsLink'] = '/pages/wnGoodsList/wnGoodsList?id='.$data['goodSource'].'&title=';
                    }else{
                        $data['goodsLink'] = '/subpages0/wnGoodsList/wnGoodsList?id='.$data['goodSource'].'&title=';
                    }

                }elseif($this->applet_cfg['ac_type'] == 18){
                    $data['goodsLink'] = '/pages/goods/goods?id='.$data['goodSource'].'&title=';
                }elseif ($this->applet_cfg['ac_type'] == 32){
                    if($this->appletType == 4){
                        $data['goodsLink'] = '/pages/searchGood/searchGood?cate='.$data['goodSource'].'&title='.$data['sourceName'];
                    }else{
                        $data['goodsLink'] = '/subpages/searchGood/searchGood?cate='.$data['goodSource'].'&title='.$data['sourceName'];
                    }

                }elseif ($this->applet_cfg['ac_type'] == 7){
                    if($this->appletType == 4){
                        $data['goodsLink'] = '/pages/allgoodsPage/allgoodsPage';
                    }else{
                        $data['goodsLink'] = '/subpages0/allgoodsPage/allgoodsPage';
                    }
                }else{
                    $data['goodsLink'] = '/pages/allgoodsPage/allgoodsPage?oneid=""&secondid='.$data['goodSource'].'&title='.$kind['sk_name'];
                }
                break;
            case 2 ://平台商品分组
                if($this->applet_cfg['ac_type'] == 8){
                    $data['goodsLink'] = '/pages/wnGoodsList/wnGoodsList?from=platform&goodType='.$data['goodSource'].'&title=';
                }elseif($this->applet_cfg['ac_type'] == 6){
                    if($this->appletType == 4){
                        $data['goodsLink'] = '/pages/wnGoodsList/wnGoodsList?from=platform&goodType='.$data['goodSource'].'&title=';
                    }else{
                        $data['goodsLink'] = '/subpages/wnGoodsList/wnGoodsList?from=platform&goodType='.$data['goodSource'].'&title=';
                    }

                }else{
                    $data['goodsLink'] = '/pages/flGoodsList/flGoodsList?id='.$data['goodSource'].'&title=';
                }
                break;
            case 3 ://商家商品列表
                if($this->appletType == 4){
                    $data['goodsLink'] = '/pages/shopgoodslist/shopgoodslist';
                }else{
                    $data['goodsLink'] = '/subpages/shopgoodslist/shopgoodslist';
                }


                break;
            case 4 ://商家商品分组
                if($this->applet_cfg['ac_type'] == 6){
                    if($this->appletType == 4){
                        $data['goodsLink'] = '/pages/wnGoodsList/wnGoodsList?from=shop&goodType='.$data['goodSource'].'&title=';
                    }else{
                        $data['goodsLink'] = '/subpages/wnGoodsList/wnGoodsList?from=shop&goodType='.$data['goodSource'].'&title=';
                    }

                }else{
                    $data['goodsLink'] = '/pages/wnGoodsList/wnGoodsList?from=shop&goodType='.$data['goodSource'].'&title=';
                }
                break;
        }
        return $data;
    }

    
    private function _deal_roomlist_data($data){
        $data['goodStyle']  = intval($data['goodStyle']);
        $data['priceBold']  = $data['priceBold']=='true'?true:false;
        $data['priceStyle']['fontSize']= intval($data['priceStyle']['fontSize']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['titleStyle']['fontSize']= intval($data['titleStyle']['fontSize']);
        //获取店铺商品
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $sort        = array('g_weight' => 'DESC', 'g_update_time' => 'DESC');
        $where[]     = ['name' => 'g_independent_mall','oper' => '=','value' => 0];
        $list        = $goods_model->fetchShopGoodsList($this->sid, 0, $data['goodsNum'], null, 0, $sort,[],0,0,1,$where);
        $uid = plum_app_user_islogin();

        $data['goodsData'] = [];
        $level = App_Helper_MemberLevel::getMemberLevel($this->sid,$uid);
        if($list){
            foreach ($list as $val){
                $data['goodsData'][] = $this->_format_room_details($val, $level);
            }
        }
        return $data;
    }

    
    private function _format_room_details($goods, $level){
        if($goods){
            $data = array(
                'id' => $goods['g_id'],
                'name'      => $goods['g_name'],
                'price'     => $level?intval($goods['g_price']*$level['ml_discount']/10):$goods['g_price'],
                'cover'     => $this->dealImagePath($goods['g_cover']),
                'oriPrice'  => $level? floatval($goods['g_price']):floatval($goods['g_ori_price']),
                'bedInfo'   => $goods['g_bed_info'],
                'hasWindow' => $goods['g_has_window']?'有窗':'无窗',
                'roomSize'  => $goods['g_room_size'],
            );
            return $data;
        }
        return false;
    }

    
    private function _deal_lessonlist_data($data){
        $data['goodStyle']  = intval($data['goodStyle']);
        $data['isShowcart'] = $data['isShowcart']=='true'?true:false;
        $data['isShowsold'] = $data['isShowsold']=='true'?true:false;
        $data['priceBold']  = $data['priceBold']=='true'?true:false;
        $data['isShowmore'] = $data['isShowmore']=='true'?true:false;
        $data['priceStyle']['fontSize']= intval($data['priceStyle']['fontSize']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['titleStyle']['fontSize']= intval($data['titleStyle']['fontSize']);
        $kind_model     = new App_Model_Train_MysqlTrainCourseTypeStorage($this->sid);
        $kind = $kind_model->getRowById($data['goodSource']['kind']);
        $data['sourceName'] = $kind['att_name'];
        $data['goodsData'] = [];
        $data['requestDataCfg'] = array(
            'dataType' => 'lessonData',
            'api' => 'applet_custom_lesson_data',
            'params' => "kind=".$data['goodSource']['kind']."&num=".$data['goodsNum']
        );
        $data['goodsLink'] = '/pages/course/course?id='.$data['goodSource']['kind'];
        return $data;
    }

    
    private function _goods_list_by_kind($type, $kind, $num, $goodsSort=1, $lng='', $lat=''){
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        if($type == 2){  // 平台分组
            $goods_list  = $goods_storage->getGroupGoods('look',$kind,0,$num,'',0,1);
        }elseif ($type == 3){ //商家商品
            //获取所有入驻店铺的推荐商品
            $where[] = array('name' => 'g_es_id', 'oper' => '!=', 'value' => 0);
            $where[] = array('name' => 'g_applay_goods_show', 'oper' => '=', 'value' => 1);
            if($goodsSort == 2){
                $goods_list = $goods_storage->fetchShopGoodsListByDistance($this->sid, 0, $num, '', $top = 1, array(),array(),0,0,1,$where, 0, $lng, $lat);
            }else{
                if($this->appletType == 4){
                    //抖音的做额外处理
                    $goods_list = $goods_storage->fetchShopGoodsList($this->sid, 0, $num, '', $top = 1, array(),array(),0,0,1,$where,'','','','','','','','',true);
                }else{
                    $goods_list = $goods_storage->fetchShopGoodsList($this->sid, 0, $num, '', $top = 1, array(),array(),0,0,1,$where);
                }

            }
        }elseif($type == 4){ //商家分组
            if($goodsSort == 2){
                $goods_list  = $goods_storage->getGroupGoodsByDistance('look',$kind,0,$num, '', 1,1, 0, $lng, $lat);
            }else{
                $goods_list  = $goods_storage->getGroupGoods('look',$kind,0,$num, '', 1,1);
            }
        }else{//平台分类
            $checkCommunity = $this->applet_cfg['ac_type'] == 32 ? true : false;

            $uid = plum_app_user_islogin();
            $extra_model = new App_Model_Member_MysqlMemberExtraStorage($this->sid);
            $extra = $extra_model->findUpdateExtraByMid($uid);
            $community = intval($extra['ame_se_cid']);

            $kind_model     = new App_Model_Shop_MysqlKindStorage($this->sid);
            $kindRow = $kind_model->getRowById($kind);
            if($this->sid==13312){
                Libs_Log_Logger::outputLog($kind.'------------------------------------------------');
                Libs_Log_Logger::outputLog($kindRow);
            }
            // 售罄商品排序下沉
            // zhangzc
            // 2019-03-20
            // $field = ['g_id','g_cover','g_name','g_price','g_stock','g_sold','g_show_num','g_brief','g_limit','g_show_vip','g_fake_buynum','g_had_vip_price','g_join_discount','g_ori_price'];
            $field = ['g_id','g_es_id','g_cover','g_name','g_price','g_stock','g_sold','g_show_num','g_brief','g_limit','g_show_vip','g_fake_buynum','g_had_vip_price','g_join_discount','g_ori_price','g_format_type','(case g_stock WHEN 0 THEN 0 else 1 end)'=>'stockby'];
            // $sort = array('g_weight' => 'DESC', 'g_update_time' => 'DESC', 'g_price' => 'ASC');
            $sort=['stockby'=>'DESC','g_weight' => 'DESC', 'g_update_time' => 'DESC', 'g_price' => 'ASC'];

            // 社区团购 区域管理合伙人处理逻辑
            // 根据社区找到这个社区是否有中间层的区域合伙人
            // 如果有区域合伙人的话查询数据的的时候 需要绕过顶级管理员设置的商品限购总开全
            // 判断当前商品在合伙人设置中是否限购

            $community_model=new App_Model_Sequence_MysqlSequenceCommunityStorage($this->sid);
            $has_manager=$community_model->checkCommunityHasRegionManager($community,$this->shop['s_c_id'],'asa_zone');
            if($has_manager['m_area_id']){
                //读取区域管理所有限购的商品id
                //读取商品小区限购表中该小区可以购买的商品
                //所有限购的商品--可以购买的商品= 不能购买的商品
                //不能购买的商品从现有的列表中剔除
                //社区团购 区域管理合伙人自定义添加的商品只能被自己所辖社区获取
                $where[]="(`g_region_add_by`={$has_manager['m_id']} OR `g_region_add_by`=0)"; 
                $region_model=new App_Model_Sequence_MysqlSequenceRegionGoodsStorage($this->sid);
                $limit_goods=$region_model->getAllLimitGoods($has_manager['m_area_id']);
                
                // 获取所有主管理员设置的限购的商品
                $limit_goods_main=$goods_storage->getGoodsLimited();

                $limit_goods_main_ids=array_column($limit_goods_main,'g_id');
                $limit_goods_ids=array_column($limit_goods,'asrg_goods_id');
                $limit_goods_ids=array_merge($limit_goods_ids,$limit_goods_main_ids);

                $sequence_goods_community=new App_Model_Sequence_MysqlSequenceGoodsCommunityStorage($this->sid);
                $can_buy_goods=$sequence_goods_community->getGoodsBySidCid($community);

                $diff_goods=array_diff($limit_goods_ids, array_column($can_buy_goods,'asgc_g_id')); //需要被从列表中删除的商品
                if($diff_goods)
                    $where[]=['name'=>'g_id','oper'=>'not in','value'=>$diff_goods];

            }
            $goods_list = $goods_storage->fetchShopGoodsListByKind(0,$num,$kindRow['sk_level'] == 1?$kind:0,$kindRow['sk_level'] == 2?$kind:0,1,true,$checkCommunity,$community,$field,$sort,$has_manager['m_area_id']?1:0,$where);

        }

        $data = array();
        if($goods_list){
            foreach ($goods_list as $val){
                $data[] = $this->_format_goods_details($val);
            }
        }
        return $data;
    }

    
    private function _format_goods_details($goods,$detail=false,$laid=0,$checkBargin = false){
        $startTime = microtime(true);
        if(!$laid){
            //获取正在进行中的抢购商品数组
            $act_model  = new App_Model_Limit_MysqlLimitActStorage($this->sid);
            $act_goods= $act_model->getAllRunningNotBeginActGoods(array(), 0, 0);
            foreach($act_goods as $value){
                if($goods['g_id'] == $value['lg_g_id']){
                    $laid = $value['la_id'];
                }
            }
        }
        //2018.12.5 不再处理结束的
        if($checkBargin && !$laid){
            return '';
        }
        if($goods){
            $data = array(
                'id'         => $goods['g_id'],
                'esId'       => intval($goods['g_es_id']),
                'esid'       => intval($goods['g_es_id']),
                'name'       => $goods['g_name'],
                'cover'      => isset($goods['g_cover']) ? $this->dealImagePath($goods['g_cover']) : '',
                'price'      => $goods['g_is_discuss']>0 ? '面议' : floatval($goods['g_price']),
                'weight'     => floatval($goods['g_goods_weight'])?floatval($goods['g_goods_weight']).($goods['g_goods_weight_type']==1?'g':'Kg'):0,
                'oriPrice'   => floatval($goods['g_ori_price']),
                'brief'      => isset($goods['g_brief']) ? $goods['g_brief'] : '',
                'stock'      => $goods['g_stock']<0?0:$goods['g_stock'],
                'stockShow'  => $goods['g_stock_show'],
                'sold'       => $goods['g_sold'],
                'soldShow'   => $goods['g_sold_show'],
                'expfeeShow' => intval($goods['g_expfee_show']),
                'freight'    => $goods['g_unified_fee'],
                'hasFormat'  => false,
                'islimit'    => $goods['g_limit'] > 0  ? true : false,
                'purchase'   => isset($goods['g_limit']) && $goods['g_limit'] > 0 ? $goods['g_limit'] : $goods['g_stock'],
                'purchaseNote'   => isset($goods['g_limit']) && $goods['g_limit'] > 0 ? '每人限购'.$goods['g_limit'].'件' : '',
                'isDiscuss'  => intval($goods['g_is_discuss']),
                'discussInfo'=> isset($goods['g_discuss_info']) ? $goods['g_discuss_info'] : '',
                'phone'      => $this->shop['s_phone'] ? $this->shop['s_phone'] : '',
                'showNum'    => $goods['g_show_num'],
                'showNumShow'=> $goods['g_show_num_show'],
                'listLabel'  => $goods['g_list_label'] ? $goods['g_list_label'] : '',
                'independent'=> intval($goods['g_independent_mall']),
                'distance'   => $goods['distance']
            );
            $level_model = new App_Model_Member_MysqlLevelStorage();
            $levelList = $level_model->getListBySid($this->sid);

            $uid    = plum_app_user_islogin();
            if($levelList || $goods['g_had_vip_price']){
                $vipData = App_Helper_Trade::getGoodsVipPirce($data['price'], $this->sid, $goods['g_id'], 0,$uid, 1);
                $data['isVipPrice'] = $levelList || $goods['g_had_vip_price'] || $vipData['isVipPrice'] ? 1 : 0;
                if($this->applet_cfg['ac_type'] == 6){
                    //同城多店
                    $data['vipPrice'] = $this->_get_vip_price($goods);
                }
                $data['noVipPrice'] = $data['price'];
                $data['price'] = $vipData['price'];
                $data['isVip'] = $vipData['isVip'];
            }
            $data['vipLabel'] = '会员折扣';

            if($goods['g_expfee_type'] == 2){
                $data['freight'] = '根据配送地区收取运费';
            }

            $data['label'] = array();

            $goods['g_is_global'] == 1 ? $data['label'][] = '全球购' : false;
            $goods['g_is_back'] == 1 ? $data['label'][] = '七天退换' : false;
            $goods['g_is_quality'] == 1 ? $data['label'][] = '正品保证' : false;
            $goods['g_is_truth'] == 1 ? $data['label'][] = '如实描述' : false;

            $data['newLabel'] = array();
            if(isset($goods['g_custom_label'])){
                $labelArr = preg_split("/[\s,]+/",$goods['g_custom_label']);
                foreach ($labelArr as $val){
                    if($val && isset($val)){
                        $data['newLabel'][] = $val;
                    }
                }
            }
            if($this->applet_cfg['ac_type'] == 8){
                $formatData = $this->_goods_format($goods['g_id']);
                $data['format'] = $formatData['value'];
                if(!empty($data['format']) && $data['format']){
                    $data['hasFormat'] = true;
                }

                //$data['vipPriceList'] = $this->_get_vip_price_list($data['price'], $goods['g_vip_price_list'], $formatData['value'], $data['hasFormat']);

                if($data['hasFormat']){
                    $data['isVip'] = $formatData['isVip'];
                    $data['formatValue'] = $this->_get_format_value($goods['g_id']);
                    $formatStock = 0;

                    foreach ($data['formatValue'] as $item){
                        $formatStock += $item['stock'];
                    }
                    $data['stock'] = $formatStock;
                }

                // 获取不同规格的价格
                $prices = $formatData['prices']?$formatData['prices']:[];
                //array_push($prices,$data['price']);
                $data['maxPrice'] = !empty($prices) && max($prices)>0 ? floatval(max($prices)) : 0;
                $data['minPrice'] = !empty($prices) && min($prices)>0 ? floatval(min($prices)) : 0;

                $oriPrices = $formatData['oriPrices']?$formatData['oriPrices']:[0];
                $data['maxOriPrice'] = max($oriPrices)>0 ? floatval(max($oriPrices)) : 0;
                $data['minOriPrice'] = min($oriPrices)>0 ? floatval(min($oriPrices)) : 0;

                $noVipPrices = $formatData['noVipPrice']?$formatData['noVipPrice']:[];
                //array_push($noVipPrices,$data['noVipPrice']);
                $data['maxNoVipPrice'] = !empty($noVipPrices) && max($noVipPrices)>0 ? floatval(max($noVipPrices)) : 0;
                $data['minNoVipPrice'] = !empty($noVipPrices) && min($noVipPrices)>0 ? floatval(min($noVipPrices)) : 0;

                if($data['hasFormat']){
                    $data['formatList']  = $this->_new_goods_format($goods);
                    $data['formatTypes'] = count($data['formatList']);

                    $weight = $formatData['weight']?$formatData['weight']:[];
                    $data['maxWeight'] = $weight[0];
                    $data['minWeight'] = $weight[0];
                    foreach ($weight as $val){
                        $data['maxWeight'] = $val['value'] > $data['maxWeight']['value']?$val:$data['maxWeight'];
                        $data['minWeight'] = $val['value'] < $data['minWeight']['value']?$val:$data['minWeight'];
                    }
                    if($data['minWeight']['value'] || $data['maxWeight']['value']){
                        if($data['minWeight']['value'] && $data['maxWeight']['value'] && $data['minWeight']['value'] != $data['maxWeight']['value']){
                            $data['weight'] = ($data['minWeight']['type']==1?$data['minWeight']['value'].'g':($data['minWeight']['value']/1000).'Kg').'-'.(($data['maxWeight']['type']==1?$data['maxWeight']['value'].'g':($data['maxWeight']['value']/1000).'Kg'));
                        }else{
                            $data['weight'] = $data['minWeight']['value']?(($data['minWeight']['type']==1?$data['minWeight']['value'].'g':($data['minWeight']['value']/1000).'Kg')):(($data['maxWeight']['type']==1?$data['maxWeight']['value'].'g':($data['maxWeight']['value']/1000).'Kg'));
                        }
                    }
                }

            }


            // 是否获取商品详情
            
            $data['seckill']  = 0;//是否参与秒杀活动
            if($data['minPrice'] > 0){
                $data['price'] = $data['minPrice'];
            }

            if($laid>0){
                //获取限时抢购活动
                $limit_buy  = new App_Helper_LimitBuy($this->sid);
                $limit_act  = $limit_buy->checkLimitAct($goods['g_id'],$laid);
                $data['limitStartTime'] = date('n月d日H:i', $limit_act['la_start_time']);
                $data['limitPrice'] = floatval($limit_act['lg_yh_price']);
                if($limit_act && $limit_act['status'] == App_Helper_LimitBuy::LIMIT_BUY_WAIT){
                    $data['seckill']= 2;
                    $data['limit'] = array(
                        'id'         => $limit_act['la_id'],
                        'name'       => $limit_act['la_name'],
                        'label'      => $limit_act['la_label'],
                        'img'        => $this->dealImagePath($limit_act['la_bg_img']),
                        'startTime'  => $limit_act['la_start_time'],
                        'endTime'    => $limit_act['la_end_time'],
                    );
                }

                //进行中的限时抢购活动
                if ($limit_act && $limit_act['status'] == App_Helper_LimitBuy::LIMIT_BUY_RUN) {
                    $data['seckill']  = 1;
                    //覆盖原有价格
                    $limit_price    = floatval($limit_act['lg_yh_price']);
                    $data['price']  = $limit_price;
                    $data['restriction']  = intval($limit_act['lg_limit']);
                    $data['purchase']   = $limit_act['lg_limit'] && $limit_act['lg_limit']>0 ? $limit_act['lg_limit'] : (isset($goods['g_limit']) && $goods['g_limit'] > 0 ? $goods['g_limit'] : $goods['g_stock']);
                    $data['purchaseNote']   = isset($goods['g_limit']) && $goods['g_limit'] > 0 ? '每人限购'.$goods['g_limit'].'件' : '';
                    if ($data['format']) {
                        foreach ($data['format'] as &$item) {
                            $item['price']   = $limit_price;
                        }
                        foreach ($data['formatValue'] as &$item) {
                            $item['price']   = $limit_price;
                        }
                    }
                    //单独秒杀销量
                    $data['limitSold']  = $limit_act['lg_sold']+$limit_act['lg_virtual_sold'];
                    //若单独设置秒杀数量,取设置值,否则取库存
                    $data['limitStock'] = $limit_act['lg_stock'] ? $limit_act['lg_stock'] : $goods['g_stock'];
                    if($limit_act['lg_stock']){
                        //覆盖原抢购百分比
                        $data['limitHadSale'] = (round((($limit_act['lg_sold']+$limit_act['lg_virtual_sold'])/(($data['limitStock']+$limit_act['lg_virtual_sold'])) ) * 100,2)).'%';
                    }else{
                        //覆盖原抢购百分比
                        //未设置秒杀库存  将商品销量与库存相加
                        $data['limitHadSale'] = (round((($limit_act['lg_sold']+$limit_act['lg_virtual_sold'])/(($limit_act['lg_sold'] + $data['limitStock']+$limit_act['lg_virtual_sold'])) ) * 100,2)).'%';
                    }


                    if($data['limitStock'] > 0){
                        if($data['purchaseNote']){
                            $data['purchaseNote'] = $data['purchaseNote']."，共{$data['limitStock']}件";
                        }else{
                            $data['purchaseNote'] = "共{$data['limitStock']}件";
                        }
                    }

                    $data['limit'] = array(
                        'id'         => $limit_act['la_id'],
                        'name'       => $limit_act['la_name'],
                        'label'      => $limit_act['la_label'],
                        'img'        => $this->dealImagePath($limit_act['la_bg_img']),
                        'startTime'  => $limit_act['la_start_time'],
                        'endTime'    => $limit_act['la_end_time'],
                    );
                    //if(($limit_act['lg_limit'] && $limit_act['lg_limit']>0) || ($limit_act['lg_stock'] && $limit_act['lg_stock']>0)){
                    if($limit_act['lg_stock'] && $limit_act['lg_stock']>0 && $detail){
                        // 获取已经购买过的数量
                        $record_model   = new App_Model_Limit_MysqlLimitRecordStorage($this->sid);
                        $had_buy    = $record_model->countBuyNumByActid($limit_act['lg_actid'], $goods['g_id']);
                       // if($limit_act['lg_limit'] && $limit_act['lg_limit']>0){
                       //     $data['stock'] = $limit_act['lg_limit']>=$had_buy ? ($limit_act['lg_limit']-$had_buy) : 0;
                       // }else
                        if ($limit_act['lg_stock'] && $limit_act['lg_stock']>0){
                            $data['stock'] = $limit_act['lg_stock']>=$had_buy ? ($limit_act['lg_stock']-$had_buy) : 0;
                        }
                    }

                    if($data['hasFormat'] && $data['formatValue']){
                        foreach ($data['formatValue'] as $key => $format){
                            //如果秒杀商品有规格，所有规格统一价格
                            $data['formatValue'][$key]['price'] = $limit_price;
                            if($limit_act['lg_stock']>0 && $detail){
                                //如果设置了秒杀数量，所有规格统一库存
                                $data['formatValue'][$key]['stock'] = $data['stock'];
                            }
                        }
                    }
                }

            }

            //是否是单品分销商品
            
            if($data['maxPrice']>0 && $data['minPrice']>0 && $data['maxPrice']==$data['minPrice']){
                $data['minPrice'] = 0;
                $data['maxPrice'] = 0;
            }

            $data['newPrice'] = $this->number_format_new($data['price']);
            $data['newSold'] = $this->number_format_new($data['sold']);

            return $data;
        }
        return false;
    }





    
    private function _get_vip_price_list($price, $list, $format, $hasFormat){

        $data = array();
        $level_model = new App_Model_Member_MysqlLevelStorage();

        if($hasFormat){
            $hadVipPrice = true;
            foreach ($format as $val){
                $vipPriceList = json_decode($val['vipPriceList'], true);
                if($vipPriceList){
                    foreach ($vipPriceList as $value){
                        if($value['price'] > 0){
                            $data[$value['identity']] = array(
                                'identity'  => $value['identity'],
                                'price' => $data[$value['identity']]['price']?$data[$value['identity']]['price']:array()
                            );
                            $data[$value['identity']]['price'][] = $value['price'];
                        }
                    }
                }
                if(empty($data) || !$hadVipPrice){
                    $hadVipPrice = false;
                    $level_model = new App_Model_Member_MysqlLevelStorage();
                    $level = $level_model->getListBySid($this->sid);
                    if($level){
                        foreach ($level as  $value){
                            if($value['ml_discount']){
                                $data[$value['ml_id']] = array(
                                    'identity'  => $value['ml_id'],
                                    'price' => $data[$value['ml_id']]['price']?$data[$value['ml_id']]['price']:array()
                                );
                                $data[$value['ml_id']]['price'][] = $val['price']* ($value['ml_discount']/10);
                            }
                        }
                    }
                }
            }
            if(!empty($data)){
                foreach ($data as $key => $val){
                    $level = $level_model->getRowById($val['identity']);
                    if($level){
                        $data[$key] = array(
                            'identity' => $level['ml_name'],
                            'price'    => number_format(min($val['price']), 2, ".", "").'-'.number_format(max($val['price']), 2, ".", ""),
                        );
                    }
                }
            }
        }else{
            $vipPriceList = json_decode($list, true);
            if($vipPriceList){
                foreach ($vipPriceList as $value){
                    $level = $level_model->getRowById($value['identity']);
                    if($level){
                        if($value['price'] > 0){
                            $data[$value['identity']] = array(
                                'identity'  => $level['ml_name'],
                                'price' => $value['price']
                            );
                        }
                    }
                }
            }
            if(empty($data)){
                $level_model = new App_Model_Member_MysqlLevelStorage();
                $level = $level_model->getListBySid($this->sid);
                if($level){
                    foreach ($level as  $value){
                        if($value['ml_discount']){
                            $data[$value['ml_id']] = array(
                                'identity'  => $value['ml_name'],
                                'price' => number_format( $price* ($value['ml_discount']/10), 2, ".", "")
                            );
                        }
                    }
                }
            }
        }

        return array_values($data);
    }

    
    private function _new_goods_format($goods){
        if($goods['g_format_type']){
            $spec = json_decode($goods['g_format_type'], true);
            foreach($spec as $key => $val){
                foreach($val['value'] as $k=>$v){
                    $spec[$key]['value'][$k]['fIndex'] = $key;
                    $spec[$key]['value'][$k]['checked'] = false;
                    $spec[$key]['value'][$k]['img'] = $v['img']?$this->dealImagePath($v['img']):$this->dealImagePath($goods['g_cover']);
                }
            }
            return $spec;
        }else{
            $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
            $format         = $format_model->getListByGid($goods['g_id']);
            $spec = [
                [
                    'name' => '规格',
                    'value' => []
                ]
            ];
            foreach($format as $key => $val){
                $spec[0]['value'][] = [
                    'fIndex' => 0,
                    'checked' => false,
                    'name' => $val['gf_name'],
                    'img'  => $this->dealImagePath($goods['g_cover'])
                ];
            }
            return $spec;
        }
    }

    
    private function _get_format_value($gid,$stock_only=false){
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
        $format         = $format_model->getListByGid($gid);
        $data = array();
        $uid    = plum_app_user_islogin();
        $stock=0; //库存
        foreach($format as $val){
            $vipData = App_Helper_Trade::getGoodsVipPirce($val['gf_price'], $this->sid, $gid, $val['gf_id'],$uid,1);
            $data[$val['gf_name'].$val['gf_name2'].$val['gf_name3']] = [
                'id'       => $val['gf_id'],
                'price'    => $vipData['price'],
                'oriPrice' => $vipData['isVip']>0 ? $val['gf_price'] : floatval($val['gf_ori_price']),
                'stock'    => $val['gf_stock'] < 0 ? 0 : intval($val['gf_stock'])
            ];
            $stock+=$val['gf_stock'];
        }
        if($stock_only){
            return [
                'data'      =>$data,
                'stock'     =>$stock
            ];
        }else{
            return $data;
        }
    }

    
    private function _goods_format($gid){
        //获取商品规格
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
        $format = $format_model->getListByGid($gid);
        $data = array();
        $isVip = 0;
        if($format){
            foreach ($format as $val){
                $data['value'][] = array(
                    'id'       => $val['gf_id'],
                    'name'     => $val['gf_name'],
                    'oriPrice' => floatval($val['gf_ori_price']),
                    'price'    => $val['gf_price'],
                    'sold'     => $val['gf_sold'],
                    'stock'    => $val['gf_stock'],
                    'point'    => $val['gf_send_point'],
                    'vipPriceList' => $val['gf_vip_price_list']
                );

                $uid    = plum_app_user_islogin();
                $vipData = App_Helper_Trade::getGoodsVipPirce($val['gf_price'], $this->sid, $gid, $val['gf_id'],$uid, 1);

                $data['noVipPrice'][] = $val['gf_price'];
                $data['oriPrices'][] = floatval($val['gf_ori_price']);
                $data['prices'][] = $vipData['price'];
                $data['weight'][] = array(
                    'value' => $val['gf_format_weight_type'] == 1?floatval($val['gf_format_weight']):floatval($val['gf_format_weight'] * 1000),
                    'type'  => $val['gf_format_weight_type']
                );
                if($vipData['isVip']){
                    $isVip = 1;
                }
            }
        }
        $data['isVip'] = $isVip;
        return $data;
    }


    //获取vip价的价格区间
    private function _get_vip_price($goods){
        if(!$goods['g_had_vip_price']){
            return 0;
        }else{
            $vipPrice = json_decode($goods['g_vip_price_list'], true);
            $priceArr = array();
            if(!empty($vipPrice)){
                foreach ($vipPrice as $val){
                    $priceArr[] = $val['price'];
                }
            }else{
                $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
                $format         = $format_model->getListByGid($goods['g_id']);
                foreach ($format as $row){
                    $vipPriceList = json_decode($row['gf_vip_price_list'], true);
                    foreach ($vipPriceList as $val){
                        $priceArr[] = $val['price'];
                    }
                }
            }
            $minPrice = min($priceArr);
            $maxPrice = max($priceArr);
            //return $minPrice;
            if($minPrice && $maxPrice && $minPrice != $maxPrice){
                return $minPrice.'-'.$maxPrice;
            }else{
                return $minPrice ? $minPrice : 0;
            }

        }
    }


    
    private function _get_format_info($gid){
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
        $format         = $format_model->getListByGid($gid);
        $data = array();
        $formatStock = 0;
        if($format){
            foreach($format as $val){
                $stock = $val['gf_stock'] < 0 ? 0 : intval($val['gf_stock']);
                $data[] = [
                    'id'       => $val['gf_id'],
                    'stock'    => $stock
                ];
                $formatStock += $stock;
            }
        }
        return $info = array(
            'data' => $data,
            'formatStock' => $formatStock
        );
    }

    
    private function _deal_recommend_list_data($data){
        $data['picStyle']      = intval($data['picStyle']);
        $data['singleImgNum']  = intval($data['singleImgNum']);
        $data['titleStyle']    = intval($data['titleStyle']);
        $data['isShowbrief']   = $data['isShowbrief']=='true'?true:false;
        $data['isShowmore']   = $data['isShowmore']=='true'?true:false;
        $data['imageStyle']['borderRadius'] = intval($data['imageStyle']['borderRadius']);
        $data['imageStyle']['height']  = intval($data['imageStyle']['height']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['titleCss']['fontSize']  = intval($data['titleCss']['fontSize']);
        $data['titleCss']['lineHeight']= intval($data['titleCss']['lineHeight']);
        $data['recommendType'] = $data['recommendType'] ? intval($data['recommendType']) : 1;
        $data['num'] = $data['recommendNum'] ? intval($data['recommendNum']) : 4;

        $picData = [];
        $list_url = '';
        $list_name= '';
        switch ($data['recommendType']){
            case 1://资讯
                $list_name = '推荐资讯';
                $list_url = $this->get_link_by_type(32,-99,$list_name);
                $picData = $this->_deal_recommend_information($data['num']);
                break;
            case 2:
                if($this->applet_cfg['ac_type'] == 27){
                    $list_url = '/pages/productList/productList?sourcetype=recommend&title=推荐课程';
                }elseif ($this->applet_cfg['ac_type'] == 8){
                    $list_url = '/pages/wnGoodsList/wnGoodsList?sourcetype=recommend&title=推荐商品';
                }elseif ($this->applet_cfg['ac_type'] == 6){
                    $list_url = '/subpages/wnGoodsList/wnGoodsList?sourcetype=recommend&title=推荐商品';
                }else{
                    $list_url = '/pages/allgoodsPage/allgoodsPage?sourcetype=recommend&title=推荐商品';
                }
                $picData = $this->_deal_recommend_goods($data['num']);
                break;
            case 3:
                if($this->applet_cfg['ac_type'] == 6){
                    $list_url = '/pages/searchShop/searchShop?sourcetype=recommend&title=推荐商家';
                }elseif ($this->applet_cfg['ac_type'] == 8){
                    $list_url = '/pages/flShoplist/flShoplist?sourcetype=recommend&title=推荐商家';
                }elseif ($this->applet_cfg['ac_type'] == 33){
                    $list_url = '/subpages/serviceProvider/serviceProvider?sourcetype=recommend&title=推荐服务商';
                }

                $picData = $this->_deal_recommend_shop($data['num']);
                break;
            case 4:
                if($this->applet_cfg['ac_type'] == 6){
                    $list_url = '/subpages/wnGoodsList/wnGoodsList?sourcetype=recommendEs&title=推荐商品';
                }elseif ($this->applet_cfg['ac_type'] == 8){
                    $list_url = '/pages/wnGoodsList/wnGoodsList?sourcetype=recommendEs&title=推荐商品';
                }elseif ($this->applet_cfg['ac_type'] == 33){
                    $list_url = '/subpages/sellingService/sellingService?sourcetype=recommendEs&title=推荐商品';
                }

                $picData = $this->_deal_recommend_goods($data['num'],true);
                break;

        }
        $data['picData'] = $picData;
        $data['listUrl'] = $list_url;

        return $data;


    }

    private function _deal_recommend_shop($count = 4){
        $data = [];

        if($this->applet_cfg['ac_type'] == 6){
            $data = $this->_city_recommend_shop_list($count);
        }elseif ($this->applet_cfg['ac_type'] == 8 || $this->applet_cfg['ac_type'] == 33){
            $data = $this->_recommend_enter_shop_list($count);
        }
        return $data;

    }

    
    private function _city_recommend_shop($count = 4){
        $recommend_model      = new App_Model_City_MysqlCityRecommendStorage($this->sid);
        $where     = array();
        $where[]   = array('name'=>'acr_s_id','oper'=>'=','value'=>$this->sid);
        $sort      = array('acr_sort'=>'ASC');
        $recommend = $recommend_model->fetchRecommendShowListShop($where,0,$count,$sort);
        $data = array();
        foreach($recommend as $key => $val){

            $data[] = [
                'title' => $val['acs_name'],
                'cover' => $this->dealImagePath($val['acs_cover']),
                'brief' => $val['acs_brief'] ? $val['acs_brief'] : '',
                'link'  => [
                    'type' => 20,
                    'url' => $this->get_link_by_type(20,$val['acs_id'],'')
                ]
            ];
        }
        return $data;
    }

    
    private function _recommend_enter_shop_list($count = 4){
        $es_model = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
        $sort = array('es_sort'=>'DESC','es_createtime'=>'DESC');
        $where = [];
        $data = [];
        $where[] = ['name' => 'es_s_id', 'oper' => '=', 'value' => $this->sid];
        $where[] = ['name' => 'es_deleted', 'oper' => '=', 'value' => 0];
        $where[] = ['name' => 'es_status', 'oper' => '=', 'value' => 0];
        $where[] = ['name' => 'es_handle_status', 'oper' => '=', 'value' => 2];
        $where[] = ['name' => 'es_list_show', 'oper' => '=', 'value' => 1]; //显示店铺
        $where[] = ['name' => 'es_is_recommend', 'oper' => '=', 'value' => 1];
        $where[] = ['name' => 'es_expire_time', 'oper' => '>', 'value' => time()]; //入驻未过期
        $shop = $es_model->getList($where,0,$count,$sort);
        if($this->applet_cfg['ac_type'] == 33){
            $linkType = 20;
        }else{
            $linkType = 17;
        }

        if($shop){
            foreach ($shop as $val){
                $data[] = [
                    'title' => $val['es_name'],
                    'cover' => $this->dealImagePath($val['es_logo']),
                    'brief' => $val['es_brief'] ? $val['es_brief'] : '',
                    'link'  => [
                        'type' => $linkType,
                        'url' => $this->get_link_by_type($linkType,$val['es_id'],'')
                    ]
                ];
            }
        }
        return $data;

    }

    
    private function _city_recommend_shop_list($count = 4){
        $shop_storage = new App_Model_City_MysqlCityShopStorage($this->sid);
        $sort  = array('acs_sort'=>'desc','acs_create_time' => 'DESC');
        $where = array();
        $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'acs_deleted', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'acs_is_recommend', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => 'acs_expire_time', 'oper' => '>', 'value' => time()); //入驻未过期
        $where[] = array('name' => 'acs_list_show', 'oper' => '=', 'value' => 1); //显示
        $where[] = array('name' => 'acs_status', 'oper' => '=', 'value' => 2); //审核通过
        $shop    = $shop_storage->getList($where,0,$count,$sort);
        $data = array();

        if($shop){
            foreach ($shop as $val){
                $data[] = [
                    'title' => $val['acs_name'],
                    'cover' => $this->dealImagePath($val['acs_img']),
                    'brief' => $val['acs_brief'] ? $val['acs_brief'] : '',
                    'link'  => [
                        'type' => 20,
                        'url' => $this->get_link_by_type(20,$val['acs_id'],'')
                    ]
                ];
            }
        }

        return $data;
    }

    private function _deal_recommend_information($count = 4){
        $information_model = new App_Model_Applet_MysqlAppletInformationStorage();
        $where = [];
        $data = [];
        $where[] = ['name'=>'ai_isrecommend','oper'=>'=','value'=>1];
        $where[] = ['name'=>'ai_s_id','oper'=>'=','value'=>$this->sid];
        $sort    = ['ai_sort'=>'DESC','ai_create_time' => 'DESC'];
        $list = $information_model->getList($where,0,$count,$sort);
        if($list){
            foreach ($list as $val){
                $data[] = [
                    'title' => $val['ai_title'],
                    'cover' => $this->dealImagePath($val['ai_cover']),
                    'brief' => $val['ai_brief'] ? $val['ai_brief'] : '',
                    'link'  => [
                        'type' => 1,
                        'url' => $this->get_link_by_type(1,$val['ai_id'],'')
                    ]
                ];
            }
        }
        return $data;
    }

    private function _deal_recommend_goods($count = 4,$entershop = false){
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $where = [];
        $data = [];
        $where[] = ['name'=>'g_is_top','oper'=>'=','value'=>1];
        $where[] = ['name'=>'g_s_id','oper'=>'=','value'=>$this->sid];
        if($this->applet_cfg['ac_type'] == 32){
            $where[] = ['name' => 'g_is_sale', 'oper' => 'in', 'value' => [1,3]];
        }else{
            $where[] = ['name' => 'g_is_sale', 'oper' => '=', 'value' => 1];
        }

        $where[] = ['name' => 'g_type','oper' => 'in','value' => array(1,2)];
        $where[] = ['name' => 'g_applay_goods_show','oper' => '=','value' => 1];

        $linkType = 5;
        if($entershop){
            $where[] = ['name'=>'g_es_id','oper'=>'>','value'=>0];
            $linkType = 27;
        }else{
            $where[] = ['name'=>'g_es_id','oper'=>'=','value'=>0];
        }


        $sort    = ['g_weight'=>'DESC','g_update_time' => 'DESC'];
        $list = $goods_model->getList($where,0,$count,$sort);

        if($list){
            foreach ($list as $val){
                $data[] = [
                    'title' => $val['g_name'],
                    'cover' => $this->dealImagePath($val['g_cover']),
                    'brief' => $val['g_brief'] ? $val['g_brief'] : '',
                    'link'  => [
                        'type' => $linkType,
                        'url' => $this->get_link_by_type($linkType,$val['g_id'],'')
                    ]
                ];
            }
        }
        return $data;
    }


    
    private function _deal_pictxt_data($data){
        $startTime = time();
        $data['picStyle']      = intval($data['picStyle']);
        $data['singleImgNum']  = intval($data['singleImgNum']);
        $data['titleStyle']    = intval($data['titleStyle']);
        $data['isShowbrief']   = $data['isShowbrief']=='true'?true:false;
        $data['imageStyle']['borderRadius'] = intval($data['imageStyle']['borderRadius']);
        $data['imageStyle']['height']  = intval($data['imageStyle']['height']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['titleCss']['fontSize']  = intval($data['titleCss']['fontSize']);
        $data['titleCss']['lineHeight']= intval($data['titleCss']['lineHeight']);
        foreach ($data['picData'] as $key => $val){
            $data['picData'][$key]['cover'] = $this->dealImagePath($val['cover']);
            if($val['link']['type'] == 107){
                $game_model = new App_Model_Gamebox_MysqlGameboxGameStorage($this->sid);
                $game = $game_model->getRowByIdSid($val['link']['url'],$this->sid);
                $data['picData'][$key]['link']['gameurl']  = $game['agg_url'] ? $game['agg_url'] : '';
                $data['picData'][$key]['link']['appid']    = $game['agg_appid'] ? $game['agg_appid'] : '';
                $data['picData'][$key]['link']['qrcode']   = $game['agg_qrcode'] ? $this->dealImagePath($game['agg_qrcode']) : '';
                $data['picData'][$key]['link']['jumpType'] = intval($game['agg_jump_type']);
            }else{
                $data['picData'][$key]['link']['url'] = $this->get_link_by_type($val['link']['type'], $val['link']['link']?$val['link']['link']:$val['link']['url'], $val['linkName'], $val['link']['articleTitle']);
            }
        }
        return $data;
    }

    
    private function _deal_window_data($data){
        $data['imageStyle']['borderRadius'] = intval($data['imageStyle']['borderRadius']);
        $data['imageStyle']['padding'] = intval($data['imageStyle']['padding']);
        $data['style']['height']       = intval($data['style']['height']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['style']['paddingLeft']  = intval($data['style']['paddingLeft']);
        $data['style']['paddingRight'] = intval($data['style']['paddingRight']);
        $data['style']['paddingBottom']= intval($data['style']['paddingBottom']);
        $data['style']['paddingTop']   = intval($data['style']['paddingTop']);
        $data['link1']['imageUrl']     = $this->dealImagePath($data['link1']['imageUrl']);
        $data['link2']['imageUrl']     = $this->dealImagePath($data['link2']['imageUrl']);
        $data['link3']['imageUrl']     = $this->dealImagePath($data['link3']['imageUrl']);

        if($data['link1']['type'] == 107){
            $game_model = new App_Model_Gamebox_MysqlGameboxGameStorage($this->sid);
            $game = $game_model->getRowByIdSid($data['link1']['url'],$this->sid);
            $data['link1']['gameurl']  = $game['agg_url'] ? $game['agg_url'] : '';
            $data['link1']['appid']    = $game['agg_appid'] ? $game['agg_appid'] : '';
            $data['link1']['qrcode']   = $game['agg_qrcode'] ? $this->dealImagePath($game['agg_qrcode']) : '';
            $data['link1']['jumpType'] = intval($game['agg_jump_type']);
        }else{

            $data['link1']['url'] = $this->get_link_by_type($data['link1']['type'], $data['link1']['url'], $data['link1']['name'], $data['link1']['articleTitle']);
        }
        if($data['link2']['type'] == 107){
            $game_model = new App_Model_Gamebox_MysqlGameboxGameStorage($this->sid);
            $game = $game_model->getRowByIdSid($data['link2']['url'],$this->sid);
            $data['link2']['gameurl']  = $game['agg_url'] ? $game['agg_url'] : '';
            $data['link2']['appid']    = $game['agg_appid'] ? $game['agg_appid'] : '';
            $data['link2']['qrcode']   = $game['agg_qrcode'] ? $this->dealImagePath($game['agg_qrcode']) : '';
            $data['link2']['jumpType'] = intval($game['agg_jump_type']);
        }else{
            $data['link2']['url'] = $this->get_link_by_type($data['link2']['type'], $data['link2']['url'], $data['link2']['name'], $data['link2']['articleTitle']);
        }
        if($data['link3']['type'] == 107){
            $game_model = new App_Model_Gamebox_MysqlGameboxGameStorage($this->sid);
            $game = $game_model->getRowByIdSid($data['link3']['url'],$this->sid);
            $data['link3']['gameurl']  = $game['agg_url'] ? $game['agg_url'] : '';
            $data['link3']['appid']    = $game['agg_appid'] ? $game['agg_appid'] : '';
            $data['link3']['qrcode']   = $game['agg_qrcode'] ? $this->dealImagePath($game['agg_qrcode']) : '';
            $data['link3']['jumpType'] = intval($game['agg_jump_type']);
        }else{
            $data['link3']['url'] = $this->get_link_by_type($data['link3']['type'], $data['link3']['url'], $data['link3']['name'], $data['link3']['articleTitle']);
        }
        return $data;
    }

    
    private function _deal_coupon_data($data){
        $uid = plum_app_user_islogin();
        $data['limitStyle']['fontSize'] = intval($data['limitStyle']['fontSize']);
        $data['valueStyle']['fontSize'] = intval($data['valueStyle']['fontSize']);
        $data['style']['marginBottom']  = intval($data['style']['marginBottom']);
        $data['style']['marginTop']     = intval($data['style']['marginTop']);
        $data['style']['paddingBottom'] = intval($data['style']['paddingBottom']);
        $data['style']['paddingTop']    = intval($data['style']['paddingTop']);
        $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
        $list   = array();
        $receive_model  = new App_Model_Coupon_MysqlReceiveStorage();
        $myCoupon = $receive_model->fetchCouponList($this->sid,$uid);
        if($data['getType'] == 1){//自动获取
            $coupon = $coupon_model->fetchShowValidList($this->sid,0,0, 0, 0);
            foreach ($coupon as $key => $value) {
                if($data['isShowover'] == 'false' && $value['cl_had_receive'] >= $value['cl_count']){
                    unset($coupon[$key]);
                }else{
                    $list[] = [
                        'id' => $value['cl_id'],
                        'name' => $value['cl_name'],
                        'value' => $value['cl_face_val'],
                        'limit' => $value['cl_use_limit'],
                        'count' => $value['cl_count'],
                        'receive' => $value['cl_had_receive'],
                        'desc' => $value['cl_use_desc'],
                        'start' => date('Y-m-d', $value['cl_start_time']),
                        'end' => date('Y-m-d', $value['cl_end_time']),
                        'hadReceive' => isset($myCoupon[$value['cl_id']])?1:0,



                        //统一首页中的优惠券领取组件与 领券大厅的领取规则字段
                        //zhangzc
                        //2019-07-01
                        'startLeft' => ($value['cl_start_time'] - time())>0?($value['cl_start_time'] - time()):0,
                        'needShare' => intval($value['cl_need_share']),
                        'type'      => $value['cl_use_type'],
                        'receiveLimit' => intval($value['cl_receive_limit']),
                        'newLimit'  => intval($value['cl_new_limit']),
                        'colorType' => (intval($value['cl_id']%4))+1,
                        'color'     => $color[(intval($value['cl_id']%3))+1],
                        'received'  => !empty($myCoupon) && isset($myCoupon[$value['cl_id']]) && $value['cl_receive_limit']==1 ? 1 : 0,
                        'used'      => !empty($myCoupon) && isset($myCoupon[$value['cl_id']]) && $myCoupon[$value['cl_id']]['cr_is_used']==1 ? 1 : 0,
                        'uid'       => $this->uid,
                        'shopName'  => '商家券：'.($value['es_name']?$value['es_name']:''),
                    ];
                }
            }
        }else{ //手动获取
            foreach ($data['couponData'] as $val){
                $coupon = $coupon_model->getRowById($val['id']);
                // 获取已经领取的优惠券
                if($data['isShowover'] == 'false' && $coupon['cl_had_receive'] >= $coupon['cl_count']){
//                    unset($coupon[$key]);
                }else{
                    $list[] = [
                        'id' => $coupon['cl_id'],
                        'name' => $coupon['cl_name'],
                        'value' => $coupon['cl_face_val'],
                        'limit' => $coupon['cl_use_limit'],
                        'count' => $coupon['cl_count'],
                        'receive' => $coupon['cl_had_receive'],
                        'desc' => $coupon['cl_use_desc'],
                        'start' => date('Y-m-d', $coupon['cl_start_time']),
                        'end' => date('Y-m-d', $coupon['cl_end_time']),
                        'hadReceive' => isset($myCoupon[$coupon['cl_id']])?1:0,

                        //统一首页中的优惠券领取组件与 领券大厅的领取规则字段
                        //zhangzc
                        //2019-07-01
                        'startLeft' => ($coupon['cl_start_time'] - time())>0?($coupon['cl_start_time'] - time()):0,
                        'needShare' => intval($coupon['cl_need_share']),
                        'type'      => $coupon['cl_use_type'],
                        'receiveLimit' => intval($coupon['cl_receive_limit']),
                        'newLimit'  => intval($coupon['cl_new_limit']),
                        'colorType' => (intval($coupon['cl_id']%4))+1,
                        'color'     => $color[(intval($coupon['cl_id']%3))+1],
                        'received'  => !empty($myCoupon) && isset($myCoupon[$coupon['cl_id']]) && $coupon['cl_receive_limit']==1 ? 1 : 0,
                        'used'      => !empty($myCoupon) && isset($myCoupon[$coupon['cl_id']]) && $myCoupon[$coupon['cl_id']]['cr_is_used']==1 ? 1 : 0,
                        'uid'       => $this->uid,
                        'shopName'  => '商家券：'.($coupon['es_name']?$coupon['es_name']:''),


                    ];
                }
            }
        }
        $data['couponData'] = $list;
        return $data;
    }

    
    private function _deal_group_data($data){
        $data['goodStyle']  = intval($data['goodStyle']);
        $data['priceBold']  = $data['priceBold']=='true'?true:false;
        $data['isShowmore'] = $data['isShowmore']=='true'?true:false;
        $data['priceStyle']['fontSize']= intval($data['priceStyle']['fontSize']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['titleStyle']['fontSize']= intval($data['titleStyle']['fontSize']);
        $list = array();

        //applet_custom_group_data只用到了拼团活动的id，所以只取出id 避免goodsData过长
        //dn 2019.07.17
        $goods_data_new = [];
        foreach ($data['goodsData'] as $goods){
            $goods_data_new[] = [
                'id' => $goods['id']
            ];
        }
        $data['goodsData'] = $goods_data_new;

        $data['requestDataCfg'] = array(
            'dataType' => 'goodsData',
            'api' => 'applet_custom_group_data',
            'params' => "getType=".$data['getType']."&goodsNum=".$data['goodsNum']."&goodsData=".json_encode($data['goodsData'])
        );



        $data['goodsData'] = $list;
        return $data;
    }

    
    private function _deal_seckill_data($data){
        $data['goodStyle']  = intval($data['goodStyle']);
        $data['priceBold']  = $data['priceBold']=='true'?true:false;
        $data['isShowmore'] = $data['isShowmore']=='true'?true:false;
        $data['priceStyle']['fontSize']= intval($data['priceStyle']['fontSize']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['titleStyle']['fontSize']= intval($data['titleStyle']['fontSize']);
        $goodsData = array();
        if($data['getType']==2){
            foreach ($data['goodsData'] as $val){
                $goodsData[] = array(
                    'id' => $val['id']
                );
            }
        }else{
            $goodsData = $data['goodsData'];
        }

        if($data['goodStyle'] == 5){
            $api = 'applet_custom_seckill_activity_data';
            $params = "goodsNum=".$data['goodsNum'];
        }else{
            $api = 'applet_custom_seckill_data';
            $params = "getType=".$data['getType']."&goodsNum=".$data['goodsNum']."&goodsData=".json_encode($goodsData);
        }

        $data['requestDataCfg'] = array(
            'dataType' => 'goodsData',
            'api' => $api,
            'params' => $params
        );
        $list = array();

        $data['goodsData'] = $list;
        return $data;
    }

    
    private function _deal_bargain_data($data){
        $uid = plum_app_user_islogin();
        $data['goodStyle']  = intval($data['goodStyle']);
        $data['priceBold']  = $data['priceBold']=='true'?true:false;
        $data['isShowmore'] = $data['isShowmore']=='true'?true:false;
        $data['priceStyle']['fontSize']= intval($data['priceStyle']['fontSize']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['titleStyle']['fontSize']= intval($data['titleStyle']['fontSize']);
        $data['requestDataCfg'] = array(
            'dataType' => 'goodsData',
            'api' => 'applet_custom_bargain_data',
            'params' => "getType=".$data['getType']."&goodsNum=".$data['goodsNum']."&goodsData=".json_encode($data['goodsData'])
        );
        $list = array();
        $data['goodsData'] = $list;
        return $data;
    }

    
    private function _deal_points_data($data){
        $data['goodStyle']  = intval($data['goodStyle']);
        $data['priceBold']  = $data['priceBold']=='true'?true:false;
        $data['isShowmore'] = $data['isShowmore']=='true'?true:false;
        $data['priceStyle']['fontSize']= intval($data['priceStyle']['fontSize']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['titleStyle']['fontSize']= intval($data['titleStyle']['fontSize']);
        $data['requestDataCfg'] = array(
            'dataType' => 'goodsData',
            'api' => 'applet_custom_points_data',
            'params' => "getType=".$data['getType']."&goodsNum=".$data['goodsNum']."&goodsData=".json_encode($data['goodsData'])
        );
        $list = array();

        $data['goodsData'] = $list;
        return $data;
    }

    private function _deal_advertisement_data($data){
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        return $data;
    }

    private function _deal_shoplist_data($data){
        $lng    = $this->request->getStrParam('lng');
        $lat    = $this->request->getStrParam('lat');
        $cityId = $this->request->getIntParam('cityId');
        $data['isShowCate']  = $data['isShowCate']=='true'?true:false;
        $data['isShowmore']  = $data['isShowmore']=='true'?true:false;
        $data['isShowLabel'] = $data['isShowLabel']=='true'?true:false;
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['titleStyle']['fontSize']= intval($data['titleStyle']['fontSize']);
        $data['sortBy'] = 'nearby';
        $data['noMoretip'] = false;

        $data['requestDataCfg'] = array(
            'dataType' => 'shopData',
            'api' => 'applet_custom_shop_data',
            'params' => "lng=".$lng."&lat=".$lat."&cityId=".$cityId."&getType=".$data['getType']."&shopNum=".$data['shopNum']."&shopData=".json_encode($data['shopData'])
        );

        $list = array();
        $data['shopData'] = $list;
        return $data;
    }

    private function _get_shop_activity_list($esId){
        // 判断店铺当前营销活动
        $activityList = array();
        //优惠券
        if($esId > 0){
            $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
            $coupon = $coupon_model->fetchValidList($this->sid,0,1, array(), $esId);
            if($coupon){
                $activityList[] = array(
                    'type'  => 1,
                    'title' => $coupon[0]['cl_name']
                );
            }
            //秒杀
            $act_model  = new App_Model_Limit_MysqlLimitActStorage($this->sid);
            $limit = $act_model->getAllRunningAct($esId);
            if($limit){
                $activityList[] = array(
                    'type'  => 2,
                    'title' => $limit[0]['la_name']
                );
            }
            //拼团
            $group_model  = new App_Model_Group_MysqlBuyStorage($this->sid);
            $group = $group_model->getCurrentListByType(1,0,1,0,'', $esId);
            if($group){
                $activityList[] = array(
                    'type'  => 3,
                    'title' => $group[0]['g_name']
                );
            }
            //砍价
            $timeNow = time();
            $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($this->sid);
            $where[] = array('name'=>'ba_s_id','oper'=>'=','value'=> $this->sid);
            $where[] = array('name'=>'ba_es_id','oper'=>'=','value'=> $esId);
            $where[] = array('name'=>'ba_deleted','oper'=>'=','value'=> 0);
            $where[] = array('name'=>'ba_start_time','oper'=>'<','value'=> $timeNow);
            $where[] = array('name'=>'ba_end_time','oper'=>'>','value'=> $timeNow);
            $bargain = $bargain_model->getActivityList($where,0,1,array());
            if($bargain){
                $activityList[] = array(
                    'type'  => 4,
                    'title' => $bargain[0]['g_name']
                );
            }
        }

        return $activityList;
    }

    private function _deal_statistic_data($data){
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['browseShow']    = $data['browseShow']=='true'?true:false;
        $data['issueShow']     = $data['issueShow']=='true'?true:false;
        $data['memberShow']    = $data['memberShow']=='true'?true:false;
        $data['shopShow']      = $data['shopShow']=='true'?true:false;
        $data['companyShow']   = $data['companyShow']=='true'?true:false;
        $data['positionShow']  = $data['positionShow']=='true'?true:false;
        $data['resumeShow']    = $data['resumeShow']=='true'?true:false;
        $data['browseShow']    = $data['browseShow']=='true'?true:false;

        if($this->applet_cfg['ac_type'] != 28){
            if($this->applet_cfg['ac_type'] == 6){
                $index_storage = new App_Model_City_MysqlCityIndexStorage($this->sid);
                $tpl   = $index_storage->findUpdateBySid(23);
            }else{
                $tpl_model = new App_Model_Community_MysqlCommunityIndexStorage($this->sid);
                $tpl = $tpl_model->findUpdateBySid(35);
            }
            $data['statIcon']    = $tpl['aci_stat_icon'] ? $this->dealImagePath($tpl['aci_stat_icon']) : $this->dealImagePath('/public/wxapp/customtpl/images/icon_tj.png');
            $data['browseNum']   = $tpl['aci_browse_num']?$this->number_format($tpl['aci_browse_num']):0;
            $data['issueNum']    = $tpl['aci_issue_num']?$this->number_format($tpl['aci_issue_num']):0;
            $data['shopNum']     = $tpl['aci_shop_num']?$this->number_format($tpl['aci_shop_num']):0;
            $data['memberNum']   = $tpl['aci_add_member']?$this->_get_member_count($tpl['aci_add_member']):$this->_get_member_count(0);
        }else{
            $tpl_model = new App_Model_Job_MysqlJobIndexStorage($this->sid);
            $tpl  = $tpl_model->findUpdateBySid(61);

            $stat = $this->_get_job_stat();
            $companyNum = $stat['company'] + intval($tpl['aji_company_num']);
            $positionNum = $stat['position'] + intval($tpl['aji_position_num']);
            $resumeNum = $stat['resume'] + intval($tpl['aji_resume_num']);
            $browseNum = intval($tpl['aji_browse_num']);
            $data['statIcon']    = $tpl['aji_stat_icon'] ? $this->dealImagePath($tpl['aji_stat_icon']) : $this->dealImagePath('/public/wxapp/customtpl/images/icon_tj.png');
            $data['companyNum']  = $this->number_format($companyNum);
            $data['positionNum'] = $this->number_format($positionNum);
            $data['resumeNum'] = $this->number_format($resumeNum);
            $data['browseNum'] = $this->number_format($browseNum);
        }

        return $data;
    }

    
    private function _get_job_stat(){

        //公司数量
        $company_model = new App_Model_Job_MysqlJobCompanyStorage($this->sid);
        $where_company[] = ['name' => 'ajc_s_id', 'oper' => '=', 'value' => $this->sid];
        $where_company[] = ['name' => 'ajc_status', 'oper' => '=', 'value' => 2];
        $company_total = $company_model->getCount($where_company);

        $position_model = new App_Model_Job_MysqlJobPositionStorage($this->sid);
        $where_position[] = ['name' => 'ajp_s_id', 'oper' => '=', 'value' => $this->sid];
        $position_total = $position_model->getCount($where_position);

        $resume_model = new App_Model_Job_MysqlJobResumeStorage($this->sid);
        $where_resume[] = ['name' => 'ajr_s_id', 'oper' => '=', 'value' => $this->sid];
        $resume_total = $resume_model->getCount($where_resume);

        $info = [
            'company' => $company_total ? intval($company_total) : 0,
            'position' => $position_total ? intval($position_total) : 0,
            'resume' => $resume_total ? intval($resume_total) : 0,
        ];

        return $info;
    }

    
    private function _deal_meal_activity_data($data){
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);

        $activity_storage = new App_Model_Meal_MysqlMealFullActivityStorage($this->sid);
        $list = $activity_storage->findListBySid();

        $activity = array();
        $fullName = '';
        $fullData = array();
        foreach ($list as $key => $value) {
            if($value['amf_type'] == 1){
                $fullName .= $value['amf_name'].',';
                $fullData[] = array(
                    'id'   => $value['amf_id'],
                    'limit'=> $value['amf_limit'],
                    'value'=> $value['amf_value']
                );
                unset($list[$key]);
            }else{
                $activity[] = array(
                    'id'   => $value['amf_id'],
                    'type' => $value['amf_type'],
                    'name' => $value['amf_name'],
                    'limit'=> $value['amf_limit'],
                    'value'=> $value['amf_value']
                );
            }
        }
        $fullName = rtrim($fullName, ",");
        if($activity){
            array_unshift($activity, array('type' => 1, 'name' => $fullName, 'fullData' => $fullData));
        }

        $data['activityData'] = $activity;

        return $data;
    }

    private function _deal_carlist_data($data){
        $lng    = $this->request->getStrParam('lng');
        $lat    = $this->request->getStrParam('lat');
        $town = $this->request->getIntParam('town');
        $data['isShowMile']  = $data['isShowMile']=='true'?true:false;
        $data['isShowmore']  = $data['isShowmore']=='true'?true:false;
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['titleStyle']['fontSize']= intval($data['titleStyle']['fontSize']);
        $data['priceStyle']['fontSize']= intval($data['titleStyle']['fontSize']);
        $shop_model = new App_Model_Car_MysqlCarResourceStorage($this->sid);
        $list = array();
        if($data['getType'] == 1){//自动获取
            $where = array();
            $where[] = array('name' => 'acr_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[] = array('name' => 'acr_deleted', 'oper' => '=', 'value' => 0); //未删除
            $where[] = array('name' => 'acr_status', 'oper' => '=', 'value' => 0); //未封禁
            if($town){
                $where[] = array('name' => 'acr_town', 'oper' => '=', 'value' => $town);
            }
//            if($lng && $lat){
//                $sort = array('acr_is_top'=>'DESC','acr_top_expire'=>'DESC','distance' => 'asc', 'acr_create_time' => 'desc');
//                $shopList = $shop_model->getResourceListDistance($lng,$lat,$where,0,$data['carNum'],$sort);
//            }else{
//                $sort = array('acr_is_top'=>'DESC','acr_top_expire'=>'DESC','acr_create_time' => 'desc');
//                $shopList = $shop_model->getResourceList($where,0,$data['carNum'],$sort);
//            }
            $sort = array('acr_is_top'=>'DESC','acr_top_expire'=>'DESC','acr_create_time' => 'desc');
            $shopList = $shop_model->getResourceList($where,0,$data['carNum'],$sort);

            foreach ($shopList as $val) {
                $list[] = array(
                    'id' => $val['acr_id'],
                    'mid' => $val['acr_m_id'],
                    'isMy' => $val['acr_m_id'] == $this->member['m_id'] ? 1 : 0 ,
                    'distance'   => isset($val['distance']) ? ($val['distance']<1 ? floor(1000*$val['distance']).'m' : round($val['distance'],2).'km' ): 0,
                    'name' => strstr($val['ct_name'],$val['cb_name']) ? $val['ct_name'] : $val['cb_name'].' '.$val['ct_name'],
                    'carType' => $val['acr_car_type'],
                    'carBrand' => $val['acr_car_brand'],
                    'mobile' => $val['acr_phone'],
                    'verify' => $val['acr_es_id'] > 0 ? 1 : 0,
                    'price' => $val['acr_price'] > 0 ? $val['acr_price'].'万' : '价格面议',
                    'mile' => $val['acr_mile'].'万公里',
                    'licenseTime' => date('Y-m-d',$val['acr_license_time']),
                    'address' => $val['acr_address'] ? $val['acr_address'] : '',
                    'lng' => $val['acr_lng'],
                    'lat' => $val['acr_lat'],
                    'isTop' => intval($val['acr_is_top']),
                    'videoUrl' => $val['acr_video'] ? $val['acr_video'] : '',
                    'videoKey' => $val['acr_video_key'] ? $val['acr_video_key'] : '',
                    'collectNum' => intval($val['acr_collect_num']),
                    'time' => $this->_format_date($val['acr_create_time'],'list'),
                    'label' => $val['acr_label'] ? $this->_format_label($val['acr_label']) : [],
                    'cover' => $this->dealImagePath($val['acr_cover']),
                );
            }
        }else{ //手动添加
            foreach ($data['carData'] as $val){
                $shop = $shop_model->getResourceRowDistance($val['id'], $lng,$lat);
                if($shop){
                    $list[] = array(
                        'id' => $shop['acr_id'],
                        'mid' => $shop['acr_m_id'],
                        'isMy' => $shop['acr_m_id'] == $this->member['m_id'] ? 1 : 0 ,
                        'distance'   => isset($shop['distance']) ? ($shop['distance']<1 ? floor(1000*$shop['distance']).'m' : round($shop['distance'],2).'km' ): 0,
                        'name' => strstr($val['ct_name'],$val['cb_name']) ? $val['ct_name'] : $val['cb_name'].' '.$val['ct_name'],
                        'carType' => $shop['acr_car_type'],
                        'carBrand' => $shop['acr_car_brand'],
                        'mobile' => $shop['acr_phone'],
                        'verify' => $shop['acr_es_id'] > 0 ? 1 : 0,
                        'price' => $shop['acr_price'] > 0 ? $shop['acr_price'].'万' : '价格面议',
                        'mile' => $shop['acr_mile'].'万公里',
                        'licenseTime' => date('Y-m-d',$shop['acr_license_time']),
                        'address' => $shop['acr_address'] ? $shop['acr_address'] : '',
                        'lng' => $shop['acr_lng'],
                        'lat' => $shop['acr_lat'],
                        'isTop' => intval($shop['acr_is_top']),
                        'videoUrl' => $shop['acr_video'] ? $shop['acr_video'] : '',
                        'videoKey' => $shop['acr_video_key'] ? $shop['acr_video_key'] : '',
                        'collectNum' => intval($shop['acr_collect_num']),
                        'time' => $this->_format_date($shop['acr_create_time'],'list'),
                        'label' => $shop['acr_label'] ? $this->_format_label($shop['acr_label']) : [],
                        'cover' => $this->dealImagePath($shop['acri_path']),
                    );
                }
            }
        }

        $data['carData'] = $list;
        return $data;
    }

    private function _deal_cate_goods_data($data, $indexBottom){
        $data['priceBold']  = $data['priceBold']=='true'?true:false;
        $data['isShowNum']  = $data['isShowNum']=='true'?true:false;
        $data['goodsStyle'] = $data['styleType'] ? intval($data['styleType']) : 1;
        $data['priceStyle']['fontSize']= intval($data['priceStyle']['fontSize']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['titleStyle']['fontSize']= intval($data['titleStyle']['fontSize']);
        $data['pageCount'] = $data['goodsNum'] == 0 ? 30 :intval($data['goodsNum']);
        $data['indexBottom'] = $data['goodsStyle'] == 3 ? 0 : $indexBottom;//是否为首页最底部
        $data['isShowmore'] = $data['isShowmore']=='true'?true:false;

        $category_model = new App_Model_Shop_MysqlKindStorage($this->sid);
        if($data['cateType'] == 1){
            $categoryList   = $category_model->getAllFirstCategory(0,200,true);
        }else{
            $data['cateType'] = 2;//防止没选
            $categoryList   = $category_model->getAllSonCategorySortAsc(0,200,true);
        }
        if($data['showRecommend'] == 'true'){
            $recommend_arr = [
                'sk_id' => -1,
                'sk_name' => $data['recommendTitle'] ? $data['recommendTitle'] : '推荐'
            ];
            array_unshift($categoryList,$recommend_arr);
        }

        $uid = plum_app_user_islogin();
        $new_member = App_Helper_Sequence::checkNewMember($uid,$this->sid);
        //至少设置了一件新人专享商品且未下架
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $where_goods[] = ['name' => 'g_s_id', 'oper' => '=', 'value' => $this->sid];
        $where_goods[] = ['name'=>'g_has_window','oper'=>'=','value'=>2];
        $where_goods[] = ['name'=>'g_is_sale','oper'=>'=','value'=>1];
        $where_goods[] = ['name'=>'g_applay_goods_show','oper'=>'=','value'=>1];
        $new_member_goods = $goods_model->getRow($where_goods);
        if($new_member && $new_member_goods){
            $newMemberArr = [
                'sk_id' => -2,
                'sk_name' => '新人专享'
            ];
            array_unshift($categoryList,$newMemberArr);
        }
        $categoryList = array_values($categoryList);

        $data['requestDataCfg'] = array(
            'dataType' => 'categoods',
            'api' => 'applet_custom_tpl_categoods',
            'params' => "cateType=".$data['cateType']."&goodsNum=".$data['pageCount']."&id=".$categoryList[0]['sk_id']
        );

        $data['goodsList'] = array();

        if($this->applet_cfg['ac_base'] >= 40 && $this->applet_cfg['ac_type'] == 32){
            foreach($categoryList as $key => $val){
                if($val['sk_name']){
                    if(count($data['goodsList']) == 0){
                        $data['goodsList'][] = array(
                            'id' => $val['sk_id'],
                            'name' => $val['sk_name'],
                            'hasGoods' => false,
                            'goods' => []
                        );
                        $data['categoods'] = [];
                        $data['curSort'] = $val['sk_id'];
                    }else{
                        $data['goodsList'][] = array(
                            'id' => $val['sk_id'],
                            'name' => $val['sk_name'],
                            'hasGoods' => false,
                            'goods' => [],
                        );
                    }
                }
            }
        }else{
            foreach($categoryList as $key => $val){
                if($val['sk_name']){
                    if(count($data['goodsList']) == 0){
                        $data['categoods'] = [];
                        $data['curSort'] = $val['sk_id'];
                    }
                    $data['goodsList'][] = array(
                        'id' => $val['sk_id'],
                        'name' => $val['sk_name'],
                        'hasGoods' => false,
                        'goods' => [],
                    );
                }

            }
        }

        return $data;
    }

    private function _deal_catelist_data($data){
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['style']['fontSize']     = intval($data['style']['fontSize']);
        $data['fixed']  = $data['fixed']=='true'?true:false;
        $category_model = new App_Model_Shop_MysqlKindStorage($this->sid);
        if($data['cateType'] == 1){
            $categoryList   = $category_model->getAllFirstCategory(0,200,true);
        }else{
            $data['cateType'] = 2;//防止没选
            $categoryList   = $category_model->getAllSonCategorySortAsc(0,200,true);
        }

        $data['cateList'] = array();
        foreach($categoryList as $key => $val){
            if($val['sk_name']){
                $data['cateList'][] = array(
                    'id' => $val['sk_id'],
                    'name' => $val['sk_name'],
                );
            }
        }
        return $data;
    }

    private function _deal_sequence_activity_data($data){
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['titleStyle']['fontSize']= intval($data['titleStyle']['fontSize']);

        $data['requestDataCfg'] = array(
            'dataType' => 'goodsList',
            'api' => 'applet_custom_activity_data',
            'params' => "goodsNum=".$data['goodsNum'],
        );

        $data['goodsList'] = array();

        return $data;
    }

    
    private function _format_activity($val,$imgCount = 3){
        if($val){
//            $timeNow = time();
            $statusNote = array(
                2 => '未开始',
                1 => '已结束',
                3 => '进行中'
            );
//            if($val['asa_start'] > $timeNow){
//                $status = 2;
//            }elseif ($val['asa_end'] < $timeNow){
//                $status = 1;
//            }else{
//                $status = 3;
//            }

            if($this->applet_cfg['ac_base'] < 28){
                $status = $val['status'];
                $statusDesc = $statusNote[$val['status']];
            }else{
                $status = 3;
                $statusDesc = '';
            }

            $data = array(
                'id' => $val['asa_id'],
                'title' => $val['asa_title'],
                'desc' => $val['asa_desc'] ? $val['asa_desc'] : '',
                'avatar' => $val['asa_avatar'] ? $this->dealImagePath($val['asa_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
                'nickname' => $val['asa_nickname'] ? $val['asa_nickname'] : '匿名',
                'mobile' => $val['asa_mobile'] ? $val['asa_mobile'] : '',
                'time' => $this->_format_date($val['asa_create_time'],'list'),
                'join' => $val['asa_join_num'],
                'img'  => $this->_get_activity_img($val['asa_id'],$imgCount),
                'status' => $status,
                'statusNote' => $statusDesc,
                'showNum' => intval($val['asa_show_num'])
            );

            //获得参与人的信息数组和纯头像数组
            if($this->applet_cfg['ac_base'] >= 28){
                $tradeInfo = $this->_get_activity_trade_new($val['asa_id']);
            }else{
                $tradeInfo = $this->_get_activity_trade($val['asa_id']);
            }

            $data['memberList'] = $tradeInfo['data'];
            $data['avatars'] = $tradeInfo['avatars'];


            return $data;
        }
        return false;
    }

    
    private function _get_activity_trade_new($id,$index = 0,$count = 10){
        $join_model = new App_Model_Sequence_MysqlSequenceActivityJoinStorage($this->sid);
        $where = [];
        $data = [];
        $avatars = [];
        $where[] = array('name'=>'asaj_s_id','oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'asaj_a_id','oper'=>'=','value'=>$id);
        $sort = array('asaj_create_time' => 'DESC');
        $list = $join_model->getJoinMemberList($where,$index,$count,$sort);
        //Libs_Log_Logger::outputLog($list);
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'avatar' => $val['m_avatar'] ? $this->dealImagePath($val['m_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
                    'nickname' => $val['m_nickname'],
                    'mid'      => $val['m_id']
                );
                $avatars[] = $val['m_avatar'] ? $this->dealImagePath($val['m_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png');
            }
        }
        $info['data'] = $data;
        $info['avatars'] = $avatars;
        return $info;
    }

    
    private function _get_activity_trade($id,$index = 0,$count = 10){
        $activity_model = new App_Model_Sequence_MysqlSequenceActivityStorage($this->sid);
        $where = [];
        $data = [];
        $avatars = [];
        $where[] = array('name'=>'asa_s_id','oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'asa_id','oper'=>'=','value'=>$id);
        $sort = array('t_create_time' => 'DESC');
        $list = $activity_model->getActivityGroupTradeMemberList($where,$index,$count,$sort);
        //Libs_Log_Logger::outputLog($list);
        if($list){
            foreach ($list as $val){
                if($val['t_id'] > 0){
                    $data[] = array(
                        'avatar' => $val['m_avatar'] ? $this->dealImagePath($val['m_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
                        'nickname' => $val['m_nickname'],
                        'mid'      => $val['m_id']
                    );
                    $avatars[] = $val['m_avatar'] ? $this->dealImagePath($val['m_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png');
                }
            }
        }
        $info['data'] = $data;
        $info['avatars'] = $avatars;
        return $info;
    }

    
    private function _get_activity_img($id,$count = 0){
        $data = array();
        $asai_model = new App_Model_Sequence_MysqlSequenceActivityImgStorage($this->sid);
        $list = $asai_model->fetchImgList($id,$count);
        if($list){
            foreach ($list as $val){
                $data[] = $this->dealImagePath($val['asai_path']);
            }
        }
        return $data;
    }

    
    private function _get_cart_list(){
        $uid = plum_app_user_islogin();
        $where = [];
        $where[] = array('name'=>'sc_s_id','oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'sc_m_id','oper'=>'=','value'=>$uid);
        $cart_model = new App_Model_Shop_MysqlShopCartStorage($this->sid);
        $cart_list = $cart_model->getGoodsFormat($where,0,0,array('sc_add_time'=>'DESC'));
        $dataGid = [];
        foreach ($cart_list as $val){
            $dataGid[$val['sc_g_id']] = array(
                'id' => $val['sc_id'],
                'gid' => $val['sc_g_id'],
                'name' => $val['g_name'],
                'price' => $val['g_price'],
                'num'  => $val['sc_num']
            );
        }
        $info['data'] = array_values($dataGid);
        $info['dataGid'] = $dataGid;
        return $info;
    }

    
    private function _get_sequence_goods_by_kind($kind, $num,$cartList = array(),$cateType=2){
        $good_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        //获得当前用户选择的小区
        $uid = plum_app_user_islogin();
        $extra_model = new App_Model_Member_MysqlMemberExtraStorage($this->sid);
        $extra = $extra_model->findUpdateExtraByMid($uid);
        $community = intval($extra['ame_se_cid']);
        $field = ['g_id','g_cover','g_name','g_price','g_stock','g_sold','g_show_num','g_brief','g_limit','g_show_vip','g_fake_buynum','g_had_vip_price','g_join_discount','g_ori_price'];
        if($kind < 0){
            $sort = array('g_weight' => 'DESC', 'g_update_time' => 'DESC', 'g_price' => 'ASC');
            $goods = $good_model->fetchShopGoodsList($this->sid, 0, $num, '', 1, $sort,$field,0,0,1,[],0,true,true,$community);
        }else{
            if($cateType==1){
                $goods = $good_model->fetchShopGoodsListByKind(0, $num, $kind, 0,true,true,false,$community,$field);
            }else{
                $goods = $good_model->fetchShopGoodsListByKind(0, $num, 0, $kind,true,true,false,$community,$field);
            }
        }
        $data = array();
        $data_sold = [];
        $data_soldout = [];

        foreach($goods as $val){
            $row = $this->_format_sequence_goods($val,false,$cartList,0,true);
            if($row['stock'] > 0){
                $data_sold[] = $row;
            }else{
                $data_soldout[] = $row;
            }
        }
        $data = array_merge($data_sold,$data_soldout);

        return $data;
    }


    
    private function _format_sequence_goods($val,$isDetail = false,$cartList = array(),$laid = 0,$changeFormatPrice = false){
        if($val){
            if(!$laid){
                //获取正在进行中的抢购商品数组
                $act_model  = new App_Model_Limit_MysqlLimitActStorage($this->sid);
                $act_goods= $act_model->getAllRunningGoodsAct();
                foreach($act_goods as $value){
                    if($val['g_id'] == $value['lg_g_id']){
                        $laid = $value['la_id'];
                    }
                }
            }

            $goods_redis = new App_Model_Goods_RedisGoodsStorage($this->sid);
            $upTtl = $goods_redis->getGoodsSaleUpTtl($val['g_id']);
            $downTtl = $goods_redis->getGoodsSaleDownTtl($val['g_id']);
            $timeNow = time();

            $cover = $this->dealImagePath($val['g_cover']);
            $data = array(
                'id' => $val['g_id'],
                'name' => $val['g_name'],
                'cover' => $cover,
                'price' => floatval($val['g_price']),
                'oldPrice' => floatval($val['g_ori_price']),
                'stock' => intval($val['g_stock']),
                'sold'  => intval($val['g_sold']),
                'showNume' => intval($val['g_show_num']),
                'hasFormat'  => false,
                'slide' => $this->_get_sequence_goods_slide($val['g_id'],$cover),
                'brief' => $val['g_brief'] ? $val['g_brief'] : '',
                'purchase'   => isset($val['g_limit']) && $val['g_limit'] > 0 ? $val['g_limit'] : $val['g_stock'],
                'purchaseNote'   => isset($val['g_limit']) && $val['g_limit'] > 0 ? '每人限购'.$val['g_limit'].'件' : '',
                'seckill' => 0,
                'laid' => $laid,
                'showVipList'=> $val['g_show_vip'],
                'isPresell' => $upTtl > 0 ? 1 : 0,
                'upTime' => intval($upTtl),
                'downTime' => intval($downTtl),
                'upTimeDate' => $upTtl > 0 ? date('m/d',($timeNow+$upTtl)) : '',
                'downTimeDate' => $downTtl > 0 ? date('m/d',($timeNow+$downTtl)) : '',
            );

            $memberInfo = $this->_get_goods_member($val['g_id']);
            $data['avatars'] = $memberInfo['data'];
            $data['memberCount'] = $memberInfo['count'] + intval($val['g_fake_buynum']);

            //会员价---
            $uid = plum_app_user_islogin();
            $vipData = App_Helper_Trade::getGoodsVipPirce($data['price'], $this->sid, $val['g_id'], 0,$uid, 1);

            $data['noVipPrice'] = $data['price'];
            $data['price'] = $vipData['price'];
            $data['isVip'] = $vipData['isVip'];

            $level_model = new App_Model_Member_MysqlLevelStorage();
            $levelList = $level_model->getListBySid($this->sid);
            $data['isVipPrice'] = ($levelList && ($val['g_had_vip_price'] || $val['g_join_discount'])) || $vipData['isVipPrice'] ? 1 : 0;
            $data['vipLabel'] = '会员折扣';
            //---


            $formatData = $this->_goods_format($val['g_id']);
            $data['format'] = $formatData['value'] ? $formatData['value'] : '';
            if(!empty($data['format']) && $data['format']){
                $data['hasFormat'] = true;
            }

            $data['vipPriceList'] = $this->_get_vip_price_list($data['price'], $val['g_vip_price_list'], $formatData['value'], $data['hasFormat']);

            if($data['hasFormat']){
                $data['isVip'] = $formatData['isVip'];
                $format_data = $this->_get_format_value($val['g_id'],true);
                $data['formatValue'] = $format_data['data'];
                $formatStock = $format_data['stock'];
//                $formatStock = 0;
//
//                foreach ($data['formatValue'] as $item){
//                    $formatStock += $item['stock'];
//                }
                $data['stock'] = $formatStock;
            }

            // 获取不同规格的价格
            $prices = $formatData['prices']?$formatData['prices']:[];
            //array_push($prices,$data['price']);
            $data['maxPrice'] = !empty($prices) && max($prices)>0 ? floatval(max($prices)) : 0;
            $data['minPrice'] = !empty($prices) && min($prices)>0 ? floatval(min($prices)) : 0;

            $oriPrices = $formatData['oriPrices']?$formatData['oriPrices']:[0];
            $data['maxOriPrice'] = max($oriPrices)>0 ? floatval(max($oriPrices)) : 0;
            $data['minOriPrice'] = min($oriPrices)>0 ? floatval(min($oriPrices)) : 0;

            $noVipPrices = $formatData['noVipPrice']?$formatData['noVipPrice']:[];
            //array_push($noVipPrices,$data['noVipPrice']);
            $data['maxNoVipPrice'] = !empty($noVipPrices) && max($noVipPrices)>0 ? floatval(max($noVipPrices)) : 0;
            $data['minNoVipPrice'] = !empty($noVipPrices) && min($noVipPrices)>0 ? floatval(min($noVipPrices)) : 0;

            //如果有购物车列表
            if($cartList){
                $data['num'] = $cartList[$val['g_id']]['num'] ? intval($cartList[$val['g_id']]['num']) : 0;
            }else{
                $data['num'] = 0;
            }


            if($isDetail){//活动中的商品详情
//                $data['groupTime'] = date('Y-m-d',$val['asa_start']).'——'.date('Y-m-d',$val['asa_end']);
//                $data['receiveTime'] = date('Y-m-d',$val['asa_receive_start']).'——'.date('Y-m-d',$val['asa_receive_end']);
//                $data['groupStart'] = intval($val['asa_start']);
//                $data['groupEnd'] = intval($val['asa_end']);
//                $data['receiveStart'] = intval($val['asa_receive_start']);
//                $data['receiveEnd'] = intval($val['asa_receive_end']);
                $data['detail'] = plum_parse_img_path_new($val['g_detail']);


            }
            if($data['hasFormat']){
                $data['formatList']  = $this->_new_goods_format($val);
                $data['formatTypes'] = count($data['formatList']);
                $data['formatTypes'] = $data['formatTypes'] >=2 ? 2 : $data['formatTypes'];
                //将formatList中的value价格更新
                if($changeFormatPrice && $data['formatTypes'] == 1){
                    foreach ($data['format'] as $format_key => $format_row){
                        $data['format'][$format_key]['price'] = $data['formatValue'][$format_row['name']]['price'];
                    }
                }

                $weight = $formatData['weight']?$formatData['weight']:[];
                $data['maxWeight'] = $weight[0];
                $data['minWeight'] = $weight[0];
                foreach ($weight as $weight_row){
                    $data['maxWeight'] = $weight_row['value'] > $data['maxWeight']['value']?$weight_row:$data['maxWeight'];
                    $data['minWeight'] = $weight_row['value'] < $data['minWeight']['value']?$weight_row:$data['minWeight'];
                }
                if($data['minWeight']['value'] || $data['maxWeight']['value']){
                    if($data['minWeight']['value'] && $data['maxWeight']['value'] && $data['minWeight']['value'] != $data['maxWeight']['value']){
                        $data['weight'] = ($data['minWeight']['type']==1?$data['minWeight']['value'].'g':($data['minWeight']['value']/1000).'Kg').'-'.(($data['maxWeight']['type']==1?$data['maxWeight']['value'].'g':($data['maxWeight']['value']/1000).'Kg'));
                    }else{
                        $data['weight'] = $data['minWeight']['value']?(($data['minWeight']['type']==1?$data['minWeight']['value'].'g':($data['minWeight']['value']/1000).'Kg')):(($data['maxWeight']['type']==1?$data['maxWeight']['value'].'g':($data['maxWeight']['value']/1000).'Kg'));
                    }
                }
            }
            $data['seckill'] = 0;
            if($data['minPrice'] > 0){
                $data['price'] = $data['minPrice'];
            }

            if($laid>0){
                //获取限时抢购活动
                $limit_buy  = new App_Helper_LimitBuy($this->sid);
                $limit_act  = $limit_buy->checkLimitAct($val['g_id'],$laid);

                //进行中的限时抢购活动
                if ($limit_act && $limit_act['status'] == App_Helper_LimitBuy::LIMIT_BUY_RUN) {
                    $data['seckill']  = 1;
                    //覆盖原有价格
                    $limit_price    = floatval($limit_act['lg_yh_price']);
                    $data['price']  = $limit_price;
                    $data['restriction']  = intval($limit_act['lg_limit']);
                    $data['purchase']   = $limit_act['lg_limit'] && $limit_act['lg_limit']>0 ? $limit_act['lg_limit'] : (isset($val['g_limit']) && $val['g_limit'] > 0 ? $val['g_limit'] : $val['g_stock']);
                    $data['purchaseNote']   = isset($val['g_limit']) && $val['g_limit'] > 0 ? '每人限购'.$val['g_limit'].'件' : '';
                    if ($data['format']) {
                        foreach ($data['format'] as &$item) {
                            $item['price']   = $limit_price;
                        }
                        foreach ($data['formatValue'] as &$item) {
                            $item['price']   = $limit_price;
                        }
                    }
                    //若单独设置秒杀数量,取设置值,否则取库存
                    $data['limitStock'] = $limit_act['lg_stock'] ? $limit_act['lg_stock'] : $val['g_stock'];

                    if($data['limitStock'] > 0){
                        if($data['purchaseNote']){
                            $data['purchaseNote'] = $data['purchaseNote']."，共{$data['limitStock']}件";
                        }else{
                            $data['purchaseNote'] = "共{$data['limitStock']}件";
                        }
                    }

                    $data['limit'] = array(
                        'id'         => $limit_act['la_id'],
                        'name'       => $limit_act['la_name'],
                        'label'      => $limit_act['la_label'],
                        'img'        => $this->dealImagePath($limit_act['la_bg_img']),
                        'startTime'  => $limit_act['la_start_time'],
                        'endTime'    => $limit_act['la_end_time'],
                    );
                    //if(($limit_act['lg_limit'] && $limit_act['lg_limit']>0) || ($limit_act['lg_stock'] && $limit_act['lg_stock']>0)){
                    if($limit_act['lg_stock'] && $limit_act['lg_stock']>0 && $isDetail){
                        // 获取已经购买过的数量
                        $record_model   = new App_Model_Limit_MysqlLimitRecordStorage($this->sid);
                        $had_buy    = $record_model->countBuyNumByActid($limit_act['lg_actid'], $val['g_id']);
//                        if($limit_act['lg_limit'] && $limit_act['lg_limit']>0){
//                            $data['stock'] = $limit_act['lg_limit']>=$had_buy ? ($limit_act['lg_limit']-$had_buy) : 0;
//                        }else
                        if ($limit_act['lg_stock'] && $limit_act['lg_stock']>0){
                            $data['stock'] = $limit_act['lg_stock']>=$had_buy ? ($limit_act['lg_stock']-$had_buy) : 0;
                        }
                    }

                    if($data['hasFormat'] && $data['formatValue']){
                        $limit_format_model = new App_Model_Limit_MysqlLimitGoodsFormatStorage();
                        $prices = [$data['price']];
                        foreach ($data['formatValue'] as $key => $format){
                            //如果秒杀商品有规格，所有规格统一价格
//                            $data['formatValue'][$key]['price'] = $limit_price;
//                            if($limit_act['lg_stock']>0){
//                                //如果设置了秒杀数量，所有规格统一库存
//                                $data['formatValue'][$key]['stock'] = $data['stock'];
//                            }
                            $actFormat = $limit_format_model->getRowByActIdGfid($data['limit']['id'], $format['id']);
                            $data['formatValue'][$key]['price'] = $actFormat?$actFormat['lgf_yh_price']:$limit_price;
                            $data['formatValue'][$key]['stock'] = $actFormat?($actFormat['lgf_stock'] > 0 ? $actFormat['lgf_stock'] : $data['formatValue'][$key]['stock']):$data['formatValue'][$key]['stock'];
                            // 获取不同规格的价格
                            $prices[] = $data['formatValue'][$key]['price']?$data['formatValue'][$key]['price']:0;
                        }
                        //array_push($prices,$data['price']);
                        $data['maxPrice'] = !empty($prices) && max($prices)>0 ? floatval(max($prices)) : 0;
                        $data['minPrice'] = !empty($prices) && min($prices)>0 ? floatval(min($prices)) : 0;
                    }
                }

            }

            return $data;
        }
        return false;
    }

    
    private function _get_goods_member($gid){
        $sort = ['to_create_time' => 'DESC'];
        $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        $memberList = $order_model->getGoodsMemberByGid($gid,0,10,$sort);
        $data = [];
        if($memberList){
            foreach ($memberList as $val){
                $data[] = $val['m_avatar'] ? $this->dealImagePath($val['m_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png');
            }
        }
        //$count = $order_model->getGoodsMemberCountByGid($gid);
        $count = $order_model->getGoodsMemberCountByGidNew($gid);
        $info = [
            'data' => $data,
            'count' => $count ? intval($count) : 0
        ];

        return $info;
    }



    
    private function _get_sequence_goods_slide($gid,$cover){
        $slide_model = new App_Model_Goods_MysqlGoodsSlideStorage($this->sid);
        $list = $slide_model->getListByGidSid($gid,$this->sid);
        $data = [];
        if($list){
            foreach ($list as $val){
                $data[] = $this->dealImagePath($val['gs_path']);
            }
        }else{
            $data[] = $cover;
        }
        return $data;
    }

    
    private function _format_date($createTime,$type = 'list'){
        if($type == 'list'){
            $now = time();
            $res = $now - $createTime;

            switch ($res){
                case $res < 60:
                    $date = '1分钟前';
                    break;
                case (60 <= $res && $res < 3600):
                    $date = floor($res/60).'分钟前';
                    break;
                case (3600 <=$res && $res < 86400) :
                    $date = floor($res/3600).'小时前';
                    break;
                case (86400 <= $res && $res < 86400*2) :
                    $date = '昨天';
                    break;
                default:
                    //$date = date('m',$createTime).'月'.date('d',$createTime).'　'.date('H:i',$createTime);
                    $date = date('m',$createTime).'-'.date('d',$createTime);
            }

        }else{
            $date = date('m',$createTime).'-'.date('d',$createTime);
        }
        return $date;
    }

    private function _format_label($label){
        $data = [];
        $labelArr = preg_split("/[\s,]+/",$label);
        foreach ($labelArr as $val){
            if($val && isset($val)){
                $data[] = $val;
            }
        }
        return $data;
    }

    
    private function _get_member_count($num){
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $count = $member_model->getMemberCount($this->sid);
        $count += $num;
        $count = $this->number_format($count);
        return $count;
    }

    
    private function _deal_gamelist_data($data){
        $data['isShowmore']  = $data['isShowmore']=='true'?true:false;
        $data['isShowLabel'] = $data['isShowLabel']=='true'?true:false;
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['titleStyle']['fontSize']= intval($data['titleStyle']['fontSize']);
        $data['gamesLink'] = '/pages/gameList/gameList?id='.$data['goodSource'].'&title=';
        $data['gamesData'] = $this->_get_game_with_category($data['goodSource'], $data['goodsNum']);
        return $data;
    }

    
    private function _get_game_with_category($cid, $num){
        $data = array();
        $link_model = new App_Model_Gamebox_MysqlGameboxCategoryLinkStorage($this->sid);
        $where[] = array('name' => 'agcl_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'agcl_c_id', 'oper' => '=', 'value' => $cid);
        $list = $link_model->getGameList($where,0,$num,array('agg_sort'=>'DESC'));
        if($list){
            foreach ($list as $val){
                $data[] = $this->_format_game($val);
            }
        }
        return $data;
    }

    private function _format_game($val){
        if($val){
            $data = array(
                'id'    => $val['agg_id'],
                'jumpType' => $val['agg_jump_type'],
                'name'  => $val['agg_name'],
                'cover' => $val['agg_cover'] ? $this->dealImagePath($val['agg_cover']) : $this->dealImagePath('/public/manage/img/zhanwei/zw_fxb_200_200.png'),
                'appid' => $val['agg_appid'] ? $val['agg_appid'] : '',
                'url'   => $val['agg_url'] ? $val['agg_url'] : '',
                'brief' => $val['agg_brief']?$val['agg_brief']:'',
                'score' => $val['agg_score']?$val['agg_score']:'9.9',
                'qrcode' => $val['agg_qrcode'] ? $this->dealImagePath($val['agg_qrcode']) : '',
                'num'   => $val['agg_num'] > 0 ? $this->number_format_new($val['agg_num']) : '',
                //'extra' => ['chid'=>'1966','subchid' => 'qimi_a856147f6b36ca9'],
                'cate'  => $val['agc_name'],
                'gamePath' => '',
                'extra' => $this->_get_game_extra($val)
            );
            return $data;
        }
        return false;
    }

    
    private function _get_game_extra($row){
        $data = array();
        $extraArr = json_decode($row['agg_extra'],1);
        $keysArr = array();
        $valuesArr = array();
        if(is_array($extraArr) && !empty($extraArr)){
            foreach ($extraArr as $val){
                if($val['name'] && $val['val']){
                    $keysArr[] = $val['name'];
                    $valuesArr[] = $val['val'];
                }
            }
            $data = array_combine($keysArr,$valuesArr);
        }
        return $data;

    }

    private function _deal_storelist_data($data){
        $lng    = $this->request->getStrParam('lng');
        $lat    = $this->request->getStrParam('lat');
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['titleStyle']['fontSize']= intval($data['titleStyle']['fontSize']);

        $shop_model = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
        $list = array();
        if($data['getType'] == 1){//自动获取
            $where = array();
            $where[] = array('name' => 'es_expire_time', 'oper' => '>', 'value' => time());
            $where[] = array('name' => 'es_deleted', 'oper' => '=', 'value' => 0); //未删除
            $where[] = array('name' => 'es_status', 'oper' => '=', 'value' => 0);
            $sort = array('es_hand_close'=>'ASC','es_sort'=>'desc','distance' => 'asc', 'es_createtime' => 'desc');
            $shopList = $shop_model->getMealListByDistance($where, 0,0, $sort,$lng,$lat);
            foreach ($shopList as $val) {
                $isOpen = 0;
                if($val['es_hand_close'] == 0){
                    if(isset($val['openStatus'])){
                        $isOpen = $val['openStatus'] == 1 ? 1 : 0;
                    }else{

                        $timeNow = time();
                        //判断是否营业
                        $openTime = strtotime($val['ams_open_time']);
                        $closeTime = strtotime($val['ams_close_time']);
                        if($openTime >= $closeTime){
                            //$closeTime = $closeTime + 86400;
                            //获得当天0点时间戳
                            $timeStep_0 = strtotime(date('Y-m-d',$timeNow));
                            //获得当天24点时间戳
                            $timeStep_24 = strtotime(date('Y-m-d',$timeNow)) + 86399;
                            if(($openTime <= $timeNow && $timeNow <= $timeStep_24) || ($timeStep_0 <= $timeNow) && $timeNow <= $closeTime){
                                $isOpen = 1;
                            }
                        }else{
                            if($openTime<  $timeNow && $closeTime >  $timeNow){
                                $isOpen = 1;
                            }
                        }
                    }
                }
                $list[] = array(
                    'esId'    => intval($val['ams_es_id']),
                    'name'    => $val['es_name'],
                    'logo'    => $this->dealImagePath($val['es_logo']),
                    'isOpen'  => $isOpen,
                    'address' => $val['ams_address'],
                    'lat'     => $val['ams_lat'],
                    'lng'     => $val['ams_lng'],
                    'distance' => isset($val['distance']) ? ($val['distance']<1 ? floor(1000*$val['distance']).'米' : round($val['distance'],2).'公里' ): 0,
                );
            }
        }else{ //手动添加
            foreach ($data['shopData'] as $val){
                $shop = $shop_model->getRowDistanceById($val['id'], $lng,$lat);
                $isOpen = 0;
                if($shop['es_hand_close'] == 0){
                    if(isset($shop['openStatus'])){
                        $isOpen = $shop['openStatus'] == 1 ? 1 : 0;
                    }else{

                        $timeNow = time();
                        //判断是否营业
                        $openTime = strtotime($shop['ams_open_time']);
                        $closeTime = strtotime($shop['ams_close_time']);
                        if($openTime >= $closeTime){
                            //$closeTime = $closeTime + 86400;
                            //获得当天0点时间戳
                            $timeStep_0 = strtotime(date('Y-m-d',$timeNow));
                            //获得当天24点时间戳
                            $timeStep_24 = strtotime(date('Y-m-d',$timeNow)) + 86399;
                            if(($openTime <= $timeNow && $timeNow <= $timeStep_24) || ($timeStep_0 <= $timeNow) && $timeNow <= $closeTime){
                                $isOpen = 1;
                            }
                        }else{
                            if($openTime<  $timeNow && $closeTime >  $timeNow){
                                $isOpen = 1;
                            }
                        }
                    }
                }
                $list[] = array(
                    'esId'    => intval($shop['ams_es_id']),
                    'name'    => $shop['es_name'],
                    'logo'    => $this->dealImagePath($shop['es_logo']),
                    'isOpen'  => $isOpen,
                    'address' => $shop['ams_address'],
                    'lat'     => $shop['ams_lat'],
                    'lng'     => $shop['ams_lng'],
                    'distance' => isset($shop['distance']) ? ($shop['distance']<1 ? floor(1000*$shop['distance']).'米' : round($shop['distance'],2).'公里' ): 0,
                );
            }
        }


        $data['shopData'] = $list;
        return $data;
    }

    private function _deal_hotelstorelist_data($data){
        $lng    = $this->request->getStrParam('lng');
        $lat    = $this->request->getStrParam('lat');
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['titleStyle']['fontSize']= intval($data['titleStyle']['fontSize']);

        $store_model    = new App_Model_Hotel_MysqlHotelStoreStorage($this->sid);
        $list = array();
        if($data['getType'] == 1){//自动获取
            //列表数据
            $storeList = $store_model->fetchListOrderLimitLocation($lat, $lng, $data['shopNum']);
            foreach ($storeList as $val) {
                $comment_model  = new App_Model_Goods_MysqlCommentStorage($this->sid);
                $count   = $comment_model->getStoreCommentCount($val['ahs_id']);
                $total   = $comment_model->getStoreScoreTotal($val['ahs_id']);
                $score   = $count>0 ? (intval($total['total'])/intval($count)) :5;
                $scoreDesc = array(1 => '很差', 2 => '一般', 3 => '满意', 4 => '非常满意', 5 => '无可挑剔');
                $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
                $minPrice = $goods_model->getHotelMinPrice($val['ahs_id']);
                $list[] = array(
                    'id'      => $val['ahs_id'],
                    'name'    => $val['ahs_name'],
                    'avatar'  => $this->dealImagePath($val['ahs_avatar']),
                    'score'   => number_format($score,1),
                    'scoreDesc'=> $scoreDesc[round($score)],
                    'commentNum' => $count,
                    'zone'    => $val['ahs_zone'],
                    'address' => $val['ahs_address'],
                    'lat'     => $val['ahs_lat'],
                    'lng'     => $val['ahs_lng'],
                    'minPrice'=> $minPrice['minprice']?$minPrice['minprice']:0,
                    'distance' => isset($val['distance']) ? ($val['distance']<1 ? floor(1000*$val['distance']).'米' : round($val['distance'],2).'公里' ): 0,
                );
            }
        }else{ //手动添加
            $ids = array();
            foreach ($data['storeData'] as $val){
                $ids[] = $val['id'];
            }
            $storeList = $store_model->fetchListOrderLimitLocation($lat, $lng, $data['shopNum'], $ids);
            foreach ($storeList as $val) {
                $comment_model  = new App_Model_Goods_MysqlCommentStorage($this->sid);
                $count   = $comment_model->getStoreCommentCount($val['ahs_id']);
                $total   = $comment_model->getStoreScoreTotal($val['ahs_id']);
                $score   = $count>0 ? (intval($total['total'])/intval($count)) :5;
                $scoreDesc = array(1 => '很差', 2 => '一般', 3 => '满意', 4 => '非常满意', 5 => '无可挑剔');
                $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
                $minPrice = $goods_model->getHotelMinPrice($val['ahs_id']);
                $list[] = array(
                    'id'      => $val['ahs_id'],
                    'name'    => $val['ahs_name'],
                    'avatar'  => $this->dealImagePath($val['ahs_avatar']),
                    'score'   => number_format($score,1),
                    'scoreDesc'=> $scoreDesc[round($score)],
                    'commentNum' => $count,
                    'zone'    => $val['ahs_zone'],
                    'address' => $val['ahs_address'],
                    'lat'     => $val['ahs_lat'],
                    'lng'     => $val['ahs_lng'],
                    'minPrice'=> $minPrice['minprice']?$minPrice['minprice']:0,
                    'distance' => isset($val['distance']) ? ($val['distance']<1 ? floor(1000*$val['distance']).'米' : round($val['distance'],2).'公里' ): 0,
                );
            }
        }


        $data['storeData'] = $list;
        return $data;
    }


    private function _deal_courselist_data($data){
        $data['goodStyle']  = intval($data['goodStyle']);
        $data['isShowcart'] = $data['isShowcart']=='true'?true:false;
        $data['isShowsold'] = $data['isShowsold']=='true'?true:false;
        $data['priceBold']  = $data['priceBold']=='true'?true:false;
        $data['isShowmore'] = $data['isShowmore']=='true'?true:false;
        $data['priceStyle']['fontSize']= intval($data['priceStyle']['fontSize']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['titleStyle']['fontSize']= intval($data['titleStyle']['fontSize']);
        $kind_model     = new App_Model_Shop_MysqlKindStorage($this->sid);
        $kind = $kind_model->getRowById($data['goodSource']['kind']);
        $data['sourceName'] = $kind['sk_name'];
        $data['goodsData'] = $this->_course_list_by_kind($data['goodSource']['url'], $data['goodSource']['kind'], $data['goodsNum']);
        $data['goodsLink'] = '/pages/productList/productList?type='.$data['goodSource']['url'].'&name='.$data['sourceName'];
        if($data['goodSource']['kind'] > 0){
            $data['goodsLink'] .= '&id='.$data['goodSource']['kind'];
        }
        return $data;
    }

    
    private function _course_list_by_kind($kind, $goodsKind, $num){
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $where[]    = array('name' => 'g_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => 1);
        $where[]    = array('name' => 'g_knowledge_pay_type', 'oper' => '=', 'value' => $kind);
        $where[]    = array('name' => 'g_type','oper' => 'in','value' => array(1,2));
        $where[]    = array('name' => 'g_independent_mall','oper' => '=','value' => 0);
        $kind_model     = new App_Model_Shop_MysqlKindStorage($this->sid);
        $kindRow = $kind_model->getRowById($goodsKind);

        if(intval($goodsKind) > 0 && $kindRow['sk_level'] == 1){
            $where[]    = array('name' => 'g_kind1', 'oper' => '=', 'value' => $goodsKind);
        }

        if(intval($goodsKind) > 0 && $kindRow['sk_level'] == 2){
            $where[]    = array('name' => 'g_kind2', 'oper' => '=', 'value' => $goodsKind);
        }

        $sort       =  array('g_weight'=>'DESC','g_update_time' => 'DESC');

        $goods_list = $goods_storage->getList($where, 0, $num, $sort);
        $data = array();
        if($goods_list){
            foreach ($goods_list as $val){
                $data[] = $this->_format_course_details($val);
            }
        }
        return $data;
    }

    
    private function _format_course_details($goods,$detail=false,$laid=0){
        $uid = plum_app_user_islogin();
        if(!$laid){
            //获取正在进行中的抢购商品数组
            $act_model  = new App_Model_Limit_MysqlLimitActStorage($this->sid);
            $act_goods= $act_model->getAllRunningGoodsAct();
            foreach($act_goods as $value){
                if($goods['g_id'] == $value['lg_g_id']){
                    $laid = $value['la_id'];
                }
            }
        }
        $tpl_model = new App_Model_Knowpay_MysqlKnowpayIndexStorage($this->sid);
        $tpl  = $tpl_model->findUpdateBySid(59);
        if($goods){
            $data = array(
                'id'         => $goods['g_id'],
                'name'       => $goods['g_name'],
                'cover'      => isset($goods['g_cover']) ? $this->dealImagePath($goods['g_cover']) : '',
                'price'      => floatval($goods['g_price']),
                'points'     => $goods['g_points'],
                'weight'     => floatval($goods['g_goods_weight']),
                'oriPrice'   => floatval($goods['g_ori_price']),
                'brief'      => isset($goods['g_brief']) ? $goods['g_brief'] : '',
                'stock'      => $goods['g_stock'],
                'stockShow'  => $goods['g_stock_show'],
                'sold'       => $goods['g_sold'],
                'soldShow'   => $goods['g_sold_show'],
                'freight'    => $goods['g_unified_fee'],
                'totalNum'   => $goods['g_knowledge_total'],
                'author'     => $goods['g_label'],
                'type'       => $goods['g_knowledge_pay_type'],
                'isNew'      => $goods['g_special'],
                'isPoint'    => ($goods['g_type'] == 4 || $goods['g_type'] == 5)?1:0,
            );

            switch ($goods['g_knowledge_pay_type']){
                case 1:
                    if($tpl['aki_article_cover_type'] == 2){
                        $data['cover'] = isset($goods['g_cover1']) ? $this->dealImagePath($goods['g_cover1']) : '';
                    }
                    $data['coverType'] = $tpl['aki_article_cover_type'];
                    break;
                case 2:
                    if($tpl['aki_audio_cover_type'] == 2){
                        $data['cover'] = isset($goods['g_cover1']) ? $this->dealImagePath($goods['g_cover1']) : '';
                    }
                    $data['coverType'] = $tpl['aki_audio_cover_type'];
                    break;
                case 3:
                    if($tpl['aki_video_cover_type'] == 1){
                        $data['cover'] = isset($goods['g_cover1']) ? $this->dealImagePath($goods['g_cover1']) : '';
                    }
                    $data['coverType'] = $tpl['aki_video_cover_type'];
                    break;
            }

            $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
            $hadBuy = $order_model->getTradeByGid($goods['g_id'],$uid);
            $data['hadBuy'] = $hadBuy?1:0;
            $knowpay_model = new App_Model_Knowpay_MysqlKnowpayKnowledgeStorage($this->sid);
            $data['updateNum'] = $knowpay_model->getKnowledgeCountByGid($goods['g_id']);

            $data['readNum'] = $knowpay_model->getReadNumByGid($goods['g_id']);

            $comment_model = new App_Model_Knowpay_MysqlKnowpayCommentStorage($this->sid);
            $where = array();
            $where[] = array('name' => 'akc_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[] = array('name' => 'akc_c_id', 'oper' => '=', 'value' => 0);
            $where[] = array('name' => 'akc_g_id', 'oper' => '=', 'value' => $goods['g_id']);
            $data['commentCount'] = $comment_model->getCount($where);

            $uid    = plum_app_user_islogin();
            $vipData = App_Helper_Trade::getKnowpayGoodsVipPirce($data['price'], $this->sid, $goods['g_id'], 0,$uid, 1);
            $data['price'] = $vipData['price'];
            $data['isVip'] = $vipData['isVip'];

            $level_model = new App_Model_Member_MysqlLevelStorage();
            $levelList = $level_model->getListBySid($this->sid);
            $data['isVipPrice'] = $levelList || $goods['g_had_vip_price'] || $vipData['isVipPrice'] ? 1 : 0;
            $data['vipLabel'] = '会员折扣';
            $data['vipPrice'] = $goods['g_had_vip_price']?json_decode($goods['g_vip_price_list'], true)[0]['price']:$vipData['price'];

            //显示已学习的课程数量
            $study_model = new App_Model_Knowpay_MysqlKnowpayStudyStorage($this->sid);
            $where = array();
            $where[] = array('name' => 'aks_m_id', 'oper' => '=', 'value' => $uid);
            $where[] = array('name' => 'aks_s_id', 'oper' => '=', 'value' => $this->sid);
            $studyList = $study_model->getList($where);
            foreach ($studyList as $value){
                foreach (json_decode($value['aks_knowledge_ids'], true) as $val){
                    $hadRead[] = $val;
                }
            }

            $data['hadReadNum'] = $knowpay_model->getKnowledgeCountByGid($goods['g_id'], $hadRead);

            $data['label'] = array();
            if(isset($goods['g_custom_label'])){
                $labelArr = preg_split("/[\s,]+/",$goods['g_custom_label']);
                foreach ($labelArr as $val){
                    if($val && isset($val)){
                        $data['label'][] = $val;
                    }
                }
            }
            // 是否获取商品详情
            if($detail){
                $data['detail'] = plum_parse_img_path_new($goods['g_detail']);
            }
            $data['seckill']  = 0;//是否参与秒杀活动
            if($laid>0){
                //获取限时抢购活动
                $limit_buy  = new App_Helper_LimitBuy($this->sid);
                $limit_act  = $limit_buy->checkLimitAct($goods['g_id'],$laid);
                //进行中的限时抢购活动
                if ($limit_act && $limit_act['status'] == App_Helper_LimitBuy::LIMIT_BUY_RUN) {
                    $data['seckill']  = 1;
                    //覆盖原有价格
                    $limit_price    = floatval($limit_act['lg_yh_price']);
                    $data['oriPrice'] = floatval($goods['g_price']);
                    $data['price']  = $limit_price;
                    $data['restriction']  = intval($limit_act['lg_limit']);
                    if ($data['format']) {
                        foreach ($data['format'] as &$item) {
                            $item['price']   = $limit_price;
                        }
                    }
                    //单独秒杀销量
                    $data['limitSold']  = $limit_act['lg_sold'];
                    //若单独设置秒杀数量,取设置值,否则取库存
                    $data['limitStock'] = $limit_act['lg_stock'] ? $limit_act['lg_stock'] : $goods['g_stock'];
                    //覆盖原抢购百分比
                    $data['limitHadSale'] = (round($limit_act['lg_sold']/($limit_act['lg_sold']+$data['limitStock']),2)*100).'%';
                    $data['limit'] = array(
                        'id'         => $limit_act['la_id'],
                        'name'       => $limit_act['la_name'],
                        'label'      => $limit_act['la_label'],
                        'img'        => $this->dealImagePath($limit_act['la_bg_img']),
                        'startTime'  => $limit_act['la_start_time'],
                        'endTime'    => $limit_act['la_end_time'],
                    );
                }

            }
            return $data;
        }
        return false;
    }

    private function _deal_quotation_list_data($data){
        $data['isShowmore'] = $data['isShowmore']=='true'?true:false;
        $data['fontStyle']['fontSize']= intval($data['fontStyle']['fontSize']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);

        $quotation_model = new App_Model_Knowpay_MysqlKnowpayClassicalQuotationsStorage($this->sid);
        $where[] = array('name' => 'kcq_s_id', 'oper' => '=', 'value' => $this->sid);
        $sort = array('kcq_create_time'=>'desc');
        //$list = $quotation_model->getQuotationMemberList($where,0,$data['quotationNum'],$sort);
        $quota = $quotation_model->getRowById($data['quotationId']);
        $list[] = $quota;
        $quotaData = array();
        foreach($list as $row){
            $quotaData[] = array(
                'id' => $row['kcq_id'],
                'content' => $row['kcq_content'] ? $row['kcq_content'] : '',
                'cover' => $row['kcq_cover'] ? $this->dealImagePath($row['kcq_cover']) : '',
                'likeNum' => intval($row['kcq_like_num']),
                'commentNum' => intval($row['kcq_comment_num']),
                'isLike'  => $this->_quotation_like($row['kcq_id'])
            );
        }
        $data['quotationData'] = $quotaData;
        return $data;
    }

    
    public function _quotation_like($pid){
        $uid = plum_app_user_islogin();
        $num = 0;
        $like_model = new App_Model_Knowpay_MysqlKnowpayQuotationLikeStorage($this->sid);
        $row = $like_model->getLikeByMidQid($uid,$pid);
        if($row){
            $num = 1;
        }
        return $num;
    }

    
    private function _lesson_list_by_kind($kind, $num){
        $data = [];
        $num = $num > 0 ? $num : 4;
        $course_model = new App_Model_Train_MysqlTrainCourseStorage($this->sid);
        $where = [];
        $where[] = ['name'=>'atc_s_id','oper'=>'=','value'=>$this->sid];
        if($kind){
            $where[] = ['name'=>'atc_type_id','oper'=>'=','value'=>$kind];
        }
        $sort = ['atc_create_time' => 'DESC'];
        $course_list = $course_model->getList($where,0,$num,$sort);
        if($course_list){
            foreach ($course_list as $value){
                $data[] = $this->_format_lesson($value);

            }
        }


        return $data;
    }

    private function _format_lesson($value,$isDetail = false,$laid = 0){
        if($value){
            $limit_price = '';
            $seckill = 0;
            $isVip = 0;
            $isVipPrice = 0;
            $act_model  = new App_Model_Limit_MysqlLimitActStorage($this->sid);
            $act_goods= $act_model->getAllRunningGoodsAct();
            foreach($act_goods as $val){
                if($value['atc_id'] == $val['lg_g_id']){
                    $laid = $val['la_id'];
                }
            }
            $limit_stock = 0;
            $limit_had_sale = '';
            $limit_price = 0;
            if($laid>0){
                //获取限时抢购活动
                $limit_buy  = new App_Helper_LimitBuy($this->sid);
                $limit_act  = $limit_buy->checkLimitAct($value['atc_id'],$laid);
                $limit_price = floatval($limit_act['lg_yh_price']);
                //进行中的限时抢购活动
                if ($limit_act && $limit_act['status'] == App_Helper_LimitBuy::LIMIT_BUY_RUN) {
                    $seckill  = 1;
                    //覆盖原有价格
                    $limit_stock = $limit_act['lg_stock'];
                    $limit_had_sale = (round((($limit_act['lg_sold']+$limit_act['lg_virtual_sold'])/(($limit_stock+$limit_act['lg_virtual_sold'])) ) * 100,2)).'%';
                }

                if($limit_act && $limit_act['status'] == App_Helper_LimitBuy::LIMIT_BUY_WAIT){
                    $seckill = 2;
                    //覆盖原有价格
                    $limit_stock = $limit_act['lg_stock'];
                }

            }

            if($limit_price && is_numeric($limit_price)){
                $priceSign = 1;
            } elseif(is_numeric($value['atc_price']) || is_float($value['atc_price'])){
                $uid = plum_app_user_islogin();
                $vipInfo = App_Helper_Trade::getTrainCourseVipPirce($value['atc_price'],$this->sid,$value['atc_id'],0,$uid,true);
                $isVip = $vipInfo['isVip'];
                $isVipPrice = $vipInfo['isVipPrice'];
                $value['atc_price'] = $vipInfo['price'];
                $priceSign = 1;
            }else{
                $priceSign = 0;
            }

            $data = [
                'img'   => $this->dealImagePath($value['atc_cover']),
                'title' => $value['atc_title'],
                'brief' => isset($value['atc_brief']) ? $value['atc_brief'] : '',
                'price' => $limit_price ? $limit_price : ($value['atc_price'] ? $value['atc_price'] :''),
                'id'    => $value['atc_id'],
                'hour'  => $value['atc_hour'] ? $value['atc_hour'].'课时': '', //课时
                'time'  => $value['atc_start_time'] && $value['atc_end_time'] ? ($this->sid == 10380 ? date('Y.m.d',$value['atc_start_time']).'~'.date('Y.m.d',$value['atc_end_time']) : date('m.d',$value['atc_start_time']).'~'.date('m.d',$value['atc_end_time'])) : '', //起止时间
                'priceSign' => $priceSign,
                'apply'  => $value['atc_apply'],
                'laid'   => $laid,
                'seckill'=> $seckill,
                'isVip' => $isVip,
                'isVipPrice' => $isVipPrice,
                'listLabel' => $value['atc_list_label'] ? $value['atc_list_label'] : '',
                'limitStartTime' => $limit_act['la_start_time'] ? date('n月d日H:i', $limit_act['la_start_time']) : '',
                'limitHadSale' => $limit_had_sale,
                'limitStock' => $limit_stock,
                'limitPrice' => $limit_price
            ];
            return $data;
        }
        return false;
    }

    private function _check_shop_status($shop){
        $openStatus  = 2;
        $openNote = '已打烊';
        $timeNow = time();
        $openTimeStr = '';
        if($shop['es_hand_close'] == 0){
            if($shop['es_week'.date('w').'_business_time']){
                $timeArr = json_decode($shop['es_week'.date('w').'_business_time'], true);
                foreach ($timeArr as $time){
                    $openTime = strtotime($time['open']);
                    $closeTime = strtotime($time['close']);
                    if($closeTime <= $openTime){
                        $timeStep_0 = strtotime(date('Y-m-d',$timeNow));
                        $timeStep_24 = $timeStep_0 + 86399;
                        if(($openTime <= $timeNow && $timeNow <= $timeStep_24) || ($timeStep_0 <= $timeNow && $timeNow <= $closeTime)){
                            $openStatus  = 1;
                            $openNote = '营业中';
                        }
                    }else{
                        if($openTime <= $timeNow && $timeNow <= $closeTime){
                            $openStatus  = 1;
                            $openNote = '营业中';
                        }
                    }

                    $openTimeStr .= $time['open'].'-'.$time['close'].'  ';
                }
            }else{
                $timeArr = json_decode($shop['es_common_business_time'], true);
                foreach ($timeArr as $time){
                    $openTimeStr .= $time['open'].'-'.$time['close'].'  ';
                    $openTime = strtotime($time['open']);
                    $closeTime = strtotime($time['close']);
                    if($closeTime <= $openTime){
                        $timeStep_0 = strtotime(date('Y-m-d',$timeNow));
                        $timeStep_24 = $timeStep_0 + 86399;
                        if(($openTime <= $timeNow && $timeNow <= $timeStep_24) || ($timeStep_0 <= $timeNow && $timeNow <= $closeTime)){
                            $openStatus  = 1;
                            $openNote = '营业中';
                        }
                    }else{
                        if($openTime <= $timeNow && $timeNow <= $closeTime){
                            $openStatus  = 1;
                            $openNote = '营业中';
                        }
                    }
                }
            }
        }

        return array('openStatus' => $openStatus, 'openNote' => $openNote, 'openTime' => $openTimeStr);
    }

    private function _check_shop_open($shop){
        $isOpen = 0;
        if($shop['es_hand_close'] == 0) {
            $shopOpen = $shop['es_business_time'] ? $shop['es_business_time'] : '00:00';
            $shopClose = $shop['es_close_time'] ? $shop['es_close_time'] : '23:59';
            $openTime = strtotime($shopOpen);
            $closeTime = strtotime($shopClose);
            if ($openTime >= $closeTime) {
                //$closeTime = $closeTime + 86400;
                //获得当天0点时间戳
                $timeStep_0 = strtotime(date('Y-m-d', $_SERVER['REQUEST_TIME']));
                //获得当天24点时间戳
                $timeStep_24 = strtotime(date('Y-m-d', $_SERVER['REQUEST_TIME'])) + 86399;
                if (($openTime <= $_SERVER['REQUEST_TIME'] && $_SERVER['REQUEST_TIME'] <= $timeStep_24) || ($timeStep_0 <= $_SERVER['REQUEST_TIME'] && $_SERVER['REQUEST_TIME'] <= $closeTime)) {
                    $isOpen = 1;
                }
            } else {
                if ($openTime <= $_SERVER['REQUEST_TIME'] && $_SERVER['REQUEST_TIME'] <= $closeTime) {
                    $isOpen = 1;
                }
            }
        }
        if (!$isOpen) {
            $data['openStatus']  = 2;
            $data['openNote'] = '已打烊';
        }else{
            $data['openStatus']  = 1;
            $data['openNote'] = '营业中';
        }
        return $data;
    }

    private function _check_city_shop_open($val){
        $isOpen = 0;
        if($val['es_hand_close'] == 0){
            $openTimeArr = explode('-',$val['acs_open_time']);
            if($this->sid==10418){   //YEGer加拿大店铺  加拿大时间比北京慢15小时
                $timeNow = time()-54000;
                $openTime = strtotime(date('Y-m-d',$timeNow).' '.$openTimeArr[0]);
                $closeTime = strtotime(date('Y-m-d',$timeNow).' '.$openTimeArr[1]);
            }else{
                $timeNow = time();
                $openTime = strtotime($openTimeArr[0]);
                $closeTime = strtotime($openTimeArr[1]);
            }
            if ($openTime >= $closeTime) {
                //获得当天0点时间戳
                $timeStep_0 = strtotime(date('Y-m-d',$timeNow));
                //获得当天24点时间戳
                $timeStep_24 = strtotime(date('Y-m-d',$timeNow)) + 86399;
                if(($openTime <= $timeNow && $timeNow <= $timeStep_24) || ($timeStep_0 <= $timeNow) && $timeNow <= $closeTime){
                    $isOpen = 1;
                }
            }else{
                if($openTime <= $timeNow && $timeNow <= $closeTime){
                    $isOpen = 1;
                }
            }
        }

        if (!$isOpen) {
            $data['openStatus']  = 2;
            $data['openNote'] = '已打烊';
        }else{
            $data['openStatus']  = 1;
            $data['openNote'] = '营业中';
        }
        return $data;

    }

    
    private function _fetch_activity_status($activity){
        $status = 0;
        $timeNow = time();
        if($activity['ba_start_time']>$timeNow){   // 未开始准备中
            $status = 0;
        }elseif($activity['ba_start_time']<$timeNow && $activity['ba_end_time']>$timeNow && (($activity['ba_goods_stock'] > 0 && ($activity['ba_goods_stock'] - $activity['ba_buy_num']) > 0) || ($activity['ba_goods_stock'] == 0 && $activity['g_stock'] > 0 && in_array($this->applet_cfg['ac_type'],[21,8,6])))){   // 正在进行中
            $status = 1;
        }
        elseif($activity['ba_end_time']<$timeNow || ($activity['ba_goods_stock'] > 0 && ($activity['ba_goods_stock'] - $activity['ba_buy_num']) <= 0) || ($activity['ba_goods_stock'] == 0 && $activity['g_stock'] <= 0 && in_array($this->applet_cfg['ac_type'],[21,8,6]))){  //已结束
            $status = 2;
        }
        return $status;
    }

    
    private function _fetch_status_and_stock($activity){
        $status = 0;
        $timeNow = time();
        if($activity['ba_start_time']>$timeNow){   // 未开始准备中
            $status = 0;
        }elseif($activity['ba_start_time']<$timeNow && $activity['ba_end_time']>$timeNow){   // 正在进行中
            $status = 1;
        }elseif($activity['ba_end_time']<$timeNow){  //已结束
            $status = 2;
        }
        if($activity['ba_goods_stock'] > 0){
            $stock = $activity['ba_goods_stock'] -$activity['ba_buy_num'];
        }else{
            $stock =  $activity['g_stock'];
        }

        $data = [
            'status' => $status,
            'stock'  => $stock
        ];

        return $data;
    }

    
    private function _get_mem_avatar($aid){
        $data = [];
        $join_storage   = new App_Model_Bargain_MysqlJoinStorage($this->sid);
        $sort  = array('bj_join_time' => 'DESC');
        $field = array('bj_m_avatar');//只获取头像
        $list  = $join_storage->fetchMemberByAid($aid,0,10,$sort,$field);
        if($list){
            foreach ($list as $val){
                $data[] = $this->dealImagePath($val['bj_m_avatar']);
            }
        }
        return $data;
    }

    public function testRequestAction(){
//        Libs_Log_Logger::outputLog('获得请求','request-frequency-20.log');
        echo '123';
    }


}