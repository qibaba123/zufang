<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/6/12
 * Time: 下午7:09
 */
class App_Model_Plugin_MysqlEleRecordStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;
    private $shopTable;


    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'ele_record';
        $this->_pk = 'er_id';
        $this->_shopId = 'er_s_id';
        $this->shopTable= DB::table('shop');

        $this->sid = $sid;
    }

    public function findRowByTid($tid, $data=array()){
        $where[]    = array('name' => 'er_tid', 'oper' => '=', 'value' => $tid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        if($data){
            return $this->updateValue($data, $where);
        }else{
            return $this->getRow($where);
        }
    }

    public function findRowByEleTid($etid){
        $where[]    = array('name' => 'er_ele_tid', 'oper' => '=', 'value' => $etid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        return $this->getRow($where);
    }

    public function getShopList($where,$index=0,$count=20,$sort){
        $sql  = 'SELECT er.* , s_name ';
        $sql .= ' FROM `'.DB::table($this->_table).'` er ';
        $sql .= ' LEFT JOIN '.$this->shopTable.' s on s_id = er_s_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret  = DB::fetch_all($sql, array());
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getShopCount($where){
        $sql  = 'SELECT count(*) ';
        $sql .= ' FROM `'.DB::table($this->_table).'` er ';
        $sql .= ' LEFT JOIN '.$this->shopTable.' s on s_id = er_s_id ';
        $sql .= $this->formatWhereSql($where);

        $ret  = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}