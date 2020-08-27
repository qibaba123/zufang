<?php

class App_Controller_Wxapp_CitymallController extends App_Controller_Wxapp_OrderCommonController {

    const PROMOTION_TOOL_KEY = 'sc';
    
    public function __construct(){
        parent::__construct();

        
    }
    
    public function secondLink($type='index',$returnInfo = false){
        $link = array(
            array(
                'label' => '主页管理',
                'link'  => '/wxapp/citymall/index',
                'active'=> 'index'
            ),
            array(
                'label' => '商家商品列表',
                'link'  => '/wxapp/citymall/goodsList',
                'active'=> 'goodsList'
            ),
            array(
                'label' => '商家商品分组',
                'link'  => '/wxapp/citymall/goodsGroup',
                'active'=> 'goodsGroup'
            ),
        );
        if($returnInfo){
            return array(
                'secondLink' => $link,
                'linkType'   => $type,
                'snTitle'    => '商城管理'
            );
        }else{
            $this->output['secondLink'] = $link;
            $this->output['linkType']   = $type;
            $this->output['snTitle']    = '商城管理';
        }

    }

    
    public function indexAction()
    {
        $this->secondLink('index');
        $this->showMallShopTpl();
        $this->showShopTplShortcut(-2);
        $this->showShopTplSlide(0, 8);
        $this->goodsGroup();
        $this->_shop_top_goods_list();
        $this->_curr_shop_goods_list();
        $this->_shop_list();
        $this->_get_list_for_select();
        $this->_shop_information();
        $this->_shop_category();
        $this->_city_shop_kind_list_for_select();
        $this->_curr_first_kind_list_for_select();
        $this->_curr_second_kind_list_for_select();
        $this->_recommend_goods_list(0);
        $this->_shop_mall_kind_list();
        $this->buildBreadcrumbs(array(
            array('title' => '商城管理', 'link' => '#'),
            array('title' => '主页管理', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/citymall/mall.tpl');


    }

    
    private function _shop_category(){
        $data = array();
        $shortcut_model = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
        $shortcut = $shortcut_model->fetchShortcutShowList(2);
        if($shortcut){
            foreach ($shortcut as $val){
                $data[] = array(
                    'id'   => $val['acc_id'],
                    'name' => $val['acc_title'],
                );
            }

        }
        $this->output['shopCategory'] = json_encode($data);
    }

    
    private function showMallShopTpl(){
        $tpl_model = new App_Model_Mall_MysqlMallUniversalStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid(0);
        if(empty($tpl)){
            $tpl = array(
                'amu_title'      => '店铺首页',
                'amu_recommend_open'  => 1
            );
        }
        $this->output['tpl'] = $tpl;
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

    
    private function _shop_top_goods_list(){
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $where = array();
        $where[]    = array('name' => 'g_es_id', 'oper' => '>', 'value' => 0);

        $goods_list = $goods_storage->fetchShopGoodsList($this->curr_sid,0,100,'',0,array(),array(),0,0,1,$where);
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

    
    private function _curr_shop_goods_list(){
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $where = array();
        $where[]    = array('name' => 'g_es_id', 'oper' => '=', 'value' => 0);

        $goods_list = $goods_storage->fetchShopGoodsList($this->curr_sid,0,100,'',0,array(),array(),0,0,1,$where);
        $data = array();
        if($goods_list){
            foreach ($goods_list as $val){
                $data[] = array(
                    'id'   => $val['g_id'],
                    'name' => $val['g_name'],
                );
            }
        }
        $this->output['currGoodsList'] = json_encode($data);
    }

    
    private function _shop_list(){
        $shop_storage = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        $sort  = array('acs_create_time' => 'DESC');
        $where = array();
        $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acs_deleted', 'oper' => '=', 'value' => 0);
        $shop    = $shop_storage->getList($where,0,0,$sort);
        $data = array();
        if($shop){
            foreach ($shop as $val){
                $data[] = array(
                    'id'        => $val['acs_id'],
                    'name'      => $val['acs_name'],
                );
            }
        }
        $this->output['shopList'] = json_encode($data);

    }

    private function _get_list_for_select($type = ''){
        $linkList = plum_parse_config('link','system');
        $linkType = plum_parse_config('link_type','system');
        $groupType = plum_parse_config('link_type_city','system');
        $link = $linkList[$this->wxapp_cfg['ac_type']];
        $mallType  = plum_parse_config('link_city_mall','system');
        $this->output['mallType'] = json_encode($mallType);
        unset($mallType[2]);

        $this->output['linkList'] = json_encode($link);
        $this->output['linkTypes'] = json_encode(array_merge($linkType,$groupType,$mallType));

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

    
    private function _city_shop_kind_list_for_select(){
        $es_model = new App_Model_Entershop_MysqlEnterShopStorage();
        $es_where[] = array('name' => 'es_s_id','oper' => '=','value' =>$this->curr_sid);
        $es_where[] = array('name' => 'es_status', 'oper' => '=', 'value' => 0);
        $es_where[] = array('name' => 'es_expire_time', 'oper' => '>', 'value' => time());
        $esList = $es_model->getList($es_where,0,0,array(),array('es_id'));
        $esIds = array();
        $data = array();
        if($esList){
            foreach ($esList as $val){
                $esIds[] = $val['es_id'];
            }
        }

        $category_model = new App_Model_Entershop_MysqlGoodsCategoryStorage(0);
        if(!empty($esIds)){
            $where[] = array('name' => 'esgc_s_id', 'oper' => 'in', 'value' => $esIds);
            $kind = $category_model->getListShopAction($where,0,0,array(),'city');

        }

        if($kind){
            foreach ($kind as $val){
                $data[] = array(
                    'id'   => $val['esgc_id'],
                    'name' => $val['esgc_name'].'  ('.$val['shopName'].')',
                    'esId' => $val['ecgc_s_id']
                );
            }
        }
        $this->output['kindSelect'] = json_encode($data);
    }

    
    private function _curr_first_kind_list_for_select(){
        $kind_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $list = $kind_model->getAllFirstCategory();
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'   => $val['sk_id'],
                    'name' => $val['sk_name']
                );
            }
        }
        $this->output['currFirstKindSelect'] = json_encode($data);

    }

    
    private function _curr_second_kind_list_for_select(){
        $kind_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $list = $kind_model->getAllSonCategory();
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'   => $val['sk_id'],
                    'name' => $val['sk_name']
                );
            }
        }
        $this->output['currSecondKindSelect'] = json_encode($data);
    }

    
    private function _recommend_goods_list($tpl){
        $recommend_model = new App_Model_City_MysqlCityMallRecommendStorage($this->curr_sid);
        $recommend_list = $recommend_model->fetchRecommendShowList();
        $data = array();
        if($recommend_list){
            foreach ($recommend_list as $val){
                $data[] = array(
                    'name'     => $val['acmr_name'],
                    'imgsrc'   => isset($val['acmr_img']) && $val['acmr_img'] ? $val['acmr_img'] :'',
                    'link'     => $val['acmr_link'],
                    'index'    => $val['acmr_weight'],
                    'linkType' => $val['acmr_link_type'],
                    'esId'     => $val['acmr_es_id']
                );
            }

        }else{
            for($i=0;$i<3;$i++){
                if($i == 0){
                    $data[] = array(
                        'name'     => '推荐',
                        'brief'    => '',
                        'imgsrc'   => '/public/manage/img/zhanwei/zw_fxb_350_425.png',
                        'link'     => 0,
                        'index'    => $i,
                        'linkType' => 27,
                        'esId'     => 0,
                    );
                }else{
                    $data[] = array(
                        'name'     => '推荐',
                        'brief'    => '',
                        'imgsrc'   => '/public/manage/img/zhanwei/zw_fxb_35_21.png',
                        'link'     => 0,
                        'index'    => $i,
                        'linkType' => 27,
                        'esId'     => 0,
                    );
                }

            }
        }
        $this->output['recommendGoods'] = json_encode($data);
    }

    
    private function _shop_mall_kind_list(){
        $kind_model = new App_Model_Mall_MysqlMallKindStorage($this->curr_sid);
        $kind_list = $kind_model->fetchKindShowList(0);
        $match_storage = new App_Model_Goods_MysqlGroupMatchStorage($this->curr_sid);
        $data = array();
        if($kind_list){
            foreach ($kind_list as $val){
                $data[] = array(
                    'title'     => $val['amk_name'],
                    'link'      => $val['amk_link'],
                    'index'     => $val['amk_weight'],
                    'imgsrc'    => $val['amk_img'],
                    'type'      => $val['amk_goods_list'],
                    'sign'      => $val['amk_sign'],
                );
            }
        }else{
            $data[] = array(
                'title'  => '标题',
                'link'   => 0,
                'index'  => 0,
                'type'   => 4,
                'sign'   => '新品上市 先买先得',
                'imgsrc' => '/public/manage/img/zhanwei/zw_fxb_750_180.png'
            );
        }
        $this->output['kindList'] = json_encode($data);
    }
    public function save_shop_shortcut_sortable($tpl_id){
        $shortcut = $this->request->getArrParam('shortcut');
        $shortcut_model = new App_Model_Shop_MysqlShopShortcutStorage($this->curr_sid);
        if(!empty($shortcut)){
            $shortcut_list = $shortcut_model->fetchShortcutShowList($tpl_id);
            if(!empty($shortcut_list)){
                $del_id = array();
                foreach($shortcut_list as $key => $val){
                    if(isset($shortcut[$key])){
                        $set = array(
                            'ss_weight' => $key,
                            'ss_name'   => $shortcut[$key]['title'],
                            'ss_icon'   => $shortcut[$key]['imgsrc'],
                            'ss_link_type' => $shortcut[$key]['type'],
                            'ss_link'      => $shortcut[$key]['link'],
                            'ss_article_title'   => $shortcut[$key]['articleTitle'],
                        );
                        $up_ret = $shortcut_model->updateById($set,$val['ss_id']);
                        unset($shortcut[$key]);
                    }else{
                        $del_id[] = $val['ss_id'];
                    }
                }
                if(!empty($del_id)){
                    $shortcut_where = array();
                    $shortcut_where[] = array('name' => 'ss_id','oper' => 'in' , 'value' => $del_id);
                    $shortcut_model->deleteValue($shortcut_where);
                }

            }
            if(!empty($shortcut)){
                $insert = array();
                foreach($shortcut as $key => $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}', {$tpl_id}, '{$val['title']}', '{$val['imgsrc']}', '{$val['link']}', '{$val['type']}','{$key}','{$val['articleTitle']}', '1','0', '".time()."') ";
                }
                $ins_ret = $shortcut_model->newInsertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'ss_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'ss_tpl_id','oper' => '=' , 'value' => $tpl_id);
            $shortcut_model->deleteValue($where);
        }
    }

    
    private function _save_mall_recommend($tpl_id){
        $recommend = $this->request->getArrParam('recommendGood');
        $recommend_model = new App_Model_City_MysqlCityMallRecommendStorage($this->curr_sid);
        if(!empty($recommend)){
            $recommend_list = $recommend_model->fetchRecommendShowList();
            if(!empty($recommend_list)){
                $del_id = array();
                foreach($recommend_list as $val){
                    if(isset($recommend[$val['amr_weight']])){
                        $set = array(
                            'acmr_weight' => $recommend[$val['acmr_weight']]['index'],
                            'acmr_img'    => $recommend[$val['acmr_weight']]['imgsrc'],
                            'acmr_link'   => $recommend[$val['acmr_weight']]['link'],
                            'acmr_link_type'   => $recommend[$val['acmr_weight']]['linkType'],
                        );
                        $up_ret = $recommend_model->updateById($set,$val['acmr_id']);
                        unset($recommend[$val['acmr_weight']]);
                    }else{
                        $del_id[] = $val['acmr_id'];
                    }
                }
                if(!empty($del_id)){
                    $recommend_where = array();
                    $recommend_where[] = array('name' => 'acmr_id','oper' => 'in' , 'value' => $del_id);
                    $recommend_model->deleteValue($recommend_where);
                }

            }
            if(!empty($recommend)){
                $insert = array();
                foreach($recommend as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}', '', '{$val['imgsrc']}', '{$val['link']}', '{$val['index']}','{$val['linkType']}','','".time()."') ";
                }
                $ins_ret = $recommend_model->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'acmr_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $recommend_model->deleteValue($where);
        }

    }

    
    private function _save_mall_shop_kind(){
        $kind = $this->request->getArrParam('kind');
        $kind_model = new App_Model_Mall_MysqlMallKindStorage($this->curr_sid);
        if(!empty($kind)){
            $kind_list = $kind_model->fetchKindShowList(0);
            if(!empty($kind_list)){
                $del_id = array();
                foreach($kind_list as $val){
                    if(isset($kind[$val['amr_weight']])){
                        $set = array(
                            'amk_weight'        => $kind[$val['amk_weight']]['index'],
                            'amk_name'          => $kind[$val['amk_weight']]['title'],
                            'amk_link'          => $kind[$val['amk_weight']]['link'],
                            'amk_img'           => $kind[$val['amk_weight']]['imgsrc'],
                            'amk_goods_list'    => 4,
                            'amk_sign'          => $kind[$val['amk_weight']]['sign'],
                        );
                        $up_ret = $kind_model->updateById($set,$val['amk_id']);
                        unset($kind[$val['amk_weight']]);
                    }else{
                        $del_id[] = $val['amk_id'];
                    }
                }
                if(!empty($del_id)){
                    $kind_where = array();
                    $kind_where[] = array('name' => 'amk_id','oper' => 'in' , 'value' => $del_id);
                    $kind_where[] = array('name' => 'amk_tpl_id','oper' => '=' , 'value' => 0);
                    $kind_model->deleteValue($kind_where);
                }

            }
            if(!empty($kind)){
                $insert = array();
                foreach($kind as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}', 0, '{$val['title']}', '{$val['imgsrc']}','{$val['link']}','{$val['sign']}','4', '{$val['index']}','".time()."') ";
                }
                $ins_ret = $kind_model->newInsertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'amk_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'amk_tpl_id','oper' => '=' , 'value' => 0);
            $kind_model->deleteValue($where);
        }

    }

    
    public function goodsGroupAction(){
        $this->secondLink('goodsGroup');
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $where      = array();
        $where[]    = array('name' => 'gg_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[]    = array('name' => 'gg_is_eshop','oper' => '=','value' =>1);
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
        $output['list'] = $list;
        $this->showOutput($output);
        $this->buildBreadcrumbs(array(
            array('title' => '商城管理', 'link' => '#'),
            array('title' => '店铺商品分组', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/citymall/shop-goods-group.tpl');
    }


    
    public function shopOrderAction() {
        $esId = $this->request->getIntParam('esId');
        $where[] = array('name' => 't_es_id', 'oper' => '=', 'value' => $esId);
        $this->show_trade_list_data($where);
        $this->output['print'] = plum_parse_config('type','print');
        $this->output['tradePay'] =  App_Helper_Trade::$trade_pay_type;
        $this->output['searchUrl'] = '/wxapp/citymall/shopOrder';
        $this->output['esId'] = $esId;
        $this->output['todayTradeInfo'] = $this->_show_order_stat($where,true);
        $this->buildBreadcrumbs(array(
            array('title' => '店铺门店管理', 'link' => '/wxapp/city/shopList'),
            array('title' => '订单列表', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/community/trade-list.tpl');
    }


    
    public function goodsListAction(){
        $this->secondLink('goodsList');
        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => '#'),
        ));
        $this->_show_goods_list_data();
        $this->_show_category();
        $this->output['choseLink']  = $link = array(
            array(
                'href'  => '/wxapp/citymall/goodsList?status=sell',
                'key'   => 'sell',
                'label' => '出售中'
            ),
            array(
                'href'  => '/wxapp/citymall/goodsList?status=depot',
                'key'   => 'depot',
                'label' => '已下架'
            ),
        );
        $level_model = new App_Model_Member_MysqlLevelStorage();
        $list = $level_model->getListBySid($this->curr_sid);
        $this->output['levelList'] = $list;

        $this->displaySmarty('wxapp/citymall/mall-goods-list.tpl');
    }


    
    private function _show_goods_list_data(){
        $where          = array();
        $where[]        = array('name' => 'g_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[]        = array('name' => 'g_es_id','oper' => '>','value' =>0);
        $output['name'] = $this->request->getStrParam('name');
        if($output['name']){
            $where[] = array('name' => 'g_name','oper' => 'like','value' =>"%{$output['name']}%");
        }
        $output['shop'] = $this->request->getStrParam('shop');
        if($output['shop']){
            $where[] = array('name' => 'es_name','oper' => 'like','value' =>"%{$output['shop']}%");
        }
        $output['cate'] = $this->request->getIntParam('cate');
        if($output['cate']){
            $where[] = array('name' => 'g_kind1','oper' => '=','value' =>$output['cate']);
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
        $total               = $goods_model->getShopGoodsCount($where);
        $pageCfg             = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        $list   = array();
        $deduct = array();
        if($index < $total){
            $sort = array('g_update_time' => 'DESC');
            $list = $goods_model->getShopGoodsList($where,$index,$this->count,$sort,'city');
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
        $output['list'] = $list;
        $where_total[] = $where_nosale[] = $where_sale[] = array('name' => 'g_s_id','oper' => '=','value' =>$this->curr_sid);
        $where_total[] = $where_nosale[] =  $where_sale[] = array('name' => 'g_es_id','oper' => '>','value' =>0);
        $where_total[] = $where_nosale[] =  $where_sale[] = array('name' => 'g_type','oper' => 'in','value' => array(1,2));
        $where_nosale[] = ['name' => 'g_is_sale','oper' => '=','value' => 2];
        $where_sale[] = ['name' => 'g_is_sale','oper' => '=','value' => 1];
        $totalCount = $goods_model->getCount($where_total);
        $nosaleCount = $goods_model->getCount($where_nosale);
        $saleCount = $goods_model->getCount($where_sale);
        $statInfo = [
            'total' => intval($totalCount),
            'sale'  => intval($saleCount),
            'nosale' => intval($nosaleCount)
        ];
        $output['statInfo'] = $statInfo;

        $this->showOutput($output);
    }

    
    private function _show_category(){
        $category_model = new App_Model_Entershop_MysqlGoodsCategoryStorage($this->curr_sid);
        $first          = $category_model->getListBySid();
        $category       = array();
        $kindSelect       = array();
        foreach($first as $val){
            $category[$val['esgc_id']] = $val['esgc_name'];
            $kindSelect[] = array(
                'id'   => $val['esgc_id'],
                'name' => $val['esgc_name']
            );
        }
        $this->output['category']   =$category ;
        $this->output['kindSelect']   = json_encode($kindSelect) ;
    }

    
    private function create_qrcode($id){
        $good_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);

        $row = $good_model->getRowById($id);
        $cover = $row['g_cover'] ? $row['g_cover'] : '';
        $str = "id=".$id;
        $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::CITY_SHOP_GOODS_DETAIL, 210 , $cover);
        $updata = array('g_qrcode'=>$url);
        $good_model->updateById($updata,$id);
        return $url;
    }

    
    public function editGoodsAction(){
        $goods_controller = new App_Controller_Wxapp_GoodsController();
        $goods_controller->newAddAction('group');
    }


}

