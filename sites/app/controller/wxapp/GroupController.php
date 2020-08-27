<?php

class App_Controller_Wxapp_GroupController extends App_Controller_Wxapp_InitController{

    const PROMOTION_TOOL_KEY    = 'wpt';

    private $application_status = null;

    public function __construct(){
        parent::__construct();

        $status = App_Helper_PluginIn::checkGroupBuyOpen($this->curr_sid);
        

        $this->application_status   = $status;
    }

    
    private function showIndexTpl(){
        $tpl_model = new App_Model_Group_MysqlGroupIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid();
        if(empty($tpl)){
            $tpl = array(
                'agi_title'         => '微拼团',
                'agi_member_open'   => 1
            );
        }
        $this->output['tpl'] = $tpl;
    }

    
    private function _show_goods_list(){
        if($this->wxapp_cfg['ac_type'] == 12){
            $goods = $this->group_list_data_course(true);
        }else{
            $goods = $this->group_list_data(true);
        }
        $data = array();
        foreach($goods as $val){
            $data[] = array(
                'id'       => $val['g_id'],
                'name'     => $val['g_name'],
                'cover'    => $val['gb_cover'],
                'price'    => $val['gb_price'],
                'oriprice' => $val['g_price'],
                'total'    => $val['gb_total'],
            );
        }
        $this->output['goods'] = json_encode($data);
    }


    
    public function secondLink($type='cfg',$returnInfo = false){
        $link = array(
            array(
                'label' => '拼团设置',
                'link'  => '/wxapp/group/cfg',
                'active'=> 'cfg'
            ),
            array(
                'label' => '拼团活动',
                'link'  => '/wxapp/group/index',
                'active'=> 'index'
            ),
            array(
                'label' => '活动分组',
                'link'  => '/wxapp/group/group',
                'active'=> 'group'
            ),
            array(
                'label' => '拼团订单',
                'link'  => '/wxapp/group/order',
                'active'=> 'order'
            ),
        );

        if($this->wxapp_cfg['ac_type'] == 27){
            unset($link[0]);
        }
        if(in_array($this->wxapp_cfg['ac_type'],[6,8])){
            $link[] = array(
                'label' => '营销活动申请',
                'link'  => '/wxapp/group/activity',
                'active'=> 'activity'
            );
            $link[] = array(
                'label' => '店铺活动列表',
                'link'  => '/wxapp/group/shopGroup',
                'active'=> 'shop'
            );
        }
        if(in_array($this->wxapp_cfg['ac_type'],[7])){
            $link[] = array(
                'label' => '商城拼团订单',
                'link'  => '/wxapp/group/order?independent=1',
                'active'=> 'order_independent'
            );
        }
        $sinTitle = '拼团购';
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
    
    public function cfgAction(){
        $this->secondLink('cfg');
        $cfg        = $this->wxapp_cfg;
        $this->output['shopType']    = $cfg['ac_type'];
        $this->showIndexTpl();
        $this->_show_goods_list();
        $this->showShopTplSlide(0, 3);
        $this->showShopTplShortcut(0);
        $this->goodsGroup();//分组
        $this->activityGroup();
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
            array('title' => '拼团管理', 'link' => '/wxapp/group/index'),
            array('title' => '拼团设置', 'link' => '#'),
        ));
        $this->output['sid'] = $this->curr_sid;

        $this->displaySmarty("wxapp/group/group-cfg.tpl");
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

    
    private function goodsGroup(){
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
        $this->output['goodsGroup'] = json_encode($data);
        $this->output['shopGoodsGroup'] = json_encode($shopData);
    }
    
