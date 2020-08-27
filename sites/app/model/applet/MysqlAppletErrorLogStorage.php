<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/27
 * Time: 上午10:39
 */
class App_Model_Applet_MysqlAppletErrorLogStorage extends Libs_Mvc_Model_BaseModel {

    private $shop_table;
    private $applet_table;
    public function __construct() {
        parent::__construct();
        $this->_table   = 'applet_error_log';
        $this->_pk      = 'ael_id';

        $this->shop_table = DB::table('shop');
        $this->applet_table = DB::table('applet_cfg');
    }

    public function getAppletList($where,$index,$count,$sort){

        $sql  = 'SELECT ael.*,ac.ac_name ';
        $sql .= ' FROM `'.DB::table($this->_table).'` ael ';
        $sql .= ' LEFT JOIN '.$this->applet_table.' ac on ael.ael_appid=ac.ac_appid ';
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

    public function getAppletCount($where){

        $sql  = 'SELECT count(*) as total ';
        $sql .= ' FROM `'.DB::table($this->_table).'` ael ';
        $sql .= ' LEFT JOIN '.$this->applet_table.' ac on ael.ael_appid=ac.ac_appid ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


}