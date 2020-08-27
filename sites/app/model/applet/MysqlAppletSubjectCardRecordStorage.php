<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/5/9
 * Time: 上午10:39
 */
class App_Model_Applet_MysqlAppletSubjectCardRecordStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_subject_card_record';
        $this->_pk = 'acr_id';
        $this->_shopId = 'acr_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    /*
      * 通过店铺id获取店铺配置
      */
    public function findUpdateBySid($data = null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    public function getUseCardCountByMid($mid,$type=1) {
        $dataTime = strtotime(date('Y-m-d',time()));
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'acr_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'acr_type', 'oper' => '=', 'value' => $type);
        $where[]    = array('name' => 'acr_create_time', 'oper' => '>', 'value' => $dataTime);
        return $this->getCount($where);
    }


}