<?php
/*
 * 社区团购
 */
class App_Model_Sequence_MysqlSequencePickStationManagerStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_sequence_pick_station_manager';
        $this->_pk = 'asps_id';
        $this->_shopId = 'asps_s_id';
        $this->sid = $sid;
    }

    /*
     * 根据用户id查找管理员
     */
    public function findRowByMid($mid){
        $where = [];
        $where[] = ['name' => 'aspsm_s_id','oper' => '=','value' =>$this->sid];
        $where[] = ['name' => 'aspsm_m_id','oper' => '=','value' =>$mid];
        return $this->getRow($where);
    }



}