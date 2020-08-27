<?php


class App_Controller_Wxapp_HotelController extends App_Controller_Wxapp_OrderCommonController {

    public function __construct() {
        parent::__construct();
    }

    
    public function hotelTemplateAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '小程序首页模板', 'link' => '#'),
        ));
        $cfg = plum_parse_config('category','applet');
        $tpl_ids = $cfg[7]['tpl'];
        $tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $list       = $tpl_model->getListByTidSidType($tpl_ids,$this->curr_sid,3);
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        $cfg        = $applet_cfg->findShopCfg();
        $row        = array();
        foreach($list as $val){
            if(empty($row) && $val['it_id'] == $cfg['ac_index_tpl']){
                $row = $val;
                break;
            }
        }
        $this->output['cfg']  = $cfg;
        $this->output['list'] = $list;
        $this->output['shop'] = $this->shops[$this->curr_sid];
        $this->output['row']  = $row;
        $this->displaySmarty('wxapp/hotel/hotel-template.tpl');
    }

    
    public function indexTplAction(){
        $tpl_id  = $this->request->getIntParam('tpl', 27);
        $this->showIndexTpl($tpl_id);
        $this->_get_list_for_select();
        $this->_show_store_list();
        $this->showShopTplSlide($tpl_id);
        $this->_shop_information();
        $this->output['goods'] = $this->_show_goods_list(0);
        $this->output['recommendGoods'] = $this->_show_goods_list(1);
        $this->_show_information_category();
        $this->_get_information_category();
        $this->_get_jump_list();

        $store_model = new App_Model_Hotel_MysqlHotelStoreStorage($this->curr_sid);
        $where[] = array('name' => 'ahs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $this->output['store'] = $store_model->getRow($where);
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/hotel/index-tpl_'.$tpl_id.'.tpl');
    }

    private function _get_list_for_select($type = ''){
        $linkList = plum_parse_config('link','system');
        $linkType = plum_parse_config('link_type','system');
        $groupType = plum_parse_config('link_type_hotel','system');
        $link = $linkList[$this->wxapp_cfg['ac_type']];

        $link = $link ? $link : [];
        $linkType = $linkType ? $linkType : [];
        $groupType = $groupType ? $groupType : [];

        $this->output['linkList'] = json_encode($link);
        $this->output['linkType'] = json_encode(array_merge($linkType,$groupType));
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


    private function _show_information_category(){
        $category_storage = new App_Model_Applet_MysqlAppletInformationCategoryStorage($this->curr_sid);
        $list = $category_storage->getListBySid();
        $categoryList = array();
        if($list){
            foreach ($list as $key => $val){
                $categoryList[] = array(
                    'link' => "/pages/informationSpecial/informationSpecial?id=".$val['aic_id']."&title=".$val['aic_name'],
                    'name' => $val['aic_name']
                );
            }
        }
        $linkList = plum_parse_config('link','system');
        $link_list = $linkList[$this->wxapp_cfg['ac_type']];
        $menu = [];
        foreach ($link_list as $link_row){
            $menu[] = [
                'name' => $link_row['name'],
                'link' => $link_row['path']
            ];
        }
        $store_list = $this->_get_store_list();
        $storeLink = [];
        $storeList = [];
        if($store_list){
            foreach ($store_list as $store){
                $storeLink[] = [
                    'link' => '/pages/shopDetail/shopDetail?id='.$store['ahs_id'],
                    'name' => $store['ahs_name']
                ];
                $storeList[] = [
                    'id' => $store['ahs_id'],
                    'name' => $store['ahs_name']
                ];
            }
        }
        $categoryList = array_merge($menu,$categoryList);
        $this->output['categoryList'] = json_encode($categoryList);
        $this->output['storeLink'] = json_encode($storeLink);
        $this->output['storeListAll'] = json_encode($storeList);
    }

    
    private function _show_goods_list($recommend){
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $sort        = array('g_weight' => 'DESC', 'g_update_time' => 'DESC');
        $where[]     = ['name' => 'g_independent_mall','oper' => '=','value' =>0];
        $list        = $goods_model->fetchShopGoodsList($this->curr_sid, 0, 50, null, $recommend, $sort,[],0,0,1,$where);
        $info        = array();
        if($list){
            foreach ($list as $val){
                $info[] = $this->_format_goods_details($val);
            }
        }
        return json_encode($info);
    }

    
    private function _format_goods_details($goods){
        if($goods){
            $data = array(
                'id'         => $goods['g_id'],
                'name'       => $goods['g_name'],
                'cover'      => $goods['g_cover'],
                'price'      => $goods['g_price'],
                'oriPrice'   => $goods['g_ori_price'],
                'sold'       => $goods['g_sold'],
                'brief'      => $goods['g_brief'],
            );
            return $data;
        }
        return false;
    }


    
    private function showIndexTpl($tpl_id=27){
        $tpl_model = new App_Model_Hotel_MysqlHotelIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid($tpl_id);
        if(empty($tpl)){
            $tpl = array(
                'ahi_title'         => '酒店',
                'ahi_tpl_id'        => $tpl_id,
                'ahi_coupon_background'  => '',
            );
        }
        $serviceArr = json_decode($tpl['ahi_service'],true);
        $has_sevice = false;
        if($serviceArr && is_array($serviceArr)){
            $has_sevice = true;
        }

        $this->output['service'] = $has_sevice?json_encode($serviceArr,JSON_UNESCAPED_UNICODE):json_encode(array());
        $this->output['tpl'] = $tpl;
    }
    private function _update_tpl($data, $tpl_id){
        $tpl_model = new App_Model_Hotel_MysqlHotelIndexStorage($this->curr_sid);
        $tpl_row   = $tpl_model->findUpdateBySid($tpl_id);
        if(!empty($tpl_row)){
            $tpl_ret = $tpl_model->findUpdateBySid($tpl_id,$data);
        }else{
            $tpl['ahi_create_time']= time();
            $tpl_ret = $tpl_model->insertValue($data);
        }
        return $tpl_ret;
    }

    
    private function _show_store_list($json=true,$all = false,$primary = false){
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $where      = array();
        $where[]    = array('name' => 'ahs_s_id','oper' => '=','value' =>$this->curr_sid);
        $this->output['name'] = $this->request->getStrParam('name');
        if($this->output['name']){
            $where[]    = array('name' => 'ahs_name','oper' => 'like','value' =>"%{$this->output['name']}%");
        }

        $store_model    = new App_Model_Hotel_MysqlHotelStoreStorage($this->curr_sid);
        $list   = array();

        if($all){
            $sort = array('ahs_create_time' => 'DESC');
            $list = $store_model->getListEntershop($where,0,0,$sort);
        }else{
            $total          = $store_model->getCount($where);
            $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
            $this->output['paginator'] = $pageCfg->render();

            if($index <= $total){
                $sort = array('ahs_create_time' => 'DESC');
                $list = $store_model->getListEntershop($where,$index,$this->count,$sort);
            }
        }

        if($json){
            $this->output['storeList'] = json_encode($list);
        }else{
            if($primary){
                $new_list = [];
                foreach ($list as $val){
                    $new_list[$val['ahs_id']] = $val;
                }
                $list = $new_list;
            }

            $this->output['storeList'] = $list;
        }
    }


    private function _get_store_list(){
        $store_model    = new App_Model_Hotel_MysqlHotelStoreStorage($this->curr_sid);
        $where[]    = array('name' => 'ahs_s_id','oper' => '=','value' =>$this->curr_sid);
        $data = [];
        $sort = array('ahs_create_time' => 'DESC');
        $list = $store_model->getList($where,0,0,$sort);
        return $list;
    }

    
    public function storeListAction(){
        $this->_show_store_list(false);
        $this->output['curr_domain'] = plum_get_server('http_host');

        $this->buildBreadcrumbs(array(
            array('title' => '店铺门店管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/hotel/store-list.tpl');
    }

    
    private function _save_hotel_service($id){
        $serviceList = $this->request->getArrParam('service');
        $service_storage = new App_Model_Hotel_MysqlHotelServiceStorage($this->curr_sid);
        if(!empty($serviceList)){
            $service_list = $service_storage->findListBySid($id,1);
            if(!empty($service_list)){
                $del_id = array();
                foreach($service_list as $key => $val){
                    if(isset($serviceList[$val['ahs_weight']])){
                        $set = array(
                            'ahs_weight'     => $key,
                            'ahs_name'       => $serviceList[$val['ahs_weight']]['name'],
                            'ahs_icon'       => $serviceList[$val['ahs_weight']]['icon'],
                        );
                        $up_ret = $service_storage->updateById($set,$val['ahs_id']);
                        unset($serviceList[$val['ahs_weight']]);
                    }else{
                        $del_id[] = $val['ahs_id'];
                    }
                }
                if(!empty($del_id)){
                    $service_where = array();
                    $service_where[] = array('name' => 'ahs_id','oper' => 'in' , 'value' => $del_id);
                    $del_ret = $service_storage->deleteValue($service_where);
                }

            }
            if(!empty($serviceList)){
                $insert = array();
                foreach($serviceList as $key => $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}','{$id}','1','{$val['name']}','{$val['icon']}', '{$key}','".time()."') ";
                }
                $ins_ret = $service_storage->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'ahs_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'ahs_type','oper' => '=' , 'value' => 1);
            $where[] = array('name' => 'ahs_f_id','oper' => '=' , 'value' => $id);
            $del     = $service_storage->deleteValue($where);
        }
        if($up_ret || $ins_ret || $del_ret || $del){
            return true;
        }else{
            return false;
        }
    }

    
    public function goodsAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '房间管理', 'link' => '#'),
        ));
        $this->_show_goods_list_data();
        $this->output['choseLink']  = $this->showTableLink('goods');
        $this->displaySmarty('wxapp/hotel/goods-list.tpl');
    }

    
    private function showTableLink($type,$param=array()){
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
                        'href'  => '/wxapp/hotel/tradeList?status=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/wxapp/hotel/tradeList?status=nopay'.$extra,
                        'key'   => 'nopay',
                        'label' => '待付款'
                    ),
                    array(
                        'href'  => '/wxapp/hotel/tradeList?status=hadpay'.$extra,
                        'key'   => 'hadpay',
                        'label' => '待入住'
                    ),
                    array(
                        'href'  => '/wxapp/hotel/tradeList?status=finish'.$extra,
                        'key'   => 'finish',
                        'label' => '已完成'
                    ),
                    array(
                        'href'  => '/wxapp/hotel/tradeList?status=refund'.$extra,
                        'key'   => 'refund',
                        'label' => '已退款'
                    ),
                    array(
                        'href'  => '/wxapp/hotel/tradeList?status=closed'.$extra,
                        'key'   => 'closed',
                        'label' => '已关闭'
                    ),
                );
                break;
            case 'goods' :
                $link = array(
                    array(
                        'href'  => '/wxapp/hotel/goods?status=sell'.$extra,
                        'key'   => 'sell',
                        'label' => '出售中'
                    ),
                    array(
                        'href'  => '/wxapp/hotel/goods?status=depot'.$extra,
                        'key'   => 'depot',
                        'label' => '已下架'
                    ),
                );
                break;
            case 'settled' :
                $link = array(
                    array(
                        'href'  => '/wxapp/hotel/settled?status=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/wxapp/hotel/settled?status=doing'.$extra,
                        'key'   => 'doing',
                        'label' => '进行中'
                    ),
                    array(
                        'href'  => '/wxapp/hotel/settled?status=refund'.$extra,
                        'key'   => 'refund',
                        'label' => '退款'
                    ),
                    array(
                        'href'  => '/wxapp/hotel/settled?status=success'.$extra,
                        'key'   => 'success',
                        'label' => '成功'
                    ),
                );
                break;


        }
        return $link;
    }

    
    private function _show_goods_list_data(){
        $where          = array();
        $where[]        = array('name' => 'g_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[]        = array('name' => 'g_type','oper' => 'in','value' => array(1,2));
        $where[]        = array('name' => 'g_independent_mall', 'oper' => '=', 'value' => 0);
        $output['name'] = $this->request->getStrParam('name');
        if($output['name']){
            $where[] = array('name' => 'g_name','oper' => 'like','value' =>"%{$output['name']}%");
        }

        $output['store'] = $this->request->getIntParam('store');
        if($output['store']){
            $where[] = array('name' => 'g_kind1','oper' => '=','value' =>$output['store']);
        }
        $output['status'] = $this->request->getStrParam('status','sell');
        switch($output['status']){
            case 'sell':
                $where[] = array('name' => 'g_is_sale','oper' => '=','value' =>1);
                break;
            case 'depot':
                $where[] = array('name' => 'g_is_sale','oper' => '=','value' =>2);
                break;
        }

        $page                = $this->request->getIntParam('page');
        $index               = $page * $this->count;
        $goods_model         = new App_Model_Goods_MysqlGoodsStorage();
        $total               = $goods_model->getCount($where);
        $pageCfg             = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        $list   = array();
        $deduct = array();
        if($index <= $total){
            $sort = array('g_update_time' => 'DESC');
            $list = $goods_model->getList($where,$index,$this->count,$sort);
            $deduct_gids = array();
            foreach($list as &$val){
                $deduct_gids[] = $val['g_id'];
                $param = array(
                    'gid' => $val['g_id']
                );
            }
        }
        if($list){
            $output['now'] = 1;
        }
        $this->_show_store_list(false,true,true);
        $output['list'] = $list;
        $this->showOutput($output);
    }

    
    private function _save_good_service($id){
        $serviceList = $this->request->getStrParam('service');
        $serviceList = json_decode($serviceList,true);

        $service_storage = new App_Model_Hotel_MysqlHotelServiceStorage($this->curr_sid);
        if(!empty($serviceList)){
            $service_list = $service_storage->findListBySid($id,2);
            if(!empty($service_list)){
                $del_id = array();
                foreach($service_list as $key => $val){
                    if(isset($serviceList[$val['ahs_weight']])){
                        $set = array(
                            'ahs_weight'     => $key,
                            'ahs_name'       => $serviceList[$val['ahs_weight']]['name'],
                            'ahs_icon'       => $serviceList[$val['ahs_weight']]['icon'],
                        );
                        $up_ret = $service_storage->updateById($set,$val['ahs_id']);
                        unset($serviceList[$val['ahs_weight']]);
                    }else{
                        $del_id[] = $val['ahs_id'];
                    }
                }
                if(!empty($del_id)){
                    $service_where = array();
                    $service_where[] = array('name' => 'ahs_id','oper' => 'in' , 'value' => $del_id);
                    $del_ret = $service_storage->deleteValue($service_where);
                }

            }
            if(!empty($serviceList)){
                $insert = array();
                foreach($serviceList as $key => $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}','{$id}','2','{$val['name']}','{$val['icon']}', '{$key}','".time()."') ";
                }
                $ins_ret = $service_storage->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'ahs_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'ahs_type','oper' => '=' , 'value' => 2);
            $where[] = array('name' => 'ahs_f_id','oper' => '=' , 'value' => $id);
            $del     = $service_storage->deleteValue($where);
        }
        if($up_ret || $ins_ret || $del_ret || $del){
            return true;
        }else{
            return false;
        }
    }

    
    private function math_price_stock_format(){
        $data   = array(
            'price' => 0,
            'oriPirce' => 0,
            'format'=> 0,
        );
        $maxNum = $this->request->getIntParam('format-num');
        for($i=0; $i <= $maxNum; $i++){
            $price  = $this->request->getFloatParam('format_price_'.$i);
            $data['format'] = $data['format'] + 1;
            if($data['price'] == 0) $data['price'] = $price;
        }

        $data['price'] = $this->request->getFloatParam('g_price');
        $data['oriPrice'] = $this->request->getFloatParam('g_ori_price');

        return $data;
    }

    
    private function batchGoodsFormat($goId,$is_add=0){
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
        $maxNum         = $this->request->getIntParam('format-num');
        $go_price       = $this->request->getFloatParam('g_price');
        $formatSort     = $this->request->getStrParam('format-sort');
        $sortArr        = explode(',',$formatSort);
        $format         = array();
        if($is_add){
            for($i=1; $i <= $maxNum; $i++){
                $name       = plum_sql_quote(plum_get_param('format_name_'.$i));
                $tem_price  = $this->request->getFloatParam('format_price_'.$i);
                $dprice     = $this->request->getFloatParam('format_dprice_'.$i);
                $stock  = $this->request->getIntParam('format_stock_'.$i);
                $gift1      = $this->request->getIntParam('format_gift1_'.$i);
                $gift2      = $this->request->getIntParam('format_gift2_'.$i);
                $gift3      = $this->request->getIntParam('format_gift3_'.$i);
                $gift       = json_encode(array($gift1, $gift2, $gift3));

                $sort       = array_search('format_id_'.$i,$sortArr);
                $price      = $tem_price ? $tem_price : $go_price ;
                if($name && $price){
                    $format[]   = "(NULL, '{$this->curr_sid}', '{$goId}', '{$name}','{$price}','{$dprice}','','{$sort}', 0, '".time()."', '{$gift}', '{$stock}')";
                }
            }
        }else{
            $gf_id = array();
            for($i=0; $i <= $maxNum; $i++){
                $name    = plum_sql_quote($this->request->getStrParam('format_name_'.$i));
                $price   = $this->request->getFloatParam('format_price_'.$i);
                $dprice   = $this->request->getFloatParam('format_dprice_'.$i);
                $stock  = $this->request->getIntParam('format_stock_'.$i);
                $id      = $this->request->getIntParam('format_id_'.$i);
                $gift1      = $this->request->getIntParam('format_gift1_'.$i);
                $gift2      = $this->request->getIntParam('format_gift2_'.$i);
                $gift3      = $this->request->getIntParam('format_gift3_'.$i);
                $gift       = json_encode(array($gift1, $gift2, $gift3));
                if($name){
                    $sort       = array_search('format_id_'.$i,$sortArr);//gf_sort
                    $temp = array(
                        'gf_name'   => $name,
                        'gf_price'  => $price ? $price : $go_price,
                        'gf_sort'   => $sort,
                        'gf_date_price'   => $dprice,
                        'gf_cake_gift' => $gift,
                        'gf_hotel_stock' => $stock
                    );
                    if($id == 0){
                        $format[]   = "(NULL, '{$this->curr_sid}', '{$goId}', '{$temp['gf_name']}','{$temp['gf_price']}','{$temp['gf_date_price']}','{$temp['gf_stock']}','{$temp['gf_sort']}', 0, '".time()."', '{$gift}', '{$stock}')";
                    }else{
                        $format_model->updateFormat($id,$temp);
                        $gf_id[] = $id;
                    }
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
            $format_model->batchHotelSave($format);
        }
    }


    
    public function tradeListAction() {
        $where_trade[] = $where[] = ['name' => 't_independent_mall', 'oper' => '=', 'value' => 0];

        $this->show_trade_list_data($where_trade);
        $this->output['print'] = plum_parse_config('type','print');
        $this->output['tradePay'] =  App_Helper_Trade::$trade_pay_type;
        $this->output['link'] = $this->showTableLink('order');

        $where[] = array('name'=>'t_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET );
        $this->output['todayTradeInfo'] = $this->_show_order_stat($where,true);
        $this->buildBreadcrumbs(array(
            array('title' => '订单列表', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/hotel/trade-list.tpl');
    }

    
    public function tradeDetailAction($isActivity = '') {
        $this->output['tradePay'] = App_Helper_Trade::$trade_pay_type;
        $this->output['tradeType']= App_Helper_Trade::$trade_type;
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
        $this->buildBreadcrumbs(array(
            array('title' => '订单列表', 'link' => '/wxapp/hotel/tradeList'),
            array('title' => '订单详情', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/hotel/trade-detail.tpl');
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
            $output['row']  = $row;
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
            $output['list']     = $trade_order->getGoodsListByTid($row['t_id']);

            $this->_trade_detail_status_desc($row);
            $output['statusNote'] = plum_parse_config('trade_status');
            $this->express_detail($row['t_company_code'],$row['t_express_code']);
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

    
    public function startAppletTplAction(){
        $result     = array(
            'ec'    => 400,
            'em'    => '该模版不可用'
        );
        $id         = $this->request->getIntParam('id');
        $tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $row        = $tpl_model->getRowBySid($id,$this->curr_sid);
        if($row || $id==0){
            $set = array(
                'ac_index_tpl'   => $id,
                'ac_update_time' => time()
            );
            $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
            $ret = $applet_cfg->findShopCfg($set);
            if($ret){
                $result     = array(
                    'ec'    => 200,
                    'em'    => ' 启用成功'
                );
                App_Helper_OperateLog::saveOperateLog("首页模板【{$row['it_name']}】启用成功");
            }else{
                $result['em'] = '启用失败';
            }
        }
        $this->displayJson($result);
    }

    
    public function commentListAction(){
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $where = array();
        $this->output['nickname'] = $this->request->getStrParam('nickname');
        if($this->output['nickname']){
            $where[]        = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$this->output['nickname']}%");
        }
        $this->output['content'] = $this->request->getStrParam('content');
        if($this->output['content']){
            $where[]        = array('name' => 'gc_content', 'oper' => 'like', 'value' => "%{$this->output['content']}%");
        }
        $out['start']   = $this->request->getStrParam('start');
        if($out['start']){
            $where[]    = array('name' => 'gc_create_time', 'oper' => '>=', 'value' => strtotime($out['start']));
        }
        $out['end']     = $this->request->getStrParam('end');
        if($out['end']){
            $where[]    = array('name' => 'gc_create_time', 'oper' => '<=', 'value' => (strtotime($out['end']) + 86400));
        }
        $where[] = array('name'=>'gc_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'gc_deleted','oper'=>'=','value'=>0);
        $where[] = array('name'=>'g_independent_mall','oper'=>'=','value'=> 0);
        $post_storage = new App_Model_Goods_MysqlCommentStorage($this->curr_sid);
        $total      = $post_storage->getCommentListMemberCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list = array();
        if($index < $total){
            $list          = $post_storage->getCommentListMember($where, $index,$this->count);
        }
        foreach($list as $key=>$val){
            $list[$key]['gc_content'] = $this->utf8_str_to_unicode($val['gc_content']);
        }
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '评论列表', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/hotel/comment-list.tpl');
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

    
    private function _fetch_post_img($cid){
        $attachment_model = new App_Model_Goods_MysqlCommentAttachmentStorage($this->curr_sid);
        $list = $attachment_model->fetchAllAttachment($cid);
        $this->output['imgList'] = $list;
    }

    
    public function batchSlide($goId,$is_add=0){
        $slide_model    = new App_Model_Goods_MysqlGoodsSlideStorage($this->curr_sid);
        $maxNum         = $this->request->getStrParam('slide-img-num');
        $slide          = array();
        if($is_add){
            for($i=0; $i<= $maxNum; $i++){
                $temp = $this->request->getStrParam('slide_'.$i);
                $temp = plum_sql_quote($temp);
                if($temp){
                    $slide[] = "(NULL, '{$this->curr_sid}', '{$goId}', '{$temp}', 0, '".time()."')";
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
            $old_slide = $slide_model->getListByGidSid($goId,$this->curr_sid);
            foreach($old_slide as $val){
                if(!in_array($val['gs_id'],$sl_id)){
                    $del_id[] = $val['gs_id'];
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
                    $slide_model->deleteSlide($goId,$del_id);
                }
            }else{
                $batch_slide = array();
                for($s=0 ; $s < count($slide) ; $s++){
                    if(isset($del_id[$s]) && $del_id[$s]){
                        $slide_model->updateSlide($del_id[$s],$slide[$s]);
                        unset($slide[$s]);
                    }else{
                        $sTemp = plum_sql_quote($slide[$s]);
                        $batch_slide[] = "(NULL, '{$this->curr_sid}', '{$goId}', '{$sTemp}', 0, '".time()."')";
                    }
                }
                if(!empty($batch_slide)){
                    $slide_model->batchSave($batch_slide);
                }
            }
        }
    }
    private function _add_enter_shop($ahsRow){
        $es_model    = new App_Model_Entershop_MysqlEnterShopStorage($this->curr_sid);
        $es_data = array(
            'es_unique_id'   => plum_uniqid_base36(),
            'es_contact'     => '',
            'es_m_id'        => 0,
            'es_phone'       => $ahsRow['ahs_contact'],
            'es_name'        => $ahsRow['ahs_name'],
            'es_s_id'        => $this->curr_sid,
            'es_logo'        => $ahsRow['ahs_avatar'],
            'es_addr'        => $ahsRow['ahs_address'],
            'es_lng'         => $ahsRow['ahs_lng'],
            'es_lat'         => $ahsRow['ahs_lat'],
            'es_label'       => '',
            'es_open_time'   => time(),
            'es_expire_time' => time()+365*86400*3,
            'es_createtime'  => time(),
            'es_status'      => 0
        );
        return $es_model->insertValue($es_data);
    }

    
    private function _add_enter_shop_manager($esId,$mobile,$password){
        $manager_storage    = new App_Model_Entershop_MysqlManagerStorage();
        $where[]    = array('name' => 'esm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]    = array('name' => 'esm_es_id', 'oper' => '=', 'value' => $esId);
        $exist = $manager_storage->getRow($where);
        if($exist){
            return false;
        }else{
            $mgdata = array(
                'esm_s_id'       => $this->curr_sid,
                'esm_es_id'      => $esId,
                'esm_mobile'     => $mobile,
                'esm_nickname'   => $password,
                'esm_password'   => plum_salt_password($password),
                'esm_createtime' => time(),
                'esm_status'     => 0,
            );
            return $manager_storage->insertValue($mgdata);
        }

    }

    
    public function tradeRefundAction($isActivity = ''){
        $tradeType = $this->request->getStrParam('tradeType');
        $url = '/wxapp/hotel/tradeList';

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
        $this->displaySmarty('wxapp/hotel/trade-refund.tpl');
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
            $output['row']      = $row;
            $redis_model        = new App_Model_Trade_RedisTradeStorage($this->curr_sid);
            $endTime            = $redis_model->getTradeRefundTtl($row['t_id']);
            $output['endTime']  = $endTime;
            $trade_order        = new App_Model_Trade_MysqlTradeRefundStorage($this->curr_sid);
            $refundList = $trade_order->getAllRecord($row['t_tid']);
            $output['refundList'] = $refundList;
            $output['refund']  = $refundList[0];
            $helper_model       = new App_Helper_Trade($this->curr_sid);
            $output['alert']    = $helper_model->checkAppletTradeRefund($output['row']['t_pay_type'],$output['refund']['tr_money']);
            $output['canAgree']   = (($row['t_feedback'] == 1 && $row['t_fd_status'] == 1 ) || ($row['t_feedback'] == 2 && $row['t_fd_result'] == 1 ) && $output['alert']['errno'] == 0) ? 1 : 0;
            $output['canRefuse']   = ($row['t_feedback'] == 1 && $row['t_fd_status'] == 1 ) ? 1 : 0;

            $output['statusNote'] = plum_parse_config('trade_status');
            $output['refundNote'] = plum_parse_config('refund_status');
            $output['tradePay']   = App_Helper_Trade::$trade_pay_type;
            $this->showOutput($output);
        } else {
            plum_url_location('订单号错误');
        }
    }


    
    public function excelOrderAction(){
        $where      = array();
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $startDate  = $this->request->getStrParam('startDate');
        $startTime  = $this->request->getStrParam('startTime');
        $endDate    = $this->request->getStrParam('endDate');
        $endTime    = $this->request->getStrParam('endTime');

        if($startDate && $startTime && $endDate && $endTime) {
            $start = $startDate . ' ' . $startTime;
            $end = $endDate . ' ' . $endTime;
            $startTime = strtotime($start);
            $endTime = strtotime($end);
            $where = array();
            $where[] = array('name' => 't_create_time', 'oper' => '>=', 'value' => $startTime);
            $where[] = array('name' => 't_create_time', 'oper' => '<', 'value' => $endTime);
            $orderStatus = $this->request->getStrParam('orderStatus','all');

            $link = App_Helper_Trade::$trade_link_status;
            if($orderStatus && isset($link[$orderStatus]) && $link[$orderStatus]['id'] > 0){
                $where[]    = array('name'=>'t_status','oper'=>'=','value'=>$link[$orderStatus]['id']);
            }else{
                $where[]   = array('name'=>'t_status','oper'=>'in','value'=>[3,4,5,6]);
            }

            $where[]    = array('name'=>'t_type','oper'=>'=','value'=>5);
            $where[]    = ['name' => 't_independent_mall', 'oper' => '=', 'value' => 0];
            $where[]    = ['name' => 't_s_id', 'oper' => '=', 'value' => $this->curr_sid];

            $total          = $trade_model->getAddressCount($where);
            if($total > 4000){
                plum_url_location('信息过多，请缩小查找范围');
            }
            $sort = array('t_create_time' => 'DESC');
            $list = $trade_model->getAddressList($where,0,0,$sort);
            if(!empty($list)){
                $statusNote = plum_parse_config('trade_status');
                $tradePay =  App_Helper_Trade::$trade_pay_type;
                $rows  = array();
                $rows[]  = array('订单号','房间名称','数量','入住时间','预计到店时间','总价','支付金额','支付方式','用户名','联系方式','入住人信息','订单状态','下单时间');
                $width   = array(
                    'A' => 25,
                    'B' => 20,
                    'C' => 15,
                    'D' => 25,
                    'E' => 15,
                    'F' => 10,
                    'G' => 10,
                    'H' => 10,
                    'I' => 15,
                    'J' => 15,
                    'K' => 20,
                    'L' => 10,
                    'M' => 15,
                );
                foreach($list as $key => $val){
                    $user_arr = json_decode($val['t_express_company']);
                    $user_str = implode('，',$user_arr);

                    $rows[] = array(
                        $val['t_tid'].' ',
                        $val['t_title'],
                        ($val['t_num'].'晚 * '.$val['t_room_num'].'间'),
                       date('Y-m-d',$val['t_receive_start_time']) .'~'. date('Y-m-d',$val['t_receive_end_time']),
                        $val['t_meal_send_time'],
                        $val['t_total_fee'],
                        $val['t_payment'],
                        $tradePay[$val['t_pay_type']],
                        $this->utf8_str_to_unicode($val['t_buyer_nick']),
                        $val['t_express_code'].' ',
                        $user_str,
                        $statusNote[$val['t_status']],
                        date('Y-m-d H:i:s',$val['t_create_time'])
                    );
                }
                $excel = new App_Plugin_PHPExcel_PHPExcelPlugin();
                $filename  = '订单.xls';
                $excel->down_common_excel($rows,$filename,$width);
            }else{
                plum_url_location('没有提现信息!');
            }

        }else{
            plum_url_location('请选择完整的时间');
        }

    }

}