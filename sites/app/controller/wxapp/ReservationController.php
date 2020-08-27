<?php


class App_Controller_Wxapp_ReservationController extends App_Controller_Wxapp_OrderCommonController {

    public function __construct() {
        parent::__construct();
    }

    
    public function allTemplateAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '小程序首页模板', 'link' => '#'),
        ));
        $cfg = plum_parse_config('category','applet');
        $tpl_ids = $cfg[18]['tpl'];
        $tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $list       = $tpl_model->getListByTidSidType($tpl_ids,$this->curr_sid,3);

        $applet_cfg = $this->_get_cfg_by_menutype($this->menuType,$this->curr_sid);
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
        $this->displaySmarty('wxapp/reservation/reserva-template.tpl');
    }

    
    public function indexTplAction(){
        $tpl_id  = $this->request->getIntParam('tpl', 33);
        $this->showIndexTpl($tpl_id);
        $this->showShopTplSlide($tpl_id);
        $this->_show_store_list();
        $this->_show_goods_list();
        $this->showShopTplShortcut($tpl_id);
        $this->_show_tpl_notice();
        $this->_shop_information();
        $this->_show_tpl_journal($tpl_id);

        $this->_show_category(1, 1);
        $this->_show_category(2, 1);
        $this->_show_expert_list();//专家列表
        $this->get_link_list_for_select();
        $this->_get_jump_list();

        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/reservation/index-tpl_'.$tpl_id.'.tpl');
    }

    
    public function get_link_list_for_select(){
        if($this->menuType == 'toutiao'){
            $config_name = 'toutiaosystem';
        }else{
            $config_name = 'system';
        }


        $linkList = plum_parse_config('link',$config_name);
        $linkType = plum_parse_config('link_type',$config_name);
        $reserType = plum_parse_config('link_type_reserva',$config_name);
        $link = $linkList[$this->wxapp_cfg['ac_type']];
        $this->output['linkList'] = json_encode($link);
        $this->output['linkType'] = json_encode(array_merge($linkType,$reserType));
    }


    
    private function _show_tpl_journal($tpl_id){
        $journal_storage = new App_Model_Reservation_MysqlReservationJournalStorage($this->curr_sid);
        $journal_list = $journal_storage->fetchJournalShowList($tpl_id);
        $json = array();
        if($journal_list){
            foreach($journal_list as $key => $val){
                $json[] = array(
                    'index'        => $val['arj_weight'] ,
                    'name'         => $val['arj_title'],
                    'imgsrc'       => $val['arj_icon'],
                    'articleId'    => $val['arj_link'],
                    'articleTitle' => $val['arj_course_title'],
                    'brief'        => $val['arj_brief']
                );
            }
        }
        $this->output['journalList'] = json_encode($json);
    }

    
    private function _show_tpl_notice(){
        $notice_storage = new App_Model_Train_MysqlTrainNoticeStorage($this->curr_sid);
        $notice_list = $notice_storage->fetchNoticeShowList();
        $data = array();
        if($notice_list){
            foreach ($notice_list as $val){
                $data[] = array(
                    'index'         => $val['atn_weight'],
                    'title'         => $val['atn_title'],
                    'imgsrc'       => $val['atn_img'],
                    'articleId'     => $val['atn_article_id'],
                    'articleTitle'  => $val['atn_article_title']
                );
            }
        }
        $this->output['noticeList'] = json_encode($data);
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

    
    private function _show_goods_list(){
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $sort        = array('g_weight' => 'DESC', 'g_update_time' => 'DESC');
        $list        = $goods_model->fetchShopGoodsList($this->curr_sid,0,0,'', 0, $sort,array(),1,0,1);;
        $info        = array();
        if($list){
            foreach ($list as $val){
                $info[] = $this->_format_goods_details($val);
            }
        }
        $this->output['goods'] = json_encode($info); 
    }

    
    private function _show_expert_list(){
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $sort        = array('g_weight' => 'DESC', 'g_update_time' => 'DESC');
        $list        = $goods_model->fetchShopGoodsList($this->curr_sid,0,0,'', 0, $sort,array(),2,0,1);;
        $info        = array();
        if($list){
            foreach ($list as $val){
                $info[] = $this->_format_goods_details($val);
            }
        }
        $this->output['expertList'] = json_encode($info);
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

    
    private function showIndexTpl($tpl_id=33){
        $tpl_model = new App_Model_Reservation_MysqlReservationIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid($tpl_id);
        if(empty($tpl)){
            $tpl = array(
                'ari_title'         => '首页',
                'ari_tpl_id'        => $tpl_id,
            );
        }
        $this->output['navList'] = isset($tpl['ari_activity']) && $tpl['ari_activity'] ? json_decode($tpl['ari_activity'],true) : array();
        $this->output['tpl'] = $tpl;
    }
    private function save_shop_slide_now($tpl_id, $type = 1){
        $slide = $this->request->getArrParam('slide');
        $slide_model = new App_Model_Shop_MysqlShopSlideStorage($this->curr_sid);
        if(!empty($slide)){
            $slide_list = $slide_model->fetchSlideShowList($tpl_id, $type);
            if(!empty($slide_list)){
                $del_id = array();
                foreach($slide_list as $val){
                    if(isset($slide[$val['ss_weight']])){
                        $set = array(
                            'ss_weight' => $slide[$val['ss_weight']]['index'],
                            'ss_link'   => $slide[$val['ss_weight']]['articleId'],
                            'ss_path'   => $slide[$val['ss_weight']]['imgsrc'],
                            'ss_article_title' => $slide[$val['ss_weight']]['articleTitle'],
                            'ss_link_type'     => $slide[$val['ss_weight']]['type'],
                            'ss_type'          => $type
                        );
                        $up_ret = $slide_model->updateById($set,$val['ss_id']);
                        unset($slide[$val['ss_weight']]);
                    }else{
                        $del_id[] = $val['ss_id'];
                    }
                }
                if(!empty($del_id)){
                    $slide_where = array();
                    $slide_where[] = array('name' => 'ss_id','oper' => 'in' , 'value' => $del_id);
                    $slide_model->deleteValue($slide_where);
                }

            }
            if(!empty($slide)){
                $insert = array();
                foreach($slide as $val){
                    $insert[] = " (NULL, {$this->curr_sid},  {$tpl_id}, {$type}, '{$val['articleId']}', '{$val['articleTitle']}', '{$val['imgsrc']}', '{$val['index']}', '1', '0', '".time()."')";
                }
                $ins_ret = $slide_model->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'ss_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'ss_tpl_id','oper' => '=' , 'value' => $tpl_id);
            $where[] = array('name' => 'ss_type','oper' => '=' , 'value' => $type);
            $slide_model->deleteValue($where);
        }
        return true;
    }

    
    private function _save_reservation_journal($tpl_id){
        $journalList = $this->request->getArrParam('journalList');
        $journal_storage = new App_Model_Reservation_MysqlReservationJournalStorage($this->curr_sid);
        if(!empty($journalList)){
            $journal_list = $journal_storage->fetchJournalShowList($tpl_id);
            if(!empty($journal_list)){
                $del_id = array();
                foreach($journal_list as $val){
                    if(isset($journalList[$val['arj_weight']])){
                        $set = array(
                            'arj_weight'            => $journalList[$val['arj_weight']]['index'],
                            'arj_title'             => $journalList[$val['arj_weight']]['name'],
                            'arj_icon'              => $journalList[$val['arj_weight']]['imgsrc'],
                            'arj_link'              => $journalList[$val['arj_weight']]['articleId'],
                            'arj_brief'             => $journalList[$val['arj_weight']]['brief'],
                            'arj_course_title'     => $journalList[$val['arj_weight']]['articleTitle'],
                        );
                        $up_ret = $journal_storage->updateById($set,$val['arj_id']);
                        unset($journalList[$val['arj_weight']]);
                    }else{
                        $del_id[] = $val['arj_id'];
                    }
                }
                if(!empty($del_id)){
                    $activity_where = array();
                    $activity_where[] = array('name' => 'arj_id','oper' => 'in' , 'value' => $del_id);
                    $del_ret = $journal_storage->deleteValue($activity_where);
                }

            }
            if(!empty($journalList)){
                $insert = array();
                foreach($journalList as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}', {$tpl_id}, '{$val['name']}','{$val['imgsrc']}','{$val['articleId']}','{$val['brief']}','{$val['articleTitle']}', '{$val['index']}', '0', '".time()."') ";
                }
                $ins_ret = $journal_storage->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'arj_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'arj_tpl_id','oper' => '=' , 'value' => $tpl_id);
            $del     = $journal_storage->deleteValue($where);
        }
        if($up_ret || $ins_ret || $del_ret || $del){
            return true;
        }else{
            return false;
        }
    }



    
    private function _save_train_notice(){
        $noticeInfo = $this->request->getArrParam('notice');
        $notice_storage = new App_Model_Train_MysqlTrainNoticeStorage($this->curr_sid);
        if(!empty($noticeInfo)){
            $notice_list = $notice_storage->fetchNoticeShowList();
            if(!empty($notice_list)){
                $del_id = array();
                foreach($notice_list as $val){
                    if(isset($noticeInfo[$val['atn_weight']])){
                        $set = array(
                            'atn_weight'            => $noticeInfo[$val['atn_weight']]['index'],
                            'atn_title'             => $noticeInfo[$val['atn_weight']]['title'],
                            'atn_img'               => $noticeInfo[$val['atn_weight']]['imgsrc'],
                            'atn_article_id'        => $noticeInfo[$val['atn_weight']]['articleId'],
                            'atn_article_title'     => $noticeInfo[$val['atn_weight']]['articleTitle'],
                        );
                        $up_ret = $notice_storage->updateById($set,$val['atn_id']);
                        unset($noticeInfo[$val['atn_weight']]);
                    }else{
                        $del_id[] = $val['atn_id'];
                    }
                }
                if(!empty($del_id)){
                    $notice_where = array();
                    $notice_where[] = array('name' => 'atn_id','oper' => 'in' , 'value' => $del_id);
                    $del_ret = $notice_storage->deleteValue($notice_where);
                }

            }
            if(!empty($noticeInfo)){
                $insert = array();
                foreach($noticeInfo as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}','{$val['title']}','{$val['imgsrc']}','{$val['articleId']}','{$val['articleTitle']}','{$val['index']}','".time()."') ";
                }
                $ins_ret = $notice_storage->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'atn_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $del     = $notice_storage->deleteValue($where);
        }
        if($up_ret || $ins_ret || $del_ret || $del){
            return true;
        }else{
            return false;
        }
    }

    
    private function _update_tpl($data, $tpl_id){
        $tpl_model = new App_Model_Reservation_MysqlReservationIndexStorage($this->curr_sid);
        $tpl_row   = $tpl_model->findUpdateBySid($tpl_id);
        if(!empty($tpl_row)){
            $tpl_ret = $tpl_model->findUpdateBySid($tpl_id,$data);
        }else{
            $tpl['ari_create_time']= time();
            $tpl_ret = $tpl_model->insertValue($data);
        }
        return $tpl_ret;
    }

    
    private function _show_store_list($json=true){
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $where      = array();
        $where[]    = array('name' => 'os_s_id','oper' => '=','value' =>$this->curr_sid);
        $output['name'] = $this->request->getStrParam('name');
        if($output['name']){
            $where[]    = array('name' => 'os_name','oper' => 'like','value' =>"%{$output['name']}%");
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

    
    public function expertCategoryAction(){
        $this->goodsCategoryAction(2);
    }

    public function goodsCategoryAction($type = ''){
        $category = $this->goods_category_son_data('',$type);
        $type = plum_parse_config('reservation_category_type', 'system');
        $this->output['type'] = $type;
        $this->renderCropTool('/wxapp/index/uploadImg');
        if($type == 2){
            $title = '专家分类';
        }else{
            $title = '产品分类';
        }
        $this->buildBreadcrumbs(array(
            array('title' => $title, 'link' => '#'),
        ));
        $this->output['list'] = $category;
        $this->displaySmarty('wxapp/reservation/good-category.tpl');
    }

    
    private function goods_category_son_data($isJson=1,$type = ''){
        $type = $type ? $type : $this->request->getIntParam('type', 1);
        $this->output['currType'] = $type;
        $category_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $categoryList   = $category_model->getSonsByFid($type);
        $temp           = array();
        if($categoryList){
            foreach($categoryList as $val){
                $temp[$val['sk_id']] = array(
                    'id'        => $val['sk_id'],
                    'index'     => $val['sk_weight'],
                    'name'       => $val['sk_name'],
                    'type'      => $val['sk_fid'],
                    'imgSrc'    => $val['sk_logo'],
                    'createTime'=> date('Y-m-d H:i:s', $val['sk_create_time']),
                    'secondItem'=> array(),
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

    
    public function goodsAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => '#'),
        ));
        $this->_show_goods_list_data(1);
        $level_model = new App_Model_Member_MysqlLevelStorage();
        $list = $level_model->getListBySid($this->curr_sid);
        $this->output['levelList'] = $list;
        $this->_show_category(1,0,1);

        if(in_array($this->wxapp_cfg['ac_type'],[6,21,1,8,24,18])){
            $this->output['addMember'] = 1;
        }else{
            $this->output['addMember'] = 0;
        }

        $this->output['choseLink']  = $this->showTableLink('goods');
        $this->displaySmarty('wxapp/reservation/goods-list.tpl');
    }

    
    public function expertsAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '专家管理', 'link' => '#'),
        ));
        $this->_show_goods_list_data(2);
        $this->_show_category(2,0,1);
        $this->output['choseLink']  = $this->showTableLink('goods');
        $this->displaySmarty('wxapp/reservation/experts-list.tpl');
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
                        'href'  => '/wxapp/reservation/tradeList?status=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/wxapp/reservation/tradeList?status=nopay'.$extra,
                        'key'   => 'nopay',
                        'label' => '待付款'
                    ),
                    array(
                        'href'  => '/wxapp/reservation/tradeList?status=pay'.$extra,
                        'key'   => 'pay',
                        'label' => '已付款'
                    ),
                    array(
                        'href'  => '/wxapp/reservation/tradeList?status=complete'.$extra,
                        'key'   => 'complete',
                        'label' => '已完成'
                    ),
                    array(
                        'href'  => '/wxapp/reservation/tradeList?status=refund'.$extra,
                        'key'   => 'refund',
                        'label' => '已退款'
                    ),
                    array(
                        'href'  => '/wxapp/reservation/tradeList?status=close'.$extra,
                        'key'   => 'close',
                        'label' => '已关闭'
                    ),
                );
                break;
            case 'goods' :
                $link = array(
                    array(
                        'href'  => '/wxapp/reservation/goods?status=sell'.$extra,
                        'key'   => 'sell',
                        'label' => '出售中'
                    ),
                    array(
                        'href'  => '/wxapp/reservation/goods?status=depot'.$extra,
                        'key'   => 'depot',
                        'label' => '已下架'
                    ),
                );
                break;
            case 'settled' :
                $link = array(
                    array(
                        'href'  => '/wxapp/reservation/settled?status=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/wxapp/reservation/settled?status=doing'.$extra,
                        'key'   => 'doing',
                        'label' => '进行中'
                    ),
                    array(
                        'href'  => '/wxapp/reservation/settled?status=refund'.$extra,
                        'key'   => 'refund',
                        'label' => '退款'
                    ),
                    array(
                        'href'  => '/wxapp/reservation/settled?status=success'.$extra,
                        'key'   => 'success',
                        'label' => '成功'
                    ),
                );
                break;


        }
        return $link;
    }

    
    private function _show_goods_list_data($type,$expert = false,$gid = 0){
        $where          = array();
        $where[]        = array('name' => 'g_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[]        = array('name' => 'g_type','oper' => 'in','value' => array(1,2));
        $output['name'] = $this->request->getStrParam('name');
        if($output['name']){
            $where[] = array('name' => 'g_name','oper' => 'like','value' =>"%{$output['name']}%");
        }
        $output['cate'] = $this->request->getIntParam('cate');
        if($type){
            $where[] = array('name' => 'g_kind1','oper' => '=','value' =>$type);
        }

        if($output['cate']){
            $where[] = array('name' => 'g_kind2','oper' => '=','value' =>$output['cate']);
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
            $sort = array('g_weight'=>'DESC','g_update_time' => 'DESC');
            $list = $goods_model->getList($where,$index,$this->count,$sort,array(),$expert);
            $deduct_gids = array();
            foreach($list as $key=>$val){

                $deduct_gids[] = $val['g_id'];
                $param = array(
                    'gid' => $val['g_id']
                );
                if(!$val['g_qrcode']){
                    $list[$key]['g_qrcode']=$this->create_qrcode($val['g_id']);
                }
            }
        }
        if($list){
            $output['now'] = 1;
        }
        $output['list'] = $list;
        if($expert){
            $expertList = [];
            if($gid){
                $arge_model = new App_Model_Reservation_MysqlReservationGoodsExpertStorage($this->curr_sid);
                $gids = array_keys($list);
                $expertList = $arge_model->fetchExpertList($gid);
                foreach ($expertList as $key => $val){
                    if(!in_array($val['arge_e_id'],$gids)){
                        unset($expertList[$key]);
                    }
                }
            }
           $this->output['expertList'] = $expertList;
        }

        $this->showOutput($output);
    }


    
    private function create_qrcode($id){
        $good_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        $str = "id=".$id;
        $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::GOODS_DETAIL_CODE_PATH, 210);
        $updata = array('g_qrcode'=>$url);
        $good_model->updateById($updata,$id);
        return $url;
    }

    
    private function _show_category($type, $index=0,$all = 0){
        $category_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $cateList          = $category_model->getSonsByFid($type);
        $category       = array();
        if($index){
            foreach($cateList as $val){
                $category[] = array(
                    'id' => $val['sk_id'],
                    'name' => $val['sk_name']
                );
            }
            if($type == 2){
                $this->output['expertCategory']    = json_encode($category) ;
                if($all){
                    $this->output['category']    =json_encode($category);
                }
            }else{
                $this->output['category']   = json_encode($category);
            }
        }else{
            $category       = array();
            foreach($cateList as $val){
                $category[$val['sk_id']] = $val['sk_name'];
            }
            if($type == 2){
                $this->output['expertCategory']    = $category ;
                if($all){
                    $this->output['category']    =$category ;
                }
            }else{
                $this->output['category']    =$category ;
            }

        }

    }

    
    private function _show_category_goods(){
        $category_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $first          = $category_model->getListBySid();
        $category       = array();
        foreach($first as $val){
            $category[$val['sk_id']] = array(
                'id'   => $val['sk_id'],
                'name' => $val['sk_name'],
                'goods'=> $this->_get_category_goods($val['sk_id'])
            );
        }
        $this->output['categoryGoods']   =$category ;
    }

    
    private function _get_category_goods($id){
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $sort        = array('g_weight' => 'DESC', 'g_update_time' => 'DESC');
        $list        = $goods_model->fetchShopGoodsList($this->curr_sid, 0, 4, null, 0, $sort,array(),$id);
        $info        = array();
        if($list){
            foreach ($list as $val){
                $info[] = $this->_format_goods_details($val);
            }
        }
        return $info;
    }

    
    public function addGoodAction(){
        $id  = $this->request->getIntParam('id');
        $type = $this->request->getIntParam('type');
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
        $this->_show_category($type,0,1);
        $this->_show_store_list(false);
        $message_storage = new App_Model_Goods_MysqlMessageTemplateStorage();
        $sort = array('amt_update_time' => 'DESC');
        $where = array();
        $where[] = array('name' => 'amt_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'amt_es_id', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'amt_deleted', 'oper' => '=', 'value' => 0);
        $messageList = $message_storage->getList($where, 0, 0, $sort);

        $this->output['row'] = $row;
        $this->output['slide']      =  $slide;
        $this->output['format']     =  $format;
        $this->output['formatNum']  = $formatNum;
        $this->output['formatSort'] = implode(',',$sort);
        $this->output['messageListData'] = $messageList;

        $this->renderCropTool('/wxapp/index/uploadImg');
        if($type == 1){
            $this->buildBreadcrumbs(array(
                array('title' => '商品管理', 'link' => '/wxapp/reservation/goods'),
                array('title' => '添加商品', 'link' => '#'),
            ));
        }else{
            $this->buildBreadcrumbs(array(
                array('title' => '团队管理', 'link' => '/wxapp/reservation/experts'),
                array('title' => '添加成员', 'link' => '#'),
            ));
        }

        if($type == 1){
            $this->_show_goods_list_data(2,true,$id);
            $this->displaySmarty("wxapp/reservation/add-goods.tpl");
        }else{
            $this->displaySmarty("wxapp/reservation/add-experts.tpl");
        }
    }

    
    private function _save_expert($id){
        $expertInfo = $this->request->getStrParam('expertInfo');
        $expertInfo = json_decode($expertInfo,true);
        $arge_model = new App_Model_Reservation_MysqlReservationGoodsExpertStorage($this->curr_sid);
        if(is_array($expertInfo) && !empty($expertInfo)){
            $expertList = $arge_model->fetchExpertList($id);
            if(!empty($expertList)){
                $del_id = [];
                foreach ($expertList as $val){
                    if(isset($expertInfo[$val['arge_sort']])){
                        $set = array(
                            'arge_sort' => $val['arge_sort'],
                            'arge_e_id' => $expertInfo[$val['arge_sort']]['eid'],
                            'arge_create_time' => time()
                        );
                        $arge_model->updateById($set,$val['arge_id']);
                        unset($expertInfo[$val['arge_sort']]);
                    }else{
                        $del_id[] = $val['arge_id'];
                    }
                }
                if(!empty($del_id)){
                    $expert_where = array();
                    $expert_where[] = array('name' => 'arge_id','oper' => 'in' , 'value' => $del_id);
                    $expert_where[] = array('name' => 'arge_s_id','oper' => '=' , 'value' => $this->curr_sid);
                    $expert_where[] = array('name' => 'arge_g_id','oper' => '=' , 'value' => $id);
                    $arge_model->deleteValue($expert_where);
                }
            }
            if(!empty($expertInfo)){
                $insert = [];
                foreach ($expertInfo as $val){
                    $insert[] = " (NULL, '{$this->curr_sid}',  '{$id}', '{$val['eid']}', '{$val['sort']}','".time()."')";
                }
                $arge_model->insertBatch($insert);
            }
        }else{
            $where = array();
            $where[] = array('name' => 'arge_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'arge_g_id','oper' => '=' , 'value' => $id);
            $arge_model->deleteValue($where);
        }
    }

    
    private function _get_custom_category(){
        $result = array(
            'kind1' => 0,
            'kind2' => 0,
        );
        $kind2 = $this->request->getIntParam('g_kind2');
        if($kind2){
            $category_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
            $row            = $category_model->getRowUpdateByIdSid($kind2,$this->curr_sid);
            $result['kind1']= $row['sk_fid'];
            $result['kind2']= $row['sk_id'];
        }else{
            $result['kind1']= 1;
            $result['kind2']= 0;
        }
        return $result;
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

    
    private function math_price_stock_format(){
        $data   = array(
            'price' => 0,
            'format'=> 0,
        );
        $maxNum = $this->request->getIntParam('format-num');
        if($maxNum > 0){
            for($i=0; $i <= $maxNum; $i++){
                $price  = $this->request->getFloatParam('format_price_'.$i);
                $data['format'] = $data['format'] + 1;
                if($data['price'] == 0) $data['price'] = $price;
            }
        }

        $data['price'] = $this->request->getFloatParam('g_price');

        return $data;
    }

    
    private function batchGoodsFormat($goId,$is_add=0){
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
        $maxNum         = $this->request->getIntParam('format-num');
        $stockType      = $this->request->getIntParam('g_stock_type');
        $go_price       = $this->request->getFloatParam('g_price');
        $formatSort     = $this->request->getStrParam('format-sort');
        $sortArr        = explode(',',$formatSort);
        $totalStock     = 0;
        $stock          = 0;
        $format         = array();
        if($is_add){
            for($i=1; $i <= $maxNum; $i++){
                $name       = plum_sql_quote(plum_get_param('format_name_'.$i));
                $tem_price  = $this->request->getFloatParam('format_price_'.$i);
                $gift1      = $this->request->getIntParam('format_gift1_'.$i);
                $gift2      = $this->request->getIntParam('format_gift2_'.$i);
                $gift3      = $this->request->getIntParam('format_gift3_'.$i);
                $gift       = json_encode(array($gift1, $gift2, $gift3));
                $tem_stock  = $this->request->getIntParam('format_stock_'.$i);
                $tem_day_stock  = $this->request->getIntParam('format_day_stock_'.$i);

                $sort       = array_search('format_id_'.$i,$sortArr);
                $price      = $tem_price ? $tem_price : $go_price ;
                $stock      = $stockType==1?$tem_stock:$tem_day_stock;
                $dayStock   = $stockType==1?$tem_stock:$tem_day_stock;
                if($name && $price){
                    $format[]   = "(NULL, '{$this->curr_sid}', '{$goId}', '{$name}','{$price}','{$stock}','{$dayStock}','{$sort}', 0, '".time()."', '{$gift}')";
                    $totalStock = $totalStock + $stock;
                }
            }
        }else{
            $gf_id = array();
            for($i=0; $i <= $maxNum; $i++){
                $name    = plum_sql_quote($this->request->getStrParam('format_name_'.$i));
                $price   = $this->request->getFloatParam('format_price_'.$i);
                $id      = $this->request->getIntParam('format_id_'.$i);
                $gift1      = $this->request->getIntParam('format_gift1_'.$i);
                $gift2      = $this->request->getIntParam('format_gift2_'.$i);
                $gift3      = $this->request->getIntParam('format_gift3_'.$i);
                $stock   = $this->request->getIntParam('format_stock_'.$i);
                $dayStock = $this->request->getIntParam('format_day_stock_'.$i);
                $gift       = json_encode(array($gift1, $gift2, $gift3));
                if($name){
                    $sort       = array_search('format_id_'.$i,$sortArr);//gf_sort
                    $temp = array(
                        'gf_name'   => $name,
                        'gf_price'  => $price ? $price : $go_price,
                        'gf_sort'   => $sort,
                        'gf_stock'  => $stockType==1?$stock:$dayStock,
                        'gf_day_stock' => $stockType==1?$stock:$dayStock,
                        'gf_cake_gift' => $gift
                    );
                    if($id == 0){
                        $format[]   = "(NULL, '{$this->curr_sid}', '{$goId}', '{$temp['gf_name']}','{$temp['gf_price']}','{$temp['gf_stock']}','{$temp['gf_day_stock']}','{$temp['gf_sort']}', 0, '".time()."', '{$gift}')";

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
            $format_model->batchNewCakeSave($format);
        }
    }


    
    public function tradeListAction() {
        $where=array();
        $where[]= array('name'=>'t_meal_type','oper'=>'=','value'=>0);
        $this->show_trade_list_data($where);
        $this->_get_offline_store();

        $link   = array(
            'all'   => array(
                'id'    => 0,
                'label' => '全部'
            ),
            'tuan'   => array(
                'id'    => App_Helper_Trade::TRADE_WAIT_PAY_RETURN,
                'label' => '待成团'
            ),
            'hadpay'   => array(
                'id'    => App_Helper_Trade::TRADE_HAD_PAY,
                'label' => '预约中'
            ),
            'finish'   => array(
                'id'    => App_Helper_Trade::TRADE_FINISH,
                'label' => '已完成'
            ),
            'closed'   => array(
                'id'    => App_Helper_Trade::TRADE_CLOSED,
                'label' => '已关闭'
            ),
            'refund'   => array(
                'id'    => App_Helper_Trade::TRADE_REFUND,
                'label' => '已退款'
            ),
        );
        $this->_get_store_experts_list();
        $this->output['link'] = $link;
        $this->output['print'] = plum_parse_config('type','print');
        $this->output['tradePay'] =  App_Helper_Trade::$trade_pay_type;

        $where[]     = array('name'=>'t_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET );
        $this->output['todayTradeInfo'] = $this->_show_order_stat($where,true);
        $this->buildBreadcrumbs(array(
            array('title' => '订单列表', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/reservation/trade-list.tpl');
    }

    private function _get_store_experts_list(){
        $where      = array();
        $where[]    = array('name' => 'os_s_id','oper' => '=','value' =>$this->curr_sid);

        $store_model    = new App_Model_Store_MysqlStoreStorage($this->curr_sid);
        $sort = array('os_create_time' => 'DESC');
        $list = $store_model->getList($where,0,50,$sort);
        $store = array();
        if($list){
            foreach($list as $key => $val){
                $store[$val['os_id']] = $val['os_name'];
            }
        }

        $good_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $goods = $good_model->fetchShopGoodsListByKind(0, 100, 2, 0);
        $experts = array();
        foreach($goods as $val){
            $experts[$val['g_id']] = $val['g_name'];
        }

        $this->output['store'] = $store;
        $this->output['experts'] = $experts;
    }

    
    public function tradeDetailAction() {
        $this->output['tradePay'] = App_Helper_Trade::$trade_pay_type;
        $this->output['tradeType']= App_Helper_Trade::$trade_type;

        $this->show_trade_detail_data();
        $this->buildBreadcrumbs(array(
            array('title' => '订单列表', 'link' => '/wxapp/reservation/tradeList'),
            array('title' => '订单详情', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/reservation/trade-detail.tpl');
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
            $applet_cfg = $this->_get_cfg_by_menutype($this->menuType,$this->curr_sid);
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

    
    private function goods_category_son_data_shop($isJson=1){
        $category_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $first          = $category_model->getListBySid();
        $temp           = array();
        foreach($first as $val){
            if($val['sk_level'] == 1){
                $temp[$val['sk_id']] = array(
                    'id'        => $val['sk_id'],
                    'index'     => $val['sk_weight'],
                    'firstName' => $val['sk_name'],
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
    
    public function goodsShopAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => '#'),
        ));
        $this->_show_goods_list_data_shop();
        $this->_show_category_shop();
        $this->output['choseLink']  = $this->showTableLinkShop('goods');
        $this->displaySmarty('wxapp/reservation/goods-list-shop.tpl');
    }
    
    private function _show_goods_list_data_shop(){
        $where          = array();
        $where[]        = array('name' => 'g_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[]        = array('name' => 'g_type','oper' => 'in','value' => array(1,2));
        $where[]        = array('name' => 'g_kind1','oper' => '!=','value' => 1);
        $where[]        = array('name' => 'g_kind1','oper' => '!=','value' => 2);
        $where[]        = array('name' => 'g_kind2','oper' => '=','value' =>0);
        $output['name'] = $this->request->getStrParam('name');
        if($output['name']){
            $where[] = array('name' => 'g_name','oper' => 'like','value' =>"%{$output['name']}%");
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
        $output['list'] = $list;
        $this->showOutput($output);
    }

    
    private function _show_category_shop(){
        $category_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $first          = $category_model->getListBySidFirst();
        $category       = array();
        foreach($first as $val){
            $category[$val['sk_id']] = $val['sk_name'];
        }
        $this->output['category']   =$category ;
    }
    
    public function addGoodShopAction(){
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
        $this->_show_category_shop();
        $this->output['row']    = $row;
        $this->output['format'] =  $format;
        $this->output['slide'] =  $slide;
        $this->output['formatNum']  = $formatNum;
        $this->output['formatSort'] = implode(',',$sort);

        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => '/wxapp/reservation/goodsShop'),
            array('title' => '添加商品', 'link' => '#'),
        ));
        $template_storage = new App_Model_Shop_MysqlShopDeliveryTemplateStorage();
        $sort = array('sdt_update_time' => 'DESC');
        $where = array();
        $where[] = array('name' => 'sdt_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'sdt_es_id', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'sdt_deleted', 'oper' => '=', 'value' => 0);
        $tempList = $template_storage->getList($where, 0, 0, $sort);
        $this->output['tempList'] = $tempList;

        $this->displaySmarty("wxapp/reservation/add-good-shop.tpl");
    }


    
    private function showTableLinkShop($type,$param=array()){
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
                        'href'  => '/wxapp/reservation/tradeList?status=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/wxapp/reservation/tradeList?status=nopay'.$extra,
                        'key'   => 'nopay',
                        'label' => '待付款'
                    ),
                    array(
                        'href'  => '/wxapp/reservation/tradeList?status=pay'.$extra,
                        'key'   => 'pay',
                        'label' => '已付款'
                    ),
                    array(
                        'href'  => '/wxapp/reservation/tradeList?status=complete'.$extra,
                        'key'   => 'complete',
                        'label' => '已完成'
                    ),
                    array(
                        'href'  => '/wxapp/reservation/tradeList?status=refund'.$extra,
                        'key'   => 'refund',
                        'label' => '已退款'
                    ),
                    array(
                        'href'  => '/wxapp/reservation/tradeList?status=close'.$extra,
                        'key'   => 'close',
                        'label' => '已关闭'
                    ),
                );
                break;
            case 'goods' :
                $link = array(
                    array(
                        'href'  => '/wxapp/reservation/goodsShop?status=sell'.$extra,
                        'key'   => 'sell',
                        'label' => '出售中'
                    ),
                    array(
                        'href'  => '/wxapp/reservation/goodsShop?status=depot'.$extra,
                        'key'   => 'depot',
                        'label' => '已下架'
                    ),
                );
                break;
            case 'settled' :
                $link = array(
                    array(
                        'href'  => '/wxapp/reservation/settled?status=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/wxapp/reservation/settled?status=doing'.$extra,
                        'key'   => 'doing',
                        'label' => '进行中'
                    ),
                    array(
                        'href'  => '/wxapp/reservation/settled?status=refund'.$extra,
                        'key'   => 'refund',
                        'label' => '退款'
                    ),
                    array(
                        'href'  => '/wxapp/reservation/settled?status=success'.$extra,
                        'key'   => 'success',
                        'label' => '成功'
                    ),
                );
                break;


        }
        return $link;
    }
    
    public function roomListAction(){
        $page = $this->request->getIntParam('page');
        $index = $page*$this->count;
        $where = array();
        $where[]    = array('name' =>'amt_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $sort = array('amt_create_time'=>'DESC');
        $table_model = new App_Model_Meal_MysqlMealTableStorage($this->curr_sid);
        $total = $table_model->getCount($where);
        $page_lib    = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['page_html'] = $page_lib->render();
        $list = array();
        if($index<$total){
            $list = $table_model->getList($where,$index,$this->count,$sort);
        }
        $this->output['list']  = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '包间设置', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/appointment/room-list.tpl');
    }

    

}