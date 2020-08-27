<?php

class App_Controller_Wxapp_CollectionprizeController extends App_Controller_Wxapp_InitController{

    const PROMOTION_TOOL_KEY = 'scyl';

    public function __construct(){
        parent::__construct();
    }

    
    public function secondLink($type='index'){
        $link = array(
            array(
                'label' => '页面设置',
                'link'  => '/wxapp/Collectionprize/index',
                'active'=> 'index'
            ),
            array(
                'label' => '优惠券设置',
                'link'  => '/wxapp/Collectionprize/coupon',
                'active'=> 'coupon'
            ),
            array(
                'label' => '审核列表',
                'link'  => '/wxapp/Collectionprize/check',
                'active'=> 'check'
            ),
        );
        $this->output['link'] = $link;
        $this->output['linkType']   = $type;
        $this->output['snTitle']    = '收藏有礼';
    }

    public function indexAction(){
        $this->secondLink('index');
        $prize_model = new App_Model_Collection_MysqlCollectionPrizeStorage($this->curr_sid);
        $row = $prize_model->findShopCfg();

        $where = array();
        $where[] = array('name' => 'cl_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[] = array('name' => 'cl_coupon_type','oper' => '=','value' =>2);
        $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
        $list = $coupon_model->getList($where,0,0, array(), array('cl_id', 'cl_name'));

        $couponJson = array();
        foreach ($list as $val){
            $couponJson[$val['cl_id']] = $val['cl_name'];
        }

        $this->output['row'] = $row;
        $this->output['coupon'] = json_encode($list);
        $this->output['couponJson'] = json_encode($couponJson);
        $this->output['applet'] = $this->wxapp_cfg;
        $this->renderCropTool('/wxapp/index/uploadImg');

        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '收藏有礼', 'link' => '/wxapp/collectionprize/index'),
            array('title' => '页面设置', 'link' => '#'),
        ));

        $this->displaySmarty("wxapp/collection/prize-setting.tpl");
    }

    public function saveSettingAction(){
        $demoImg = $this->request->getStrParam('demoImg');
        $couponId = $this->request->getIntParam('couponId');

        $prize_model = new App_Model_Collection_MysqlCollectionPrizeStorage($this->curr_sid);
        $row = $prize_model->findShopCfg();

        $data = array(
            'acp_demo_img'    => $demoImg,
            'acp_coupon_id'   => $couponId,
            'acp_update_time' => time()
        );

        if($row){
            $prize_model = new App_Model_Collection_MysqlCollectionPrizeStorage($this->curr_sid);
            $ret = $prize_model->findShopCfg($data);
        }else{
            $data['acp_s_id'] = $this->curr_sid;
            $data['acp_create_time'] = time();
            $ret = $prize_model->insertValue($data);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("保存收藏有礼配置成功");
        }

        $this->showAjaxResult($ret);
    }

    public function couponAction(){
        $this->secondLink('coupon');

        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '收藏有礼', 'link' => '/wxapp/collectionprize/index'),
            array('title' => '优惠券设置', 'link' => '#'),
        ));

        $this->_show_coupon_list_data();
        $this->displaySmarty("wxapp/collection/coupon-list.tpl");
    }
    private function _show_coupon_list_data(){
        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $where = array();
        $where[] = array('name' => 'cl_s_id','oper' => '=','value' =>$this->curr_sid);
        $output['name']     = $this->request->getStrParam('name');
        if($output['name']){
            $where[] = array('name' => 'cl_name','oper' => 'like','value' =>"%{$output['name']}%");
        }
        $where[] = array('name' => 'cl_coupon_type','oper' => '=','value' =>2);
        $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
        $total          = $coupon_model->getCount($where);
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $list   = array();
        $field = array('cl_id', 'cl_name', 'cl_face_val', 'cl_use_limit', 'cl_end_time', 'cl_had_receive', 'cl_had_used', 'cl_use_end_time', 'cl_use_days', 'cl_use_time_type');
        if($index <= $total){
            $sort = array('cl_update_time' => 'DESC');
            $list = $coupon_model->getList($where,$index,$this->count,$sort, $field);
        }
        $output['paginator'] = $pageCfg->render();
        $output['list']      = $list;
        $output['count']     = $total;

        $this->showOutput($output);
    }

    
    public function  couponAddAction(){
        $this->secondLink('coupon');
        $id  = $this->request->getIntParam('id');
        $row = array();
        if($id){
            $coupon_model = new App_Model_Coupon_MysqlCouponStorage();
            $row = $coupon_model->getRowByIdSid($id,$this->curr_sid);
            if(!empty($row)){
                $row['cl_use_desc'] = plum_textarea_html_to_line($row['cl_use_desc']);
            }
        }
        $this->output['row']    = $row;
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '收藏有礼', 'link' => '/wxapp/collectionprize/index'),
            array('title' => '优惠券设置', 'link' => '/wxapp/collectionprize/coupon'),
            array('title' => '优惠券添加', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/collection/coupon-add.tpl");
    }

    
    public function saveCouponAction(){
        $id     = $this->request->getIntParam('id');

        $field  = array('face_val','use_limit','use_type','count','receive_limit');
        $data   = $this->getIntByField($field,'cl_');

        $data['cl_name']         = $this->request->getStrParam('name');

        $end    = $this->request->getStrParam('end');
        $data['cl_start_time']   = strtotime($start);
        $data['cl_end_time']     = strtotime($end);
        $useEnd    = $this->request->getStrParam('useEnd');
        $data['cl_use_end_time']     = $useEnd?strtotime($useEnd):strtotime($end);
        $data['cl_use_time_type']    = $this->request->getIntParam('useTimeType', 1);
        $data['cl_use_days']         = $this->request->getIntParam('useDays');
        $couponType              = $this->request->getIntParam('couponType');
        if($couponType){
            $data['cl_coupon_type'] = $couponType;
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

        if($ret){
            App_Helper_OperateLog::saveOperateLog("保存收藏有礼优惠券成功");
        }

        $this->showAjaxResult($ret);
    }


    public function checkAction(){
        $this->secondLink('check');
        $status = $this->request->getIntParam('status', 1);
        $page = $this->request->getIntParam('page');
        $nickname = $this->request->getStrParam('nickname');

        $index = $page * $this->count;
        $list = array();

        $audit_model = new App_Model_Collection_MysqlCollectionPrizeAuditStorage($this->curr_sid);

        $where = array();
        $where[] = array('name' => 'acpa_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acpa_status', 'oper' => '=', 'value' => $status);
        if($nickname){
            $where[] = array('name' => 'm_nickname', 'oper' => '=', 'value' => $nickname);
        }

        $total = $audit_model->getMemberCount($where);
        $page_plugin = new Libs_Pagination_Paginator($total,$this->count,'jquery',1);
        $output['paginator'] = $page_plugin->render();
        $sort = array('acpa_create_time' => 'desc');

        if($total > $index){
            $list = $audit_model->getMemberList($where, $index, $page, $sort);
        }

        $this->output['list']    = $list;
        $this->output['status']  = $status;
        $this->output['nickname']  = $nickname;
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '收藏有礼', 'link' => '/wxapp/collectionprize/index'),
            array('title' => '审核管理', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/collection/audit-list.tpl");
    }

    public function handleApplyAction(){
        $id     = $this->request->getIntParam('id');
        $remark = $this->request->getStrParam('remark');
        $status = $this->request->getIntParam('status');

        $audit_model = new App_Model_Collection_MysqlCollectionPrizeAuditStorage($this->curr_sid);
        $apply = $audit_model->getRowById($id);

        $set = array(
            'acpa_status'     => $status,
            'acpa_deal_note'  => $remark,
            'acpa_audit_time' => time()
        );

        if($status == 2){
            $receive_model  = new App_Model_Coupon_MysqlReceiveStorage();
            $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
            $coupon     = $coupon_model->getCoupon($apply['acpa_coupon_id'], $this->curr_sid);
            $slogan = plum_parse_config('coupon_slogan', 'app');
            $rand   = mt_rand(0, count($slogan)-1);
            $indata = array(
                'cr_s_id'         => $this->curr_sid,
                'cr_es_id'        => 0,
                'cr_m_id'         => $apply['acpa_m_id'],
                'cr_c_id'         => $apply['acpa_coupon_id'],
                'cr_receive_time' => time(),
                'cr_expire_time'  => $coupon['cl_use_time_type'] == 1?$coupon['cl_use_end_time']:strtotime("+".$coupon['cl_use_days']." days"),
                'cr_slogan'       => $slogan[$rand],
            );
            $crid       = $receive_model->insertValue($indata);
            $coupon_model->incrementReceiveCount($apply['acpa_coupon_id'], 1);
        }

        if($status != 2 || $crid){
            $ret = $audit_model->updateById($set, $id);
        }

        if($ret){
            $str = '';
            if($status == 2){
                $str = '通过';
            }elseif ($status == 3){
                $str = '拒绝';
            }
            if($str){
                App_Helper_OperateLog::saveOperateLog("收藏有礼审核成功，审核结果{$str}");
            }
        }

        $this->showAjaxResult($ret);
    }

}