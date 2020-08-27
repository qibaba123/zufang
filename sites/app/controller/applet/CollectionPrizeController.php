<?php


class App_Controller_Applet_CollectionPrizeController extends App_Controller_Applet_InitController
{

    public function __construct()
    {
        parent::__construct();

    }

    public function settingAction(){
        $prize_model = new App_Model_Collection_MysqlCollectionPrizeStorage($this->sid);
        $row = $prize_model->findShopCfg();

        $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
        $coupon = $coupon_model->getRowById($row['acp_coupon_id']);

        $audit_model = new App_Model_Collection_MysqlCollectionPrizeAuditStorage($this->sid);

        $where = array();
        $where[] = array('name' => 'acpa_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'acpa_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $audit = $audit_model->getRow($where);

        $info['data'] = array(
            'appName'   => $this->applet_cfg['ac_name'],
            'appLogo'   => $this->dealImagePath($this->applet_cfg['ac_avatar']),
            'prizeName' => $coupon['cl_name'],
            'status'    => $audit?$audit['acpa_status']:0,
            'dealNote'  => $audit?$audit['acpa_deal_note']:'',
        );

        $this->outputSuccess($info);
    }

    public function submitApplyAction(){
        $image = $this->request->getStrParam('image');

        $prize_model = new App_Model_Collection_MysqlCollectionPrizeStorage($this->sid);
        $row = $prize_model->findShopCfg();

        $audit_model = new App_Model_Collection_MysqlCollectionPrizeAuditStorage($this->sid);
        $where = array();
        $where[] = array('name' => 'acpa_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'acpa_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $audit = $audit_model->getRow($where);
        $data = array(
            'acpa_s_id'           => $this->sid,
            'acpa_m_id'           => $this->member['m_id'],
            'acpa_coupon_id'      => $row['acp_coupon_id'],
            'acpa_collection_img' => $image,
            'acpa_status'         => 1,
        );

        if($audit){
            $ret = $audit_model->updateById($data, $audit['acpa_id']);
        }else{
            $data['acpa_create_time'] = time();
            $ret = $audit_model->insertValue($data);
        }

        if($ret){
            $info['data'] = array(
                'result' => true,
                'msg'    => '提交成功'
            );
            $this->outputSuccess($info);
        }else{
            $this->outputError('提交失败,请稍后重试');
        }
    }

}