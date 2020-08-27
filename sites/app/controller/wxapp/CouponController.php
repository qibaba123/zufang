<?php

class App_Controller_Wxapp_CouponController extends App_Controller_Wxapp_LinkcommonController {
    private $couponCenter;
    public function __construct(){
        parent::__construct();

        if(in_array($this->wxapp_cfg['ac_type'],[6,8])){
            $this->couponCenter = 1;
        }else{
            $this->couponCenter = 0;
        }
        $this->output['couponCenter'] = $this->couponCenter;
    }

    
    public function secondLink($type='coupon'){
        $link = array(
            array(
                'label' => '优惠券',
                'link'  => '/wxapp/coupon/index',
                'active'=> 'coupon'
            )
        );
        if($this->couponCenter == 1){
            array_push($link,array(
                'label' => '商家优惠券',
                'link'  => '/wxapp/coupon/shopCoupon',
                'active'=> 'shopCoupon'
            ));
        }
        $this->output['secondLink'] = $link;
        $this->output['linkType']   = $type;
        $this->output['snTitle']    = '优惠券';
    }
    public function cashAction() {
        $this->secondLink('coupon');
        $cfg        = $this->wxapp_cfg;
        $this->output['shopType']    = $cfg['ac_type'];
        $this->output['sh_id']=$this->curr_sid;

        $this->_show_coupon_list_data();
        $this->secondLinkCash('cash');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '优惠券', 'link' => '/wxapp/coupon/cash'),
            array('title' => '优惠券管理', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/cash/coupon-list.tpl");
    }

    public function indexAction() {
        $this->secondLink('coupon');
        $cfg        = $this->wxapp_cfg;
        $this->output['shopType']    = $cfg['ac_type'];
        $this->output['sh_id']=$this->curr_sid;

        $this->_show_coupon_list_data();
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '优惠券', 'link' => '/wxapp/coupon/index'),
            array('title' => '优惠券管理', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/coupon/coupon-list.tpl");
    }

    public function leaderCouponAction() {

        $this->output['couponType'] = 3;
        $this->_show_coupon_list_data(3);
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '团长优惠券', 'link' => '/wxapp/coupon/leaderCoupon'),
            array('title' => '优惠券管理', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/coupon/coupon-list.tpl");
    }


    public function shopCouponAction() {
        $this->secondLink('shopCoupon');
        $cfg        = $this->wxapp_cfg;
        $this->output['shopType']    = $cfg['ac_type'];
        $this->output['sh_id']=$this->curr_sid;

        $this->_show_shop_coupon_list_data();
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '优惠券', 'link' => '/wxapp/coupon/index'),
            array('title' => '商家优惠券', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/coupon/shop-coupon-list.tpl");
    }


