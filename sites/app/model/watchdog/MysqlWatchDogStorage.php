<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2019/5/29
 * Time: 12:30 PM
 */
class App_Model_Watchdog_MysqlWatchDogStorage extends Libs_Mvc_Model_BaseModel {

    public function __construct(){
        $this->_table 	= 'watch_dog';
        $this->_pk 		= 'wd_id';
        parent::__construct();
    }

    /*
     * 方法一
     */
    public function getRequestRankOne($where,$index,$count,$sort){
        $sql = "SELECT count(*) as total,wd_suid ";
        $sql .= " FROM ".DB::table($this->_table)." ";
        $sql .= $this->formatWhereSql($where);
        $sql .= " group by wd_suid ";
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
//        echo $sql;die;

        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得列表 关联店铺
     */
    public function getListShop($where,$index,$count,$sort){
        $sql  = 'SELECT wd.*,s.s_name,s.s_id,ac.ac_type,aa.aa_name ';
        $sql .= ' FROM '.DB::table($this->_table).' wd ';
//        $sql .= ' LEFT JOIN '.$this->manager_table.' m on m.m_c_id=s.s_c_id And m.m_fid = 0 ';
        $sql .= ' LEFT JOIN pre_shop s on wd.wd_suid=s.s_unique_id ';
        $sql .= ' LEFT JOIN pre_applet_cfg ac on ac.ac_s_id=s.s_id ';
        $sql .= ' LEFT JOIN pre_agent_admin aa on wd.wd_for_id=aa_id AND wd_source = "agent" ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $list = DB::fetch_all($sql);
        if ($list === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $list;
    }

    /*
     * 获得列表 关联店铺
     */
    public function getCountShop($where){
        $sql  = 'SELECT count(*) as total ';
        $sql .= ' FROM '.DB::table($this->_table).' wd ';
        // $sql .= ' LEFT JOIN '.$this->manager_table.' m on m.m_c_id=s.s_c_id And m.m_fid = 0 ';
        // $sql .= ' LEFT JOIN '.$this->applet_table.' ac on ac.ac_s_id=s.s_id ';
        // 
        // 
        // 查询的是个count 数据连表意义不大-所以省去该连接
        // zhangzc
        // 2019-06-12
        /* $sql .= ' LEFT JOIN pre_shop s on wd.wd_suid=s.s_unique_id ';*/
        
        $sql .= $this->formatWhereSql($where);
        $row = DB::result_first($sql);
        if ($row === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $row;
    }

    /*
     * 清空记录
     */
    public function truncateRecord(){
        $this->truncate();
    }

}
