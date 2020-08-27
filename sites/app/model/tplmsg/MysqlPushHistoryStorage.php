<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 16/7/29
 * Time: 下午2:59
 */
class App_Model_Tplmsg_MysqlPushHistoryStorage extends Libs_Mvc_Model_BaseModel{

    public function __construct(){
        $this->_table 	= 'applet_push_history';
        $this->_pk 		= 'aph_id';
        $this->_shopId 	= 'aph_s_id';
        parent::__construct();
    }

    /*
     * 资讯推送统计信息
     */
    public function getSum($where,$type = 'information'){
        $sql  = 'SELECT count(aph_id) as pushTotal,sum(aph_total) as pushMemberSum ';
        $sql .= ' FROM '.DB::table($this->_table).' aph ';
        if($type == 'information'){
            $sql .= ' LEFT JOIN pre_applet_information ai on aph.aph_information_id = ai.ai_id ';
        }elseif ($type == 'goods'){
            $sql .= ' LEFT JOIN pre_goods g on aph.aph_g_id = g.g_id ';
        }
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }



}