    private function activityGroup(){
        $group_model    = new App_Model_Group_MysqlGroupStorage($this->curr_sid);
        $where[]=['name' => 'agg_s_id','oper' => '=','value' =>$this->curr_sid];
        $sort = array('agg_create_time' => 'DESC');
        $list = $group_model->getList($where,0,0,$sort);
        $data=[];
        foreach ($list as $val) {
           $data[] =[
                'id'   => $val['agg_id'],
                'name' => $val['agg_name']
            ];
        }
        $this->output['activityGroup'] = json_encode($data);
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
        $linkList = plum_parse_config('link','system');
        $linkType = plum_parse_config('link_type','system');
        $weedingType = plum_parse_config('link_type_group','system');
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
            unset($weedingType[4]);
            unset($weedingType[5]);
            unset($weedingType[6]);
        }
        $this->output['linkList'] = json_encode($link);
        $this->output['linkTypes'] = json_encode(array_merge($linkType,$weedingType));
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
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'   => $val['gg_id'],
                    'name' => $val['gg_name'],
                );
            }
        }
        $this->output['ordinaryGoodsGroup'] = json_encode($data);
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

    
    public function saveCfgAction(){
        $title      = $this->request->getStrParam('title');
        $listTitle  = $this->request->getStrParam('listTitle');
        $listType   = $this->request->getStrParam('listType');
        $isopen     = $this->request->getIntParam('isopen');
        $applyTitle = $this->request->getStrParam('applyTitle');
        $data = array(
            'agi_s_id'                => $this->curr_sid,
            'agi_title'               => $title,
            'agi_list_title'          => $listTitle,
            'agi_list_type'           => $listType,
            'agi_isopen'              => $isopen,
            'agi_update_time'        => time(),
            'agi_apply_title'        => $applyTitle
        );
        $tpl_model = new App_Model_Group_MysqlGroupIndexStorage($this->curr_sid);
        $tpl_row   = $tpl_model->findUpdateBySid();
        if(!empty($tpl_row)){
            $ret = $tpl_model->findUpdateBySid($data);
        }else{
            $tpl['agi_create_time']= time();
            $ret = $tpl_model->insertValue($data);
        }
        if($ret){
            $this->save_shop_slide(0, 3);//保存幻灯
            $this->save_shop_shortcut_new(0);//保存导航
            App_Helper_OperateLog::saveOperateLog("拼团首页模板配置保存成功");
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
        $where[]    = array('name' => 'agg_s_id','oper' => '=','value' =>$this->curr_sid);
        $output['name'] = $this->request->getStrParam('name');
        if($output['name']){
            $where[]    = array('name' => 'agg_name','oper' => 'like','value' =>"%{$output['name']}%");
        }

        $group_model    = new App_Model_Group_MysqlGroupStorage($this->curr_sid);
        $total          = $group_model->getCount($where);
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        $list   = array();
        $goods_model = new App_Model_Group_MysqlBuyStorage($this->curr_sid);
        if($index <= $total){
            $sort = array('agg_create_time' => 'DESC');
            $list = $group_model->getList($where,$index,$this->count,$sort);
            foreach($list as $key => &$val){
                $params = array(
                    'gpid' => $val['agg_id']
                );
                $list[$key]['agg_total'] = $goods_model->getCountGoods('look',$val['agg_id'],'');
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
        $this->output['goodsName'] = $goodsName;

        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '拼团管理', 'link' => '/wxapp/group/index'),
            array('title' => '活动分组', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/group/goods-group.tpl');
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
            $group_model    = new App_Model_Group_MysqlGroupStorage($this->curr_sid);
            if($id){
                $set = array(
                    'agg_name'       => $name,
                    'agg_list_type'  => $style,
                    'agg_brief'      => $brief,
                    'agg_bg'         => $img
                );
                $ret = $group_model->getRowUpdateByIdSid($id,$this->curr_sid,$set);
            }else{
                $data = array(
                    'agg_s_id'       => $this->curr_sid,
                    'agg_name'       => $name,
                    'agg_list_type'  => $style,
                    'agg_brief'      => $brief,
                    'agg_bg'         => $img,
                    'agg_create_time'=> time()
                );
                $ret = $group_model->insertValue($data);
            }
            if($ret){
                App_Helper_OperateLog::saveOperateLog("拼团分组【".$name."】保存成功");
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

        $goods_model = new App_Model_Group_MysqlBuyStorage($this->curr_sid);

        if($this->wxapp_cfg['ac_type'] == 12){
            $list        = $goods_model->getGroupCourseWithSection($type,$id,$index,$this->count,$keyword);
            $total       = $goods_model->getCountCourseWithSection($type,$id,$keyword);
        }else{
            $list        = $goods_model->getGroupGoodsWithSection($type,$id,$index,$this->count,$keyword);
            $total       = $goods_model->getCountGoodsWithSection($type,$id,$keyword);
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
        $where[]    = array('name' => 'agm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]    = array('name' => 'agm_g_id', 'oper' => '=', 'value' => $id);
        $where[]    = array('name' => 'agm_gg_id', 'oper' => '=', 'value' => $gg);
        $match_model = new App_Model_Group_MysqlGroupMatchStorage($this->curr_sid);
        $group_model = new App_Model_Group_MysqlGroupStorage($this->curr_sid);
        if($type == 'del'){
            $label = '移除';
            $ret   = $match_model->deleteValue($where);
            $group_model->changeTotalById($gg,2);
        }else{
            $row = $match_model->getRow($where);
            if(empty($row)){
                $data = array(
                    'agm_s_id'  => $this->curr_sid,
                    'agm_g_id'  => $id,
                    'agm_gg_id' => $gg,
                    'agm_create_time' => time()
                );
                $ret = $match_model->insertValue($data);
                $group_model->changeTotalById($gg);
            }else{
                $ret = true;
            }
            $label = '追加';
        }

        if($ret){
            $group = $group_model->getRowById($gg);
            App_Helper_OperateLog::saveOperateLog("拼团活动分组【{$group['agg_name']}】{$label}拼团活动成功");
        }

        $this->showAjaxResult($ret,$label);
    }

    
    public function changeWeightAction(){
        $id     = $this->request->getIntParam('id');
        $val    = $this->request->getIntParam('val');
        $set    = array(
            'agm_weight'      => $val,
            'agm_create_time' => time()
        );
        $match_model = new App_Model_Group_MysqlGroupMatchStorage($this->curr_sid);
        $ret = $match_model->getRowUpdateByIdSid($id,$this->curr_sid,$set);

        if($ret){
            App_Helper_OperateLog::saveOperateLog("修改分组拼团活动排序成功");
        }

        $this->showAjaxResult($ret);
    }

    
    public function indexAction() {
        $this->secondLink('index');
        $tpl_msg_model  = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
        $where[] = array('name' => 'awt_s_id','oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'awt_deleted','oper' => '=', 'value' => 0);
        $this->output['msg'] = $tpl_msg_model->getList($where,0,0);
        $this->output['groupType'] = plum_parse_config('group_type');
        $this->output['color']     = plum_parse_config('color','status');
        $this->output['yesNo']     = plum_parse_config('yesNo','status');
        $this->output['time']      = array('now' => $_SERVER['REQUEST_TIME'],'nextDay'=>$_SERVER['REQUEST_TIME']-24*3600);

        if($this->wxapp_cfg['ac_type'] == 12){
            $this->group_list_data_course();
        }else{
            $this->group_list_data();
        }
        $activity_model = new App_Model_Group_MysqlBuyStorage($this->curr_sid);
        $where_total = $where_going = $where_expire = [];
        $where_total[] = $where_going[] = $where_expire[] = ['name'=>'gb_s_id','oper'=>'=','value'=>$this->curr_sid];
        $where_going[] = ['name'=>'gb_start_time','oper'=>'<','value'=>$_SERVER['REQUEST_TIME']];
        $where_going[] = ['name'=>'gb_end_time','oper'=>'>','value'=>$_SERVER['REQUEST_TIME']];
        $where_expire[] = ['name'=>'gb_end_time','oper'=>'<','value'=>$_SERVER['REQUEST_TIME']];
        $total = $activity_model->getCount($where_total);
        $going = $activity_model->getCount($where_going);
        $expire = $activity_model->getCount($where_expire);
        $org_model = new App_Model_Group_MysqlOrgStorage($this->curr_sid);
        $where_success = $where_fail = [];
        $where_success[] = $where_fail[] = ['name'=>'go_s_id','oper'=>'=','value'=>$this->curr_sid];
        $where_success[] = ['name'=>'go_status','oper'=>'=','value'=>1];
        $where_fail[] = ['name'=>'go_status','oper'=>'=','value'=>2];
        $success = $org_model->getCount($where_success);
        $fail = $org_model->getCount($where_fail);
        $statInfo = [
            'total' => intval($total),
            'going' => intval($going),
            'expire' => intval($expire),
            'success' => intval($success),
            'fail' => intval($fail)
        ];
        $this->output['statInfo'] = $statInfo;

        if($this->wxapp_cfg['ac_type'] == 27){
            $this->output['groupPath'] = App_Plugin_Weixin_WxxcxClient::KNOWPAY_GROUP_CODE_PATH.'?id=';
        }else{
            $this->output['groupPath'] = App_Plugin_Weixin_WxxcxClient::GROUP_DETAIL_CODE_PATH.'?goodid=';
        }

        $this->output['appletCfg'] = $this->wxapp_cfg;

        $gcfg_model = new App_Model_Group_MysqlCfgStorage($this->curr_sid);
        $gcfg   = $gcfg_model->getRowUpdata();

        $this->output['groupCfg'] = $gcfg;
        $this->output['appletCfg'] = $this->wxapp_cfg;

        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '拼团管理', 'link' => '/wxapp/group/index'),
            array('title' => '拼团活动', 'link' => '#'),
        ));
        $this->output['app_status'] = $this->application_status;
        $this->displaySmarty("wxapp/group/group-list.tpl");
    }


    private function group_list_data($json=false, $isShop=false){
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $group_model  = new App_Model_Group_MysqlBuyStorage($this->curr_sid);
        $where      = array();
        $where[]    = array('name'=>'gb_s_id','oper'=>'=','value'=>$this->curr_sid);
        if($isShop){
            $where[]    = array('name'=>'gb_es_id','oper'=>'>','value'=>0);
        }else{
            $where[]    = array('name'=>'gb_es_id','oper'=>'=','value'=>0);
        }
        if($json){
            $where[]    = array('name' => 'gb_end_time', 'oper' => '>', 'value' => $_SERVER['REQUEST_TIME']);
        }
        $output['type'] = $this->request->getStrParam('type','all');
        if($output['type'] && $output['type'] != 'all'){
            $type = 0;
            if($output['type'] == 'ptpt'){
                $type = App_Helper_Group::GROUP_TYPE_PTPT;
            }elseif($output['type'] == 'cjt'){
                $type = App_Helper_Group::GROUP_TYPE_CJT;
            }elseif($output['type'] == 'tzyht'){
                $type = App_Helper_Group::GROUP_TYPE_TZYHT;
            }elseif($output['type'] == 'jtpt'){
                $type = App_Helper_Group::GROUP_TYPE_JTPT;
            }

            if($type>0){
                $where[] = array('name'=>'gb_type','oper'=>'=','value'=>$type);
            }
        }
        $total      = $group_model->getGoodsCountWithSection($where);
        $page_libs  = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $list       = array();
        if($index < $total){
            $sort = array('gb_sort'=>'DESC','gb_create_time' => 'DESC');
            $list = $group_model->getGoodsListWithSection($where,$index,$this->count,$sort);
            foreach($list as &$val){
                $param = array('gbid' => $val['gb_id']);
                $val['link'] = $this->composeLink('group','detail',$param,true);
            }
        }
        if($json){
            return $list;
        }
        $output['pageHtml'] = $page_libs->render();
        $output['list']     = $list;
        $this->showOutput($output);
    }

    private function group_list_data_course($json=false){
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $group_model  = new App_Model_Group_MysqlBuyStorage($this->curr_sid);
        $where      = array();
        $where[]    = array('name'=>'gb_s_id','oper'=>'=','value'=>$this->curr_sid);
        if($json){
            $where[]    = array('name' => 'gb_end_time', 'oper' => '>', 'value' => $_SERVER['REQUEST_TIME']);
        }
        $output['type'] = $this->request->getStrParam('type','all');
        if($output['type'] && $output['type'] != 'all'){
            $type = 0;
            if($output['type'] == 'ptpt'){
                $type = App_Helper_Group::GROUP_TYPE_PTPT;
            }elseif($output['type'] == 'cjt'){
                $type = App_Helper_Group::GROUP_TYPE_CJT;
            }elseif($output['type'] == 'tzyht'){
                $type = App_Helper_Group::GROUP_TYPE_TZYHT;
            }
            if($type>0){
                $where[] = array('name'=>'gb_type','oper'=>'=','value'=>$type);
            }
        }
        $total      = $group_model->getCourseCountWithSection($where);
        $page_libs  = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $list       = array();
        if($index < $total){
            $sort = array('gb_sort'=>'DESC','gb_create_time' => 'DESC');
            $list = $group_model->getCourseListWithSection($where,$index,$this->count,$sort);
            foreach($list as &$val){
                $val['g_name'] = $val['atc_title'];
                $val['g_price'] = $val['atc_price'];
                $val['g_cover'] = $val['atc_cover'];
                $param = array('gbid' => $val['gb_id']);
                $val['link'] = $this->composeLink('group','detail',$param,true);
            }
        }
        if($json){
            return $list;
        }
        $output['pageHtml'] = $page_libs->render();
        $output['list']     = $list;
        $this->showOutput($output);
    }

    
    private function get_ids_from_row($row,$field,$pre='',$suf=''){
        $ids = array();
        foreach($field as $val){
            if(isset($row[$pre.$val.$suf]) && $row[$pre.$val.$suf] > 0){
                $ids[] = $row[$pre.$val.$suf];
            }
        }
        return $ids;
    }

    
    public function addGroupAction() {
        $this->secondLink('index');
        $id     = $this->request->getIntParam('id');
        $row    = array();
        $isAdd  = 'add';
        if($id){
            $group_model  = new App_Model_Group_MysqlBuyStorage($this->curr_sid);
            $row = $group_model->getRowByIdSid($id,$this->curr_sid);
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            $goods = $goods_model->getRowById($row['gb_g_id']);
            $row['g_format'] = $this->_get_goods_format($goods['g_id'], $id);
            $this->output['goods'] = $goods;
            if(!empty($row) && ($row['gb_ptcg_msgid'] || $row['gb_ptsb_msgid'] || $row['gb_hdjs_msgid'])){
                $field = array('zfcg','ptcg','ptsb','hdjs');
                $ids = $this->get_ids_from_row($row,$field,'gb_','_msgid');

                $msg_model  = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->curr_sid);
                $msg        = $msg_model->getListByids($ids);
                foreach($field as $val){
                    $row[$val.'_title'] = $msg[$row['gb_'.$val.'_msgid']]['wt_title'];
                }
            }
            if(!empty($row)){
                $isAdd  = 'edit';
            }
        }
        if($this->wxapp_cfg['ac_type'] == 12){
            $this->_get_course_list();
        }else{
            $this->get_goods_list();
        }

        $this->output['row']    = $row;
        $this->output['isAdd']  = $isAdd;
        $groupType = plum_parse_config('group_type');
        if(!in_array($this->wxapp_cfg['ac_type'], array(4, 6, 7, 8, 12, 13, 18, 21))){
            unset($groupType[2]);
            unset($groupType[4]);
        }

        $this->output['now']    = date('Y-m-d',$_SERVER['REQUEST_TIME']);
        $this->output['yesNo']  = plum_parse_config('yesNo','status');
        $this->output['groupType'] = $groupType;
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '拼团活动', 'link' => '/wxapp/group/index'),
            array('title' => '添加拼团', 'link' => '#'),
        ));

        if($this->wxapp_cfg['ac_type'] == 27){
            $goodsName = '课程';
        }else{
            $goodsName = '商品';
        }
        $this->output['goodsName'] = $goodsName;
        $this->output['appletCfg'] = $this->wxapp_cfg;

        if($this->wxapp_cfg['ac_type'] == 21 || $this->wxapp_cfg['ac_type'] == 6 || $this->wxapp_cfg['ac_type'] == 8){
            $this->displaySmarty("wxapp/group/add-new.tpl");
        }else{
            $this->displaySmarty("wxapp/group/add.tpl");
        }
    }

    
    public function addSectionGroupAction() {
        $this->secondLink('index');

        $id     = $this->request->getIntParam('id');
        $row    = array();
        if($this->wxapp_cfg['ac_type'] == 12){
            $this->_get_course_list();
        }else{
            $this->get_goods_list();
        }
        $sectionPrice = array();
        $isAdd  = 1;
        if($id){
            $isAdd  = 0;
            $group_model  = new App_Model_Group_MysqlBuyStorage($this->curr_sid);
            $row = $group_model->getRowByIdSid($id,$this->curr_sid);
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            $goods = $goods_model->getRowById($row['gb_g_id']);
            $selectedGoodsFormat = json_encode($this->_get_goods_format($goods['g_id'], $id));
            $this->output['goods'] = $goods;
            $where = array();
            $where[] = array('name' => 'gb_gbs_id', 'oper' => '=', 'value' => $row['gb_gbs_id']);
            $groupList = $group_model->getList($where, 0, 0, array('gb_total' => 'ASC'));
            foreach ($groupList as $value){
                $sectionPrice[] = array(
                    'total' => intval($value['gb_total']),
                    'price' => floatval($value['gb_price']),
				    'format'=> $this->_get_goods_format($goods['g_id'], $value['gb_id'])
                );
            }
        }else{
            if($this->wxapp_cfg['ac_type'] == 12){
                $selectedGoodsFormat = json_encode(array());
            }else{
                $selectedGoodsFormat = $this->output['goodsList'][0]['g_format'];
            }
        }

        $this->output['selectedGoodsFormat'] = $selectedGoodsFormat;
        $this->output['row']    = $row;
        $this->output['isAdd']  = $isAdd;
        $this->output['sectionPrice'] = json_encode($sectionPrice);
        $this->output['appletCfg'] = $this->wxapp_cfg;

        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '拼团活动', 'link' => '/wxapp/group/index'),
            array('title' => '添加拼团', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/group/add-section-group.tpl");
    }

    
    public function saveSectionGroupAction(){
        $int  = array('g_id','show_num','use_auto','joined','sub_limit', 'limit');
        $data = $this->getIntByField($int,'gb_');
        $data['gb_type']        = 4;
        $data['gb_sort']        = $this->request->getIntParam('sort');
        $data['gb_cover']       = $this->request->getStrParam('cover');
        $data['gb_share_title'] = $this->request->getStrParam('share_title');
        $data['gb_share_desc']  = $this->request->getStrParam('share_desc');
        $data['gb_share_image'] = $this->request->getStrParam('share_image');
        $data['gb_act_rule']    = $this->request->getStrParam('activity_rule');
        $data['gb_update_time'] = $_SERVER['REQUEST_TIME'];
        $data['gb_use_auto']    = $data['gb_type'] == 1 ? $data['gb_use_auto'] : 0;
        $data['gb_single_buy']  = $this->request->getIntParam('single_buy');
        $data['gb_view_num']    = $this->request->getIntParam('viewNum');
        $data['gb_view_num_show'] = $this->request->getIntParam('viewNumShow');
        $sectionPrice           = json_decode($this->request->getStrParam('sectionPrice'), true);
        $group_model  = new App_Model_Group_MysqlBuyStorage($this->curr_sid);
        $id           = $this->request->getIntParam('id');

        $sectionId = 0;
        if(!$id){
            $section_model = new App_Model_Group_MysqlGroupSectionStorage($this->curr_sid);
            $sectionData = array(
                'gbs_s_id' => $this->curr_sid,
                'gbs_create_time' => $_SERVER['REQUEST_TIME']
            );
            $sectionId = $section_model->insertValue($sectionData);
        }

        if($id){
            unset($data['gb_g_id']);
            $group_model = new App_Model_Group_MysqlBuyStorage($this->curr_sid);
            $group = $group_model->getRowById($id);
            $where = array();
            $where[] = array('name'=>'gb_gbs_id','oper'=>'=','value'=>$group['gb_gbs_id']);
            $where[] = array('name'=>'gb_s_id','oper'=>'=','value'=>$this->curr_sid);
            $ret = $group_model->updateValue($data, $where);
        }else{
            foreach ($sectionPrice as $value){
                $str        = array('startTime','endTime');
                $tempDate   = $this->getStrByField($str);
                $start      = strtotime($tempDate['startTime']);
                $end        = strtotime($tempDate['endTime']);
                if(!($start < $end && $start > 0)){
                    $this->displayJsonError('请选择正确的开始时间和结束时间');
                }
                $data['gb_start_time']  = $start;
                $data['gb_end_time']    = $end;
                $data['gb_price']       = $value['price']?$value['price']:$value['format'][0]['price'];
                $data['gb_tz_price']    = 0;
                $data['gb_total']       = $value['total'];
                $data['gb_gbs_id']      = $sectionId;

                $data['gb_s_id']        = $this->curr_sid;
                $data['gb_create_time'] = $_SERVER['REQUEST_TIME'];
                $ret = $group_model->insertValue($data);
                $actId  = $ret;
                $this->_save_group_format($actId, $data['gb_g_id'], $value['format']);
                if($ret){
                    $group_redis_model = new App_Model_Group_RedisOrgStorage($this->curr_sid);
                    $group_redis_model->recordActEndTime($actId,$end);
                }
            }
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("阶梯拼团活动保存成功");
        }

        $this->showAjaxResult($ret,'保存');
    }



    private function get_goods_list(){
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $sort        = array('g_weight' => 'DESC','g_update_time'=>'DESC');
        $field       = array('g_id','g_name', 'g_price');
        $where[]     = array('name' => 'g_es_id', 'oper' => '=', 'value' => 0);
        $where[]     = array('name' => 'g_is_discuss', 'oper' => '=', 'value' => 0);
        if(!in_array($this->wxapp_cfg['ac_type'],[7])){//4697
            $where[]     = array('name' => 'g_independent_mall', 'oper' => '=', 'value' => 0);
        }

        if($this->wxapp_cfg['ac_type'] == 18){
            $where[]     = array('name' => 'g_kind1', 'oper' => '=', 'value' => 1);
        }
        $goods       = $goods_model->fetchShopGoodsList($this->curr_sid,0,0,'',0,$sort,$field, 0, 0, 1, $where);
        foreach ($goods as $key => $val){
            $goods[$key]['g_format'] = json_encode($this->_get_goods_format($val['g_id']));
        }
        $this->output['goodsList'] = $goods;
    }

    private function _get_goods_format($gid, $gbid=0){
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
        $where = array();
        $where[] = array('name' => 'gf_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'gf_g_id', 'oper' => '=', 'value' => $gid);
        if($gbid){
            $where[] = array('name' => 'gbf_gb_id', 'oper' => '=', 'value' => $gbid);
            $format         = $format_model->getFormatListAndGroupAction($where, 0, 0, array());
        }else{
            $format = $format_model->getList($where, 0, 0, array());
        }

        $data = array();
        foreach($format as $val){
            $data[] = [
                'id'       => $val['gbf_id'],
                'gfid'     => $val['gf_id'],
                'name'     => $val['gf_name'].($val['gf_name2']?('-'.$val['gf_name2']):'').($val['gf_name3']?('-'.$val['gf_name3']):''),
                'gfprice'  => floatval($val['gf_price']),
                'price'    => floatval($val['gbf_price']),
                'tzprice'  => floatval($val['gbf_tz_price'])
            ];
        }
        return $data;
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
    
    public function editGroupAction() {
        $this->secondLink('index');
        $id     = $this->request->getIntParam('id');
        $row    = array();
        $isAdd  = 'add';
        if($id){
            $group_model  = new App_Model_Group_MysqlBuyStorage($this->curr_sid);
            $row = $group_model->getRowByIdSid($id,$this->curr_sid);
            if(!empty($row) && ($row['gb_ptcg_msgid'] || $row['gb_ptsb_msgid'] || $row['gb_hdjs_msgid'])){
                $field = array('zfcg','ptcg','ptsb','hdjs');
                $ids = $this->get_ids_from_row($row,$field,'gb_','_msgid');

                $msg_model  = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->curr_sid);
                $msg        = $msg_model->getListByids($ids);
                foreach($field as $val){
                    $row[$val.'_title'] = $msg[$row['gb_'.$val.'_msgid']]['wt_title'];
                }
            }
            if(!empty($row)){
                $isAdd  = 'edit';
            }
        }
        if($this->wxapp_cfg['ac_type'] == 12){
            $this->_get_course_list();
        }else{
            $this->get_goods_list();
        }
        $this->output['row']    = $row;
        $this->output['isAdd']  = $isAdd;
        $groupType = plum_parse_config('group_type');
        unset($groupType[2]);

        $this->output['now']    = date('Y-m-d',$_SERVER['REQUEST_TIME']);
        $this->output['yesNo']  = plum_parse_config('yesNo','status');
        $this->output['groupType'] = $groupType;
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '拼团活动', 'link' => '/wxapp/group/index'),
            array('title' => '添加拼团', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/group/edit.tpl");
    }

    
    public function saveGroupAction(){
        $int  = array('type','g_id','total','show_num','use_auto','joined','sub_limit', 'limit');
        $data = $this->getIntByField($int,'gb_');
        $data['gb_sort']       = $this->request->getIntParam('sort');
        $data['gb_cover']       = $this->request->getStrParam('cover');
        $data['gb_share_title'] = $this->request->getStrParam('share_title');
        $data['gb_share_desc']  = $this->request->getStrParam('share_desc');
        $data['gb_share_image'] = $this->request->getStrParam('share_image');
        $data['gb_act_rule']    = $this->request->getStrParam('activity_rule');
        $data['gb_update_time'] = $_SERVER['REQUEST_TIME'];
        $data['gb_use_auto']    = $data['gb_type'] == 1 ? $data['gb_use_auto'] : 0;
        $data['gb_single_buy']  = $this->request->getIntParam('single_buy');
        $data['gb_view_num']    = $this->request->getIntParam('viewNum');
        $data['gb_view_num_show'] = $this->request->getIntParam('viewNumShow');

        $group_model  = new App_Model_Group_MysqlBuyStorage($this->curr_sid);
        $id           = $this->request->getIntParam('id');

        if($id){
            unset($data['gb_g_id']);
            unset($data['gb_total']);
            $ret = $group_model->getRowUpdateByIdSid($id,$this->curr_sid,$data);
        }else{
            $str        = array('startTime','endTime');
            $tempDate   = $this->getStrByField($str);
            $start      = strtotime($tempDate['startTime']);
            $end        = strtotime($tempDate['endTime']);
            if($this->wxapp_cfg['ac_type'] == 12){
                $course_model = new App_Model_Train_MysqlTrainCourseStorage($this->curr_sid);
                $course = $course_model->getRowByIdSid($data['gb_g_id'],$this->curr_sid);
                if(!is_numeric($course['atc_price']) || !floatval($course['atc_price'])){
                    $this->displayJsonError('课程价格不正确');
                }
            }
            if(!($start < $end && $start > 0)){
                $this->displayJsonError('请选择正确的开始时间和结束时间');
            }
            $data['gb_start_time']  = $start;
            $data['gb_end_time']    = $end;
            $data['gb_price']       = $this->request->getFloatParam('price');
            $tz_price               = $this->request->getFloatParam('tz_price');
            $data['gb_tz_price']    = $data['gb_type'] == 3 ? $tz_price : 0;

            $data['gb_s_id']        = $this->curr_sid;
            $data['gb_create_time'] = $_SERVER['REQUEST_TIME'];
            $ret = $group_model->insertValue($data);
            $id  = $ret;
            $this->_save_group_format($id, $data['gb_g_id']);
            
            if($ret){
                $group_redis_model = new App_Model_Group_RedisOrgStorage($this->curr_sid);
                $group_redis_model->recordActEndTime($id,$end);
            }
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("拼团活动保存成功");
        }

        $this->showAjaxResult($ret,'保存');
    }

    private function _save_group_format($gbId, $gid, $format=''){
        if(!$format){
            $format = $this->request->getArrParam('format');
        }
        $group_format_model  = new App_Model_Group_MysqlGroupGoodsFormatStorage($this->curr_sid);
        $group_format_model->deleteListByActidGid($gbId, $gid);
        $insert       = array();
        foreach($format as $val){
            $gfid     = intval($val['gfid'])?intval($val['gfid']):intval($val['id']);
            $price    = floatval($val['price']);
            $tzprice  = intval($val['tzprice']);
            $insert[] = "(null,{$this->curr_sid},{$gbId},{$gid},{$gfid},{$price},{$tzprice},{$_SERVER['REQUEST_TIME']})";
        }
        if(!empty($insert)){
            $group_format_model->insertBacth($insert);
        }
    }

    
    public function partakeAction(){
        $this->secondLink('index');
        $pid             = $this->request->getIntParam('pid');
        $group_model     = new App_Model_Group_MysqlBuyStorage($this->curr_sid);
        $gwhere          = array();
        $gwhere[]        = array('name'=>'gb_id' , 'oper' => '=' ,'value' => $pid);
        $gwhere[]        = array('name'=>'gb_s_id' , 'oper' => '=' ,'value' => $this->curr_sid);
        $group           = $group_model->getGoodsList($gwhere,0,1);
        if(!empty($group)){
            $output['group'] = $group[0];
            if($group[0]['gb_type'] == 2) {
                $luck_msg_model         = new App_Model_Group_MysqlGoodLuckStorage($this->curr_sid);
                $output['luckMsg']      = $luck_msg_model->fetchRowUpdateByGbId($pid);
            }

            $page       = $this->request->getIntParam('page');
            $index      = $page * $this->count;
            $where      = array();
            $where[]    = array('name'=>'go_s_id','oper'=>'=','value'=>$this->curr_sid);

            if($output['group']['gb_type'] == 4){
                $swhere = array();
                $swhere[] = array('name' => 'gb_gbs_id', 'oper' => '=', 'value' => $output['group']['gb_gbs_id']);
                $groupList = $group_model->getList($swhere, 0, 0, array('gb_total' => 'ASC'));
                $pidArr = [];
                foreach ($groupList as $value){
                    $pidArr[] = $value['gb_id'];
                }
                $where[]    = array('name'=>'go_gb_id','oper'=>'in','value'=>$pidArr);
            }else{
                $where[]    = array('name'=>'go_gb_id','oper'=>'=','value'=>$pid);
            }

            $org_model  = new App_Model_Group_MysqlOrgStorage($this->curr_sid);
            $total      = $org_model->getCount($where);
            $list       = array();
            if($total > $index){
                $list   = $org_model->getPartakeList($where,$index,$this->count);
            }
            $output['list']     = $list;
            $page_libs          = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
            $output['pageHtml'] = $page_libs->render();
            $output['groupType']= plum_parse_config('group_type');
            $output['canMsg']   = 1;
            $output['time']     = array(
                'nextDay'       => $_SERVER['REQUEST_TIME'] - 24*60*60
            );
            $tpl_msg_model  = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
            $where = array();
            $where[] = array('name' => 'awt_s_id','oper' => '=', 'value' => $this->curr_sid);
            $where[] = array('name' => 'awt_deleted','oper' => '=', 'value' => 0);
            $this->output['msg'] = $tpl_msg_model->getList($where,0,0);
            $this->showOutput($output);
            $this->buildBreadcrumbs(array(
                array('title' => '拼团活动', 'link' => '/wxapp/group/index'),
                array('title' => '活动参与情况', 'link' => '#'),
            ));
            $this->displaySmarty("wxapp/group/partake-list.tpl");
        }else{
            plum_url_location('该团购不存在');
        }
    }

    public function partyMemberAction(){
        $goid       = $this->request->getIntParam('goid');
        $gbid       = $this->request->getIntParam('gbid');
        $where      = array();
        $mem_model  = new App_Model_Group_MysqlMemStorage($this->curr_sid);
        $where[]    = array('name'=>'gm_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]    = array('name'=>'gm_is_robot','oper'=>'=','value'=>0);
        $list       = array();
        if($goid){
            $where[]= array('name'=>'gm_go_id','oper'=>'=','value'=>$goid);
            $list   = $mem_model->getMemList($where,0,0);
            $count  = 1;
        }elseif($gbid){
            $where[]= array('name'=>'gm_gb_id','oper'=>'=','value'=>$gbid);
            $where[]= array('name'=>'go_status','oper'=>'=','value'=>1);
            $list   = $mem_model->getMemOrgList($where,0,0);
            $count  = $mem_model->checkWinnerByGbid($gbid);

        }
        if(!empty($list)){
            $data       = array(
                'ec'    => 200,
                'data'  => $list,
                'count' => $count
            );
        }else{
            $data       = array(
                'ec'    => 400,
                'em'    => '未查到相关会员'
            );
        }
        $this->displayJson($data);
    }

    
    public function saveGoodsLuckAction(){
        $result     = array(
            'ec'    => 400,
            'em'    => '请选择中奖选手'
        );
        $gmids  = $this->request->getStrParam('gmids');
        $allmid = $this->request->getStrParam('allmid');
        $gbid   = $this->request->getIntParam('gbid');
        $ids    = explode(',',$gmids);
        $allids = explode(',',$allmid);
        if(!empty($ids) && $gbid){
            $where      = array();
            $mem_model  = new App_Model_Group_MysqlMemStorage($this->curr_sid);
            $count      = $mem_model->checkWinnerByGbid($gbid);
            if($count == 0){
                $where[]    = array('name'=>'gm_s_id','oper'=>'=','value'=>$this->curr_sid);
                $where[]    = array('name'=>'gm_is_robot','oper'=>'=','value'=>0);
                $where[]    = array('name'=>'gm_id','oper'=>'in','value'=>$ids);
                $set        = array('gm_is_winner' => 1);
                $ret        = $mem_model->updateValue($set,$where);
                if($ret){
                    $this->_refund_data($gbid, $ids);
                    $this->_deal_winner_trade($ids);
                    $this->_send_msg($gbid,$ids,$allids);

                    if($ret){
                        App_Helper_OperateLog::saveOperateLog("抽奖团中奖人保存成功");
                    }

                    $result     = $this->showAjaxResult($ret,'开奖',1);
                }
            }else{
                $result['em'] = '该活动已经开过奖';
            }
        }
        $this->displayJson($result);
    }
    private function _deal_winner_trade($ids){
        $mem_model  = new App_Model_Group_MysqlMemStorage($this->curr_sid);
        $where      = array();
        $where[]    = array('name'=>'gm_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]    = array('name'=>'gm_is_robot','oper'=>'=','value'=>0);
        $where[]    = array('name'=>'gm_id','oper'=>'in','value'=>$ids);
        $list       = $mem_model->fetchAllTradeList($where, 2, 1, 0, 0);
        $trade_helper   = new App_Helper_Trade($this->curr_sid);
        $updata         = array('t_status' => App_Helper_Trade::TRADE_HAD_PAY);

        $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        foreach ($list as $item) {
            $trade_helper->adjustTradeGoodsStock($item['t_id']);
            $trade_model->findUpdateTradeByTid($item['gm_tid'], $updata);
        }
    }

    private function _send_msg($gbid,$ids,$all){
        $luck_msg_model = new App_Model_Group_MysqlGoodLuckStorage($this->curr_sid);
        $row            = $luck_msg_model->fetchRowUpdateByGbId($gbid);

        $sendIds = array();
        switch($row['gc_push_type']){
            case 1:
                if(($row['gc_zjjg_msgid']) && !empty($ids)){
                    $sendIds = $ids;
                }
                break;
            case 2:
                break;
            case 3:
                if(($row['gc_zjjg_msgid']) && !empty($all)){
                    $sendIds = $all;
                }
                break;
        }
        plum_open_backend('templmsg', 'lotteryGroupTmplmsg', array('sid' => $this->curr_sid, 'sendIds' => rawurlencode(json_encode($sendIds)), 'gbid' => $gbid));
    }

    
    

    
    public function endAction(){
        $id  = $this->request->getIntParam('id');
        $group_model = new App_Model_Group_MysqlBuyStorage($this->curr_sid);
        $group = $group_model->getRowById($id);
        $set = array(
            'gb_end_time'    => $_SERVER['REQUEST_TIME'],
            'gb_update_time' => $_SERVER['REQUEST_TIME'],
        );
        $where       = array();
        $where[]     = array('name'=>'gb_end_time','oper'=>'>=','value'=>$_SERVER['REQUEST_TIME']);
        $where[]     = array('name'=>'gb_start_time','oper'=>'<=','value'=>$_SERVER['REQUEST_TIME']);
        if($group['gb_type'] != 4){
            $where[]     = array('name'=>'gb_id','oper'=>'=','value'=>$id);
        }else{
            $where[]     = array('name'=>'gb_gbs_id','oper'=>'=','value'=>$group['gb_gbs_id']);
        }
        $where[]     = array('name'=>'gb_s_id','oper'=>'=','value'=>$this->curr_sid);
        $ret         = $group_model->updateValue($set,$where);
        if($ret){
            $redis_model = new App_Model_Group_RedisOrgStorage($this->curr_sid);
            if($group['gb_type'] != 4){
                $redis_model->deleteActEndTime($id);
            }else{
                $list = $group_model->getList($where, 0, 0);
                foreach ($list as $value){
                    $redis_model->deleteActEndTime($value['gb_id']);
                }
            }
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("拼团活动终止成功");
        }

        $this->showAjaxResult($ret,'保存');
    }

    
    public function delGroupBuyAction(){
        $result     = array(
            'ec'    => 400,
            'em'    => '进行中的团购，不可删除'
        );
        $id          = $this->request->getIntParam('id');
        $group_model = new App_Model_Group_MysqlBuyStorage($this->curr_sid);
        $group       = $group_model->getRowUpdateByIdSid($id,$this->curr_sid);
        if($group && ($group['gb_start_time'] < $_SERVER['REQUEST_TIME'] || $group['gb_end_time'] > ($_SERVER['REQUEST_TIME'] + 86400))){
            $set    = array('gb_deleted' => 1);
            if($group['gb_type'] != 4){
                $ret    = $group_model->updateById($set,$group['gb_id']);
            }else{
                $where = array();
                $where[] = array('name'=>'gb_gbs_id','oper'=>'=','value'=>$group['gb_gbs_id']);
                $where[] = array('name'=>'gb_s_id','oper'=>'=','value'=>$this->curr_sid);
                $ret     = $group_model->updateValue($set, $where);
            }
            if($ret && $group['gb_start_time'] < $_SERVER['REQUEST_TIME']){
                $redis_model = new App_Model_Group_RedisOrgStorage($this->curr_sid);
                if($group['gb_type'] != 4){
                    $redis_model->deleteActEndTime($id);
                }else{
                    $list = $group_model->getList($where, 0, 0);
                    foreach ($list as $value){
                        $redis_model->deleteActEndTime($value['gb_id']);
                    }
                }
            }
            if($ret){
                App_Helper_OperateLog::saveOperateLog("拼团活动删除成功");
            }

            $result     = $this->showAjaxResult($ret,'删除',1);
        }
        $this->displayJson($result);
    }

    public function lookLuckAction(){
        $acid   = $this->request->getIntParam('acid');
        $page   = $this->request->getIntParam('page');
        $index  = $page * $this->count;
        $sort   = array('go_create_time'=>'DESC');
        $where  = array();
        $where[]= array('name'=>'go_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]= array('name'=>'go_gb_id','oper'=>'=','value'=>$acid);
        $where[]= array('name'=>'go_status','oper'=>'=','value'=>1);
        $org_model  = new App_Model_Group_MysqlOrgStorage($this->curr_sid);
        $orgList    = $org_model->getList($where,$index,$this->count,$sort,array(),true);
        if(!empty($orgList)){
            $go_id_arr  = array_keys($orgList);
            $mwhere     = array();
            $mwhere[]   = array('name'=>'gm_s_id','oper'=>'=','value'=>$this->curr_sid);
            $mwhere[]   = array('name'=>'gm_gb_id','oper'=>'=','value'=>$acid);
            $mwhere[]   = array('name'=>'gm_go_id','oper'=>'in','value'=>$go_id_arr);
            $mwhere[]   = array('name'=>'gm_is_robot','oper'=>'!=','value'=>1);

            $mem_model  = new App_Model_Group_MysqlMemStorage($this->curr_sid);
            $memList    =$mem_model->getMemList($mwhere,0,0);
            foreach($memList as $val){
                $orgList[$val['gm_go_id']]['mem'][] = array(
                    'id'        => $val['gm_id'],
                    'mid'       => $val['m_id'],
                    'nickname'  => $val['m_nickname'],
                    'istz'      => $val['gm_is_tz'],
                );
            }
            $this->displayJsonSuccess(array_values($orgList));
        }else{
            $this->displayJsonError('无人参与');
        }
    }

    
    public function luckMsgAction(){
        $field = array('gb_id','refund_type','push_type','zjjg','zjjg_nwid');
        $keys  = array('tktz','zjjg','lqtz');
        foreach($keys as $v){
            $field[] = $v.'_msgid';
            $field[] = $v.'_nwid';
        }
        $data  = $this->getIntByField($field,'gc_');
        $data['gc_create_time'] = $_SERVER['REQUEST_TIME'];
        $luck_msg_model         = new App_Model_Group_MysqlGoodLuckStorage($this->curr_sid);
        $row                    = $luck_msg_model->fetchRowUpdateByGbId($data['gc_gb_id']);
        if($row){
            $ret  = $luck_msg_model->fetchRowUpdateByGbId($data['gc_gb_id'],$data);
        }else{
            $data['gc_s_id'] = $this->curr_sid;
            $ret  = $luck_msg_model->insertValue($data);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("拼团活动开奖模板消息保存成功");
        }

        $this->showAjaxResult($ret,'保存');
    }

    
    private function _refund_data($gbid, $winIds){
        $where      = array();
        $mem_model  = new App_Model_Group_MysqlMemStorage($this->curr_sid);
        $where[]    = array('name'=>'gm_s_id','oper'=>'=','value'=> $this->curr_sid);
        $where[]    = array('name'=>'gm_gb_id','oper'=>'=','value'=> $gbid);
        $where[]    = array('name'=>'gm_id','oper'=>'not in','value'=> $winIds);
        $where[]    = array('name'=>'go_status','oper'=>'=','value'=> 1);
        $where[]    = array('name'=>'gm_is_robot','oper'=>'=','value'=> 0);
        $list       = $mem_model->getMemOrgList($where,0,0);
        $tradeHelper = new App_Helper_Trade($this->curr_sid);
        $ids         = array();
        $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $refundTids = array();
        foreach($list as $val){
            $trade      = $trade_model->findUpdateTradeByTid($val['gm_tid']);
            $refund_model   = new App_Model_Trade_MysqlTradeRefundStorage($this->curr_sid);
            $indata     = array(
                'tr_s_id'       => $this->curr_sid,
                'tr_wid'        => App_Plugin_Weixin_PayPlugin::makeMchOrderid('W'),
                'tr_tid'        => $val['gm_tid'],
                'tr_reason'     => '未中奖,系统自动退款',//退款原因
                'tr_money'      => $trade['t_total_fee'],
                'tr_create_time'=> time(),//退款编号创建时间
                'tr_status'     => 0,//退款处理中
            );
            $rfid = $refund_model->insertValue($indata);
            $ret = $tradeHelper->appletDealRefund($val['gm_tid'],'tid');
            if (!$ret['errcode']) {
                $ids[] = $val['gm_id'];
                $refund_model->updateById(array('tr_status' => 1, 'tr_finish_time' => time()), $rfid);
                $refundTids[] = $trade['t_tid'];
            }
        }
        plum_open_backend('templmsg', 'lotteryRefundTempl', array('sid' => $this->curr_sid, 'gbid' => $gbid, 'refundTids' => rawurlencode(json_encode($refundTids))));
        if(!empty($ids)){
            $mem_model->updateHadRefund($ids);
        }
    }

    
    private function _show_order_stat($where,$today = true,$gtype = 0, $type = -1){
        if($today){
            $time = strtotime(date('Y-m-d',time()));
            $where[] = array('name'=>'t_create_time','oper'=>'>=','value'=>$time);
        }

        $where[] = array('name'=>'t_status','oper'=>'in','value'=>array(3,4,5,6,10));
        $order_model = new App_Model_Group_MysqlMemStorage($this->curr_sid);
        return $order_model->statOrderStatistic($where,$gtype,$type);
    }

    
    public function orderAction(){

        $independent = $this->request->getIntParam('independent',0);
        if($independent == 1){
            $this->secondLink('order_independent');
        }else{
            $this->secondLink('order');
        }
        $this->output['independent'] = $independent;
        $this->show_trade_list_data([],1,$independent);
        $this->output['tradePay'] =  App_Helper_Trade::$trade_pay_type;
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '拼团管理', 'link' => '/wxapp/group/index'),
            array('title' => '拼团订单', 'link' => '#'),
        ));
        $this->output['todayTradeInfo'] = $this->_show_order_stat(array(),true);

        if($this->wxapp_cfg['ac_type'] == 27){
            $goodsName = '课程';
        }else{
            $goodsName = '商品';
        }
        $this->output['goodsName'] = $goodsName;

        $this->displaySmarty('wxapp/group/group-trade-list.tpl');
    }

    private function show_trade_list_data($where= array(),$needExpress=1,$independent = 0){
        $independent = $independent == 1 ? 1 : 0;
        $link = App_Helper_Group::$group_trade_status;
        $this->output['linkList'] = $link;
        $tradeStatus = plum_parse_config('group_trade_status');
        if($this->wxapp_cfg['ac_type'] == 4 || $this->wxapp_cfg['ac_type'] == 18){
            $tradeStatus[3] = '已付款';
        }
        $this->output['statusNote'] = $tradeStatus;
        $output['status'] = $this->request->getStrParam('status','all');
        if(in_array($output['status'],array('all','success')) && $needExpress){
            $express_model  = new App_Model_Trade_MysqlExpressStorage();
            $express = $express_model->getExpressList(1);
        }else{
            $express = array();
        }
        $this->output['express'] = $express;

        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;

        $where[]    = array('name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]    = array('name'=>'t_status','oper'=>'>','value'=>0);
        $where[]    = array('name'=>'t_independent_mall','oper'=>'=','value'=>$independent);
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
            $where[]= array('name'=>'ma_name','oper'=>'like','value'=>"%{$output['harvest']}%");
        }
        $output['phone']  = $this->request->getStrParam('phone');
        if($output['phone']){
            $where[]= array('name'=>'ma_phone','oper'=>'=','value'=>$output['phone']);
        }
        $output['start']   = $this->request->getStrParam('start');
        if($output['start']){
            $where[]    = array('name' => 't_create_time', 'oper' => '>=', 'value' => strtotime($output['start']));
        }
        $output['end']     = $this->request->getStrParam('end');
        if($output['end']){
            $where[]    = array('name' => 't_create_time', 'oper' => '<=', 'value' => (strtotime($output['end']) + 86400));
        }
        $output['gtype']  = $this->request->getStrParam('gtype','pt');
        if($output['gtype']=='cj'){
            $gtype = 2;
        }elseif($output['gtype']=='md'){
            $gtype = 3;
        }elseif($output['gtype']=='jt'){
            $gtype = 4;
        }else{
            $gtype = 1;
        }
        if($output['status'] && isset($link[$output['status']]) && $link[$output['status']]['id'] >= 0){
            $type = $link[$output['status']]['id'];
        }else{
            $type = -1;
        }
        $output['searchTradeInfo'] = $this->_show_order_stat($where,FALSE,$gtype,$type);
        $mem_model      = new App_Model_Group_MysqlMemStorage($this->curr_sid);
        $total       = $mem_model->fetchAllTradeCount($where,$gtype,$type);
        $page_lib    = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['page_html'] = $page_lib->render();
        $list     = array();
        $trader   = array();
        if($total > $index){
            $list = $mem_model->fetchAllTradeList($where,$gtype,$type,$index,$this->count);
            $ids  = array();
            foreach($list as $val){
                $ids[] = $val['t_id'];
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
        $output['list']   = $list;
        $this->showOutput($output);
    }


    
    public function categoryAction(){
        $this->secondLink('category');
        $category = $this->goods_category_son_data();
        $this->renderCropTool('/wxapp/index/uploadImg');
         $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '拼团管理', 'link' => '/wxapp/group/index'),
            array('title' => '拼团课程分类', 'link' => '#'),
        ));
        $this->output['cateLink'] = $this->composeLink('shop','accordion',array(),true,'none');
        $this->output['category'] = json_encode($category);
        $this->displaySmarty('wxapp/group/group-train-category-new.tpl');
    }


    
    private function goods_category_son_data($isJson=1){
        $category_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $first          = $category_model->getListBySid();
        $temp           = array();
        foreach($first as $val){
            if($val['sk_level'] == 1){
                $temp[$val['sk_id']] = array(
                    'id'        => $val['sk_id'],
                    'index'     => $val['sk_weight'],
                    'firstName' => $val['sk_name'],
                    'secondItem'=> array(),
                );
            }elseif($val['sk_fid'] > 0 && $val['sk_level'] == 2){
                $temp[$val['sk_fid']]['secondItem'][] = array(
                    'id'         => $val['sk_id'],
                    'index'      => $val['sk_weight'],
                    'secondName' => $val['sk_name'],
                    'imgSrc'     => $val['sk_logo'],
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

    
    public function newAddAction(){
        $this->secondLink('goods');
        $id  = $this->request->getIntParam('id');
        $row = array(); $slide = array();
        if($id){
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            $row = $goods_model->getRowByIdSid($id,$this->curr_sid);
            if(!empty($row)){
                $slide_model    = new App_Model_Goods_MysqlGoodsSlideStorage($this->curr_sid);
                $slide          = $slide_model->getSlideByGid($row['g_id']);
            }
        }
        $this->output['row']    = $row;
        $this->output['slide']  =  $slide;
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '拼团管理', 'link' => '/wxapp/group/index'),
            array('title' => '拼团课程管理', 'link' => '/wxapp/group/goodsList'),
            array('title' => '添加/编辑拼团课程', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/group/group-train-add.tpl');
    }

    public function goodsListAction() {
        $this->secondLink('goods');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '拼团管理', 'link' => '/wxapp/group/index'),
            array('title' => '拼团课程管理', 'link' => '#'),
        ));
        $this->_show_goods_list_data();
        $this->_show_category_type(0);
        $table_menu = new App_Helper_TableMenu();
        $import = null;
        $plugin_helper  = new App_Helper_PluginIn();
        $code   = $plugin_helper->checkShopThreeOpen($this->curr_sid);
        $point  = $plugin_helper->checkShopPointOpen($this->curr_sid);
        $this->output['threeSale']  = $code['code'] == 0 ? $code['level'] : 0;
        $this->output['openPoint']  = $point['code'] == 0 ? 1 : 0;
        $this->output['integral']   = plum_parse_config('integralReturn');

        $this->output['import']     = $import;
        $this->output['choseLink']  = $table_menu->showTableLink('trainGoods');
        $this->output['threeSale']  = App_Helper_ShopWeixin::checkShopThreeLevel($this->curr_sid);

        $this->output['platform']  = $this->request->getStrParam('platform');//判断是否是试衣间 clothes
        $this->output['clothes']   = $this->curr_shop['s_clothes_status'];
        $this->displaySmarty("wxapp/group/group-train-list.tpl");
    }

    private function _show_goods_list_data(){
        $where = array();
        $where[] = array('name' => 'g_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[]        = array('name' => 'g_type','oper' => 'in','value' => array(1,2));
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
        }

        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $total = $goods_model->getCount($where);
        $pageCfg = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        $list   = array();
        $deduct = array();
        if($index <= $total){
            $sort = array('g_update_time' => 'DESC');
            $list = $goods_model->getList($where,$index,$this->count,$sort);
            $deduct_gids = array();
            foreach($list as $key=>$val){
                $deduct_gids[] = $val['g_id'];
                $param = array(
                    'gid' => $val['g_id']
                );
                $val['link'] = $this->composeLink('shop','detail',$param);
                if(!$val['g_qrcode']){
                    $list[$key]['g_qrcode']=$this->create_qrcode($val['g_id']);
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
        $output['list'] = $list;
        $output['deduct'] = $deduct;
        $this->showOutput($output);
    }

    
    private function _show_category_type($is_add=1){

        $category_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $temp          = $category_model->getAllSonCategory();
        $category = array();
        foreach($temp as $val){
            $category[$val['sk_id']] = $val['sk_name'];
        }
        $this->output['category']   =$category ;
        $this->output['type']       = plum_parse_config('goodsType');
    }


    
    public function activityAction(){
        $this->secondLink('activity');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '拼团管理', 'link' => '/wxapp/group/index'),
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
                $order_controller->tradeDetailAction('group');
                break;
            case 7:
                $order_controller = new App_Controller_Wxapp_HotelController();
                $order_controller->tradeDetailAction('group');
                break;
            default:
                $order_controller = new App_Controller_Wxapp_OrderController();
                $order_controller->tradeDetailAction('group');
        }

    }



    
    public function groupSynchronAction(){
        $res = array(
            'ec' => 400,
            'em' => '处理失败'
        );
        $goId = $this->request->getIntParam('goid');
        if($goId){
            $group_help = new App_Helper_Group($this->curr_sid);
            $ret = $group_help->groupOrgOvertime($goId);
            if($ret){
                $res = array(
                    'ec' => 200,
                    'em' => '处理成功'
                );
                App_Helper_OperateLog::saveOperateLog("拼团订单状态同步成功");
            }
        }
        $this->displayJson($res);
    }

    public function shopGroupAction() {
        $this->secondLink('shop');
        $tpl_msg_model  = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
        $where[] = array('name' => 'awt_s_id','oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'awt_deleted','oper' => '=', 'value' => 0);
        $this->output['msg'] = $tpl_msg_model->getList($where,0,0);
        $this->output['groupType'] = plum_parse_config('group_type');
        $this->output['color']     = plum_parse_config('color','status');
        $this->output['yesNo']     = plum_parse_config('yesNo','status');
        $this->output['time']      = array('now' => $_SERVER['REQUEST_TIME'],'nextDay'=>$_SERVER['REQUEST_TIME']-24*86400);

        if($this->wxapp_cfg['ac_type'] == 12){
            $this->group_list_data_course();
        }else{
            $this->group_list_data(false, 1);
        }

        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '拼团管理', 'link' => '/wxapp/group/index'),
            array('title' => '店铺拼团活动', 'link' => '#'),
        ));
        $this->output['app_status'] = $this->application_status;
        $this->displaySmarty("wxapp/group/shop-group-list.tpl");
    }

    public function changeShowAction(){
        $status = $this->request->getIntParam('status');
        $actid  = $this->request->getIntParam('actid');

        $act_model  = new App_Model_Group_MysqlBuyStorage($this->curr_sid);
        $set = array('gb_index_show' => $status);
        $ret = $act_model->updateById($set, $actid);
        $this->showAjaxResult($ret);
    }

    
    public function saveGroupCfgAction(){
        $show   = $this->request->getIntParam('show');
        $title  = $this->request->getStrParam('title');
        $desc   = $this->request->getStrParam('desc');
        $logo   = $this->request->getStrParam('logo');
        $qrcode = $this->request->getStrParam('qrcode');

        $data['gc_s_id'] = $this->curr_sid;
        $data['gc_wxgroup_show']   = $show;
        $data['gc_wxgroup_title']  = $title;
        $data['gc_wxgroup_desc']   = $desc;
        $data['gc_wxgroup_logo']   = $logo;
        $data['gc_wxgroup_qrcode'] = $qrcode;
        $data['gc_update_time']    = time();

        $gcfg_model = new App_Model_Group_MysqlCfgStorage($this->curr_sid);
        $gcfg   = $gcfg_model->getRowUpdata();

        if($gcfg){
            $ret = $gcfg_model->getRowUpdata($data);
        }else{
            $ret = $gcfg_model->insertValue($data);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("拼团设置保存成功");
        }

        $this->showAjaxResult($ret);
    }

}