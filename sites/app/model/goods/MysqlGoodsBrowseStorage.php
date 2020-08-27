<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/11/11
 * Time: 上午11:19
 */
class App_Model_Goods_MysqlGoodsBrowseStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    private $curr_table;
    private $goods_table;
    private $member_table;

    public function __construct($sid = null){
        $this->_table 	= 'goods_browse_records';
        $this->_pk 		= 'gb_id';
        $this->_shopId 	= 'gb_s_id';
        parent::__construct();

        $this->sid      = $sid;
        $this->curr_table   = DB::table($this->_table);
        $this->member_table = DB::table('member');
        $this->goods_table   = DB::table('goods');
    }

    public function getGoodsList($where, $index, $count, $sort){
        $sql = 'select * ';
        $sql .= ' from '.$this->curr_table.' c ';
        $sql .= ' left join '.$this->goods_table.' g on g.g_id = c.gb_g_id ';
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
    /*
     * 判断会员的浏览记录中是否有该商品
     */
    public function getRowByIdSidMid($id,$sid,$mid)
    {
        $where   = array();
        $where[] = array('name'=>'gb_g_id','oper'=>'=','value'=>$id);
        $where[] = array('name'=>'gb_s_id','oper'=>'=','value'=>$sid);
        $where[] = array('name'=>'gb_m_id','oper'=>'=','value'=>$mid);
        return $this->getRow($where);
    }
}