    private function _show_coupon_list_data($type = 0){
        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $where = array();
        $where[] = array('name' => 'cl_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[] = array('name' => 'cl_es_id','oper' => '=','value' =>0);
        $output['name']     = $this->request->getStrParam('name');
        if($output['name']){
            $where[] = array('name' => 'cl_name','oper' => 'like','value' =>"%{$output['name']}%");
        }
        $output['status'] = $this->request->getStrParam('status','all');
        switch($output['status']){
            case 'nostart':
                $where[] = array('name' => 'cl_status','oper' => '>','value' =>0);
                break;
            case 'receive':
                $where[] = array('name' => 'cl_status','oper' => '=','value' =>1);
                break;
            case 'end':
                $where[] = array('name' => 'cl_status','oper' => '=','value' =>2);
                break;
        }
        $type_value=[4];
        array_push($type_value,$type);
        if($type){
            if($this->wxapp_cfg['ac_type']==21){
                $where[] = array('name' => 'cl_coupon_type','oper' => 'in','value' =>$type_value);
            }else
                $where[] = array('name' => 'cl_coupon_type','oper' => '=','value' =>$type);
        }else{
            if($this->wxapp_cfg['ac_type']==21){
                $where[] = array('name' => 'cl_coupon_type','oper' => 'in','value' =>$type_value);
            }else
                $where[] = array('name' => 'cl_coupon_type','oper' => '=','value' =>0);
        }

        $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
        $total          = $coupon_model->getCount($where);
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $list   = array();
        if($index <= $total){
            $sort = array('cl_update_time' => 'DESC');
            $list = $coupon_model->getList($where,$index,$this->count,$sort);
            foreach($list as &$val){
                $val['link'] = $this->composeLink('coupon','detail',array('cid'=>$val['cl_id']),true,'info');
                if($val['cl_end_time'] <= time()){
                    $val['edit'] = 0;
                }else{
                    $val['edit'] = 1;
                }
            }
        }
        $output['paginator'] = $pageCfg->render();
        $output['list']      = $list;
        $timeNow = time();
        $where_total = $where_expire = $where_going = [];
        $where_total[] = $where_expire[] = $where_going[] = ['name' => 'cl_s_id','oper' => '=','value' =>$this->curr_sid];
        $where_total[] = $where_expire[] = $where_going[] = ['name' => 'cl_es_id','oper' => '=','value' =>0];
        $where_total[] = $where_expire[] = $where_going[] = ['name' => 'cl_coupon_type','oper' => '=','value' =>0];
        $where_expire[] = ['name' => 'cl_end_time','oper' => '<','value' =>$timeNow];
        $where_going[] = ['name' => 'cl_start_time','oper' => '<','value' =>$timeNow];
        $where_going[] = ['name' => 'cl_end_time','oper' => '>','value' =>$timeNow];
        $total = $coupon_model->getCount($where_total);
        $total_expire = $coupon_model->getCount($where_expire);
        $total_going = $coupon_model->getCount($where_going);
        $output['statInfo'] = [
            'total' => intval($total),
            'expire' => intval($total_expire),
            'going' => intval($total_going)
        ];
        $receive_model = new App_Model_Coupon_MysqlReceiveStorage($this->curr_sid);
        $usedStat = $receive_model->getReceiveStat($where_total,'used');
        $goingStat = $receive_model->getReceiveStat($where_total,'going');
        $expireStat = $receive_model->getReceiveStat($where_total,'expire');
        $output['statInfo']['usedTotal'] = intval($usedStat['total']);
        $output['statInfo']['usedMoney'] = floatval($usedStat['money']);
        $output['statInfo']['goingTotal'] = intval($goingStat['total']);
        $output['statInfo']['goingMoney'] = floatval($goingStat['money']);
        $output['statInfo']['expireTotal'] = intval($expireStat['total']);
        $output['statInfo']['expireMoney'] = floatval($expireStat['money']);

        $this->showOutput($output);
    }

    private function _show_shop_coupon_list_data(){
        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $where = array();
        $where[] = array('name' => 'cl_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[] = array('name' => 'cl_es_id','oper' => '>','value' =>0);
        $output['name']     = $this->request->getStrParam('name');
        if($output['name']){
            $where[] = array('name' => 'cl_name','oper' => 'like','value' =>"%{$output['name']}%");
        }
        $output['shopName']     = $this->request->getStrParam('shopName');
        if($output['shopName']){
            if($this->wxapp_cfg['ac_type'] == 6){
                $where[] = array('name' => 'acs_name','oper' => 'like','value' =>"%{$output['shopName']}%");
            }else{
                $where[] = array('name' => 'es_name','oper' => 'like','value' =>"%{$output['shopName']}%");
            }

        }
        $output['status'] = $this->request->getStrParam('status','all');
        switch($output['status']){
            case 'nostart':
                $where[] = array('name' => 'cl_status','oper' => '>','value' =>0);
                break;
            case 'receive':
                $where[] = array('name' => 'cl_status','oper' => '=','value' =>1);
                break;
            case 'end':
                $where[] = array('name' => 'cl_status','oper' => '=','value' =>2);
                break;
        }
        $where[] = array('name' => 'cl_coupon_type','oper' => '=','value' =>0);
        $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
        if($this->wxapp_cfg['ac_type'] == 6){
            $where[]=['name'=>'acs_deleted','oper'=>'=','value'=>0];
            $total = $coupon_model->getCityShopCount($where);
        }else{
            $where[] =['name'=>'es_deleted','oper'=>'=','value'=>0];
            $total = $coupon_model->getCommunityShopCount($where);
        }
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $list   = array();
        if($index <= $total){
            $sort = array('cl_update_time' => 'DESC');
            if($this->wxapp_cfg['ac_type'] == 6){
                $where[]=['name'=>'acs_deleted','oper'=>'=','value'=>0];
                $list = $coupon_model->getCityShopList($where,$index,$this->count,$sort);
            }else{
                $list = $coupon_model->getCommunityShopList($where,$index,$this->count,$sort);
            }
            foreach($list as &$val){
                $val['link'] = $this->composeLink('coupon','detail',array('cid'=>$val['cl_id']),true,'info');
                if($val['cl_end_time'] <= time()){
                    $val['edit'] = 0;
                }else{
                    $val['edit'] = 1;
                }
            }
        }
        $output['paginator'] = $pageCfg->render();
        $output['list']      = $list;
        $timeNow = time();
        $where_total = $where_expire = $where_going = [];
        $where_total[] = $where_expire[] = $where_going[] = ['name' => 'cl_s_id','oper' => '=','value' =>$this->curr_sid];
        $where_total[] = $where_expire[] = $where_going[] = ['name' => 'cl_es_id','oper' => '>','value' =>0];
        $where_total[] = $where_expire[] = $where_going[] = ['name' => 'cl_coupon_type','oper' => '=','value' =>0];
        $where_expire[] = ['name' => 'cl_end_time','oper' => '<','value' =>$timeNow];
        $where_going[] = ['name' => 'cl_start_time','oper' => '<','value' =>$timeNow];
        $where_going[] = ['name' => 'cl_end_time','oper' => '>','value' =>$timeNow];
        $total = $coupon_model->getCount($where_total);
        $total_expire = $coupon_model->getCount($where_expire);
        $total_going = $coupon_model->getCount($where_going);
        $output['statInfo'] = [
            'total' => intval($total),
            'expire' => intval($total_expire),
            'going' => intval($total_going)
        ];
        $receive_model = new App_Model_Coupon_MysqlReceiveStorage($this->curr_sid);
        $usedStat = $receive_model->getReceiveStat($where_total,'used');
        $goingStat = $receive_model->getReceiveStat($where_total,'going');
        $expireStat = $receive_model->getReceiveStat($where_total,'expire');
        $output['statInfo']['usedTotal'] = intval($usedStat['total']);
        $output['statInfo']['usedMoney'] = floatval($usedStat['money']);
        $output['statInfo']['goingTotal'] = intval($goingStat['total']);
        $output['statInfo']['goingMoney'] = floatval($goingStat['money']);
        $output['statInfo']['expireTotal'] = intval($expireStat['total']);
        $output['statInfo']['expireMoney'] = floatval($expireStat['money']);

        $this->showOutput($output);
    }

    
    public function addAction(){
        $this->secondLink('coupon');
        $id   = $this->request->getIntParam('id');
        $this->output['cash'] = $this->request->getStrParam('cash');
        $couponType = $this->request->getIntParam('couponType');
        $this->output['couponType'] = $couponType;

        $row = array();
        if($id){
            $coupon_model = new App_Model_Coupon_MysqlCouponStorage();
            $row = $coupon_model->getRowByIdSid($id,$this->curr_sid);
            if(!empty($row)){
                $row['cl_use_desc'] = plum_textarea_html_to_line($row['cl_use_desc']);
                $this->show_goods_by_actId($row['cl_id'],$row['cl_use_type']);
            }
        }
        $cfg        = $this->wxapp_cfg;
        $this->output['shopType']    = $cfg['ac_type'];
        $this->output['row']    = $row;
        if($this->output['cash']) {
            $this->buildBreadcrumbs(array(
                array('title' => '优惠券列表', 'link' => '/wxapp/coupon/cash'),
                array('title' => '优惠券添加', 'link' => '#'),
            ));
        } else {
            $this->buildBreadcrumbs(array(
                array('title' => '优惠券管理', 'link' => '/wxapp/coupon/index'),
                array('title' => '优惠券添加', 'link' => '#'),
            ));
        }


        if($this->wxapp_cfg['ac_type'] == 21 || $this->wxapp_cfg['ac_type'] == 8 || $this->wxapp_cfg['ac_type'] == 6){
            $this->displaySmarty("wxapp/coupon/coupon-add-new.tpl");
        }else{
            $this->displaySmarty("wxapp/coupon/coupon-add.tpl");
        }
    }

    
    private function show_goods_by_actId($actid,$type){
        $goods   = array();
        if($type == 2){
            $goods_model    = new App_Model_Coupon_MysqlCouponGoodsStorage($this->curr_sid);
            $goods_list     = $goods_model->getListByActid($actid);
            foreach($goods_list as $val){
                $goods[] = array(
                    'id'    => $val['cg_id'],
                    'gid'   => $val['g_id'],
                    'gname' => $val['g_name'],
                );
            }
        }

        $this->output['goods'] = $goods;
    }

    
    public function saveAction(){
        $id     = $this->request->getIntParam('id');

        $field  = array('face_val','use_limit','use_type','count','receive_limit','receive_day_limit','sort');
        $data   = $this->getIntByField($field,'cl_');

        $data['cl_name']         = $this->request->getStrParam('name');
        $index                   = $this->request->getIntParam('index_show');
        $newLimit                = $this->request->getIntParam('new_limit');
        $needShare               = $this->request->getIntParam('needShare');



        $data['cl_shop_show']    = $index ? 1 : 0;
        $data['cl_new_limit']    = $newLimit ? 1 : 0;
        $data['cl_need_share']   = $needShare ? 1 : 0;

        $start  = $this->request->getStrParam('start');//开始时间
        $end    = $this->request->getStrParam('end');
        if(!$start || !$end){
            $this->displayJsonError('请选择领券时间');
        }
        $data['cl_start_time']   = strtotime($start);
        $data['cl_end_time']     = strtotime($end);
        $useEnd    = $this->request->getStrParam('useEnd');
        $data['cl_use_end_time']     = $useEnd?strtotime($useEnd):strtotime($end);
        $data['cl_use_time_type']    = $this->request->getIntParam('useTimeType', 1);
        $data['cl_use_days']         = $this->request->getIntParam('useDays');
        $data['cl_need_points']  = $this->request->getIntParam('needPoints');
        $couponType              = $this->request->getIntParam('couponType');
        $tradeLimit              = $this->request->getIntParam('tradeLimit');
        $data['cl_coupon_receive_limit']=$tradeLimit;
        if($couponType){
            $data['cl_coupon_type'] = $couponType;
            if($data['cl_coupon_type']==4){
                $data['cl_shop_show']    = 0;
                if($tradeLimit <= 0)
                    $this->displayJsonError('满减券需要填写订单满减金额');
            }
        }
        $data['cl_update_time']  = time();
        $descTemp   = $this->request->getStrParam('use_desc');
        $data['cl_use_desc'] = plum_textarea_line_to_html($descTemp);
        if($data['cl_face_val'] < 1){
            $this->displayJsonError('优惠券面值不得小于1元');
        }
        if($data['cl_use_limit'] < 0){
            $this->displayJsonError('使用条件填写错误');
        }
        if($data['cl_count'] < 1 && $couponType != 3 && !in_array($data['cl_coupon_type'],[1,4])){
            $this->displayJsonError('发放总量不得小于1');
        }
        if($data['cl_receive_limit'] < 0){
            $this->displayJsonError('单人领取错误');
        }
        if($data['cl_receive_day_limit'] < 0){
            $this->displayJsonError('每人每日领取错误');
        }
        if(!in_array($data['cl_status'],array(0,1,2))){
            $this->displayJsonError('状态错误');
        }
        $coupon_model = new App_Model_Coupon_MysqlCouponStorage();
        if($id){
            $ret = $coupon_model->getRowUpdateByIdSid($id,$this->curr_sid,$data);
        }else{
            $data['cl_s_id']        = $this->curr_sid;
            $data['cl_create_time'] = time();
            $ret = $coupon_model->insertValue($data);
            $id  = $ret;
        }
        App_Helper_OperateLog::saveOperateLog("优惠券【".$data['cl_name']."】保存成功");
        if($id && $ret) $this->deal_can_used_goods($id);
        $this->showAjaxResult($ret);
    }

    
    private function deal_can_used_goods($newid){
        $old_act_id   = $this->request->getIntParam('id');
        $goods        = $this->request->getArrParam('goods');
        $use_type     = $this->request->getIntParam('use_type');
        if($use_type == 0){
            $use_type = 1;
        }
        $goods_model  = new App_Model_Coupon_MysqlCouponGoodsStorage($this->curr_sid);
        if($use_type == 1){
            $goods_model->deleteHasExist($newid);
        }else{
            $goods_model  = new App_Model_Coupon_MysqlCouponGoodsStorage($this->curr_sid);
            $insert       = array();
            foreach($goods as $val){
                $gid = intval($val['gid']);
                $id  = intval($val['id']);
                if($id){
                    $has_id[] = $val['id'];
                    $set      = array(
                        'cg_g_id'         => $gid,
                        'cg_create_time' => $_SERVER['REQUEST_TIME'],
                    );
                    $goods_model->getRowUpdateByIdSid($id,$this->curr_sid,$set);
                }else{
                    $insert[] = "(null,{$this->curr_sid},{$newid},{$gid},{$_SERVER['REQUEST_TIME']})";
                }
            }
            if(isset($has_id) && $old_act_id){
                $goods_model->deleteHasExist($old_act_id,$has_id,'not in');
            }
            if(!empty($insert)){
                $goods_model->insertBacth($insert);
            }
        }

    }

    
    public function receiveAction(){
        $esId = $this->request->getIntParam('esid',0);
        $cash = $this->request->getStrParam('cash');

        if($cash == 'cash') {
            $this->buildBreadcrumbs(array(
                array('title' => '优惠券', 'link' => '/wxapp/coupon/cash'),
                array('title' => '领取明细', 'link' => '#'),
            ));
        } else {
            if($esId > 0){
                $this->buildBreadcrumbs(array(
                    array('title' => '商家优惠券', 'link' => '/wxapp/coupon/shopCoupon'),
                    array('title' => '领取明细', 'link' => '#'),
                ));
                $this->secondLink('shopCoupon');
            }else{
                $this->buildBreadcrumbs(array(
                    array('title' => '优惠券管理', 'link' => '/wxapp/coupon/index'),
                    array('title' => '领取明细', 'link' => '#'),
                ));
                $this->secondLink('coupon');
            }
        }
        $this->output['esId'] = $esId;

        $this->_show_coupon_receive_data();

        $this->displaySmarty("wxapp/coupon/coupon-receive.tpl");
    }

    private function _show_coupon_receive_data(){
        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $type   = $this->request->getIntParam('type');
        $esId = $this->request->getIntParam('esid',0);

        $where = array();
        $where[] = array('name' => 'cl_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[] = array('name' => 'cl_es_id','oper' => '=','value' =>$esId);
        if($type ==1){
            $where[] = array('name' => 'cr_receive_type','oper' => '=','value' =>1);
        }else{
            $where[] = array('name' => 'cr_receive_type','oper' => '=','value' =>0);
        }
        $output['cid']  = $this->request->getIntParam('cid');
        if($output['cid']){
            $where[]    = array('name' => 'cr_c_id','oper' => '=','value' =>$output['cid']);
        }
        $output['name'] = $this->request->getStrParam('name');
        if($output['name']){
            $where[]    = array('name' => 'cl_name','oper' => 'like','value' =>"%{$output['name']}%");
        }
        $output['nickname'] = $this->request->getStrParam('nickname');
        if($output['nickname']){
            $where[]    = array('name' => 'm_nickname','oper' => 'like','value' =>"%{$output['nickname']}%");
        }


        $receive_model  = new App_Model_Coupon_MysqlReceiveStorage();
        $total          = $receive_model->getReceiveCount($where);
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $list   = array();
        if($index <= $total){
            $sort = array('cr_receive_time' => 'DESC');
            $list = $receive_model->getReceiveList($where,$index,$this->count,$sort);
        }
        $output['paginator'] = $pageCfg->render();
        $output['list']      = $list;
        $this->showOutput($output);
    }

    
    public function deleteCouponAction(){
        $id = $this->request->getIntParam('id');
        if($id){
            $coupon_model = new App_Model_Coupon_MysqlCouponStorage();
            $coupon = $coupon_model->getRowById($id);
            $ret = $coupon_model->deleteById($id);
            if($ret){
                App_Helper_OperateLog::saveOperateLog("优惠券【".$coupon['cl_name']."】删除成功");
            }
        }
        $this->showAjaxResult($ret,'删除');
    }






    
    public function couponCenterAction(){
        $this->showShopTplSlide(0,12);
        $this->showIndexTpl();
        $this->_shop_information();
        $this->_shop_list();
        $this->_show_shop_list();
        $this->_get_list_for_select();
        $this->_ordinary_goods_group();
        $this->_shop_top_goods_list();
        $this->_limit_group();//秒杀商品分组
        $this->_shop_kind_list_for_select();
        $this->_curr_first_kind_list_for_select();
        $this->_curr_second_kind_list_for_select();
        $this->_shop_category(2);
        $this->_get_jump_list();
        $this->_get_information_category();
        $this->_get_goods_group();
        $this->_community_shop_kind_list_for_select();
        $this->showShopTplShortcut(-4);
        $this->show_city_shortcut(2);

        $page      = $this->_fetch_shop_outside();
        $page_data = $this->_fetch_page_data();

        $this->output['page_list'] = json_encode(array_merge($page,$page_data));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '优惠券管理', 'link' => '#'),
            array('title' => '领券大厅', 'link' => '#'),
        ));

        $this->displaySmarty('wxapp/coupon/coupon-center.tpl');
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

    
    private function showIndexTpl(){
        $tpl_model = new App_Model_Coupon_MysqlCouponCenterStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid();
        if(empty($tpl)){
            $tpl = array(
                'acc_title'         => '领券中心',
            );
        }
        $this->output['tpl'] = $tpl;
    }

    
    public function saveCouponCenterAction(){
        $head_title   = $this->request->getStrParam('headerTitle');
        $data = array(
            'acc_s_id'           => $this->curr_sid,
            'acc_title'          => $head_title,
            'acc_update_time'    => time()
        );

        $index_storage = new App_Model_Coupon_MysqlCouponCenterStorage($this->curr_sid);
        $index = $index_storage->findUpdateBySid();
        if($index){
            $ret = $index_storage->findUpdateBySid($data);
        }else{
            $data['acc_create_time'] = time();
            $ret = $index_storage->insertValue($data);
        }
        $this->save_shop_slide_new(0,12);
        $this->save_shop_shortcut_new(-4);
        if($ret){
            $result = array(
                'ec' => 200,
                'em' => '信息保存成功'
            );
            App_Helper_OperateLog::saveOperateLog("保存领券中心配置成功");
        }else{
            $result = array(
                'ec' => 400,
                'em' => '信息保存失败'
            );
        }
        $this->displayJson($result);
    }

    
    public function changeCouponInfoAction(){

        $result = array(
            'ec' => 400,
            'em' => '保存失败'
        );
        $id = $this->request->getIntParam('id');
        $field = $this->request->getStrParam('field');
        $value = $this->request->getIntParam('value');
        if($id && $field){
            $coupon_field = 'cl_'.$field;
            $set = array(
                $coupon_field => $value
            );
            $coupon_model = new App_Model_Coupon_MysqlCouponStorage();
            $coupon = $coupon_model->getRowById($id);
            $res = $coupon_model->getRowUpdateByIdSid($id,$this->curr_sid,$set);
            if($res){
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功'
                );
                App_Helper_OperateLog::saveOperateLog("优惠券【".$coupon['cl_name']."】修改成功");
            }
        }else{
            $result = array(
                'ec' => 400,
                'em' => '操作异常'
            );
        }
        $this->displayJson($result);
    }

