<?php


class App_Controller_Wxapp_MealController extends App_Controller_Wxapp_OrderCommonController {

    public function __construct() {
        parent::__construct();
    }


    public function indexAction() {
        $this->secondLink('index');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '秒杀管理', 'link' => '/wxapp/limit/cfg'),
            array('title' => '秒杀活动', 'link' => '#'),
        ));
        $this->full_list_data();

        $this->displaySmarty('wxapp/meal/list.tpl');
    }

    
    private function full_list_data(){
        $page       = $this->request->getIntParam('page');
        $output['status'] = $this->request->getStrParam('status','all');
        $index      = $page * $this->count;
        $where      = array();
        $where[]    = array('name' => 'la_s_id', 'oper' => '=', 'value' => $this->curr_sid);
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
        $this->showOutput($output);
    }


    
    public function mealTemplateAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '小程序首页模板', 'link' => '#'),
        ));
        $cfg = plum_parse_config('category','applet');
        $tpl_ids = $cfg[4]['tpl'];



        $tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $list       = $tpl_model->getListByTidSidType($tpl_ids,$this->curr_sid,3);
        if( $this->menuType=='toutiao')
            $applet_cfg = new App_Model_Toutiao_MysqlToutiaoCfgStorage($this->curr_sid);
        else
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
        $this->displaySmarty('wxapp/meal/meal-template.tpl');
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
            if( $this->menuType=='toutiao')
                $applet_cfg = new App_Model_Toutiao_MysqlToutiaoCfgStorage($this->curr_sid);
            else
                $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
            $exist = $applet_cfg->findShopCfg();
            if(!$exist){
                $set['ac_s_id']=$this->curr_sid;
                $ret=$applet_cfg->insertValue($set);
            }else
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


    
    public function indexTplAction(){
        $tpl_id  = $this->request->getIntParam('tpl', 12);
        $new = $this->request->getIntParam('new');
        $this->showIndexTpl($tpl_id);
        $this->showActivity($tpl_id);
        $this->showShopTplSlide($tpl_id);
        $this->_show_tpl_environment();
        $this->_show_goods_list();
        $this->_shop_information();
        $this->_show_store_list(true,true);

        $store_model = new App_Model_Meal_MysqlMealStoreStorage($this->curr_sid);
        $where[] = array('name' => 'ams_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $store   = $store_model->getRow($where);
        $store['ams_brief'] = mb_substr($store['ams_brief'],0,28).'...';
        $this->output['store'] = $store;

        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/meal/index-tpl_'.$tpl_id.'_new.tpl');
    }

    
    private function _show_tpl_environment(){
        $environment_storage = new App_Model_Meal_MysqlMealEnvironmentStorage($this->curr_sid);
        $environment_list = $environment_storage->fetchEnvironmentShowList();
        $json = array();
        if($environment_list){
            foreach($environment_list as $key => $val){
                $json[] = array(
                    'index'        => $val['ame_weight'] ,
                    'imgsrc'       => $val['ame_img'],
                );
            }
        }
        $this->output['environmentList'] = json_encode($json);
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
        $list        = $goods_model->fetchShopGoodsList($this->curr_sid, 0, 50, null, 1, $sort);
        $info        = array();
        if($list){
            foreach ($list as $val){
                $info[] = $this->_format_goods_details($val);
            }
        }
        $this->output['recommendList'] = json_encode($info);
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

        $this->displaySmarty('wxapp/meal/add.tpl');
    }

    
    public function secondLink($type='index'){
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
                'link'  => '/wxapp/limit/index',
                'active'=> 'index'
            ),
            array(
                'label' => '秒杀订单',
                'link'  => '/wxapp/limit/order',
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
        }
        $this->output['link']       = $link;
        $this->output['linkType']   = $type;
        $this->output['snTitle']    = '秒杀';
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
                'price'  => $val['lg_yh_price'],
            );
        }
        $this->output['goods'] = $goods;
    }

    
    private function showIndexTpl($tpl_id=12){
        $tpl_model = new App_Model_Meal_MysqlMealIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid($tpl_id);
        if(empty($tpl)){
            $tpl = array(
                'ami_title'         => '首页',
                'ami_address'       => '这里填写公司地址',
                'ami_lng'           => '113.72052',
                'ami_lat'           => '34.77485',
                'ami_tpl_id'        => $tpl_id,
                'ami_out_on'        => 1,
                'ami_eat_on'        => 1,
                'ami_appo_on'       => 1,
                'ami_payment_money' => 0,
                'ami_tableware_fee' => 0,
                'ami_logo_show'     => 1,
                'ami_intro_open'    => 1
            );
        }
        $tpl['ami_open_time'] = explode('-', $tpl['ami_open_time']);
        $tpl['ami_address'] = str_replace(array("\r\n", "\r", "\n"), "", $tpl['ami_address']);
        $tpl['ami_label']     = json_decode($tpl['ami_label'], true);
        $this->output['shop'] = $this->shops[$this->curr_sid];
        $this->output['tpl']  = $tpl;
        $this->output['labelList']  = $tpl['ami_new_label']?$tpl['ami_new_label']:json_encode(array());
        $navList = json_decode($tpl['ami_nav_list'],true);
        foreach($navList as $key => $val){
            $navList[$key]['open'] = ($val['open']=='true'?true:false);
        }
        if($tpl_id == 55){
            $this->output['navList']  = $navList?json_encode($navList):json_encode(array(
            array(
                'index' => 0,
                'open' => true,
                'title'=> '预约',
                'imgsrc'=> '/public/wxapp/meal/images/appointment.png'
            ),
            array(
                'index' => 1,
                'open'=> true,
                'title'=> '点餐',
                'imgsrc'=> '/public/wxapp/meal/images/meal.png'
            ),
            array(
                'index' => 2,
                'open'=> true,
                'title'=> '外卖',
                'imgsrc'=> '/public/wxapp/meal/images/takeout.png'
            ),
            array(
                'index' => 3,
                'open'=> true,
                'title'=> '优惠券',
                'imgsrc'=> '/public/wxapp/meal/images/coupon.png'
            ),
        ));
        }else {
            if($navList && !$navList[6]){
                $navList[6] = array(
                    'index' => "6",
                    'open' => false,
                    'title' => '排号',
                    'imgsrc' => '/public/wxapp/meal/images/queue.png'
                );
            }

            $this->output['navList'] = $navList ? json_encode($navList) : json_encode([
                [
                    'index' => 0,
                    'open' => TRUE,
                    'title' => '预约',
                    'imgsrc' => '/public/wxapp/meal/images/appointment.png'
                ],
                [
                    'index' => 1,
                    'open' => TRUE,
                    'title' => '点餐',
                    'imgsrc' => '/public/wxapp/meal/images/meal.png'
                ],
                [
                    'index' => 2,
                    'open' => TRUE,
                    'title' => '外卖',
                    'imgsrc' => '/public/wxapp/meal/images/takeout.png'
                ],
                [
                    'index' => 3,
                    'open' => TRUE,
                    'title' => '收银台',
                    'imgsrc' => '/public/wxapp/meal/images/cash.png'
                ],
                [
                    'index' => 4,
                    'open' => TRUE,
                    'title' => '会员充值',
                    'imgsrc' => '/public/wxapp/meal/images/bag.png'
                ],
                [
                    'index' => 5,
                    'open' => TRUE,
                    'title' => '优惠券',
                    'imgsrc' => '/public/wxapp/meal/images/coupon.png'
                ],
                [
                    'index' => 6,
                    'open' => TRUE,
                    'title' => '排号',
                    'imgsrc' => '/public/wxapp/meal/images/queue.png'
                ],
            ]);
        }
    }

    
    private function showActivity($tpl_id=12){
        $activity_storage = new App_Model_Meal_MysqlMealFullActivityStorage($this->curr_sid);
        $list = $activity_storage->findListBySid();
        $fullName = '';
        foreach ($list as $key => $value) {
            if($value['amf_type'] == 1){
                $fullName .= $value['amf_name'].',';
                unset($list[$key]); 
            }
        }
        $fullName = rtrim($fullName, ",");
        array_unshift($list, array('amf_type' => 1, 'amf_name' => $fullName));
        $this->output['activityList'] = json_encode($list);
    }
    private function _save_meal_environment(){
        $environmentList = $this->request->getArrParam('environmentList');
        $environment_storage = new App_Model_Meal_MysqlMealEnvironmentStorage($this->curr_sid);
        if(!empty($environmentList)){
            $environment_list = $environment_storage->fetchEnvironmentShowList();
            if(!empty($environment_list)){
                $del_id = array();
                foreach($environment_list as $val){
                    if(isset($environmentList[$val['ame_weight']])){
                        $set = array(
                            'ame_weight'            => $environmentList[$val['ame_weight']]['index'],
                            'ame_img'              => $environmentList[$val['ame_weight']]['imgsrc'],
                        );
                        $up_ret = $environment_storage->updateById($set,$val['ame_id']);
                        unset($environmentList[$val['ame_weight']]);
                    }else{
                        $del_id[] = $val['ame_id'];
                    }
                }
                if(!empty($del_id)){
                    $activity_where = array();
                    $activity_where[] = array('name' => 'ame_id','oper' => 'in' , 'value' => $del_id);
                    $activity_where[] = array('name' => 'ame_es_id','oper' => '=' , 'value' => 0);
                    $del_ret = $environment_storage->deleteValue($activity_where);
                }

            }
            if(!empty($environmentList)){
                $insert = array();
                foreach($environmentList as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}', 0,'{$val['imgsrc']}','{$val['index']}','".time()."') ";
                }
                $ins_ret = $environment_storage->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'ame_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'ame_es_id','oper' => '=' , 'value' => 0);
            $del     = $environment_storage->deleteValue($where);
        }
        if($up_ret || $ins_ret || $del_ret || $del){
            return true;
        }else{
            return false;
        }
    }

    
    private function _update_tpl($data, $tpl_id){
        $tpl_model = new App_Model_Meal_MysqlMealIndexStorage($this->curr_sid);
        $tpl_row   = $tpl_model->findUpdateBySid($tpl_id);
        if(!empty($tpl_row)){
            $tpl_ret = $tpl_model->findUpdateBySid($tpl_id,$data);
        }else{
            $tpl['ami_create_time']= time();
            $tpl_ret = $tpl_model->insertValue($data);
        }
        return $tpl_ret;
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
        if(in_array($this->wxapp_cfg['ac_type'],[4,7, 27])){
            $independent = 1;
        }else{
            $independent = 0;
        }
        $this->_show_goods_list_data();
        $this->_show_category();
        $this->output['choseLink']  = $this->showTableLink('goods');
        $this->output['g_sold_type'] = [
            0   => '通用',
            1   => '外卖',
            2   => '门店'
        ];
        $this->displaySmarty('wxapp/meal/goods-list.tpl');
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
                        'href'  => '/wxapp/meal/tradeList?status=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/wxapp/meal/tradeList?status=nopay'.$extra,
                        'key'   => 'nopay',
                        'label' => '待付款'
                    ),
                    array(
                        'href'  => '/wxapp/meal/tradeList?status=pay'.$extra,
                        'key'   => 'pay',
                        'label' => '已付款'
                    ),
                    array(
                        'href'  => '/wxapp/meal/tradeList?status=complete'.$extra,
                        'key'   => 'complete',
                        'label' => '已完成'
                    ),
                    array(
                        'href'  => '/wxapp/meal/tradeList?status=refund'.$extra,
                        'key'   => 'refund',
                        'label' => '已退款'
                    ),
                    array(
                        'href'  => '/wxapp/meal/tradeList?status=close'.$extra,
                        'key'   => 'close',
                        'label' => '已关闭'
                    ),
                );
                break;
            case 'goods' :
                $link = array(
                    array(
                        'href'  => '/wxapp/meal/goods?status=sell'.$extra,
                        'key'   => 'sell',
                        'label' => '出售中'
                    ),
                    array(
                        'href'  => '/wxapp/meal/goods?status=depot'.$extra,
                        'key'   => 'depot',
                        'label' => '已下架'
                    ),
                );
                break;
            case 'settled' :
                $link = array(
                    array(
                        'href'  => '/wxapp/meal/settled?status=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/wxapp/meal/settled?status=doing'.$extra,
                        'key'   => 'doing',
                        'label' => '进行中'
                    ),
                    array(
                        'href'  => '/wxapp/meal/settled?status=refund'.$extra,
                        'key'   => 'refund',
                        'label' => '退款'
                    ),
                    array(
                        'href'  => '/wxapp/meal/settled?status=success'.$extra,
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
        $where[]        = array('name' => 'g_es_id','oper' => '=','value' =>0);
        $where[]        = array('name' => 'g_type','oper' => 'in','value' => array(1,2));
        $where[]        = array('name' => 'g_independent_mall','oper' => '=','value' => 0);
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
            $sort = array('g_weight' => 'DESC', 'g_update_time' => 'DESC');
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

    
    private function _show_category(){
        $category_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $first          = $category_model->getListBySid();
        $category       = array();
        foreach($first as $val){
            $category[$val['sk_id']] = $val['sk_name'];
        }
        $this->output['category']   =$category ;
    }

    
    public function addGoodAction(){
        $id  = $this->request->getIntParam('id');
        $row = array(); $slide = array();$format = array();
        $formatNum = 0;
        $sort      = array();
        if($id){
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            $row = $goods_model->getRowByIdSid($id,$this->curr_sid);
            if(!empty($row)){
                $format_model   = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
                $format         = $format_model->getListByGid($row['g_id']);
                $slide_model    = new App_Model_Goods_MysqlGoodsSlideStorage($this->curr_sid);
                $slide          = $slide_model->getSlideByGid($row['g_id']);
                if($format){
                    $formatNum = count($format) - 1;
                    for($i=0 ; $i <= $formatNum ; $i ++){
                        $sort[] = 'format_id_'.$i;
                    }
                }

            }
        }
        $this->_show_category();
        $this->output['row']    = $row;
        $this->output['format'] =  $format;
        $this->output['slide']  =  $slide;
        $this->output['formatNum']  = $formatNum;
        $this->output['formatSort'] = implode(',',$sort);

        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => '/wxapp/meal/goods'),
            array('title' => '添加商品', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/meal/add-good.tpl");
    }


    
    public function saveGoodAction(){
        $result = array(
            'ec' => 400,
            'em' => '请填写完整商品数据'
        );
        $temp_psf = $this->math_price_stock_format();
        $id       = $this->request->getIntParam('id');
        $joinAct  = $this->request->getStrParam('g_join_act');
        $data['g_name']         = $this->request->getStrParam('g_name');
        $data['g_price']        = $temp_psf['price'];
        $data['g_has_format']   = $temp_psf['format'];
        $data['g_unified_fee']  = $this->request->getFloatParam('g_unified_fee');
        $data['g_cover']        = $this->request->getStrParam('g_cover');
        $data['g_weight']       = $this->request->getIntParam('g_weight');
        $data['g_stock_show']   = 1;
        $data['g_join_act']     = ($joinAct == 'on' || $joinAct == 1)? 1 : 0;
        $data['g_kind1']        = $this->request->getIntParam('g_kind1');
        $data['g_s_id']         = $this->curr_sid;
        $data['g_update_time']  = time();
        $istop                  = $this->request->getStrParam('g_is_top');
        $data['g_is_top']       = ($istop == 'on' || $istop == 1)? 1 : 0;
        $format                 = $this->request->getIntParam('format-num');
        $data['g_detail']       = $this->request->getStrParam('g_detail');
        $data['g_sold']         = $this->request->getIntParam('g_sold');
        $data['g_sold_type']    = $this->request->getIntParam('g_sold_type');
        $data['g_stock_type']   = $this->request->getIntParam('g_stock_type');
        if($data['g_stock_type'] == 1){
            $data['g_stock']        = $this->request->getIntParam('g_stock');
            $data['g_day_stock']    = $this->request->getIntParam('g_stock');
        }else{
            $data['g_stock']        = $this->request->getIntParam('g_day_stock');
            $data['g_day_stock']    = $this->request->getIntParam('g_day_stock');
        }


        if($data['g_name'] && (($data['g_price'] && $format == 0) || $format > 0)){
            $is_add = 0;
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            if($id){
                $ret = $goods_model->getRowUpdateByIdSid($id,$this->curr_sid,$data);
            }else{
                $ret = $goods_model->insertValue($data);
                $id  = $ret;
                $is_add = 1;
            }
            if($ret){
                $this->batchSlide($id,$is_add);
                $this->batchGoodsFormat($id,$is_add);
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功',
                );
                App_Helper_OperateLog::saveOperateLog("商品【{$data['g_name']}】保存成功");
            }else{
                $result['em'] = '保存失败';
            }
        }
        $this->displayJson($result);
    }

    
    private function math_price_stock_format(){
        $data   = array(
            'price' => 0,
            'format'=> 0,
        );
        $maxNum = $this->request->getIntParam('format-num');
        for($i=0; $i <= $maxNum; $i++){
            $price  = $this->request->getFloatParam('format_price_'.$i);
            $data['format'] = $data['format'] + 1;
            if($data['price'] == 0) $data['price'] = $price;
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
                $tem_stock  = $this->request->getIntParam('format_stock_'.$i);
                $tem_day_stock  = $this->request->getIntParam('format_day_stock_'.$i);

                $sort       = array_search('format_id_'.$i,$sortArr);
                $price      = $tem_price ? $tem_price : $go_price ;
                $stock      = $stockType==1?$tem_stock:$tem_day_stock;
                $dayStock   = $stockType==1?$tem_stock:$tem_day_stock;
                if($name && $price){
                    $format[]   = "(NULL, '{$this->curr_sid}', '{$goId}', '{$name}','{$price}','{$stock}','{$dayStock}','{$sort}', 0, '".time()."')";
                    $totalStock = $totalStock + $stock;
                }
            }
        }else{
            $gf_id = array();
            for($i=0; $i <= $maxNum; $i++){
                $name    = plum_sql_quote($this->request->getStrParam('format_name_'.$i));
                $price   = $this->request->getFloatParam('format_price_'.$i);
                $stock   = $this->request->getIntParam('format_stock_'.$i);
                $dayStock = $this->request->getIntParam('format_day_stock_'.$i);
                $id      = $this->request->getIntParam('format_id_'.$i);
                if($name){
                    $sort       = array_search('format_id_'.$i,$sortArr);//gf_sort
                    $temp = array(
                        'gf_name'   => $name,
                        'gf_price'  => $price ? $price : $go_price,
                        'gf_sort'   => $sort,
                        'gf_stock'  => $stockType==1?$stock:$dayStock,
                        'gf_day_stock' => $stockType==1?$stock:$dayStock
                    );
                    if($id == 0){
                        $format[]   = "(NULL, '{$this->curr_sid}', '{$goId}', '{$temp['gf_name']}','{$temp['gf_price']}','{$temp['gf_stock']}','{$temp['gf_day_stock']}','{$temp['gf_sort']}', 0, '".time()."')";
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
            $format_model->batchNewSave($format);
        }
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

    
    public function tradeListAction() {
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        $cfg        = $applet_cfg->findShopCfg();
        $this->output['indexTpl'] = $cfg['ac_index_tpl'];
        if($cfg['ac_index_tpl'] == 55 || $cfg['ac_index_tpl'] == 0){
            $store_model = new App_Model_Meal_MysqlMealStoreStorage($this->curr_sid);
            $store_list = $store_model->fetchStoreList(array(),0,50,array('ams_update_time' => 'DESC'));
            $this->output['storeList'] = $store_list;

        }
        $where_trade[] = $where[] = ['name' => 't_independent_mall', 'oper' => '=', 'value' => 0];
        $this->show_trade_list_data($where_trade);
        $this->output['print'] = plum_parse_config('type','print');
        $this->output['tradePay'] =  App_Helper_Trade::$trade_pay_type;

        $where[] = array('name'=>'t_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET );
        $this->output['todayTradeInfo'] = $this->_show_order_stat($where,true);
        $this->buildBreadcrumbs(array(
            array('title' => '订单列表', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/meal/trade-list.tpl');
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
            array('title' => '商城订单', 'link' => '/wxapp/meal/tradeList'),
            array('title' => '订单详情', 'link' => '#'),
        ));
        $feie_model = new App_Model_Feie_MysqlFeieListStorage($this->curr_sid);
        $printlist = $feie_model->findListBySid();
        $this->output['printlist'] = $printlist;
        $this->displaySmarty('wxapp/meal/trade-detail.tpl');
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

            if($row['t_legwork_num'] > 0){
                if(date('Y-m-d',$row['t_pay_time']) == date('Y-m-d')){
                    $row['legworkNum'] = '今日 '.$row['t_legwork_num'].'号';
                }else{
                    $row['legworkNum'] = date('Y年m月d日').$row['t_legwork_num'].'号';
                }
            }

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
            if($this->wxapp_cfg['ac_type'] == 4){
                $output['statusNote'][2] = "待商家接单";
                $output['statusNote'][3] = "商家已接单";
            }
            $output['legworkStatusNote'] = App_Helper_Legwork::$trade_status_note;
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
                if($row['t_express_method'] == 7){
                    $desc = array(
                        'icon'      => '!',
                        'class'     => 'primary',
                        'desc'      => '<div>骑手已接单，等待骑手取货</div>'
                    );
                }else{
                    $desc = array(
                        'icon'      => '!',
                        'class'     => 'primary',
                        'desc'      => '<div>已发货、等待用户确认收货。</div>'
                    );
                }
                break;
            case App_Helper_Trade::TRADE_ACCEPT:
                if($row['t_express_method'] == 7){
                    $desc = array(
                        'icon'      => '!',
                        'class'     => 'primary',
                        'desc'      => '<div>骑手已取货</div>'
                    );
                }
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

    
    public function createStoreQrcodeAction(){
        $esId = $this->request->getIntParam('esId');
        $es_model = new App_Model_Entershop_MysqlEnterShopStorage($this->curr_sid);
        $row = $es_model->findShopBySid($esId);
        $cover = $row['es_logo'];
        $url = $this->_create_store_qrcode($esId,$cover);
        if($url){
            $es_model->updateById(array('es_qrcode'=>$url),$esId);
        }
        $res = array('ec'=> 200,'em'=> '创建成功！','url'=> $url);
        $this->displayJson($res);
    }

    
    private function _create_store_qrcode($esId,$cover = ''){

        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        $str = "esId=".$esId;
        $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::MEAL_STORE_DETAIL_PATH, 210 , $cover);
        return $url;
    }

    
    public function downloadStoreQrcodeAction() {
        $esId = $this->request->getIntParam('esId');
        if($esId){
            $es_model = new App_Model_Entershop_MysqlEnterShopStorage($this->curr_sid);
            $row = $es_model->findShopBySid($esId);
            $file       = PLUM_DIR_ROOT.$row['es_qrcode'];
            $filesize   = filesize($file);
            $filename   = $row['es_name'].".jpg";

            plum_send_http_header("Content-type: application/octet-stream");
            plum_send_http_header("Accept-Ranges: bytes");
            plum_send_http_header("Accept-Length:".$filesize);
            plum_send_http_header("Content-Disposition: attachment; filename=".$filename);

            readfile($file);
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
                    $insert[] =  " (NULL, '{$this->curr_sid}','{$val['title']}','','{$val['articleId']}','{$val['articleTitle']}','{$val['index']}','".time()."') ";
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

    
    private function _show_store_list($json=true,$indexTpl=false){
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $where      = array();
        $where[]    = array('name' => 'ams_s_id','oper' => '=','value' =>$this->curr_sid);
        $output['name'] = $this->request->getStrParam('name');
        if($output['name']){
            $where[]    = array('name' => 'ams_name','oper' => 'like','value' =>"%{$output['name']}%");
        }

        $store_model    = new App_Model_Meal_MysqlMealStoreStorage($this->curr_sid);
        if($indexTpl){
            $sort = array('ams_create_time' => 'DESC');
            $list = $store_model->fetchStoreList($where,0,4,$sort);
        }else{
          $total          = $store_model->getCount($where);
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['paginator'] = $pageCfg->render();
        $list   = array();
        if($index <= $total){
            $sort = array('ams_create_time' => 'DESC');
            $list = $store_model->fetchStoreList($where,$index,$this->count,$sort);
        }
        }

        if($json){
            $this->output['storeList'] = json_encode($list);
        }else{
            $this->output['storeList'] = $list;
        }
    }

    
    public function storeListAction(){
        $this->_show_store_list(false);
        $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->curr_sid);
        $appcfg = $appletPay_Model->findRowPay();
        $this->output['maid'] = $appcfg['ap_shop_percentage'];
        $this->output['curr_domain'] = plum_get_server('http_host');
        $ext_query = '?';
        if($this->curr_sid == 7448){
            $ext_query .= 'notcheackmobile=1&';
        }
        $ext_query = rtrim($ext_query,'?');
        $ext_query = rtrim($ext_query,'&');
        $this->output['ext_query'] = $ext_query;

        $this->buildBreadcrumbs(array(
            array('title' => '店铺门店管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/meal/store-list.tpl');
    }

    
    public function addStoreAction(){
        $esId     = $this->request->getIntParam('esId',0);
        $row    = array();

        if($esId){
            $store_model = new App_Model_Meal_MysqlMealStoreStorage($this->curr_sid);
            $row         = $store_model->fetchStoreDetail($esId);
            $slide_model    = new App_Model_Entershop_MysqlEnterShopSlideStorage($esId);
            $slide          = $slide_model->getSlideList();
            $this->output['slide'] = $slide;
        }
        $this->output['row'] = $row;
        $this->buildBreadcrumbs(array(
            array('title' => '店铺门店管理', 'link' => '/wxapp/meal/storeList'),
            array('title' => '添加门店', 'link' => '#'),
        ));
        $other_cfg = new App_Model_Legwork_MysqlOtherLegworkCfgStorage($this->curr_sid);
        $legworkCfg = $other_cfg->findUpdateBySidEsId(0);
        $shopLegworkCfg = [];
        if($esId){
            $shopLegworkCfg = $other_cfg->findUpdateBySidEsId($esId);
        }
        $this->output['legworkCfg'] = $legworkCfg;
        $this->output['shopLegworkCfg'] = $shopLegworkCfg;

        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty("wxapp/meal/add-store.tpl");
    }

    
    public function batchShopSlide($esId){
        $store_model    = new App_Model_Entershop_MysqlEnterShopSlideStorage($esId);
        $maxNum         = $this->request->getStrParam('slideImgNum');
        $slide          = array();

        $sl_id = array();
        for($i=0; $i<= $maxNum; $i++){
            $temp    = plum_sql_quote(plum_get_param('slide_'.$i));
            $temp_id = $this->request->getIntParam('slide_id_'.$i);
            if($temp && $temp_id == 0){
                $slide[] = $temp;
            }
            if($temp_id){
                $sl_id[] = $temp_id;
            }
        }
        $del_id = array();
        $old_slide = $store_model->getListBySid($esId);
        foreach($old_slide as $val){
            if(!in_array($val['ess_id'],$sl_id)){
                $del_id[] = $val['ess_id'];
            }
        }
        if(count($slide) <= count($del_id)){
            for($d=0 ; $d < count($del_id) ; $d++){
                if(isset($slide[$d])){
                    $store_model->updateSlide($del_id[$d],$slide[$d]);
                    unset($del_id[$d]);
                }
            }
            if(!empty($del_id)){
                $store_model->deleteSlide($del_id);
            }
        }else{
            $batch_slide = array();
            for($s=0 ; $s < count($slide) ; $s++){
                if(isset($del_id[$s])){
                    $store_model->updateSlide($del_id[$s],$slide[$s]);
                    unset($slide[$s]);
                }else{
                    $sTemp = plum_sql_quote($slide[$s]);
                    $batch_slide[] = "(NULL, '{$esId}', '{$sTemp}',0 , 0, '".time()."')";
                }
            }
            if(!empty($batch_slide)){
                $store_model->batchSave($batch_slide);
            }
        }
    }

    private function _save_hotel_service($id){
        $serviceList = $this->request->getArrParam('service');
        $service_storage = new App_Model_Hotel_MysqlHotelServiceStorage($this->curr_sid);
        if(!empty($serviceList)){
            $service_list = $service_storage->findListBySid($id,1);
            if(!empty($service_list)){
                $del_id = array();
                foreach($service_list as $key => $val){
                    if(isset($serviceList[$val['ams_weight']])){
                        $set = array(
                            'ams_weight'     => $key,
                            'ams_name'       => $serviceList[$val['ams_weight']]['name'],
                            'ams_icon'       => $serviceList[$val['ams_weight']]['icon'],
                        );
                        $up_ret = $service_storage->updateById($set,$val['ams_id']);
                        unset($serviceList[$val['ams_weight']]);
                    }else{
                        $del_id[] = $val['ams_id'];
                    }
                }
                if(!empty($del_id)){
                    $service_where = array();
                    $service_where[] = array('name' => 'ams_id','oper' => 'in' , 'value' => $del_id);
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
            $where[] = array('name' => 'ams_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'ams_type','oper' => '=' , 'value' => 1);
            $where[] = array('name' => 'ams_f_id','oper' => '=' , 'value' => $id);
            $del     = $service_storage->deleteValue($where);
        }
        if($up_ret || $ins_ret || $del_ret || $del){
            return true;
        }else{
            return false;
        }
    }

    
    public function delStoreAction(){
        $id   = $this->request->getIntParam('id');
        $esId   = $this->request->getIntParam('esId');
        $set    = array(
            'ams_deleted' => 1
        );
        $store_model = new App_Model_Meal_MysqlMealStoreStorage($this->curr_sid);
        $row = $store_model->getRowById($id);
        $ret = $store_model->getRowUpdateByIdSid($id,$this->curr_sid,$set);
        if($ret && $esId){

            $es_model = new App_Model_Entershop_MysqlEnterShopStorage($esId);
            $set_es = array(
                'es_deleted' => 1
            );
            $es_model->updateById($set_es,$esId);
            $esm_model = new App_Model_Entershop_MysqlManagerStorage();
            $where_manager[] = array('name'=>'esm_es_id','oper'=> '=','value'=>$esId);
            $where_manager[] = array('name'=>'esm_s_id','oper'=> '=','value'=>$this->curr_sid);
            $esm_model->deleteValue($where_manager);

        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("门店【{$row['ams_title']}】删除成功");
        }

        $this->showAjaxResult($ret,'删除');
    }

    
    public function withdrawAction(){
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $where      = array();
        $where[]    = array('name' => 'esw_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $output['audit'] = $this->request->getStrParam('audit','all');
        switch($output['audit']){
            case 'success':
                $where[] = array('name' => 'esw_status','oper' => '=','value' =>1);
                break;
            case 'refuse':
                $where[] = array('name' => 'esw_status','oper' => '=','value' =>2);
                break;
            case 'doing':
                $where[] = array('name' => 'esw_status','oper' => '=','value' =>0);
                break;
        }
        $output['start'] = $this->request->getStrParam('start');
        $start           = strtotime($output['start']);
        if($start){
            $where[]     = array('name' => 'esw_create_time','oper' => '>=','value' =>$start);
        }
        $output['end']   = $this->request->getStrParam('end');
        $end             = strtotime($output['end']);
        if($end){
            $where[] = array('name' => 'esw_create_time','oper' => '<=','value' =>$end);
        }

        $withdraw_model = new App_Model_Entershop_MysqlEnterShopWithdrawStorage();
        $total          = $withdraw_model->getShopBankCount($where);
        $page_libs      = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['pageHtml'] =$page_libs->render();

        $list = array();
        if($total > $index){
            $withdraw   = $withdraw_model->getShopBankList($where,$index,$this->count);
            $list       = $withdraw;
        }
        $output['list'] = $list;
        $this->output['choseLink'] = array(
            array(
                'href'  => '/wxapp/meal/withdraw?audit=all',
                'key'   => 'all',
                'label' => '全部'
            ),
            array(
                'href'  => '/wxapp/meal/withdraw?audit=doing',
                'key'   => 'doing',
                'label' => '审核中'
            ),
            array(
                'href'  => '/wxapp/meal/withdraw?audit=success',
                'key'   => 'success',
                'label' => '成功'
            ),
            array(
                'href'  => '/wxapp/meal/withdraw?audit=refuse',
                'key'   => 'refuse',
                'label' => '拒绝'
            ),
        );
        $tpl_model = new App_Model_Meal_MysqlMealIndexStorage($this->curr_sid);
        $tpl = $tpl_model->findUpdateBySid($this->wxapp_cfg['ac_index_tpl']?$this->wxapp_cfg['ac_index_tpl']:12);
        $this->output['tpl'] = $tpl;
        $this->output['status'] = array(0=>'进行中',1=>'成功',2=>'失败');
        $this->showOutput($output);
        $this->buildBreadcrumbs(array(
            array('title' => '提现列表', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/meal/withdraw.tpl');
    }

    
    public function saveWithdrawLimitAction(){
        $res = array(
            'ec' => 400 ,
            'em' => '保存失败',
        );
        $limit = $this->request->getIntParam('limit');
        $tpl_model = new App_Model_Meal_MysqlMealIndexStorage($this->curr_sid);
        $row = $tpl_model->findUpdateBySid($this->wxapp_cfg['ac_index_tpl']?$this->wxapp_cfg['ac_index_tpl']:12);
        if($row){
            $set = array(
                'ami_withdraw_limit' => $limit
            );
            $ret = $tpl_model->findUpdateBySid($this->wxapp_cfg['ac_index_tpl']?$this->wxapp_cfg['ac_index_tpl']:12,$set);
            if($ret){
                $res = array(
                    'ec' => 200 ,
                    'em' => '保存成功',
                );
                App_Helper_OperateLog::saveOperateLog("商家最低提现金额【{$limit}】保存成功");
            }
        }else{
            $res = array(
                'ec' => 400 ,
                'em' => '保存失败，请先配置社区主页',
            );
        }
        $this->displayJson($res);

    }
    
    public function saveWithdrawRateAction(){
        $res = array(
            'ec' => 400 ,
            'em' => '保存失败',
        );
        $rate = $this->request->getIntParam('rate');
        $tpl_model = new App_Model_Meal_MysqlMealIndexStorage($this->curr_sid);
        $row = $tpl_model->findUpdateBySid($this->wxapp_cfg['ac_index_tpl']?$this->wxapp_cfg['ac_index_tpl']:12);
        if($row){
            $set = array(
                'ami_withdraw_rate' => $rate
            );
            $ret = $tpl_model->findUpdateBySid($this->wxapp_cfg['ac_index_tpl']?$this->wxapp_cfg['ac_index_tpl']:12,$set);
            if($ret){
                $res = array(
                    'ec' => 200 ,
                    'em' => '保存成功',
                );
                App_Helper_OperateLog::saveOperateLog("商家提现百分比【{$rate}%】保存成功");
            }
        }else{
            $res = array(
                'ec' => 400 ,
                'em' => '保存失败，请先配置社区主页',
            );
        }
        $this->displayJson($res);

    }

    
    public function auditWithdrawAction(){
        $res = array(
            'ec' => 400 ,
            'em' => '审核失败',
        );
        $id     = $this->request->getIntParam('id');
        $status = $this->request->getIntParam('status');
        $note   = $this->request->getStrParam('note');
        if($id && $status){
            $set = array(
                'esw_status'     => $status,
                'esw_audit_note' => $note,
                'esw_audit_time' => time(),
            );
            $withdraw_storage = new App_Model_Entershop_MysqlEnterShopWithdrawStorage(0);
            $ret = $withdraw_storage->updateById($set,$id);
            if($ret){
                $row = $withdraw_storage->getRowById($id);
                $shop_model = new App_Model_Entershop_MysqlEnterShopStorage();
                $balanceRet = $shop_model->changeBalanceWithdraw($row['esw_es_id'],$row['esw_amount'],$status);
                if($status == 1 && $balanceRet){
                    $shop = $shop_model->getRowById($row['esw_es_id']);
                    $this->withdraw_record_save($row['esw_es_id'],$row['esw_amount'],$shop['es_balance']);
                }
                $res = array(
                    'ec' => 200,
                    'em' => '审核成功',
                );
                $str = $status == 1 ? '通过' : '不通过';
                App_Helper_OperateLog::saveOperateLog("处理商家提现申请成功，处理结果：{$str}");
            }
        }else{
            $res['em'] = '提现状态错误';
        }
        $this->displayJson($res);
    }

    private function withdraw_record_save($sid,$money,$balance){
        $data = array(
            'si_s_id'   => $this->curr_sid,
            'si_es_id'   => $sid,
            'si_name'   => '账户提现',
            'si_amount' => floatval($money),
            'si_balance'=> $balance,
            'si_type'   => 2,
            'si_create_time'   => time()
        );
        $shop_inout_model = new App_Model_Shop_MysqlShopInoutStorage(0);
        $ret = $shop_inout_model->insertValue($data);
    }
    private function _compress_download_file($zipfile='全部餐桌二维码.zip',$shopId = 0){
        $result = array(
            'ec' => 400,
            'em' => '无法创建压缩文件'
        );
        $list_model = new App_Model_Meal_MysqlMealTableStorage($this->curr_sid);
        if($shopId >= 0){
            $where[] = ['name' => 'amt_es_id','oper' => '=','value' =>$shopId];
        }
        $where[] = ['name' => 'amt_s_id','oper' => '=','value' =>$this->curr_sid];
        $filelist    = $list_model->getList($where,0,0);

        $zipname    = PLUM_APP_BUILD.'/'.$zipfile;
        if(file_exists($zipname)){
            unlink($zipname);
        }
        $zip = new ZipArchive();
        if($zip->open($zipname,ZipArchive::CREATE)!==TRUE){
            $result['em'] = '无法打开文件，或者文件创建失败';
            return $result;
        }

        if(!empty($filelist)){
            foreach($filelist as $val){
                $filepath = PLUM_DIR_ROOT.$val['amt_applet_code'];
                $filename = $val['amt_table'].'.jpg';
                if(file_exists($filepath)){
                    $zip->addFile($filepath,$filename);//用原文件名覆盖 防止保留文件目录结构
                }
            }
        }
        $zip->close();
        if(!file_exists($zipname)){
            $result['em'] = '无法找到文件';
            return $result;
        }else{
            return array(
                'ec' => 200,
                'em' => '压缩文件创建成功',
                'file' => str_replace('/wwwdata/www/fenxiaobao','',$zipname)
            );
        }
    }

    
    public function tradeRefundAction($isActivity = ''){
        $tradeType = $this->request->getStrParam('tradeType');
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
            array('title' => '商城订单', 'link' => '/wxapp/meal/tradeList'),
            array('title' => '订单维权', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/order/trade-refund.tpl');
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

    
    public function changeBelongAction(){
        $id = $this->request->getIntParam('id');
        $mid = $this->request->getIntParam('mid');

        $res = FALSE;
        if($id && $mid){
            $shop_model = new App_Model_Meal_MysqlMealStoreStorage($this->curr_sid);
            $where_row[] = array('name' => 'ams_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where_row[] = array('name' => 'ams_m_id', 'oper' => '=', 'value' => $mid);
            $row = $shop_model->getRow($where_row);
            if($row){
                $this->displayJsonError('该用户已有绑定店铺');
            }
            $set = array(
                'ams_m_id' => $mid
            );
            $where[] = array('name' => 'ams_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[] = array('name' => 'ams_id', 'oper' => '=', 'value' => $id);
            $res = $shop_model->updateValue($set,$where);
            if($res){
                $shop = $shop_model->getRowById($id);
                if($shop['ams_es_id'] > 0){
                    $es_model = new App_Model_Entershop_MysqlEnterShopStorage();
                    $es_model->updateById(['es_m_id' => $mid],$shop['ams_es_id']);
                }
            }
            if($res){
                $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                $member = $member_model->getRowById($mid);
                $nickname = $member['m_nickname'];
                App_Helper_OperateLog::saveOperateLog("修改门店【{$row['ams_title']}】绑定用户【{$nickname}】");
            }
        }

        $this->showAjaxResult($res,'修改');
    }

    
    private function utf8_orderstr_to_unicode($utf8_str) {
        $unicode_str = '';
        for($i=0;$i<mb_strlen($utf8_str);$i++){
            $val = mb_substr($utf8_str,$i,1,'utf-8');
            if(strlen($val) >= 4){
                $unicode = (ord($val[0]) & 0xF) << 18;
                $unicode |= (ord($val[1]) & 0x3F) << 12;
                $unicode |= (ord($val[2]) & 0x3F) << 6;
                $unicode |= (ord($val[3]) & 0x3F);
                $unicode_str.= '';
            }else{
                $unicode_str.=$val;
            }
        }
        $unicode_str = $this->_filter_character($unicode_str);
        return $unicode_str;
    }

    
    private function _filter_character($nickname) {
        $nickname = preg_replace('/[\x{1F600}-\x{1F64F}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{1F300}-\x{1F5FF}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{1F680}-\x{1F6FF}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{2600}-\x{26FF}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{2700}-\x{27BF}]/u', '', $nickname);
        $nickname = preg_replace('/[=]/u', '', $nickname);
        $nickname = str_replace(array('"','\''), '', $nickname);
        $nickname  = addslashes(trim($nickname));
        return $nickname;
    }

    
    public function changeCateAction(){
        $ids = $this->request->getStrParam('ids');
        $kind1 = $this->request->getIntParam('custom_cate');
        $id_arr = plum_explode($ids);

        $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
        foreach ($id_arr as $value){
            $update = array('g_kind1' => $kind1);    
            $ret = $goods_model->updateValue($update, [
                ['name'=>'g_id','oper'=>'=','value'=>$value],
                ['name'=>'g_s_id','oper'=>'=','value'=>$this->curr_sid]
            ]);
        }

        $result = array(
            'ec' => 200,
            'em' => '修改成功'
        );
        $this->displayJson($result);
    }
}