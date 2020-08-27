<?php

class App_Controller_Wxapp_LimitController extends App_Controller_Wxapp_OrderCommonController
{
    const PROMOTION_TOOL_KEY    = 'wms';
    public function __construct()
    {
        parent::__construct();
        
    }

    
    public function secondLink($type='index',$page_type=''){
        $link = array(
            array(
                'label' => '秒杀首页',
                'link'  => '/wxapp/limit/cfg',
                'active'=> 'cfg'
            ),
            array(
                'label' => '秒杀商品分组',
                'link'  => '/wxapp/limit/group',
                'active'=> 'group'
            ),
            array(
                'label' => '秒杀活动',
                'link'  => $page_type == 'meal' ? '/wxapp/meal/index' :'/wxapp/limit/index',
                'active'=> 'index'
            ),
            array(
                'label' => '秒杀订单',
                'link'  => ($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36) ? '/wxapp/limit/sequenceOrder' : '/wxapp/limit/order',
                'active'=> 'order'
            ),
        );
        if($this->wxapp_cfg['ac_type'] == 27){
            $link[1]['label'] = '秒杀课程分组';
            unset($link[0]);

        }
        if(in_array($this->wxapp_cfg['ac_type'],[6,8])){
            $link[] = array(
                'label' => '营销活动申请',
                'link'  => '/wxapp/limit/activity',
                'active'=> 'activity'
            );
            $link[] = array(
                'label' => '店铺活动列表',
                'link'  => '/wxapp/limit/shopLimit',
                'active'=> 'shop'
            );
        }
        if(in_array($this->wxapp_cfg['ac_type'],[7])){
            $link[] = array(
                'label' => '商城秒杀订单',
                'link'  => '/wxapp/limit/order?independent=1',
                'active'=> 'order_independent'
            );
        }

        $this->output['link']       = $link;
        $this->output['linkType']   = $type;
        $this->output['snTitle']    = '秒杀';
    }