    public function excelCouponStatisticAction(){
        $couponStatus = $this->request->getIntParam('couponStatus');
        $startDate  = $this->request->getStrParam('startDate');
        $startTime  = $this->request->getStrParam('startTime');
        $endDate    = $this->request->getStrParam('endDate');
        $endTime    = $this->request->getStrParam('endTime');

        if($startDate && $startTime && $endDate && $endTime){
            $start = $startDate.' '.$startTime;
            $end   = $endDate.' '.$endTime;
            $startTime  = strtotime($start);
            $endTime    = strtotime($end);

            $where = array();
            $where[] = array('name' => 'cl_s_id','oper' => '=','value' =>$this->curr_sid);
            $where[] = array('name' => 'cl_es_id','oper' => '=','value' =>0);
            if($couponStatus == 1){
                $where[]    = array('name' => 'cl_end_time','oper'=>'>','value'=>time());
            }

            if($couponStatus == 2){
                $where[]    = array('name' => 'cl_end_time','oper'=>'<=','value'=>time());
            }

            $where[] = array('name' => 'cl_coupon_type','oper' => '=','value' =>0);

            $coupon_model = new App_Model_Coupon_MysqlCouponStorage();
            $sort = array('cl_update_time' => 'DESC');
            $list = $coupon_model->getList($where, 0, 0, $sort);
            $receive_model  = new App_Model_Coupon_MysqlReceiveStorage();
            if(!empty($list)){
                $date       = date('Ymd',$_SERVER['REQUEST_TIME']);
                $rows  = array();
                $rows[]  = array('优惠券名称','面值','发放总量','领取数量','使用数量');
                $width   = array(
                    'A' => 20,
                    'B' => 20,
                    'C' => 20,
                    'D' => 20,
                    'E' => 20,
                );
                foreach($list as $key => $val){
                    $rows[] = array(
                        $val['cl_name'],
                        $val['cl_face_val'],
                        $val['cl_count'],
                        $receive_model->getReceiveTypeCount($this->curr_sid, 'receive', $val['cl_id'], $startTime, $endTime),
                        $receive_model->getReceiveTypeCount($this->curr_sid, 'used', $val['cl_id'], $startTime, $endTime),
                    );
                }
                $excel = new App_Plugin_PHPExcel_PHPExcelPlugin();
                $excel->down_common_excel($rows,$date.'优惠券统计数据.xls',$width);
            }else{
                plum_url_location('当前时间段内没有优惠券统计数据!');
            }
        }else{
            plum_url_location('日期请填写完整!');
        }
    }

    
    public function giftCouponAction(){
        $ids    = $this->request->getStrParam('ids');
        $coupon_id = $this->request->getIntParam('coupon_id');
        $id_arr = plum_explode($ids);
        $result = array(
            'ec' => 400,
            'em' => '未选择用户'
        );
        $now = time();
        if(!empty($id_arr)){
            $coupon_model = new App_Model_Coupon_MysqlCouponStorage();
            $coupon = $coupon_model->getRowById($coupon_id);

            if($coupon){
                if($coupon['cl_end_time'] == 0 || ($coupon['cl_end_time'] && $coupon['cl_end_time'] > $now)){
                    $left = $coupon['cl_count'] - $coupon['cl_had_receive'];
                    $gift_total = count($id_arr);
                    if($gift_total <= $left){
                        $exipre = $coupon['cl_use_time_type'] == 1?$coupon['cl_use_end_time']:strtotime("+".$coupon['cl_use_days']." days");

                        $insert = [];
                        foreach ($id_arr as $id){
                            $insert[] = " (NULL, '{$this->curr_sid}','{$coupon['cl_es_id']}', '{$id}', '{$coupon['cl_id']}','{$now}', '{$exipre}') ";
                        }
                        $receive_model = new App_Model_Coupon_MysqlReceiveStorage();
                        $res = $receive_model->batchSave($insert);
                        if($res){
                            $coupon_model->incrementReceiveCount($coupon['cl_id'], $gift_total);
                            $result = array(
                                'ec' => 200,
                                'em' => '赠送成功'
                            );
                        }else{
                            $result = array(
                                'ec' => 400,
                                'em' => '赠送失败'
                            );
                        }
                    }else{
                        $result = array(
                            'ec' => 400,
                            'em' => '赠送数量超过优惠券剩余数量'
                        );
                    }
                }else{
                    $result = array(
                        'ec' => 400,
                        'em' => '优惠券已经失效'
                    );
                }
            }else{
                $result = array(
                    'ec' => 400,
                    'em' => '优惠券不存在'
                );
            }
        }
        $this->displayJson($result);
    }


    
    public function secondLinkCash($type='cash'){
        $link = plum_parse_config('second_menu_coupon', 'cashier');
        $this->output['secondLink'] = $link;
        $this->output['linkType']   = $type;
        $this->output['snTitle']    = '优惠券';
    }




    
    public function rechargeCouponListAction() {

        $page  = $this->request->getIntParam('page', 0);
        $count = $this->count;
        $index = $count * $page;
        $model_crc = new App_Model_Cash_MysqlRechargeCouponStorage($this->curr_sid);

        $where[] = array('name'=>'crc_s_id', 'oper'=>'=', 'value'=>$this->curr_sid);

        $output['rid']   = $this->request->getIntParam('rid');
        if($output['rid']) {
            $where[] = array('name'=>'crc_r_id', 'oper'=>'=', 'value'=>$output['rid']);
        }
        $output['name'] = $this->request->getStrParam('name');
        if($output['name']) {
            $where[] = array('name'=>'cl_name', 'oper'=>'like', 'value'=>"%".$output['name']."%");
        }
        $output['Stype'] = $this->request->getIntParam('Stype');
        if($output['Stype']) {
            $where[] = array('name'=>'crc_type', 'oper'=>'=', 'value'=>$output['Stype']);
        }

        $sort = array('crc_create_time'=>'desc');
        $list  = $model_crc->getRechargeCouponList($where, $index, $count, $sort);
        $total = $model_crc->getRechargeCouponCount($where);

        $page_plugin = new Libs_Pagination_Paginator($total,$count,'jquery',1);
        $output['paginator'] = $page_plugin->render();
        $output['list']      = $list;
        $output['rv']        = $this->_get_rv();
        $output['type']      = $this->_get_coupon_type();
        $output['info']      = plum_parse_config('remind_info', 'cashier')['couponSend_info'];

        $this->showOutput($output);
        $this->secondLinkCash('rechargeCouponList');
        $this->buildBreadcrumbs(array(
            array('title' => '优惠券', 'link' => '/wxapp/coupon/cash'),
            array('title' => '赠送优惠券', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/cash/recharge-coupon-list.tpl");
    }
    private function _get_rv() {
        $recharge_model = new App_Model_Member_MysqlRechargeValueStorage($this->curr_sid);
        $list = $recharge_model->fetchValueList();
        $data = array();
        if($list) {
            foreach($list as $value) {
                $data[$value['rv_id']] = '充'.$value['rv_money'].'得'.$value['rv_coin'];
            }
        }
        return $data;
    }
    private function _get_coupon_type() {
        $model_cct = new App_Model_Cash_MysqlCouponTypeStorage($this->curr_sid);
        $where[] = array('name'=>'cct_s_id', 'oper'=>'=', 'value'=>$this->curr_sid);
        $list = $model_cct->getList($where, 0,0);

        $type = array();
        if($list) {
            foreach($list as $key => $value) {
                $type[$value['cct_type']] = $value['cct_name'];
            }
        }
        return $type;
    }


    
    public function couponTypeAction() {
        $page  = $this->request->getIntParam('page', 0);
        $count = $this->count;
        $index = $count * $page;

        $model_cct = new App_Model_Cash_MysqlCouponTypeStorage($this->curr_sid);
        $where = array();
        $where[] = array('name'=>'cct_s_id', 'oper'=>'=', 'value'=>$this->curr_sid);
        $output['name'] = $this->request->getStrParam('name');
        if($output['name']) {
            $where[] = array('name'=>'cct_name', 'oper'=>'like', 'value'=>'%'.$output['name'].'%');
        }

        $sort = array('cct_sort'=>'desc');
        $list  = $model_cct->getList($where, $index, $count, $sort);
        $total = $model_cct->getCount($where);

        $page_plugin = new Libs_Pagination_Paginator($total,$count,'jquery',1);
        $output['paginator'] = $page_plugin->render();
        $output['list']      = $list;
        $output['type']      = plum_parse_config('coupon_type', 'cashier');
        $output['info']      = plum_parse_config('remind_info', 'cashier')['couponCfg_info'];

        $this->showOutput($output);
        $this->secondLinkCash('couponType');
        $this->buildBreadcrumbs(array(
            array('title' => '优惠券', 'link' => '/wxapp/coupon/cash'),
            array('title' => '优惠券配置', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/cash/coupon-type.tpl');
    }

    
    public function saveCouponTypeAction() {
        $id   = $this->request->getIntParam('id');
        $type = $this->request->getIntParam('type');
        $sort = $this->request->getIntParam('sort', 0);
        $name = $this->request->getStrParam('name');

        if(in_array($type, array(1,2,3)) && $name) {
            $check = $this->_chech_coupon_type($type, $id);
            if($check) {
                $model_cct  = new App_Model_Cash_MysqlCouponTypeStorage($this->curr_sid);

                $data['cct_type'] = $type;
                $data['cct_sort'] = $sort;
                $data['cct_name'] = $name;
                if($id) {
                    $data['cct_update_time'] = time();
                    $ret = $model_cct->updateById($data, $id);
                } else {
                    $data['cct_s_id'] = $this->curr_sid;
                    $data['cct_create_time'] = time();
                    $data['cct_deleted']     = 0;
                    $ret = $model_cct->insertValue($data);
                }

                if($ret) {
                    $this->displayJsonSuccess(null, null, '操作成功');
                } else {
                    $this->displayJsonError('操作失败');
                }
            } else {
                $this->displayJsonError('同一分类不能重复添加');
            }
        } else {
            $this->displayJsonError('数据格式错误');
        }
    }
    private function _chech_coupon_type($type, $id=0) {
        $result = false;
        $model_cct = new App_Model_Cash_MysqlCouponTypeStorage($this->curr_sid);
        $where = array();
        $where[] = array('name'=>'cct_s_id', 'oper'=>'=', 'value'=>$this->curr_sid);
        $where[] = array('name'=>'cct_type', 'oper'=>'=', 'value'=>$type);
        $row = $model_cct->getRow($where);

        if(!$row || ($id && $id == $row['cct_id'])) {
            $result = true;
        }
        return $result;
    }

    
    public function delCouponTypeAction() {
        $id = $this->request->getIntParam('id');
        if($id) {
            $model_cct  = new App_Model_Cash_MysqlCouponTypeStorage($this->curr_sid);
            $set = array('cct_deleted'=>1);
            $ret = $model_cct->updateById($set, $id);

            if($ret) {
                $this->displayJsonSuccess(null, null, '操作成功');
            } else {
                $this->displayJsonError('操作失败');
            }
        } else {
            $this->displayJsonError('未找到该分类');
        }
    }
    public function couponGiftTestAction($mid, $total, $rid=0, $isNew=false) {
        $test  = $this->request->getIntParam('test');

        $mid = 5620179;
        $cid = 9025;
        $num = 4;

        $result = array();
        $model_crc = new App_Model_Cash_MysqlRechargeCouponStorage($this->curr_sid);

        if($isNew) {
            $where = array();
            $where[] = array('name'=>'crc_s_id', 'oper'=>'=', 'value'=>$this->curr_sid);
            $where[] = array('name'=>'crc_status', 'oper'=>'=', 'value'=>1);
            $where[] = array('name'=>'crc_type', 'oper'=>'=', 'value'=>1);
            $list = $model_crc->getList($where);

            $data = array();
            if($list) {
                foreach($list as $value) {
                    $data[] = $this->_coupon_gift($value['crc_c_id'], $value['crc_num'], $mid);
                }
            }

        } else {
            $list = $this->_get_coupon_cfg($total, $rid);
            $data = array();
            if($list) {
                foreach($list as $value) {
                    $data[] = $this->_coupon_gift($value['crc_c_id'], $value['crc_num'], $mid);
                }
            }
        }

        $result = $data;
        plum_msg_dump($result, 1);
    }
    private function _coupon_gift($cid, $num, $mid) {
        $coupon_model = new App_Model_Coupon_MysqlCouponStorage();
        $coupon = $coupon_model->getRowById($cid);
        $now = time();
        $result = array();
        if($coupon){
            if($coupon['cl_end_time'] == 0 || ($coupon['cl_end_time'] && $coupon['cl_end_time'] > $now)){
                $left = $coupon['cl_count'] - $coupon['cl_had_receive'];
                if($num <= $left){
                    $exipre = $coupon['cl_use_time_type'] == 1?$coupon['cl_use_end_time']:strtotime("+".$coupon['cl_use_days']." days");
                    $insert = [];
                    for($i=0; $i<$num; $i++) {
                        $insert[] = " (NULL, '{$this->curr_sid}','{$coupon['cl_es_id']}', '{$mid}', '{$coupon['cl_id']}','{$now}', '{$exipre}') ";
                    }
                    $receive_model = new App_Model_Coupon_MysqlReceiveStorage();
                    $res = $receive_model->batchSave($insert);
                    if($res){
                        $coupon_model->incrementReceiveCount($coupon['cl_id'], $num);
                        $result = array(
                            'name'  => $coupon['cl_name'],
                            'money' => $coupon['cl_face_val'],
                            'limit' => $coupon['cl_use_limit'],
                            'start' => $coupon['cl_start_time'],
                            'end'   => $coupon['cl_end_time'],
                            'num'   => $num,
                        );
                    }
                }
            }
        }
        return $result;
    }
    private function _get_coupon_cfg($total, $rid=0) {
        $model_cct = new App_Model_Cash_MysqlCouponTypeStorage($this->curr_sid);
        $model_crc = new App_Model_Cash_MysqlRechargeCouponStorage($this->curr_sid);

        $where = array();
        $where[] = array('name'=>'cct_s_id', 'oper'=>'=', 'value'=>$this->curr_sid);
        $where[] = array('name'=>'cct_type', 'oper'=>'in', 'value'=>array(2,3));
        $sort = array('cct_sort'=>'desc');
        $list = $model_cct->getList($where, 0, 0, $sort);
        $type = $list[0]['cct_type'];
        $result = array();


        $where_rid = array();
        $where_rid[] = array('name'=>'crc_s_id', 'oper'=>'=', 'value'=>$this->curr_sid);
        $where_rid[] = array('name'=>'crc_type', 'oper'=>'=', 'value'=>2);
        $where_rid[] = array('name'=>'crc_r_id', 'oper'=>'=', 'value'=>$rid);
        $where_rid[] = array('name'=>'crc_status', 'oper'=>'=', 'value'=>1);
        $list2 = $model_crc->getList($where_rid, 0, 0);

        $where1 = array();
        $where1[] = array('name'=>'crc_s_id', 'oper'=>'=', 'value'=>$this->curr_sid);
        $where1[] = array('name'=>'crc_type', 'oper'=>'=', 'value'=>3);
        $where1[] = array('name'=>'crc_status', 'oper'=>'=', 'value'=>1);
        $where_max[] = array('name'=>'crc_limit_money', 'oper'=>'<=', 'value'=>$total);
        $money = $model_crc->getMaxMoney(array_merge($where1, $where_max));
        $where2[] = array('name'=>'crc_limit_money', 'oper'=>'=', 'value'=>$money);
        $list3 = $model_crc->getList(array_merge($where1, $where2), 0, 0);

        if($type ==3) {
            if(!empty($list3)) {
                $result = $list3;
            } else {
                $result = $list2;
            }
        } else if($type ==2){
            if(!empty($list2)) {
                $result = $list2;
            } else {
                $result = $list3;
            }
        }
        return $result;
    }


    
    private function _get_coupon($goods_fee,$mid,$t_id) {
        $order_model    = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
        $list = $order_model->fetchOrderListByTid($t_id);
        $gids = array();
        if($list) {
            foreach($list as $value) {
                $gids[] = $value['to_g_id'];
            }
        }

        plum_msg_dump($gids, 0);
        $full_helper  = new App_Helper_FullAct($this->curr_sid);

        $youhuiq_arr  = $full_helper->getCouponListByGids($gids, $mid, $goods_fee,false,true);


        $max = array();
        if($youhuiq_arr) {
            foreach($youhuiq_arr as $key => $value) {
                if($goods_fee >= $value['cl_face_val']) {
                    $max[$key] = $value['cl_face_val'];
                }
            }
        }

        $youhuiq = array();
        if($max) {
            $res = array_search(max($max), $max);
            $youhuiq = $youhuiq_arr[$res];
        }
        plum_msg_dump($youhuiq, 1);

        return $youhuiq;
    }









    
    public function sendLeaderCouponAction(){
        $leader = $this->request->getIntParam('leader');
        $coupon = $this->request->getIntParam('coupon');
        $num = $this->request->getIntParam('num');
        $res = false;
        $hold_model = new App_Model_Coupon_MysqlLeaderCouponHoldStorage($this->curr_sid);
        $row = $hold_model->getRowByCouponLeader($coupon,$leader);
        if($row){
            $res = $hold_model->incrementField('lch_hold_num',$num,$coupon,$leader);
        }else{
            $insert = [
                'lch_s_id' => $this->curr_sid,
                'lch_coupon' => $coupon,
                'lch_leader' => $leader,
                'lch_hold_num' => $num,
                'lch_send_num' => 0,
                'lch_create_time' => time()
            ];
            $res = $hold_model->insertValue($insert);
        }

        if($res){
            $coupon_model = new App_Model_Coupon_MysqlCouponStorage();
            $coupon_model->incrementCount($coupon,$num);
        }
        $this->showAjaxResult($res,'发放');

    }

}