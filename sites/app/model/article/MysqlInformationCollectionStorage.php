<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/8/17
 * Time: 上午10:39
 */
class App_Model_Article_MysqlInformationCollectionStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $member_table;
    private $information_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_information_collection';
        $this->_pk = 'aic_id';
        $this->_shopId = 'aic_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
        $this->member_table = DB::table('member');
        $this->information_table = DB::table('applet_information');
    }

    /**
     * 根据会员ID和同城店铺ID获取收藏信息
     */
    public function getCollectionByMidPid($mid,$sid){
        $where = array();
        $where[] = array('name'=>'aic_m_id','oper'=>'=','value'=>$mid);
        $where[] = array('name'=>'aic_ai_id','oper'=>'=','value'=>$sid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        return $this->getRow($where);
    }

    /**
     * 获取我收藏的同城店铺信息
     */

    public function getCollectionListMember($where,$index,$count,$sort){
        $sql = "select * ";
        $sql .= " from `".DB::table($this->_table)."` aic ";
        $sql .= " left join ".$this->information_table." infor on infor.ai_id = aic.aic_ai_id ";
        $sql .= " left join ".$this->member_table." m on m.m_id = aic.aic_m_id ";

        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}
