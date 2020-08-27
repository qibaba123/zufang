<?php

class App_Controller_Wxapp_DeliveryController extends App_Controller_Wxapp_InitController{
    private $sendCfg;
    public function __construct(){
        parent::__construct();
        $this->_get_send_cfg();
    }

    
    private function _get_send_cfg(){
        $cfg_model = new App_Model_Cake_MysqlCakeSendStorage($this->curr_sid);
        $row = $cfg_model->findUpdateBySid();
        if($row){
            $this->sendCfg = $row;
        }else{
            $insert = array(
                'acs_s_id' => $this->curr_sid,
                'acs_create_time' => time()
            );
            $cfg_model->insertValue($insert);
            $row = $cfg_model->findUpdateBySid();
            $this->sendCfg = $row;
        }
    }

    
    public function secondLink($type='index'){
        if($this->curr_sid == 4230 || $this->curr_sid == 10380){
            $link = array(
                array(
                    'label' => '积分商城',
                    'link'  => '/wxapp/community/pointCfg',
                    'active'=> 'pointCfg'
                ),
                array(
                    'label' => '积分来源',
                    'link'  => '/wxapp/community/pointSourceCfg',
                    'active'=> 'pointSourceCfg'
                ),
                array(
                    'label' => '积分订单',
                    'link'  => '/wxapp/community/pointOrder',
                    'active'=> 'pointOrder'
                ),
                array(
                    'label' => '积分商品',
                    'link'  => '/wxapp/community/pointGoods',
                    'active'=> 'pointGoods'
                ),
                array(
                    'label' => '优惠券',
                    'link'  => '/wxapp/community/couponList',
                    'active'=> 'couponList'
                ),
                array(
                    'label' => '运费模板',
                    'link'  => '/wxapp/community/postTpl',
                    'active'=> 'postTpl'
                ),
            );
        }else{
            $link = array(
                array(
                    'label' => '商家配送',
                    'link'  => '/wxapp/delivery/sendCfg',
                    'active'=> 'send'
                ),
                array(
                    'label' => '快递发货',
                    'link'  => '/wxapp/delivery/index',
                    'active'=> 'express'
                ),
                array(
                    'label' => '门店自提',
                    'link'  => '/wxapp/delivery/receiveCfg',
                    'active'=> 'receive'
                ),
            );
        }
        $this->output['secondLink']       = $link;
        $this->output['linkType']   = $type;
        $this->output['snTitle']    = '配送配置';
    }

    
    public function receiveCfgAction(){
        $this->secondLink('receive');
        $this->buildBreadcrumbs(array(
            array('title' => '配送配置', 'link' => '#'),
            array('title' => '门店自提配置', 'link' => '#'),
        ));
        $this->output['sendCfg'] = $this->sendCfg;
        $this->_get_receive_store();
        $this->_get_select_store();

        $showManager = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[6])){
            $showManager = 1;
        }
        $this->output['showManager'] = $showManager;

        $showStoreGoodsLimit = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[21])){
            $showStoreGoodsLimit = 1;
        }

        $showReceivePriceLimit = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[21])){
            $showReceivePriceLimit = 1;
        }

        $this->output['showStoreGoodsLimit'] = $showStoreGoodsLimit;
        $this->output['showReceivePriceLimit'] = $showReceivePriceLimit;


        $this->displaySmarty('wxapp/delivery/delivery-receive-cfg.tpl');
    }

    
    public function _get_receive_store($json = FALSE){
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $where      = array();
        $where[]    = array('name' => 'os_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[]    = array('name' => 'os_receive_store','oper' => '=','value' =>1);
        $this->output['name'] = $this->request->getStrParam('name');
        if($this->output['name']){
            $where[]    = array('name' => 'os_name','oper' => 'like','value' =>"%{$this->output['name']}%");
        }

        $store_model    = new App_Model_Store_MysqlStoreStorage($this->curr_sid);
        $total          = $store_model->getCount($where);
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        $list   = array();
        if($index <= $total){
            $sort = array('os_create_time' => 'DESC');
            $list = $store_model->getList($where,$index,$this->count,$sort);
        }
        if($json){
            $this->output['storeList'] = json_encode($list);
        }else{
            $this->output['storeList'] = $list;
        }

    }

    
    public function _get_select_store(){
        $where      = array();
        $where[]    = array('name' => 'os_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[]    = array('name' => 'os_receive_store','oper' => '=','value' =>0);
        $store_model    = new App_Model_Store_MysqlStoreStorage($this->curr_sid);
        $sort = array('os_create_time' => 'DESC');
        $list = $store_model->getList($where,0,0,$sort);
        $this->output['selectList'] = $list;
    }

    
    public function addReceiveStoreAction(){
        $this->secondLink('receive');
        $this->buildBreadcrumbs(array(
            array('title' => '配送配置', 'link' => '#'),
            array('title' => '门店自提配置', 'link' => '/wxapp/delivery/receiveCfg'),
            array('title' => '新增/编辑自提门店', 'link' => '#'),
        ));
        $id = $this->request->getIntParam('id');
        if($id){
            $store_model = new App_Model_Store_MysqlStoreStorage($this->curr_sid);
            $this->output['row'] = $store_model->getRowByIdSid($id,$this->curr_sid);
        }
        $shortcut_model      = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
        $category            = $shortcut_model->fetchShortcutShowList(1);
        $this->output['category_select'] = $category;

        $showManager = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[6])){
            $showManager = 1;
        }
        $this->output['showManager'] = $showManager;

        $this->output['isReceive'] = 1;
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/delivery/add-receive-store.tpl');
    }

    
    public function changeReceiveStoreAction(){
        $id     = $this->request->getIntParam('id');
        $status = $this->request->getIntParam('status',0);
        $res = FALSE;
        if($id){
            $where[]    = array('name' => 'os_s_id','oper' => '=','value' =>$this->curr_sid);
            $where[]    = array('name' => 'os_id','oper' => '=','value' =>$id);
            $set = array(
                'os_receive_store' => $status
            );
             $store_model    = new App_Model_Store_MysqlStoreStorage($this->curr_sid);
             $res = $store_model->updateValue($set,$where);
             if($res && $status == 0){
                 $os_model = new App_Model_Store_MysqlStoreStorage($this->curr_sid);
                 $count = $os_model->getReceiveStoreCount();
                 if($count == 0){
                      $send_storage = new App_Model_Cake_MysqlCakeSendStorage($this->curr_sid);
                      $data['acs_receive'] = 0;
                      $send_storage->findUpdateBySid($data);
                 }
             }
             if($res){
                 $str = $status == 1 ? '添加' : '移除';
                 $store = $store_model->getRowById($id);
                 App_Helper_OperateLog::saveOperateLog("{$str}自提门店【{$store['os_name']}】成功");
             }
        }
        $this->showAjaxResult($res,'操作');
    }

    
    public function changeSendAction()
    {
        $result = array(
            'ec' => 400,
            'em' => '修改失败'
        );
        $type    = $this->request->getStrParam('type');
        $value   = $this->request->getStrParam('value');

        $status = $value == 'on' ? 1 : 0;
        $status_note = $status == 1 ? '启用' : '禁用';
        $send_storage = new App_Model_Cake_MysqlCakeSendStorage($this->curr_sid);
        if( $this->wxapp_cfg['ac_type'] == 32){
            $send_info  =   $send_storage->findUpdateBySid();
            $d_recieve  =   $send_info['acs_receive'];
            $d_leader   =   $send_info['acs_leader_send'];
            $d_send     =   $send_info['acs_send'];
            switch ($type) {
                case 'receive':
                    $d_recieve=$status;
                    # code...
                    break;
                 case 'leader':
                    $d_leader=$status;
                    break;
                case 'send':
                    $d_send=$status;
                    break;
                default:
                    break;
            }
            if(($d_recieve + $d_leader +  $d_send)<1)
                $this->displayJsonError('请至少保留一种配送方式');
        }   

      
        $type_note = '';
        if ($type == 'send') {
            $type_note = '商家配送';
            $data['acs_send'] = $status;
        }
        if ($type == 'receive') {
            if($status && $this->wxapp_cfg['ac_type'] != 32 && $this->wxapp_cfg['ac_type'] != 36){
                $os_model = new App_Model_Store_MysqlStoreStorage($this->curr_sid);
                $count = $os_model->getReceiveStoreCount();
                if(!$count){
                   $result = array(
                        'ec' => 400,
                        'em' => '请先添加或选择自提门店'
                    );
                   $this->displayJson($result,TRUE);
                }
            }
            $type_note = '门店自取';
            $data['acs_receive'] = $status;
        }
        if ($type == 'express') {
            $type_note = '快递发货';
            $data['acs_express_delivery'] = $status;
        }
        if($type == 'leader'){
            $type_note = '团长配送';
            $data['acs_leader_send'] = $status;
        }
        $data['acs_update_time'] = time();
        $ret = $send_storage->findUpdateBySid($data);


        if ($ret) {
            $result = array(
                'ec' => 200,
                'em' => ' 修改成功'
            );
            if($status_note && $type_note){
                App_Helper_OperateLog::saveOperateLog($type_note.$status_note."成功");
            }
        }
        $this->displayJson($result);
    }

    
    public function changeSendTwoAction(){
        $result     = array(
            'ec'    => 400,
            'em'    => '配置失败'
        );
        $dataValue      = $this->request->getArrParam('dataValue');
        $dataTime       = serialize($dataValue);
        $radioValue     = $this->request->getIntParam('radioValue');
        $address = $this->request->getStrParam('address');
        $lng     = $this->request->getStrParam('lng');
        $lat     = $this->request->getStrParam('lat');
        $sendDetails = $this->request->getParam('sendDetails');
        $sendRange = $this->request->getFloatParam('sendRange');
        $baseLong = $this->request->getFloatParam('baseLong');
        $basePrice = $this->request->getFloatParam('basePrice');
        $plusLong = $this->request->getFloatParam('plusLong');
        $plusPrice = $this->request->getFloatParam('plusPrice');
        $satisfySend = $this->request->getFloatParam('satisfySend');
        $receiveLimit = $this->request->getFloatParam('receiveLimit');
        $post_free=$this->request->getIntParam('post_free',0);
        $sort = $this->request->getIntParam('sort',0);
        $data=array(
            'acs_s_id'=>$this->curr_sid,
            'acs_today_send'=>$radioValue,
            'acs_time'=>$dataTime,
            'acs_send_range' => $sendRange,
            'acs_send_scope' => $sendDetails,
            'acs_shop_address' => $address,
            'acs_shop_lng'  => $lng,
            'acs_shop_lat'  => $lat,
            'acs_update_time' => time(),
            'acs_base_long' =>$baseLong,
            'acs_base_price' =>$basePrice,
            'acs_plus_long' =>$plusLong,
            'acs_plus_price' =>$plusPrice,
            'acs_satisfy_send' => $satisfySend,
            'acs_send_sort' => $sort,
            'acs_post_free' =>$post_free,
        );

        if($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36){
            $sequenceDay = $this->request->getIntParam('sequenceDay');
            $sequenceDaytime = $this->request->getStrParam('sequenceDaytime');
            $leaderLimit = $this->request->getFloatParam('leaderLimit');
            $leaderPrice = $this->request->getFloatParam('leaderPrice');
            $leaderReduce = $this->request->getFloatParam('leaderReduce');
            $data['acs_sequence_day'] = $sequenceDay;
            $data['acs_sequence_daytime'] = $sequenceDaytime;
            $data['acs_leader_limit'] = $leaderLimit;
            $data['acs_leader_price'] = $leaderPrice;
            $data['acs_leader_reduce'] = $leaderReduce;
            $data['acs_receive_price'] = $receiveLimit;
        }

        $send_storage = new App_Model_Cake_MysqlCakeSendStorage($this->curr_sid);
        $ret = $send_storage->findUpdateBySid();
        if($ret){
            $res = $send_storage->findUpdateBySid($data);
        }else{
            $res = $send_storage->insertValue($data);
        }
        if($res){
            App_Helper_OperateLog::saveOperateLog("商家配送配置信息保存成功");
            $result     = array(
                'ec'    => 200,
                'em'    => ' 配置成功'
            );
        }
        $this->displayJson($result);
    }

    
    public function changeSortAction(){
        $value = $this->request->getIntParam('value',0);
        $type = $this->request->getStrParam('type','');
        $res = false;
        if($type){
            $send_storage = new App_Model_Cake_MysqlCakeSendStorage($this->curr_sid);
            $ret = $send_storage->findUpdateBySid();
            $data["acs_{$type}_sort"] = $value;

            if($ret){
                $res = $send_storage->findUpdateBySid($data);
            }else{
                $data['acs_create_time'] = time();
                $data['acs_s_id'] = $this->curr_sid;
                $res = $send_storage->insertValue($data);
            }
        }

        if($res){
            $str = '';
            switch ($type){
                case 'send':
                    $str = '商家配送';
                    break;
                case 'receive':
                    $str = '门店自提';
                    break;
                case 'express':
                    $str = '快递发货';
                    break;
                case 'leader':
                    $str = '团长配送';
                    break;
            }
            App_Helper_OperateLog::saveOperateLog("修改{$str}排序成功");
        }

        $this->showAjaxResult($res,'保存');
    }


    
    public function changeReceivePriceAction(){
        $value = $this->request->getIntParam('value',0);
        $res = false;
        $send_storage = new App_Model_Cake_MysqlCakeSendStorage($this->curr_sid);
        $ret = $send_storage->findUpdateBySid();
        $data["acs_receive_price"] = $value;

        if($ret){
            $res = $send_storage->findUpdateBySid($data);
        }else{
            $data['acs_create_time'] = time();
            $data['acs_s_id'] = $this->curr_sid;
            $res = $send_storage->insertValue($data);
        }

        if($res){
            App_Helper_OperateLog::saveOperateLog("最低自提金额成功");
        }

        $this->showAjaxResult($res,'保存');
    }


    
    public function indexAction(){
        if($this->wxapp_cfg['ac_type'] != 13){
            $this->secondLink('express');
        }
        $this->output['sendCfg'] = $this->sendCfg;
        $page  = $this->request->getIntParam("page");
        $index = $page * $this->count;
        $template_storage = new App_Model_Shop_MysqlShopDeliveryTemplateStorage();
        $sort = array('sdt_update_time' => 'DESC');
        $where[] = array('name' => 'sdt_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'sdt_es_id', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'sdt_deleted', 'oper' => '=', 'value' => 0);
        $total = $template_storage->getCount($where);
        $list = $template_storage->getList($where, $index, $this->count, $sort);
        $city_storage = new App_Model_Shop_MysqlShopDeliveryCityStorage($this->curr_sid);
        foreach($list as $key => $val){
            $where = array();
            $where[] = array('name' => 'sdc_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[] = array('name' => 'sdc_es_id', 'oper' => '=', 'value' => 0);
            $where[] = array('name' => 'sdc_temp_id', 'oper' => '=', 'value' => $val['sdt_id']);
            $where[] = array('name' => 'sdc_deleted', 'oper' => '=', 'value' => 0);
            $clist = $city_storage->getList($where, 0, 0);
            $group = array();
            foreach($clist as $v){
                $group[$v['sdc_group']][] = $v;
            }
            $list[$key]['cityList'] = $group;
        }
        $pageCfg = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['paginator'] = $pageCfg->render();
        $this->output['applet'] = $this->wxapp_cfg;
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '配送配置', 'link' => '#'),
            array('title' => '快递发货配置', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/delivery/delivery-template-index.tpl");
    }

    
    public function addAction() {
        if($this->wxapp_cfg['ac_type'] != 13){
            $this->secondLink('express');
        }
        $id = $this->request->getIntParam('id');
        $template_storage = new App_Model_Shop_MysqlShopDeliveryTemplateStorage();
        $row = $template_storage->getRowById($id);
        $city_storage = new App_Model_Shop_MysqlShopDeliveryCityStorage($this->curr_sid);
        $where[] = array('name' => 'sdc_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'sdc_es_id', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'sdc_temp_id', 'oper' => '=', 'value' => $id);
        $where[] = array('name' => 'sdc_deleted', 'oper' => '=', 'value' => 0);
        $list = $city_storage->getList($where, 0, 0);
        $group = array();
        foreach($list as $val){
            $group[$val['sdc_group']][] = $val;
        }

        $this->_get_address();

        $this->output['sid'] = $this->curr_sid;
        $this->output['row'] = $row;
        $this->output['applet'] = $this->wxapp_cfg;
        $this->output['list'] = json_encode($group);
        $this->buildBreadcrumbs(array(
            array('title' => '快递发货配置', 'link' => '/wxapp/delivery/index'),
            array('title' => '编辑运费模板', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/delivery/add-express-template.tpl");
    }

    
    private function _get_address(){
        $addr_helper    = new App_Helper_Address();
        $allRegion = $addr_helper->getAllRegion();
        $data = array();
        foreach ($allRegion as $key => $val){
            $cityRegion = $addr_helper->getAllRegion($val['region_id']);
            $data[$key] = array(
                'region' => array(
                    'name' => $val['region_name'],
                    'code' => $val['region_id'],
                )
            );
            foreach ($cityRegion as $k => $v){
                $zoneRegion = $addr_helper->getAllRegion($v['region_id']);
                $data[$key]['region']['state'][$k] = array(
                    'name' => $v['region_name'],
                    'code' => $v['region_id'],
                    'city' => $data[$key]['region']['state'][$k]['city']?$data[$key]['region']['state'][$k]['city']:array()
                );

                if($zoneRegion){
                    foreach ($zoneRegion as $zone){
                        $data[$key]['region']['state'][$k]['city'][] = array(
                            'name' => $zone['region_name'],
                            'code' => $zone['region_id'],
                        );
                    }
                }elseif ($v['region_type'] == 2 && !$zoneRegion){
                    $data[$key]['region']['state'][$k]['city'][] = [
                        'name' => $v['region_name'],
                        'code' => $v['region_id'],
                    ];
                }
            }
        }

        $this->output['LocalAreaList'] = json_encode($data);
    }

    
    public function saveTemplateAction(){
        $id   = $this->request->getIntParam('id');
        $name = $this->request->getParam('name');
        $type = $this->request->getParam('type');
        $template_storage = new App_Model_Shop_MysqlShopDeliveryTemplateStorage();
        $data = array(
            'sdt_s_id' => $this->curr_sid,
            'sdt_es_id' => 0,
            'sdt_name' => $name,
            'sdt_type' => $type,
            'sdt_update_time' => time()
        );
        if($id){
            $template_storage->updateById($data, $id);
            $ret = $id;
        }else{
            $data['sdt_create_time'] = time();
            $ret = $template_storage->insertValue($data);
        }
        if($ret){
            App_Helper_OperateLog::saveOperateLog("运费模板【".$name."】保存成功");
            $ret = $this->_save_template_city($ret);
        }

        $this->showAjaxResult(1);
    }

    
    private function _save_template_city($ret){
        $templateList = $this->request->getArrParam('templateList');
        $city_storage = new App_Model_Shop_MysqlShopDeliveryCityStorage($this->curr_sid);
        foreach($templateList as $key => $template){
            if(!empty($template)){
                $city_list = $city_storage->fetchCityListByGroup($key,$ret);
                if(!empty($city_list)){
                    $del_id = array();
                    foreach($city_list as $val){
                        $del = true;
                        foreach($templateList[$key]['singalFinalResData'] as $k => $v){
                            if($val['sdc_area_name'] == $v['name']){
                                $set = array(
                                    'sdc_first_num' => $templateList[$key]['firstNum'],
                                    'sdc_first_fee' => $templateList[$key]['firstFee'] ,
                                    'sdc_add_num' => $templateList[$key]['addNum'],
                                    'sdc_add_fee' => $templateList[$key]['addFee'],
                                );
                                $city_storage->updateById($set, $val['sdc_id']);
                                $del = false;
                                unset($templateList[$key]['singalFinalResData'][$k]);
                            }
                        }
                        if($del){
                            $del_id[] = $val['sdc_id'];
                        }
                    }
                    if(!empty($del_id)){
                        $notice_where = array();
                        $notice_where[] = array('name' => 'sdc_id','oper' => 'in' , 'value' => $del_id);
                        $del_ret = $city_storage->deleteValue($notice_where);
                    }

                }
                if(!empty($templateList[$key]['singalFinalResData'])){
                    $insert = array();
                    $addr_helper    = new App_Helper_Address();
                    foreach($templateList[$key]['singalFinalResData'] as $val){
                        if($val['type'] == 1){
                            $region = $addr_helper->getLevelRegion($val['name'],'','',1);
                            $area = $region[1];
                        }else{
                            $region = $addr_helper->getLevelRegion($val['prov'],$val['name'],'',2);
                            $area = $region[2];
                        }

                        $insert[] =  " (NULL, '{$this->curr_sid}','0','{$ret}','{$key}','{$area['region_id']}','{$val['name']}','{$val['type']}','{$templateList[$key]['firstNum']}','{$templateList[$key]['firstFee']}','{$templateList[$key]['addNum']}','{$templateList[$key]['addFee']}','".time()."') ";
                    }
                    $ins_ret = $city_storage->insertBatch($insert);
                }
            }else{
                $where   = array();
                $where[] = array('name' => 'sdc_s_id','oper' => '=' , 'value' => $this->curr_sid);
                $where[] = array('name' => 'sdc_es_id','oper' => '=' , 'value' => 0);
                $where[] = array('name' => 'sdc_temp_id','oper' => '=' , 'value' => $ret);
                $where[] = array('name' => 'sdc_group','oper' => '=' , 'value' => $key);

                $del     = $city_storage->deleteValue($where);
            }
        }
        return true;
    }

    
    public function deleteTemplateAction(){
        $id = $this->request->getIntParam('id');
        if($id){
            $template_storage = new App_Model_Shop_MysqlShopDeliveryTemplateStorage();
            $template = $template_storage->getRowById($id);
            $ret = $template_storage->deleteById($id);
            if($ret){
                App_Helper_OperateLog::saveOperateLog("运费模板【".$template['sdt_name']."】删除成功");
                $city_storage = new App_Model_Shop_MysqlShopDeliveryCityStorage($this->curr_sid);
                $where[] = array('name' => 'sdc_s_id', 'oper' => '=', 'value' => $this->curr_sid);
                $where[] = array('name' => 'sdc_es_id', 'oper' => '=', 'value' => 0);
                $where[] = array('name' => 'sdc_temp_id', 'oper' => '=', 'value' => $id);
                $city_storage->deleteValue($where);
            }
        }
        $this->showAjaxResult($ret);
    }

    public function sendCfgAction(){
        $this->secondLink('send');
        $this->buildBreadcrumbs(array(
            array('title' => '配送配置', 'link' => '#'),
            array('title' => '商家配送配置', 'link' => '#')
        ));
        $this->output['sendCfg'] = $this->sendCfg;
        $dataTime=$this->sendCfg['acs_time'];
        $dataValue=unserialize($dataTime);
        foreach($dataValue as $k=>$v){
            $timePoint=explode('-',$v);
            $dataValue[$k]=$timePoint;
        }
        $this->output['dataValue'] = $dataValue;
        if(in_array($this->wxapp_cfg['ac_type'],[1,21,24,8,6,4,18])){
            $this->output['showSendFee'] = 1;
        }
        $this->displaySmarty('wxapp/delivery/delivery-send-cfg.tpl');

    }

    
    public function tradeSettingAction(){
        $this->output['appletCfg'] = $this->wxapp_cfg;
        $this->secondLink('tradeSet');
        $this->buildBreadcrumbs(array(
            array('title' => '订单管理', 'link' => '#'),
            array('title' => '订单设置', 'link' => '#'),
        ));

        $orderComent = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[21,32])){
            $orderComent = 1;
        }
        $this->output['orderComment'] = $orderComent;
        $this->displaySmarty('wxapp/delivery/trade-setting.tpl');
    }

    public function saveTradeSettingAction(){
        $closeTrade  = $this->request->getIntParam('closeTrade');
        $finishTrade = $this->request->getIntParam('finishTrade');
        $return_time = $this->request->getIntParam('return_time');
        $returnRatio = $this->request->getFloatParam('returnRatio');
        $autoFinish  = $this->request->getIntParam('autoFinish');
        $s_order_tip = $this->request->getStrParam('s_order_tip');
        $s_order_comment = $this->request->getStrParam('s_order_comment');
        $s_entershop_finish_open = $this->request->getStrParam('s_entershop_finish_open');
        $autoRefund  = $this->request->getStrParam('autoRefund');
        $enter_settle  = $this->request->getStrParam('enter_settle');
        $autoReceiveOrder  = $this->request->getStrParam('autoReceiveOrder');
        $s_order_tip = ($s_order_tip == 'on' || $s_order_tip == 1) ?  1 : 0;
        $s_order_comment = ($s_order_comment == 'on' || $s_order_comment == 1) ?  1 : 0;
        $s_entershop_finish_open = ($s_entershop_finish_open == 'on' || $s_entershop_finish_open == 1) ?  1 : 0;
        $autoReceiveOrder = ($autoReceiveOrder == 'on' || $autoReceiveOrder == 1) ?  1 : 0;

        if($closeTrade && $finishTrade){
            if($closeTrade==$this->curr_shop['s_close_trade'] && $autoReceiveOrder==$this->curr_shop['s_auto_receive_order'] && $autoRefund==$this->curr_shop['s_auto_refund'] && $finishTrade==$this->curr_shop['s_finish_trade'] && $returnRatio==$this->curr_shop['s_order_return_ratio'] && $autoFinish == $this->curr_shop['s_auto_finish'] && $s_order_tip == $this->curr_shop['s_order_tip'] && $s_order_comment == $this->curr_shop['s_order_comment'] && $s_entershop_finish_open == $this->curr_shop['s_entershop_finish_open']){
                $ret = 1;
            }else{
                $updata = array(
                    's_close_trade'        => $closeTrade,
                    's_finish_trade'       => $finishTrade,
                    's_auto_refund'        => $autoRefund,
                    's_order_return_ratio' => $returnRatio,
                    's_order_tip'          => $s_order_tip,
                    's_enter_settle'       => $enter_settle,
                    's_auto_receive_order' => $autoReceiveOrder,
                    's_return_time'        => $return_time,
                );

                if(in_array($this->wxapp_cfg['ac_type'],[21,32])){
                    $updata['s_order_comment'] = $s_order_comment;
                }

                if($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36){
                    $updata['s_auto_finish'] = $autoFinish;
                }
                if(in_array($this->wxapp_cfg['ac_type'],[6]) && $this->curr_sid == 4546){
                    $updata['s_entershop_finish_open'] = $s_entershop_finish_open;
                }

                $shop_storage = new App_Model_Shop_MysqlShopCoreStorage();
                $ret = $shop_storage->updateById($updata,$this->curr_sid);
            }
            if($ret){
                App_Helper_OperateLog::saveOperateLog("保存订单设置成功");
            }
            $this->showAjaxResult($ret,'设置');
        }else{
            $this->displayJsonError('请将数据填写完整');
        }
    }

    
    public function saveStoreManagerAction(){
        $id = $this->request->getIntParam('id');
        $mobile = $this->request->getStrParam('mobile');
        $password = $this->request->getStrParam('password');
        $data = array();
        $store_model = new App_Model_Store_MysqlStoreStorage($this->curr_sid);

        if($mobile){
            $exist = $store_model->findRowByManagerMobile($mobile,$id);
            if($exist){
                $result = array(
                    'ec' => 400,
                    'em' => '管理员手机号已经存在'
                );
                $this->displayJson($result,true);
            }else{
                if(!plum_is_mobile_phone($mobile)){
                    $result = array(
                        'ec' => 400,
                        'em' => '请填写正确的管理员手机号'
                    );
                    $this->displayJson($result,true);
                }else{
                    $data['os_manager_mobile'] = $mobile;
                }
            }
        }
        if($password){
            $data['os_manager_password'] = plum_salt_password($password);
        }
        $data['os_update_time'] = time();
        $res = $store_model->updateById($data,$id);

        if($res){
            $store = $store_model->getRowById($id);
            App_Helper_OperateLog::saveOperateLog("保存店铺【{$store['os_name']}】登录信息成功");
        }

        $this->showAjaxResult($res,'保存');
    }

    
    public function changeStoreGoodsLimitAction(){
        $result = array(
            'ec' => 400,
            'em' => '修改失败'
        );
        $value   = $this->request->getStrParam('value');

        $status = $value == 'on' ? 1 : 0;

        $data = [
            's_store_goods_limit' => $status
        ];

        $send_storage = new App_Model_Shop_MysqlShopCoreStorage();
        $ret = $send_storage->updateById($data,$this->curr_sid);

        if ($ret) {
            $result = array(
                'ec' => 200,
                'em' => ' 修改成功'
            );
            $str = $status == 1 ? '开启自提门店限制' : '关闭自提门店设置';
            App_Helper_OperateLog::saveOperateLog($str);
        }
        $this->displayJson($result);
    }

    
    public function editStoreGoodsAction(){
        $id = $this->request->getIntParam('id');
        $where = [];
        $where[] =['name' => 'asgl_s_id','oper' => '=' , 'value' => $this->curr_sid];
        $where[] =['name' => 'asgl_store_id','oper' => '=' , 'value' => $id];
        $store_goods_model = new App_Model_Cake_MysqlCakeStoreGoodsListStorage($this->curr_sid);
        $list = $store_goods_model->getGoodsListAction($where,0,0,[]);
        $this->output['goods'] = $list;
        $this->output['sid'] = $this->curr_sid;
        $this->output['storeId'] = $id;
        $this->buildBreadcrumbs(array(
            array('title' => '配送配置', 'link' => '#'),
            array('title' => '门店自提配置', 'link' => '/wxapp/delivery/receiveCfg'),
            array('title' => '自提商品', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/delivery/store-goods-list.tpl');
    }

    
    public function saveStoreGoodsAction(){
        $id = $this->request->getIntParam('id');
        $goods = $this->request->getArrParam('goods');
        $res = false;
        $limit_goods_model  = new App_Model_Cake_MysqlCakeStoreGoodsListStorage($this->curr_sid);
        $limit_goods_model->deleteListByStoreid($id);
        $insert = [];
        if($goods){
            foreach($goods as $val){
                $gid = intval($val['gid']);
                $insert[] = "(null,{$this->curr_sid},{$id},{$gid},{$_SERVER['REQUEST_TIME']})";
            }
        }else{
            $res = true;
        }

        if(!empty($insert)){
            $res = $limit_goods_model->insertBatch($insert);
        }
        if($res){
            App_Helper_OperateLog::saveOperateLog('保存门店商品成功');
        }
        $this->showAjaxResult($res,'保存');
    }


    
    public function manualSyncSettledAction(){
        $settled_model  = new App_Model_Trade_MysqlTradeSettledStorage($this->curr_sid);
        $un_settled_list=$settled_model->getList([
            ['name'=>'ts_s_id','oper'=>'=','value'=>$this->curr_sid],
            ['name'=>'ts_status','oper'=>'=','value'=>0],
            ['name'=>'ts_order_finish_time','oper'=>'>','value'=>0],
        ],0,0,[],['ts_order_finish_time','ts_status','ts_tid','ts_id','ts_es_id']);
        if(empty($un_settled_list)){
            $this->displayJsonError('暂无未结算订单!');
        }
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $shop_info=$shop_model->getRowById($this->curr_sid);
        
        if(!empty($shop_info) && $shop_info['s_enter_settle']){
            $time_now=time();
            $trade_helper   = new App_Helper_Trade($this->curr_sid);
            foreach ($un_settled_list as $key => $value) {
                $settled_time=$value['ts_order_finish_time']+($shop_info['s_enter_settle'] * 24 * 60 *60);
                if($time_now>=$settled_time){
                    $trade_helper->recordSuccessSettled($value['ts_id']);
                }
            }
        }
        $this->displayJsonSuccess(NULL,TRUE,'同步完成！');
    }

}