<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/5/19
 * Time: 下午2:34
 * 小程序相关配置
 */
class App_Controller_Wxapp_MallController extends App_Controller_Wxapp_InitController{

    public function __construct(){
        parent::__construct();
    }


    /**
     * 小程序首页模板
     */
    public function mallTemplateAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '店铺管理', 'link' => '#'),
            array('title' => '小程序首页模板', 'link' => '#'),
        ));
        $cfg = plum_parse_config('category','applet');
        $tpl_ids = $cfg[21]['tpl'];
        $tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $list       = $tpl_model->getListByTidSidType($tpl_ids,$this->curr_sid,3);
        $row        = array();
        foreach($list as $val){
            if(empty($row) && $val['it_id'] == $this->wxapp_cfg['ac_index_tpl']){
                $row = $val;
                break;
            }
        }
        $this->output['cfg']  = $this->wxapp_cfg;
        $this->output['list'] = $list;
        $this->output['shop'] = $this->shops[$this->curr_sid];
        $this->output['row']  = $row;
        $this->displaySmarty('wxapp/mall/mall-template.tpl');
    }

    /*
     * 店铺首页模板设置
     */
    public function fixtureAction()
    {
        $tpl_id = $this->request->getIntParam('tpl', 3);
        $tpl_model = new App_Model_Shop_MysqlIndexTplStorage();
        $row = $tpl_model->getRowBySid($tpl_id, $this->curr_sid);
        $this->output['shop'] = $this->shops[$this->curr_sid];
        if ($row) {
            $this->showShopTpl($tpl_id);
            $this->showShortcut($tpl_id);
            $this->showSlide($tpl_id);
            $this->goodsGroup();
            $page = $this->_fetch_shop_outside();
            $page_data = $this->_fetch_page_data();
            $this->output['page_list'] = json_encode(array_merge($page,$page_data));
            $this->_fetch_page_data();//菜单
            // 店铺选择推荐商品
            $this->_shop_top_goods_list();
            // 店铺选择推荐商品
            $this->_shop_appointment_goods_list();
            // 店铺推荐商品展示
            $this->_recommend_goods_list($tpl_id);
            //店铺的所有一级,二级分类
            $this->_shop_kind_list_for_select();
            // 店铺分类展示
            $this->_shop_kind_list($tpl_id);
            // 链接列表及分类
            $this->_get_list_for_select();
            $this->_group_list_for_select(); //获取拼团商品列表
            $this->_limit_list_for_select(); //获取秒杀商品列表
            $this->_bargain_list_for_select(); //获取砍价商品列表
            //获取文章列表
            $this->_shop_information();
            //获取文章资讯分类
            $this->_get_information_category();
            //获得跳转小程序
            $this->_get_jump_list();
            $this->renderCropTool('/wxapp/index/uploadImg');
            $this->buildBreadcrumbs(array(
                array('title' => '店铺主页', 'link' => '/wxapp/mall/mallTemplate'),
                array('title' => '首页模版', 'link' => '#'),
            ));
            if($tpl_id == 48){
                $this->_kind_one_get_select();
            }
            $this->displaySmarty('wxapp/mall/index-tpl_' . $tpl_id . '.tpl');
        } else {
            plum_url_location('模版不存在');
        }
    }

    /**
     * 拼团商品列表
     *
     */
    private function _group_list_for_select(){
        $group_model    = new App_Model_Group_MysqlBuyStorage($this->curr_sid);

        $list    = $group_model->getCurrentList(0,0,array());
        $data = array();
        foreach($list as $val){
            $data[] = array(
                'id'    => $val['gb_id'],
                'name'  => $val['g_name'],
            );
        }
        $this->output['groupList'] = json_encode($data);
    }

    /**
     * 秒杀商品列表
     *
     */
    private function _limit_list_for_select(){
        $limit_model = new App_Model_Limit_MysqlLimitActStorage($this->curr_sid);
        $list    = $limit_model->getAllRunningNotBeginActGoods(array(),0,0);
        $data = array();
        foreach($list as $val){
            $data[]= array(
                'id'    => $val['g_id'],
                'name'  => $val['g_name'],
            );
        }
        $this->output['limitList'] = json_encode($data);
    }

    /**
     * 砍价商品列表
     *
     */
    private function _bargain_list_for_select(){
        $where = array();
        $where[]    = array('name'=>'ba_s_id','oper'=>'=','value'=>$this->curr_sid);

        $where[]  = array('name'=>'ba_deleted','oper'=>'=','value'=>0);
        $where[]  = array('name'=>'ba_end_time','oper'=>'>','value'=>time());
        $sort = array('ba_status'=>'ASC','ba_create_time' => 'DESC');
        $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($this->curr_sid);
        $list = $bargain_model->getActivityList($where,0,0,$sort);
        $data = array();
        foreach($list as $val){
            $data[]= array(
                'id'    => $val['ba_id'],
                'name'  => $val['g_name'],
            );
        }
        $this->output['bargainList'] = json_encode($data);
    }
    /**
     * 获取一级分类-48号模板使用
     */
    private function _kind_one_get_select() {
        $kind_model     = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $kind1      = $kind_model->getFirstCategory(0, 50);//获取最多50个一级分类
        if($kind1){
            foreach ($kind1 as $val){
                $secondKind = $this->_get_son_select_by_fid($val['sk_id']);
                $goods      = $this->_get_goods_by_kind1($val['sk_id']);
                $data[] = array(
                    'id'   => $val['sk_id'],
                    'name' => $val['sk_name'],
                    'second' => $secondKind,
                    'goods'  => $goods
                 );
            }
        }
        $this->output['kindSelectOne'] = json_encode($data);
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
    /**
     * 获取指定二级分类-48号模板使用
     */
    private function _get_son_select_by_fid($fid){
        $data       = array();
        $kind_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $kind2      = $kind_model->getSonsByFid($fid,0, 4);//获取最多50个一级分类
        if($kind2){
            foreach($kind2 as $val){
                $data[] = array(
                    'id'    => $val['sk_id'],
                    'name'  => $val['sk_name'],
                    'cover' => $val['sk_logo']?$val['sk_logo']:'/public/manage/img/zhanwei/zw_fxb_200_200.png'
                );
            }
        }
        return $data;
    }
    /**
     * 获取类目下的推荐商品
     */
    private function _get_goods_by_kind1($kind1){
        $data         =  array();
        $goods_model  =  new App_Model_Goods_MysqlGoodsStorage();
        $where        =  array();
        $where[]      =  array('name'=>'g_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]      =  array('name'=>'g_kind1','oper'=>'=','value'=>$kind1);
        $where[]      =  array('name'=>'g_is_top','oper'=>'=','value'=>1);
        $list         =  $goods_model->getList($where,0,4,'',array('g_id','g_name','g_vip_price','g_price','g_cover'));
        if($list){
            foreach($list as $val){
                $data[] = array(
                    'id'   => $val['g_id'],
                    'name' => $val['g_name']?$val['g_name']:'商品名称',
                    'oldPrice'  => $val['g_price'],
                    'newPrice'  => $val['g_vip_price']?$val['g_vip_price']:$val['g_price'],
                    'cover'     => $val['g_cover']?$val['g_cover']:'/public/manage/img/zhanwei/zw_fxb_200_200.png'
                );
            }
        }
        return $data;
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




    /**
     * 获取列表以供使用
     */
    private function _get_list_for_select(){
        if($this->menuType == 'toutiao'){
            $config_name = 'toutiaosystem';
        }else{
            $config_name = 'system';
        }

        $foldType = plum_parse_config('fold_menu',$config_name);
        $linkList = plum_parse_config('link',$config_name);
        $linkType = plum_parse_config('link_type',$config_name);
        $weedingType = plum_parse_config('link_type_goods',$config_name);
        $link = $linkList[$this->wxapp_cfg['ac_type']];
        //unset($linkType[0]);  // 去除资讯单页
        $this->output['linkList'] = json_encode($link);
        unset($foldType[0]); //去掉客服
        if($this->wxapp_cfg['ac_type'] == 21){
            $allMallType = plum_parse_config('link_type_all_mall',$config_name);
            $this->output['linkType'] = json_encode(array_merge($linkType,$weedingType,$allMallType,$foldType));
        }else{
            $this->output['linkType'] = json_encode(array_merge($linkType,$weedingType,$foldType));
        }
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
        if($this->wxapp_cfg['ac_type'] == 6){
            $page_data[] = array(
                'path' => 'pages/goodIndex/goodIndex',
                'name' => '同城商城'." （pages/goodIndex/goodIndex）"
            );
        }
        return $page_data;
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


    /**
     * 获取商品分组数据
     */
    private function goodsGroup(){
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
        $this->output['goodsGroup'] = json_encode($data);
    }

    /**
     * 获取店铺促销商品,推荐商品选择推荐商品使用
     */
    private function _shop_top_goods_list(){
        $test = $this->request->getIntParam('test');
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        //只获得推荐商品
//        $goods_list = $goods_storage->fetchShopGoodsList($this->curr_sid,0,50,'',1,array(),array(),0,0,0);
        //获得全部商品  推荐在前
        $goods_list = $goods_storage->fetchShopGoodsList($this->curr_sid,0,0,'',0,array('g_is_top' => 'DESC','g_update_time' => 'DESC'),array(),0,0,1);
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

    private function _shop_appointment_goods_list(){
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        //只获得推荐商品
//        $goods_list = $goods_storage->fetchShopGoodsList($this->curr_sid,0,50,'',1,array(),array(),0,0,0);
        //获得全部商品  推荐在前
        $goods_list = $goods_storage->fetchShopGoodsList($this->curr_sid,0,0,'',0,array('g_is_top' => 'DESC','g_update_time' => 'DESC'),array(),0,0,3);
        $data = array();
        if($goods_list){
            foreach ($goods_list as $val){
                $data[] = array(
                    'id'   => $val['g_id'],
                    'name' => $val['g_name'],
                );
            }
        }
        $this->output['appointmentGoodsList'] = json_encode($data);
    }

    /**
     * @param $tpl
     * @return array
     * 获取该模板选择的推荐商品
     */
    private function _recommend_goods_list($tpl){
        $recommend_model = new App_Model_Mall_MysqlMallRecommendStorage($this->curr_sid);
        $recommend_list = $recommend_model->fetchRecommendShowList($tpl);
        $data = array();
        if($recommend_list){
            foreach ($recommend_list as $val){
                $data[] = array(
                    'name'     => $val['amr_name'],
                    'price'    => $val['amr_price'],
                    'imgsrc'   => isset($val['amr_img']) && $val['amr_img'] ? $val['amr_img'] :'/public/manage/img/zhanwei/zw_fxb_200_200.png',
                    'link'     => $val['amr_link'],
                    'index'    => $val['amr_weight'],
                );
            }

        }else{
            for($i=0;$i<3;$i++){
                $data[] = array(
                    'name'     => '推荐商品1',
                    'price'    => '0',
                    'imgsrc'   => '/public/manage/img/zhanwei/zw_fxb_200_200.png',
                    'link'     => '',
                    'index'    => $i,
                );
            }
        }
        $this->output['recommendGoods'] = json_encode($data);
    }

    /**
     * 获取店铺的全部分类选择使用
     */
    private function _shop_kind_list_for_select(){
        $kind_model     = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        // 获取店铺的所有二级分类
        $kind2 = $kind_model->getAllSonCategory(0,0);
        $data = array();
        if($kind2){
            foreach ($kind2 as $val){
                $data[] = array(
                    'id'   => $val['sk_id'],
                    'name' => $val['sk_name']
                );
            }
        }
//        //获取店铺的所有一级分类
        $kind1 = $kind_model->getAllFirstCategory(0,0);
        $firstKindSelect = array();
        if($kind1){
            foreach ($kind1 as $val){
                $firstKindSelect[] = array(
                    'id'   => $val['sk_id'],
                    'name' => $val['sk_name']
                );
            }
        }
        //一级分类和二级分类合并
        $data = array_merge($data,$firstKindSelect);
        $this->output['kindSelect'] = json_encode($data);
        $this->output['firstKindSelect'] = json_encode($firstKindSelect);
    }

    /**
     * @param $tpl
     * @return array
     * 获取店铺首页展示的分类数据
     */
    private function _shop_kind_list($tpl){
        $kind_model = new App_Model_Mall_MysqlMallKindStorage($this->curr_sid);
        $kind_list = $kind_model->fetchKindShowList($tpl);
        $data = array();
        if($kind_list){
            foreach ($kind_list as $val){
                $secondKind = $this->_get_son_select_by_fid($val['amk_link']);
                $goods      = $this->_get_goods_by_kind1($val['amk_link']);
                $data[] = array(
                    'title'  => $val['amk_name'],
                    'link'   => $val['amk_link'],
                    'index'  => $val['amk_weight'],
                    'imgsrc' => $val['amk_img'],
                    'selectTwo' => $secondKind,
                    'goods'     => $goods
                );
            }
        }else{
            $data[] = array(
                'title'  => '分类名称',
                'link'   => 1,
                'index'  => 0,
                'imgsrc' => '/public/manage/img/zhanwei/zw_fxb_750_180.png'
            );
        }
        $this->output['kindList'] = json_encode($data);
    }

    /**
     * 显示顶部管理设置
     */
    private function showShopTpl($tpl_id=3){
//        $tpl_model = new App_Model_Applet_MysqlAppletTplStorage($this->curr_sid);
//        $tpl  = $tpl_model->findUpdateBySid($tpl_id);
        $tpl_model = new App_Model_Mall_MysqlMallIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid($tpl_id);
        if(empty($tpl)){
            $tpl = array(
                'ami_title'      => '店铺首页',
                'ami_search_tip' => '请输入关键字',
                'ami_head_img'   => '/public/manage/applet/temp2/images/bg.png',
                'ami_tpl_id'     => $tpl_id,
                'ami_goods_list' => 1,
            );
        }
        $this->output['tpl'] = $tpl;
    }

    /**
     * 显示分类导航
     */
    private function showShortcut($tpl_id=3){
        $shortcut_model = new App_Model_Shop_MysqlShopShortcutStorage($this->curr_sid);
        $shortcut = $shortcut_model->fetchShortcutShowList($tpl_id);
        $json = array();
        foreach($shortcut as $key => $val){
            $json[] = array(
                'index'        => $key ,
                'title'        => $val['ss_name'],
                'imgsrc'       => $val['ss_icon'],
                'link'         => $val['ss_link'],
                'articleId'    => $val['ss_link'],
                'selectedSite' => array(
                    'id'   => $val['ss_link'],
                    'name' => $val['ss_name']
                ),
                'type'         => $val['ss_link_type']
            );
        }
        $this->output['shortcut'] = json_encode($json);
    }
    /**
     * 显示幻灯信息
     */
    private function showSlide($tpl_id=3){
        $slide_model = new App_Model_Shop_MysqlShopSlideStorage($this->curr_sid);
        $slide = $slide_model->fetchSlideShowList($tpl_id);
        $json = array();
        foreach($slide as $key => $val){
            $json[] = array(
                'index'          => $key ,
                'imgsrc'         => $val['ss_path'],
                'articleId'      => $val['ss_link'],
                'link'           => $val['ss_link'],
                'type'           => $val['ss_link_type']
            );
        }
        $this->output['slide'] = json_encode($json);
    }

    // 保存模板配置(废弃)
    public function saveAppletTplOldAction(){
        $tpl_id               = $this->request->getIntParam('tpl_id',3);
        $tpl['at_title']      = $this->request->getStrParam('title');
        $tpl['at_head_img']   = $this->request->getStrParam('head_img');
        $tpl['at_goods_list'] = $this->request->getIntParam('list_type');
        $tpl['at_address']    = $this->request->getStrParam('address');
        $tpl['at_lng']        = $this->request->getStrParam('longitude');
        $tpl['at_lat']        = $this->request->getStrParam('latitude');
        $tpl['at_update_time']= time();
        // 校验店铺是否可用改模板
        $index_tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $row   = $index_tpl_model->getRowBySid($tpl_id,$this->curr_sid);
        if($row){
            $tpl_model = new App_Model_Applet_MysqlAppletTplStorage($this->curr_sid);
            $tpl_row   = $tpl_model->findUpdateBySid($tpl_id);
            if(!empty($tpl_row)){
                $ret = $tpl_model->findUpdateBySid($tpl_id,$tpl);
            }else{
                $tpl['at_tpl_id']     = $tpl_id;
                $tpl['at_s_id']       = $this->curr_sid;
                $tpl['at_create_time']= time();
                $ret = $tpl_model->insertValue($tpl);
            }
            $this->save_shop_slide($tpl_id);
            $this->save_shop_shortcut($tpl_id);
            // 保存推荐商品
            $this->_save_shop_recommend($tpl_id);
            // 保存首页分类信息
            $this->_save_shop_kind($tpl_id);
            if($ret){
                $result = array(
                    'ec' => 200,
                    'em' => '信息保存成功'
                );
            }else{
                $result = array(
                    'ec' => 400,
                    'em' => '信息保存失败'
                );
            }
        }else{
            $result = array(
                'ec' => 400,
                'em' => '模版不可用'
            );
        }
        $this->displayJson($result);
    }

    // 保存模板配置
    public function saveAppletTplAction(){
        $tpl_id               = $this->request->getIntParam('tpl_id',3);
        $tpl['ami_title']      = $this->request->getStrParam('title');
        $tpl['ami_search_tip'] = $this->request->getStrParam('searchTip');
        $tpl['ami_head_img']   = $this->request->getStrParam('head_img');
        $tpl['ami_goods_list'] = $this->request->getIntParam('list_type');
        $tpl['ami_address']    = $this->request->getStrParam('address');
        $tpl['ami_lng']        = $this->request->getStrParam('longitude');
        $tpl['ami_lat']        = $this->request->getStrParam('latitude');
        $tpl['ami_recommend_tip'] = $this->request->getStrParam('recommendTip');

        $tpl['ami_notice_title']  = $this->request->getStrParam('notice_title');
        $tpl['ami_notice_color']  = $this->request->getStrParam('notice_color');
        //$tpl['ami_notice_size']   = $this->request->getStrParam('notice_size');
        $tpl['ami_update_time']   = time();
        // 校验店铺是否可用改模板
        $index_tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $row   = $index_tpl_model->getRowBySid($tpl_id,$this->curr_sid);
        if($row){
            $tpl_model = new App_Model_Mall_MysqlMallIndexStorage($this->curr_sid);
            $tpl_row   = $tpl_model->findUpdateBySid($tpl_id);
            if(!empty($tpl_row)){
                $ret = $tpl_model->findUpdateBySid($tpl_id,$tpl);
            }else{
                $tpl['ami_tpl_id']     = $tpl_id;
                $tpl['ami_s_id']       = $this->curr_sid;
                $tpl['ami_create_time']= time();
                $ret = $tpl_model->insertValue($tpl);
            }
            // 保存幻灯
            $this->save_shop_slide_new($tpl_id);

            // 保存分类导航
            $this->save_shop_shortcut_new($tpl_id);

            // 保存推荐商品
            $this->_save_shop_recommend($tpl_id);
            // 保存首页分类信息
            $this->_save_shop_kind($tpl_id);
            if($ret){
                App_Helper_OperateLog::saveOperateLog("首页模板【".$row['it_name']."】配置信息保存成功");
                $result = array(
                    'ec' => 200,
                    'em' => '信息保存成功'
                );
            }else{
                $result = array(
                    'ec' => 400,
                    'em' => '信息保存失败'
                );
            }
        }else{
            $result = array(
                'ec' => 400,
                'em' => '模版不可用'
            );
        }
        $this->displayJson($result);
    }
    /**
     * 修改模板公告启用状态
     */
    public function changeNoticeStatusAction(){
        $id     =  $this->request->getIntParam('id');
        $status =  $this->request->getIntParam('status');
        $ret    =  '';
        if($id){
            $tpl_model = new App_Model_Mall_MysqlMallIndexStorage($this->curr_sid);
            $set       = array('ami_notice_status'=>$status);
            $ret       = $tpl_model->updateById($set,$id);
        }

        if($ret){
            $str = $status > 0  ? '开启' : '关闭';
            App_Helper_OperateLog::saveOperateLog("{$str}首页模板公告");
        }

        $this->showAjaxResult($ret);
    }






    /**
     * 模版启用
     */
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
            //获取配置信息
//            if($this->menuType && $this->menuType=='bdapp'){
//                $applet_cfg = new App_Model_Baidu_MysqlBaiduCfgStorage($this->curr_sid);
//                $ret = $applet_cfg->findShopCfg($set);
//            }else if($this->menuType && $this->menuType=='aliapp'){
//                $applet_cfg = new App_Model_Alixcx_MysqlAlixcxCfgStorage($this->curr_sid);
//                $ret = $applet_cfg->findShopCfg($set);
//            }else if($this->menuType && $this->menuType == 'toutiao'){
//                $applet_cfg   = new App_Model_Toutiao_MysqlToutiaoCfgStorage($this->curr_sid);
//                $ret = $applet_cfg->findShopCfg($set);
//            } else{
//                $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
//                $ret = $applet_cfg->findShopCfg($set);
//            }
            $applet_cfg = $this->_get_cfg_by_menutype($this->menuType,$this->curr_sid);
            $ret = $applet_cfg->findShopCfg($set);

            if($ret){
                App_Helper_OperateLog::saveOperateLog("首页模板【".$row['it_name']."】启用成功");
                $result     = array(
                    'ec'    => 200,
                    'em'    => ' 启用成功'
                );
            }else{
                $result['em'] = '启用失败';
            }
        }
        $this->displayJson($result);
    }

    /**
     * @param $tpl_id
     * @return bool
     * 保存幻灯（废弃）
     */
    private function _save_shop_slide($tpl_id){
        $slide = $this->request->getArrParam('slide');
        $slide_model = new App_Model_Shop_MysqlShopSlideStorage($this->curr_sid);
        if(!empty($slide)){
            $slide_list = $slide_model->fetchSlideShowList($tpl_id);
            if(!empty($slide_list)){
                $del_id = array();
                foreach($slide_list as $val){
                    if(isset($slide[$val['ss_weight']])){  //存在这个位置的幻灯，更新
                        $set = array(
                            'ss_weight' => $slide[$val['ss_weight']]['index'],
                            'ss_link'   => $slide[$val['ss_weight']]['link'],
                            'ss_path'   => $slide[$val['ss_weight']]['imgsrc'],
                        );
                        $up_ret = $slide_model->updateById($set,$val['ss_id']);
                        unset($slide[$val['ss_weight']]); //然后清理前端传过来的幻灯
                    }else{ //多余的删除
                        $del_id[] = $val['ss_id'];
                    }
                }
                if(!empty($del_id)){
                    $slide_where = array();
                    $slide_where[] = array('name' => 'ss_id','oper' => 'in' , 'value' => $del_id);
                    $slide_model->deleteValue($slide_where);
                }

            }
            //新增的幻灯
            if(!empty($slide)){
                $insert = array();
                foreach($slide as $val){
                    $insert[] = " (NULL, {$this->curr_sid},  {$tpl_id}, '{$val['link']}', '{$val['imgsrc']}', '{$val['index']}', '1', '0', '".time()."')";
                }
                $ins_ret = $slide_model->insertBatch($insert);
            }
        }else{ //若不存在，则全部删除
            $where   = array();
            $where[] = array('name' => 'ss_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'ss_tpl_id','oper' => '=' , 'value' => $tpl_id);
            $slide_model->deleteValue($where);
        }
        return true;
    }

    /**
     * 保存快捷导航(废弃)
     */
    private function _save_shop_shortcut($tpl_id){
        $shortcut = $this->request->getArrParam('shortcut');
        $shortcut_model = new App_Model_Shop_MysqlShopShortcutStorage($this->curr_sid);
        if(!empty($shortcut)){
            $shortcut_list = $shortcut_model->fetchShortcutShowList($tpl_id);
            if(!empty($shortcut_list)){
                $del_id = array();
                foreach($shortcut_list as $val){
                    if(isset($shortcut[$val['ss_weight']])){  //存在这个位置的快捷导航，更新
                        $set = array(
                            'ss_weight' => $shortcut[$val['ss_weight']]['index'],
                            'ss_name'   => $shortcut[$val['ss_weight']]['title'],
                            'ss_icon'   => $shortcut[$val['ss_weight']]['imgsrc'],
                            'ss_link'   => $shortcut[$val['ss_weight']]['link'],
                        );
                        $up_ret = $shortcut_model->updateById($set,$val['ss_id']);
                        unset($shortcut[$val['ss_weight']]); //然后清理前端传过来的快捷导航
                    }else{ //多余的删除
                        $del_id[] = $val['ss_id'];
                    }
                }
                if(!empty($del_id)){
                    $shortcut_where = array();
                    $shortcut_where[] = array('name' => 'ss_id','oper' => 'in' , 'value' => $del_id);
                    $shortcut_model->deleteValue($shortcut_where);
                }

            }

            //新增的快捷导航
            if(!empty($shortcut)){
                $insert = array();
                foreach($shortcut as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}', {$tpl_id}, '{$val['title']}', '{$val['imgsrc']}', '{$val['link']}', '{$val['index']}',NULL, '0', '".time()."') ";
                }
                $ins_ret = $shortcut_model->insertBatch($insert);
            }
        }else{ //若数组为空，则清空该店铺快捷导航
            $where   = array();
            $where[] = array('name' => 'ss_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'ss_tpl_id','oper' => '=' , 'value' => $tpl_id);
            $shortcut_model->deleteValue($where);
        }

    }

    /**
     * 保存首页推荐商品
     */
    private function _save_shop_recommend($tpl_id){
        $recommend = $this->request->getArrParam('recommendGood');
        $recommend_model = new App_Model_Mall_MysqlMallRecommendStorage($this->curr_sid);
        if(!empty($recommend)){
            $recommend_list = $recommend_model->fetchRecommendShowList($tpl_id);
            if(!empty($recommend_list)){
                $del_id = array();
                foreach($recommend_list as $val){
                    if(isset($recommend[$val['amr_weight']])){  //存在这个位置的快捷导航，更新
                        $set = array(
                            'amr_weight' => $recommend[$val['amr_weight']]['index'],
                            'amr_name'   => $recommend[$val['amr_weight']]['name'],
                            'amr_price'  => $recommend[$val['amr_weight']]['price'],
                            'amr_img'    => $recommend[$val['amr_weight']]['imgsrc'],
                            'amr_link'   => $recommend[$val['amr_weight']]['link'],
                        );
                        $up_ret = $recommend_model->updateById($set,$val['amr_id']);
                        unset($recommend[$val['amr_weight']]); //然后清理前端传过来的快捷导航
                    }else{ //多余的删除
                        $del_id[] = $val['amr_id'];
                    }
                }
                if(!empty($del_id)){
                    $recommend_where = array();
                    $recommend_where[] = array('name' => 'amr_id','oper' => 'in' , 'value' => $del_id);
                    $recommend_model->deleteValue($recommend_where);
                }

            }

            //新增的快捷导航
            if(!empty($recommend)){
                $insert = array();
                foreach($recommend as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}', {$tpl_id}, '{$val['name']}', '{$val['price']}','{$val['imgsrc']}', '{$val['link']}', '{$val['index']}','','".time()."') ";
                }
                $ins_ret = $recommend_model->insertBatch($insert);
            }
        }else{ //若数组为空，则清空该店铺快捷导航
            $where   = array();
            $where[] = array('name' => 'amr_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'amr_tpl_id','oper' => '=' , 'value' => $tpl_id);
            $recommend_model->deleteValue($where);
        }

    }

    /**
     * 保存首页分类
     */
    private function _save_shop_kind($tpl_id){
        $kind = $this->request->getArrParam('kind');
        $kind_model = new App_Model_Mall_MysqlMallKindStorage($this->curr_sid);
        if(!empty($kind)){
            $kind_list = $kind_model->fetchKindShowList($tpl_id);
            if(!empty($kind_list)){
                $del_id = array();
                foreach($kind_list as $val){
                    if(isset($kind[$val['amk_weight']])){  //存在这个位置的快捷导航，更新
                        $set = array(
                            'amk_weight' => $kind[$val['amk_weight']]['index'],
                            'amk_name'   => $kind[$val['amk_weight']]['title'],
                            'amk_link'   => $kind[$val['amk_weight']]['link'],
                            'amk_img'    => $kind[$val['amk_weight']]['imgsrc'],
                        );
                        $up_ret = $kind_model->updateById($set,$val['amk_id']);
                        unset($kind[$val['amk_weight']]); //然后清理前端传过来的快捷导航
                    }else{ //多余的删除
                        $del_id[] = $val['amk_id'];
                    }
                }
                if(!empty($del_id)){
                    $kind_where = array();
                    $kind_where[] = array('name' => 'amk_id','oper' => 'in' , 'value' => $del_id);
                    $kind_model->deleteValue($kind_where);
                }

            }

            //新增的快捷导航
            if(!empty($kind)){
                $insert = array();
                foreach($kind as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}', {$tpl_id}, '{$val['title']}', '{$val['imgsrc']}','{$val['link']}', '','{$val['index']}','".time()."') ";
                }
                $ins_ret = $kind_model->insertBatch($insert);
            }
        }else{ //若数组为空，则清空该店铺快捷导航
            $where   = array();
            $where[] = array('name' => 'amk_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'amk_tpl_id','oper' => '=' , 'value' => $tpl_id);
            $kind_model->deleteValue($where);
        }

    }


    /**
     * 店铺设置
     */
    public function shopSetupAction(){
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $row        = $shop_model->getRowByIdCompany($this->company['c_id'],$this->curr_sid);
        $this->output['row'] = $row;
        $this->output['appletCfg'] = $this->wxapp_cfg;
        //配置营业时间 基础商城 万能商城 营销商城
//        $appletType = intval($this->wxapp_cfg['ac_type']);
//        if(in_array($appletType,array(21,1,24))) {
//            $this->output['showTime'] = 1;
//        }

        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '店铺管理', 'link' => '#'),
            array('title' => '店铺信息设置', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/mall/shop-setup.tpl');
    }

    /**
     * 保存店铺信息
     */
    public function saveShopInfoAction(){
        $strField   = array('name','contact','phone','logo','start_time','end_time');
        $str_data   = $this->getStrByField($strField,'s_');
        $data       = $str_data;
        $data['s_update_time']  = time();
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $ret        = $shop_model->updateById($data,$this->curr_sid);
        $this->showAjaxResult($ret,'保存');
    }

    /**
     * 保存店铺支付配置信息
     */
    public function saveShopPayAction(){
        $mch_id = $this->request->getStrParam('mch_id');
        $mch_key = $this->request->getStrParam('mch_key');
        $data       = array(
            'ac_mch_id'  => $mch_id,
            'ac_mch_key' => $mch_key
        );
        $applet_model = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        $ret        = $applet_model->findShopCfg($data);
        $this->showAjaxResult($ret,'保存');
    }

    /**
     * 获取店铺公告信息
     */
    public function shopNoticeAction(){
        $notice_storage     = new App_Model_Shop_MysqlShopNoticeStorage($this->curr_sid);
        $notice     = $notice_storage->fetchNoticeShowNew();
        $this->output['notice'] = $notice;
        $this->buildBreadcrumbs(array(
            array('title' => '店铺管理', 'link' => '#'),
            array('title' => '店铺公告', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/mall/notice.tpl');
    }

    public function saveShopNoticeAction(){
        $id      = $this->request->getIntParam('id');
        $title   = $this->request->getStrParam('title');
        $content = $this->request->getParam('content');
        $data = array(
            'sn_s_id'        => $this->curr_sid,
            'sn_title'       => $title,
            'sn_content'     => $content,
            'sn_create_time' => time()
        );
        $notice_storage     = new App_Model_Shop_MysqlShopNoticeStorage($this->curr_sid);
        $row = $notice_storage->getRowById($id);
        if($row){
            $ret = $notice_storage->updateById($data,$id);
        }else{
            $ret = $notice_storage->insertValue($data);
        }
        $this->showAjaxResult($ret);
    }
    /**
     * 配送方式配置
     */
    public function sendMethodAction(){
        $send_storage = new App_Model_Cake_MysqlCakeSendStorage($this->curr_sid);
        $send_cfg = $send_storage->findUpdateBySid();
        if(!$send_cfg){
            $data = array(
                'acs_s_id' => $this->curr_sid,
                'acs_send' => 0,
                'acs_receive' => 0,
                'acs_express_delivery' => 1,
                'acs_create_time' => time()
            );
            $send_storage->insertValue($data);
        }
        $send_cfg = $send_storage->findUpdateBySid();
        $this->output['cfg'] = $send_cfg;
        $this->buildBreadcrumbs(array(
            array('title' => '店铺管理', 'link' => '#'),
            array('title' => '配送设置', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/mall/send-cfg.tpl');
    }

    /**
     * 修改配送方式配置
     */
    public function changeSendAction()
    {
        $result = array(
            'ec' => 400,
            'em' => '修改失败'
        );
        $type    = $this->request->getStrParam('type');
        $value   = $this->request->getStrParam('value');
        $address = $this->request->getStrParam('address');
        $lng     = $this->request->getStrParam('lng');
        $lat     = $this->request->getStrParam('lat');
        $sendDetails = $this->request->getParam('sendDetails');
        $status = $value == 'on' ? 1 : 0;
        if ($type == 'send') {
            $data['acs_send'] = $status;
        }
        if ($type == 'receive') {
            $data['acs_receive'] = $status;
        }
        if ($type == 'express') {
            $data['acs_express_delivery'] = $status;
        }
        if($sendDetails){
            $data['acs_send_scope'] = $sendDetails;
        }
        if($address){
            $data['acs_shop_address'] = $address;
        }
        if($lng){
            $data['acs_shop_lng'] = $lng;
        }
        if($lat){
            $data['acs_shop_lat'] = $lat;
        }
        $data['acs_update_time'] = time();
        $send_storage = new App_Model_Cake_MysqlCakeSendStorage($this->curr_sid);
        $ret = $send_storage->findUpdateBySid($data);
        if ($ret) {
            $result = array(
                'ec' => 200,
                'em' => ' 修改成功'
            );
        }
        $this->displayJson($result);
    }
    /*万能商城*/
    /*
     * 万能商城店铺首页模板设置
     */
    public function indexTplAction()
    {
        $tpl_id = $this->request->getIntParam('tpl', 53);
        $tpl_model = new App_Model_Shop_MysqlIndexTplStorage();
        $row = $tpl_model->getRowBySid($tpl_id, $this->curr_sid);
        $this->output['shop'] = $this->shops[$this->curr_sid];
        if ($row) {
            $this->showMallShopTpl($tpl_id);
            $this->showShortcut($tpl_id);
            $this->showMallSlide($tpl_id);
            $this->goodsGroup();
            // 店铺选择推荐商品
            $this->_shop_top_goods_list();
            // 店铺推荐商品展示
            $this->_mall_recommend_goods_list($tpl_id);
            //店铺的所有二级分类
            $this->_shop_kind_list_for_select();
            // 店铺分类展示
            $this->_shop__mall_kind_list($tpl_id);
            // 链接列表及分类
            $this->_get_list_for_select();
            //获取文章列表
            $this->_shop_information();
            $this->renderCropTool('/wxapp/index/uploadImg');
            $this->buildBreadcrumbs(array(
                array('title' => '店铺主页', 'link' => '/wxapp/mall/mallTemplate'),
                array('title' => '首页模版', 'link' => '#'),
            ));
            if($tpl_id == 48){
                $this->_kind_one_get_select();
            }
            $this->displaySmarty('wxapp/universal/index-tpl_' . $tpl_id . '.tpl');
        } else {
            plum_url_location('模版不存在');
        }
    }
    /**
     * 显示顶部管理设置
     */
    private function showMallShopTpl($tpl_id=3){
//        $tpl_model = new App_Model_Applet_MysqlAppletTplStorage($this->curr_sid);
//        $tpl  = $tpl_model->findUpdateBySid($tpl_id);
        $tpl_model = new App_Model_Mall_MysqlMallUniversalStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid($tpl_id);
        if(empty($tpl)){
            $tpl = array(
                'amu_title'      => '店铺首页',
                'amu_tpl_id'     => $tpl_id,
            );
        }
        $this->output['tpl'] = $tpl;
    }
    /**
     * 显示幻灯信息
     */
    private function showMallSlide($tpl_id=3){
        $slide_model = new App_Model_Shop_MysqlShopSlideStorage($this->curr_sid);
        $slide = $slide_model->fetchSlideShowList($tpl_id);
        $json = array();
        foreach($slide as $key => $val){
            $json[] = array(
                'index'          => $key ,
                'imgsrc'         => $val['ss_path'],
                'articleId'      => $val['ss_link'],
                'link'           => $val['ss_link'],
                'type'           => $val['ss_link_type']
            );
        }
        $this->output['slide'] = json_encode($json);
    }
    /**
     * @param $tpl
     * @return array
     * 获取店铺首页展示的分类数据
     */
    private function _shop__mall_kind_list($tpl){
        $kind_model = new App_Model_Mall_MysqlMallKindStorage($this->curr_sid);
        $kind_list = $kind_model->fetchKindShowList($tpl);
        $data = array();
        if($kind_list){
            foreach ($kind_list as $val){
                $secondKind = $this->_get_son_select_by_fid($val['amk_link']);
                $goods      = $this->_get_goods_by_kind1($val['amk_link']);
                $data[] = array(
                    'title'     => $val['amk_name'],
                    'link'      => $val['amk_link'],
                    'index'     => $val['amk_weight'],
                    'imgsrc'    => $val['amk_img'],
                    'type'      => $val['amk_goods_list'],
                    'selectTwo' => $secondKind,
                    'goods'     => $goods,
                    'sign'      => $val['amk_sign'],
                );
            }
        }else{
            $data[] = array(
                'title'  => '分类名称',
                'link'   => 1,
                'index'  => 0,
                'type'   => 2,
                'sign'   => '新品上市 先买先得',
                'imgsrc' => '/public/manage/img/zhanwei/zw_fxb_750_180.png'
            );
        }
        $this->output['kindList'] = json_encode($data);
    }
    /**
     * @param $tpl
     * @return array
     * 获取该模板选择的推荐商品
     */
    private function _mall_recommend_goods_list($tpl){
        $recommend_model = new App_Model_Mall_MysqlMallRecommendStorage($this->curr_sid);
        $recommend_list = $recommend_model->fetchRecommendShowList($tpl);
        $data = array();
        if($recommend_list){
            foreach ($recommend_list as $val){
                $data[] = array(
                    'name'     => $val['amr_name'],
                    'price'    => $val['amr_price'],
                    'imgsrc'   => isset($val['amr_img']) && $val['amr_img'] ? $val['amr_img'] :'/public/manage/img/zhanwei/zw_fxb_200_200.png',
                    'link'     => $val['amr_link'],
                    'index'    => $val['amr_weight'],
                );
            }

        }/*else{
            for($i=0;$i<3;$i++){
                $data[] = array(
                    'name'     => '推荐商品1',
                    'price'    => '0',
                    'imgsrc'   => '/public/manage/img/zhanwei/zw_fxb_200_200.png',
                    'link'     => '',
                    'index'    => $i,
                );
            }
        }*/
        $this->output['recommendGoods'] = json_encode($data);
    }
    // 保存模板配置
    public function saveMallTplAction(){
        $tpl_id               = $this->request->getIntParam('tpl_id',53);
        $tpl['amu_title']      = $this->request->getStrParam('title');
      /*  $tpl['ami_search_tip'] = $this->request->getStrParam('searchTip');
        $tpl['ami_head_img']   = $this->request->getStrParam('head_img');
        $tpl['ami_goods_list'] = $this->request->getIntParam('list_type');
        $tpl['ami_address']    = $this->request->getStrParam('address');
        $tpl['ami_lng']        = $this->request->getStrParam('longitude');
        $tpl['ami_lat']        = $this->request->getStrParam('latitude');
        $tpl['ami_recommend_tip'] = $this->request->getStrParam('recommendTip');*/
        $tpl['amu_coupon_title']     = $this->request->getStrParam('coupon_title');//优惠券标题
        $tpl['amu_coupon_sign']      = $this->request->getStrParam('coupon_sign');//优惠券标签
        $tpl['amu_promotion_title']  = $this->request->getStrParam('promotion_title');//促销标题
        $tpl['amu_promotion_sign']   = $this->request->getStrParam('promotion_sign');//促销标签
        $tpl['amu_hot_img']          = $this->request->getStrParam('hot_img');
        $tpl['amu_hot_type']         = $this->request->getIntParam('hot_type');
        $tpl['amu_hot_link']         = $this->request->getIntParam('hot_link');
        $tpl['amu_update_time']      = time();
        // 校验店铺是否可用改模板
        /*$index_tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $row   = $index_tpl_model->getRowBySid($tpl_id,$this->curr_sid);
        if($row){*/
            $tpl_model = new App_Model_Mall_MysqlMallUniversalStorage($this->curr_sid);
            $tpl_row   = $tpl_model->findUpdateBySid($tpl_id);
            if(!empty($tpl_row)){
                $ret = $tpl_model->findUpdateBySid($tpl_id,$tpl);
            }else{
                $tpl['amu_tpl_id']     = $tpl_id;
                $tpl['amu_s_id']       = $this->curr_sid;
                $tpl['amu_create_time']= time();
                $ret = $tpl_model->insertValue($tpl);
            }
            // 保存幻灯
            $this->save_shop_slide_new($tpl_id);

            // 保存分类导航
            $this->save_shop_shortcut_new($tpl_id);

            // 保存推荐商品
            $this->_save_shop_recommend($tpl_id);
            // 保存首页分类信息
           $this->_save_mall_shop_kind($tpl_id);
            if($ret){
                $result = array(
                    'ec' => 200,
                    'em' => '信息保存成功'
                );
            }else{
                $result = array(
                    'ec' => 400,
                    'em' => '信息保存失败'
                );
            }
        /*}else{
            $result = array(
                'ec' => 400,
                'em' => '模版不可用'
            );
        }*/
        $this->displayJson($result);
    }
    /**
     * 保存首页分类
     */
    private function _save_mall_shop_kind($tpl_id){
        $kind = $this->request->getArrParam('kind');
        $kind_model = new App_Model_Mall_MysqlMallKindStorage($this->curr_sid);
        if(!empty($kind)){
            $kind_list = $kind_model->fetchKindShowList($tpl_id);
            if(!empty($kind_list)){
                $del_id = array();
                foreach($kind_list as $val){
                    if(isset($kind[$val['amr_weight']])){  //存在这个位置的快捷导航，更新
                        $set = array(
                            'amk_weight'        => $kind[$val['amk_weight']]['index'],
                            'amk_name'          => $kind[$val['amk_weight']]['title'],
                            'amk_link'          => $kind[$val['amk_weight']]['link'],
                            'amk_img'           => $kind[$val['amk_weight']]['imgsrc'],
                            'amk_goods_list'    => $kind[$val['amk_weight']]['type'],
                            'amk_sign'          => $kind[$val['amk_weight']]['sign'],
                        );
                        $up_ret = $kind_model->updateById($set,$val['amk_id']);
                        unset($kind[$val['amk_weight']]); //然后清理前端传过来的快捷导航
                    }else{ //多余的删除
                        $del_id[] = $val['amk_id'];
                    }
                }
                if(!empty($del_id)){
                    $kind_where = array();
                    $kind_where[] = array('name' => 'amk_id','oper' => 'in' , 'value' => $del_id);
                    $kind_model->deleteValue($kind_where);
                }

            }

            //新增的快捷导航
            if(!empty($kind)){
                $insert = array();
                foreach($kind as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}', {$tpl_id}, '{$val['title']}', '{$val['imgsrc']}','{$val['link']}','{$val['sign']}','{$val['type']}', '{$val['index']}','".time()."') ";
                }
                $ins_ret = $kind_model->newInsertBatch($insert);
            }
        }else{ //若数组为空，则清空该店铺快捷导航
            $where   = array();
            $where[] = array('name' => 'amk_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'amk_tpl_id','oper' => '=' , 'value' => $tpl_id);
            $kind_model->deleteValue($where);
        }

    }
    /**
     * 个人中心设置
     */
    public function centerManageAction(){
        $center_model   = new App_Model_Member_MysqlCenterToolStorage();
        $row            = $center_model->findUpdateBySid($this->curr_sid);
        if(empty($row)){
            $row = plum_parse_config('center_tool');
        }
        if(!$row['ct_nav_list']){
            $row['ct_nav_list'] = json_encode(array(
                array(
                    'index' => 0,
                    'open' => false,
                    'title' => '小金库',
                    'imgsrc' => '/public/manage/img/zhanwei/zw_fxb_200_200.png'
                ),
                array(
                    'index' => 1,
                    'open' => false,
                    'title' => '卡包',
                    'imgsrc' => '/public/manage/img/zhanwei/zw_fxb_200_200.png'
                ),
                array(
                    'index' => 2,
                    'open' => false,
                    'title' => '积分商城',
                    'imgsrc' => '/public/manage/img/zhanwei/zw_fxb_200_200.png'
                ),
                array(
                    'index' => 3,
                    'open' => false,
                    'title' => '会员特权',
                    'imgsrc' => '/public/manage/img/zhanwei/zw_fxb_200_200.png'
                ),
            ));
        }else{
            $navList = json_decode($row['ct_nav_list'], true);
            foreach($navList as $key=>$val){
                $navList[$key]['open'] = $val['open'] == 'true'?true:false;
            }
            $row['ct_nav_list'] = json_encode($navList);
        }
        $row['center']  = $this->composeLink('center','index',array(),true,'info');
        $this->output['row'] = $row;
        $this->buildBreadcrumbs(array(
            array('title' => '会员中心', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');   // 上传图片
        $this->displaySmarty('wxapp/member/marketing-member-center.tpl');
    }
}