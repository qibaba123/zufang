<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Smart_MysqlStoreDynamicStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_store_dynamic';
        $this->_pk = 'asd_id';
        $this->_shopId = 'asd_s_id';
        $this->_df     = 'asd_deleted';
        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }
    /**
     * 增加点赞数
     */
    public function addStoreFabulousNum($where){
        $sql  = 'UPDATE '.DB::table($this->_table);
        $sql .= ' SET  asd_fabulous = asd_fabulous + 1 ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /**
     * 减少点赞数
     */
    public function reduceStoreFabulousNum($where){
        $sql  = 'UPDATE '.DB::table($this->_table);
        $sql .= ' SET  asd_fabulous = asd_fabulous - 1 ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /**
     * 增加评论数
     */
    public function addStoreCommentNum($where){
        $sql  = 'UPDATE '.DB::table($this->_table);
        $sql .= ' SET  asd_comment = asd_comment + 1 ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /**
     * 减少评论数
     */
    public function reduceStoreCommentNum($where){
        $sql  = 'UPDATE '.DB::table($this->_table);
        $sql .= ' SET  asd_comment = asd_comment - 1 ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}