    public function cfgAction(){
        $page_type = $this->request->getStrParam('page_type','');
        $this->secondLink('cfg',$page_type);
        $cfg        = $this->wxapp_cfg;
        $this->output['shopType']    = $cfg['ac_type'];
        $this->showIndexTpl();
        $this->showShopTplSlide(0, 4);
        $this->showShopTplShortcut(-1);

        $this->_limit_group();//秒杀商品分组

        $this->_get_list_for_select();
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
            array('title' => '秒杀管理', 'link' => '/wxapp/limit/cfg'),
            array('title' => '首页配置', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/limit/limit-cfg.tpl");
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

    
    private function _get_list_for_select(){
        if($this->menuType == 'toutiao'){
            $config_name = 'toutiaosystem';
        }else{
            $config_name = 'system';
        }


        $linkList = plum_parse_config('link',$config_name);
        $linkType = plum_parse_config('link_type',$config_name);
        $groupType = plum_parse_config('link_type_limit',$config_name);
        unset($linkType[1]);
        if($this->menuType != 'toutiao'){
            unset($linkType[3]);
        }

        $link = $linkList[$this->wxapp_cfg['ac_type']];
        if($this->wxapp_cfg['ac_type']==6){//同城的
            unset($groupType[0]);
            unset($groupType[2]);
        }
        if($this->wxapp_cfg['ac_type']==12  || $this->wxapp_cfg['ac_type'] == 7 || $this->wxapp_cfg['ac_type'] == 4){
            unset($groupType[0]);
            unset($groupType[1]);
            unset($groupType[2]);
        }
        if($this->wxapp_cfg['ac_type']==18){
            unset($groupType[0]);
        }
        if($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36){
            unset($groupType[0]);
            unset($groupType[2]);
            unset($linkType[3]);
            unset($linkType[4]);
        }
        if($this->wxapp_cfg['ac_type']!=6 && $this->wxapp_cfg['ac_type']!=8){//同城的
            unset($groupType[4]);
            unset($groupType[5]);
            unset($groupType[6]);
        }

        $this->output['linkList'] = json_encode($link);
        $this->output['linkTypes'] = json_encode(array_merge($linkType,$groupType));
    }


    
    private function showIndexTpl(){
        $tpl_model = new App_Model_Limit_MysqlLimitIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid();
        if(empty($tpl)){
            $tpl = array(
                'ali_title'         => '微秒杀',
            );
        }
        $this->output['tpl'] = $tpl;
    }


    
    private function _limit_group(){
        $where      = array();
        $where[]    = array('name' => 'alg_s_id','oper' => '=','value' =>$this->curr_sid);
        $group_model    = new App_Model_Limit_MysqlLimitGroupStorage($this->curr_sid);
        $sort = array('alg_create_time' => 'DESC');
        $list = $group_model->getList($where,0,0,$sort);
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'   => $val['alg_id'],
                    'name' => $val['alg_name'],
                );
            }
        }
        $this->output['goodsGroup'] = json_encode($data);
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

    
    private function _shop_top_goods_list($top = 1){
        $test = $this->request->getIntParam('test');
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $goods_list = $goods_storage->fetchShopGoodsList($this->curr_sid,0,200,'',$top,array(),array(),0,0,0);
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

    
    public function saveCfgAction(){
        $title      = $this->request->getStrParam('title');
        $isopen     = $this->request->getIntParam('isopen');
        $showcoupon = $this->request->getIntParam('showcoupon');
        $applyTitle = $this->request->getStrParam('applyTitle');
        $data = array(
            'ali_s_id'                => $this->curr_sid,
            'ali_title'               => $title,
            'ali_update_time'         => time(),
            'ali_isopen'              =>$isopen,
            'ali_show_coupon'         =>$showcoupon,
            'ali_apply_title'         => $applyTitle
        );
        $tpl_model = new App_Model_Limit_MysqlLimitIndexStorage($this->curr_sid);
        $tpl_row   = $tpl_model->findUpdateBySid();
        if(!empty($tpl_row)){
            $ret = $tpl_model->findUpdateBySid($data);
        }else{
            $tpl['ali_create_time']= time();
            $ret = $tpl_model->insertValue($data);
        }
        if($ret){
            $this->save_shop_slide(0, 4);//保存幻灯
            $this->save_shop_shortcut_new(-1);//保存导航
            App_Helper_OperateLog::saveOperateLog("秒杀首页模板配置保存成功");
            $result = array(
                'ec' => 200,
                'em' => '信息保存成功'
            );
        }else{
            $result = array(
                'ec' => 400,
                'em' => '模版不可用'
            );
        }
        $this->displayJson($result);
    }

    public function groupAction(){
        $this->secondLink('group');
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $where      = array();
        $where[]    = array('name' => 'alg_s_id','oper' => '=','value' =>$this->curr_sid);
        $output['name'] = $this->request->getStrParam('name');
        if($output['name']){
            $where[]    = array('name' => 'alg_name','oper' => 'like','value' =>"%{$output['name']}%");
        }

        $group_model    = new App_Model_Limit_MysqlLimitGroupStorage($this->curr_sid);
        $total          = $group_model->getCount($where);
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        $list   = array();
        $limit_model = new App_Model_Limit_MysqlLimitActStorage($this->curr_sid);
        if($index <= $total){
            $sort = array('alg_create_time' => 'DESC');
            $list = $group_model->getList($where,$index,$this->count,$sort);
            foreach($list as $key => &$val){
                $params = array(
                    'gpid' => $val['alg_id']
                );
                if($this->wxapp_cfg['ac_type'] == 12){
                    $list[$key]['alg_total'] = $limit_model->getCountCourse('look',$val['alg_id'],'');
                }else{
                    $list[$key]['alg_total'] = $limit_model->getCountGoods('look',$val['alg_id'],'');
                }
            }
        }
        $output['list'] = $list;
        $this->showOutput($output);
        $this->renderCropTool('/wxapp/index/uploadImg');

        if($this->wxapp_cfg['ac_type'] == 27){
            $goodsName = '课程';
        }else{
            $goodsName = '商品';
        }
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '秒杀管理', 'link' => '/wxapp/limit/cfg'),
            array('title' => "活动{$goodsName}分组", 'link' => '#'),
        ));
        $this->output['goodsName'] = $goodsName;

        $this->displaySmarty('wxapp/limit/goods-group.tpl');
    }

    
    public function saveActiveGroupAction(){
        $result = array(
            'ec' => 400,
            'em' => '分组名称不能为空'
        );
        $id       = $this->request->getIntParam('id');
        $name     = $this->request->getStrParam('name');
        $brief    = $this->request->getStrParam('brief');
        $img      = $this->request->getStrParam('img');
        $style    = $this->request->getIntParam('style');
        if($name){
            $group_model    = new App_Model_Limit_MysqlLimitGroupStorage($this->curr_sid);
            if($id){
                $set = array(
                    'alg_name'       => $name,
                    'alg_list_type'  => $style,
                    'alg_brief'      => $brief,
                    'alg_bg'         => $img
                );
                $ret = $group_model->getRowUpdateByIdSid($id,$this->curr_sid,$set);
            }else{
                $data = array(
                    'alg_s_id'       => $this->curr_sid,
                    'alg_name'       => $name,
                    'alg_list_type'  => $style,
                    'alg_brief'      => $brief,
                    'alg_bg'         => $img,
                    'alg_create_time'=> time()
                );
                $ret = $group_model->insertValue($data);
            }
            if($ret){
                App_Helper_OperateLog::saveOperateLog("秒杀商品分组【".$name."】保存成功");
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功'
                );
            }else{
                $result['em'] = '保存失败';
            }
        }
        $this->displayJson($result);
    }

    
    public function groupGoodsAction(){
        $this->count= 10;
        $id       = $this->request->getIntParam('id');
        $keyword  = $this->request->getStrParam('keyword');
        $page     = $this->request->getIntParam('page',1);
        $page     = $page >=1 ? $page : 1;
        $type     = $this->request->getStrParam('type');
        $index    = ($page - 1)* $this->count;
        $goods_model = new App_Model_Limit_MysqlLimitActStorage($this->curr_sid);
        if($this->wxapp_cfg['ac_type'] == 12){
            $list        = $goods_model->getGroupCourse($type,$id,$index,$this->count,$keyword);
            $total       = $goods_model->getCountCourse($type,$id,$keyword);
        }else{
            $list        = $goods_model->getGroupGoods($type,$id,$index,$this->count,$keyword);
            $total       = $goods_model->getCountGoods($type,$id,$keyword);
        }

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

    
    public function saveGoodsGroupAction(){
        $id     = $this->request->getIntParam('id');
        $gg     = $this->request->getIntParam('gg');
        $type   = $this->request->getStrParam('type');
        $where      = array();
        $where[]    = array('name' => 'algm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]    = array('name' => 'algm_g_id', 'oper' => '=', 'value' => $id);
        $where[]    = array('name' => 'algm_gg_id', 'oper' => '=', 'value' => $gg);
        $match_model = new App_Model_Limit_MysqlLimitGroupMatchStorage($this->curr_sid);
        $group_model = new App_Model_Limit_MysqlLimitGroupStorage($this->curr_sid);
        if($type == 'del'){
            $label = '移除';
            $ret   = $match_model->deleteValue($where);
            $group_model->changeTotalById($gg,2);
        }else{
            $row = $match_model->getRow($where);
            if(empty($row)){
                $data = array(
                    'algm_s_id'  => $this->curr_sid,
                    'algm_g_id'  => $id,
                    'algm_gg_id' => $gg,
                    'algm_create_time' => time()
                );
                $ret = $match_model->insertValue($data);
                $group_model->changeTotalById($gg);
            }else{
                $ret = true;
            }
            $label = '追加';
        }

        if($ret){
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            $goods = $goods_model->getRowById($id);
            $group = $group_model->getRowById($gg);
            App_Helper_OperateLog::saveOperateLog("秒杀分组【{$group['alg_name']}】{$label}商品【{$goods['g_name']}】");
        }

        $this->showAjaxResult($ret,$label);
    }

    
    public function changeWeightAction(){
        $id     = $this->request->getIntParam('id');
        $val    = $this->request->getIntParam('val');
        $set    = array(
          'algm_weight'      => $val,
          'algm_create_time' => time()
        );
        $match_model = new App_Model_Limit_MysqlLimitGroupMatchStorage($this->curr_sid);
        $ret = $match_model->getRowUpdateByIdSid($id,$this->curr_sid,$set);
        $this->showAjaxResult($ret);
    }




    public function indexAction() {
        $this->secondLink('index');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '秒杀管理', 'link' => '/wxapp/limit/cfg'),
            array('title' => '秒杀活动', 'link' => '#'),
        ));
        $this->full_list_data();
        $this->renderCropTool('/wxapp/index/uploadImg');

        $cfg_model = new App_Model_Limit_MysqlLimitCfgStorage($this->curr_sid);
        $limit_cfg = $cfg_model->fetchUpdateCfg();

        $this->output['limitCfg'] = $limit_cfg;
        $this->output['appletCfg'] = $this->wxapp_cfg;

        $this->displaySmarty('wxapp/limit/list.tpl');
    }

    
    private function full_list_data($isShop=0){
        $page       = $this->request->getIntParam('page');
        $output['status'] = $this->request->getStrParam('status','all');
        $index      = $page * $this->count;
        $where      = array();
        $where[]    = array('name' => 'la_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        if($isShop){
            $where[]    = array('name' => 'la_es_id', 'oper' => '>', 'value' => 0);
        }else{
            $where[]    = array('name' => 'la_es_id', 'oper' => '=', 'value' => 0);
        }
        $output['name']     = $this->request->getStrParam('name');
        if($output['name']) {
            $where[]    = array('name' => 'la_name', 'oper' => '=', 'value' => "%{$output['name']}%");
        }
        $time = time();
        switch($output['status']){
            case 'notStart' :
                $where[]    = array('name' => 'la_start_time', 'oper' => '>', 'value' => $time);
                break;
            case 'runing' :
                $where[]    = array('name' => 'la_start_time', 'oper' => '<', 'value' => $time);
                $where[]    = array('name' => 'la_end_time', 'oper' => '>', 'value' => $time);
                break;
            case 'finish' :
                $where[]    = array('name' => 'la_end_time', 'oper' => '<', 'value' => $time);
                break;
            default:
                break;
        }
        $act_model  = new App_Model_Limit_MysqlLimitActStorage($this->curr_sid);
        $total      = $act_model->getCount($where);
        $list       = array();
        if($index < $total){
            $sort   = array('la_create_time' => 'DESC');
            $list   = $act_model->getList($where,$index,$this->count,$sort);
            foreach($list as &$val){
                $param = array('laid' => $val['la_id']);
                $val['link'] = $this->composeLink('limit','detail',$param,true);
            }
        }
        $page_libs  = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['pageHtml'] = $page_libs->render();
        $output['list']     = $list;
        $where      = array();
        $where[]    = array('name' => 'la_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]    = array('name' => 'la_es_id', 'oper' => '=', 'value' => 0);
        $total = $act_model->getCount($where);
        $where[]    = array('name' => 'la_start_time', 'oper' => '>', 'value' => $time);
        $total_zbz = $act_model->getCount($where);
        unset($where[2]);
        $where = array_values($where);
        $where[]    = array('name' => 'la_start_time', 'oper' => '<', 'value' => $time);
        $where[]    = array('name' => 'la_end_time', 'oper' => '>', 'value' => $time);
        $total_jxz = $act_model->getCount($where);
        unset($where[2],$where[3]);
        $where = array_values($where);
        $where[]    = array('name' => 'la_end_time', 'oper' => '<', 'value' => $time);
        $total_yjs = $act_model->getCount($where);
        $output['statInfo'] = [
            'total'     => $total,
            'total_zbz' => $total_zbz,
            'total_jxz' => $total_jxz,
            'total_yjs' => $total_yjs
        ];
        $this->showOutput($output);
    }


    
    public function addAction() {
        $this->secondLink('index');
        $id   = $this->request->getIntParam('id');
        $row  = array();
        if($id){
            $act_model  = new App_Model_Limit_MysqlLimitActStorage($this->curr_sid);
            $row        = $act_model->getRowUpdateByIdSid($id,$this->curr_sid);
        }
        if(!empty($row)){
            $this->show_goods_by_actId($row['la_id']);
        }
        $this->output['row']    = $row;
        $this->output['sid']    = $this->curr_sid;
        $this->buildBreadcrumbs(array(
            array('title' => '限时活动', 'link' => '/wxapp/limit/index'),
            array('title' => '添加限时活动', 'link' => '#'),
        ));

        if($this->wxapp_cfg['ac_type'] == 27){
            $goodsName = '课程';
        }else{
            $goodsName = '商品';
        }
        $this->output['goodsName'] = $goodsName;

        $customShare = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[6,8,21])){
            $customShare = 1;
        }
        $this->output['customShare'] = $customShare;
        $banEdit = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[32]) && $row &&$row['la_start_time'] <= time()){
            $banEdit = 1;
        }
        $this->output['banEdit'] = $banEdit;


        $example_model = new App_Model_Limit_MysqlLimitFakeExampleStorage($this->curr_sid);
        $example_list = $example_model->getExampleList($id);
        if($example_list){
            foreach ($example_list as &$val){
                $val['lfe_time'] = date('Y-m-d',$val['lfe_time']);
            }
        }
        $this->output['example_list'] = $example_list;

        $showExample = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[6,8,21,32])){
            $showExample = 1;
        }
        $this->output['showExample'] = $showExample;

        $this->renderCropTool('/wxapp/index/uploadImg');
        if(in_array($this->wxapp_cfg['ac_type'],[6,8,21,32])){
            $this->displaySmarty('wxapp/limit/add-new.tpl');
        }else{
            $this->displaySmarty('wxapp/limit/add.tpl');
        }
    }


    
    public function saveLimitAction(){
        $field                  = array('name','label');
        $data                   = $this->getStrByField($field,'la_');

        $start                  = $this->request->getStrParam('start_time');
        $end                    = $this->request->getStrParam('end_time');
        $data['la_start_time']  = strtotime($start);
        $data['la_end_time']    = strtotime($end);
        $data['la_update_time'] = time();
        $data['la_share_title'] = $this->request->getStrParam('share_title','');
        $data['la_share_img'] = $this->request->getStrParam('share_image','');
        $banEdit = $this->request->getIntParam('banEdit');
        if($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36){
            $data['la_ignore_deduct'] = $this->request->getIntParam('ignoreDeduct',0);
        }


        $id         = $this->request->getIntParam('id');
        $act_model  = new App_Model_Limit_MysqlLimitActStorage($this->curr_sid);
        $update = false;
        if($id){
            if($banEdit){
                $data_old = $data;
                $data = [];
                $data['la_name'] = $data_old['la_name'];
                $data['la_label'] = $data_old['la_label'];
                $data['la_update_time'] = time();
            }else{
                if($data['la_end_time'] <= $_SERVER['REQUEST_TIME'] ||  $data['la_start_time'] >= $data['la_end_time']){
                    $this->displayJsonError('请选择正确的时间');
                }
            }
            $update =true;
            $ret = $act_model->getRowUpdateByIdSid($id,$this->curr_sid,$data);
        }else{
            if($data['la_start_time'] <= $_SERVER['REQUEST_TIME'] ||  $data['la_start_time'] >= $data['la_end_time']){
                $this->displayJsonError('请选择正确的时间');
            }
            $data['la_create_time'] = $_SERVER['REQUEST_TIME'];
            $data['la_s_id']        = $this->curr_sid;
            $ret = $act_model->insertValue($data);
            $id  = $ret;
        }
        if($ret && $id) {
            App_Helper_OperateLog::saveOperateLog("秒杀活动【".$data['la_name']."】保存成功");
            if(!$banEdit){
                $this->save_act_goods($id,$update);
            }
            $this->_save_fake_example($id);
        }
        $this->showAjaxResult($ret , '保存');
    }

    private function _save_fake_example($id){
        $exampleList = $this->request->getArrParam('exampleList');
        Libs_Log_Logger::outputLog($exampleList,'test.log');
        $example_model = new App_Model_Limit_MysqlLimitFakeExampleStorage($this->curr_sid);

        if(is_array($exampleList) && !empty($exampleList)){
            if($this->curr_sid == 5655){
                Libs_Log_Logger::outputLog('没有全部删除','test.log');
                Libs_Log_Logger::outputLog($exampleList,'test.log');
            }
            $example_list = $example_model->getExampleList($id,0,0,true);
            if(!empty($example_list)){
                $del_id = array();
                foreach($exampleList as $key => $val){
                    if(isset($example_list[$val['id']])){
                        $set = array(
                            'lfe_title' => $val['title'],
                            'lfe_num'   => $val['num'],
                            'lfe_time'  => strtotime($val['time'])
                        );
                        $up_ret = $example_model->updateById($set,$val['id']);
                        unset($exampleList[$key]);
                        unset($example_list[$val['id']]);
                    }
                }

                $del_id = array_keys($example_list);
                Libs_Log_Logger::outputLog($del_id,'test.log');

                if(!empty($del_id)){
                    $example_where = array();
                    $example_where[] = array('name' => 'lfe_id','oper' => 'in' , 'value' => $del_id);
                    $example_model->deleteValue($example_where);
                }

            }
            if(!empty($exampleList)){
                $insert = array();
                foreach($exampleList as $val){
                    $time = strtotime($val['time']);
                    $insert[] = " (NULL, {$this->curr_sid},'{$id}','{$val['title']}', '{$val['num']}','{$time}', '".time()."')";
                }
                $ins_ret = $example_model->insertBatch($insert);
            }
        }else{
            if($this->curr_sid == 5655){
                Libs_Log_Logger::outputLog('执行全部删除','test.log');
            }
            $del_where = [];
            $del_where[] = ['name' => 'lfe_s_id','oper' => '=' , 'value' => $this->curr_sid];
            $del_where[] = ['name' => 'lfe_la_id','oper' => '=' , 'value' => $id];
            $example_model->deleteValue($del_where);
        }
    }

    
    private function save_act_goods($newid,$update){
        $start                  = $this->request->getStrParam('start_time');
        $end                    = $this->request->getStrParam('end_time');
        $goods        = $this->request->getArrParam('goods');
        $limit_goods_model  = new App_Model_Limit_MysqlLimitGoodsStorage($this->curr_sid);
        $limit_goods_model->deleteListByActid($newid);
        $insert       = array();
        $act_model  = new App_Model_Limit_MysqlLimitActStorage($this->curr_sid);
        $goods_exits = $act_model->getActGoodsList(strtotime($start),strtotime($end));
        $exits = array();
        foreach($goods_exits as $val){
            $exits[] = $val['lg_g_id'];
        }
        foreach($goods as $val){
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            $good = $goods_model->getRowById($val['gid']);
            if(in_array($val['gid'], $exits)){
                if(!$update){
                    $act_model->deleteById($newid);
                }
                $this->displayJsonError($good['g_name'].'已存在于其他同期秒杀活动中');
            }
            $gid = intval($val['gid']);
            $price = floatval($val['price']);
            $limit = intval($val['limit']);
            $stock = intval($val['stock']);
            $sold  = intval($val['sold']);
            $viewNum  = intval($val['viewNum']);
            $viewNumShow  = intval($val['viewNumShow']);
            $format_price=$this->_save_limit_format($newid, $val['gid'], $val['format']);
            if($format_price!=-1){
                if($price)
                    $price=min($price,$format_price);
                else
                    $price=$format_price;
            }
            $price = floatval($price) >= 0 ? $price : 0;
            $insert[] = "(null,{$this->curr_sid},{$newid},{$gid},{$price},{$limit},{$stock},{$sold},{$viewNum},{$viewNumShow},{$_SERVER['REQUEST_TIME']})";
        }
        if(!empty($insert)){
            $limit_goods_model->insertNew2Bacth($insert);
        }
    }
    private function _save_limit_format($actId, $gid, $format){
        $price_arr=[];
        $limit_format_model  = new App_Model_Limit_MysqlLimitGoodsFormatStorage($this->curr_sid);
        $limit_format_model->deleteListByActidGid($actId, $gid);
        $insert  = array();
        $hadSave = array();
        foreach($format as $val){
            $price = floatval($val['price']);
            $price_arr[]=$price;
            $stock = intval($val['stock']);
            if(!in_array($val['id'], $hadSave)){
                $insert[] = "(null,{$this->curr_sid},{$actId},{$gid},{$val['id']},{$price},{$stock},{$_SERVER['REQUEST_TIME']})";
                $hadSave[] = $val['id'];
            }
        }
        if(!empty($insert)){
            $limit_format_model->insertBacth($insert);
        }
        if($price_arr)
            return min($price_arr);
        else
            return -1;
    }

    
    private function show_goods_by_actId($actid){
        $goods   = array();
        $goods_model    = new App_Model_Limit_MysqlLimitGoodsStorage($this->curr_sid);
        if($this->wxapp_cfg['ac_type'] == 12){
            $goods_list     = $goods_model->getListByActidCourse($actid);
        }else{
            $goods_list     = $goods_model->getListByActid($actid);
        }
        foreach($goods_list as $val){
            if($this->wxapp_cfg['ac_type'] == 12){
                $price = $val['atc_price'];
                $name  = $val['atc_title'];
            }else{
                $price = $val['g_price'];
                $name  = $val['g_name'];
            }
            $goods[] = array(
                'id'     => $val['lg_id'],
                'gid'    => $val['lg_g_id'],
                'gname'  => $name,
                'gprice' => $price,
                'limit'  => $val['lg_limit'],
                'stock'  => $val['lg_stock'],
                'sold'   => $val['lg_virtual_sold'],
                'price'  => $val['lg_yh_price'],
                'viewNum'  => $val['lg_view_num'],
                'viewNumShow'  => $val['lg_view_num_show'],
                'format' => $this->_get_goods_format($val['lg_g_id'], $actid)
            );
        }
        $this->output['goods'] = $goods;
    }

    private function _get_goods_format($gid, $actid){
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
        $where = array();
        $where[] = array('name' => 'gf_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'gf_g_id', 'oper' => '=', 'value' => $gid);
        $where[] = array('name' => 'lgf_actid', 'oper' => '=', 'value' => $actid);
        $format         = $format_model->getFormatListAndLimitAction($where);
        $data = array();
        foreach($format as $val){
            $data[] = [
                'id'       => $val['lgf_id'],
                'gfid'     => $val['gf_id'],
                'name'     => $val['gf_name'].($val['gf_name2']?('-'.$val['gf_name2']):'').($val['gf_name3']?('-'.$val['gf_name3']):''),
                'gfprice'  => $val['gf_price'],
                'price'    => $val['lgf_yh_price'],
                'stock'    => $val['lgf_stock'],
            ];
        }
        return $data;
    }

    
    public function limitBannerAction(){
        $id = $this->request->getIntParam('id');
        $act_model  = new App_Model_Limit_MysqlLimitActStorage($this->curr_sid);
        $row       = $act_model->getRowUpdateById($id);
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '限时活动', 'link' => '/wxapp/limit/index'),
            array('title' => '限时活动配置', 'link' => '#'),
        ));
        $this->output['row'] = $row;
        $this->displaySmarty('wxapp/limit/limit-banner.tpl');
    }

    
    public function saveLimitBannerAction(){
        $data = array();
        $data['la_bg_img']      = $this->request->getStrParam('bg');
        $data['la_bg_color']    = $this->request->getStrParam('color');
        $id   = $this->request->getIntParam('id');
        $act_model  = new App_Model_Limit_MysqlLimitActStorage($this->curr_sid);
        $row = $act_model->getRowUpdateById($id);
        if(!empty($row)){
            $ret = $act_model->getRowUpdateById($id,$data);
        }else{
            $ret = 0;
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("秒杀活动【{$row['la_name']}】背景图保存成功");
        }

        $this->showAjaxResult($ret);
    }

    
    public function delLimitAction(){
        $id   = $this->request->getIntParam('id');
        $act_model  = new App_Model_Limit_MysqlLimitActStorage($this->curr_sid);
        $row  = $act_model->getRowUpdateById($id);
        $set  = array('la_deleted'=>1);
        if(!empty($row)){
            $ret = $act_model->getRowUpdateById($id,$set);
        }else{
            $ret = 0;
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("秒杀活动【{$row['la_name']}】删除成功");
        }

        $this->showAjaxResult($ret,'删除');
    }

    
    public function activityAction(){
        $this->secondLink('activity');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '秒杀管理', 'link' => '/wxapp/limit/cfg'),
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

    public function orderAction(){
        $this->showTypeByKey('order_status');
        $where[] = array('name' => 't_applet_type', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_APPLET_SECKILL);

        $independent = $this->request->getIntParam('independent',0);
        if($independent){
            $where[] = ['name' => 't_independent_mall', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_APPLET_SECKILL];
        }

        $this->show_trade_list_data($where);
        if($independent == 1){
            $this->secondLink('order_independent');
        }else{
            $this->secondLink('order');
        }
        $this->output['independent'] = $independent;

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

        $this->displaySmarty('wxapp/limit/trade-list.tpl');
    }


    public function sequenceOrderAction(){
        $this->showTypeByKey('order_status');
        $where[] = array('name' => 't_applet_type', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_APPLET_SECKILL);
        $this->show_sequence_trade_list_data($where);
        $this->secondLink('order');
        $order_link = App_Helper_Trade::$trade_link_status;
        unset($order_link['tuan']);
        unset($order_link['hadpay']);
        unset($order_link['ship']);

        if(in_array($this->wxapp_cfg['ac_type'],[12,21,27])){
            $this->output['hasThree'] = 1;
        }
        $this->output['limit_trade'] = 1;
        $this->output['orderlink'] = $order_link;
        $this->output['todayTradeInfo'] = $this->_show_sequence_order_stat($where,true);
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '秒杀管理', 'link' => '#'),
            array('title' => '订单管理', 'link' => '#'),
        ));
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

    public function shopLimitAction() {
        $this->secondLink('shop');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '秒杀管理', 'link' => '/wxapp/limit/cfg'),
            array('title' => '店铺秒杀活动', 'link' => '#'),
        ));
        $this->full_list_data(1);

        $this->displaySmarty('wxapp/limit/shop-list.tpl');
    }

    public function changeShowAction(){
        $status = $this->request->getIntParam('status');
        $actid  = $this->request->getIntParam('actid');

        $act_model  = new App_Model_Limit_MysqlLimitActStorage($this->curr_sid);
        $set = array('la_index_show' => $status);
        $ret = $act_model->updateById($set, $actid);

        if($ret){
            $act = $act_model->getRowById($actid);
            $str = $status == 1 ? '显示' : '隐藏';
            App_Helper_OperateLog::saveOperateLog("修改秒杀活动【{$act['la_name']}】首页{$str}");
        }

        $this->showAjaxResult($ret);
    }

    
    public function saveLimitCfgAction(){
        $show   = $this->request->getIntParam('show');
        $title  = $this->request->getStrParam('title');
        $desc   = $this->request->getStrParam('desc');
        $logo   = $this->request->getStrParam('logo');
        $qrcode = $this->request->getStrParam('qrcode');

        $data['lc_s_id'] = $this->curr_sid;
        $data['lc_wxgroup_show']   = $show;
        $data['lc_wxgroup_title']  = $title;
        $data['lc_wxgroup_desc']   = $desc;
        $data['lc_wxgroup_logo']   = $logo;
        $data['lc_wxgroup_qrcode'] = $qrcode;
        $data['lc_update_time']    = time();

        $cfg_model = new App_Model_Limit_MysqlLimitCfgStorage($this->curr_sid);
        $limit_cfg = $cfg_model->fetchUpdateCfg();

        if($limit_cfg){
            $ret = $cfg_model->fetchUpdateCfg($data);
        }else{
            $ret = $cfg_model->insertValue($data);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("秒杀配置保存成功");
        }

        $this->showAjaxResult($ret);
    }
}