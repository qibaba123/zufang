<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/5/9
 * Time: 上午10:39
 */
class App_Model_Applet_MysqlAppletSubjectStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_subject';
        $this->_pk = 'as_id';
        $this->_shopId = 'as_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    /*
      * 通过店铺id获取店铺题目
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

    /**
     * @param array $value
     * 批量导入题目
     */
    public function insertBatch(array $value){
        $ret = false;
        if(!empty($value)){
            $sql = 'INSERT INTO '.DB::table($this->_table);
            $sql .= '  (`as_id`, `as_s_id`, `as_question`, `as_answer`, `as_item1`, `as_item2`,`as_item3`,`as_item4`,`as_degree`,`as_deleted`,`as_create_time`)  ';
            $sql .= ' VALUES ';
            $sql .= implode(',',$value);
            $ret = DB::query($sql);
            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
        }
        return $ret;
    }

    /**
     * 获取随机题目
     */
    public function fetchRandomSubject($where,$count=8){
        $sql = 'Select * ';
        $sql .= " from `".DB::table($this->_table)."` ";
        $sql .= $this->formatWhereSql($where);
        $sql .= ' order by Rand() Limit '.$count;
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}