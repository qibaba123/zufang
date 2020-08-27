<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Meeting_MysqlMeetingLotteryStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_meeting_lottery';
        $this->_pk = 'aml_id';
        $this->_shopId = 'aml_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    /**
     * 根据店铺id获取店铺的所有资讯分类
     */
    public function getListBySid($lid, $type=0){
        $where = array();
        $where[] = array('name'=>'aml_l_id','oper'=>'=','value'=>$lid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        if($type){
            $where[] = array('name'=>'aml_type','oper'=>'=','value'=>$type);
        }
        return $this->getList($where,0,0,array('aml_weight' => 'ASC','aml_update_time'=>'DESC','aml_create_time'=>'DESC'));
    }

    public function getGoodsSum($lid){
        $where = array();
        $where[] = array('name'=>'aml_l_id','oper'=>'=','value'=>$lid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);

        $sql = 'SELECT sum(aml_num) ';
        $sql .= ' FROM `'.DB::table($this->_table).'` ';

        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}
