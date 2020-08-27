<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Applet_MysqlAppletDomainStorage extends Libs_Mvc_Model_BaseModel
{


    public function __construct()
    {
        parent::__construct();
        $this->_table = 'applet_shop_domain';
        $this->_pk = 'asd_id';

    }

    /*
     * 获取使用最少的域名
     */
    public function getListFirst() {
        $where = array();
        $where[] = array('name'=>'asd_status','oper'=>'=','value'=>0);
        $sort = array('asd_usd_num'=>'ASC');
        $list = $this->getList($where,0,1,$sort);
        return $list[0];
    }

    /**
     * 增加域名使用数量
     */
    public function addDomainUsedNum($asdId){
        $sql  = 'UPDATE '.DB::table($this->_table);
        $sql .= ' SET  asd_usd_num = asd_usd_num + 1 ';
        $sql .= '  WHERE '.$this->_pk .' = '.intval($asdId);
        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}