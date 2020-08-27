<?php
/*
 * 社区团购 自提点佣金记录
 */
class App_Model_Sequence_MysqlSequencePickStationDeductStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
//    private $member_table;
//    private $member_extra;
//    private $manager_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_sequence_pick_station_deduct';
        $this->_pk = 'aspsd_id';
        $this->_shopId = 'aspsd_s_id';
        $this->sid = $sid;
        $this->_df = 'aspsd_deleted';
//        $this->member_table = DB::table('member');
//        $this->member_extra = DB::table('applet_member_extra');
//        $this->manager_table = DB::table('applet_sequence_pick_station_manager');

    }


}