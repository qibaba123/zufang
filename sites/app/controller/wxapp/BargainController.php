<?php

class App_Controller_Wxapp_BargainController extends App_Controller_Wxapp_OrderCommonController{

    const PROMOTION_TOOL_KEY = 'wkj';
    
    public function __construct(){
        parent::__construct();

        
    }
    
    public function secondLink($type='index',$returnInfo = false){
        $link = array(
            array(
                'label' => '砍价配置',
                'link'  => '/wxapp/bargain/index',
                'active'=> 'index'
            ),
            array(
                'label' => '活动管理',
                'link'  => '/wxapp/bargain/list',
                'active'=> 'list'
            ),
            array(
                'label' => '订单管理',
                'link'  => ($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36) ? '/wxapp/bargain/sequenceOrder' :'/wxapp/bargain/order',
                'active'=> 'order'
            ),
        );
        if($this->wxapp_cfg['ac_type'] == 27){
            unset($link[0]);
        }
        if(in_array($this->wxapp_cfg['ac_type'],[7])){
            $link[] = array(
                'label' => '商城砍价订单',
                'link'  => '/wxapp/bargain/order?independent=1',
                'active'=> 'order_independent'
            );
        }
        if($this->wxapp_cfg['ac_type'] == 6 || $this->wxapp_cfg['ac_type'] == 8){
            $link[] = array(
                'label' => '营销活动申请',
                'link'  => '/wxapp/bargain/activity',
                'active'=> 'activity'
            );
            $link[] = array(
                'label' => '店铺活动列表',
                'link'  => '/wxapp/bargain/shopList',
                'active'=> 'shop'
            );
        }

        $sinTitle = '微砍价';
        if($returnInfo){
            return array(
                'link' => $link,
                'linkType' => $type,
                'snTitle'  => $sinTitle
            );
        }else{
            $this->output['link']       = $link;
            $this->output['linkType']   = $type;
            $this->output['snTitle']    = $sinTitle;
        }
    }

    
    public function indexAction() {
        $this->secondLink('index');
        $cfg        = $this->wxapp_cfg;
        $this->output['shopType']    = $cfg['ac_type'];
        $this->showIndexTpl();
        $this->showShopTplSlide(0, 5);
        $this->_get_list_for_select();
        $this->showShopTplShortcut(-5);
        $this->_shop_kind_list_for_select();
        $this->_shop_top_goods_list();
        $this->_ordinary_goods_group();
        $page      = $this->_fetch_shop_outside();
        $page_data = $this->_fetch_page_data();
        $this->_shop_list_for_select();
        $this->_community_shop_kind_list_for_select();
        $this->output['page_list'] = json_encode(array_merge($page,$page_data));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '砍价管理', 'link' => '/wxapp/bargain/index'),
            array('title' => '砍价配置', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/bargain/cfg.tpl");
    }

    
    private function _community_shop_kind_list_for_select(){
        if($this->wxapp_cfg['ac_type'] == 6){
            $shortcut_model = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
            $category = $shortcut_model->fetchShortcutShowList(2);
            $data = array();
            if($category){
                foreach ($category as $val){
                    $data[] = array(
                        'id'   => $val['acc_id'],
                        'name' => $val['acc_title'],
                    );
                }
            }
            $this->output['shopKindSelect'] = json_encode($data);
        }else{
            $kind_model     = new App_Model_Community_MysqlKindStorage($this->curr_sid);
            $kind1 = $kind_model->getFirstCategory(0,0);
            $data = array();
            if($kind1){
                foreach ($kind1 as $val){
                    $data[] = array(
                        'id'   => $val['ack_id'],
                        'name' => $val['ack_name']
                    );
                }
            }
            $this->output['shopKindSelect'] = json_encode($data);
        }
    }

    
    private function _shop_list_for_select(){
        if($this->wxapp_cfg['ac_type'] == 6){
            $shop_storage = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
            $sort  = array('acs_create_time' => 'DESC');
            $where = array();
            $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[] = array('name' => 'acs_deleted', 'oper' => '=', 'value' => 0);
            $shop    = $shop_storage->getList($where,0,0,$sort);
            $data = array();
            $selectShop = array();
            if($shop){
                foreach ($shop as $val){
                    $data[] = array(
                        'id'        => $val['acs_id'],
                        'name'      => $val['acs_name'],
                    );
                    $selectShop[$val['acs_id']] = $val['acs_name'];
                }
            }
            $this->output['shoplist'] = json_encode($data);
            $this->output['selectShop'] = $selectShop;
        }else{
            $where[] = array('name'=>'es_s_id','oper'=>'=','value'=>$this->curr_sid);
            $where[] = array('name'=>'es_status','oper'=>'=','value'=>0);

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
    }

    
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
                if($val['ap_path'] == "pages/goodIndex/goodIndex" && $this->wxapp_cfg['ac_type'] != 8){
                    $path = str_replace('pages', 'subpages0', $val['ap_path']);
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
        if($this->wxapp_cfg['ac_type'] == 6){
            $page_data[] = array(
                'path' => 'pages/goodIndex/goodIndex',
                'name' => '同城商城'." （pages/goodIndex/goodIndex）"
            );
        }
        return $page_data;
    }

    
    private function _shop_kind_list_for_select(){
        $kind_model     = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        if($this->wxapp_cfg['ac_type'] == 18){
            $kind2 = $kind_model->getSonsByFid(1,0,0);
        }else{
            $kind2 = $kind_model->getAllSonCategory(0,0);
        }

        $data = array();
        if($kind2){
            foreach ($kind2 as $val){
                $data[] = array(
                    'id'   => $val['sk_id'],
                    'name' => $val['sk_name']
                );
            }
        }
        $this->output['kindSelect'] = json_encode($data);
    }

    
    private function _shop_top_goods_list(){
        $test = $this->request->getIntParam('test');
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $goods_list = $goods_storage->fetchShopGoodsList($this->curr_sid,0,50,'',1,array(),array(),0,0,0);
        $data = array();
        if($goods_list){
            foreach ($goods_list as $val){
                $data[] = array(
                    'id'   => $val['g_id'],
                    'name' => $val['g_name'],
                );
            }
        }
        $this->output['goodsList'] = json_encode($data);
    }

    
    private function _ordinary_goods_group(){
        $where      = array();
        $where[]    = array('name' => 'gg_s_id','oper' => '=','value' =>$this->curr_sid);
        $group_model    = new App_Model_Goods_MysqlGroupStorage($this->curr_sid);
        $sort = array('gg_create_time' => 'DESC');
        $list = $group_model->getList($where,0,0,$sort);
        $data = array();
        $shopData = array();
        if($list){
            foreach ($list as $val){
                if($val['gg_is_eshop']){
                    $shopData[] = array(
                        'id'   => $val['gg_id'],
                        'name' => $val['gg_name'],
                    );
                }else{
                    $data[] = array(
                        'id'   => $val['gg_id'],
                        'name' => $val['gg_name'],
                    );
                }
            }
        }
        $this->output['ordinaryGoodsGroup'] = json_encode($data);
        $this->output['shopGoodsGroup'] = json_encode($shopData);
    }

    
    private function _get_list_for_select(){
        $linkList = plum_parse_config('link','system');
        $linkType = plum_parse_config('link_type','system');
        $weedingType = plum_parse_config('link_type_bargain','system');
        $link = $linkList[$this->wxapp_cfg['ac_type']];
        unset($linkType[1]);
        unset($linkType[3]);
        if($this->wxapp_cfg['ac_type']==6){//同城的
            unset($weedingType[0]);
            unset($weedingType[2]);
        }
        if($this->wxapp_cfg['ac_type'] == 12){
            unset($weedingType[0]);
            unset($weedingType[1]);
            unset($weedingType[2]);
        }
        if($this->wxapp_cfg['ac_type'] == 4 || $this->wxapp_cfg['ac_type'] == 7 ){
            unset($weedingType[0]);
            unset($weedingType[2]);
        }
        if($this->wxapp_cfg['ac_type'] == 18){
            unset($weedingType[0]);
        }
        if($this->wxapp_cfg['ac_type'] == 27){
            $weedingType[1]['name'] = '课程详情';
            $weedingType[2]['name'] = '课程分类列表';
        }
        if($this->wxapp_cfg['ac_type']!=6 && $this->wxapp_cfg['ac_type']!=8){//同城的
            unset($weedingType[3]);
            unset($weedingType[4]);
            unset($weedingType[5]);
        }
        if($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36){
            unset($weedingType[2]);
        }

        $this->output['linkList'] = json_encode($link);
        $this->output['linkTypes'] = json_encode(array_merge($linkType,$weedingType));
    }

    
    private function showIndexTpl(){
        $tpl_model = new App_Model_Bargain_MysqlBargainIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid();
        if(empty($tpl)){
            $tpl = array(
                'ali_title'         => '微砍价',
            );
        }
        $this->output['tpl'] = $tpl;
    }

    
    public function saveIndexAction(){
        $title            = $this->request->getStrParam('title');
        $isopen     = $this->request->getIntParam('isopen');
        $applyTitle = $this->request->getStrParam('applyTitle');
        $data = array(
            'abi_s_id'                => $this->curr_sid,
            'abi_title'               => $title,
            'abi_update_time'        => time(),
            'abi_isopen'              =>$isopen,
            'abi_apply_title'         => $applyTitle
        );
        $tpl_model = new App_Model_Bargain_MysqlBargainIndexStorage($this->curr_sid);
        $tpl_row   = $tpl_model->findUpdateBySid();
        if(!empty($tpl_row)){
            $ret = $tpl_model->findUpdateBySid($data);
        }else{
            $tpl['abi_create_time']= time();
            $ret = $tpl_model->insertValue($data);
        }
        if($ret){
            $this->save_shop_slide(0, 5);//保存幻灯
            $this->save_shop_shortcut_new(-5);//保存导航
            $result = array(
                'ec' => 200,
                'em' => '信息保存成功'
            );

            App_Helper_OperateLog::saveOperateLog("保存砍价首页设置成功");
        }else{
            $result = array(
                'ec' => 400,
                'em' => '模版不可用'
            );
        }
        $this->displayJson($result);
    }

    
    public function listAction() {
        $table_menu = new App_Helper_TableMenu();
        $this->output['choseLink'] = array(
            array(
                'href'  => '/wxapp/bargain/list?type=all',
                'key'   => 'all',
                'label' => '全部'
            ),
            array(
                'href'  => '/wxapp/bargain/list?type=ready',
                'key'   => 'ready',
                'label' => '准备中'
            ),
            array(
                'href'  => '/wxapp/bargain/list?type=underway',
                'key'   => 'underway',
                'label' => '进行中'
            ),
            array(
                'href'  => '/wxapp/bargain/list?type=finish',
                'key'   => 'finish',
                'label' => '已经结束'
            ),
        );;
        $tpl_msg_model  = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
        $where[] = array('name' => 'awt_s_id','oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'awt_deleted','oper' => '=', 'value' => 0);
        $this->output['msg'] = $tpl_msg_model->getList($where,0,0);
        $this->secondLink('list');
        $this->showTypeByKey('bargainStatus');

        if($this->wxapp_cfg['ac_type'] == 12){
            $this->_show_bargain_data_course();
        }else{
            $this->_show_bargain_data();
        }

        $cfg_model = new App_Model_Bargain_MysqlCfgStorage($this->curr_sid);
        $bargain_cfg = $cfg_model->findShopCfg();

        $this->output['bargainCfg'] = $bargain_cfg;

        if($this->wxapp_cfg['ac_type'] == 27){
            $goodsName = '课程';
        }else{
            $goodsName = '商品';
        }
        $this->output['goodsName'] = $goodsName;

        $this->output['bargainPath'] = App_Plugin_Weixin_WxxcxClient::BARGAIN_DETAIL_CODE_PATH;

        $this->output['sid'] = $this->curr_sid;
        $this->output['appletCfg'] = $this->wxapp_cfg;

        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '砍价管理', 'link' => '/wxapp/bargain/index'),
            array('title' => '活动管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/bargain/bargain-list.tpl');
    }

    public function _show_bargain_data($isShop=false){
        $page       = $this->request->getIntParam('page');
        $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($this->curr_sid);
        $where      = array();
        $where[]    = array('name'=>'ba_s_id','oper'=>'=','value'=>$this->curr_sid);
        if($isShop){
            $where[]    = array('name'=>'ba_es_id','oper'=>'>','value'=>0);
        }else{
            $where[]    = array('name'=>'ba_es_id','oper'=>'=','value'=>0);
        }
        $output['type'] = $this->request->getStrParam('type','all');
        switch($output['type']){
            case 'ready':
                $where[] = array('name' => 'ba_start_time', 'oper' => '>', 'value' => time());
                break;
            case 'underway':
                $where[] = array('name' => 'ba_start_time', 'oper' => '<', 'value' => time());
                $where[] = array('name' => 'ba_end_time', 'oper' => '>', 'value' => time());
                break;
            case 'finish':
                $where[] = array('name' => 'ba_end_time', 'oper' => '<', 'value' => time());
                break;
        }

        $where[] = array('name' => 'ba_deleted', 'oper' => '=', 'value' => 0);
        $index      = $page * $this->count;
        $total      = $bargain_model->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['pagination']   = $pageCfg->render();
        $list = array();
        if($index < $total){
            $sort = array('ba_create_time' => 'DESC');
            $list = $bargain_model->getActivityList($where,$index,$this->count,$sort);
            $join_model = new App_Model_Bargain_MysqlJoinStorage($this->curr_sid);
            $join = $join_model->statisticJoinByAids();
            $output['join'] = $join ;
        }
        $output['list'] = $list;
        $where      = array();
        $where[]    = array('name'=>'ba_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]    = array('name'=>'ba_es_id','oper'=>'=','value'=>0);
        $total = $bargain_model->getCount($where);
        $where[] = array('name' => 'ba_start_time', 'oper' => '>', 'value' => time());
        $total_zbz = $bargain_model->getCount($where);
        unset($where[2]);
        $where[] = array('name' => 'ba_start_time', 'oper' => '<', 'value' => time());
        $where[] = array('name' => 'ba_end_time', 'oper' => '>', 'value' => time());
        $total_jxz = $bargain_model->getCount($where);
        unset($where[3],$where[4]);
        $where[] = array('name' => 'ba_end_time', 'oper' => '<', 'value' => time());
        $total_yjs = $bargain_model->getCount($where);

        $bj_model = new App_Model_Bargain_MysqlJoinStorage($this->curr_sid);
        $bj_list = $bj_model->getJoinerList([],0,0);
        $total_kjcg = 0;
        $total_kjsb = 0;
        foreach($bj_list as $v){
            if($v['ba_price'] - $v['ba_buy_price_limit'] >= $v['bj_amount']){
                $total_kjcg ++;
            }else{
                $total_kjsb ++;
            }
        }
        $output['statInfo'] = [
            'total'     => $total,
            'total_zbz' => $total_zbz,
            'total_jxz' => $total_jxz,
            'total_yjs' => $total_yjs,
            'total_kjcg'=> $total_kjcg,
            'total_kjsb'=> $total_kjsb
        ];

        $this->showOutput($output);
    }

    public function _show_bargain_data_course(){
        $page       = $this->request->getIntParam('page');
        $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($this->curr_sid);
        $where      = array();
        $where[]    = array('name'=>'ba_s_id','oper'=>'=','value'=>$this->curr_sid);
        $output['type'] = $this->request->getStrParam('type','all');
        switch($output['type']){
            case 'ready':
                $where[] = array('name' => 'ba_start_time', 'oper' => '>', 'value' => time());
                break;
            case 'underway':
                $where[] = array('name' => 'ba_start_time', 'oper' => '<', 'value' => time());
                $where[] = array('name' => 'ba_end_time', 'oper' => '>', 'value' => time());
                break;
            case 'finish':
                $where[] = array('name' => 'ba_end_time', 'oper' => '<', 'value' => time());
                break;
        }

        $where[] = array('name' => 'ba_deleted', 'oper' => '=', 'value' => 0);
        $index      = $page * $this->count;
        $total      = $bargain_model->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $output['pagination']   = $pageCfg->render();
        $list = array();
        if($index < $total){
            $sort = array('ba_create_time' => 'DESC');
            $list = $bargain_model->getCourseActivityList($where,$index,$this->count,$sort);

            foreach ($list as &$value){
                $value['g_name'] = $value['atc_title'];
                $value['g_cover'] = $value['atc_cover'];
                $value['g_price'] = floatval($value['atc_price']);
            }

            $join_model = new App_Model_Bargain_MysqlJoinStorage($this->curr_sid);
            $join = $join_model->statisticJoinByAids();
            $output['join'] = $join ;
        }
        $output['list'] = $list;
        $this->showOutput($output);
    }

    
    private function _fetch_activity_status($activity){
        $status = 0;
        $timeNow = time();
        if($activity['ba_start_time']>$timeNow){
            $status = 0;
        }elseif($activity['ba_start_time']<$timeNow && $activity['ba_end_time']>$timeNow && (($activity['ba_goods_stock'] > 0 && ($activity['ba_goods_stock'] - $activity['ba_buy_num']) > 0) || ($activity['ba_goods_stock'] == 0 && $activity['g_stock'] > 0 && in_array($this->wxapp_cfg['ac_type'],[21,8,6])))){
            $status = 1;
        }
        elseif($activity['ba_end_time']<$timeNow || ($activity['ba_goods_stock'] > 0 && ($activity['ba_goods_stock'] - $activity['ba_buy_num']) <= 0) || ($activity['ba_goods_stock'] == 0 && $activity['g_stock'] <= 0 && in_array($this->wxapp_cfg['ac_type'],[21,8,6]))){
            $status = 2;
        }
        return $status;
    }

    
    public function bargainMsgAction(){
        $key        = array('kjwc', 'bkcg');
        $intField   = array();
        foreach($key as $val){
            $intField[] = $val.'_msgid';
        }
        $data     = $this->getIntByField($intField,'ba_');
        $id       = $this->request->getIntParam('hid_id');
        $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($this->curr_sid);
        $row = $bargain_model->getRowUpdateByIdSid($id,$this->curr_sid);
        if($row && $row['ba_kjwc_msgid']==$data['ba_kjwc_msgid'] && $row['ba_bkcg_msgid']==$data['ba_bkcg_msgid']){
            $ret = 1;
        }else{
            $ret         = $bargain_model->getRowUpdateByIdSid($id,$this->curr_sid,$data);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("保存砍价活动模板消息");
        }

        $this->showAjaxResult($ret,'保存');
    }


    public function addAction(){
        $this->secondLink('list');
        $id = $this->request->getIntParam('id');
        $restart = $this->request->getIntParam('restart',0);
        $row = array();
        if($id){
            $red_pack = new App_Model_Bargain_MysqlActivityStorage($this->curr_sid);
            $row = $red_pack->getRowByIdSid($id,$this->curr_sid);
            if($this->wxapp_cfg['ac_type'] == 12){
                $course_model = new App_Model_Train_MysqlTrainCourseStorage($this->curr_sid);
                $goods = $course_model->getRowById($row['ba_g_id']);
                $goods['g_id']    = $goods['atc_id'];
                $goods['g_name']  = $goods['atc_title'];
                $goods['g_price'] = $goods['atc_price'];
                $this->output['goods'] = $goods;
            }else{
                $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
                $goods = $goods_model->getRowById($row['ba_g_id']);
                $this->output['goods'] = $goods;
            }
        }

        if($this->wxapp_cfg['ac_type'] == 12){
            $this->_get_course_list();
        }else{
            $this->get_goods_list();
        }
        $this->output['status'] = plum_parse_config('bargainStatus');
        $this->output['restart'] = $restart;
        $this->output['row']    = $row;
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '砍价活动', 'link' => '/wxapp/bargain/list'),
            array('title' => '添加活动', 'link' => '#'),
        ));

