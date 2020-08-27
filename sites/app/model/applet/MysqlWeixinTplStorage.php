<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/19
 * Time: 下午12:13
 */

class App_Model_Applet_MysqlWeixinTplStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_weixin_tpl';
        $this->_pk      = 'awt_id';
        $this->_shopId  = 'awt_s_id';
        $this->_df      = 'awt_deleted';

        $this->sid      = $sid;
    }

    public function getListBySid($index,$count){
        $where = array();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sort    = array('awt_create_time' => 'DESC');
        return $this->getList($where,$index,$count,$sort);
    }

    public function getCountBySid(){
        $where = array();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        return $this->getCount($where);
    }

    /**
     * @param $tplId
     * @return bool
     * 根据模版ID删除模版信息
     */
    public function deleteByTplId($tplId){
        $where = array();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'awt_tplid', 'oper' => '=', 'value' => $tplId);
        $set     = array(
            $this->_df => 1
        );
        return $this->updateValue($set,$where);
    }

    /**
     * @param $tplId
     * @return array|bool
     * 根据模版ID获取模版信息
     */
    public function getRowTplId($tplId){
        $where = array();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'awt_tplid', 'oper' => '=', 'value' => $tplId);
        return $this->getRow($where);
    }

    /**
     * @param $tplId
     * @return bool
     * 获取已经存在的模版，包含已经删除的
     */
    public function checkTplId($tplId){
        $where = array();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'awt_tplid', 'oper' => '=', 'value' => $tplId);
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql = $this->formatCountSql($where);
        $ret = DB::result_first($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function insertBatch($insert){
        $sql  = 'INSERT INTO '.DB::table($this->_table);
        $sql .= ' (`awt_id`, `awt_s_id`, `awt_tplid`, `awt_title`, `awt_content`, `awt_example`, `awt_deleted`, `awt_create_time`) ';
        $sql .= ' VALUES ';
        $sql .= implode(',',$insert);

        $ret = DB::query($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;

    }


}