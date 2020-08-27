<?php

class App_Controller_Wxapp_GoodsController extends App_Controller_Wxapp_InitController{

    public function __construct(){
        parent::__construct();
    }


    
    public function secondLink($type='plateform'){
        $link = array(
            array(
                'label' => '平台商品',
                'link'  => '/wxapp/goods/index?plateform=1',
                'active'=> 'plateform'
            ),
            array(
                'label' => '商家商品',
                'link'  => '/wxapp/goods/index?plateform=2',
                'active'=> 'shop'
            ),
        );
        if($this->menuType == 'toutiao' && $this->wxapp_cfg['ac_type'] == 8){
            $link[] = array(
                    'label' => '商品审核',
                    'link'  => '/wxapp/goods/verifyGoodsList',
                    'active'=> 'verify'
                );
        }
        $this->output['secondLink'] = $link;
        $this->output['linkType']   = $type;
        $this->output['snTitle']    = '商品列表';
    }
  
  
 public function copyformatAction(){
        $id   = $this->request->getIntParam('id');
        $test = $this->request->getIntParam('test');
        $type = $this->request->getIntParam('type');
        $row = array(); $slide = array();$format = array();

        if(in_array($this->wxapp_cfg['ac_type'],[4,7,27])){
            $independent = 1;
        }else{
            $independent = 0;
        }
        $this->output['independent'] = $independent;
        $formatNum = 0;
        if($id){
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            $goods = $goods_model->getRowByIdSid($id,$this->curr_sid);
            $row['g_format_type'] = $goods['g_format_type'];
            $esId = $row['g_es_id'];
            $format_model   = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
            $format         = $format_model->getListByGid($id);
            if(!$row['g_format_type'] && $format){
                $spec = [
                    [
                        'name' => '规格',
                        'value' => []
                    ]
                ];
                foreach($format as $val){
                    $spec[0]['value'][] = [
                        'name' => $val['gf_name'],
                        'img'  => $val['gf_img']
                    ];
                    $dataList[] = array(
                        'spec'=> [$val['gf_name']],
                        'oriPrice'=> $val['gf_ori_price'],
                        'price'=> $val['gf_price'],
                        'stock'=> $val['gf_stock'],
                        'weight' => $val['gf_format_weight'],
                        'weightType' => $val['gf_format_weight_type']
                    );
                }
            }else{
                $spec = $row['g_format_type']?json_decode($row['g_format_type'],true):[];
                foreach($format as $val){
                    $dataList[] = array(
                        'spec'=> [$val['gf_name']],
                        'oriPrice'=> $val['gf_ori_price'],
                        'price'=> $val['gf_price'],
                        'stock'=> $val['gf_stock'],
                        'weight' => $val['gf_format_weight'],
                        'weightType' => $val['gf_format_weight_type']
                    );
                }
            }
        }

        $template_storage = new App_Model_Shop_MysqlShopDeliveryTemplateStorage();
        $sort = array('sdt_update_time' => 'DESC');
        $where = array();
        $where[] = array('name' => 'sdt_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'sdt_es_id', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'sdt_deleted', 'oper' => '=', 'value' => 0);
        $tempList = $template_storage->getList($where, 0, 0, $sort);
        $message_storage = new App_Model_Goods_MysqlMessageTemplateStorage();
        $sort = array('amt_update_time' => 'DESC');
        $where = array();
        $where[] = array('name' => 'amt_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'amt_es_id', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'amt_deleted', 'oper' => '=', 'value' => 0);
        $messageList = $message_storage->getList($where, 0, 0, $sort);
        $level_model = new App_Model_Member_MysqlLevelStorage();
        $list = $level_model->getListBySid($this->curr_sid);
        $this->output['levelList'] = $list?json_encode($list):json_encode(array());
        $this->output['types']       = plum_parse_config('goodsType');
        $this->output['row']    = $row;
        $this->output['slide']  =  $slide;
        $this->output['format'] =  $format;
        $this->output['messageList'] = $row['g_extra_message']?$row['g_extra_message']:json_encode(array());
        $this->output['vipPriceList'] = $row['g_vip_price_list']?$row['g_vip_price_list']:json_encode(array());
        $this->output['spec']  = json_encode($spec?$spec:[]);
        $this->output['dataList']  = json_encode($dataList?$dataList:[]);
        $this->output['formatSort'] = implode(',',$sort);
        $this->output['tempList'] = $tempList;
        $this->output['messageListData'] = $messageList;
        $this->output['sid'] = $this->curr_sid;
        $this->renderCropTool('/wxapp/index/uploadImg');
        if($esId > 0 && $this->wxapp_cfg['ac_type'] == 6){
            $titleLink = '/wxapp/citymall/goodsList';
            $titleName = '商品添加';
        }elseif ($esId > 0 && $this->wxapp_cfg['ac_type'] == 33){
            $titleLink = '/wxapp/car/goodsList';
            $titleName = '商品编辑';
        }else{
            $titleLink = '/wxapp/goods/index';
            $titleName = '商品添加/编辑';
        }
        $this->output['backUrl'] = $titleLink;
        $showUnit = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[21,6,8])){
            $showUnit = 1;
        }
        $this->output['showUnit'] = $showUnit;

        $pickupTime = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[21])){
            $pickupTime = 1;
        }
        $this->output['pickupTime'] = $pickupTime;

        $this->output['ac_type'] = $this->wxapp_cfg['ac_type'];

        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => $titleLink),
            array('title' => $titleName, 'link' => '#')
        ));
        $this->output['type'] = $type;

        $this->displaySmarty('wxapp/goods/goods-new.tpl');


    }

    public function indexAction() {

        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => '#'),
            array('title' => '商品列表', 'link' => '#'),
        ));
        if(in_array($this->wxapp_cfg['ac_type'],[4,7, 27])){
            $independent = 1;
        }else{
            $independent = 0;
        }
        $this->output['independent'] = $independent;

        $area_info=$this->get_area_manager();
        $close_cfg = $this->curr_shop['s_agent_close'] ? json_decode($this->curr_shop['s_agent_close'],1) : [];
        if((isset($close_cfg['prepare']) && $close_cfg['prepare']['val'] == 1) || $this->wxapp_cfg['ac_type'] == 36){
            $closePrepare = 1;
        }else{
            $closePrepare = 0;
        }
        $this->output['closePrepare'] = $closePrepare;
        $sequenceShowAll = 1;
        if($this->wxapp_cfg['ac_type'] == 36){
            $sequenceShowAll = 0;
        }
        $this->output['sequenceShowAll'] = $sequenceShowAll;


        $this->_show_goods_list_data($independent,$area_info);

        $this->_show_category_type(0,$independent);
       
        $table_menu = new App_Helper_TableMenu();
        $import = null;
        if ($this->shops[$this->curr_sid]['s_type']) {
            switch ($this->shops[$this->curr_sid]['s_type']) {
                case 1 :
                    $import = array(
                        'name'  => '有赞商品导入',
                        'link'  => '/wxapp/goods/import?type=youzan&step=1',
                    );
                    break;
                case 2 :
                    $import = array(
                        'name'  => '微店商品导入',
                        'link'  => '/wxapp/goods/import?type=weidian&step=1',
                    );
                    break;
            }
        }
        $plugin_helper  = new App_Helper_PluginIn();
        $code   = $plugin_helper->checkShopThreeOpen($this->curr_sid);
        $point  = $plugin_helper->checkShopPointOpen($this->curr_sid);
        $level_model = new App_Model_Member_MysqlLevelStorage();
        $list = $level_model->getListBySid($this->curr_sid);

        $this->output['levelList'] = $list;
        $this->output['levelCount'] = count($list);

        $this->output['threeSale']  = $code['code'] == 0 ? $code['level'] : 0;
        $this->output['openPoint']  = $point['code'] == 0 ? 1 : 0;
        $this->output['integral']   = plum_parse_config('integralReturn');

        $this->output['import']     = $import;
        if($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36){
            $choseLink = $table_menu->showTableLink('sequenceGoods');
            if(!($area_info)){
                unset($choseLink[6]);
                unset($choseLink[7]);
            }

            if($closePrepare){
                unset($choseLink[3]);
            }

            $this->output['choseLink'] = $choseLink;
        }else{
            $this->output['choseLink']  = $table_menu->showTableLink('goodsNew');
        }

        $this->output['threeSale']  = App_Helper_ShopWeixin::checkShopThreeLevel($this->curr_sid);
        $this->output['platform']  = $this->request->getStrParam('platform');//判断是否是试衣间 clothes
        $this->output['clothes']   = $this->curr_shop['s_clothes_status'];
        if($this->wxapp_cfg['ac_type']==6 || $this->wxapp_cfg['ac_type']==8){
            $this->_show_enter_shop();
        }
        $plugin_model = new App_Model_Applet_MysqlAppletPluginStorage($this->curr_sid);
        $hadSc = $plugin_model->findUpdateBySid('sc');
        if($hadSc){
            $this->output['hadSc'] = 1;
        }else{
            $this->output['hadSc'] = 0;
        }

        if(in_array($this->wxapp_cfg['ac_type'],[6,21,1,8,24,18,32])){
            $this->output['addMember'] = 1;
        }else{
            $this->output['addMember'] = 0;
        }
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        if($this->wxapp_cfg['ac_type'] == 4){
            $this->output['goodsPath'] = $client_plugin::MEAL_MALL_GOODS_DETAIL;
        }else{
            $this->output['goodsPath'] = $client_plugin::GOODS_DETAIL_CODE_PATH;
        }

        $allGoodsJumpPageShow = 0;
        if($this->wxapp_cfg['ac_type'] == 21){
            $this->output['allGoodsJumpPage'] = array(
                array(
                    'path' => '/pages/allFlGoodsPage/allFlGoodsPage',
                    'name' => '全部商品分类',
                ),
                array(
                    'path' => '/pages/oneFlgoods/oneFlgoods',
                    'name' => '一级分类商品',
                ),
                array(
                    'path' => '/subpages0/fenleiGoods/fenleiGoods',
                    'name' => '分类商品'
                ),
            );
            $allGoodsJumpPageShow = 1;
            $this->output['allGoodsJump'] = $this->curr_shop['s_all_goods_jump'];
        }
        $this->output['allGoodsJumpPageShow'] = $allGoodsJumpPageShow;
        $day_time = plum_parse_config('day_time');
        $this->output['dayTime'] = $day_time;
        $pickupTime = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[21])){
            $pickupTime = 1;
        }
        $this->output['pickupTime'] = $pickupTime;
        $goodsAlert = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[1,2,5,6,8,13,21,24])){
            $goodsAlert = 1;
        }
        $this->output['goodsAlert'] = $goodsAlert;


        $this->output['ac_type'] = $this->wxapp_cfg['ac_type'];
        $this->output['shop'] = $this->curr_shop;

        $send_model = new App_Model_Cake_MysqlCakeSendStorage($this->curr_sid);
        $sendCfg = $send_model->findUpdateBySid();
        $this->output['sendCfg'] = $sendCfg;
        if($this->wxapp_cfg['ac_type']==32 || $this->wxapp_cfg['ac_type'] == 36){
            $supplier_model=new App_Model_Sequence_MysqlSequenceSupplierInfoStorage($this->curr_sid);
            $supplier=$supplier_model->getList([
                ['name'=>'assi_s_id','oper'=>'=','value'=>$this->curr_sid],
                ['name'=>'assi_deleted','oper'=>'=','value'=>0]
            ],0,0,[],['assi_id','assi_name']);
            $this->output['supplier']=$supplier;
            $this->displaySmarty("wxapp/goods/seq-goods-list-ajax.tpl");
        }else
            $this->displaySmarty("wxapp/goods/goods-list.tpl");
    }
    private function _show_enter_shop(){
        
        $shop_model = new App_Model_Entershop_MysqlEnterShopStorage();
        $list       = $shop_model->getShopListBySid($this->curr_sid);
        $enterShop  = array();
        foreach($list as $val){
            $enterShop[$val['es_id']] = $val['es_name'];
        }
        $this->output['enterShop'] = $enterShop;
    }
    protected function _show_goods_list_data($independent = 0,$area_info = [],$verify_list = 0,$region_id = 0){
        $output['verify_list'] = $verify_list;
        $output['region_id'] = $region_id;
        $where = array();
        $where[] = array('name' => 'g_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[] = array('name' => 'g_independent_mall','oper' => '=','value' =>$independent);
        $where[]        = array('name' => 'g_type','oper' => 'in','value' => array(1,2));

        if($this->menuType == 'toutiao' && $this->curr_shop['s_entershop_goods_verify'] == 1){
            $where[]     = array('name' => 'g_is_sale', 'oper' => 'not in', 'value' =>[4,5]);
        }

        $output['name']     = $this->request->getStrParam('name');
        if($output['name']){
            $where[] = array('name' => 'g_name','oper' => 'like','value' =>"%{$output['name']}%");
        }

        $output['cate'] = $this->request->getIntParam('cate');
        if($output['cate']){
            $where[] = array('name' => 'g_kind2','oper' => '=','value' =>$output['cate']);
        }
        $output['gtype']     = $this->request->getIntParam('gtype');
        if($output['gtype']){
            $where[] = array('name' => 'g_type','oper' => '=','value' =>$output['gtype']);
        }
        $output['selDeduct']     = $this->request->getIntParam('selDeduct');
        if($output['selDeduct']){
            $where[] = array('name' => 'g_is_deduct','oper' => '=','value' =>($output['selDeduct']-1));
        }
        $output['plateform']     = $this->request->getIntParam('plateform', 1);
        $this->secondLink($output['plateform'] == 1 ? 'plateform':'shop');
        if($this->wxapp_cfg['ac_type'] == 6 || $output['plateform'] == 1){
            $where[] = array('name' => 'g_es_id','oper' => '=','value' => 0);
        }else{
           $output['esId']  = $this->request->getIntParam('esId');
          if($output['esId']){
            $where[] = array('name' => 'g_es_id','oper' => '=','value' =>$output['esId']);
           }
            $where[] = array('name' => 'g_es_id','oper' => '!=','value' => 0);
        }

        if($region_id > 0){
            $where[] = array('name' => 'g_region_add_by','oper' => '=','value' =>$region_id);
        }


        $supplier=$this->request->getIntParam('supplier',0);
        if($supplier){
            $where[]=['name'=>'g_supplier_id','oper'=>'=','value'=>$supplier];
        }
        if($verify_list){
            $output['status'] = $this->request->getStrParam('status','verify_wait');
            switch($output['status']){
                case 'verify_wait':
                    $where[] = array('name' => 'g_is_sale','oper' => '=','value' =>4);
                    break;
                case 'verify_refuse':
                    $where[] = array('name' => 'g_is_sale','oper' => '=','value' =>5);
                    break;
            }
        }else{
            $output['status'] = $this->request->getStrParam('status','sell');
            switch($output['status']){
                case 'sell':
                    $where[] = array('name' => 'g_is_sale','oper' => '=','value' =>1);
                    $where[] = array('name' => 'g_stock','oper' => '>','value' =>0);
                    break;
                case 'sellout':
                    $where[] = array('name' => 'g_is_sale','oper' => '=','value' =>1);
                    $where[] = array('name' => 'g_stock','oper' => '<=','value' =>0);
                    break;
                case 'depot':
                    $where[] = array('name' => 'g_is_sale','oper' => '=','value' =>2);
                    break;
                case 'presell'://预售
                    $where[] = array('name' => 'g_is_sale','oper' => '=','value' =>3);
                    break;
                case 'recommend'://推荐商品 先不考虑商品状态及库存
                    $where[] = array('name' => 'g_is_top','oper' => '=','value' =>1);
                    $where[] = array('name' => 'g_is_sale','oper' => '=','value' =>1);
                    break;
                case 'verify_wait':
                    $where[] = array('name' => 'g_is_sale','oper' => '=','value' =>4);
                    break;
                case 'verify_refuse'://社区团购 未审核商品
                    $where[] = array('name' => 'g_is_sale','oper' => '=','value' =>5);
                    break;
                case 'supplier_presell'://社区团购 供应商审核通过但是未上架的商品
                    $where[] = array('name' => 'g_is_sale','oper' => '=','value' =>11);
                    break;
            }
        }


        if ($this->wxapp_cfg['ac_type'] != 32 && $this->wxapp_cfg['ac_type'] != 36){
            $output['sortType'] = $this->request->getStrParam('sortType','updateNew');
            $output['weightSortType'] = $this->request->getStrParam('weightSortType','DESC');
            $sort = ['g_weight'=>$output['weightSortType']];
        }else{
            $output['sortType'] = $this->request->getStrParam('sortType','sortMax');
            if($this->curr_sid==11845)
                $output['sortType'] = $this->request->getStrParam('sortType','customer_11845');
        }

        switch ($output['sortType']){
            case 'sortMax':
                $sort['g_weight'] ='DESC';
                $sort['g_create_time'] = 'DESC';
                break;
            case 'sortMin':
                $sort['g_weight'] = 'ASC';
                $sort['g_create_time'] = 'DESC';
                break;
            case 'updateNew':
                $sort['g_update_time'] ='DESC';
                break;
            case 'updateOld':
                $sort['g_update_time'] = 'ASC';
                break;
            case 'createNew':
                $sort['g_create_time'] = 'DESC';
                break;
            case 'createOld':
                $sort['g_create_time'] = 'DESC';
                break;
            case 'stockMax':
                $sort['g_stock'] = 'DESC';
                break;
            case 'stockMin':
                $sort['g_stock'] = 'ASC';
                break;
            case 'customer_11845':
                $sort['g_weight'] ='DESC';
                $sort['g_update_time'] = 'DESC';
                $sort['g_price'] = 'ASC';
                break;
            default:
                $sort['g_create_time'] = 'DESC';
        }

        $area_manager_id = 0;
        if($area_info){
            $where[]="(`g_region_add_by`={$this->uid} OR `g_region_add_by`=0)";
            $area_manager_id = $this->uid;
        }
        $output['area_manager_id'] = $area_manager_id;
        $output['area_info'] = $area_info;



        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $total = $goods_model->getCount($where);


        $pageCfg = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        $output['showPage'] = $total > $this->count ? 1 : 0;
        $list   = array();
        $deduct = array();
        if($index <= $total){
            if($this->wxapp_cfg['ac_type'] == 6 || $output['plateform'] == 1){
                if($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36){
                    
                    $list=$goods_model->getGoodsListWithRegion($where,$index,$this->count,$sort);

                }else
                    $list = $goods_model->getList($where,$index,$this->count,$sort);
            }else{

                $list = $goods_model->getCommunityShopGoods($where,$index,$this->count,$sort);

            }


            $goods_redis = new App_Model_Goods_RedisGoodsStorage($this->curr_sid);
            $timeNow = time();
            $deduct_gids = array();

            foreach($list as $key=>$val){
                $deduct_gids[] = $val['g_id'];
                $param = array(
                    'gid' => $val['g_id']
                );

                if(!$val['g_qrcode'] && $this->curr_sid!=8503){
                }
                if($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36){
                    $ratio_model = new App_Model_Sequence_MysqlSequenceGoodsDeductStorage($this->curr_sid);
                    $ratio_info  = $ratio_model->getRowByGid($val['g_id']);
                    $list[$key]['asgd_id'] = $ratio_info['asgd_id'];
                    $list[$key]['g_1f_ratio'] = bcadd($val['g_price'] * $ratio_info['asgd_1f_ratio'] / 100,0,2);
                    $list[$key]['g_1f_ratio_percent']=$ratio_info['asgd_1f_ratio'];
                    $up_ttl = $goods_redis->getGoodsSaleUpTtl($val['g_id']);
                    $down_ttl = $goods_redis->getGoodsSaleDownTtl($val['g_id']);
                    $list[$key]['upDate'] = $up_ttl > 0 ? date('Y-m-d H:i',($timeNow+$up_ttl)) :'';
                    $list[$key]['downDate'] = $down_ttl > 0 ? date('Y-m-d H:i',($timeNow+$down_ttl)) :'';
                    $region_ratio_model=new App_Model_Sequence_MysqlSequenceRegionGoodsDeductStorage($this->curr_sid);
                    $region_ratio_info = $region_ratio_model->getRowByGid($val['g_id']);
                    $list[$key]['asrgd_id'] = $region_ratio_info['asrgd_id'];
                    $list[$key]['asrgd_1f_ratio_percent'] = $region_ratio_info['asrgd_1f_ratio'];
                    $list[$key]['asrgd_1f_ratio'] = bcadd($val['g_price'] * $region_ratio_info['asrgd_1f_ratio'] / 100,0,2);
                }
               
            }

            if(!empty($deduct_gids)){
                $deduct_model = new App_Model_Goods_MysqlDeductStorage($this->curr_sid);
                $deduct = $deduct_model->getListByGids($deduct_gids);
            }
        }
        if($list){
            $output['now'] = 1;
        }
        if($area_info){
            $this->output['area_info']=$area_info['m_area_id'];
            $region_model=new App_Model_Sequence_MysqlSequenceRegionGoodsStorage($this->curr_sid);
            foreach ($list as $key => $val) {
               $region_limit=$this->get_area_manager_goods_limit($region_model,$val['g_id'],$area_info['m_area_id']);
               if($region_limit)
                    $list[$key]['region_limit']= $region_limit['asrg_limit_status'];
                else
                    $list[$key]['region_limit']= 0;
            }
        }



        $output['list'] = $list;
        $output['deduct'] = $deduct;
        $where_total = $where_soldout = $where_nosale = [];
        $where_total[] = $where_soldout[] = $where_nosale[] = ['name' => 'g_s_id','oper' => '=','value' =>$this->curr_sid];
        $where_total[] = $where_soldout[] = $where_nosale[] = ['name' => 'g_type','oper' => 'in','value' => array(1,2)];
        $where_total[] = $where_soldout[] = $where_nosale[] = ['name' => 'g_independent_mall','oper' => '=','value' => $independent];
        if($region_id){
            $where_total[] = $where_soldout[] = $where_nosale[] = ['name' => 'g_region_add_by','oper' => '=','value' =>$region_id];
        }
        if($this->wxapp_cfg['ac_type'] == 6 || $output['plateform'] == 1){
            $where_total[] = $where_soldout[] = $where_nosale[] = array('name' => 'g_es_id','oper' => '=','value' => 0);
        }
        $where_soldout[] = ['name' => 'g_stock','oper' => '=','value' => 0];
        $where_soldout[] = ['name' => 'g_is_sale','oper' => '=','value' => 1];
        $where_nosale[] = ['name' => 'g_is_sale','oper' => '=','value' => 2];
        if($area_info){
            $where_total[]="(`g_region_add_by`={$this->uid} OR `g_region_add_by`=0)";
            $where_soldout[]="(`g_region_add_by`={$this->uid} OR `g_region_add_by`=0)";
        }

        $totalInfo = $goods_model->getStatInfo($where_total);
        $soldout = $goods_model->getCount($where_soldout);
        $nosale = $goods_model->getCount($where_nosale);
        $sale = intval($totalInfo['total']) - intval($soldout) - intval($nosale);
        $statInfo = [
            'total' => intval($totalInfo['total']),
            'soldout' => intval($soldout),
            'nosale' => intval($nosale),
            'sale' => $sale > 0 ? $sale : 0,
            'soldNum' => intval($totalInfo['soldNum'])
        ];
        $push_model = new App_Model_Tplmsg_MysqlPushHistoryStorage();
        $where_push = [];
        $where_push[] = ['name'=>'aph_s_id','oper'=>'=','value'=>$this->curr_sid];
        $where_push[] = ['name'=>'aph_g_id','oper'=>'>','value'=>0];
        $where_push[] = ['name'=>'g_deleted','oper'=>'=','value'=>0];
        $pushStat = $push_model->getSum($where_push,'goods');
        $statInfo['pushTotal'] = intval($pushStat['pushTotal']);
        $statInfo['pushMemberSum'] = intval($pushStat['pushMemberSum']);
        $output['statInfo'] = $statInfo;
        $this->showOutput($output);

    }
    
    public function shopListAction(){
        $this->output['gid']  = $this->request->getIntParam('gid');
        $this->output['esId'] = $this->request->getIntParam('esId');
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $where[] = array('name'=>'es_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'es_deleted','oper'=>'=','value'=>0);
        $shop_model = new App_Model_Entershop_MysqlEnterShopStorage();
        $total      = $shop_model->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list = array();
        if($index < $total){
            $sort          = array('es_createtime' => 'DESC');
            $list          = $shop_model->getShopMangerList($where,$index,$this->count,$sort);
        }

        $this->output['shopLevel'] = $this->_get_select_level();
        $this->output['category'] = $this->_get_select_category();
        $this->output['district'] = $this->_get_select_district();
        $this->output['appletCfg'] = $this->wxapp_cfg;
        $this->output['list'] = $list;
        $this->output['sid'] = $this->curr_sid;
        $this->buildBreadcrumbs(array(
            array('title' => '商家管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/goods/shop-list.tpl');
    }

    
    private function _get_select_category(){
        $category_model = new App_Model_Community_MysqlKindStorage($this->curr_sid);
        $category_list  = $category_model->getAllCategorySelect();
        return $category_list;
    }
    
    private function _get_select_district(){
        $district_model = new App_Model_Community_MysqlCommunityDistrictStorage($this->curr_sid);
        $district_list  = $district_model->getListBySid();
        $data = array();
        foreach($district_list as $val){
            $data[$val['acd_id']] = array(
                'name' => $val['acd_name'],
                'area_name' => $val['acd_area_name']
            );
        }
        return $data;
    }
    
    private function _get_select_level(){
        $level_model = new App_Model_Entershop_MysqlEnterShopLevelStorage($this->curr_sid);
        $levelList = $level_model->getListBySid($this->curr_sid,0,0);
        $data = array();
        foreach ($levelList as $val){
            $data[$val['esl_id']] = $val['esl_name'];
        }
        return $data;
    }
    
    public function formatToPointAction(){
        $gid         = $this->request->getIntParam('gid');
        $goods_model = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
        $list        = $goods_model->getListByGid($gid);
        $format      = array();
        foreach($list as $val){
            $format[] = array(
                'id'   => $val['gf_id'],
                'name' => $val['gf_name'],
                'point'=> $val['gf_send_point'],
            );
        }
        $this->displayJsonSuccess($format);
    }

    
    public function savePointAction(){
        $format      = $this->request->getIntParam('format');
        $gid         = $this->request->getIntParam('gid');
        $num         = $this->request->getIntParam('num');
        $unit        = $this->request->getIntParam('unit');
        $set         = array(
            'g_update_time' => $_SERVER['REQUEST_TIME'],
            'g_back_num'    => $num,
            'g_back_unit'   => $unit,
        );
        if($format > 0){
            $result = $this->save_point_to_format();
        }else{
            $point       = $this->request->getFloatParam('point');
            $set['g_send_point'] =  $point;
        }
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $res         = $goods_model->getRowUpdateByIdSid($gid,$this->curr_sid,$set);
        if(isset($result)){
            if($result['ec'] == 200){
                $goods = $goods_model->getRowById($gid);
                App_Helper_OperateLog::saveOperateLog("保存商品【{$goods['g_name']}】积分设置成功");
            }
            $this->displayJson($result);
        }else{
            if($res){
                $goods = $goods_model->getRowById($gid);
                App_Helper_OperateLog::saveOperateLog("保存商品【{$goods['g_name']}】积分设置成功");
            }

            $this->showAjaxResult($res,'保存');
        }
    }

    
    private function save_point_to_format(){
        $point       = $this->request->getArrParam('point');
        $gid         = $this->request->getIntParam('gid');
        $format_model= new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
        foreach($point as $val){
            $where = array();
            $where[] = array('name'=>'gf_id','oper'=>'=','value'=>$val['id']);
            $where[] = array('name'=>'gf_g_id','oper'=>'=','value'=>$gid);
            $where[] = array('name'=>'gf_s_id','oper'=>'=','value'=>$this->curr_sid);
            $set     = array('gf_send_point' => $val['val']);
            $format_model->updateValue($set,$where);
        }
        return array(
            'ec' => 200,
            'em' => '保存成功'
        );
    }

    
    private function save_point_to_goods(){

    }

    
    public function addAction(){
        $id  = $this->request->getIntParam('id');
        $row = array(); $slide = array();$format = array();
        $formatNum = 0;
        $sort      = array();
        if($id){
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            $row = $goods_model->getRowByIdSid($id,$this->curr_sid);
            if(!empty($row)){
                $slide_model    = new App_Model_Goods_MysqlGoodsSlideStorage($this->curr_sid);
                $slide          = $slide_model->getSlideByGid($row['g_id']);
                $format_model   = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
                $format         = $format_model->getListByGid($row['g_id']);
                if($format){
                    $formatNum = count($format) - 1;
                    for($i=0 ; $i <= $formatNum ; $i ++){
                        $sort[] = 'format_id_'.$i;
                    }
                }
            }
        }
        $template_storage = new App_Model_Shop_MysqlShopDeliveryTemplateStorage();
        $sort = array('sdt_update_time' => 'DESC');
        $where = array();
        $where[] = array('name' => 'sdt_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'sdt_deleted', 'oper' => '=', 'value' => 0);
        $tempList = $template_storage->getList($where, 0, 0, $sort);
        $this->output['type']       = plum_parse_config('goodsType');
        $this->output['row']    = $row;
        $this->output['slide']  =  $slide;
        $this->output['format'] =  $format;
        $this->output['formatNum']  = $formatNum;
        $this->output['formatSort'] = implode(',',$sort);
        $this->output['tempList'] = $tempList;

        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => '/wxapp/goods/index'),
            array('title' => '添加商品', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/goods/add-goods.tpl");
    }



    
    protected function _show_category_type($is_add=1,$independent = 0){
        
        $category_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $temp          = $category_model->getAllSonCategory(0,200,false,$independent);
        $category = array();
        foreach($temp as $val){
            $category[$val['sk_id']] = $val['sk_name'];
        }
        $this->output['category']   =$category ;
        $this->output['type']       = plum_parse_config('goodsType');
    }

    
    public function saveAction(){
        $result = array(
            'ec' => 400,
            'em' => '请填写完整商品数据'
        );
        $temp_psf = $this->math_price_stock_format();
        $id       = $this->request->getIntParam('id');
        $intField = array('g_sold','g_type','g_weight','g_limit','g_vip_discount');
        $data     = $this->getIntByField($intField);
        $data['g_name']         = $this->request->getStrParam('g_name');
        $data['g_price']        = $temp_psf['price'];
        $data['g_stock']        = $temp_psf['stock'];
        $data['g_has_format']   = $temp_psf['format'];

        $data['g_ori_price']    = $this->request->getFloatParam('g_ori_price');
        $data['g_unified_fee']  = $this->request->getFloatParam('g_unified_fee');

        $data['g_cover']        = $this->request->getStrParam('g_cover');
        $data['g_expfee_type']  = $this->request->getStrParam('g_expfee_type');
        $data['g_unified_tpid']  = $this->request->getStrParam('g_unified_tpid');
        $data['g_brief']        = $this->request->getStrParam('g_brief'); ;
        $data['g_detail']       = $this->request->getStrParam('g_detail');

        $istop                  = $this->request->getStrParam('g_is_top');
        $vipbuy                 = $this->request->getStrParam('g_vip_buy');
        $stockShow              = $this->request->getStrParam('g_stock_show');
        $soldShow               = $this->request->getStrParam('g_sold_show');
        $data['g_is_back']      = $this->request->getIntParam('good_tag_0');
        $data['g_is_quality']   = $this->request->getIntParam('good_tag_1');
        $data['g_is_truth']     = $this->request->getIntParam('good_tag_2');
        $data['g_is_global']     = $this->request->getIntParam('g_is_global');
        $data['g_is_top']       = ($istop == 'on' || $istop == 1)? 1 : 0;
        $data['g_vip_buy']      = ($vipbuy == 'on' || $vipbuy == 1)? 1 : 0;
        $data['g_stock_show']   = ($stockShow == 'on' || $stockShow == 1)? 1 : 0;
        $data['g_sold_show']    = ($soldShow == 'on' || $soldShow == 1)? 1 : 0;
        $cusCategory            = $this->_get_custom_category();
        $data['g_kind1']        = $cusCategory['kind1'];
        $data['g_kind2']        = $cusCategory['kind2'];
        $data['g_s_id']         = $this->curr_sid;
        $data['g_update_time']  = time();
        $data['g_custom_label'] = $this->request->getStrParam('g_custom_label');
        $format                 = $this->request->getIntParam('format-num');


        if($data['g_name'] && $data['g_cover']){
            $is_add = 0;
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            if($id){
                $ret = $goods_model->getRowUpdateByIdSid($id,$this->curr_sid,$data);
            }else{
                $data['g_create_time'] = time();
                $ret = $goods_model->insertValue($data);
                $id  = $ret;
                $is_add = 1;
            }
            if($ret){
                $this->batchGoodsFormat($id,$is_add);
                $this->batchSlide($id,$is_add);
                if($is_add){
                    $this->create_qrcode($ret, $data['g_cover']);
                }
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功',
                );
            }else{
                $result['em'] = '保存失败';
            }
        }
        $this->displayJson($result);
    }

    
    private function _get_custom_category(){
        $result = array(
            'kind1' => 0,
            'kind2' => 0,
        );
        $kind2 = $this->request->getIntParam('custom_cate');
        if($kind2){
            $category_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
            $row            = $category_model->getRowUpdateByIdSid($kind2,$this->curr_sid);
            $result['kind1']= $row['sk_fid'];
            $result['kind2']= $row['sk_id'];
        }
        return $result;
    }

    
    private function math_price_stock_format(){
        $data   = array(
            'price' => 0,
            'stock' => 0,
            'format'=> 0,
        );
        $maxNum = $this->request->getIntParam('format-num');
        for($i=0; $i < $maxNum; $i++){
            $stock = $this->request->getIntParam('format_stock_'.$i);
            if($stock){
                $price  = $this->request->getFloatParam('format_price_'.$i);
                $data['stock']  = $data['stock'] + $stock;
                $data['format'] = $data['format'] + 1;
                if($data['price'] == 0) $data['price'] = $price;
            }
        }
        $data['price'] = $this->request->getFloatParam('g_price');
        $data['stock'] = $this->request->getIntParam('g_stock');
        $data['oriPrice'] = $this->request->getFloatParam('g_ori_price');
        $data['weight'] = $this->request->getFloatParam('g_goods_weight');
        $data['weightType'] = $this->request->getIntParam('g_goods_weight_type');

        $formatList = json_decode($this->request->getStrParam('formatList'),true);

        if($formatList){//有规格
            $data['stock'] = 0;
            $data['price'] = 0;
            $data['oriPrice'] = 0;
            $data['weight'] = 0;
        }

        foreach ($formatList as $val){
            if($val['stock'] > 0){
                $data['stock'] += $val['stock'];
            }
            if($data['price'] == 0){
                $data['price'] = $val['price'];
            }
            if($data['oriPrice'] == 0){
                $data['oriPrice'] = $val['oriPrice'];
            }
            if($data['weight'] == 0){
                $data['weight'] = $val['weight'];
            }
            $data['weightType'] = $val['weightType'];
        }


        return $data;
    }

    
    public function shelfAction(){
      

        $ids    = $this->request->getStrParam('ids');
        $id_arr = plum_explode($ids);
        $type   = $this->request->getStrParam('type');

        $result = array(
            'ec' => 400,
            'em' => '您尚未选择商品'
        );
        if(!empty($id_arr)){
            if($type == 'down'){
                $set = array(
                    'g_is_sale' => 2
                );
            }else{
                $set = array(
                    'g_is_sale' => 1
                );
            }

            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            $where   = array();
            $where[] = array('name' => 'g_s_id','oper' => '=','value' =>$this->curr_sid);
            $where[] = array('name' => 'g_id','oper' => 'in','value' =>$id_arr);
            $area_info=$this->get_area_manager();
            if($area_info){
                $shelf_goods_list=$goods_model->getList($where,0,0,[],['g_region_add_by']);
                foreach ($shelf_goods_list as $key => $value) {
                    if($value['g_region_add_by']!=$this->uid){
                        $this->displayJson(['em'=>'区域合伙人仅可操作自己添加的商品'],1);
                        break;
                    }
                }
            }


          
            
            $ret = $goods_model->updateValue($set,$where);
            if($ret){
                if($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36){
                    $redis = new App_Model_Goods_RedisGoodsStorage($this->curr_sid);
                    $redis->delGoodsSaleKeys($id_arr);
                }
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功'
                );
                $str = $type == 'down' ? '下架' : '上架';
                App_Helper_OperateLog::saveOperateLog("商品{$str}成功".$ids);
            }else{
                $result['em'] = '保存失败';
            }
        }
        $this->displayJson($result);
    }


    
    public function autoShelfAction(){
        $ids    = $this->request->getStrParam('ids');
        $id_arr = plum_explode($ids);
        $type   = $this->request->getStrParam('type');
        $down_time = $this->request->getStrParam('down_time');
        $up_time = $this->request->getStrParam('up_time');
        $downTime = strtotime($down_time);
        $upTime = strtotime($up_time);
        $timeNow = time();
        $ret = false;
        if(!empty($id_arr)){
            $where   = array();
            $where[] = array('name' => 'g_s_id','oper' => '=','value' =>$this->curr_sid);
            $where[] = array('name' => 'g_id','oper' => 'in','value' =>$id_arr);
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            $area_info=$this->get_area_manager();
            if($area_info){
                $shelf_goods_list=$goods_model->getList($where,0,0,[],['g_region_add_by']);
                foreach ($shelf_goods_list as $key => $value) {
                    if($value['g_region_add_by']!=$this->uid){
                        $this->displayJson(['em'=>'区域合伙人仅可操作自己添加的商品'],1);
                        break;
                    }
                }
            }

            if($type == 'down'){
                if(!$down_time){
                    $this->displayJsonError('请选择上架时间');
                }
                if($downTime <= ($timeNow+60)){
                    $this->displayJsonError('下架时间必须至少大于当前时间1分钟');
                }
                $redis = new App_Model_Goods_RedisGoodsStorage($this->curr_sid);
                $redis->delGoodsSaleKeys($id_arr);
                $ttl = $downTime - $timeNow;
                foreach ($id_arr as $gid0){
                    $ret = $redis->setGoodsSaleDownTtl($gid0,$ttl);
                }
            }else{
                if(!$up_time){
                    $this->displayJsonError('请选择上架时间');
                }
                if($upTime <= ($timeNow+60)){
                    $this->displayJsonError('上架时间必须至少大于当前时间1分钟');
                }
                if($downTime && $downTime <= ($upTime+60)){
                    $this->displayJsonError('下架时间必须至少大于上架时间1分钟');
                }

                if($type == 'presell'){
                    $set = array(
                        'g_is_sale' => 3
                    );
                   
                   
                    $ret = $goods_model->updateValue($set,$where);
                }

                if($ret || $type == 'presell_change'){
                    $redis = new App_Model_Goods_RedisGoodsStorage($this->curr_sid);
                    $redis->delGoodsSaleKeys($id_arr);
                    if($upTime){
                        $ttl = $upTime - $timeNow;
                        foreach ($id_arr as $gid1){
                            $ret = $redis->setGoodsSaleUpTtl($gid1,$ttl);
                        }
                    }
                    if($downTime){
                        $ttl = $downTime - $timeNow;
                        foreach ($id_arr as $gid2){
                            $ret = $redis->setGoodsSaleDownTtl($gid2,$ttl);
                        }
                    }
                }
            }

            if($ret){
                $str = $type == 'down' ? '下架' : '上架';
                App_Helper_OperateLog::saveOperateLog("设置商品自动{$str}成功");
            }

            $this->showAjaxResult($ret);
        }else{
            $this->displayJsonError('您尚未选择商品');
        }
    }

    
    public function saveRatioAction(){
        $result = array(
            'ec' => 400,
            'em' => '商品信息错误'
        );
        $data = array();
        $g_id = $this->request->getIntParam('gid');
        $data['gd_is_used']     = $this->request->getIntParam('used');
        $data['gd_update_time'] = time();
        for($i=0; $i<=3; $i++){
            $data['gd_'.$i.'f_ratio'] = $this->request->getFloatParam('ratio_'.$i);
        }
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $deduct_model = new App_Model_Goods_MysqlDeductStorage($this->curr_sid);
        $course_model = new App_Model_Train_MysqlTrainCourseStorage($this->curr_sid);
        $deduct = $deduct_model->fetchUpdateRow($g_id);
        $goods = [];
        if($deduct){
            $ret = $deduct_model->fetchUpdateRow($g_id,$data);
        }else{
            if($this->wxapp_cfg['ac_type'] == 12){
                $goods = $course_model->getRowByIdSid($g_id,$this->curr_sid);
            }else{
                $goods = $goods_model->findGoodsBySidGid($this->curr_sid,$g_id);
            }

            if(!empty($goods)){
                $data['gd_g_id'] = $g_id;
                $data['gd_s_id'] = $this->curr_sid;
                $data['gd_create_time'] = time();
                $ret = $deduct_model->insertValue($data);
            }
        }
        if(isset($ret) && $ret){
            if($this->wxapp_cfg['ac_type'] == 12){
                $course_model->changeDeduct($g_id,$data['gd_is_used']);
            }else{
                $goods_model->changeDeduct($g_id,$data['gd_is_used']);
            }
            $result = array(
                'ec' => 200,
                'em' => '保存成功'
            );

            if(!$goods){
                if($this->wxapp_cfg['ac_type'] == 12){
                    $goods = $course_model->getRowByIdSid($g_id,$this->curr_sid);
                }else{
                    $goods = $goods_model->findGoodsBySidGid($this->curr_sid,$g_id);
                }
            }
            App_Helper_OperateLog::saveOperateLog("保存商品【{$goods['g_name']}】分销比例成功");

        }else{
            $result['em'] =  '保存失败';
        }
        $this->displayJson($result);
    }

    
    public function delRatioAction(){
        $id = $this->request->getIntParam('id');
        $course_model = new App_Model_Train_MysqlTrainCourseStorage($this->curr_sid);
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $deduct_model = new App_Model_Goods_MysqlDeductStorage($this->curr_sid);
        $deduct = $deduct_model->getRowById($id);
        $ret = $deduct_model->deleteById($id);
        if($this->wxapp_cfg['ac_type'] == 12){
            $course_model->changeDeduct($deduct['gd_g_id'],0);
        }else{
            $goods_model->changeDeduct($deduct['gd_g_id'],0);
        }
        if($ret){
            if($this->wxapp_cfg['ac_type'] == 12){
                $goods = $course_model->getRowByIdSid($deduct['gd_g_id'],$this->curr_sid);
            }else{
                $goods = $goods_model->findGoodsBySidGid($this->curr_sid,$deduct['gd_g_id']);
            }
            App_Helper_OperateLog::saveOperateLog("删除商品【{$goods['g_name']}】分销比例成功");
        }

        $this->showAjaxResult($ret);
    }

    
    public function batchSlide($goId,$is_add=0){
        $slide_model    = new App_Model_Goods_MysqlGoodsSlideStorage($this->curr_sid);
        $maxNum         = $this->request->getStrParam('slide-img-num');
        $slide          = array();
        $sort           = array();
        $slideImgArr    = array();
        if($is_add){
            for($i=0; $i<= $maxNum; $i++){
                $temp = $this->request->getStrParam('slide_'.$i);
                $temp_sort = $this->request->getIntParam('slide_sort_'.$i);
                $temp = plum_sql_quote($temp);
                if($temp){
                    $slide[] = "(NULL, '{$this->curr_sid}', '{$goId}', '{$temp}','{$temp_sort}', 0, '".time()."')";
                    $slideImgArr[] = $temp;
                }
            }
            $slide_model->batchNewSave($slide);
        }else{
            $sl_id = array();
            $sort_id = array();
            for($i=0; $i<= $maxNum; $i++){
                $temp = $this->request->getStrParam('slide_'.$i);
                $temp = plum_sql_quote($temp);
                $temp_id = $this->request->getIntParam('slide_id_'.$i);
                $temp_sort = $this->request->getIntParam('slide_sort_'.$i);
                if($temp && $temp_id == 0){
                    $slide[] = $temp;
                    $slideImgArr[] = $temp;
                    $sort[] = $temp_sort;
                }
                if($temp_id){
                    $sl_id[] = $temp_id;
                    $sort_id[] = $temp_sort;
                }
            }
            $del_id = array();
            $old_slide = $slide_model->getListByGidSid($goId,$this->curr_sid);
            foreach($old_slide as $val){
                if(!in_array($val['gs_id'],$sl_id)){
                    $del_id[] = $val['gs_id'];
                }
            }

            foreach ($sl_id as $key => $val){
                $set = array('gs_sort' => $sort_id[$key]);
                $slide_model->updateById($set, $val);
            }
            if(count($slide) <= count($del_id)){
                $delNum = count($del_id);
                for($d=0 ; $d < $delNum; $d++){
                    if(isset($slide[$d]) && $slide[$d]){
                        $slide_model->updateSlide($del_id[$d],$slide[$d], $sort[$d]);
                        unset($del_id[$d]);
                    }
                }
                if(!empty($del_id)){
                    $slide_model->deleteSlide($goId,$del_id);
                }
            }else{
                $batch_slide = array();
                $slidNum = count($slide);
                for($s=0 ; $s < $slidNum ; $s++){
                    if(isset($del_id[$s]) && $del_id[$s]){
                        $slide_model->updateSlide($del_id[$s],$slide[$s], $sort[$s]);
                        unset($slide[$s]);
                    }else{
                        $sTemp = plum_sql_quote($slide[$s]);
                        $batch_slide[] = "(NULL, '{$this->curr_sid}', '{$goId}', '{$sTemp}', '{$sort[$s]}', 0, '".time()."')";
                    }
                }
                if(!empty($batch_slide)){
                    $slide_model->batchNewSave($batch_slide);
                }
            }
        }

        if($this->curr_shop['s_watermark_open']){
            $imgData = json_encode($slideImgArr);
            plum_open_backend('post','addWatermark',array('imgdata'=>rawurlencode($imgData),'sid'=>$this->curr_sid));
        }
    }

    
    private function batchGoodsFormat($goId,$is_add=0){
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
        $maxNum         = $this->request->getIntParam('format-num');
        $go_price       = $this->request->getFloatParam('g_price');
        $formatSort     = $this->request->getStrParam('format-sort');
        $sortArr        = explode(',',$formatSort);
        $totalStock     = 0;
        $format         = array();
        if($is_add){
            for($i=0; $i <= $maxNum; $i++){
                $stock = $this->request->getIntParam('format_stock_'.$i);
                if($stock){
                    $name       = plum_sql_quote(plum_get_param('format_name_'.$i));
                    $tem_price  = $this->request->getFloatParam('format_price_'.$i);
                    $sort       = array_search('format_id_'.$i,$sortArr);
                    $price      = $tem_price ? $tem_price : $go_price ;
                    $format[]   = "(NULL, '{$this->curr_sid}', '{$goId}', '{$name}','{$price}','{$stock}','{$sort}', 0, '".time()."')";
                    $totalStock = $totalStock + $stock;
                }

            }
        }else{
            $gf_id = array();
            for($i=0; $i <= $maxNum; $i++){
                $stock   = $this->request->getIntParam('format_stock_'.$i);
                $name    = plum_sql_quote($this->request->getStrParam('format_name_'.$i));
                $price   = $this->request->getFloatParam('format_price_'.$i);
                $id      = $this->request->getIntParam('format_id_'.$i);
                if($stock && $name){
                    $sort       = array_search('format_id_'.$i,$sortArr);//gf_sort
                    $temp = array(
                        'gf_name'   => $name,
                        'gf_price'  => $price ? $price : $go_price,
                        'gf_stock'  => $stock,
                        'gf_sort'   => $sort
                    );
                    if($id == 0){
                        $format[]   = "(NULL, '{$this->curr_sid}', '{$goId}', '{$temp['gf_name']}','{$temp['gf_price']}','{$temp['gf_stock']}','{$temp['gf_sort']}', 0, '".time()."')";
                    }else{
                        $format_model->updateFormat($id,$temp);
                        $gf_id[] = $id;
                    }
                    $totalStock = $totalStock + $stock;
                }
            }
            $del_id = array();
            $old_format = $format_model->getListByGid($goId);
            foreach($old_format as $val){
                if(!in_array($val['gf_id'],$gf_id)){
                    $del_id[] = $val['gf_id'];
                }
            }
            if(!empty($del_id)){
                $format_model->deleteFormat($goId,$del_id);
            }
        }
        if(!empty($format)){
            $format_model->batchSave($format);
        }
    }

    
    public function importAction() {
        $this->buildBreadcrumbs(array(
            array('title' => '商品列表', 'link' => '/wxapp/goods/index'),
            array('title' => '商品导入', 'link' => '#'),
        ));
        $type   = $this->request->getStrParam('type');
        $step   = $this->request->getIntParam('step', 1);

        $desc   = array();
        $button = array();
        if ($step == 1) {
            if ($type == 'weidian') {
                $desc   = array('1、仅支持已授权微店店铺商品导入', '2、仅支持微店店铺中上架商品导入', '3、导入数据耗时较长,请耐心等待');
                $button = array('name' => '开始导入', 'link' => '/wxapp/goods/import?type=weidian&step=2');
            } else if ($type == 'youzan') {
                $desc   = array('1、仅支持已授权有赞店铺商品导入', '2、仅支持有赞店铺中上架商品导入', '3、导入数据耗时较长,请耐心等待');
                $button = array('name' => '开始导入', 'link' => '/wxapp/goods/import?type=youzan&step=2');
            }
        } else if ($step == 2) {
            set_time_limit(0);//设置不超时
            if ($type == 'weidian') {
                $weidian_client = new App_Plugin_Weidian_Client($this->curr_sid);
                $count  = 50;//每次获取商品条数
                $data   = $weidian_client->getGoodsList(1, $count);
                $status = $data['status'];
                if ($status['status_code']) {
                    $desc   = array('1、商品导入失败', "2、导入失败原因={$status['status_reason']}");
                    $button = array('name' => '重新导入', 'link' => '/wxapp/goods/import?type=weidian&step=1');
                } else {
                    $desc[] = '1、商品导入成功';
                    $result = $data['result'];
                    $total  = $result['total_num'];
                    $item   = $result['items'];
                    $page_num   = ceil($total/$count);
                    for ($i=2; $i<=$page_num; $i++) {
                        $data   = $weidian_client->getGoodsList($i, $count);
                        $item   = array_merge($item, $data['result']['items']);//合并数组
                    }
                    $goods_model    = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
                    $slide_model    = new App_Model_Goods_MysqlGoodsSlideStorage($this->curr_sid);
                    $add    = 0;
                    foreach ($item as $goods) {
                        $exist  = $goods_model->findGoodsByWdid($goods['itemid']);
                        if ($exist) {
                            continue;
                        }
                        $detail     = array("<div>{$goods['item_desc']}</div>");
                        $return = $weidian_client->getGoodsSingle($goods['itemid']);
                        if ($return['status_code'] == 0) {
                            $single = $return['result'];
                            if (count($single['imgs']) > 0) {
                                foreach ($single['imgs'] as $img) {
                                    $detail[]   = "<div><img src='{$img}'></div>";
                                }
                            }
                        } else {//获取失败时,使用列表图片
                            if (count($goods['imgs']) > 0) {
                                foreach ($goods['imgs'] as $img) {
                                    $detail[]   = "<div><img src='{$img}'></div>";
                                }
                            }
                        }
                        if ($exist) {
                            $gdupdata   = array(
                                'g_name'    => $goods['item_name'],
                                'g_cover'   => $goods['imgs'][0],//获取第一个图片作为缩略图
                                'g_price'   => $goods['price'],
                                'g_ori_price'=> $goods['price'],//原价等于现价
                                'g_detail'  => join('', $detail),
                                'g_update_time' => time(),
                            );
                            $goods_model->updateById($gdupdata, $exist['g_id']);
                        } else {
                            $add++;
                            $gdindata   = array(
                                'g_s_id'    => $this->curr_sid,
                                'g_wd_itemid'   => $goods['itemid'],
                                'g_name'    => $goods['item_name'],
                                'g_cover'   => $goods['imgs'][0],//获取第一个图片作为缩略图
                                'g_c_id'    => 0,//未知类别
                                'g_price'   => $goods['price'],
                                'g_ori_price'=> $goods['price'],//原价等于现价
                                'g_type'    => 1,//默认实物
                                'g_is_sale' => 1,//在售商品
                                'g_stock'   => $goods['stock'],
                                'g_sold'    => $goods['sold'],
                                'g_limit'   => 0,//不限购
                                'g_brief'   => '',//简介置空
                                'g_detail'  => join('', $detail),
                                'g_has_format'  => count($goods['skus']),
                                'g_create_time' => time(),
                                'g_update_time' => time(),
                            );
                            $gid    = $goods_model->insertValue($gdindata);
                            if (count($goods['imgs']) > 0) {
                                foreach ($goods['imgs'] as $img) {
                                    $sdindata   = array(
                                        'gs_s_id'   => $this->curr_sid,
                                        'gs_g_id'   => $gid,
                                        'gs_path'   => $img,
                                        'gs_create_time'    => time(),
                                    );
                                    $slide_model->insertValue($sdindata);
                                }
                            }
                            if (count($goods['skus']) > 0) {
                                $format_model   = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
                                foreach ($goods['skus'] as $sku) {
                                    $skindata   = array(
                                        'gf_s_id'   => $this->curr_sid,
                                        'gf_g_id'   => $gid,
                                        'gf_name'   => $sku['title'],
                                        'gf_price'  => floatval($sku['price']),
                                        'gf_stock'  => intval($sku['stock']),
                                        'gf_create_time'    => time(),
                                    );
                                    $format_model->insertValue($skindata);
                                }
                            }
                        }
                    }
                    $diff   = $total-$add;
                    $desc[] = "2、获取商品数量={$total}个";
                    $desc[] = "3、新增商品数量={$add}个";
                    $desc[] = "4、更新商品数量={$diff}个";
                    $button = array('name' => '完成', 'link' => '/wxapp/goods/index');
                }
            } else if ($type == "youzan") {
                $youzan_client  = new App_Plugin_Youzan_OauthClient($this->curr_sid);
                $count  = 50;//每次获取商品条数
                $data   = $youzan_client->getGoodsList(1, $count);
                if (isset($data['status']) && !$data['status']) {
                    $desc   = array('1、商品导入失败', "2、导入失败原因={$data['msg']}");
                    $button = array('name' => '重新导入', 'link' => '/wxapp/goods/import?type=youzan&step=1');
                } else {
                    $desc[] = '1、商品导入成功';
                    $item   = $data['items'];
                    $total  = $data['total_results'];
                    $page_num   = ceil($total/$count);
                    for ($i=2; $i<=$page_num; $i++) {
                        $data   = $youzan_client->getGoodsList($i, $count);
                        $item   = array_merge($item, $data['items']);//合并数组
                    }
                    $goods_model    = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
                    $slide_model    = new App_Model_Goods_MysqlGoodsSlideStorage($this->curr_sid);
                    $add    = 0;
                    foreach ($item as $goods) {
                        $exist  = $goods_model->findGoodsByYzid($goods['num_iid']);
                        if ($exist) {
                            continue;
                        }
                        $detail     = array("<div>{$goods['item_desc']}</div>");

                        $add++;
                        $gdindata   = array(
                            'g_s_id'    => $this->curr_sid,
                            'g_yz_itemid'   => $goods['num_iid'],
                            'g_name'    => $goods['title'],
                            'g_cover'   => $goods['pic_url'],//获取第一个图片作为缩略图
                            'g_c_id'    => 0,//未知类别
                            'g_price'   => $goods['price'],
                            'g_ori_price'=> $goods['price'],//原价等于现价
                            'g_type'    => $goods['is_virtual'] ? 2 : 1,//默认实物
                            'g_is_sale' => $goods['is_listing'] ? 1 : 2,//在售商品
                            'g_stock'   => $goods['num'],
                            'g_sold'    => $goods['sold_num'],
                            'g_limit'   => $goods['buy_quota'],//不限购
                            'g_brief'   => '',//简介置空
                            'g_detail'  => $goods['desc'],
                            'g_expfee_type' => 1,//统一运费
                            'g_unified_fee' => $goods['post_fee'],
                            'g_has_format'  => count($goods['skus']),
                            'g_create_time' => time(),
                            'g_update_time' => time(),
                        );
                        $gid    = $goods_model->insertValue($gdindata);
                        if (count($goods['item_imgs']) > 0) {
                            foreach ($goods['item_imgs'] as $img) {
                                $sdindata   = array(
                                    'gs_s_id'   => $this->curr_sid,
                                    'gs_g_id'   => $gid,
                                    'gs_path'   => $img['url'],
                                    'gs_create_time'    => time(),
                                );
                                $slide_model->insertValue($sdindata);
                            }
                        }
                        if (count($goods['skus']) > 0) {
                            $format_model   = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
                            foreach ($goods['skus'] as $sku) {
                                $skindata   = array(
                                    'gf_s_id'   => $this->curr_sid,
                                    'gf_g_id'   => $gid,
                                    'gf_name'   => $sku['properties_name'],
                                    'gf_price'  => floatval($sku['price']),
                                    'gf_stock'  => intval($sku['quantity']),
                                    'gf_create_time'    => time(),
                                );
                                $format_model->insertValue($skindata);
                            }
                        }
                    }
                    $diff   = $total-$add;
                    $desc[] = "2、获取商品数量={$total}个";
                    $desc[] = "3、新增商品数量={$add}个";
                    $desc[] = "4、更新商品数量={$diff}个";
                    $button = array('name' => '完成', 'link' => '/wxapp/goods/index');
                }
            }
        }

        $this->output['step']   = $step;
        $this->output['desc']   = $desc;
        $this->output['button'] = $button;
        $this->displaySmarty("wxapp/goods/import.tpl");
    }
    
    public function groupAction(){
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $where      = array();
        $where[]    = array('name' => 'gg_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[]    = array('name' => 'gg_is_eshop','oper' => '=','value' =>0);
        $output['name'] = $this->request->getStrParam('name');
        if($output['name']){
            $where[]    = array('name' => 'gg_name','oper' => 'like','value' =>"%{$output['name']}%");
        }

        $group_model    = new App_Model_Goods_MysqlGroupStorage($this->curr_sid);
        $total          = $group_model->getCount($where);
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        $list   = array();
        if($index <= $total){
            $sort = array('gg_create_time' => 'DESC');
            $list = $group_model->getList($where,$index,$this->count,$sort);
            foreach($list as &$val){
                $params = array(
                    'gpid' => $val['gg_id']
                );
                $val['link'] = $this->composeLink('shop','group',$params,true,'none');
            }
        }
        $output['showPage'] = $total > $this->count ? 1 : 0;
        $output['list'] = $list;
        $this->showOutput($output);
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => '#'),
            array('title' => '商品分组', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/goods/goods-group.tpl');
    }

    
    public function saveGroupAction(){
        $result = array(
            'ec' => 400,
            'em' => '分组名称不能为空'
        );
        $id       = $this->request->getIntParam('id');
        $name     = $this->request->getStrParam('name');
        $brief    = $this->request->getStrParam('brief');
        $img      = $this->request->getStrParam('img');
        $style    = $this->request->getIntParam('style');
        $iseshop = $this->request->getIntParam('iseshop');
        if($name){
            $group_model    = new App_Model_Goods_MysqlGroupStorage($this->curr_sid);
            if($id){
                $set = array(
                    'gg_name'       => $name,
                    'gg_list_type'  => $style,
                    'gg_brief'      => $brief,
                    'gg_bg'         => $img
                );
                $ret = $group_model->getRowUpdateByIdSid($id,$this->curr_sid,$set);
            }else{
                $data = array(
                    'gg_s_id'       => $this->curr_sid,
                    'gg_name'       => $name,
                    'gg_list_type'  => $style,
                    'gg_brief'      => $brief,
                    'gg_bg'         => $img,
                    'gg_create_time'=> time(),
                    'gg_is_eshop' => $iseshop
                );
                $ret = $group_model->insertValue($data);
            }
            if($ret){
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功'
                );
            }else{
                $result['em'] = '保存失败';
            }
        }
        App_Helper_OperateLog::saveOperateLog("商品分组【".$name."】保存成功");
        $this->displayJson($result);
    }

    
    public function groupGoodsAction(){
        $this->count= 10;
        $id       = $this->request->getIntParam('id');
        $isShop   = $this->request->getIntParam('isShop');
        $keyword  = $this->request->getStrParam('keyword');
        $page     = $this->request->getIntParam('page',1);
        $page     = $page >=1 ? $page : 1;
        $type     = $this->request->getStrParam('type');
        $index    = ($page - 1)* $this->count;

        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $list        = $goods_model->getGroupGoods($type,$id,$index,$this->count,$keyword, $isShop);
        $total       = $goods_model->getCountGoods($type,$id,$keyword, $isShop);
        $tot_page    = ceil($total/$this->count);

        $menu_helper = new App_Helper_Menu();
        $menu        = $menu_helper->ajaxPageLink($tot_page , $page);

        $data = array(
            'ec'        => 200,
            'list'      => $list,
            'pageHtml'  => $menu
        );
        $this->displayJson($data);
    }

    
    public function giftGoodsAction(){
        $this->count = 10;
        $page     = $this->request->getIntParam('page',1);
        $keyword  = $this->request->getStrParam('keyword');
        $type     = $this->request->getStrParam('type','');
        $knowpayType = $this->request->getIntParam('knowpayType');
        $modalType = $this->request->getStrParam('modalType','');
        $goodsType = $this->request->getStrParam('goodsType','shop');
        $page     = $page >=1 ? $page : 1;
        $index    = ($page - 1)* $this->count;
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        if($goodsType == 'entershop'){
            $where[]     = array('name' => 'g_es_id', 'oper' => '>', 'value' => 0);
        }else{
            $where[]     = array('name' => 'g_es_id', 'oper' => '=', 'value' => 0);
        }
        if($type != 'information'){
            $where[]     = array('name' => 'g_is_discuss', 'oper' => '=', 'value' => 0);
        }
        if($this->wxapp_cfg['ac_type'] == 18){
            $where[]     = array('name' => 'g_kind1', 'oper' => '=', 'value' => 1);
        }
        if($knowpayType){
            $where[]     = array('name' => 'g_knowledge_pay_type', 'oper' => '=', 'value' => $knowpayType);
        }
        if($type == 'informationAppointment'){
            $where[]     = array('name' => 'g_type', 'oper' => '=', 'value' => 3);
        }else{
            $where[]     = array('name' => 'g_type', 'oper' => 'in', 'value' => array(1,2));
        }
        if(!in_array($this->wxapp_cfg['ac_type'],[7]) || $modalType == 'room'){//4697
            $where[] = array('name' => 'g_independent_mall', 'oper' => '=', 'value' => 0);
        }
        if($this->menuType == 'toutiao' && $this->curr_shop['s_entershop_goods_verify'] == 1){
            $where[]     = array('name' => 'g_is_sale', 'oper' => 'not in', 'value' =>[4,5]);
        }


        $field=[];
        if($this->request->getIntParam('self_field',0))
            $field=['g_id','g_cover','g_name','g_price','g_stock'];

        $list        = $goods_model->fetchShopGoodsList($this->curr_sid,$index,$this->count,$keyword, 0, array(), $field,0,0,$type == 'informationAppointment'?3:1,$where);
        foreach ($list as $key => $val){
            $list[$key]['g_format'] = json_encode($this->_get_goods_format($val['g_id']));
        }
        $total       = $goods_model->fetchCountBySid($this->curr_sid,$keyword,0,0,0,$goodsType, $where);
        $tot_page    = ceil($total/$this->count);
        $menu_helper = new App_Helper_Menu();
        $menu        = $menu_helper->ajaxGoodsPageLink($tot_page , $page, $type);

        $data = array(
            'ec'        => 200,
            'list'      => $list,
            'pageHtml'  => $menu
        );
        $this->displayJson($data);
    }

    private function _get_goods_format($gid){
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
        $where = array();
        $where[] = array('name' => 'gf_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'gf_g_id', 'oper' => '=', 'value' => $gid);
        $format         = $format_model->getList($where);
        $data = array();
        foreach($format as $val){
            $data[] = [
                'id'     => $val['gf_id'],
                'name'   => $val['gf_name'].($val['gf_name2']?('-'.$val['gf_name2']):'').($val['gf_name3']?('-'.$val['gf_name3']):''),
                'price'  => $val['gf_price'],
            ];
        }
        return $data;
    }

    
    public function  pointsGoodsAction(){
        $this->count = 10;
        $page     = $this->request->getIntParam('page',1);
        $keyword  = $this->request->getStrParam('keyword');
        $page     = $page >=1 ? $page : 1;
        $index    = ($page - 1)* $this->count;
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $where       = array();
        $where[]     = array('name' => 'g_es_id', 'oper' => '=', 'value' => 0);
        $list        = $goods_model->fetchShopGoodsList($this->curr_sid,$index,$this->count,$keyword, 0, array(),array(),0,0,4,array(4,5));
        $total       = $goods_model->fetchCountBySid($this->curr_sid,$keyword,1);
        $tot_page    = ceil($total/$this->count);

        $menu_helper = new App_Helper_Menu();
        $menu        = $menu_helper->ajaxGoodsPageLink($tot_page , $page);

        $data = array(
            'ec'        => 200,
            'list'      => $list,
            'pageHtml'  => $menu
        );
        $this->displayJson($data);
    }

    
    public function saveGoodsGroupAction(){
        $id     = $this->request->getIntParam('id');
        $gg     = $this->request->getIntParam('gg');
        $type   = $this->request->getStrParam('type');
        $where      = array();
        $where[]    = array('name' => 'gm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]    = array('name' => 'gm_g_id', 'oper' => '=', 'value' => $id);
        $where[]    = array('name' => 'gm_gg_id', 'oper' => '=', 'value' => $gg);
        $match_model = new App_Model_Goods_MysqlGroupMatchStorage($this->curr_sid);
        $group_model = new App_Model_Goods_MysqlGroupStorage($this->curr_sid);
        if($type == 'del'){
            $label = '移除';
            $ret   = $match_model->deleteValue($where);
            $group_model->changeTotalById($gg,2);
        }else{
            $row = $match_model->getRow($where);
            if(empty($row)){
                $data = array(
                    'gm_s_id'  => $this->curr_sid,
                    'gm_g_id'  => $id,
                    'gm_gg_id' => $gg,
                    'gm_create_time' => time()
                );
                $ret = $match_model->insertValue($data);
                $group_model->changeTotalById($gg);
            }else{
                $ret = true;
            }
            $label = '追加';
        }

        if($ret){
            $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
            $group = $group_model->getRowById($id);
            $goods = $goods_model->getRowById($id);
            App_Helper_OperateLog::saveOperateLog("商品分组{$group['gg_name']}{$label}商品【{$goods['g_name']}】成功");
        }

        $this->showAjaxResult($ret,$label);
    }

    
    public function changeWeightAction(){
        $id     = $this->request->getIntParam('id');
        $val    = $this->request->getIntParam('val');
        $set    = array(
            'gm_weight'      => $val,
            'gm_create_time' => time()
        );
        $match_model = new App_Model_Goods_MysqlGroupMatchStorage($this->curr_sid);
        $ret = $match_model->getRowUpdateByIdSid($id,$this->curr_sid,$set);
        if($ret){
            $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
            $goods = $goods_model->getRowById($id);
            App_Helper_OperateLog::saveOperateLog("修改分组商品【{$goods['g_name']}】排序成功");
        }
        $this->showAjaxResult($ret);
    }
    
    public function groupControlAction() {
        $kind_model = new App_Model_Goods_MysqlGroupKindStorage($this->curr_sid);
        $list = $kind_model->getListBySid();
        $data = array();
        foreach($list as $val){
            $data[] = array(
                'id'        => $val['gk_id'],
                'index'     => $val['gk_index'],
                'imgsrc'    => $val['gk_pic'],
                'showstyle' => $val['gk_list_type'],
                'kind'      => $val['gk_gg_id'],
                'kindName'  => $val['gg_name'],
                'showNum'  => $this->show_index_by_num($val['gk_show_num']),
                'name'      => $val['gk_name']
            );
        }
        $this->output['link'] = $this->composeLink('shop','kind',array(),true,'none');
        $this->output['data'] = json_encode($data);
        $this->renderCropTool('/wxapp/index/uploadImg');

        $this->buildBreadcrumbs(array(
            array('title' => '商品分组', 'link' => '/wxapp/goods/group'),
            array('title' => '商品分类设置', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/goods/group-control.tpl");
    }

    public function saveGroupKindAction(){
        $data = $this->request->getArrParam('goods');
        $kind_model = new App_Model_Goods_MysqlGroupKindStorage($this->curr_sid);
        $insert = array();
        foreach($data as $key => $val){
            if($val['id']){
                $set = array(
                    'gk_name'        => $val['name'],
                    'gk_show_num'    => $this->get_num_by_index($val['showNum']),
                    'gk_index'       => $val['index'],
                    'gk_pic'         => $val['imgsrc'],
                    'gk_list_type'   => $val['showstyle'],
                    'gk_gg_id'       => $val['kind'],
                    'gk_update_time' => time(),
                );
                $kind_model->getRowUpdateByIdSid($val['id'] , $this->curr_sid,$set);
            }else{
                $insert[] = "(null,{$this->curr_sid},".intval($val['kind']).",'".plum_sql_quote($val['name'])."','".plum_sql_quote($val['imgsrc'])."',".intval($val['showstyle']).",".$this->get_num_by_index($val['showNum']).",".intval($val['index']).",".time().",".time().")";
            }
        }
        if(!empty($insert)){
            $kind_model->batchInsert($insert);
        }
        App_Helper_OperateLog::saveOperateLog("保存分组分类成功");
        $this->showAjaxResult(true,'保存');
    }

    private function get_num_by_index($index){
        switch($index){
            case 2 :
                $num = 12;
                break;
            case 3 :
                $num = 18;
                break;
            default:
                $num = 6;
        }
        return $num;
    }

    private function show_index_by_num($num){
        switch($num){
            case 12 :
                $index = 2;
                break;
            case 18 :
                $index = 3;
                break;
            default:
                $index = 1;
        }
        return $index;
    }

    public function ajaxGroupAction(){
        $this->count= 10;
        $page       = $this->request->getIntParam('page',1);
        $page       = $page >= 1 ? $page : 1;
        $index      = ($page-1) * $this->count;
        $where      = array();
        $where[]    = array('name' => 'gg_s_id','oper' => '=','value' =>$this->curr_sid);
        $group_model= new App_Model_Goods_MysqlGroupStorage($this->curr_sid);
        $total       = $group_model->getCount($where);
        $tot_page    = ceil($total/$this->count);

        $menu_helper = new App_Helper_Menu();
        $menu        = $menu_helper->ajaxPageLink($tot_page , $page);
        $sort = array('gg_create_time' => 'DESC');
        $list = $group_model->getList($where,$index,$this->count,$sort);
        $data = array(
            'ec'        => 200,
            'list'      => $list,
            'pageHtml'  => $menu
        );
        $this->displayJson($data);
    }

    
    public function delGroupKindAction(){
        $id = $this->request->getIntParam('id');
        $kind_model = new App_Model_Goods_MysqlGroupKindStorage($this->curr_sid);
        $row        = $kind_model->getRowByIdSid($id,$this->curr_sid);
        if($row){
            $where      = array();
            $where[]    = array('name' => 'gk_s_id','oper' => '=','value' =>$this->curr_sid);
            $where[]    = array('name' => 'gk_index','oper' => '>','value' =>$row['gk_index']);
            $kind_model->changeIndex($where);
            $del_ret    = $kind_model->deleteBySidId($id,$this->curr_sid);
        }else{
            $del_ret = false;
        }

        if($del_ret){
            App_Helper_OperateLog::saveOperateLog("分组分类【{$row['gk_name']}】删除成功");
        }

        $this->showAjaxResult($del_ret,'删除');
    }

    

    public function goodsCategoryAction(){
        if($this->wxapp_cfg['ac_type']==32){
            $area_info=$this->get_area_manager();
            if($area_info){
                plum_redirect_with_msg('无查看权限',$_SERVER['HTTP_REFERER'],true);
            }
        }
        

        if(in_array($this->wxapp_cfg['ac_type'],[4,7])){
            $independent = 1;
        }else{
            $independent = 0;
        }
        if(in_array($this->wxapp_cfg['ac_type'],[4,7,32])){
            $hideImg = 1;
        }else{
            $hideImg = 0;
        }
        if(in_array($this->wxapp_cfg['ac_type'],[4,7])){
            $hideShow = 1;
        }else{
            $hideShow = 0;
        }

        $this->output['hideImg'] = $hideImg;
        $this->output['hideShow'] = $hideShow;
        $category = $this->goods_category_son_data(1,$independent);
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => '#'),
            array('title' => '商品类别', 'link' => '#'),
        ));
        $this->output['link'] = $this->composeLink('shop','accordion',array(),true,'none');
        $this->output['category'] = json_encode($category);
        if($this->wxapp_cfg['ac_type'] == 27){
            $this->displaySmarty('wxapp/goods/knowpay-goods-category.tpl');
        }else{
            $this->displaySmarty('wxapp/goods/goods-category.tpl');
        }
    }

    

    public function goodsCategoryIndependentAction(){
        if($this->wxapp_cfg['ac_type']==32){
            $area_info=$this->get_area_manager();
            if($area_info){
                plum_redirect_with_msg('无查看权限',$_SERVER['HTTP_REFERER'],true);
            }
        }


        if(in_array($this->wxapp_cfg['ac_type'],[4,7,27])){
            $independent = 1;
        }else{
            $independent = 0;
        }
        if(in_array($this->wxapp_cfg['ac_type'],[4,7,32,27])){
            $hideImg = 1;
        }else{
            $hideImg = 0;
        }
        if(in_array($this->wxapp_cfg['ac_type'],[4,7,27])){
            $hideShow = 1;
        }else{
            $hideShow = 0;
        }

        $this->output['hideImg'] = $hideImg;
        $this->output['hideShow'] = $hideShow;
        $category = $this->goods_category_son_data(1,$independent);
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => '#'),
            array('title' => '商品类别', 'link' => '#'),
        ));
        $this->output['link'] = $this->composeLink('shop','accordion',array(),true,'none');
        $this->output['category'] = json_encode($category);
        $this->displaySmarty('wxapp/goods/goods-category.tpl');
    }


    
    private function goods_category_son_data($isJson=1,$independent = 0){
        $category_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $first          = $category_model->getListBySid($independent);
        $temp           = array();
        foreach($first as $key => $val){
            if($val['sk_level'] == 1){
                $temp[$val['sk_id']] = array(
                    'id'        => $val['sk_id'],
                    'index'     => ($this->wxapp_cfg['ac_type'] == 27 && !$independent && !$val['sk_weight'])?$key:$val['sk_weight'],
                    'firstName' => $val['sk_name'],
                    'imgSrc'    => $val['sk_logo'] ? $val['sk_logo'] : '/public/manage/img/zhanwei/zw_fxb_640_200.png',
                    'imgShow'   => $val['sk_logo_show'],
                    'show'      => $val['sk_show'],
                    'secondItem'=> array(),
                );
            }elseif($val['sk_fid'] > 0 && $val['sk_level'] == 2){
                $temp[$val['sk_fid']]['secondItem'][] = array(
                    'id'         => $val['sk_id'],
                    'index'      => $val['sk_weight'],
                    'secondName' => $val['sk_name'],
                    'imgSrc'     => $val['sk_logo'],
                    'show'       => $val['sk_show'],
                    'link'       => ""
                );
            }

        }
        if($isJson){
            $category   = array();
            foreach($temp as $tal){
                $category[] = $tal;
            }
            return $category;
        }else{
            return $temp;
        }
    }

    public function saveCategoryAction(){
        $category       = $this->request->getStrParam('category');
        $category       = json_decode($category, true);

        if(in_array($this->wxapp_cfg['ac_type'],[4,7])){
            $independent = 1;
        }else{
            $independent = 0;
        }

        $category_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $hasIds         = array();
        $insert         = array();
        foreach($category as $key=>$fal){
            $imgSrc = strpos($fal['imgSrc'],'zw_fxb_640_200') ? '' : $fal['imgSrc'];
            $fdata = array(
                'sk_name'   =>  $fal['firstName'],
                'sk_logo'   =>  $imgSrc,
                'sk_logo_show' => $fal['imgShow'],
                'sk_weight' =>  $key,
                'sk_fid'    => 0,
                'sk_level'  => 1,
                'sk_show'   => $fal['show'],
                'sk_s_id'   => $this->curr_sid,
                'sk_independent_mall' => $independent

            );
            if($fal['id']){
                $fid = $fal['id'];
                $category_model->getRowUpdateByIdSid($fal['id'],$this->curr_sid,$fdata);
            }else{
                if(count($fal['secondItem']) > 0){
                    $fdata['sk_create_time'] = $_SERVER['REQUEST_TIME'];
                    $fid  = $category_model->insertValue($fdata);
                }else{
                    $fid  = 0;
                    $insert[]  = "(NULL, {$this->curr_sid}, '{$fal['firstName']}', '{$fal['imgSrc']}','{$fal['imgShow']}', '{$key}', '1', '0','{$fal['show']}', '0', '{$_SERVER['REQUEST_TIME']}','{$independent}')" ;
                }
            }
            if($fid > 0){
                $hasIds[]  = $fid;
                foreach($fal['secondItem'] as $sey=>$sal){
                    if($sal['id']){
                        $hasIds[]  = $sal['id'];
                        $sdata = array(
                            'sk_name'   => $sal['secondName'],
                            'sk_weight' => $sey,
                            'sk_logo'   => $sal['imgSrc'],
                            'sk_fid'    => $fid,
                            'sk_level'  => 2,
                            'sk_s_id'   => $this->curr_sid,
                            'sk_show'   => $sal['show']
                        );
                        $category_model->getRowUpdateByIdSid($sal['id'],$this->curr_sid,$sdata);
                    }else{
                        $insert[]  = "(NULL, {$this->curr_sid}, '{$sal['secondName']}', '{$sal['imgSrc']}','1', '{$sey}', '2', '{$fid}','{$sal['show']}', '0', '{$_SERVER['REQUEST_TIME']}','{$independent}')" ;
                    }
                }
            }
        }
        if(!empty($hasIds)){
            $category_model->deleteByIds($hasIds,'not in',$independent);
        }
        if(!empty($insert) ){
            $category_model->insertBatchValue($insert);
        }

        App_Helper_OperateLog::saveOperateLog("商品分类保存成功");

        $this->showAjaxResult(true,'保存');
    }

    public function saveIndependentCategoryAction(){
        $category       = $this->request->getStrParam('category');
        $category       = json_decode($category, true);

        if(in_array($this->wxapp_cfg['ac_type'],[4,7,27])){
            $independent = 1;
        }else{
            $independent = 0;
        }

        $category_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $hasIds         = array();
        $insert         = array();
        foreach($category as $key=>$fal){
            $imgSrc = strpos($fal['imgSrc'],'zw_fxb_640_200') ? '' : $fal['imgSrc'];
            $fdata = array(
                'sk_name'   =>  $fal['firstName'],
                'sk_logo'   =>  $imgSrc,
                'sk_logo_show' => $fal['imgShow'],
                'sk_weight' =>  $key,
                'sk_fid'    => 0,
                'sk_level'  => 1,
                'sk_show'   => $fal['show'],
                'sk_s_id'   => $this->curr_sid,
                'sk_independent_mall' => $independent

            );
            if($fal['id']){
                $fid = $fal['id'];
                $category_model->getRowUpdateByIdSid($fal['id'],$this->curr_sid,$fdata);
            }else{
                if(count($fal['secondItem']) > 0){
                    $fdata['sk_create_time'] = $_SERVER['REQUEST_TIME'];
                    $fid  = $category_model->insertValue($fdata);
                }else{
                    $fid  = 0;
                    $insert[]  = "(NULL, {$this->curr_sid}, '{$fal['firstName']}', '{$fal['imgSrc']}','{$fal['imgShow']}', '{$key}', '1', '0','{$fal['show']}', '0', '{$_SERVER['REQUEST_TIME']}','{$independent}')" ;
                }
            }
            if($fid > 0){
                $hasIds[]  = $fid;
                foreach($fal['secondItem'] as $sey=>$sal){
                    if($sal['id']){
                        $hasIds[]  = $sal['id'];
                        $sdata = array(
                            'sk_name'   => $sal['secondName'],
                            'sk_weight' => $sey,
                            'sk_logo'   => $sal['imgSrc'],
                            'sk_fid'    => $fid,
                            'sk_level'  => 2,
                            'sk_s_id'   => $this->curr_sid,
                            'sk_show'   => $sal['show']
                        );
                        $category_model->getRowUpdateByIdSid($sal['id'],$this->curr_sid,$sdata);
                    }else{
                        $insert[]  = "(NULL, {$this->curr_sid}, '{$sal['secondName']}', '{$sal['imgSrc']}','1', '{$sey}', '2', '{$fid}','{$sal['show']}', '0', '{$_SERVER['REQUEST_TIME']}','{$independent}')" ;
                    }
                }
            }
        }
        if(!empty($hasIds)){
            $category_model->deleteByIds($hasIds,'not in',$independent);
        }
        if(!empty($insert) ){
            $category_model->insertBatchValue($insert);
        }

        App_Helper_OperateLog::saveOperateLog("商城商品分类保存成功");
        $this->showAjaxResult(true,'保存');
    }

    
    public function ajaxGoodsCustomCategoryAction(){
        $independent = $this->request->getIntParam('independent',0);

        $category = $this->goods_category_son_data(1,$independent);
        $this->displayJsonSuccess($category);
    }
    
    
    private function _show_public_goods_list(){
        $name  = $this->request->getStrParam('name');
        $gtype = $this->request->getIntParam('gtype');
        if($name){
            $where[] = array('name'=>'pg_name','oper'=>"like",'value'=>"%$name%");
            $this->output['name']  = $name;
        }
        if($gtype){
            $where[] = array('name'=>'pg_type','oper'=>'=','value'=>$gtype);
            $this->output['ptype'] = $gtype;
        }
        $where = array();
        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $pg_model = new   App_Model_Goods_MysqlPublicGoodsStorage();
        $total = $pg_model->getCount($where);
        $pageCfg = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['paginator'] = $pageCfg->render();
        $list   = array();

        if($index <= $total){
            $sort  = array('pg_update_time'=>'DESC');
            $list  = $pg_model->getList($where,$index,$this->count,$sort);
        }
        $this->output['list']   = $list;
        $this->output['shopId'] = $this->curr_sid;
        $this->output['type']   = plum_parse_config('goodsType');
        $this->output['newArr'] = array(0=>'否',1=>'是');
    }
    
    private function _do_add_format($pidArr,$data){
        $pgf_model   =  new  App_Model_Goods_MysqlPublicFormatStorage();
        $where_pgf   =  array();
        $where_pgf[] =  array('name'=>'pgf_pg_id','oper'=>'in','value'=>$pidArr);
        $pgf_list    =  $pgf_model->getList($where_pgf,0,0,'');
        $new_arr     =  array();
        foreach ($pgf_list as $key=>$val){
               $new_arr[] = "(NULL, '{$this->curr_sid}', '{$data[$val['pgf_pg_id']]}', '{$val['pgf_name']}','{$val['pgf_price']}',0,0, 0, '".time()."')";
        }
        $gf_model    = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
        return $gf_model->batchSave($new_arr);
    }
    
    private function _do_add_slide($pidArr,$data){
        $pgs_model  =  new  App_Model_Goods_MysqlPublicSlideStorage();
        $where_pgs   =  array();
        $where_pgs[] =  array('name'=>'pgs_pg_id','oper'=>'in','value'=>$pidArr);
        $pgs_list    =  $pgs_model->getList($where_pgs,0,0,'');
        $new_arr     =  array();
        foreach($pgs_list as $key=>$val){
            $new_arr[] = "(NULL, '{$this->curr_sid}', '{$data[$val['pgs_pg_id']]}', '{$val['pgs_path']}', 0, '".time()."')";
        }
        $gs_model    = new App_Model_Goods_MysqlGoodsSlideStorage($this->curr_sid);
        return $gs_model->batchSave($new_arr);
    }

    
    public function clothesAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => '/wxapp/goods/index?platform=clothes'),
            array('title' => '试衣间', 'link' => '#')
        ));
        $clothes  =  $this->curr_shop['s_clothes_status'];
        $this->_get_clothes_room_img();
        $this->output['test'] = $this->request->getIntParam('test');
        $this->displaySmarty('wxapp/goods/goods-clothes-new.tpl');
    }
    private function _get_clothes_room_img(){
        $page                = $this->request->getIntParam('page');
        $index               = $this->count * $page;
        $output['gid']       = $this->request->getIntParam('gid');
        $output['type']      = $this->request->getStrParam('type','color');
        $imgType             = array('model'=>array('id'=>1,'desc'=>'模特'),'color'=>array('id'=>2,'desc'=>'面料'));
        $clothes_storage     = new App_Model_Goods_MysqlClothesRoomStorage($this->curr_sid);
        $where               = array();
        $where[]             = array('name'=>'gcri_s_id','oper'=>'=','value'=>$this->curr_sid);
        if($output['type']){
            if($output['type'] == 'color'){
                $where[]             = array('name'=>'gcri_g_id','oper'=>'=','value'=>$output['gid']);
            }else{
                $where[]             = array('name'=>'gcri_copy_status','oper'=>'=','value'=>2);//上传的图片
            }
            $output['desc']  = $imgType[$output['type']]['desc'];
            $where[]         = array('name'=>'gcri_type','oper'=>'=','value'=>$imgType[$output['type']]['id']);
        }
        $sort                = array('gcri_create_time'=>'DESC');
        $output['list']      = $clothes_storage->getList($where,$index,$this->count,$sort);
        $total               = $clothes_storage->getCount($where);
        $pageCfg             = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        $product_model     = new App_Model_Goods_MysqlClothesProductStorage($this->curr_sid);
        $output['p_data']  = $product_model->getProductDataByGid($output['gid']);


        $this->output['choseLink'] = array(
            array('href'  => '/wxapp/goods/clothes?type=model&gid='.$output['gid'],'key'=> 'model','label' => '模特'),
            array('href'  => '/wxapp/goods/clothes?type=color&gid='.$output['gid'],'key'=> 'color','label' => '面料'),
        );
        $this->showOutput($output);
    }
    
    private function create_qrcode($id, $cover='',$independent = 0){
        $good_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        if(!$cover){
            $good  = $good_model->getRowById($id);
            $cover = $good['g_cover'];
        }
        $str = "id=".$id;

        if($this->wxapp_cfg['ac_type'] == 33){
            $code_path = $client_plugin::CAR_GOODS_DETAIL;
        }elseif (in_array($this->wxapp_cfg['ac_type'],[4,7,27]) && $independent == 1){
            $code_path = $client_plugin::MEAL_MALL_GOODS_DETAIL;
        }else{
            $code_path = $client_plugin::GOODS_DETAIL_CODE_PATH;
        }

        $url = $client_plugin->fetchWxappShareCode($str, $code_path, 210, $cover);

        $updata = array('g_qrcode'=>$url);
        $good_model->updateById($updata,$id);
        return $url;
    }

    
    public function createQrcodeAction(){
        $id = $this->request->getIntParam('id');
        $independent = $this->request->getIntParam('independent',0);
        $url = $this->create_qrcode($id,'',$independent);
        $res = array('ec'=> 200,'em'=> '创建成功！','url'=> $url);
        $this->displayJson($res);
    }

    
    public function downloadGoodsQrcodeAction() {
        $id = $this->request->getIntParam('id');
        if($id){
            $good_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
            $goods = $good_model->getRowById($id);
            $file       = PLUM_DIR_ROOT.$goods['g_qrcode'];
            $filesize   = filesize($file);
            $filename   = $goods['g_name'].".jpg";

            plum_send_http_header("Content-type: application/octet-stream");
            plum_send_http_header("Accept-Ranges: bytes");
            plum_send_http_header("Accept-Length:".$filesize);
            plum_send_http_header("Content-Disposition: attachment; filename=".$filename);

            readfile($file);
        }
    }

    
    public function newAddAction($isActivity = ''){
        $id  = $this->request->getIntParam('id');
        $test = $this->request->getIntParam('test');
        $row = array(); $slide = array();$format = array();

        if(in_array($this->wxapp_cfg['ac_type'],[4,7,27])){
            $independent = 1;
        }else{
            $independent = 0;
        }
        $this->output['independent'] = $independent;
        $formatNum = 0;
        if($id){
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            $row = $goods_model->getRowByIdSid($id,$this->curr_sid);
            $esId = $row['g_es_id'];
            if(!empty($row)){
                if($row['g_recommend_goods']){
                    $gidArr = json_decode($row['g_recommend_goods'],1);
                    if(!empty($gidArr)){
                        $where_goods[]    = array('name' => 'g_id', 'oper' => 'in', 'value' => $gidArr);
                        $where_goods[]    = array('name' => 'g_s_id', 'oper' => '=', 'value' =>$this->curr_sid);
                        $where_goods[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => 1);
                        $goodsList = $goods_model->getList($where_goods,0,10,array(),array('g_id','g_name'));
                    }
                    $this->output['goodsList'] = $goodsList;
                }
                $slide_model    = new App_Model_Goods_MysqlGoodsSlideStorage($this->curr_sid);
                $slide          = $slide_model->getSlideByGid($row['g_id']);
                $format_model   = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
                $format         = $format_model->getListByGid($row['g_id']);
                if(!$row['g_format_type'] && $format){
                    $spec = [
                        [
                            'name' => '规格',
                            'value' => []
                        ]
                    ];
                    foreach($format as $val){
                        $spec[0]['value'][] = [
                            'name' => $val['gf_name'],
                            'img'  => $val['gf_img']
                        ];
                        $dataList[] = array(
                            'spec'=> [$val['gf_name']],
                            'oriPrice'=> $val['gf_ori_price'],
                            'price'=> $val['gf_price'],
                            'stock'=> $val['gf_stock'],
                            'weight' => $val['gf_format_weight'],
                            'weightType' => $val['gf_format_weight_type']
                        );
                    }
                }else{
                    $spec = $row['g_format_type']?json_decode($row['g_format_type'],true):[];
                    foreach($format as $val){
                        $dataList[] = array(
                            'spec'=> [$val['gf_name']],
                            'oriPrice'=> $val['gf_ori_price'],
                            'price'=> $val['gf_price'],
                            'stock'=> $val['gf_stock'],
                            'weight' => $val['gf_format_weight'],
                            'weightType' => $val['gf_format_weight_type']
                        );
                    }
                }
            }
        }

        if($isActivity){
            $this->output['isActivity'] = 1;
            switch ($isActivity){
                case 'group':
                    $citymall_controller = new App_Controller_Wxapp_CitymallController();
                    $secondLink = $citymall_controller->secondLink('goodsList',true);
                    break;
            }
            $this->output['secondLink'] = $secondLink['secondLink'];
            $this->output['linkType'] = $secondLink['linkType'];
            $this->output['snTitle'] = $secondLink['snTitle'];
        }
        $template_storage = new App_Model_Shop_MysqlShopDeliveryTemplateStorage();
        $sort = array('sdt_update_time' => 'DESC');
        $where = array();
        $where[] = array('name' => 'sdt_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'sdt_es_id', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'sdt_deleted', 'oper' => '=', 'value' => 0);
        $tempList = $template_storage->getList($where, 0, 0, $sort);
        $message_storage = new App_Model_Goods_MysqlMessageTemplateStorage();
        $sort = array('amt_update_time' => 'DESC');
        $where = array();
        $where[] = array('name' => 'amt_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'amt_es_id', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'amt_deleted', 'oper' => '=', 'value' => 0);
        $messageList = $message_storage->getList($where, 0, 0, $sort);
        $level_model = new App_Model_Member_MysqlLevelStorage();
        $list = $level_model->getListBySid($this->curr_sid);
        $this->output['levelList'] = $list?json_encode($list):json_encode(array());
        $this->output['types']       = plum_parse_config('goodsType');
        $this->output['row']    = $row;
        $this->output['slide']  =  $slide;
        $this->output['format'] =  $format;
        $this->output['messageList'] = $row['g_extra_message']?$row['g_extra_message']:json_encode(array());
        $this->output['vipPriceList'] = $row['g_vip_price_list']?$row['g_vip_price_list']:json_encode(array());
        $this->output['spec']  = json_encode($spec?$spec:[]);
        $this->output['dataList']  = json_encode($dataList?$dataList:[]);
        $this->output['formatSort'] = implode(',',$sort);
        $this->output['tempList'] = $tempList;
        $this->output['messageListData'] = $messageList;
        $this->output['sid'] = $this->curr_sid;
        $this->renderCropTool('/wxapp/index/uploadImg');
        if($esId > 0 && $this->wxapp_cfg['ac_type'] == 6){
            $titleLink = '/wxapp/citymall/goodsList';
            $titleName = '商品添加';
        }elseif ($esId > 0 && $this->wxapp_cfg['ac_type'] == 33){
            $titleLink = '/wxapp/car/goodsList';
            $titleName = '商品编辑';
        }else{
            $titleLink = '/wxapp/goods/index';
            $titleName = '商品添加/编辑';
        }
        $this->output['backUrl'] = $titleLink;
        $showUnit = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[21,6,8])){
            $showUnit = 1;
        }
        $this->output['showUnit'] = $showUnit;

        $pickupTime = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[21])){
            $pickupTime = 1;
        }
        $this->output['pickupTime'] = $pickupTime;

        $this->output['ac_type'] = $this->wxapp_cfg['ac_type'];

        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => $titleLink),
            array('title' => $titleName, 'link' => '#')
        ));

        if($test == 123){
            $this->displaySmarty('wxapp/goods/goods-new-test.tpl');
        }else{
            $this->displaySmarty('wxapp/goods/goods-new.tpl');
        }

    }

    
    public function newSaveAction(){
        $result = array(
            'ec' => 400,
            'em' => '请填写完整商品数据',
            'id' => 0
        );

        $formatList = json_decode($this->request->getStrParam('formatList'),true);
        $temp_psf = $this->math_price_stock_format();
        $id       = $this->request->getIntParam('id');
        $intField = array('g_sold','g_type','g_weight','g_limit','g_vip_discount', 'g_show_num', 'g_day_limit');
        $data     = $this->getIntByField($intField);
        $data['g_name']         = $this->request->getStrParam('g_name');
        $data['g_cost']         = $this->request->getFloatParam('g_cost');
        $data['g_price']        = $temp_psf['price'];
        $data['g_stock']        = $temp_psf['stock'];
        $data['g_has_format']   = count($formatList);
        $data['g_small_num']    = $this->request->getIntParam('g_small_num',1);
        $data['g_small_num']    = $data['g_small_num'] > 0 ? $data['g_small_num'] : 1;

        $data['g_ori_price']    = $temp_psf['oriPrice'];
        $data['g_unified_fee']  = $this->request->getFloatParam('g_unified_fee');
        $data['g_goods_weight']  = $temp_psf['weight'];
        $data['g_goods_weight_type']  = $temp_psf['weightType'];

        $data['g_cover']        = $this->request->getStrParam('g_cover');
        $data['g_expfee_type']  = $this->request->getStrParam('g_expfee_type');
        $data['g_unified_tpid']  = $this->request->getStrParam('g_unified_tpid');
        $data['g_message_tpid'] = $this->request->getStrParam('g_message_tpid');
        $data['g_brief']        = $this->request->getStrParam('g_brief'); ;
        $data['g_detail']       = $this->request->getStrParam('g_detail');
        $data['g_parameter']    = $this->request->getStrParam('g_parameter');
        $istop                  = $this->request->getStrParam('g_is_top');
        $isDiscuss              = $this->request->getStrParam('g_is_discuss');
        $vipbuy                 = $this->request->getStrParam('g_vip_buy');
        $stockShow              = $this->request->getStrParam('g_stock_show');
        $soldShow               = $this->request->getStrParam('g_sold_show');
        $showNumShow            = $this->request->getStrParam('g_show_num_show');
        $expfeeShow             = $this->request->getStrParam('g_expfee_show');
        $joinDiscount           = $this->request->getStrParam('g_join_discount');
        $dayShow                = $this->request->getStrParam('g_sequence_day_show');
        $g_applay_goods_show    = $this->request->getStrParam('g_applay_goods_show','on');
        $data['g_is_back']      = $this->request->getIntParam('good_tag_0');
        $data['g_is_quality']   = $this->request->getIntParam('good_tag_1');
        $data['g_is_truth']     = $this->request->getIntParam('good_tag_2');
        $data['g_is_global']     = $this->request->getIntParam('g_is_global');
        $data['g_is_top']       = ($istop == 'on' || $istop == 1)? 1 : 0;
        $data['g_is_discuss']       = ($isDiscuss == 'on' || $isDiscuss == 1)? 1 : 0;
        $data['g_vip_buy']      = ($vipbuy == 'on' || $vipbuy == 1)? 1 : 0;
        $data['g_show_num_show']= ($showNumShow == 'on' || $showNumShow == 1)? 1 : 0;
        $data['g_stock_show']   = ($stockShow == 'on' || $stockShow == 1)? 1 : 0;
        $data['g_sold_show']    = ($soldShow == 'on' || $soldShow == 1)? 1 : 0;
        $data['g_expfee_show']    = ($expfeeShow == 'on' || $expfeeShow == 1)? 1 : 0;
        $data['g_join_discount']  = ($joinDiscount == 'on' || $joinDiscount == 1)? 1 : 0;
        $data['g_applay_goods_show']    = ($g_applay_goods_show == 'on' || $g_applay_goods_show == 1 )? 1 : 0;
        $cusCategory            = $this->_get_custom_category();
        $data['g_kind1']        = $cusCategory['kind1'];
        $data['g_kind2']        = $cusCategory['kind2'];
        $data['g_s_id']         = $this->curr_sid;
        $data['g_update_time']  = time();
        $data['g_format_type']  = $this->request->getStrParam('formatType');
        $data['g_extra_message']= $this->request->getStrParam('messageList');
        $data['g_recommend_goods']= $this->request->getStrParam('gids');
        $data['g_video_url']    = $this->request->getStrParam('g_video');
        $data['g_vr_url']    = $this->request->getStrParam('g_vr');
        $data['g_custom_label'] = $this->request->getStrParam('g_custom_label');
        $data['g_list_label'] = $this->request->getStrParam('g_list_label');
        $data['g_discuss_info'] = $this->request->getStrParam('g_discuss_info');
        $data['g_unit_name'] = $this->request->getStrParam('g_unit_name');
        $data['g_fake_buynum'] = $this->request->getIntParam('g_fake_buynum',0);
        $data['g_sequence_day'] = $this->request->getIntParam('sequence_day',0);
        $data['g_supplier_id'] = $this->request->getIntParam('g_supplier_id',0);
        $data['g_pick_self']    =$this->request->getIntParam('pick_goods_self',1);
        if($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36){
            $data['g_hotel_stock'] = $this->request->getIntParam('g_hotel_stock');
            $hasWindow = $this->request->getStrParam('g_has_window');//社区团购设置新人专享商品
            $data['g_has_window'] = ($hasWindow == 'on' || $hasWindow == 2)? 2 : 1;
            $data['g_date_price'] = $this->request->getFloatParam('g_date_price');
            if($data['g_has_window'] == 2 && $data['g_date_price'] <= 0 ){
                $this->displayJsonError('请填写新人专享购买价格');
            }
        }


        if($this->wxapp_cfg['ac_type'] == 21){
            $data['g_sequence_day_show']  = ($dayShow == 'on' || $dayShow == 1)? 1 : 0;
        }
        $area_info=$this->get_area_manager();
        if($area_info){
            $data['g_region_add_by']=$this->uid;
            $seqcfg_model = new App_Model_Sequence_MysqlSequenceCfgStorage($this->curr_sid);
            $seq_cfg = $seqcfg_model->findUpdateBySid();
            if($seq_cfg['asc_region_goods_verify'] == 1){
                $data['g_is_sale'] = 4;
            }
        }


        if(in_array($this->wxapp_cfg['ac_type'],[4,7,27])){
            $independent = 1;
        }else{
            $independent = 0;
        }
        $data['g_independent_mall'] = $independent;

       

        if(!$data['g_cover']){
            $maxNum         = $this->request->getStrParam('slide-img-num');
            for($i=0; $i< $maxNum; $i++){
                $temp = $this->request->getStrParam('slide_'.$i);
                $temp_sort = $this->request->getIntParam('slide_sort_'.$i);
                $temp = plum_sql_quote($temp);
                if($temp_sort == 0){
                    $data['g_cover'] = $temp;
                }
            }
        }
        if($data['g_limit'] > 0 && $data['g_limit'] < $data['g_small_num']){
            $this->displayJsonError('单人限购数量不能小于起购数量');
        }
        if($data['g_limit'] > 0 && $data['g_limit'] < $data['g_day_limit']){
            $this->displayJsonError('单人限购数量不能小于单日限购数量');
        }
        if($data['g_day_limit'] > 0 && $data['g_day_limit'] < $data['g_small_num']){
            $this->displayJsonError('单日限购数量不能小于起购数量');
        }
        $region_goods_ratio = $this->request->getStrParam('region_goods_ratio','');
        if($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36){
            $plugin_model = new App_Model_Applet_MysqlAppletPluginStorage($this->curr_sid);
            $plugin_row = $plugin_model->findUpdateBySid('qyhhr');
            if ($plugin_row && $plugin_row['apo_expire_time']>time() ){ 
                if(is_numeric($region_goods_ratio)){
                    if($region_goods_ratio < 0 || $region_goods_ratio > 100){
                        $this->displayJsonError('请填写正确的区域合伙人分佣比例');
                    }
                }else{
                    if($region_goods_ratio != ''){
                        $this->displayJsonError('请填写正确的区域合伙人分佣比例');
                    }
                }
           }
        }
        
        $goods_ratio = $this->request->getStrParam('goods_ratio','');

        if($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36){
            if(is_numeric($goods_ratio)){
                if($goods_ratio < 0 || $goods_ratio > 100){
                    $this->displayJsonError('请填写正确的分佣比例');
                }
            }else{
                if($goods_ratio != ''){
                    $this->displayJsonError('请填写正确的分佣比例');
                }
            }
        }

        if(mb_strlen($data['g_list_label']) > 4){
            $this->displayJsonError('商品列表标签最多4个字');
        }

        if($data['g_fake_buynum'] < 0 ){
            $this->displayJsonError('购买人数不能小于0');
        }

        if($data['g_name'] && $data['g_cover']){

            $is_add = 0;
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            if($id){
                if($this->wxapp_cfg['ac_type'] == 6){
                    $goodsRow = $goods_model->getRowById($id);
                    if($goodsRow['g_es_id'] > 0){
                        $data['g_vip_price'] = $this->request->getFloatParam('g_vip_price');
                        unset($data['g_kind1']);
                        unset($data['g_kind2']);
                    }
                }
                $ret = $goods_model->getRowUpdateByIdSid($id,$this->curr_sid,$data);
            }else{
                $data['g_create_time'] = time();
                $data['g_create_day'] = date('Y-m-d', time());
                $ret = $goods_model->insertValue($data);
                $id  = $ret;
                $is_add = 1;
            }
            if($ret){
                $this->batchSlide($id,$is_add);
                $this->batchFormat($id,$is_add);
                if($is_add){
                    $this->create_qrcode($ret,'',$independent);
                }else{
                    plum_open_backend('index', 'updateGoods', array('sid' => $this->curr_sid, 'gid' => $id));
                }
                if($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36){
                    if(is_numeric($goods_ratio) || $goods_ratio == ''){
                        $this->_save_sequence_goods_ratio($id,$goods_ratio);
                    }
                    if ($plugin_row && $plugin_row['apo_expire_time']>time() ){
                        if(is_numeric($region_goods_ratio) || $region_goods_ratio == ''){
                            $this->_save_sequence_region_goods_ratio($id,$region_goods_ratio);
                        }
                    }
                    if($data['g_is_sale'] == 4){
                        $message_helper = new App_Helper_ShopMessage($this->curr_sid);
                        $message_helper->messageRecord($message_helper::SEQUENCE_REGION_GOODS_SEND);
                    }
                    
                }
                if($this->curr_shop['s_watermark_open']){
                    $imgData = json_encode(array($data['g_cover']));
                    plum_open_backend('post','addWatermark',array('imgdata'=>rawurlencode($imgData),'sid'=>$this->curr_sid));
                }
                App_Helper_OperateLog::saveOperateLog("商品【".$data['g_name']."】信息保存成功,库存".$data['g_stock']);
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功',
                    'id' => $id
                );
                if($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36){
                    $trade_redis_model   = new App_Model_Trade_RedisTradeStorage($this->curr_sid);     
                    $trade_redis_model->sequenceSetGoodsStockStatus($id);
                }
            }else{
                $result['em'] = '保存失败';
            }
        }
        $this->displayJson($result);
    }

    
    private function _save_sequence_goods_ratio($id,$goods_ratio){
        $ratio_model = new App_Model_Sequence_MysqlSequenceGoodsDeductStorage($this->curr_sid);
        $row = $ratio_model->getRowByGid($id);

        $set = [
            'asgd_update_time' => time(),
            'asgd_1f_ratio'    => $goods_ratio
        ];

        if($row){
            $ratio_model->updateById($set,$row['asgd_id']);
        }else{
            $set['asgd_s_id'] = $this->curr_sid;
            $set['asgd_g_id'] = $id;
            $set['asgd_create_time'] = time();
            $ratio_model->insertValue($set);
        }
    }
    
    private function _save_sequence_region_goods_ratio($goods_id,$goods_ratio){
        $region_ratio_model = new App_Model_Sequence_MysqlSequenceRegionGoodsDeductStorage($this->curr_sid);
        $row = $region_ratio_model->getRowByGid($goods_id);

        $set = [
            'asrgd_update_time' => time(),
            'asrgd_1f_ratio'    => $goods_ratio
        ];

        if($row){
            $region_ratio_model->updateById($set,$row['asrgd_id']);
        }else{
            $set['asrgd_s_id'] = $this->curr_sid;
            $set['asrgd_g_id'] = $goods_id;
            $set['asrgd_create_time'] = time();
            $region_ratio_model->insertValue($set);
        }
    }

    
    private function batchFormat($goId,$is_add=0){
        $formatList = json_decode($this->request->getStrParam('formatList'),true);
        $go_price   = $this->request->getFloatParam('g_price');

        $totalStock     = 0;
        $format         = array();
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
        if($is_add){
            foreach($formatList as $key => $val){
                $name1      = $val['spec'][0]?addslashes($val['spec'][0]['name']):'';
                $name2      = $val['spec'][1]?addslashes($val['spec'][1]['name']):'';
                $name3      = $val['spec'][2]?addslashes($val['spec'][2]['name']):'';
                $img        = $val['spec'][0]?$val['spec'][0]['img']:'';
                $tem_price  = $val['price'];
                $weight     = $val['weight'];
                $weightType = $val['weightType'];
                $oriPrice   = $val['oriPrice'];
                $newmemberPrice   = $val['newmemberPrice'];
                $sort       = $key;
                $price      = $tem_price ? $tem_price : $go_price ;
                $cost       = $val['cost'];
                $format[]   = "(NULL, '{$this->curr_sid}', '{$goId}', '{$name1}','{$name2}','{$name3}','{$img}','{$oriPrice}','{$price}','{$val['stock']}','{$weight}','{$weightType}','{$sort}', 0, '".time()."','{$cost}','{$newmemberPrice}')";
                $totalStock = $totalStock + $val['stock'];
            }
        }else{
            $gf_id = array();
            $del_id = array();
            $old_format = $format_model->getListByGid($goId);
            foreach($old_format as $key => $val){
                if($formatList[$key]){
                    $temp = array(
                        'gf_name'   => $formatList[$key]['spec'][0]?addslashes($formatList[$key]['spec'][0]['name']):'',
                        'gf_name2'  => $formatList[$key]['spec'][1]?addslashes($formatList[$key]['spec'][1]['name']):'',
                        'gf_name3'  => $formatList[$key]['spec'][2]?addslashes($formatList[$key]['spec'][2]['name']):'',
                        'gf_img'    => $formatList[$key]['spec'][0]?$formatList[$key]['spec'][0]['img']:'',
                        'gf_ori_price' => $formatList[$key]['oriPrice'],
                        'gf_newmember_price' => $formatList[$key]['newmemberPrice'],
                        'gf_cost'   => $formatList[$key]['cost'],
                        'gf_price'  => $formatList[$key]['price'] ? $formatList[$key]['price'] : $go_price,
                        'gf_format_weight' => $formatList[$key]['weight'] ? $formatList[$key]['weight'] : 0,
                        'gf_format_weight_type' => $formatList[$key]['weightType'] ? $formatList[$key]['weightType'] : 1,
                        'gf_stock'  => $formatList[$key]['stock'],
                        'gf_sort'   => $key
                    );
                    $format_model->updateFormat($val['gf_id'],$temp);
                    unset($formatList[$key]);
                }else{
                    $del_id[] = $val['gf_id'];
                }
            }
            foreach($formatList as $key => $val){
                $name1      = $val['spec'][0]?addslashes($val['spec'][0]['name']):'';
                $name2      = $val['spec'][1]?addslashes($val['spec'][1]['name']):'';
                $name3      = $val['spec'][2]?addslashes($val['spec'][2]['name']):'';
                $img        = $val['spec'][0]?$val['spec'][0]['img']:'';
                $tem_price  = $val['price'];
                $weight     = $val['weight'];
                $weightType = $val['weightType'];
                $oriPrice   = $val['oriPrice'];
                $newmemberPrice   = $val['newmemberPrice'];
                $sort       = $key;
                $price      = $tem_price ? $tem_price : $go_price ;
                $cost       =$val['cost'];
                $format[]   = "(NULL, '{$this->curr_sid}', '{$goId}', '{$name1}','{$name2}','{$name3}','{$img}','{$oriPrice}','{$price}','{$val['stock']}','{$weight}','{$weightType}','{$sort}', 0, '".time()."','{$cost}','{$newmemberPrice}')";
                $totalStock = $totalStock + $val['stock'];
            }
            if(!empty($del_id)){
                $format_model->deleteFormat($goId,$del_id);
            }
        }
        if(!empty($format)){
            $format_model->newBatchSave($format);
        }
    }
    public function commonGoodsAction() {
        $area_info=$this->get_area_manager();
        if($area_info){
            plum_redirect_with_msg('无当前页面的访问权限',$_SERVER['HTTP_REFERER'],1);
        }



        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => '#'),
        ));
        $this->_show_common_goods_list_data();
        $this->displaySmarty("wxapp/goods/common-goods-list.tpl");
    }

    private function _show_common_goods_list_data(){
        $type = $this->request->getIntParam('type', 1);
        $open_storage = new App_Model_Agent_MysqlOpenStorage(0);
        $agent = $open_storage->getAgentBySid($this->curr_sid, 0);
        $agentid = $agent?$agent['ao_a_id']:-1;
        $where = array();
        if($type == 1){
            $where[] = array('name' => 'g_s_id','oper' => '=','value' =>$agentid);
        }else{
            $where[] = array('name' => 'g_s_id','oper' => '=','value' =>0);
        }
        $where[]        = array('name' => 'g_type','oper' => 'in','value' => array(1,2));
        $where[]        = array('name' => 'g_deleted','oper' => '=','value' => 0);
        $output['name']     = $this->request->getStrParam('name');
        if($output['name']){
            $where[] = array('name' => 'g_name','oper' => 'like','value' =>"%{$output['name']}%");
        }
        $output['cate'] = $this->request->getIntParam('cate');
        if($output['cate']){
            $where[] = array('name' => 'g_kind2','oper' => '=','value' =>$output['cate']);
        }
        $output['gtype']     = $this->request->getIntParam('gtype');
        if($output['gtype']){
            $where[] = array('name' => 'g_type','oper' => '=','value' =>$output['gtype']);
        }
        $output['selDeduct']     = $this->request->getIntParam('selDeduct');
        if($output['selDeduct']){
            $where[] = array('name' => 'g_is_deduct','oper' => '=','value' =>($output['selDeduct']-1));
        }
        

        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $goods_model = new App_Model_Agent_MysqlCommonGoodsStorage();
        $total = $goods_model->getCount($where);
        $pageCfg = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        $list   = array();
        if($index <= $total){
            $sort = array('g_update_time' => 'DESC');
            $list = $goods_model->getList($where,$index,$this->count,$sort);
            $deduct_gids = array();
            foreach($list as $key=>$val){
                $deduct_gids[] = $val['g_id'];
                $param = array(
                    'gid' => $val['g_id']
                );
            }
        }
        if($list){
            $output['now'] = 1;
        }
        $output['list'] = $list;
        $output['type'] = $type;
        $output['appletCfg'] = $this->wxapp_cfg;
        $this->showOutput($output);
    }
    public function common2ShopAction(){
        $ids = $this->request->getStrParam('ids');
        $id_arr = plum_explode($ids);
        $open_model = new App_Model_Agent_MysqlOpenStorage(0);
        $agent = $open_model->getAgentBySid($this->curr_sid, 0);
        $common_goods_model  = new App_Model_Agent_MysqlCommonGoodsStorage();
        $common_slide_model  = new App_Model_Agent_MysqlCommonGoodsSlideStorage(0);
        $common_format_model = new App_Model_Agent_MysqlCommonFormatStorage(0);
        $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
        $slide_model    = new App_Model_Goods_MysqlGoodsSlideStorage($this->curr_sid);
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
        foreach($id_arr as $val){//$val['gid']
            $data     = array();
            $goodData = $common_goods_model->getRowById($val);
            foreach ($goodData as $key=>$item){
                $data[$key] = $item;
            }
            $data['g_s_id'] = $this->curr_sid;
            $data['g_create_time'] = time();
            $data['g_update_time'] = time();

            if(in_array($this->wxapp_cfg['ac_type'],[4,7,27])){
                $data['g_independent_mall'] = 1;
            }else{
                $data['g_independent_mall'] = 0;
            }

            unset($data['g_id']);
            unset($data['g_es_id']);
            unset($data['g_g_id']);
            unset($data['g_qrcode']);
            $ret  = $goods_model->insertValue($data);//新商品的id
            if($ret){
                $old_format     = $common_format_model->getListByGid($val);
                if($old_format){
                    foreach ($old_format as $oval){
                        $format[]   = "(NULL, '{$this->curr_sid}', '{$ret}', '{$oval['gf_name']}','{$oval['gf_name2']}','{$oval['gf_name3']}','{$oval['gf_img']}','{$oval['gf_price']}','{$oval['gf_format_weight']}','{$oval['gf_points']}','{$oval['gf_stock']}','{$oval['gf_sort']}', '{$oval['gf_sold']}','".time()."', '{$oval['gf_cake_gift']}')";
                    }
                }
                $old_slide      = $common_slide_model->getListByGidSid($val);
                if($old_slide){
                    foreach($old_slide as $sval){
                        $slide[] = "(NULL, '{$this->curr_sid}', '{$ret}', '{$sval['gs_path']}', 0, '".time()."')";
                    }
                }
            }
        }
        if(!empty($format)){
            $res  = $format_model->copyBatchSave($format);
        }
        if(!empty($slide)){
            $ress = $slide_model->batchSave($slide);
        }
        if($ret  || $ress){
            $result = array(
                'ec' => 200,
                'em' => '导入成功'
            );
            App_Helper_OperateLog::saveOperateLog("商品导入成功");

        }else{
            $result['em'] = '导入失败';
        }
        $this->displayJson($result);
    }
    public function shop2CommonAction(){
        $area_info=$this->get_area_manager();
        if($area_info){
            $this->displayJson(['em'=>'暂无将商品加入商品库的权限'],1);
        }



        $id = $this->request->getIntParam('id');
        $open_model = new App_Model_Agent_MysqlOpenStorage(0);
        $agent = $open_model->getAgentBySid($this->curr_sid, 0);
        $common_goods_model  = new App_Model_Agent_MysqlCommonGoodsStorage();
        $where[] = array('name' => 'g_g_id', 'oper' => '=', 'value' => $id);
        $where[] = array('name' => 'g_s_id', 'oper' => '=', 'value' => $agent['ao_a_id']);
        $where[] = array('name' => 'g_deleted', 'oper' => '=', 'value' => 0);
        $goods = $common_goods_model->getRow($where);
        if($goods){
            $this->displayJsonError('此商品在产品库已存在');
        }
        $common_slide_model  = new App_Model_Agent_MysqlCommonGoodsSlideStorage($agent['ao_a_id']);
        $common_format_model = new App_Model_Agent_MysqlCommonFormatStorage($agent['ao_a_id']);
        $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
        $slide_model    = new App_Model_Goods_MysqlGoodsSlideStorage($this->curr_sid);
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
        $data     = array();
        $goodData = $goods_model->getRowById($id);
        $commonGoodsField = array_keys($common_goods_model->getRow(array()));
        foreach ($goodData as $key=>$item){
            if(in_array($key, $commonGoodsField)){
                $data[$key] = $item;
            }
        }
        $data['g_s_id'] = $agent['ao_a_id'];
        $data['g_g_id'] = $id;
        $data['g_independent_mall'] = 0;
        $data['g_create_time'] = time();
        $data['g_update_time'] = time();
        unset($data['g_id']);
        unset($data['g_qrcode']);
        $ret  = $common_goods_model->insertValue($data);//新商品的id
        if($ret){
            $old_format     = $format_model->getListByGid($id);
            if($old_format){
                foreach ($old_format as $oval){
                    $format[]   = "(NULL, '{$agent['ao_a_id']}', '{$ret}', '{$oval['gf_name']}','{$oval['gf_name2']}','{$oval['gf_name3']}','{$oval['gf_img']}','{$oval['gf_price']}','{$oval['gf_format_weight']}','{$oval['gf_points']}','{$oval['gf_stock']}','{$oval['gf_sort']}', '{$oval['gf_sold']}','".time()."', '{$oval['gf_cake_gift']}')";
                }
            }
            $old_slide      = $slide_model->getListByGidSid($id,$this->curr_sid);
            if($old_slide){
                foreach($old_slide as $sval){
                    $slide[] = "(NULL, '{$agent['ao_a_id']}', '{$ret}', '{$sval['gs_path']}', 0, '".time()."')";
                }
            }
        }

        if(!empty($format)){
            $res  = $common_format_model->copyBatchSave($format);
        }
        if(!empty($slide)){
            $ress = $common_slide_model->batchSave($slide);
        }
        if($ret  || $ress){
            $result = array(
                'ec' => 200,
                'em' => '导入成功'
            );
            App_Helper_OperateLog::saveOperateLog("商品【{$data['g_name']}】导入成功");
        }else{
            $result['em'] = '导入失败';
        }
        $this->displayJson($result);
    }

    
    public function copyShopGoodsAction(){
        $ids = $this->request->getStrParam('ids');
        $gid = $this->request->getIntParam('gid');
        $esId = $this->request->getIntParam('esId');
        $id_arr = plum_explode($ids);
        $common_goods_model  = new App_Model_Agent_MysqlCommonGoodsStorage();
        $common_slide_model  = new App_Model_Agent_MysqlCommonGoodsSlideStorage(0);
        $common_format_model = new App_Model_Agent_MysqlCommonFormatStorage(0);
        $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
        $slide_model    = new App_Model_Goods_MysqlGoodsSlideStorage($this->curr_sid);
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
        foreach($id_arr as $val){//$val['gid']
            $data     = array();
            $goodData = $goods_model->getRowById($gid);
            foreach ($goodData as $key=>$item){
                $data[$key] = $item;
            }
            $data['g_s_id'] = $this->curr_sid;
            $data['g_es_id'] = $val;
            $data['g_sold']  = 0;
            $data['g_create_time'] = time();
            $data['g_update_time'] = time();
            unset($data['g_id']);
            unset($data['g_qrcode']);
            $ret  = $goods_model->insertValue($data);//新商品的id
            if($ret){
                $old_format     = $format_model->getListByGid($gid,$esId);
                if($old_format){
                    foreach ($old_format as $oval){
                        $format[]   = "(NULL, '{$val}','{$this->curr_sid}', '{$ret}', '{$oval['gf_name']}','{$oval['gf_price']}','{$oval['gf_points']}','{$oval['gf_stock']}','{$oval['gf_sort']}', '{$oval['gf_sold']}','".time()."', '{$oval['gf_cake_gift']}')";
                    }
                }
                $old_slide      = $slide_model->getListByGidSid($gid,$this->curr_sid);
                if($old_slide){
                    foreach($old_slide as $sval){
                        $slide[] = "(NULL, '{$this->curr_sid}', '{$ret}', '{$sval['gs_path']}', 0, '".time()."')";
                    }
                }
            }
        }
        if(!empty($format)){
            $res  = $format_model->batchFormatSave($format);
        }
        if(!empty($slide)){
            $ress = $slide_model->batchSave($slide);
        }
        if($ret  || $ress){
            $result = array(
                'ec' => 200,
                'em' => '复制成功'
            );
            App_Helper_OperateLog::saveOperateLog("商品复制成功");
        }else{
            $result['em'] = '复制失败';
        }
        $this->displayJson($result);
    }


    public function goodsDetailAction(){
        $id  = $this->request->getIntParam('id');
        $row = array(); $slide = array();$format = array();
        $open_model = new App_Model_Agent_MysqlOpenStorage(0);
        $agent = $open_model->getAgentBySid($this->curr_sid, 0);
        $formatNum = 0;
        if($id){
            $goods_model = new App_Model_Agent_MysqlCommonGoodsStorage();
            $row = $goods_model->getRowById($id);
            if(!empty($row)){
                $slide_model    = new App_Model_Agent_MysqlCommonGoodsSlideStorage($agent['ao_a_id']);
                $slide          = $slide_model->getSlideByGid($row['g_id']);
                $format_model   = new App_Model_Agent_MysqlCommonFormatStorage($agent['ao_a_id']);
                $format         = $format_model->getListByGid($row['g_id']);
                if(!$row['g_format_type'] && $format){
                    $spec = [
                        [
                            'name' => '规格',
                            'value' => []
                        ]
                    ];
                    foreach($format as $val){
                        $spec[0]['value'][] = [
                            'name' => $val['gf_name'],
                            'img'  => ''
                        ];
                        $dataList[] = array(
                            'spec'=> [$val['gf_name']],
                            'price'=> $val['gf_price'],
                            'stock'=> $val['gf_stock']
                        );
                    }
                }else{
                    $spec = $row['g_format_type']?json_decode($row['g_format_type'],true):[];
                    foreach($format as $val){
                        $dataList[] = array(
                            'spec'=> [$val['gf_name']],
                            'price'=> $val['gf_price'],
                            'stock'=> $val['gf_stock']
                        );
                    }
                }
            }
        }
        $this->output['type']       = plum_parse_config('goodsType');
        $this->output['row']    = $row;
        $this->output['slide']  =  $slide;
        $this->output['format'] =  $format;
        $this->output['spec']  = json_encode($spec?$spec:[]);
        $this->output['dataList']  = json_encode($dataList?$dataList:[]);
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '公共产品库', 'link' => '/wxapp/goods/commonGoods'),
            array('title' => '商品详情', 'link' => '#')
        ));
        $this->displaySmarty('wxapp/goods/goods-detail.tpl');
    }

    public function changeCateAction(){

        $ids = $this->request->getStrParam('ids');
        $cusCategory            = $this->_get_custom_category();
        $id_arr = plum_explode($ids);

        $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
        $area_info=$this->get_area_manager();
        if($area_info){
            $where=[
                ['name'=>'g_s_id','oper'=>'=','value'=>$this->curr_sid],
                ['name'=>'g_id','oper'=>'in','value'=>$id_arr]
            ];
            $shelf_goods_list=$goods_model->getList($where,0,0,[],['g_region_add_by']);
            foreach ($shelf_goods_list as $key => $value) {
                if($value['g_region_add_by']!=$this->uid){
                    $this->displayJson(['em'=>'区域合伙人仅可操作自己添加的商品'],1);
                    break;
                }
            }
        }

        foreach ($id_arr as $value){
            $update = array('g_kind1' => $cusCategory['kind1'], 'g_kind2' => $cusCategory['kind2']);    
            $ret = $goods_model->updateById($update, $value);
        }

        $result = array(
            'ec' => 200,
            'em' => '修改成功'
        );

        $this->displayJson($result);
    }

    public function changeJoinDiscountAction(){
        $ids = $this->request->getStrParam('ids');
        $join = $this->request->getIntParam('join');
        $id_arr = plum_explode($ids);

        $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
        $area_info=$this->get_area_manager();
        if($area_info){
            $where=[
                ['name'=>'g_s_id','oper'=>'=','value'=>$this->curr_sid],
                ['name'=>'g_id','oper'=>'in','value'=>$id_arr]
            ];
            $shelf_goods_list=$goods_model->getList($where,0,0,[],['g_region_add_by']);
            foreach ($shelf_goods_list as $key => $value) {
                if($value['g_region_add_by']!=$this->uid){
                    $this->displayJson(['em'=>'区域合伙人仅可操作自己添加的商品'],1);
                    break;
                }
            }
        }


        foreach ($id_arr as $value){
            $update = array('g_join_discount' => $join);
           
            $goods_model->updateById($update, $value);
        }

        $result = array(
            'ec' => 200,
            'em' => '修改成功'
        );
        $str = $join == 1 ? '修改商品参与会员价' : '修改商品不参与会员价';
        App_Helper_OperateLog::saveOperateLog($str);

        $this->displayJson($result);
    }
    public function getVipPriceAction(){
        $id = $this->request->getIntParam('id');
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $goods = $goods_model->getRowById($id);
        $info = array();
        $level_model = new App_Model_Member_MysqlLevelStorage();
        $level_list = $level_model->getListBySid($this->curr_sid);
        $info['showVip'] = $goods['g_show_vip'];
        if ($goods['g_has_format'] > 0) {
            $info['type'] = 'format';
            $format_model   = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
            $format         = $format_model->getListByGid($goods['g_id']);
            foreach (json_decode($goods['g_format_type'], true) as $name){
                $info['formatName'][] = $name['name'];
            }
            foreach ($format as $v){
                $vipPriceList = json_decode($v['gf_vip_price_list'], true);
                $tempData['name1'] = $v['gf_name'];
                $tempData['name2'] = $v['gf_name2'];
                $tempData['name3'] = $v['gf_name3'];
                $tempData['price'] = $v['gf_price'];
                if($vipPriceList){
                    foreach ($level_list as $key => $value){
                        $tempData['vipPrice'][$key]['id'] = $v['gf_id'];
                        $tempData['vipPrice'][$key]['lid'] = $value['ml_id'];
                        $tempData['vipPrice'][$key]['name'] = $value['ml_name'];
                        $tempData['vipPrice'][$key]['price'] = '';
                        foreach ($vipPriceList as $val){
                            if($value['ml_id'] == $val['identity']){
                                $tempData['vipPrice'][$key]['price'] = $val['price'];
                            }
                        }
                    }
                }else{
                    foreach ($level_list as $key => $value){
                        $tempData['vipPrice'][$key]['id'] = $v['gf_id'];
                        $tempData['vipPrice'][$key]['lid'] = $value['ml_id'];
                        $tempData['vipPrice'][$key]['name'] = $value['ml_name'];
                        $tempData['vipPrice'][$key]['price'] = '';
                    }
                }
                $info['data'][] = $tempData;
            }
        }else{
            $info['type'] = 'goods';
            $vipPriceList = json_decode($goods['g_vip_price_list'], true);
            $tempData['price'] = $goods['g_price'];
            if($vipPriceList){
                foreach ($level_list as $key => $value){
                    $tempData['vipPrice'][$key]['id'] = $goods['g_id'];
                    $tempData['vipPrice'][$key]['lid'] = $value['ml_id'];
                    $tempData['vipPrice'][$key]['name'] = $value['ml_name'];
                    $tempData['vipPrice'][$key]['price'] = '';
                    foreach ($vipPriceList as $val){
                        if($value['ml_id'] == $val['identity']){
                            $tempData['vipPrice'][$key]['price'] = $val['price'];
                        }
                    }
                }
            }else{
                foreach ($level_list as $key => $value){
                    $tempData['vipPrice'][$key]['id'] = $goods['g_id'];
                    $tempData['vipPrice'][$key]['lid'] = $value['ml_id'];
                    $tempData['vipPrice'][$key]['name'] = $value['ml_name'];
                    $tempData['vipPrice'][$key]['price'] = '';
                }
            }
            $info['data'][] = $tempData;
        }
        $this->displayJson($info);
    }
    public function saveVipPriceAction(){
        $area_info=$this->get_area_manager();
        if($area_info){
            $this->displayJson(['em'=>'无操作权限'],1);
        }


        $type    = $this->request->getStrParam('type');
        $showVip = $this->request->getStrParam('showVip', 'true');
        $data    = $this->request->getArrParam('data');
        $priceArr = array();
        $gset = array('g_had_vip_price' => 0, 'g_show_vip' => $showVip=='true'?1:0);
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        foreach ($data as $val){
            $priceArr[$val['id']][] = array(
                'identity' => $val['identity'],
                'price' => $val['price']
            );
            if($this->wxapp_cfg['ac_type'] == 27){
                $gset = array('g_had_vip_price' => 1, 'g_show_vip' => $showVip=='true'?1:0);
            }else{
                if($val['price'] > 0){
                    $gset = array('g_had_vip_price' => 1, 'g_show_vip' => $showVip=='true'?1:0);
                }
            }
        }
        if($type == 'goods'){
            foreach ($priceArr as $key=>$val){
                $gid = $key;
                $set = array('g_vip_price_list' => json_encode($val));
                $goods_model->updateById($set, $key);
            }
        }

        if($type == 'format'){
            $format_model   = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
            foreach ($priceArr as $key=>$val){
                $format = $format_model->getRowById($key);
                $gid = $format['gf_g_id'];
                $set = array('gf_vip_price_list' => json_encode($val));
                $format_model->updateById($set, $key);
            }
        }
        $goods_model->updateById($gset, $gid);

        $goods = $goods_model->getRowById($gid);
        App_Helper_OperateLog::saveOperateLog("保存商品【{$goods['g_name']}】会员价成功");

        $this->showAjaxResult(1);
    }


    public function messageListAction(){
        $page  = $this->request->getIntParam("page");
        $index = $page * $this->count;
        $message_storage = new App_Model_Goods_MysqlMessageTemplateStorage();
        $sort = array('amt_update_time' => 'DESC');
        $where[] = array('name' => 'amt_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'amt_es_id', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'amt_deleted', 'oper' => '=', 'value' => 0);
        $total = $message_storage->getCount($where);
        $list = $message_storage->getList($where, $index, $this->count, $sort);
        $pageCfg = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['paginator'] = $pageCfg->render();
        $this->output['list'] = $list;
        if($this->wxapp_cfg['ac_type'] == 9){
            $this->buildBreadcrumbs(array(
                array('title' => '店铺管理', 'link' => '#'),
                array('title' => '留言模板', 'link' => '#'),
            ));
        }elseif ($this->wxapp_cfg['ac_type'] == 34){
            $legwork_model = new App_Model_Legwork_MysqlLegworkCfgStorage($this->curr_sid);
            $legworkCfg = $legwork_model->findUpdateBySid();
            $this->output['buyMessage'] = intval($legworkCfg['alc_buy_message']);
            $this->output['receiveMessage'] = intval($legworkCfg['alc_receive_message']);
            $this->output['sendMessage'] = intval($legworkCfg['alc_send_message']);

            $this->buildBreadcrumbs(array(
                array('title' => '留言模板', 'link' => '#'),
            ));
        }else{
            $this->buildBreadcrumbs(array(
                array('title' => '商品管理', 'link' => '#'),
                array('title' => '留言模板', 'link' => '#'),
            ));
        }

        $this->displaySmarty("wxapp/goods/message-template-index.tpl");
    }

    public function addMessageListAction(){
        $id = $this->request->getIntParam("id");
        $message_storage = new App_Model_Goods_MysqlMessageTemplateStorage();
        $row = $message_storage->getRowById($id);
        $messageList = json_decode($row['amt_data'], true);
        foreach ($messageList as $key => $val){
            $messageList[$key]['require'] = $val['require'] == 'true'?true:false;
            $messageList[$key]['multi'] = $val['multi'] == 'true'?true:false;
            $messageList[$key]['date'] = $val['date'] == 'true'?true:false;
        }
        $this->output['messageList'] = $messageList?json_encode($messageList):json_encode(array());
        $this->output['row'] = $row;
        $this->output['applet'] = $this->wxapp_cfg;
        $this->buildBreadcrumbs(array(
            array('title' => '模板列表', 'link' => '/wxapp/goods/messageList'),
            array('title' => '留言模板', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/goods/edit-message-template.tpl");
    }

    public function saveMessageListAction(){
        $id = $this->request->getIntParam("id");
        $name = $this->request->getStrParam('name');
        $messageList = $this->request->getArrParam('messageList');
        $message_storage = new App_Model_Goods_MysqlMessageTemplateStorage();
        $data['amt_data'] = json_encode($messageList);
        $data['amt_s_id'] = $this->curr_sid;
        $data['amt_update_time'] = time();
        $data['amt_name'] = $name;
        if($id){
            $ret = $message_storage->updateById($data, $id);
        }else{
            $data['amt_create_time'] = time();
            $ret = $message_storage->insertValue($data);
        }
        App_Helper_OperateLog::saveOperateLog("留言模板【".$name."】保存成功");
        $this->showAjaxResult($ret);
    }

    
    public function deleteMessageTemplateAction(){
        $id = $this->request->getIntParam('id');
        if($id){
            $template_storage = new App_Model_Goods_MysqlMessageTemplateStorage();
            $template = $template_storage->getRowById($id);
            $ret = $template_storage->deleteById($id);
        }
        App_Helper_OperateLog::saveOperateLog("留言模板【".$template['amt_name']."】删除成功");
        $this->showAjaxResult($ret);
    }

    
    public function changeGoodsInfoAction(){       
        $result = array(
            'ec' => 400,
            'em' => '保存失败'
        );
        $id = $this->request->getIntParam('id');
        $field = $this->request->getStrParam('field');
        $value = $this->request->getFloatParam('value');
        $pre='g_';
        $table=$this->request->getStrParam('table','goods');
        $model=null;
        $area_info=$this->get_area_manager();
        $goods_info = [];
        $goods_model=new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        if($area_info){
            $goods_info=$goods_model->getRowById($id);
            if($goods_info['g_region_add_by']!=$this->uid){
                $this->displayJson(['em'=>'无操作权限'],1);
            }
           
        }


        $str = '';
        switch ($table) {
            case 'deduct':
                $str = '团长佣金';
                $pre='asgd_';
                $model= new App_Model_Sequence_MysqlSequenceGoodsDeductStorage($this->curr_sid);
                break;
            case 'region':
                $str = '合伙人佣金';
                $pre='asrgd_';
                $model=new App_Model_Sequence_MysqlSequenceRegionGoodsDeductStorage($this->curr_sid);
                break;
            case 'supplier':
            case 'goods':
            default:
                $str = '信息';
                $model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
                break;
        }


        if($id && $field){
            $goods_field = $pre.$field;
            $set = array(
                $goods_field => $value
            );

            $res = $model->getRowUpdateByIdSid($id,$this->curr_sid,$set);
            if($res){
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功'
                );
                if($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36){
                    $trade_redis_model   = new App_Model_Trade_RedisTradeStorage($this->curr_sid);     
                    $trade_redis_model->sequenceSetGoodsStockStatus($id);
                }
                if(!$goods_info){
                    $goods_info = $goods_model->getRowById($id);
                }
                
                $stock_log='';
                if($field=='stock'){
                    $stock_log=$value;
                }
                App_Helper_OperateLog::saveOperateLog("商品【{$goods_info['g_name']}】{$str}保存成功,库存".$stock_log);
            }
        }else{
            $result = array(
                'ec' => 400,
                'em' => '操作异常'
            );
        }
        $this->displayJson($result);
    }

    
    public function commentGoodsAction(){
        $id = $this->request->getIntParam('id');
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $row = $goods_model->getRowByIdSid($id,$this->curr_sid);
        if($row){
            $format_model   = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
            $format         = $format_model->getListByGid($row['g_id']);
            if(!$row['g_format_type'] && $format){
                $spec = [
                    [
                        'name' => '规格',
                        'value' => []
                    ]
                ];
                foreach($format as $val){
                    $spec[0]['value'][] = [
                        'name' => $val['gf_name'],
                        'img'  => $val['gf_img']
                    ];
                    $dataList[] = array(
                        'spec'=> [$val['gf_name']],
                        'oriPrice'=> $val['gf_ori_price'],
                        'price'=> $val['gf_price'],
                        'stock'=> $val['gf_stock'],
                        'weight' => $val['gf_format_weight']
                    );
                }
            }else{
                $spec = $row['g_format_type']?json_decode($row['g_format_type'],true):[];
                foreach($format as $val){
                    $dataList[] = array(
                        'spec'=> [$val['gf_name']],
                        'oriPrice'=> $val['gf_ori_price'],
                        'price'=> $val['gf_price'],
                        'stock'=> $val['gf_stock'],
                        'weight' => $val['gf_format_weight']
                    );
                }
            }

        }
        $this->renderCropTool('/wxapp/index/uploadImg');
        $memberModel              = new App_Model_Member_MysqlMemberCoreStorage();
        $this->output['memberList'] = $memberModel->getMemberListBySource($this->curr_sid,5);

        $this->output['row']   = $row ? $row : array();
        $this->output['spec']  = $spec?$spec:[];
        $this->output['dataList']  = $dataList?$dataList:[];

        if($this->wxapp_cfg['ac_type'] == 18){
            $url = '/wxapp/reservation/goods';
        }else{
            $url = '/wxapp/goods/index';
        }
        $this->output['jumpUrl'] = $url;
        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => $url),
            array('title' => '评价商品', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/goods/comment-goods.tpl");
    }

    
    public function saveCommentAction(){
        $result = array(
            'ec' => 400,
            'em' => '评价失败'
        );
        $id = $this->request->getIntParam('id');
        $score = $this->request->getIntParam('score');
        $member = $this->request->getIntParam('member');
        $content = $this->request->getStrParam('content');
        $time = $this->request->getStrParam('time');
        $imgArr = $this->request->getArrParam('imgArr');
        $formatArr = $this->request->getArrParam('formatArr');

        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $row = $goods_model->getRowByIdSid($id,$this->curr_sid);
        if($row){
            if (!in_array(intval($score), array(1,2,3,4,5))) {
                $score  = 5;
            }

            $img = !empty($imgArr) ? json_encode($imgArr) : '';
            $format = !empty($formatArr) ? implode(' ',$formatArr) : '';

            $goods_comment  = new App_Model_Goods_MysqlCommentStorage($this->curr_sid);

            $indata = array(
                'gc_s_id'        => $this->curr_sid,
                'gc_g_id'        => $id,
                'gc_es_id'       => $row['g_es_id'],
                'gc_tid'         => '',
                'gc_to_id'       => 0,
                'gc_mid'         => $member,
                'gc_star'        => $score,
                'gc_content'     => $content,
                'gc_create_time' => $time ? strtotime($time) : time(),
                'gc_comment_img' => $img,
                'gc_format'      => $format
            );
            $res = $goods_comment->insertValue($indata);
            if($res){
                $result = array(
                    'ec' => 200,
                    'em' => '评价成功'
                );
                App_Helper_OperateLog::saveOperateLog("商品【{$row['g_name']}】评价成功");
            }else{
                $result['em'] = '评价失败';
            }
        }else{
            $result['em'] = '商品信息不存在';
        }
        $this->displayJson($result);
    }

    
    public function saveLegworkMessageAction(){
        $buyMessage = $this->request->getIntParam('buyMessage');
        $receiveMessage = $this->request->getIntParam('receiveMessage');
        $sendMessage = $this->request->getIntParam('sendMessage');

        $legwork_model = new App_Model_Legwork_MysqlLegworkCfgStorage($this->curr_sid);
        $cfg = $legwork_model->findUpdateBySid();

        $data = [
            'alc_buy_message' => $buyMessage,
            'alc_receive_message' => $receiveMessage,
            'alc_send_message' => $sendMessage,
            'alc_update_time' => time()
        ];

        if($cfg){
            $res = $legwork_model->findUpdateBySid($data);
        }else{
            $data['alc_s_id'] = $this->curr_sid;
            $data['alc_create_time'] = time();
            $res = $legwork_model->insertValue($data);
        }

        if($res){
            App_Helper_OperateLog::saveOperateLog("自定义留言保存成功");
        }

        $this->showAjaxResult($res,'保存');
    }


    
    public function goodsBuyRecordAction(){
        $id = $this->request->getIntParam('id');
        $page = $this->request->getIntParam('page');
        $index = $this->count * $page;
        $sort = ['to_create_time'=>'desc'];
        $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
        $where = [];
        $where[] = ['name' => 'to_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where[] = ['name' => 'to_g_id', 'oper' => '=', 'value' => $id];
        $where[] = ['name' => 't_status', 'oper' => '>', 'value' => 2];
        $where[] = ['name' => 't_status', 'oper' => '<', 'value' => 7];
        $area_info=$this->get_area_manager();
        if($area_info){
            $leader_model=new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
            $leaders=$leader_model->getLeaderByCityId($area_info['m_area_id']);
            $leader_ids=array_unique(array_column($leaders,'asc_leader'));
            if(!$leader_ids)
                $leader_ids=[0];
            $where[]=['name'=>'to_se_leader','oper'=>'in','value'=>$leader_ids];
        }



        $total              = $order_model->getCountTrade($where);
        $page_libs          = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['pageHtml'] =$page_libs->render();
        $list = $order_model->getListTrade($where,$index,$this->count,$sort);
        $this->output['list'] = $list;
        $sumInfo = $order_model->getSum($where);
        $this->output['sumInfo'] = $sumInfo;
        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => '/wxapp/goods/index'),
            array('title' => '购买记录', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/goods/goods-buy-record.tpl');
    }

    
    public function allGoodsJumpAction(){
        $link = $this->request->getStrParam('link');
        $goodsAlert = $this->request->getIntParam('goodsAlert');
        $alertValue = $this->request->getIntParam('alertValue');
        $data = [
            's_all_goods_jump' => $link,
            's_goods_alert_open' => $goodsAlert,
            's_goods_alert_value' => $alertValue
        ];

        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $ret = $shop_model->updateById($data, $this->curr_sid);
        if($ret){

            App_Helper_OperateLog::saveOperateLog("全部商品跳转配置保存成功");
            $this->showAjaxResult(true);
        }else{
            $this->showAjaxResult(false);
        }

    }

    private function _save_send_cfg(){
        $daytime = $this->request->getStrParam('daytime','');

        $set = [
            'acs_sequence_daytime' => $daytime,
            'acs_update_time' => time()
        ];
        $cfg_model = new App_Model_Cake_MysqlCakeSendStorage($this->curr_sid);
        $exist = $cfg_model->findUpdateBySid();
        if($exist){
            $res = $cfg_model->findUpdateBySid($set);
        }else{
            $set['acs_create_time'] = time();
            $set['acs_s_id'] = $this->curr_sid;
            $res = $cfg_model->insertValue($set);
        }
        return $res;
    }


    
    protected function get_area_manager(){
        $manager_model = new App_Model_Member_MysqlManagerStorage();
        $info=$manager_model->getSingleManagerWithArea($this->uid,$this->company['c_id']);
        if($info){
            return [
                'm_id'          =>$info['m_id'],
                'm_area_id'     =>$info['m_area_id'],
                'm_area_type'   =>$info['m_area_type'],
                'region_name'   =>$info['region_name'],
            ];
        }else{
            return null;
        }
    }
    
    private function get_area_manager_goods_limit($region_model,$goods_id,$region_id){
        $where=[
            ['name'=>'asrg_region_id',  'oper'=>'=',    'value'=>$region_id],
            ['name'=>'asrg_goods_id',   'oper'=>'=',    'value'=>$goods_id],
            ['name'=>'asrg_shop_id',    'oper'=>'=',    'value'=>$this->curr_sid]
        ];
        $row=$region_model->getRow($where);
        return $row;
    }

    
    public function openWatermarkAction(){
        $status = $this->request->getIntParam('status');
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $set = array('s_watermark_open'=>$status);
        $ret = $shop_model->updateById($set, $this->curr_sid);

        if($ret){
            $str = $status == 1 ? '开启图片添加水印' : '关闭图片添加水印';
            App_Helper_OperateLog::saveOperateLog($str);
        }


        $this->showAjaxResult($ret);
    }

    
    public function addImageWaterAction(){
        $images = $this->request->getArrParam('images');
        if($this->curr_shop['s_watermark_open']){
            sleep(3);
            $imgData = json_encode($images);
            plum_open_backend('post','addWatermark',array('imgdata'=>rawurlencode($imgData),'sid'=>$this->curr_sid));
        }
    }

    
    private function get_goods_list(){
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $sort        = array('g_weight' => 'DESC','g_update_time'=>'DESC');
        $field       = array('g_id','g_name');
        $where[]     = array('name' => 'g_es_id', 'oper' => '=', 'value' => 0);
        $goods       = $goods_model->fetchShopGoodsList($this->curr_sid,0,0,'',0,$sort,$field, 0, 0, 1, $where);
        $this->output['goodsList'] = $goods;
    }

    public function multiDeleteAction(){

        $ids    = $this->request->getStrParam('ids');
        $id_arr = plum_explode($ids);
        $result = array(
            'ec' => 400,
            'em' => '您尚未选择商品'
        );
        if(!empty($id_arr)){
            $set = array(
                'g_deleted' => 1
            );
            $where   = array();
            $where[] = array('name' => 'g_s_id','oper' => '=','value' =>$this->curr_sid);
            $where[] = array('name' => 'g_id','oper' => 'in','value' =>$id_arr);
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();


            $area_info=$this->get_area_manager();
            if($area_info){
                $shelf_goods_list=$goods_model->getList($where,0,0,[],['g_region_add_by']);
                foreach ($shelf_goods_list as $key => $value) {
                    if($value['g_region_add_by']!=$this->uid){
                        $this->displayJson(['em'=>'区域合伙人仅可删除自己添加的商品'],1);
                        break;
                    }
                }
            }


            $ret = $goods_model->updateValue($set,$where);
            if($ret){
                $result = array(
                    'ec' => 200,
                    'em' => '删除成功'
                );
                App_Helper_OperateLog::saveOperateLog("商品批量删除成功");
            }else{
                $result['em'] = '删除失败';
            }
        }
        $this->displayJson($result);
    }

    
    public function allCommonGoodsAction(){
        $page  = $this->request->getIntParam('page');
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);

        $where   = array();
        $where[] = array('name' => 'g_type','oper' => 'in','value' => array(1,2));
        $output['name']     = $this->request->getStrParam('name');
        if($output['name']){
            $where[] = array('name' => 'g_name','oper' => 'like','value' =>"%{$output['name']}%");
            $curr_shop_goods_id=$goods_model->getList([
                ['name'=>'g_s_id','oper'=>'=','value'=>$this->curr_sid],
                ['name'=>'g_name','oper'=>'like','value' =>"%{$output['name']}%"]
            ],0,0,[],['g_id']);
            $curr_gids=[];
            foreach ($curr_shop_goods_id as $key => $value) {
                $curr_gids[]=$value['g_id'];
            }
            if($curr_gids)
                $where[]=['name'=>'g_id','oper'=>'not in','value'=>$curr_gids];
           
            $total = $goods_model->getCount($where);
            $pageCfg = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
            $output['paginator'] = $pageCfg->render();
            $list   = array();
            if($index <= $total){
                $sort = array('g_sold' => 'DESC','g_create_time' => 'DESC');
                $index = $page * $this->count;
                $list = $goods_model->getList($where, $index, $this->count, $sort, array('g_id', 'g_name', 'g_price', 'g_cover', 'g_update_time','g_sold','g_create_time'));
            }
            $output['list'] = $list;
            $output['noGoods'] = $list?0:1;
        }
        $this->buildBreadcrumbs(array(
            array('title' => '公共商品库', 'link' => '#'),
        ));

        $this->showOutput($output);
        $this->displaySmarty('wxapp/goods/all-common-goods-list.tpl');
    }

    
    public function allCommonGoodsDetailAction(){
        $id  = $this->request->getIntParam('id');
        $row = array(); $slide = array();$format = array();
        if($id){
            $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
            $row = $goods_model->getRowById($id);
            if(!empty($row)){
                $slide_model    = new App_Model_Goods_MysqlGoodsSlideStorage(0);
                $slide          = $slide_model->getSlideByGid($row['g_id']);
                $format_model   = new App_Model_Goods_MysqlFormatStorage(0);
                $format         = $format_model->getListByGid($row['g_id']);
                if(!$row['g_format_type'] && $format){
                    $spec = [
                        [
                            'name' => '规格',
                            'value' => []
                        ]
                    ];
                    foreach($format as $val){
                        $spec[0]['value'][] = [
                            'name' => $val['gf_name'],
                            'img'  => ''
                        ];
                        $dataList[] = array(
                            'spec'=> [$val['gf_name']],
                            'price'=> $val['gf_price'],
                            'stock'=> $val['gf_stock']
                        );
                    }
                }else{
                    $spec = $row['g_format_type']?json_decode($row['g_format_type'],true):[];
                    foreach($format as $val){
                        $dataList[] = array(
                            'spec'=> [$val['gf_name']],
                            'price'=> $val['gf_price'],
                            'stock'=> $val['gf_stock']
                        );
                    }
                }
            }
        }
        $this->output['type']       = plum_parse_config('goodsType');
        $this->output['row']    = $row;
        $this->output['slide']  =  $slide;
        $this->output['format'] =  $format;
        $this->output['spec']  = json_encode($spec?$spec:[]);
        $this->output['dataList']  = json_encode($dataList?$dataList:[]);
        $this->buildBreadcrumbs(array(
            array('title' => '公共商品库', 'link' => '/wxapp/goods/allCommonGoods'),
            array('title' => '商品详情', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/goods/all-common-goods-detail.tpl');
    }
    public function allCommon2ShopAction(){
        $ids = $this->request->getStrParam('ids');
        $id_arr = plum_explode($ids);
        $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
        $slide_model    = new App_Model_Goods_MysqlGoodsSlideStorage(0);
        $format_model   = new App_Model_Goods_MysqlFormatStorage(0);
        foreach($id_arr as $val){//$val['gid']
            $data     = array();
            $goodData = $goods_model->getRowById($val);
            foreach ($goodData as $key=>$item){
                $data[$key] = $item;
            }
            $data['g_s_id'] = $this->curr_sid;
            $data['g_create_time'] = time();
            $data['g_update_time'] = time();

            if(in_array($this->wxapp_cfg['ac_type'],[4,7,27])){
                $data['g_independent_mall'] = 1;
            }else{
                $data['g_independent_mall'] = 0;
            }

            $unsetField = array('g_id', 'g_es_id', 'g_g_id', 'g_qrcode', 'g_kind1', 'g_kind2', 'g_kind3', 'g_show_vip', 'g_vip_price', 'g_vip_price_list', 'g_had_vip_price', 'g_vip_discount', 'g_is_sale', 'g_weight');
            foreach ($unsetField as $unsetItem){
                unset($data[$unsetItem]);
            }

            $ret  = $goods_model->insertValue($data);//新商品的id
            if($ret){
                $old_format     = $format_model->getListByGid($val);
                if($old_format){
                    foreach ($old_format as $oval){
                        $format[]   = "(NULL, '{$this->curr_sid}', '{$ret}', '{$oval['gf_name']}','{$oval['gf_name2']}','{$oval['gf_name3']}','{$oval['gf_img']}','{$oval['gf_price']}','{$oval['gf_format_weight']}','{$oval['gf_points']}','{$oval['gf_stock']}','{$oval['gf_sort']}', '{$oval['gf_sold']}','".time()."', '{$oval['gf_cake_gift']}')";
                    }
                }
                $old_slide      = $slide_model->getListByGidSid($val);
                if($old_slide){
                    foreach($old_slide as $sval){
                        $slide[] = "(NULL, '{$this->curr_sid}', '{$ret}', '{$sval['gs_path']}', 0, '".time()."')";
                    }
                }
            }
        }
        if(!empty($format)){
            $res  = $format_model->copyBatchSave($format);
        }
        if(!empty($slide)){
            $ress = $slide_model->batchSave($slide);
        }
        if($ret  || $ress){
            $result = array(
                'ec' => 200,
                'em' => '导入成功',
                'id' => $ret
            );
            App_Helper_OperateLog::saveOperateLog("商品导入成功");
        }else{
            $result['em'] = '导入失败';
        }
        $this->displayJson($result);
    }

    
    public function checkGoodsSaleDataAction(){
        $gid=$this->request->getIntParam('gid',0);
        $time_type=$this->request->getStrParam('type','yesterday');
        $today=$this->request->getIntParam('show_today',0);
        $start_time=$end_time=0;
        switch ($time_type) {
            case 'yesterday':
                $end_time=strtotime(date('Y-m-d',time()));
                $start_time=$end_time - (24 * 60 * 60);
                break;
            default:
                break;
        }
        if($start_time && $end_time){
            $where=[
                ['name'=>'to_g_id','oper'=>'=','value'=>$gid],
                ['name'=>'to_s_id','oper'=>'=','value'=>$this->curr_sid],
                ['name'=>'t_status','oper'=>'in','value'=>[3,4,5,6]],
                ['name'=>'t_create_time','oper'=>'>=','value'=>$start_time],
                ['name'=>'t_create_time','oper'=>'<','value'=>$end_time],
            ];

            $trade_order_model=new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
            $goods_sum=$trade_order_model->getSum($where);

            $output_data='昨日销量：'.(isset($goods_sum['numSum'])?$goods_sum['numSum']:0);
            if($today){
                $where=[
                    ['name'=>'to_g_id','oper'=>'=','value'=>$gid],
                    ['name'=>'to_s_id','oper'=>'=','value'=>$this->curr_sid],
                    ['name'=>'t_status','oper'=>'in','value'=>[3,4,5,6]],
                    ['name'=>'t_create_time','oper'=>'>=','value'=>$end_time],
                    ['name'=>'t_create_time','oper'=>'<','value'=>time()],
                ];
                $today_goods_sum=$trade_order_model->getSum($where);
                $output_data=sprintf("今日销量：%s<br/>%s",
                    (isset($today_goods_sum['numSum'])?$today_goods_sum['numSum']:0),
                    $output_data
                );
            }
            $this->displayJsonSuccess(['data'=>$output_data]);
        }else
            $this->displayJsonError('时间格式不正确');
    }

    
    public function verifyGoodsListAction(){
        $where = array();
        $where[] = array('name' => 'g_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[] = array('name' => 'g_verify_apply_time','oper' => '>','value' =>0);


        $output['name']     = $this->request->getStrParam('name');
        if($output['name']){
            $where[] = array('name' => 'g_name','oper' => 'like','value' =>"%{$output['name']}%");
        }

        $output['esId']  = $this->request->getIntParam('esId');
        if($output['esId']){
            $where[] = array('name' => 'g_es_id','oper' => '=','value' =>$output['esId']);
        }

        $output['status']  = $this->request->getIntParam('status',4);
        if($output['status']){
            if($output['status'] == 1){
                $where[] = array('name' => 'g_is_sale','oper' => 'not in','value' =>[4,5]);
            }else{
                $where[] = array('name' => 'g_is_sale','oper' => '=','value' =>$output['status']);
            }
        }
        $sort = ['g_verify_apply_time' => 'desc'];
        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $total = $goods_model->getCount($where);
        $pageCfg = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        $output['showPage'] = $total > $this->count ? 1 : 0;
        $list = [];
        if($index <= $total){
            $list = $goods_model->getCommunityShopGoods($where,$index,$this->count,$sort);
        }
        $output['list'] = $list;
        if($list){
            $output['now'] = 1;
        }
        $output['active']  = 'verify';
        $output['backUrl'] = '/wxapp/goods/verifyGoodsList';
        $this->showOutput($output);
        $this->_show_enter_shop();
        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => '#'),
            array('title' => '商品审核', 'link' => '#'),
        ));
        $this->secondLink($type='verify');
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/goods/verify-goods-list.tpl');
    }

    
    public function changeShopGoodsVerifyAction(){
        $status = $this->request->getIntParam('status');
        $set = [
            's_entershop_goods_verify' => $status
        ];
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage($this->curr_sid);
        $res = $shop_model->changeShopByUniqid($this->curr_shop['s_unique_id'],$set);
        $this->showAjaxResult($res);
    }
    public function saveHandleGoodsAction(){
        $status = $this->request->getIntParam('status');
        $id     = $this->request->getIntParam('id');
        $remark = $this->request->getStrParam('remark');
        if($this->menuType == 'toutiao' && $this->wxapp_cfg['ac_type'] ==8) {
            if($status ==5) {
                $this->_goods_verify();
            }
        }

        $set = [
            'g_is_sale' => $status,
            'g_verify_remark' => $remark,
        ];
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $res = $goods_model->updateById($set,$id);
        $this->showAjaxResult($res,'审核');
    }

    private function _goods_verify() {
        $img    = $this->request->getStrParam('imgs');
        $id     = $this->request->getIntParam('id');
        $remark = $this->request->getStrParam('remark');

        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $good = $goods_model->getRowById($id);

        $insert = [
            'gv_s_id' => $this->curr_sid,
            'gv_g_id' => $id,
            'gv_img'  => json_encode(json_decode($img, true)),
            'gv_desc' => $remark,
            'gv_type' => 1,
            'gv_es_id' => $good['g_es_id'] ? $good['g_es_id'] : 0,
            'gv_create_time' => time(),
            'gv_deleted' => 0,
        ];
        $gv_model = new App_Model_Goods_MysqlGoodsVerifyStorage($this->curr_sid);
        $gv_model->insertValue($insert);
    }
}