        if($this->wxapp_cfg['ac_type'] == 27){
            $goodsName = '课程';
        }else{
            $goodsName = '商品';
        }
        $this->output['goodsName'] = $goodsName;
        $this->output['appletCfg'] = $this->wxapp_cfg;

        $this->displaySmarty("wxapp/bargain/activity.tpl");
    }

    private function get_goods_list(){
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $sort        = array('g_weight' => 'DESC','g_update_time'=>'DESC');
        $field       = array('g_id','g_name','g_price');
        $where[]     = array('name' => 'g_es_id', 'oper' => '=', 'value' => 0);
        $where[]     = array('name' => 'g_is_discuss', 'oper' => '=', 'value' => 0);
        if(!in_array($this->wxapp_cfg['ac_type'],[7])){//4697
            $where[]     = array('name' => 'g_independent_mall', 'oper' => '=', 'value' => 0);
        }

        if($this->wxapp_cfg['ac_type'] == 18){
            $where[]     = array('name' => 'g_kind1', 'oper' => '=', 'value' => 1);
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
                $goods[$key]['g_price'] = $val['atc_price'];
            }
        }

        $this->output['goodsList'] = $goods;
    }

    public function saveAction(){
        $res = array(
            'ec' => 400,
            'em' => '数据错误'
        );
        $id = $oldId = $this->request->getIntParam('id');
        $restart = $this->request->getIntParam('restart',0);
        $data   = array();
        $data['ba_s_id']   = $this->curr_sid;
        $data['ba_g_id'] = $this->request->getIntParam('g_id');
        $data['ba_view_num_show'] = $this->request->getStrParam('viewNumShow')=='on'?1:0;
        $data['ba_view_num'] = $this->request->getIntParam('viewNum');

        $st_date= $this->request->getStrParam('start');
        $st_time= $this->request->getStrParam('startTime');
        $en_date= $this->request->getStrParam('end');
        $en_time= $this->request->getStrParam('endTime');
        $data['ba_start_time']  = strtotime($st_date.' '.$st_time);
        $data['ba_end_time']    = strtotime($en_date.' '.$en_time);
        $data['ba_rule']   = $this->request->getStrParam('rule');
        $data['ba_image']  = $this->request->getStrParam('img');
        $data['ba_desc']   = $this->request->getStrParam('desc');
        $data['ba_goods_stock'] = $this->request->getIntParam('goods_stock');
        $section = 0;
        for($i=1 ;$i<=3 ;$i++){
            $data['ba_price_section_'.$i] = $this->request->getFloatParam('se_price_'.$i);
            $section += $data['ba_price_section_'.$i];
            $data['ba_num_section_'.$i]   = $this->request->getIntParam('se_num_'.$i);
        }
        $data['ba_buy_price_limit'] = $this->request->getFloatParam('buy_price');
        $data['ba_kj_price_limit']   = $this->request->getFloatParam('kj_price');
        $bargain_model = new App_Model_Bargain_MysqlActivityStorage($this->curr_sid);
        $verifyTime = 1;
        $need_redis = 1;
        $create_qrcode = 1;
        if($id && !$restart){

            $row = $bargain_model->getRowUpdateByIdSid($id,$this->curr_sid);
            
            if($row['ba_status'] != 0){//已开始的活动，禁止修改价格、开始时间、结束时间
                unset($data['ba_price']);
                unset($data['ba_start_time']);
                unset($data['ba_end_time']);
                $need_redis = 0;
                $verifyTime = 0;
            }
        }else{
            if($this->wxapp_cfg['ac_type'] == 12){
                $course_model = new App_Model_Train_MysqlTrainCourseStorage($this->curr_sid);
                $course = $course_model->getRowById($data['ba_g_id']);
                $currPrice = $course['atc_price'];
            }else{
                $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
                $goods = $goods_model->getRowById($data['ba_g_id']);
                $currPrice = $goods['g_price'];
            }

            $data['ba_price'] = floatval($currPrice);

            if (!is_numeric($data['ba_price'])){
                $res['em'] = '砍价商品价格异常';
                $this->displayJson($res,1);
            }
        }
        $delta = 0.0001;
        if((($data['ba_start_time'] > time() && $data['ba_end_time'] > $data['ba_start_time']) || !$verifyTime) && (abs($data['ba_price']-$data['ba_kj_price_limit']-$section) < $delta || !$data['ba_price'])){
            if($id && !$restart){
                unset($data['ba_g_id']);
                $ret = $bargain_model->getRowUpdateByIdSid($id,$this->curr_sid,$data);
            }else{
                $data['ba_create_time'] = time();
                $ret = $bargain_model->insertValue($data);
                $id  = $ret;
                $create_qrcode = 1;
            }
            if($ret){
                if($create_qrcode){
                    $this->create_qrcode($id);
                }
                if($need_redis){
                    $redis_model = new App_Model_Bargain_RedisActivityStorage($this->curr_sid);
                    $redis_model->createActivityCountdown($id,$data['ba_start_time'],$data['ba_end_time']);
                }
                if($oldId && $restart){
                    $bargain_model->deleteDFById($oldId);
                }
                $res = array(
                    'ec' => 200,
                    'em' => '活动保存成功'
                );
                App_Helper_OperateLog::saveOperateLog("砍价活动保存成功");
            }else{
                $res['em'] = '活动保存失败';
            }
        }elseif(!($data['ba_start_time'] > time() && $data['ba_end_time'] > $data['ba_start_time']) && $verifyTime){
            $res['em'] = '时间错误';
        } elseif(abs($data['ba_price']-$data['ba_kj_price_limit']-$section) >= $delta){
            $res['em'] = '三个阶段砍掉的价格之和+砍价最低价要等于商品售价';
        }
        $this->displayJson($res);
    }

    
    public function endAction(){
        $id  = $this->request->getIntParam('id');
        $set = array(
            'ba_status' => 2,
            'ba_end_time' => time()
        );
        $where = array();
        $where[] = array('name'=>'ba_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'ba_id','oper'=>'=','value'=>$id);
        $bargain_model = new App_Model_Bargain_MysqlActivityStorage($this->curr_sid);
        $ret = $bargain_model->getRowUpdateByIdSid($id,$this->curr_sid,$set);
        if($ret){
            $redis_model = new App_Model_Bargain_RedisActivityStorage($this->curr_sid);
            $redis_model->deleteActivityCountdown($id);
            $res = array(
                'ec' => 200,
                'em' => '活动结束'
            );
            App_Helper_OperateLog::saveOperateLog("结束砍价活动成功");
        }else{
            $res = array(
                'ec' => 400,
                'em' => '活动修改失败'
            );
        }
        $this->displayJson($res);
    }

    
    public function deleteAction(){
        $id  = $this->request->getIntParam('id');

        $bargain_model = new App_Model_Bargain_MysqlActivityStorage($this->curr_sid);
        $row = $bargain_model->getRowByIdSid($id,$this->curr_sid);
        if($row){
            $set = array('ba_deleted'=>1);
            $where = array();
            $where[] = array('name'=>'ba_s_id','oper'=>'=','value'=>$this->curr_sid);
            $where[] = array('name'=>'ba_id','oper'=>'=','value'=>$id);
            $res    = $bargain_model->updateValue($set,$where);
            if($res){
                $ret = array(
                    'ec' => 200,
                    'em' => '删除成功'
                );
                App_Helper_OperateLog::saveOperateLog("删除砍价活动成功");
            }else{
                $ret = array(
                    'ec' => 200,
                    'em' => '删除失败'
                );
            }
        }else{
            $ret = array(
                'ec' => 400,
                'em' => '该活动已经不存在'
            );
        }
        $this->displayJson($ret);

    }

    
    public function joinAction(){
        $this->secondLink('list');
        $this->showTypeByKey('bargainBuy');
        $this->showTypeByKey('bargainStatus');
        $this->_fetch_join_list_data();
        $this->show_bargain_activity();
        $this->buildBreadcrumbs(array(
            array('title' => '砍价活动', 'link' => '/wxapp/bargain/list'),
            array('title' => '活动数据', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/bargain/join.tpl");
    }

    private function _fetch_join_list_data(){
        $id   = $this->request->getIntParam('id');
        $page = $this->request->getIntParam('page');
        $index = $this->count * $page;
        $sort   = array('bj_amount' => 'DESC');

        $where = array();
        $where[] = array('name'=>'bj_a_id','oper'=>'=','value'=>$id);
        $where[] = array('name'=>'bj_s_id','oper'=>'=','value'=>$this->curr_sid);
        $output['buy'] = $this->request->getStrParam('buy');
        switch($output['buy']){
            case 'buy_ok':
                $where[] = array('name'=>'bj_has_buy','oper'=>'=','value'=>1);
                break;
            case 'buy_no':
                $where[] = array('name'=>'bj_has_buy','oper'=>'=','value'=>0);
                break;
        }
        $output['nickname'] = $this->request->getStrParam('nickname');
        if($output['nickname']){
            $where[] = array('name'=>'bj_m_nickname','oper'=>'like','value'=>"%{$output['nickname']}%");
        }
        $join_model = new App_Model_Bargain_MysqlJoinStorage($this->curr_sid);
        $total = $join_model->getCount($where);
        $page_cfg = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['paginator'] = $page_cfg->render();
        $list  = array();
        if($total >= $index){
            $list  = $join_model->getList($where,$index,$this->count,$sort);
        }
        $where_total = $where_buy = [];
        $where_total[] = $where_buy[]  = ['name'=>'bj_s_id','oper'=>'=','value'=>$this->curr_sid];
        $where_total[] = $where_buy[]  = ['name'=>'bj_a_id','oper'=>'=','value'=>$id];
        $where_buy[] = ['name'=>'bj_has_buy','oper'=>'=','value'=>1];
        $totalInfo = $join_model->getSum($where_total);
        $buyCount = $join_model->getCount($where_buy);
        $statInfo = [
            'joinNum' => intval($totalInfo['totalJoin']),
            'buyNum' => intval($buyCount),
            'money' => floatval($totalInfo['totalMoney'])
        ];
        $this->output['statInfo'] = $statInfo;


        $this->output['total'] = $total;
        $this->output['list'] = $list;
    }

    private function show_bargain_activity(){
        $id   = $this->request->getIntParam('id');
        $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($this->curr_sid);
        $where      = array();
        $where[]    = array('name'=>'ba_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]    = array('name'=>'ba_id','oper'=>'=','value'=>$id);
        $bargain = $bargain_model->getRowById($id);
        $this->output['bargain'] = $bargain;
    }

    
    public function effortAction(){
        $this->showTypeByKey('bargainStatus');
        $jid   = $this->request->getIntParam('jid');
        $this->show_bargain_effort($jid);
        $page = $this->request->getIntParam('page');
        $index = $this->count * $page;
        $where = array();
        $where[] = array('name'=>'be_j_id','oper'=>'=','value'=>$jid);
        $where[] = array('name'=>'be_s_id','oper'=>'=','value'=>$this->curr_sid);
        $output['nickname'] = $this->request->getStrParam('nickname');
        if($output['nickname']){
            $where[] = array('name'=>'be_m_nickname','oper'=>'like','value'=>"%{$output['nickname']}%");
        }
        $effort_model = new App_Model_Bargain_MysqlEffortStorage($this->curr_sid);
        $total = $effort_model->getCount($where);
        $page_cfg = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['paginator'] = $page_cfg->render();
        $list  = array();
        $aid   = 0;
        if($total >= $index){
            $list  = $effort_model->fetchHelpListByJid($jid,$index,$this->count);
            $aid   = $list[0]['be_a_id'];
        }
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '砍价活动', 'link' => '/wxapp/bargain/list'),
            array('title' => '参与情况', 'link' => '/wxapp/bargain/join?id='.$aid),
            array('title' => '砍价详情', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/bargain/effort.tpl");

    }

    private function show_bargain_effort($id){
        $join_model = new App_Model_Bargain_MysqlJoinStorage($this->curr_sid);
        $bargain    = $join_model->getActivityRow($id);
        $this->output['bargain'] = $bargain;
    }

    public function orderAction(){
        $this->showTypeByKey('order_status');
        $where[] = array('name' => 't_applet_type', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_APPLET_BARGAIN);

        $independent = $this->request->getIntParam('independent',0);
        $this->output['independent'] = $independent;
        if($independent == 1){
            $this->secondLink('order_independent');
        }else{
            $this->secondLink('order');
        }

        $where[] = array('name' => 't_independent_mall', 'oper' => '=', 'value' => $independent);

        $this->show_trade_list_data($where,1,0,0,1);

        $link = App_Helper_Trade::$trade_link_status;
        unset($link['tuan']);

        if($this->wxapp_cfg['ac_type'] == 12){
            unset($link['hadpay']);
            unset($link['ship']);
            unset($link['refund']);
        }

        if($this->wxapp_cfg['ac_type'] == 18){
            $link['hadpay']['label'] = '已付款';
            unset($link['ship']);
        }

        if(in_array($this->wxapp_cfg['ac_type'],[12,21,27])){
            $this->output['hasThree'] = 1;
        }

        $this->output['orderlink'] = $link;
        $this->output['todayTradeInfo'] = $this->_show_order_stat($where,true);
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '砍价管理', 'link' => '/wxapp/bargain/index'),
            array('title' => '订单管理', 'link' => '#'),
        ));

        if($this->wxapp_cfg['ac_type'] == 27){
            $goodsName = '课程';
        }else{
            $goodsName = '商品';
        }
        $this->output['goodsName'] = $goodsName;

        $this->displaySmarty('wxapp/bargain/trade-list.tpl');
    }

    
    public function downloadBargainQrcodeAction() {
        $id = $this->request->getIntParam('id');
        if($id){
            $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($this->curr_sid);
            $bargain = $bargain_model->getRowById($id);
            if(!$bargain){
                $bargain = $bargain_model->getRowById($id);
            }
            $file       = PLUM_DIR_ROOT.$bargain['ba_qrcode'];
            $filesize   = filesize($file);
            $filename   = date('YmdHis',time()).".jpg";

            plum_send_http_header("Content-type: application/octet-stream");
            plum_send_http_header("Accept-Ranges: bytes");
            plum_send_http_header("Accept-Length:".$filesize);
            plum_send_http_header("Content-Disposition: attachment; filename=".$filename);

            readfile($file);
        }
    }

    
    private function create_qrcode($id){
        $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($this->curr_sid);
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        $str = "id=".$id;
        $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::BARGAIN_DETAIL_CODE_PATH, 210);
        $updata = array('ba_qrcode'=>$url);
        $bargain_model->updateById($updata,$id);
        return $url;
    }

    
    public function createQrcodeAction(){
        $id = $this->request->getIntParam('id');
        $url = $this->create_qrcode($id);
        $res = array('ec'=> 200,'em'=> '创建成功！','url'=> $url);
        $this->displayJson($res);
    }

    
    public function activityAction(){
        $this->secondLink('activity');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '砍价管理', 'link' => '/wxapp/bargain/index'),
            array('title' => '活动申请管理', 'link' => '#'),
        ));
        $activity_model   = new App_Model_Community_MysqlActivityApplyStorage($this->curr_sid);
        $page             = $this->request->getIntParam('page');
        $index            = $page*$this->count;
        $sort             = array('aap_id'=>'DESC','aap_create_time'=>'DESC');
        $where            = array();
        $where[]          = array('name'=>'aap_s_id','oper'=>'=','value'=>$this->curr_sid);
        $list             = $activity_model->getList($where,$index,$this->count,$sort);
        $this->output['list'] = $list;
        $status           = array(0=>'未处理',1=>'已处理');
        $this->output['status'] = $status;
        $total            =  $activity_model->getCount($where);
        $page_libs  = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['paginator'] = $page_libs->render();
        $this->output['showSecondLink'] = 1;
        $this->displaySmarty('wxapp/activity/activity-list.tpl');
    }

    
    public function tradeDetailAction(){
        switch ($this->wxapp_cfg['ac_type']){
            case 4:
                $order_controller = new App_Controller_Wxapp_MealController();
                $order_controller->tradeDetailAction('bargain');
                break;
            case 7:
                $order_controller = new App_Controller_Wxapp_HotelController();
                $order_controller->tradeDetailAction('bargain');
                break;
            default:
                $order_controller = new App_Controller_Wxapp_OrderController();
                $order_controller->tradeDetailAction('bargain');
        }

    }

    public function tradeRefundAction(){
        $order_controller = new App_Controller_Wxapp_OrderController();
        $order_controller->tradeRefundAction('bargain');
    }



    
    public function shopListAction() {
        $table_menu = new App_Helper_TableMenu();
        $this->output['choseLink'] = array(
            array(
                'href'  => '/wxapp/bargain/shopList?type=all',
                'key'   => 'all',
                'label' => '全部'
            ),
            array(
                'href'  => '/wxapp/bargain/shopList?type=ready',
                'key'   => 'ready',
                'label' => '准备中'
            ),
            array(
                'href'  => '/wxapp/bargain/shopList?type=underway',
                'key'   => 'underway',
                'label' => '进行中'
            ),
            array(
                'href'  => '/wxapp/bargain/shopList?type=finish',
                'key'   => 'finish',
                'label' => '已经结束'
            ),
        );;
        $tpl_msg_model  = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
        $where[] = array('name' => 'awt_s_id','oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'awt_deleted','oper' => '=', 'value' => 0);
        $this->output['msg'] = $tpl_msg_model->getList($where,0,0);
        $this->secondLink('shop');
        $this->showTypeByKey('bargainStatus');

        if($this->wxapp_cfg['ac_type'] == 12){
            $this->_show_bargain_data_course();
        }else{
            $this->_show_bargain_data(1);
        }

        if($this->wxapp_cfg['ac_type'] == 27){
            $goodsName = '课程';
        }else{
            $goodsName = '商品';
        }
        $this->output['goodsName'] = $goodsName;

        $this->output['sid'] = $this->curr_sid;
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '砍价管理', 'link' => '/wxapp/bargain/index'),
            array('title' => '店铺活动管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/bargain/shop-bargain-list.tpl');
    }

    public function changeShowAction(){
        $status = $this->request->getIntParam('status');
        $actid  = $this->request->getIntParam('actid');

        $act_model  = new App_Model_Bargain_MysqlActivityStorage($this->curr_sid);
        $set = array('ba_index_show' => $status);
        $ret = $act_model->updateById($set, $actid);

        if($ret){
            $str = $status == 1 ? '首页展示' : '首页不展示';
            App_Helper_OperateLog::saveOperateLog("修改砍价活动".$str);
        }

        $this->showAjaxResult($ret);
    }




    public function sequenceOrderAction(){
        $this->showTypeByKey('order_status');
        $where[] = array('name' => 't_applet_type', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_APPLET_BARGAIN);
        $this->show_sequence_trade_list_data($where);
        $this->secondLink('order');
        $order_link = App_Helper_Trade::$trade_link_status;
        unset($order_link['tuan']);
        unset($order_link['hadpay']);
        unset($order_link['ship']);


        if(in_array($this->wxapp_cfg['ac_type'],[12,21,27])){
            $this->output['hasThree'] = 1;
        }
        $this->output['bargain_trade'] = 1;
        $this->output['orderlink'] = $order_link;
        $this->output['todayTradeInfo'] = $this->_show_sequence_order_stat($where,true);
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '砍价管理', 'link' => '/wxapp/bargain/index'),
            array('title' => '订单管理', 'link' => '#'),
        ));

        if($this->wxapp_cfg['ac_type'] == 27){
            $goodsName = '课程';
        }else{
            $goodsName = '商品';
        }
        $this->output['goodsName'] = $goodsName;

        $this->displaySmarty('wxapp/sequence/cb-trade-list.tpl');
    }

    
    protected function _show_sequence_order_stat($where,$today = true){
        if($today){
            $time = strtotime(date('Y-m-d',time()));
            $where[] = array('name'=>'t_create_time','oper'=>'>=','value'=>$time);
        }

        $where[] = array('name'=>'t_status','oper'=>'in','value'=>array(3,4,5,6));
        $where[] = array('name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid);
        $order_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        return $order_model->statSequenceOrderStatisticNew($where);
    }


    
    public function show_sequence_trade_list_data($where= array(),$needExpress=1,$isrefund=0,$type=0){

        $output['status'] = $this->request->getStrParam('status','all');
        $expressMethod = array(
            1 => '商家配送',
            2 => '门店自取',
            3 => '快递发货',
            5 => '蜂鸟配送',
            6 => '团长配送'
        );
        if($this->wxapp_cfg['ac_type'] == 32){
            unset($expressMethod[3]);
        }
        $output['expressMethod'] = $expressMethod;
        if($isrefund==1){
            $link = App_Helper_Trade::$trade_refund_link_status;
            if($output['status'] && isset($link[$output['status']]) && $link[$output['status']]['id'] > 0){
                $where[]= array('name'=>'t_feedback','oper'=>'=','value'=>$link[$output['status']]['id']);
            }
        }else{
            $link = App_Helper_Trade::$trade_link_status;
            if($this->wxapp_cfg['ac_type'] == 12){
                unset($link['hadpay']);
                unset($link['refund']);
            }
            if($this->wxapp_cfg['ac_type'] == 32){
                $link['hadpay']['label'] = '已付款';
                $link['finish']['label'] = '已完成';
                $link['refund']['label'] = '退款';
                unset($link['tuan']);
                unset($link['ship']);
            }

            if($output['status'] && isset($link[$output['status']]) && $link[$output['status']]['id'] == 0 && $type == App_Helper_Trade::TRADE_AUCTION){
                $where[]= array('name'=>'t_status','oper'=>'!=','value'=>1);
                $where[]= array('name'=>'t_status','oper'=>'!=','value'=>7);
            }
            if($output['status'] && isset($link[$output['status']]) && $link[$output['status']]['id'] > 0){
                $where[]= array('name'=>'t_status','oper'=>'=','value'=>$link[$output['status']]['id']);
            }elseif($output['status'] == 'winNOPay'){
                $where[]= array('name'=>'t_status','oper'=>'=','value'=>11);
            }
        }
        $this->output['link'] = $link;
        $this->output['statusNote'] = plum_parse_config('trade_status');
        $this->output['trade_screen'] = plum_parse_config('trade_screen');
        if(in_array($output['status'],array('all','hadpay')) && $needExpress){
            $express_model  = new App_Model_Trade_MysqlExpressStorage();
            $express = $express_model->getExpressList(1);
        }else{
            $express = array();
        }
        $this->output['express'] = $express;

        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $sort       = array('t_create_time' => 'DESC');

        $where[]    = array('name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]    = array('name'=>'t_status','oper'=>'>','value'=>0);
        $output['title'] = $this->request->getStrParam('title');
        if($output['title']){
            $where[]= array('name'=>'t_title','oper'=>'like','value'=>"%{$output['title']}%");
        }
        $output['tid'] = $this->request->getStrParam('tid');
        if($output['tid']){
            $where[]= array('name'=>'t_tid','oper'=>'=','value'=>$output['tid']);
        }
        $output['buyer']  = $this->request->getStrParam('buyer');
        if($output['buyer']){
            $where[]= array('name'=>'t_buyer_nick','oper'=>'like','value'=>"%{$output['buyer']}%");
        }
        $output['harvest']  = $this->request->getStrParam('harvest');
        if($output['harvest']){
            $where[]= array('name'=>'t_express_company','oper'=>'like','value'=>"%{$output['harvest']}%");
        }
        $output['phone']  = $this->request->getStrParam('phone');
        if($output['phone']){
            $where[]= array('name'=>'t_express_code','oper'=>'=','value'=>$output['phone']);
        }
        $output['mobile']  = $this->request->getStrParam('mobile');
        if($output['mobile']){
            $where[]= array('name'=>'t_express_code','oper'=>'=','value'=>$output['mobile']);
        }
        $output['realName']  = $this->request->getStrParam('realName');
        if($output['realName']){
            $where[]= array('name'=>'t_express_company','oper'=>'like','value'=>"%{$output['realName']}%");
        }
        if(!$type){
            $where[]     = array('name'=>'t_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET );
        }else{
            $where[]     = array('name'=>'t_type','oper'=>'=','value'=>$type);
        }
        $output['start']   = $this->request->getStrParam('start');
        if($output['start']){
            $where[]    = array('name' => 't_create_time', 'oper' => '>=', 'value' => strtotime($output['start']));
        }
        $output['end']     = $this->request->getStrParam('end');
        if($output['end']){
            $where[]    = array('name' => 't_create_time', 'oper' => '<=', 'value' => (strtotime($output['end']) + 86400));
        }
        $output['esId'] = $this->request->getIntParam('esId',0);
        if($output['esId'] > 0){
            $where[]    = array('name' => 't_es_id', 'oper' => '=', 'value' => $output['esId']);
        }elseif ($output['esId'] < 0){
            $where[]    = array('name' => 't_es_id', 'oper' => '=', 'value' => 0);
        }
        $output['postType'] = $this->request->getIntParam('postType',0);
        if($output['postType'] > 0){
            $where[]    = array('name' => 't_express_method', 'oper' => '=', 'value' => $output['postType']);
        }
        $output['osId'] = $this->request->getIntParam('osId',0);
        if($output['osId'] > 0){
            $where[]    = array('name' => 't_store_id', 'oper' => '=', 'value' => $output['osId']);
            if($this->wxapp_cfg['ac_type'] != 18){
                $output['postType'] = 2;
            }
        }
        $output['community'] = $this->request->getStrParam('community','');
        if($output['community']){
            $where[]= array('name'=>'asc_name','oper'=>'like','value'=>"%{$output['community']}%");
        }
        $output['leader'] = $this->request->getStrParam('leaderName','');
        if($output['leader']){
            $where[]= array('name'=>'asl_name','oper'=>'like','value'=>"%{$output['leader']}%");
        }

        $output['tradeScreen'] = $this->request->getStrParam('tradeScreen','valid');
        if($output['tradeScreen'] && $output['status'] != 'closed'){
            switch ($output['tradeScreen']){
                case 'valid':
                    $where[] = array('name' => 't_status', 'oper' => '!=', 'value' => App_Helper_Trade::TRADE_CLOSED);
                    break;
                case 'close':
                    $where[] = array('name' => 't_status', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_CLOSED);
                    break;
            }
        }

        $output['searchTradeInfo'] = $this->_show_sequence_order_stat($where,FALSE);
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $total       = $trade_model->getSequenceAddressCountNew($where);
        $page_lib    = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['page_html'] = $page_lib->render();
        $list     = array();
        $trader   = array();
        if($total > $index){
            $list = $trade_model->getSequenceAddressListNew($where,$index,$this->count,$sort);
            $ids  = array();
            $store_storage = new App_Model_Cake_MysqlCakeStoreStorage($this->curr_sid);
            foreach($list as $key=>$val){
                $ids[] = $val['t_id'];
                if($val['t_store_id']){
                    $store  = $store_storage->getRowById($val['t_store_id']);
                    $list[$key]['storeName'] = $store['acs_name'];
                }
            }
            $trade_order    = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);

            $temp   =  $trade_order->getListByGoIds($ids);
            foreach($temp as $val){
                if(isset($trader[$val['to_t_id']]['count'])){
                    $trader[$val['to_t_id']]['count'] ++ ;
                }else{
                    $trader[$val['to_t_id']]['count']  = 1;
                }
                $trader[$val['to_t_id']]['data'][] = $val;
            }
        }
        $output['trader'] = $trader;
        foreach ($list as $key=>$val){
            $list[$key]['t_remark_extra'] = json_decode($val['t_remark_extra'], true);
        }
        $output['list']   = $list;
        $this->showOutput($output);
    }


    
    public function saveBargainCfgAction(){
        $show   = $this->request->getIntParam('show');
        $title  = $this->request->getStrParam('title');
        $desc   = $this->request->getStrParam('desc');
        $logo   = $this->request->getStrParam('logo');
        $qrcode = $this->request->getStrParam('qrcode');

        $data['bc_s_id'] = $this->curr_sid;
        $data['bc_wxgroup_show']   = $show;
        $data['bc_wxgroup_title']  = $title;
        $data['bc_wxgroup_desc']   = $desc;
        $data['bc_wxgroup_logo']   = $logo;
        $data['bc_wxgroup_qrcode'] = $qrcode;
        $data['bc_update_time']    = time();

        $cfg_model = new App_Model_Bargain_MysqlCfgStorage($this->curr_sid);
        $bargain_cfg = $cfg_model->findShopCfg();

        if($bargain_cfg){
            $ret = $cfg_model->findShopCfg($data);
        }else{
            $ret = $cfg_model->insertValue($data);
        }
        if($ret){
            App_Helper_OperateLog::saveOperateLog("砍价活动配置保存成功");
        }


        $this->showAjaxResult($ret);
    }
}

